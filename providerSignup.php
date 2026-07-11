<?php
require "config.php";
$currentLang = $_SESSION['lang'];
   $result=$db->query("SELECT * FROM category");
   $result2=$db->query("SELECT * FROM service");
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
    <!--رابط انواع الخط-->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <?php if ($_SESSION['lang'] === 'ar'): ?>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <?php endif; ?>
    <!--رابط الicon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--رابط  استدعاء المكتبة ل الاشعارات  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="style.css" rel="stylesheet">
    <link href="navbarStyle.css" rel="stylesheet">
    <title>
        <?php echo $lang['text']['provider_sign']?>
    </title>

    <style>
        html,
        body {
            min-height: 100%;
            width: 100%;
            background: linear-gradient(135deg, #EEEEEE 0%, #BFC9D1 100%);


        }

        .container {
            border-radius: 10px;
            text-align: center;
            border: 1px solid snow;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            margin-top: 20px;
        }

        form {
            text-align: start;
            padding: 10px;
        }

        /* بالوسط فقط: عنوان الصفحة والرابط تحت الفورم */
        .container .row > div[class*="col-"]:first-child > h1 {
            text-align: center;
        }

        .container .row > div[class*="col-"]:first-child > a[href="loginPage.php"] {
            display: block;
            text-align: center;
        }

        html[dir="rtl"] body,
        html[dir="rtl"] .form-control,
        html[dir="rtl"] .form-label,
        html[dir="rtl"] .input-group-text,
        html[dir="rtl"] #div2 {
            font-family: 'Cairo', 'Segoe UI', sans-serif;
        }

        #div2 {
            background-color: #0C7779;
            color: #EEEEEE;
            border-radius: 10px;
            text-align: start;
            padding: 50px;
        }

        #divpoint {
            margin-top: 50px;

        }

        #divpoint span {
            display: block;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            width: fit-content;
            box-shadow: 0 -1px rgba(255, 255, 255, 0.1);
            padding: 10px;
            margin: 10px;
            font-size: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.5s ease;

        }

        #divpoint span:hover {
            transform: translateY(-10px);
        }

        @media screen and (max-width: 768px) {
            .container {
                overflow-y: auto;
            }

            .modal-dialog {
                width: 450px;
                padding: 5px;
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
                        <a class="nav-link" href="aboutAs.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section4">How it works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboardCustomer.php">My bookings</a>
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
    

    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-8 col-lg-6">
                <h1>
                    <?php echo $lang['text']['sign_up']?>
                </h1>
                <form id="formj" action="registerProvider.php" method="post" enctype="multipart/form-data">
                    <label for="name" class="form-label fw-bold">
                        <?php echo $lang['lang']['user_name']?>
                    </label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                        <input type="text" name="name" id="name"
                            placeholder="<?php echo $lang['placeholder']['enter_name']?>" class="form-control mb-2"
                            required>
                    </div>



                    <label for="email" class="form-label fw-bold">
                        <?php echo $lang['lang']['email']?>
                    </label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email"
                            placeholder="<?php echo $lang['placeholder']['email_address']?>" class="form-control mb-2"
                            required>
                    </div>


                    <label for="phoneNumber" class="form-label fw-bold">
                        <?php echo $lang['lang']['phone_number']?>
                    </label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" name="phone_number" id="phoneNumber"
                            placeholder="<?php echo $lang['placeholder']['enter_phone']?>" class="form-control mb-2"
                            required>
                    </div>

                    <label for="password" class="form-label fw-bold">
                        <?php echo $lang['lang']['password']?>
                    </label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" id="password"
                            placeholder="<?php echo $lang['placeholder']['enter_password']?>" class="form-control mb-2"
                            required>
                    </div>

                    <label for="location" class="form-label fw-bold">
                        <?php echo $lang['lang']['location']?>
                    </label>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                        <input type="text" name="location" id="location"
                            placeholder="<?php echo $lang['placeholder']['enter_location']?>" class="form-control mb-2"
                            required>
                    </div>

                    


                    <button type="button" class="btn mb-3" data-bs-toggle="modal" data-bs-target="#modalService">
                        <?php echo $lang['lang']['service_type']?>
                    </button>
                    <div class="modal fade" id="modalService">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-titel text-center">
                                        <h2>
                                            <?php echo $lang['text']['modal-titel']?>
                                        </h2>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <label for="category-modal" class="form-label fw-bold">
                                        <?php echo $lang['lang']['modal-categorytype']?>
                                    </label>

                                    <div class="input-group mb-3">
                                        <input class="form-select" name="category-modal" id="category-modal"
                                            list="category-options" class="form-control mb-2"
                                            placeholder="<?php echo $lang['placeholder']['placeholder-categorytype']?>"
                                            required />
                                        <datalist id="category-options">
    <?php while($row = $result->fetch_assoc()){ ?>
    <option value="<?php echo $row['Category_Name_' . $currentLang] ?: $row['Category_Name']; ?>"></option>
    <?php } ?>
</datalist>
                                    </div>

                                    <label for="descriptioncate-modal" class="form-label fw-bold">
                                        <?php echo $lang['lang']['modal-description']?>
                                    </label>
                                    <div class="input-group flex-nowrap">
                                        <input type="text" name="descriptioncate-modal" id="descriptioncate-modal"
                                            class="form-control mb-2"
                                            placeholder="<?php echo $lang['placeholder']['category_description']?>" />
                                    </div>


                                    <label for="servicename-modal" class="form-label fw-bold">
                                        <?php echo $lang['lang']['modal-servicename']?>
                                    </label>
                                    <div class="input-group flex-nowrap">
                                        <input type="text" name="servicename-modal" id="servicename-modal"
                                            list="services-options" class="form-control mb-2"
                                            placeholder="<?php echo $lang['placeholder']['placeholder-servicename']?>"
                                            required />
                                        <datalist id="services-options">
    <?php while($row = $result2->fetch_assoc()){ ?>
    <option value="<?php echo $row['Service_Name_' . $currentLang] ?: $row['Service_Name']; ?>"></option>
    <?php } ?>
</datalist>
                                    </div>


                                    <label for="description-modal" class="form-label fw-bold">
                                        <?php echo $lang['lang']['modal-description']?>
                                    </label>
                                    <div class="input-group flex-nowrap">
                                        <input type="text" name="description-modal" id="description-modal"
                                            class="form-control mb-2"
                                            placeholder="<?php echo $lang['placeholder']['placeholder-description']?>"
                                            required />
                                    </div>
                                    <label for="price-modal" class="form-label fw-bold">
                                        <?php echo $lang['lang']['modal-price']?>
                                    </label>
                                    <div class="input-group flex-nowrap">
                                        <input type="number" name="price-modal" id="price-modal"
                                            class="form-control mb-2"
                                            placeholder="<?php echo $lang['placeholder']['placeholder-price']?>"
                                            required />
                                    </div>

                                    <label class="form-label fw-bold d-block mb-2">
                                        <?php echo $lang['lang']['modal-day'] ?>
                                    </label>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <?php $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                          foreach($days as $day){
                                         ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="working_days[]"
                                                value="<?php echo $day ?>" id="day-<?php echo $day ?>">
                                            <label class="form-check-label" for="day-<?php echo $day ?>">
                                                <?php echo $day ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="start-time" class="form-label fw-bold">
                                                <?php echo $lang['lang']['modal-hour'] ?> (من)
                                            </label>
                                            <input type="time" name="start_time" id="start-time"
                                                class="form-control mb-2" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end-time" class="form-label fw-bold">
                                                إلى
                                            </label>
                                            <input type="time" name="end_time" id="end-time" class="form-control mb-2"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" id="saveServiceBtn">
                                        <?php echo $lang['btn']['btn-save']?>
                                    </button>
                                    <button type="button" data-bs-dismiss="modal" class="btn">
                                        <?php echo $lang['btn']['btn-close']?>
                                    </button>

                                </div>


                            </div>
                        </div>

                    </div>
                        <button type="submit" name="submit" class="btn w-100" id="button">
                            <?php echo $lang['btn']['Subscribe_provider']?>
                        </button>
                </form>
                <a href="loginPage.php">
                    <?php echo $lang['link']['subscriber_before']?>
                </a>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-6" id="div2">
                <h2>
                    <?php echo $lang['text']['text-provider']?>
                </h2>
                <p><strong>
                        <?php echo $lang['text']['pargraph-provider']?>
                    </strong></p>


                <div id="divpoint">
                    <span class="badge rounded-pill ">
                        <?php echo $lang['text']['create-point1']?>
                    </span>
                    <span class="badge rounded-pill ">
                        <?php echo $lang['text']['create-point2']?>
                    </span>
                    <span class="badge rounded-pill ">
                        <?php echo $lang['text']['create-point3']?>
                    </span>
                </div>


            </div>

        </div>
    </div>

    <script>
        const saveBtn = document.getElementById('saveServiceBtn');
        const myModalElement = document.querySelector('#modalService');
        const myModalControl = new bootstrap.Modal(myModalElement);

        function modalBtnSave(event) {
            // منع السلوك الافتراضي
            event.preventDefault();

            let allValid = true;
            const inputs = myModalElement.querySelectorAll('[required]');

            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    allValid = false;
                    input.reportValidity();
                }
            });

            if (allValid) {
                myModalControl.hide();

            } else {
            }
        }

        if (saveBtn) {
            saveBtn.addEventListener('click', modalBtnSave);
        }
        const form = document.getElementById('formj');
        const phoneInput = document.getElementById('phoneNumber');

        function submitform(event) {
            if (!(phoneInput.value.startsWith('+970')) && !(phoneInput.value.startsWith('+972'))) {
                event.preventDefault(); // منع إرسال الفورم
                Swal.fire({
                    icon: 'warning',
                    title: "Notifications",
                    text: "Please enter the introduction",
                    confirmButtonColor: '#6FA4AF'
                });

            }
        }

        form.addEventListener('submit', submitform);

    

        <?php if (isset($_SESSION['message'])) {?>


            let status = "<?php echo $_SESSION['status_message']?>";
            let message = "<?php echo $_SESSION['message']?>";
            let flage = 0;

            let iconType;

            if (status === "sucsses") {
                iconType = "success";
            } else {
                iconType = "error";
            }

            if (flage === 1) {
                Swal.fire({
                    icon: iconType,
                    title: "Notifications",
                    text: message,
                    confirmButtonColor: '#6FA4AF'
                });
            } else {
                Swal.fire({
                    icon: iconType,
                    title: "Notifications",
                    text: message,
                    confirmButtonColor: '#6FA4AF'
                });
            }



        <?php }?>


        <?php if (!empty($_SESSION['message1'])) {?>

            Swal.fire({
                icon: 'error',
                title: "Notifications",
                text: "<?php echo $_SESSION['message1']?>",
                confirmButtonColor: '#6FA4AF'
            });
        
        <?php }?>
        <?php if (!empty($_SESSION['message2'])) {?>

            Swal.fire({
                icon: 'error',
                title: "Notifications",
                text: "<?php echo $_SESSION['message2']?>",
                confirmButtonColor: '#6FA4AF'
            });
        
        <?php }?>
       

        <?php if (!empty($_SESSION['message3'])) {?>

            Swal.fire({
                icon: 'error',
                title: "Notifications",
                text: "<?php echo $_SESSION['message3']?>",
                confirmButtonColor: '#6FA4AF'
            });
        
        <?php }?>
    </script>
</body>

</html>