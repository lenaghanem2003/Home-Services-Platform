<?php

header('Content-Type: application/json; charset=utf-8');

require "config.php";

// استقبال البيانات سواء كانت JSON أو POST عادي
$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    $input = $_POST;
}

// تنظيف المدخلات واستخراجها
$service_name = trim($input['Service_Name'] ?? '');
$category_id  = trim($input['Category_ID'] ?? '');

// التحقق من المدخلات الإلزامية
if ($service_name === '') {
    echo json_encode([
        "success" => false,
        "message" => "Service_Name مطلوب"
    ]);
    exit;
}

if ($category_id === '') {
    echo json_encode([
        "success" => false,
        "message" => "Category_ID مطلوب"
    ]);
    exit;
}

// 1. التحقق من أن الصنف (Category) موجود بالفعل في قاعدة البيانات
$checkCategory = $db->prepare("SELECT Category_ID FROM Category WHERE Category_ID = ?");
$checkCategory->bind_param("i", $category_id);
$checkCategory->execute();
$categoryResult = $checkCategory->get_result();

if ($categoryResult->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "الصنف المحدد (Category_ID) غير موجود"
    ]);
    exit;
}

// 2. التحقق من التكرار (عدم إضافة نفس الخدمة لنفس الصنف مسبقاً)
$stmt = $db->prepare("SELECT Service_ID FROM service WHERE Service_Name = ? AND Category_ID = ?");
$stmt->bind_param("si", $service_name, $category_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "هذه الخدمة موجودة مسبقاً داخل هذا الصنف"
    ]);
    exit;
}

// 3. إضافة الخدمة الجديدة
$stmt = $db->prepare("INSERT INTO service (Service_Name, Category_ID) VALUES (?, ?)");
$stmt->bind_param("si", $service_name, $category_id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "تمت إضافة الخدمة بنجاح",
        "Service_ID" => $db->insert_id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "فشلت عملية الإضافة: " . $db->error
    ]);
}