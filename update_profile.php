<?php
require "config.php";

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id']; // نحصل عليه من السيشن عند تسجيل الدخول

if(isset($data['first_name'])) {

    // 1. جلب الـ Provider_ID الخاص بهذا المستخدم أولاً لنتمكن من تحديث جدول servicepro
    $sql_prov = "SELECT Provider_ID FROM Provider WHERE User_ID = ?";
    $stmt_prov = $db->prepare($sql_prov);
    $stmt_prov->bind_param("i", $user_id);
    $stmt_prov->execute();
    $res_prov = $stmt_prov->get_result()->fetch_assoc();

    if ($res_prov) {
        $provider_id = $res_prov['Provider_ID'];

        // 2. تحديث جدول الـ Provider (الاسم، الهاتف، ومنطقة الخدمة "Governorate")
        $sql1 = "UPDATE Provider SET First_Name = ?, Last_Name = ?, Phone_No = ?, Governorate = ? WHERE User_ID = ?";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bind_param("ssssi", $data['first_name'], $data['last_name'], $data['phone_no'], $data['governorate'], $user_id);
        
        // 3. تحديث جدول الـ Account (الإيميل)
        $sql2 = "UPDATE Account SET Email = ? WHERE User_ID = ?";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bind_param("si", $data['email'], $user_id);

        // 4. تحديث جدول الـ servicepro (نوع الخدمة، السعر، الوصف، أيام وساعات العمل)
        // ملاحظة: Service_ID يمثل نوع الخدمة التي يختارها المزود
        $sql3 = "UPDATE servicepro SET Service_ID = ?, Price = ?, Service_Description = ?, working_days = ?, working_hours = ? WHERE Provider_ID = ?";
        $stmt3 = $db->prepare($sql3);
        $stmt3->bind_param("idsssi", $data['service_id'], $data['price'], $data['description'], $data['working_days'], $data['working_hours'], $provider_id);

        // تنفيذ الاستعلامات الرئيسية الثلاثة
        if ($stmt1->execute() && $stmt2->execute() && $stmt3->execute()) {

            // 5. تغيير كلمة المرور (فقط إذا أدخلت قيمة)
            if (!empty($data['old_pass']) && !empty($data['new_pass'])) {

                // جيبي الباسورد الحالية
                $sql4  = "SELECT Password FROM Account WHERE User_ID = ?";
                $stmt4 = $db->prepare($sql4);
                $stmt4->bind_param("i", $user_id);
                $stmt4->execute();
                $row = $stmt4->get_result()->fetch_assoc();

                // تحققي إن القديمة صح
                if ($row && password_verify($data['old_pass'], $row['Password'])) {
                    $newHash = password_hash($data['new_pass'], PASSWORD_DEFAULT);
                    $sql5    = "UPDATE Account SET Password = ? WHERE User_ID = ?";
                    $stmt5   = $db->prepare($sql5);
                    $stmt5->bind_param("si", $newHash, $user_id);
                    $stmt5->execute();
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
    } else {
        echo json_encode(["success" => false, "message" => "لم يتم العثور على مزود خدمة مرتبط بهذا الحساب"]);
    }
}
?>