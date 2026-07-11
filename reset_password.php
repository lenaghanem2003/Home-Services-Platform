<?php
// reset_password.php

require "config.php"; 

$current_lang = $_SESSION['lang'] ?? 'ar';
$dir = ($current_lang == 'ar') ? 'rtl' : 'ltr';

$error_message = "";
$token_valid = false; 

$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

// الفحص المبدئي للرابط (GET) باستخدام نفس الأسلوب الكائني
if (empty($token) || empty($email)) {
    $error_message = $lang['invalid_token_error'] ?? 'رابط غير صالح أو منتهي الصلاحية.';
} else {
    // جلب التوكن باستخدام كائن $db وطريقة السهم
    $stmt = $db->prepare("SELECT * FROM password_resets WHERE email = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc(); // جلب المصفوفة بالأسلوب الكائني

    if ($row && password_verify($token, $row['token'])) {
        $token_valid = true; 
    } else {
        $error_message = $lang['invalid_token_error'] ?? 'رابط غير صالح أو منتهي الصلاحية.';
    }
}

// معالجة تحديث كلمة السر (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $response = [
        'success' => false,
        'message' => ''
    ];

    if (!$token_valid) {
        $response['message'] = $lang['invalid_token_error'] ?? 'رابط غير صالح أو منتهي الصلاحية.';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($new_password) || empty($confirm_password)) {
        $response['message'] = $lang['password_required_error'] ?? 'الرجاء تعبئة جميع الحقول.';
    }
    elseif (strlen($new_password) < 8) {
        $response['message'] = $lang['password_length_error'] ?? 'يجب أن تكون كلمة المرور مكونة من 8 أحرف على الأقل.';
    }
    elseif ($new_password !== $confirm_password) {
        $response['message'] = $lang['password_mismatch_error'] ?? 'كلمات المرور غير متطابقة.';
    }
    else {
       // ... داخل شرط الـ POST في جملة الـ else بعد تشفير كلمة السر الجديدة

$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// تعديل الاستعلام ليتوافق مع جدول Account وأعمدته (Password و Email)
$update_stmt = $db->prepare("UPDATE Account SET Password = ? WHERE Email = ?");
$update_stmt->bind_param("ss", $hashed_password, $email);

if ($update_stmt->execute()) {
    // حذف الرمز المستعمل من جدول الاستعادة
    $delete_stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
    $delete_stmt->bind_param("s", $email);
    $delete_stmt->execute();

    $response['success'] = true;
    $response['message'] = $lang['password_updated_success'] ?? 'تم تحديث كلمة المرور بنجاح.';
} else {
    $response['message'] = 'حدث خطأ أثناء تحديث البيانات، حاول مجدداً.';
}
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>" dir="<?php echo $dir; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang['reset_password_title'] ?? 'إعادة تعيين كلمة السر'; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        .form-box h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .form-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-box button {
            width: 100%;
            padding: 10px;
            background-color: #27ae60;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-box button:hover {
            background-color: #219150;
        }
        .error-msg {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 10px;
            /* إذا كان الخطأ جاي من سيرفر الـ GET بنظهره فوراً، غير هيك بكون مخفي */
            display: <?php echo !empty($error_message) ? 'block' : 'none'; ?>; 
        }
        .success-msg {
            color: #27ae60;
            font-size: 14px;
            margin-bottom: 10px;
            display: none; /* مخفي افتراضياً وبظهر بالجافا سكريبت */
        }
        .back-link {
            display: block;
            margin-top: 15px;
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="form-box">
        <h2><?php echo $lang['lang']['reset_password_title'] ?? 'إعادة تعيين كلمة السر'; ?></h2>

        <div id="error-box" class="error-msg"><?php echo $error_message; ?></div>
        <div id="success-box" class="success-msg"></div>

        <form id="resetPasswordForm" style="display: <?php echo $token_valid ? 'block' : 'none'; ?>;">
            <input
                type="password"
                name="new_password"
                id="newPasswordInput"
                placeholder="<?php echo $lang['lang']['new_password_label'] ?? 'كلمة السر الجديدة'; ?>"
                required
            >

            <input
                type="password"
                name="confirm_password"
                id="confirmPasswordInput"
                placeholder="<?php echo $lang['lang']['confirm_password_label'] ?? 'تأكيد كلمة السر'; ?>"
                required
            >

            <button type="submit" id="submitBtn"><?php echo $lang['lang']['reset_password_btn'] ?? 'تحديث كلمة السر'; ?></button>
        </form>

        <a id="request-link" class="back-link" href="forgot_password.php" style="display: <?php echo !$token_valid ? 'block' : 'none'; ?>;">
            <?php echo $lang['lang']['request_new_link'] ?? 'طلب رابط جديد'; ?>
        </a>
        
        <a id="login-link" class="back-link" href="loginPage.php">
            <?php echo $lang['lang']['back_to_login'] ?? 'العودة لتسجيل الدخول'; ?>
        </a>
    </div>

    <script>
    // منربط الحدث بالفورم في حال كان ظاهراً
    const form = document.getElementById('resetPasswordForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // منع الصفحة من عمل ريفريش

            const errorBox = document.getElementById('error-box');
            const successBox = document.getElementById('success-box');
            const submitBtn = document.getElementById('submitBtn');
            const loginLink = document.getElementById('login-link');
            const requestLink = document.getElementById('request-link');

            // إخفاء الرسائل السابقة وتجهيز حالة الزر
            errorBox.style.display = 'none';
            successBox.style.display = 'none';
            submitBtn.disabled = true;
            submitBtn.innerText = '...جاري التحديث';

            // تجميع البيانات لإرسالها
            const formData = new FormData();
            formData.append('new_password', document.getElementById('newPasswordInput').value);
            formData.append('confirm_password', document.getElementById('confirmPasswordInput').value);

            // إرسال البيانات لنفس الرابط (يلي بيحتوي على الـ GET parameters أصلاً عشان الـ API يتعرف عليها)
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('حدث خطأ في السيرفر');
                }
                return response.json();
            })
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerText = '<?php echo $lang['lang']['reset_password_btn'] ?? 'تحديث كلمة السر'; ?>';

                if (data.success) {
                    // في حال النجاح: نظهر رسالة النجاح، نخفي الفورم ورابط الطلب الجديد، ونظهر رابط تسجيل الدخول
                    successBox.innerText = data.message;
                    successBox.style.display = 'block';
                    form.style.display = 'none';
                    requestLink.style.display = 'none';
                    loginLink.style.display = 'block';
                } else {
                    // في حال فشل التحققات بالخلفية
                    errorBox.innerText = data.message;
                    errorBox.style.display = 'block';
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerText = '<?php echo $lang['lang']['reset_password_btn'] ?? 'تحديث كلمة السر'; ?>';
                errorBox.innerText = 'عذراً، حدث خطأ أثناء الاتصال بالسيرفر. حاول مجدداً.';
                errorBox.style.display = 'block';
            });
        });
    }
    </script>

</body>
</html>