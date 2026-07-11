<?php
require "config.php";

$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = null;

if($category_id == 0){
    die("Category not found"); // لو دخل بدون id
}

// جلب اسم الفئة
$name_cate = $db->query("SELECT Category_Name FROM category WHERE Category_ID=$category_id");
if($name_cate->num_rows > 0){
    $result = $name_cate->fetch_assoc();
} else {
    die("Category not found");
}

// بناء الاستعلام الأساسي
$sql = "SELECT 
    p.First_Name, 
    p.Last_Name, 
    p.profile_image,
    p.Governorate,
    sp.Price, 
    sp.Service_Description, 
    sp.working_days, 
    sp.working_hours,
    s.Service_Name
FROM Provider p
JOIN servicepro sp ON p.Provider_ID = sp.Provider_ID
JOIN service s ON sp.Service_ID = s.Service_ID
WHERE s.Category_ID = $category_id";

// إضافة البحث أو الفلترة لو ضغط زر البحث
if(isset($_GET['search-button'])){
    if(!empty($_GET['search'])){
        $search = $db->real_escape_string($_GET['search']);
        $sql .= " AND s.Service_Name LIKE '%$search%'";
    }
    if(!empty($_GET['num_price'])){
        $filter_price = (float)$_GET['num_price'];
        $sql .= " AND sp.Price => $filter_price";
    }
    if(!empty($_GET['area'])){
        $filter_area = $db->real_escape_string($_GET['area']);
        $sql .= " AND p.Governorate = '$filter_area'";
    }
}

$stmsel = $db->query($sql);

if(!$stmsel){
    die("Query error: ".$db->error);
}
?>