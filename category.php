<?php
require "config.php";
require "translate_helper.php";
include "chatbot.php";

$currentLang = $_SESSION['lang'];
$result=$db->query("SELECT * FROM category");

?>

<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">

<head>
    <title>Categories page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

    <!--Bootstrap icon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!--رابط  استدعاء المكتبة ل الاشعارات  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="navbarStyle.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        section{
            padding: 30px;
            
        }
        #section1 {
            background: linear-gradient(135deg, #6FA4AF 0%, #8CC7C4 50%, #ECE7D1 100%);
            border-radius: 0 0 80px 80px;
            min-height: 400px;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        /* دوائر متحركة في خلفية section1 */
        #section1::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255,215,0,0.1);
            border-radius: 50%;
            top: -120px;
            right: -80px;
            animation: floatBg 8s ease-in-out infinite;
        }

        #section1::after {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            bottom: -90px;
            left: -60px;
            animation: floatBg 10s ease-in-out infinite reverse;
        }

        /* دوائر إضافية */
        #section1 .circle-bg {
            position: absolute;
            width: 120px;
            height: 120px;
            background: rgba(255,215,0,0.08);
            border-radius: 50%;
            top: 50%;
            left: 20%;
            animation: moveCircle 12s linear infinite;
        }
        
        /* تنسيق الأيكون في section1 */
        .bi-tools {
            font-size: 200px;
            color: rgba(255,255,255,0.9);
            text-shadow: 3px 3px 10px rgba(0,0,0,0.2);
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        /* تنسيق النص في section1 */
        #section1 strong {
            color: #0C7779 !important;
            font-size: 30px;
            text-shadow: 1px 1px 2px rgba(255,255,255,0.5);
        }

        #section1 p {
            color: #2C3E50;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* ========== تنسيق الكروت المعدل ========== */
        .row h2 {
            color: #0C7779;
            padding: 50px;
        }

        /* تنسيق الكارد الأساسي */
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            background: linear-gradient(135deg, #6FA4AF 0%, #8CC7C4 50%, #ECE7D1 100%);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* تدرجات مختلفة لكل كارد */
        .card:nth-child(1) {
            background: linear-gradient(135deg, #6FA4AF 0%, #8CC7C4 50%, #ECE7D1 100%);
        }

        .card:nth-child(2) {
            background: linear-gradient(135deg, #6FA4AF 0%, #8CC7C4 50%, #ECE7D1 100%);
        }

        .card:nth-child(3) {
            background: linear-gradient(1135deg, #6FA4AF 0%, #8CC7C4 50%, #ECE7D1 100%);
        }

        .card:nth-child(4) {
            background: linear-gradient(135deg, #6FA4AF 0%, #8CC7C4 50%, #ECE7D1 100%);
        }

        .card:nth-child(5) {
            background: linear-gradient(135deg, #6FA4AF 0%, #8CC7C4 50%, #ECE7D1 100%);
        }

        .card:nth-child(6) {
            background: linear-gradient(135deg, #6FA4AF 0%, #8CC7C4 50%, #ECE7D1 100%);
        }

        /* الدوائر المتحركة للكارد */
        .card::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255,215,0,0.15);
            border-radius: 50%;
            top: -100px;
            right: -80px;
            animation: float 6s ease-in-out infinite;
        }

        .card::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(12,119,121,0.15);
            border-radius: 50%;
            bottom: -70px;
            left: -70px;
            animation: float 8s ease-in-out infinite reverse;
        }

        /* دوائر إضافية داخل الكارد */
        .card .circle-card {
            position: absolute;
            width: 80px;
            height: 80px;
            background: rgba(255,215,0,0.1);
            border-radius: 50%;
            top: 20%;
            right: 10%;
            animation: moveCircle 10s linear infinite;
        }

        .card .circle-card2 {
            position: absolute;
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            bottom: 15%;
            left: 15%;
            animation: moveCircle 7s linear infinite reverse;
        }

        /* محتوى الكارد */
        .card-body {
            position: relative;
            z-index: 2;
            padding: 30px 20px;
            text-align: center;
        }

        .card-title {
            color: white !important;
            font-size: 1.8rem;
            font-weight: bold;
            margin: 15px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .card-text {
            color: rgba(255,255,255,0.9);
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        /* تنسيق الزر */
        .card .btn {
            background: white;
            color: #0C7779;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .card .btn:hover {
            transform: scale(1.05);
            background: #ECE7D1;
            color: #0C7779;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        /* تأثير hover على الكارد */
        .card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .card:hover::before {
            animation: float 4s ease-in-out infinite;
        }

        /* ========== الحركات العامة ========== */
        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-25px) translateX(15px);
            }
        }

        @keyframes floatBg {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-20px) translateX(10px);
            }
        }

        @keyframes moveCircle {
            0% {
                transform: translateX(0) translateY(0);
            }
            50% {
                transform: translateX(30px) translateY(-20px);
            }
            100% {
                transform: translateX(0) translateY(0);
            }
        }

        /* ========== باقي التنسيقات كما هي ========== */
        #navbar{
            background-color: #DCDCDC;
            display: flex;
            justify-content:flex-start;
            gap: 20px;
            position:fixed;
            z-index:10;
        }
        #navbar a{
            text-decoration: none;
            color: #0C7779;
        }
        #navbar a:hover{
            text-decoration:underline;
            color:black;
        }

        .btn{
            background-color: #0C7779;
            color: white;
        }

        .btn:hover{
            background-color: #547792;
            color: white;
        }

        #footerDiv{
            text-align: center;
            background-color: #2C3E50;
            min-height:100px;
            color: #8CC7C4;
            padding: 20px 40px;
        }

        .bi-house-gear{
            font-size: 20px;
            color:#0C7779 ;
        }

        @media (max-width: 576px){
            .bi-tools{
                font-size: 150px;
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
                    <a class="nav-link active" href="homePage.php"><?php echo $lang['link']['home-page'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category.php"><?php echo $lang['link']['services'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutAs.php"><?php echo $lang['link']['about_as'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#section4"><?php echo $lang['link']['how_work'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboardCustomer.php"><?php echo $lang['link']['my_booking'] ?></a>
                </li>
                <?php include __DIR__ . '/language_switcher.php'; ?>
                <li class="nav-item ms-lg-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="nav-link btn-login">Logout</a>
                    <?php else: ?>
                        <a href="loginPage.php" class="nav-link btn-login"><i class="bi bi-person-fill"></i><?php echo $lang['btn']['log_in'] ?></a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
</header>

    <main>
        <section id="section1"  class="container-fluid">
            <div class="circle-bg"></div>
            <div class="row align-items-center">
            <div  class="col-12 col-md-4 col-lg-6 text-center">

                <span><i class="bi bi-tools"></i></span>
            </div>
            <div class="col-12  col-md-8 col-lg-6"> 
            
                    <strong style="color:#E3E3E3; font-size:30px;"><?php echo $lang['text']['text_bold']?></strong>
                    <p>
                    <?php echo $lang['text']['text_paragraph']?>
                    </p>
                
            </div>
         </div>
        </section>


        <section id="section2" class="container text-center  ">
            <div class="row">
            <div class="col-12 text-center">
               <h2>
                <?php echo $lang['link']['services']?>
               </h2>
            </div>
            <?php while($row = $result->fetch_assoc()){?>
            <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                    <div class="card h-100  ">
                        <div class="card-body">
                            <h5 class="card-title"><?php 
                                    echo $row['Category_Name_' . $currentLang] ?: $row['Category_Name'];?></i></h5>
                            <p class="card-text"><?php 
                                    echo $row['category_description_' . $currentLang] ?: $row['category_description'];?>
                            </p>
                            <a href="service.php?id=<?php echo $row['Category_ID']?>" class="btn"><?php echo $lang['btn']['btn-details']?></a>
                        </div>
                    </div>
                </div>
            
                <?php }?>
            </div>
               
        </section>

    </main>


    <footer class="container">
        <div id="footerDiv">
                <p class="mb-1">&copy; 2026 PalHomeServices. جميع الحقوق محفوظة. تصميم وتطوير: [Leena]</p>
            </div>
  
    </footer>

    <script>
        <?php if(isset($_SESSION['error1'])){?>
            <script>
        Swal.fire({
                icon: 'error',
                title: "Notifications",
                text: "<?php echo $_SESSION['error1']?>",
                confirmButtonColor: '#6FA4AF'
            });
        </script>
        <?php
                unset($_SESSION['error1']);}
                
            ?>
    </script>




</body>


</html>