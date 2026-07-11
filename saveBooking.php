<?php
require "config.php";
header('Content-Type: application/json'); // نخبر المتصفح إن الرد سيكون JSON

// ============================================================
// دالة: تحويل وقت HH:MM أو HH:MM:SS إلى دقائق منذ منتصف الليل
// ============================================================
function booking_time_to_minutes(string $timeStr): ?int
{
    $timeStr = trim($timeStr);
    if ($timeStr === '') return null; // وقت فارغ → null

    // صيغة HH:MM أو HH:MM:SS
    if (preg_match('/^(\d{1,2}):(\d{2})(?::(\d{2}))?/', $timeStr, $m)) {
        $h   = (int)$m[1];
        $min = (int)$m[2];
        if ($h >= 0 && $h <= 23 && $min >= 0 && $min <= 59)
            return $h * 60 + $min; // نحوّل إلى دقائق كلية
    }

    // صيغة رقمية مثل 0900 أو 930
    if (preg_match('/^(\d{3,4})$/', $timeStr, $m)) {
        $digits = $m[1];
        $len    = strlen($digits);
        $h   = (int)substr($digits, 0, $len === 4 ? 2 : 1);
        $min = (int)substr($digits, $len === 4 ? 2 : 1, 2);
        if ($h >= 0 && $h <= 23 && $min >= 0 && $min <= 59)
            return $h * 60 + $min;
    }

    // محاولة أخيرة عبر strtotime
    $ts = strtotime($timeStr);
    if ($ts === false) return null; // فشل التحليل

    return (int)date('G', $ts) * 60 + (int)date('i', $ts);
}

// ============================================================
// دالة: استخراج وقت البداية والنهاية من حقل working_hours
// ============================================================
function booking_parse_working_hours(string $hours): ?array
{
    $hours = trim($hours);
    $hours = str_replace(['–', '—', '−'], '-', $hours); // توحيد رمز الشرطة

    // صيغة HH:MM-HH:MM
    if (preg_match('/^\s*(\d{1,2}:\d{2}(?::\d{2})?)\s*-\s*(\d{1,2}:\d{2}(?::\d{2})?)\s*/', $hours, $m))
        return [trim($m[1]), trim($m[2])];

    // صيغة بسيطة: رقم-رقم مثل 8-17
    $parts = explode('-', $hours);
    if (count($parts) === 2) {
        $a = trim($parts[0]);
        $b = trim($parts[1]);
        if ($a !== '' && $b !== '') return [$a, $b];
    }

    return null; // تعذّر التحليل
}

// ============================================================
// التحقق من طريقة الطلب ووجود submit
// ============================================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    echo json_encode(['success' => false, 'message' => 'طلب غير صالح']); // طلب خارج السياق
    exit;
}

// ============================================================
// التحقق من تسجيل دخول المستخدم
// ============================================================
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'redirect' => 'loginPage.php', 'message' => 'يجب تسجيل الدخول أولاً']);
    exit;
}
$customer_user_id = $_SESSION['user_id']; // معرّف المستخدم من الجلسة

// ============================================================
// استقبال بيانات POST والتحقق من وجود الحقول الأساسية
// ============================================================
$provider_id  = (int)($_POST['provider_id'] ?? 0);  // معرّف مزود الخدمة
$service_id   = (int)($_POST['service_id']  ?? 0);  // معرّف الخدمة
$booking_date =       $_POST['booking_date'] ?? '';  // تاريخ الحجز
$booking_time =       $_POST['time']         ?? '';  // وقت الحجز
$booking_note =       $_POST['notes']        ?? '';  // ملاحظات العميل
$location_lat =       $_POST['location_lat'] ?? '';  // خط العرض (GPS)
$location_lng =       $_POST['location_lng'] ?? '';  // خط الطول (GPS)
$location_text =      $_POST['location_text'] ?? ''; // العنوان النصي للموقع

if (!$provider_id || !$service_id) {
    echo json_encode(['success' => false, 'redirect' => 'service.php', 'message' => 'اختر مزود الخدمة أولاً']);
    exit;
}

// ============================================================
// جلب Customer_ID الفعلي من جدول customer بناءً على User_ID
// ============================================================
$stmt = $db->prepare("SELECT Customer_ID FROM customer WHERE User_ID = ?");
$stmt->bind_param("i", $customer_user_id);
$stmt->execute();
$customer_data = $stmt->get_result()->fetch_assoc();

if (!$customer_data) {
    // لا يوجد سجل عميل مرتبط بهذا المستخدم
    echo json_encode(['success' => false, 'message' => 'تعذّر العثور على ملف عميل. يرجى إكمال التسجيل.']);
    exit;
}
$real_customer_id = $customer_data['Customer_ID']; // المعرّف الفعلي في جدول booking

// ============================================================
// جلب أيام وساعات العمل من جدول servicepro
// ============================================================
$stmt2 = $db->prepare("SELECT working_days, working_hours FROM servicepro WHERE Provider_ID = ? AND Service_ID = ?");
$stmt2->bind_param("ii", $provider_id, $service_id);
$stmt2->execute();
$work_row = $stmt2->get_result()->fetch_assoc();

if ($work_row) {
    $allowed_days_str = $work_row['working_days'];   // مثل: "Monday,Tuesday,Wednesday"
    $work_hours_str   = $work_row['working_hours'];  // مثل: "8-17" أو "08:00-17:00"

    // --- التحقق من يوم الحجز ---
    $tsBooking = strtotime($booking_date);
    if ($tsBooking !== false) {
        $day_name     = date('l', $tsBooking); // اسم اليوم بالإنجليزية مثل Monday
        $allowed_days = array_filter(array_map('trim', explode(',', (string)$allowed_days_str)));
        $allowed_lower = array_map('strtolower', $allowed_days); // نحوّل للحروف الصغيرة للمقارنة

        if ($allowed_days !== [] && !in_array(strtolower($day_name), $allowed_lower, true)) {
            // اليوم المختار ليس ضمن أيام عمل المزود
            echo json_encode(['success' => false, 'message' => "عذراً، المزود غير متاح يوم $day_name"]);
            exit;
        }
    }

    // --- التحقق من ساعة الحجز ضمن نطاق ساعات العمل ---
    $parsed = booking_parse_working_hours((string)$work_hours_str);
    if ($parsed !== null) {
        [$start_time, $end_time] = $parsed;
        $userMin  = booking_time_to_minutes($booking_time); // وقت العميل بالدقائق
        $startMin = booking_time_to_minutes($start_time);   // بداية العمل بالدقائق
        $endMin   = booking_time_to_minutes($end_time);     // نهاية العمل بالدقائق

        if ($userMin !== null && $startMin !== null && $endMin !== null) {
            if ($userMin < $startMin || $userMin > $endMin) {
                // الوقت خارج ساعات العمل المسموحة
                echo json_encode(['success' => false, 'message' => "عذراً، الوقت خارج ساعات العمل ($work_hours_str)"]);
                exit;
            }
        }
    }
}

// ============================================================
// التحقق من عدم تكرار الحجز بنفس الوقت والتاريخ
// ============================================================
$stmt3 = $db->prepare("SELECT Provider_ID FROM booking WHERE Provider_ID = ? AND Service_ID = ? AND Booking_Time = ? AND Booking_Date = ? AND status != 'cancelled'");

$stmt3->bind_param("iiss", $provider_id, $service_id, $booking_time, $booking_date);
$stmt3->execute();
$duplicate = $stmt3->get_result();

if ($duplicate->num_rows > 0) {
    // الوقت المختار محجوز مسبقاً
    echo json_encode(['success' => false, 'message' => 'عذراً، هذا الوقت محجوز. يرجى اختيار وقت آخر.']);
    exit;
}

// ============================================================
// إدخال الحجز الجديد في قاعدة البيانات
// ============================================================
$sql = $db->prepare(
    "INSERT INTO Booking 
     (Customer_ID, Service_ID, Booking_Time, Booking_Date, note, Provider_ID, location_lat, location_lng, location_text)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
$sql->bind_param(
    "iisssidds",         // أنواع المعاملات: int, int, string, string, string, int, double, double, string
    $real_customer_id,   // معرّف العميل
    $service_id,         // معرّف الخدمة
    $booking_time,       // وقت الحجز
    $booking_date,       // تاريخ الحجز
    $booking_note,       // الملاحظات
    $provider_id,        // معرّف المزود
    $location_lat,       // خط العرض
    $location_lng,       // خط الطول
    $location_text       // العنوان النصي
);
$success = $sql->execute();

if ($success) {
    // الحجز تم بنجاح → نرسل redirect URL للـ JS
    echo json_encode(['success' => true, 'redirect' => 'dashboardCustomer.php', 'message' => 'تم الحجز بنجاح']);
} else {
    // خطأ في قاعدة البيانات عند الإدخال
    echo json_encode(['success' => false, 'message' => 'تعذّر إتمام الحجز. يرجى المحاولة مرة أخرى.']);
}
exit;
?>