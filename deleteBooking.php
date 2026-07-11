<?php
    require "config.php";
    header('Content-Type: application/json');//لاخبار المتصفح انه يلي رح ابعته هو كود json وليس صفحة html 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    // استقبال الـ ID من الطلب
    $data = json_decode(file_get_contents('php://input'), true);//file_get_contents هاد fun في ال php بتقرأمحتويات اي ملف 
    $booking_id = $data['booking_id'];

    // استعلام الحذف - نتحقق أيضاً من Customer_ID للأمان
    $sql = "DELETE FROM Booking WHERE Booking_ID = ? AND Customer_ID = (SELECT Customer_ID FROM customer WHERE User_ID = ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $db->error]);
    }
    exit;
}
?>