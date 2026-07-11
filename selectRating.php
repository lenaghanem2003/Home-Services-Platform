<?php
header("Content-Type: application/json; charset=UTF-8");

require "config.php";

$lang       = $_GET['lang'] ?? 'ar';
$commentCol = ($lang === 'ar') ? 'Comment_ar' : 'Comment_en';

$sql = "SELECT 
            r.Rating_ID,
            r.Score,
            COALESCE(r.$commentCol, r.Comment) AS Comment,
            r.Date,
            CONCAT(c.First_Name, ' ', c.Last_Name) AS Customer_Name,
            s.Service_Name_ar,
            s.Service_Name_en
        FROM Rating r
        JOIN customer c ON r.Customer_ID = c.Customer_ID
        JOIN service s ON r.Service_ID = s.Service_ID
        WHERE r.Score IS NOT NULL
        ORDER BY r.Date DESC
        LIMIT 20";

$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {

    $ratings = array();

    while ($row = $result->fetch_assoc()) {
        $ratings[] = $row;
    }

    echo json_encode([
        "status"  => "success",
        "ratings" => $ratings
    ], JSON_UNESCAPED_UNICODE);

} else {

    echo json_encode([
        "status"  => "error",
        "message" => "لا توجد تقييمات"
    ], JSON_UNESCAPED_UNICODE);

}
?>