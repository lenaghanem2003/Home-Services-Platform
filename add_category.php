<?php

header('Content-Type: application/json; charset=utf-8');

require "config.php";
require "translate_helper.php";

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    $input = $_POST;
}

$category_name = trim($input['Category_Name'] ?? '');
$category_description = trim($input['Category_Description'] ?? ''); 

if ($category_name === '') {
    echo json_encode([
        "success" => false,
        "message" => "Category_Name مطلوب"
    ]);
    exit;
}

// التحقق من التكرار
$stmt = $db->prepare("SELECT Category_ID FROM category WHERE Category_Name = ?");
$stmt->bind_param("s", $category_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "الصنف موجود مسبقاً"
    ]);
    exit;
}

// --- استخدام دوالك لتحديد اللغة والترجمة التلقائية ---
$detected_lang = detectLang($category_name);

if ($detected_lang === 'ar') {
    // المدخلات عربي، نقوم بترجمتها للإنجليزي
    $category_name_ar = $category_name;
    $category_name_en = translateText($category_name, 'ar', 'en');
    
    $category_description_ar = $category_description;
    $category_description_en = translateText($category_description, 'ar', 'en');
} else {
    // المدخلات إنجليزي، نقوم بترجمتها للعربي
    $category_name_en = $category_name;
    $category_name_ar = translateText($category_name, 'en', 'ar');
    
    $category_description_en = $category_description;
    $category_description_ar = translateText($category_description, 'en', 'ar');
}


// إضافة الصنف مع كافة حقول قاعدة البيانات المعدلة
$query = "INSERT INTO category (
    Category_Name, 
    category_description, 
    Category_Name_ar, 
    Category_Name_en, 
    category_description_ar, 
    category_description_en
) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $db->prepare($query);
$stmt->bind_param("ssssss", 
    $category_name, 
    $category_description, 
    $category_name_ar, 
    $category_name_en, 
    $category_description_ar, 
    $category_description_en
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "تمت إضافة الصنف وترجمته بنجاح",
        "Category_ID" => $db->insert_id,
        "translations" => [
            "input_lang" => $detected_lang,
            "name_ar" => $category_name_ar,
            "name_en" => $category_name_en,
            "desc_ar" => $category_description_ar,
            "desc_en" => $category_description_en
        ]
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => $db->error
    ]);

}