<?php
require "config.php";

// لازم تكون قبل أي output
ob_start(); // ← يمسك أي output غلطي
header('Content-Type: application/json');

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

ob_clean(); // ← يمسح أي warnings طلعت

if (!$data || !isset($data['booking_id'], $data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON: ' . $raw]);
    exit;
}

$booking_id = (int) $data['booking_id'];
$status     = $data['status'];


if (!in_array($status, ['confirmed', 'cancelled', 'completed'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$stmt = $db->prepare("SELECT Provider_ID FROM provider WHERE User_ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'Provider not found']);
    exit;
}

$provider_id = (int) $row['Provider_ID'];


$stmt = $db->prepare("
    UPDATE booking 
    SET status = ? 
    WHERE Booking_ID = ? 
    AND Provider_ID = ?
");
$stmt->bind_param("sii", $status, $booking_id, $provider_id);
$stmt->execute();

echo json_encode([
    'success' => $stmt->affected_rows > 0,
    'message' => $stmt->affected_rows > 0 ? 'Updated successfully' : 'Not found or already updated'
]);
exit;
?>