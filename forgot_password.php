<?php
// forgot_password.php

require "config.php"; // استدعاء ملف الاتصال بقاعدة البيانات، هلق الكائن $db جاهز للاستخدام

$current_lang = $_SESSION['lang'] ?? 'ar';
$dir = ($current_lang == 'ar') ? 'rtl' : 'ltr';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $response = [
        'success' => false,
        'message' => ''
    ];

    $email = trim($_POST['email'] ?? '');
    $email = htmlspecialchars($email);

    if (empty($email)) {
        $response['message'] = $lang['email_required_error'] ?? 'الرجاء إدخال البريد الإلكتروني';
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = $lang['email_invalid_error'] ?? 'صيغة البريد الإلكتروني غير صحيحة';
    }
    else {
        $stmt = $db->prepare("SELECT User_ID FROM Account WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$response['success'] = true;
$response['message'] = $lang['reset_link_sent'] ?? 'إذا كان البريد الإلكتروني مسجلاً لدينا، فستتلقى رابطاً لإعادة تعيين كلمة المرور.';

if ($result->num_rows > 0) {
    // توليد البيانات كالمعتاد
    $token = bin2hex(random_bytes(32));
    $hashed_token = password_hash($token, PASSWORD_DEFAULT);
    $expires_at = date("Y-m-d H:i:s", strtotime("+60 minutes"));

    // حذف الطلبات القديمة (جدول password_resets أعمدته سليمة وتبدأ بأحرف صغيرة)
    $delete_stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
    $delete_stmt->bind_param("s", $email);
    $delete_stmt->execute();

    // إدخال الطلب الجديد
    $insert_stmt = $db->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    $insert_stmt->bind_param("sss", $email, $hashed_token, $expires_at);
    $insert_stmt->execute();

    // بناء الرابط وإرساله
    $reset_link = "https://palhomeservices.com/reset_password.php?token=" . $token . "&email=" . urlencode($email);

    $subject = "إعادة تعيين كلمة السر - PalHomeServices";
    $message = "اضغط على الرابط التالي لإعادة تعيين كلمة السر:\n" . $reset_link;
    $headers = "From: no-reply@palhomeservices.com";

    @mail($email, $subject, $message, $headers);
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
    <title><?php echo $lang['forgot_password_title'] ?? 'نسيت كلمة المرور'; ?></title>
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
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .form-box p {
            color: #777;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .form-box input[type="email"] {
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
        /* إخفاء عناصر الرسائل افتراضياً، وسيتم تفعيلها عبر الجافا سكريبت */
        .error-msg {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 10px;
            display: none; 
        }
        .success-msg {
            color: #27ae60;
            font-size: 14px;
            margin-bottom: 10px;
            display: none;
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
        <h2><?php echo $lang['forgot_password_title'] ?? 'نسيت كلمة السر؟'; ?></h2>
        <p><?php echo $lang['forgot_password_subtitle'] ?? 'أدخل بريدك الإلكتروني لإرسال رابط الاستعادة.'; ?></p>

        <div id="error-box" class="error-msg"></div>
        <div id="success-box" class="success-msg"></div>

        <form id="forgotPasswordForm">
            <input
                type="email"
                name="email"
                id="emailInput"
                placeholder="<?php echo $lang['email_placeholder'] ?? 'البريد الإلكتروني'; ?>"
                required
            >
            <button type="submit" id="submitBtn"><?php echo $lang['send_reset_link_btn'] ?? 'إرسال الرابط'; ?></button>
        </form>

        <a class="back-link" href="login.php"><?php echo $lang['back_to_login'] ?? 'العودة لتسجيل الدخول'; ?></a>
    </div>

    <script>
    document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
        e.preventDefault(); // منع الصفحة من عمل ريفريش وإرسال الفورم بالطريقة التقليدية

        // تجهيز عناصر الواجهة للتحكم بها
        const errorBox = document.getElementById('error-box');
        const successBox = document.getElementById('success-box');
        const submitBtn = document.getElementById('submitBtn');
        const emailInput = document.getElementById('emailInput');

        // إخفاء أي رسائل قديمة وتجهيز الزر لحالة التحميل
        errorBox.style.display = 'none';
        successBox.style.display = 'none';
        submitBtn.disabled = true;
        submitBtn.innerText = '...جاري الإرسال';

        // تجميع بيانات الفورم لإرسالها
        const formData = new FormData();
        formData.append('email', emailInput.value);

        // إرسال البيانات لنفس الملف الحالي باستخدام Fetch API
        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // التحقق من أن السيرفر رجع حالة سليمة وأنها بصيغة JSON
            if (!response.ok) {
                throw new Error('حدث خطأ في السيرفر');
            }
            return response.json();
        })
        .then(data => {
            // إعادة الزر لحالته الطبيعية
            submitBtn.disabled = false;
            submitBtn.innerText = '<?php echo $lang['send_reset_link_btn'] ?? 'إرسال الرابط'; ?>';

            if (data.success) {
                // إذا تمت العملية بنجاح، بنعرض رسالة النجاح وننظف الحقل
                successBox.innerText = data.message;
                successBox.style.display = 'block';
                emailInput.value = ''; 
            } else {
                // إذا رجع خطأ من التحققات داخل الـ PHP، بنعرض رسالة الخطأ
                errorBox.innerText = data.message;
                errorBox.style.display = 'block';
            }
        })
        .catch(error => {
            // التعامل مع أخطاء الشبكة أو السيرفر غير المتوقعة
            submitBtn.disabled = false;
            submitBtn.innerText = '<?php echo $lang['send_reset_link_btn'] ?? 'إرسال الرابط'; ?>';
            errorBox.innerText = 'عذراً، حدث خطأ أثناء الاتصال بالسيرفر. حاول مجدداً.';
            errorBox.style.display = 'block';
        });
    });
    </script>

</body>
</html>