<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require "config.php";
require 'translate_helper.php';

$flage = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $name = "";
    $email = "";
    $password = "";
    $role_id = 2;
    $phone_number = "";
    $location = "";
    $price = "";
    $Service_Description = "";
    $working_days = "";
    $working_hours = "";
    $service_Name = "";
    $user_selection = "";
    $file = "";
    $category_desc = "";
    $is_image_valid = true;

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }
    if (isset($_POST['phone_number'])) {
        $phone_number = $_POST['phone_number'];
    }
    if (isset($_POST['location'])) {
        $location = $_POST['location'];
    }
    if (isset($_POST['price-modal'])) {
        $price = $_POST['price-modal'];
    }
    if (isset($_POST['description-modal'])) {
        $Service_Description = $_POST['description-modal'];
    }
    if (isset($_POST['working_days'])) {
        $working_days = implode(',', $_POST['working_days']);
    }
    if (isset($_POST['start_time']) && isset($_POST['end_time'])) {
        $working_hours = $_POST['start_time'] . "-" . $_POST['end_time'];
    }
    if (isset($_POST['servicename-modal'])) {
        $service_Name = $_POST['servicename-modal'];
    }
    if (isset($_POST['category-modal'])) {
        $user_selection = $_POST['category-modal'];
    }
    if (isset($_POST['descriptioncate-modal'])) {
        $category_desc = $_POST['descriptioncate-modal'];
    }



    // ==========================================
    // 1️⃣ ← ترجمة وصف الخدمة تلقائياً عبر فحص النص (detectLang)
    // ==========================================
    $description = trim($Service_Description);
    $desc_ar = '';
    $desc_en = '';

    if ($description !== '') {
        $inputLang = detectLang($description);
        $otherLang = ($inputLang === 'ar') ? 'en' : 'ar';
        $translated = translateText($description, $inputLang, $otherLang);

        $desc_ar = ($inputLang === 'ar') ? $description : $translated;
        $desc_en = ($inputLang === 'en') ? $description : $translated;
    }

    // ==========================================
    // 2️⃣ ← تحقق من الصنف والترجمة التلقائية لحقوله
    // ==========================================
    $stmt = $db->prepare("
        SELECT Category_ID FROM category 
        WHERE Category_Name = ? 
           OR Category_Name_ar = ? 
           OR Category_Name_en = ?
    ");
    $stmt->bind_param("sss", $user_selection, $user_selection, $user_selection);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check->num_rows > 0) {
        $new_var = $check->fetch_assoc();
        $final_id = $new_var['Category_ID'];
    } else {
        // ترجمة اسم الصنف تلقائياً بحسب فحص لغة النص
        $inputLangCat = detectLang($user_selection);
        $otherLangCat = ($inputLangCat === 'ar') ? 'en' : 'ar';
        $catName_translated = translateText($user_selection, $inputLangCat, $otherLangCat);

        $catName_ar = ($inputLangCat === 'ar') ? $user_selection : $catName_translated;
        $catName_en = ($inputLangCat === 'en') ? $user_selection : $catName_translated;

        // ترجمة وصف الصنف تلقائياً
        $catDesc_ar = '';
        $catDesc_en = '';
        if ($category_desc !== '') {
            $inputLangDesc = detectLang($category_desc);
            $otherLangDesc = ($inputLangDesc === 'ar') ? 'en' : 'ar';
            $catDesc_translated = translateText($category_desc, $inputLangDesc, $otherLangDesc);

            $catDesc_ar = ($inputLangDesc === 'ar') ? $category_desc : $catDesc_translated;
            $catDesc_en = ($inputLangDesc === 'en') ? $category_desc : $catDesc_translated;
        }

        $stmt = $db->prepare("INSERT INTO category 
            (Category_Name, category_description, Category_Name_ar, Category_Name_en, category_description_ar, category_description_en) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $user_selection, $category_desc, $catName_ar, $catName_en, $catDesc_ar, $catDesc_en);
        $stmt->execute();
        $final_id = $db->insert_id;
    }

    // معالجة الحساب والاسم والـ Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $split_name = preg_split('/[\s_-]+/', $name);
    $first_name = $split_name[0];
    $last_name = isset($split_name[1]) ? $split_name[1] : "";

    $action = $db->prepare("INSERT INTO Account (User_Name, Email, Password, Role_ID) VALUES (?, ?, ?, ?)");
    $action->bind_param("sssi", $name, $email, $hashed_password, $role_id);
    $succsess1 = $action->execute();

    if (!$succsess1) die('Account Error: ' . $action->error);

    $user_id = $db->insert_id;

    $action2 = $db->prepare("INSERT INTO Provider (First_Name, Last_Name, Phone_No, Governorate, User_ID) VALUES (?,?,?,?,?)");
    $action2->bind_param("ssssi", $first_name, $last_name, $phone_number, $location, $user_id);
    $succsess2 = $action2->execute();

    if (!$succsess2) die('Provider Error: ' . $action2->error);

    $provider_id = $db->insert_id;

    // ==========================================
    // 3️⃣ ← تحقق من الخدمة والترجمة التلقائية لحقولها
    // ==========================================
    $stmt2 = $db->prepare("
        SELECT Service_ID FROM service 
        WHERE Service_Name = ? 
           OR Service_Name_ar = ? 
           OR Service_Name_en = ?
    ");
    $stmt2->bind_param("sss", $service_Name, $service_Name, $service_Name);
    $stmt2->execute();
    $check2 = $stmt2->get_result();

    if ($check2->num_rows > 0) {
        $row = $check2->fetch_assoc();
        $service_id = $row['Service_ID'];
        $succsess3 = true;
    } else {
        // ترجمة اسم الخدمة تلقائياً بحسب فحص لغة النص
        $inputLangSvc = detectLang($service_Name);
        $otherLangSvc = ($inputLangSvc === 'ar') ? 'en' : 'ar';
        $svcTranslated = translateText($service_Name, $inputLangSvc, $otherLangSvc);

        $svc_name_ar = ($inputLangSvc === 'ar') ? $service_Name : $svcTranslated;
        $svc_name_en = ($inputLangSvc === 'en') ? $service_Name : $svcTranslated;

        $action3 = $db->prepare("
            INSERT INTO service (Service_Name, Service_Name_ar, Service_Name_en, Category_ID) 
            VALUES (?, ?, ?, ?)
        ");
        $action3->bind_param("sssi", $service_Name, $svc_name_ar, $svc_name_en, $final_id);
        $succsess3 = $action3->execute();

        if (!$succsess3) die('Service Error: ' . $action3->error);
        $service_id = $db->insert_id;
    }

    // إدخال تفاصيل حجز الخدمة للمزود داخل الـ Pivot Table (servicepro)
    $action4 = $db->prepare("INSERT INTO servicepro (Provider_ID, Service_ID, Service_Description, Price, Service_Description_ar, Service_Description_en, working_days, working_hours) VALUES (?,?,?,?,?,?,?,?)");
    $action4->bind_param("iisdssss", $provider_id, $service_id, $description, $price, $desc_ar, $desc_en, $working_days, $working_hours);
    $succsess4 = $action4->execute();

    if (!$succsess4) die('ServicePro Error: ' . $action4->error);

    // التحقق من نجاح كافة العمليات وتوجيه المستخدم
    if ($succsess1 && $succsess2 && $succsess3 && $succsess4) {
        $_SESSION['user_id'] =$user_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $hashed_password;
        $_SESSION['phone_number'] = $phone_number;
        $_SESSION['location'] = $location;

        $flage = 1;

        $_SESSION['status_message'] = "sucsses";
        $_SESSION['message'] = 'Account created successfully!\n Welcome ' . $name;

        header("location:dashboardProvider.php");
        exit();
    } else {
        $flage = -1;
        $_SESSION['status_message'] = "fail";
        $_SESSION['message'] = 'Registration failed. Please check your information and try again';
        header("location:providerSignup.php");
        exit();
    }
}
?>