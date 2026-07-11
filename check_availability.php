<?php
require "config.php";
header('Content-Type: application/json');

// استخدام GET بدل POST لأن الفرونت بيرسل query string
$p_id = (int)($_GET['provider_id'] ?? 0);
$s_id = (int)($_GET['service_id']  ?? 0);
$date =       $_GET['date']         ?? '';
$current_booking_id = (int)($_GET['booking_id'] ?? 0); // اختياري لاستثناء الحجز الحالي

if (!$p_id || !$s_id || !$date) {
    echo json_encode([]); // array فاضية بدل success:false عشان forEach ما تنكسر
    exit;
}

$stmt = $db->prepare("SELECT working_days, working_hours FROM servicepro WHERE Provider_ID = ? AND Service_ID = ?");
$stmt->bind_param("ii", $p_id, $s_id);
$stmt->execute();
$work_data = $stmt->get_result()->fetch_assoc();

if (!$work_data) {
    echo json_encode([]);
    exit;
}

$day_name = date('l', strtotime($date));
$allowed_days_array = array_map('trim', explode(',', strtolower($work_data['working_days'])));

if (!in_array(strtolower($day_name), $allowed_days_array)) {
    echo json_encode([]);
    exit;
}

// استثني الحجز الحالي (الذي يتم تعديله) من قائمة الأوقات المحجوزة
$sql2 = "SELECT Booking_Time FROM booking WHERE Provider_ID = ? AND Booking_Date = ? AND status IN ('pending','confirmed')";
if ($current_booking_id) {
    $sql2 .= " AND Booking_ID != ?";
}
$stmt2 = $db->prepare($sql2);
if ($current_booking_id) {
    $stmt2->bind_param("issi", $p_id, $date, $current_booking_id);
} else {
    $stmt2->bind_param("is", $p_id, $date);
}
$stmt2->execute();
$res = $stmt2->get_result();

$booked_times = [];
while ($row = $res->fetch_assoc()) {
    $booked_times[] = date('H:i:s', strtotime($row['Booking_Time']));
}

$parts      = explode('-', $work_data['working_hours']);
$start_hour = (int)($parts[0] ?? 8);
$end_hour   = (int)($parts[1] ?? 17);

$slots = [];
for ($hour = $start_hour; $hour <= $end_hour; $hour++) {
    $time_db = sprintf('%02d:00:00', $hour);
    if (in_array($time_db, $booked_times)) continue; // استثني المحجوز

    $slots[] = [
        'value'   => $time_db,
        'display' => date('h:i A', strtotime($time_db))
    ];
}

echo json_encode($slots);
exit;