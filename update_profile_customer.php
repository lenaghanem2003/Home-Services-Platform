<?php
require "config.php";

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id']; // نحصل عليه من السيشن عند تسجيل الدخول

if(isset($data['first_name'])) {
    // 1. تحديث جدول الـ customer
    $sql1 = "UPDATE customer SET First_Name = ?, Last_Name = ?, Governorate = ? , Phone_No=? WHERE User_ID = ?";
    $stmt1 = $db->prepare($sql1);
    $stmt1->bind_param("ssssi", $data['first_name'], $data['last_name'], $data['Governorate'],$data['phone_no'] ,$user_id);
    
    // 2. تحديث جدول الـ Account (الإيميل)
    $sql2 = "UPDATE Account SET Email = ? WHERE User_ID = ?";
    $stmt2 = $db->prepare($sql2);
    $stmt2->bind_param("si", $data['email'], $user_id);

    if ($stmt1->execute() && $stmt2->execute()) {

        // 3. تغيير كلمة المرور (فقط إذا أدخلت قيمة)
        if (!empty($data['password']) && !empty($data['new_pass'])) {

            // جيبي الباسورد الحالية
            $sql3  = "SELECT Password FROM Account WHERE User_ID = ?";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bind_param("i", $user_id);
            $stmt3->execute();
            $row = $stmt3->get_result()->fetch_assoc();

            // تحققي إن القديمة صح
            if ($row && password_verify($data['password'], $row['Password'])) {
                $newHash = password_hash($data['new_pass'], PASSWORD_DEFAULT);
                $sql4    = "UPDATE Account SET Password = ? WHERE User_ID = ?";
                $stmt4   = $db->prepare($sql4);
                $stmt4->bind_param("si", $newHash, $user_id);
                $stmt4->execute();
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "كلمة المرور الحالية غير صحيحة"]);
            }

        } else {
            // ما أدخلت باسورد — حفظ البيانات العادية فقط
            echo json_encode(["success" => true]);
        }

    } else {
        echo json_encode(["success" => false, "message" => $db->error]);
    }

    
}
?>