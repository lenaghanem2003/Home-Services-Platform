<?php
require "config.php";

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['booking_id'])) {
    $id   = (int)$data['booking_id'];
    $date = trim($data['date'] ?? '');
    $time = trim($data['time'] ?? '');
    $note = trim($data['note'] ?? '');

    // التحقق من الحقول الأساسية
    if (!$id || !$date || !$time) {
        echo json_encode(["success" => false, "message" => "يرجى تعبئة التاريخ والوقت"]);
        exit;
    }

    $sql  = "UPDATE Booking SET Booking_Date = ?, Booking_Time = ?, note = ? WHERE Booking_ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssi", $date, $time, $note, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $db->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "booking_id مفقود"]);
}
?>