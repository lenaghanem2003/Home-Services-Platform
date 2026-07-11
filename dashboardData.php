<?php
// ============================================================
// get_dashboard_data.php — API Endpoint للداشبورد (متوافق مع الفرونت)
// ============================================================

require "config.php"; // بيعطينا $db كـ mysqli instance

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

$user_id = (int) $_SESSION['user_id']; 

// جلب الـ Provider_ID وبيانات المزود الأساسية (تمت إضافة الحقول الناقصة هنا)
$stmt = $db->prepare("
    SELECT 
        p.Provider_ID, 
        p.Phone_No,
        p.Governorate,
        p.First_Name,
        p.Last_Name,
        CONCAT(p.First_Name, ' ', p.Last_Name) AS Full_Name,
        sp.Service_ID,
        sp.Price        AS Price_Per_Hour,
        sp.Service_Description AS Bio,
        sp.working_days,
        sp.working_hours,
        s.Service_Name,
        a.Email
    FROM provider p
    LEFT JOIN servicepro sp ON sp.Provider_ID = p.Provider_ID
    LEFT JOIN service s ON sp.Service_ID = s.Service_ID
    LEFT JOIN account a ON a.User_ID = p.User_ID
    WHERE p.User_ID = ?
    LIMIT 1
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$provider_info = $stmt->get_result()->fetch_assoc();

if (!$provider_info) { 
    echo json_encode(['success' => false, 'error' => 'Provider not found for user_id: ' . $user_id]);
    exit;
}

$provider_id = (int) $provider_info['Provider_ID'];

// 1. حجوزات آخر 7 أيام
$stmt = $db->prepare("
    SELECT COUNT(*) AS cnt
    FROM booking
    WHERE Provider_ID = ?
      AND Booking_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
");
$stmt->bind_param("i", $provider_id);
$stmt->execute();
$weekly_count = (int) $stmt->get_result()->fetch_assoc()['cnt'];

// 2. مجموع كل الحجوزات
$stmt = $db->prepare("
    SELECT COUNT(*) AS cnt
    FROM booking
    WHERE Provider_ID = ?
");
$stmt->bind_param("i", $provider_id);
$stmt->execute();
$total_count = (int) $stmt->get_result()->fetch_assoc()['cnt'];

// 3. الحجوزات المكتملة
$stmt = $db->prepare("
    SELECT COUNT(*) AS cnt
    FROM booking
    WHERE Provider_ID = ?
      AND status = 'completed'
");
$stmt->bind_param("i", $provider_id);
$stmt->execute();
$completed_count = (int) $stmt->get_result()->fetch_assoc()['cnt'];

$completion_rate = $total_count > 0 ? round(($completed_count / $total_count) * 100) : 0;

// 4. الحجوزات المعلقة
$stmt = $db->prepare("
    SELECT COUNT(*) AS cnt
    FROM booking
    WHERE Provider_ID = ?
      AND status = 'pending'
");
$stmt->bind_param("i", $provider_id);
$stmt->execute();
$pending_count = (int) $stmt->get_result()->fetch_assoc()['cnt'];

// 5. بيانات الشارت — الحجوزات حسب محافظة الزبون
$stmt = $db->prepare("
    SELECT c.Governorate, COUNT(*) AS booking_count
    FROM booking b
    JOIN customer c ON b.Customer_ID = c.Customer_ID
    WHERE b.Provider_ID = ?
    GROUP BY c.Governorate
    ORDER BY booking_count DESC
    LIMIT 6
");
$stmt->bind_param("i", $provider_id);
$stmt->execute();
$chart_result = $stmt->get_result();

$chart_labels = [];
$chart_values = [];
while ($row = $chart_result->fetch_assoc()) {
    $chart_labels[] = $row['Governorate'];
    $chart_values[] = (int) $row['booking_count'];
}

// ============================================================
// 6. آخر 6 حجوزات للجدول (تم دمج حقول الموقع الكاملة هنا)
// ============================================================
$stmt = $db->prepare("
    SELECT
        b.Booking_ID  AS order_id,
        CONCAT(c.First_Name, ' ', c.Last_Name) AS client_name,
        CONCAT(c.Governorate, ', ', c.Village, ', ', c.Street) AS location,
        CONCAT(b.Booking_Date, ' ', b.Booking_Time) AS date_time,
        c.Phone_No    AS whatsapp,
        b.status,
        b.note,
        b.location_lat  AS lat,
        b.location_lng  AS lng
    FROM booking b
    JOIN customer c ON b.Customer_ID = c.Customer_ID
    WHERE b.Provider_ID = ?
    ORDER BY b.Booking_Date DESC, b.Booking_Time DESC
    LIMIT 6
");
$stmt->bind_param("i", $provider_id);
$stmt->execute();
$bookings_result = $stmt->get_result();

$bookings_list = [];
while ($row = $bookings_result->fetch_assoc()) {
    $bookings_list[] = $row;
}

$services_result = $db->query("SELECT Service_ID, Service_Name FROM service ORDER BY Service_Name");
$services_list = [];
while ($srow = $services_result->fetch_assoc()) {
    $services_list[] = ['id' => $srow['Service_ID'], 'name' => $srow['Service_Name']];
}

// 7. كل الحجوزات لصفحة All Bookings (بدون LIMIT)
$stmt = $db->prepare("
    SELECT
        b.Booking_ID  AS order_id,
        CONCAT(c.First_Name, ' ', c.Last_Name) AS client_name,
        CONCAT(c.Governorate, ', ', c.Village, ', ', c.Street) AS location,
        CONCAT(b.Booking_Date, ' ', b.Booking_Time) AS date_time,
        c.Phone_No    AS whatsapp,
        b.status,
        b.note,
        b.location_lat AS lat,
        b.location_lng AS lng
    FROM booking b
    JOIN customer c ON b.Customer_ID = c.Customer_ID
    WHERE b.Provider_ID = ?
    ORDER BY b.Booking_Date DESC, b.Booking_Time DESC
");
$stmt->bind_param("i", $provider_id);
$stmt->execute();
$all_result = $stmt->get_result();

$all_bookings_list = [];
while ($row = $all_result->fetch_assoc()) {
    $all_bookings_list[] = $row;
}

// ============================================================
// 7. تجميع الرد بالهيكلية المتوافقة تماماً مع الـ JavaScript
// ============================================================
echo json_encode([
    'success'         => true, // ضروري جداً لأن الفرونت يفحصه أولاً
    'user' => [
        'name'        => $provider_info['Full_Name'],
        'role'        => $provider_info['Service_Name'] ?? 'Service Provider'
    ],
    'stats' => [
        'weekly'          => $weekly_count,
        'total'           => $total_count,
        'completed'       => $completed_count,
        'pending'         => $pending_count,
        'completion_rate' => $completion_rate
    ],
    'chart_data' => [
        'labels'          => $chart_labels,
        'values'          => $chart_values
    ],
    'recent_bookings'     => $bookings_list,
    'all_bookings'    => $all_bookings_list,
    'services'        => $services_list,
    
    // تم إضافة وتوزيع كافة بيانات التعديل هنا لترجع بالـ JSON للفرونت إند
    'profile_extra' => [
        'first_name'      => $provider_info['First_Name'],
        'last_name'       => $provider_info['Last_Name'],
        'phone'           => $provider_info['Phone_No'],
        'governorate'     => $provider_info['Governorate'],
        'email'           => $provider_info['Email'] ?? '', 
        'service_id'      => $provider_info['Service_ID'],
        'bio'             => $provider_info['Bio'],
        'price'           => $provider_info['Price_Per_Hour'],
        'working_days'    => $provider_info['working_days'],
        'working_hours'   => $provider_info['working_hours']
    ]
], JSON_UNESCAPED_UNICODE);
exit;
?>