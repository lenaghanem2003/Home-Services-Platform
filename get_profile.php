<?php
    // استدعاء ملف الاتصال بقاعدة البيانات
    require "config.php";

    // إخبار المتصفح إن الرد رح يكون بصيغة JSON مش صفحة HTML عادية
    header('Content-Type: application/json');

    // التأكد إن المستخدم مسجل دخول وموجود له User_ID في السشن
    if (isset($_SESSION['user_id'])) {
        
        $user_id = $_SESSION['user_id'];

        // أول شي بدنا نعرف شو "رتبة" المستخدم (Role) عشان نعرف نجيب بياناته من أي جدول
        $sql_role = "SELECT Role_ID FROM Account WHERE User_ID = ?";
        $stmt_role = $db->prepare($sql_role);
        $stmt_role->bind_param("i", $user_id);
        $stmt_role->execute();
        $result_role = $stmt_role->get_result();
        $user_data = $result_role->fetch_assoc();

        if ($user_data) {
            $role_id = $user_data['Role_ID'];

            // إذا كان Role_ID يساوي 1 (مثلاً للزبون Customer)
            if ($role_id == 1) {
                // استعلام لجلب بيانات الزبون مع بيانات حسابه
                $sql = "SELECT a.Email, a.User_Name, c.First_Name, c.Last_Name, c.Phone_No, c.Governorate, c.Village 
                        FROM Account a 
                        JOIN customer c ON a.User_ID = c.User_ID 
                        WHERE a.User_ID = ?";
            } 
            // إذا كان Role_ID يساوي 2 (مثلاً لمزود الخدمة Provider)
            else {
                // استعلام لجلب بيانات المزود مع بيانات حسابه
                $sql = "SELECT a.Email, a.User_Name, p.First_Name, p.Last_Name, p.Phone_No, p.Governorate, p.profile_image 
                        FROM Account a 
                        JOIN Provider p ON a.User_ID = p.User_ID 
                        WHERE a.User_ID = ?";
            }

            // تجهيز وتنفيذ الاستعلام النهائي
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $profile_info = $result->fetch_assoc();

            if ($profile_info) {
                // إذا لقينا البيانات بنبعتها بنجاح
                echo json_encode(['success' => true, 'data' => $profile_info]);
            } else {
                // إذا ما لقينا بيانات في جداول التفاصيل
                echo json_encode(['success' => false, 'message' => 'لم يتم العثور على تفاصيل الملف الشخصي']);
            }
        }
    } else {
        // إذا المستخدم مش مسجل دخول أصلاً
        echo json_encode(['success' => false, 'message' => 'المستخدم غير مسجل دخول']);
    }
    exit; // إنهاء السكريبت
?>