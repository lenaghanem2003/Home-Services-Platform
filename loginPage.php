<?php
require "config.php";

?>

<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($_SESSION['lang'] === 'ar'): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <?php else: ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--رابط  استدعاء المكتبة ل الاشعارات  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--رابط انواع الخط-->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <?php if ($_SESSION['lang'] === 'ar'): ?>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <?php endif; ?>
    <!--رابط الicon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="style.css" rel="stylesheet">
    <link href="navbarStyle.css" rel="stylesheet">
    <title>
        <?php echo $lang['text']['title']?>
    </title>

    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            background-color: #F3F4F4;
            overflow-x: hidden;
        }

        .container {
            position: relative;
            border-radius: 20px;
            width: 80%;
            height: 100%;
            margin: 5% 10%;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        #pargraph {
            background-color: #0C7779;
            padding: 40px;
            border-radius: 20px;
            color: white;

        }

        #pargraph img {
            width: 30%;
        }

        #sectionSignUp {
            transform: translateX(100%);
            opacity: 0;

        }

        section {
            position: absolute;
            width: 100%;
            height: 100%;
            transition: all 0.8s ease-in-out;
            text-align: center;
            justify-content: center;
        }

        .slide-out {
            transform: translateX(-100%) !important;
            opacity: 0 !important;
        }

        .slide-in {
            transform: translateX(0) !important;
            opacity: 1 !important;
            z-index: 3 !important;
        }

        #imgDiv {
            height: 100%;
            display: flex;
        }

        #imgDiv img {
            width: 100%;
            object-fit: cover;
            object-position: center;
            border-radius: 20px;
        }


        form {
            padding: 15px;
            display: flex;
            flex-direction: column;
            text-align: start;
            justify-content: center;

        }

        html[dir="rtl"] body,
        html[dir="rtl"] .form-control,
        html[dir="rtl"] .form-label,
        html[dir="rtl"] .input-group-text {
            font-family: 'Cairo', 'Segoe UI', sans-serif;
        }

        #login,
        #signUp {
            background-color: #EAEFEF;
            padding: 20px;
            border-radius: 20px;
            text-align: start;
        }

        /* بالوسط فقط: عنوان تسجيل الدخول / التسجيل والروابط تحت النموذج */
        #login h2,
        #signUp h2 {
            text-align: center;
        }

        #login > a,
        #signUp > a {
            display: block;
            text-align: center;
        }

        html[dir="rtl"] #sectionSignUp {
            transform: translateX(-100%);
        }

        html[dir="rtl"] .slide-out {
            transform: translateX(100%) !important;
        }

        .language{
            display: flex;
            justify-content: left;
        }
        @media (max-width: 576px) {

            #imgDiv {
                display: none;

            }
        }
    </style>

</head>

<body>
 
 <header id="header1">
    <nav class="navbar navbar-expand-lg navbar-dark">
            <h1 class="navbar-brand" href="index.php">
                <img src="iconHome.jpg" alt="Logo" class="rounded-circle" width="50" height="50">
                <span>PalHomeServices</span>
            </h1>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="homePage.php"><?php echo $lang['link']['home-page']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php"><?php echo $lang['link']['services']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutAs.php"><?php echo $lang['link']['about_as']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section4"><?php echo $lang['link']['how_work']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboardCustomer.php"><?php echo $lang['link']['my_booking']?></a>
                    </li>
                   <?php include __DIR__ . '/language_switcher.php'; ?>
                    <li class="nav-item ms-lg-3">
                        <?php if (isset($_SESSION['user_id'])): ?>
    <a href="logout.php" class="nav-link btn-login">Logout</a>
<?php else: ?>
    <a href="loginPage.php" class="nav-link btn-login"><i class="bi bi-person-fill"></i>Login</a>
<?php endif; ?>
                        
                    </li>
                </ul>
            </div>
    </nav>
</header>

    <main class="container">
        <section id="sectionLogin" class="row">
            <div id="pargraph" class="col-sm-12 col-lg-6">
                <img src="iconHome.jpg" alt="Icon home" class="img-fluid rounded-circle">
                <h1><em>
                        <?php echo $lang['text']['welcome']?>
                    </em></h1>
                <p>
                    <?php echo $lang['text']['paragraph']?>
                </p>

            </div>
            <div id="login" class="col-sm-12 col-lg-6">
                <h2>
                    <?php echo $lang['text']['login']?>
                </h2>
                <form action="login.php" method="POST" id="loginForm">
                    <label for="LoginEmail" class="form-label fw-bold">
                        <?php echo $lang['lang']['email']?>
                    </label>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="LoginEmail" class="form-control"
                            placeholder="<?php echo $lang['placeholder']['email_address']?>" required>
                    </div>

                    <label for="LoginPassword" class="form-label fw-bold">
                        <?php echo $lang['lang']['password']?>
                    </label>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" id="LoginPassword" class="form-control"
                            placeholder="<?php echo $lang['placeholder']['enter_password']?>" required>
                    </div>

                    

                    <input type="submit" class="btn w-100 mt-2" id="btnLog" name="submit"
                        value="<?php echo $lang['btn']['log_in']?>" />
                        

                
                </form>
                <a href="providerSignup.php">
                    <?php echo $lang['link']['register_provider']?>
                </a><br>

                <a href="loginPage.php" id="swapPage1">
                    <?php echo $lang['link']['create_account']?>
                </a>
            </div>

        </section>


        <section id="sectionSignUp" class="row">
            <div id="signUp" class="col-sm-12 col-md-8 col-lg-6">
                <h2>
                    <?php echo $lang['text']['sign_up']?>
                </h2>
                <form action="register.php" method="POST" id="signUpForm">
                    <label for="name" class="form-label fw-bold">
                        <?php echo $lang['lang']['user_name']?>
                    </label>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="<?php echo $lang['placeholder']['enter_name']?>" required>
                    </div>

                    <label for="signupEmail" class="form-label fw-bold">
                        <?php echo $lang['lang']['email']?>
                    </label>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="signupEmail" class="form-control"
                            placeholder="<?php echo $lang['placeholder']['email_address']?>" required>
                    </div>

                    <label for="number" class="form-label fw-bold">
                        <?php echo $lang['lang']['phone_number']?>
                    </label>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="tel" name="number" id="number" class="form-control"
                            placeholder="<?php echo $lang['placeholder']['enter_phone']?>" required>
                    </div>

                    <label for="signUpPassword" class="form-label fw-bold">
                        <?php echo $lang['lang']['password']?>
                    </label>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" id="signUpPassword" class="form-control"
                            placeholder="<?php echo $lang['placeholder']['enter_password']?>" required>
                    </div>

                    <label for="location" class="form-label fw-bold">
                        <?php echo $lang['lang']['location']?>
                    </label>
                    <div class="input-group flex-nowrap mb-2">
                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                        <input type="text" name="location" id="location" class="form-control"
                            placeholder="<?php echo $lang['placeholder']['placeoder_location']?>" required>
                    </div>
                    

                    <input type="submit" class="btn w-100 mt-3" value="<?php echo $lang['btn']['Subscribe_provider']?>"
                        name="submit" id="submit">

                </form>


                <a href="#" id="swapPage2">
                    <?php echo $lang['link']['already_account']?>
                </a>
            </div>
            <div id="imgDiv" class="col-sm-12 col-md-4 col-lg-6 p-0">
                <img src="homeImage.jpg" alt="Image" class="img-fluid">
            </div>
        </section>

    </main>


    <script>
        const sectionLogIn = document.querySelector('#sectionLogin');
        const sectionSignUp = document.querySelector('#sectionSignUp');
        const logInLink = document.querySelector('#swapPage1');// رابط الانتقال الى صفحة التسجيل 
        const signUpLink = document.querySelector('#swapPage2');//رابط الانتقال الى صفحة تسجيل الدخول

        function showSignUp(event) {
            event.preventDefault();//يمنع الurl من اعادة تحميل الصفحة
            sectionLogIn.classList.remove('slide-in');
            sectionLogIn.classList.add('slide-out');

            sectionSignUp.classList.remove('slide-out');
            sectionSignUp.classList.add('slide-in');

        }

        function showLogin(event) {
            event.preventDefault();

            sectionSignUp.classList.remove('slide-in');
            sectionSignUp.classList.add('slide-out');

            sectionLogIn.classList.remove('slide-out');
            sectionLogIn.classList.add('slide-in');


        }
        logInLink.addEventListener('click', showSignUp);
        signUpLink.addEventListener('click', showLogin);


        //التأكد من ملىء الحقول في الform الخاص بالlogin

        const loginForm = document.querySelector('#loginForm');
        const loginEmail = document.querySelector('#LoginEmail');
        const loginPassword = document.querySelector('#LoginPassword');

        function validation(event) {

            if (loginEmail.value.trim() === "" || loginPassword.value === "") {
                event.preventDefault();
                Swal.fire({
                    icon: "error",
                    title: "Notifications",
                    text: "Please fill in all fields!",
                    confirmButtonColor: '#6FA4AF'
                });

            }
        }

        loginForm.addEventListener('submit', validation);


        //التأكد من ملىء الحقول في الform الخاص sign up

        const signUPForm = document.querySelector('#signUpForm');
        const signname = document.querySelector('#name');
        const signEmail = document.querySelector('#signupEmail');
        const signPassword = document.querySelector('#signUpPassword');
        const signPhonenumber = document.querySelector('#number');
        const signlocation = document.querySelector('#location');

        function validation1(event) {

            if (signname.value.trim() === "" || signEmail.value === "" || signPassword.value === "" || signPhonenumber.value === "" || signlocation.value === "") {
                event.preventDefault();
                Swal.fire({
                    icon: "error",
                    title: "<?php echo $lang['text']['notifications']?>",
                    text: "<?php echo $lang['text']['fill_fields_error']?>",
                    confirmButtonColor: '#6FA4AF'
                });
            } else if (signPassword.value.length < 8) {
                event.preventDefault();
                Swal.fire({
                    icon: "error",
                    title: "Notifications",
                    text: "Password must be at least 8 characters",
                    confirmButtonColor: '#6FA4AF'
                });
            } else if (signPassword.value === signPassword.value.toLowerCase()) {
                event.preventDefault();
                Swal.fire({
                    icon: "error",
                    title: "Notifications",
                    text: "Password must contain at least one uppercase letter",
                    confirmButtonColor: '#6FA4AF'
                });
            }else if(!(signPhonenumber.value.startsWith('+970')) && !(signPhonenumber.value.startsWith('+972'))){
                event.preventDefault(); // منع إرسال الفورم
                Swal.fire({
                    icon: 'warning',
                    title: "Notifications",
                    text: "Please enter the introduction",
                    confirmButtonColor: '#6FA4AF'
                });

            }
        }

        signUPForm.addEventListener('submit', validation1);

    </script>

    <!--الاشعارات الخاصة بصفحة الlogin-->
    <?php 
           if(isset($_SESSION['message'])){?>
    <script>
        let messge1 = "<?php echo $_SESSION['message']?>";
        let status = "<?php echo $_SESSION['status_message']?>";
        let flage = 0;

        let iconType;

        if (status === "sucsses") {
            iconType = "success";
        } else {
            iconType = "error";
        }
        if (status === "fail") {
            flage = 2;
            Swal.fire({
                icon: iconType,
                title: "Notifications",
                text: messge1,
                confirmButtonColor: '#6FA4AF'
            });
        } else {
            flage = -1;
            Swal.fire({
                icon: iconType,
                title: "Notifications",
                text: messge1,
                confirmButtonColor: '#6FA4AF'
            });
        }
    </script>
    <?php
                unset($_SESSION['message']);
                unset($_SESSION['status_message']);}
                
            ?>

    <?php
            if(isset($_SESSION['submit'])){?>

    <script>
        let message = "<?php echo $_SESSION['message']?>";
        let status1 = "<?php echo $_SESSION['status_message']?>";
        let flage = 0;

        let iconType;

        if (status1 === "sucsses") {
            iconType = "success";
        } else {
            iconType = "error";
        }
        if (status1 === "sucsses") {
            flage = 1;
            Swal.fire({
                icon: iconType,
                title: "Notifications",
                text: message,
                confirmButtonColor: '#6FA4AF'
            });
        } else {
            flage = -1;
            Swal.fire({
                icon: iconType,
                title: "Notifications",
                text: messge1,
                confirmButtonColor: '#6FA4AF'
            });
        }
    </script>

    <?php
                unset($_SESSION['message']);
                unset($_SESSION['status_message']);}
                
            ?>

        <?php if(isset($_SESSION['error'])){?>
        <script>
        Swal.fire({
                icon: 'error',
                title: "Notifications",
                text: "<?php echo $_SESSION['error']?>",
                confirmButtonColor: '#6FA4AF'
            });
        </script>
        <?php
                unset($_SESSION['error']);}
                
            ?>


</body>

</html>