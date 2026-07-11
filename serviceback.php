<?php
header("Content-Type: application/json; charset=UTF-8");

require "config.php";
require "translate_helper.php";
$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'ar';

if ($current_lang === 'en') {
    $name_col = "s.Service_Name_en";
    $desc_col = "sp.Service_Description_en";
} else {
    $name_col = "s.Service_Name_ar";
    $desc_col = "sp.Service_Description_ar";
}

$ajax        = $_GET['ajax']             ?? '';
$category_id = (int)($_GET['id']         ?? 0);
$service_id  = (int)($_GET['service_id'] ?? 0);


// --- جلب الخدمات (مع بحث اختياري) ---
if ($ajax === 'services') {

    if ($category_id <= 0) {
        echo json_encode(["status" => "error", "message" => "معرف القسم غير صالح"]);
        exit;
    }

    $search = trim($_GET['q'] ?? '');

    if ($search === '') {
        $sql = "SELECT s.Service_ID,
                       COALESCE($name_col, s.Service_Name) AS Service_Name,
                       COALESCE(MIN(sp.Price), 0)          AS min_price
                FROM service s
                LEFT JOIN servicepro sp ON s.Service_ID = sp.Service_ID
                WHERE s.Category_ID = ?
                GROUP BY s.Service_ID, s.Service_Name, s.Service_Name_ar, s.Service_Name_en
                ORDER BY Service_Name";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $category_id);
    } else {
        $sql = "SELECT s.Service_ID,
                       COALESCE($name_col, s.Service_Name) AS Service_Name,
                       COALESCE(MIN(sp.Price), 0)          AS min_price
                FROM service s
                LEFT JOIN servicepro sp ON s.Service_ID = sp.Service_ID
                WHERE s.Category_ID = ?
                  AND (s.Service_Name_ar LIKE ? OR s.Service_Name_en LIKE ? OR s.Service_Name LIKE ?)
                GROUP BY s.Service_ID, s.Service_Name, s.Service_Name_ar, s.Service_Name_en
                ORDER BY Service_Name";
        $stmt = $db->prepare($sql);
        $like = "%" . $search . "%";
        $stmt->bind_param("isss", $category_id, $like, $like, $like);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = [
            'Service_ID'   => (int)$row['Service_ID'],
            'Service_Name' => $row['Service_Name'],
            'min_price'    => (float)$row['min_price'],
        ];
    }

    echo json_encode([
        "status"   => "success",
        "services" => $services
    ], JSON_UNESCAPED_UNICODE);
    exit;
}


// --- أعلى سعر للسلايدر ---
if ($ajax === 'price_max') {

    if ($category_id <= 0) {
        echo json_encode(["status" => "error", "message" => "معرف القسم غير صالح"]);
        exit;
    }

    $sql = "SELECT MAX(sp.Price) AS top_price
            FROM servicepro sp
            INNER JOIN service s ON sp.Service_ID = s.Service_ID
            WHERE s.Category_ID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    echo json_encode([
        "status" => "success",
        "max"    => (float)($row['top_price'] ?? 0)
    ], JSON_UNESCAPED_UNICODE);
    exit;
}


// --- مزودو خدمة معينة ---
if ($ajax === 'providers') {

    if ($service_id <= 0) {
        echo json_encode(["status" => "error", "message" => "معرف الخدمة غير صالح"]);
        exit;
    }

    $sql = "SELECT p.Provider_ID, p.First_Name, p.Last_Name, sp.Price, p.Phone_No, p.Governorate,
                   COALESCE($desc_col, sp.Service_Description) AS Service_Description,
                   sp.working_days, sp.working_hours,
                   COALESCE($name_col, s.Service_Name) AS Service_Name,
                   s.Service_ID,
                   ROUND(AVG(r.Score), 1) AS avg_rating,
                   COUNT(r.Rating_ID)     AS rating_count
            FROM Provider p
            JOIN servicepro sp ON p.Provider_ID = sp.Provider_ID
            JOIN service    s  ON sp.Service_ID  = s.Service_ID
            LEFT JOIN Booking b ON b.Provider_ID = p.Provider_ID
                                AND b.Service_ID  = s.Service_ID
            LEFT JOIN Rating  r ON r.Booking_ID  = b.Booking_ID
            WHERE s.Service_ID = ?
            GROUP BY p.Provider_ID, p.First_Name, p.Last_Name, sp.Price, p.Phone_No, p.Governorate,
                     sp.Service_Description, sp.Service_Description_ar, sp.Service_Description_en,
                     sp.working_days, sp.working_hours,
                     s.Service_Name, s.Service_Name_ar, s.Service_Name_en, s.Service_ID";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $providers = [];
    while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }

    if (count($providers) > 0) {
        echo json_encode([
            "status"    => "success",
            "providers" => $providers
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "لا يوجد مزودون لهذه الخدمة"
        ], JSON_UNESCAPED_UNICODE);
    }
    exit;
}


// --- طلب غير معروف ---
echo json_encode(["status" => "error", "message" => "طلب غير معروف"]);
exit;
?>