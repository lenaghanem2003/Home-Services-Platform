<?php
// ============================================================
// ملف: admin_actions.php
// الغرض: جلب بيانات لوحة الأدمن بناءً على الـ action بكتابة عادية مسترسلة
// ============================================================

require "config.php"; // ملف الاتصال (conn$ أو db$ و session_start)

header("Content-Type: application/json"); // كل الردود JSON

// 1. استقبال الـ action من الـ URL (مثال: admin_actions.php?action=get_customers)
$action = isset($_GET['action']) ? $_GET['action'] : 'none';

// 2. خارطة الاستعلامات والمفاتيح (كتابة عادية داخل مصفوفة لترتيب الكود)
$config = [
    'get_categories' => [
        'sql' => "SELECT Category_ID AS id, 
                         IFNULL(Category_Name_en, Category_Name) AS name_en, 
                         IFNULL(Category_Name_ar, Category_Name) AS name_ar 
                  FROM Category ORDER BY Category_ID ASC",
        'key' => 'categories'
    ],
    'get_providers' => [
        'sql' => "SELECT p.Provider_ID AS id, p.First_Name AS first_name, p.Last_Name AS last_name, p.Phone_No AS phone, p.Governorate AS governorate, a.Email AS email 
                  FROM Provider p LEFT JOIN Account a ON p.User_ID = a.User_ID ORDER BY p.Provider_ID DESC",
        'key' => 'providers'
    ],
    'get_customers' => [
        'sql' => "SELECT c.Customer_ID AS id, CONCAT(c.First_Name, ' ', c.Last_Name) AS full_name, c.First_Name AS first_name, c.Last_Name AS last_name, c.Phone_No AS phone, c.Governorate AS governorate, a.Email AS email 
                  FROM customer c LEFT JOIN Account a ON c.User_ID = a.User_ID ORDER BY c.Customer_ID DESC",
        'key' => 'customers'
    ],
    'get_recent_customers' => [
        'sql' => "SELECT CONCAT(First_Name, ' ', Last_Name) AS full_name, Phone_No AS phone, Governorate AS governorate 
                  FROM customer ORDER BY Customer_ID DESC LIMIT 5",
        'key' => 'customers'
    ],
    'get_services' => [
        'sql' => "SELECT s.Service_ID AS id, 
                         IFNULL(s.Service_Name_en, s.Service_Name) AS name_en, 
                         IFNULL(s.Service_Name_ar, s.Service_Name) AS name_ar, 
                         s.Category_ID AS category_id, 
                         IFNULL(c.Category_Name_ar, c.Category_Name) AS category_name_ar, 
                         IFNULL(c.Category_Name_en, c.Category_Name) AS category_name_en
                  FROM service s 
                  INNER JOIN Category c ON s.Category_ID = c.Category_ID 
                  ORDER BY s.Service_ID DESC",
        'key' => 'services'
    ],
    // الإجراء الجديد: جلب الأعداد الإجمالية لكل الجداول لعرضها في بطاقات الإحصاءات
    'get_stats' => [
        'sql' => "SELECT 
                    (SELECT COUNT(*) FROM customer) AS customers,
                    (SELECT COUNT(*) FROM Provider) AS providers,
                    (SELECT COUNT(*) FROM Category) AS categories,
                    (SELECT COUNT(*) FROM service) AS services",
        'key' => 'stats'
    ]
];

// 3. التنفيذ المسترسل والمباشر
// نفحص إذا كان الـ action المطلوب مدعوماً في خارطة الكود أعلاه
if (array_key_exists($action, $config)) {
    
    // ملاحظة: تأكدي من مسمى متغير الاتصال بقاعدة البيانات (إذا كان $db أو $conn في ملف config.php)
    $stmt = $db->prepare($config[$action]['sql']); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    // تعديل بسيط لقراءة نتيجة الإحصاءات كـ Object واحد بدلاً من مصفوفة أسطر
    if ($action === 'get_stats') {
        $data = $result->fetch_assoc(); // جلب السطر الوحيد الخاص بالأعداد
        echo json_encode([
            "success" => true,
            "customers"  => $data['customers'],
            "providers"  => $data['providers'],
            "categories" => $data['categories'],
            "services"   => $data['services']
        ]);
    } else {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode([
            "success" => true,
            $config[$action]['key'] => $data
        ]);
    }
    
    $stmt->close();

} else {
    // إذا كان الـ action غير معروف أو فارغ
    echo json_encode([
        "success" => false,
        "message" => "Action غير معروف"
    ]);
}

$db->close();
?>