<?php
require "config.php";
require "translate_helper.php";

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'طريقة الطلب غير صحيحة']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$booking_id = intval($input['booking_id'] ?? 0);
$score      = intval($input['rating']     ?? 0);
$comment    = trim($input['comment']      ?? '');

// التحقق من البيانات
if (!$booking_id || $score < 1 || $score > 5) {
    echo json_encode(['success' => false, 'message' => 'بيانات غير صحيحة']);
    exit;
}

// جلب Customer_ID من الـ session
$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT Customer_ID FROM customer WHERE User_ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'العميل غير موجود']);
    exit;
}

$customer_id = $result['Customer_ID'];

// التحقق من أن الحجز يخص هذا العميل وأنه مكتمل
$stmt = $db->prepare("
    SELECT b.Booking_ID, b.Service_ID 
    FROM Booking b
    WHERE b.Booking_ID = ? 
      AND b.Customer_ID = ? 
      AND b.status = 'completed'
");
$stmt->bind_param("ii", $booking_id, $customer_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$booking) {
    echo json_encode(['success' => false, 'message' => 'الحجز غير موجود أو غير مكتمل']);
    exit;
}

$service_id = $booking['Service_ID'];

// التحقق من عدم وجود تقييم مسبق لنفس الحجز
$stmt = $db->prepare("
    SELECT Rating_ID FROM Rating 
    WHERE Booking_ID=?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$existing = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($existing) {
    echo json_encode(['success' => false, 'message' => 'لقد قمت بتقييم هذه الخدمة مسبقاً']);
    exit;
}

$comment_ar = '';
$comment_en = '';

if ($comment !== '') {
    $inputLang  = detectLang($comment);
    $otherLang  = ($inputLang === 'ar') ? 'en' : 'ar';
    $translated = translateText($comment, $inputLang, $otherLang);

    $comment_ar = ($inputLang === 'ar') ? $comment : $translated;
    $comment_en = ($inputLang === 'en') ? $comment : $translated;
}

// إدراج التقييم
$today = date('Y-m-d');

$stmt = $db->prepare("
    INSERT INTO Rating (Booking_ID, Customer_ID, Service_ID, Date, Score, Comment, Comment_ar, Comment_en)
    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)
");
// الحقول بالترتيب: i -> Booking, i -> Customer, i -> Service, s -> Date, i -> Score, s -> Comment, s -> Comment_ar, s -> Comment_en
$stmt->bind_param("iiisisss", $booking_id, $customer_id, $service_id, $today, $score, $comment, $comment_ar, $comment_en);

if ($stmt->execute()) {
    $stmt->close();
    echo json_encode(['success' => true, 'message' => 'تم إرسال تقييمك بنجاح']);
} else {
    $stmt->close();
    echo json_encode(['success' => false, 'message' => 'فشل حفظ التقييم، حاول مجدداً']);
}
?>