<?php
require "config.php";
include "chatbot.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">

<head>
    <title>Home page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="navbarStyle.css" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        height: 100%;
        width: 100%;
        background-color: #DCDCDC;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    
    .hero-section {
        position: relative;
        width: 100%;
        height: 80vh; /* طول القسم 80% من طول الشاشة */
        background-image: url('picture.jpg'); /* الصورة الخلفية */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center; /* تتسيط المحتوى عمودياً */
        justify-content: center; /* تتسيط المحتوى أفقياً */
        margin-bottom: 80px; /* مسافة عن القسم التالي */
    }

    /* طبقة زجاجية داكنة فوق الصورة لضمان وضوح النص الأبيض */
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* لون أسود شفاف بنسبة 50% */
        z-index: 1;
    }

    /* حاوية المحتوى النصي فوق الطبقة الشفافة */
    .hero-content {
        position: relative;
        z-index: 2; /* فوق الـ overlay */
        text-align: center;
        color: white;
        padding: 0 20px;
        max-width: 800px; /* عرض محدد للنص لسهولة القراءة */
    }

    .hero-content h2 {
        color: white !important; /* تغيير لون العنوان للأبيض */
        font-size: 3rem; /* حجم خط كبير للعنوان */
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5); /* ظل خفيف للنص لزيادة الوضوح */
    }

    /* تنسيق أزرار الـ Hero Section لتكون بارزة */
    .hero-btn-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap; /* للسماح للأزرار بالنزول لسطر جديد على الموبايل */
        margin-top: 30px;
    }

    .btn-hero {
        background-color: #ECE7D1; /* لون بيج فاتح */
        color: #0C7779 !important; /* لون النص كحلي */
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 30px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        margin-top: 0; /* إلغاء المارجن القديم */
    }

    .btn-hero:hover {
        background-color: transparent;
        color: white !important;
        border-color: #ECE7D1;
        transform: translateY(-3px);
    }

    /* الزر الثالث المميز (تصفح كزائر) */
    .btn-visitor {
        background-color: transparent;
        border: 2px solid white;
        color: white !important;
    }

    .btn-visitor:hover {
        background-color: white;
        color: #0C7779 !important;
    }

    /* --- تنسيقات المحتوى العامة --- */
    h2, strong { color: #0C7779; }

    .btn {
        background-color: #0C7779;
        margin-top: 10px;
        color: white;
    }

    .btn:hover { background-color: #ECE7D1; }

    #link {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    #link-btn {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    /* --- تنسيق الصور المداخلة --- */
    #image img { width: 250px; position: relative; }
    #image2 { position: absolute; z-index: 1; }
    #image1 { position: absolute; z-index: 2; left: 150px; top: 100px; }

    /* ===== تعديل خاص باللغة العربية: إخفاء الصورة الثانية وتعديل موضع الأولى لتبدو منسقة عند تفعيل الـ RTL ===== */
    [dir="rtl"] #image2 {
        display: none !important;
    }
    [dir="rtl"] #image1 {
        position: relative !important;
        left: auto !important;
        top: auto !important;
        display: block;
        margin: 0 auto;
    }

    main section { margin-bottom: 100px; }

    .card {
        background-color: #F9F3EF;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        height: auto; /* تم تعديله من 200px ليكون مرناً مع المحتوى */
        padding: 20px;
    }

    footer { background-color: black; color: white; padding: 40px 0; }
    .list-unstyled a { color: white; text-decoration: none; }
    .list-unstyled a:hover { color: #0C7779; }

    /* --- الشاشات الصغيرة --- */
    @media (max-width: 576px) {
        #image img { width: 180px; padding-bottom: 150px; }
        #image1 { left: 50px; top: 50px; } /* تعديل الموقع ليناسب الموبايل */

        .hero-section { height: 60vh; }
        .hero-content h2 { font-size: 2rem; }
        .hero-btn-group { gap: 10px; }
        .btn-hero { padding: 10px 20px; font-size: 0.9rem; }
   
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
                    </td>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php"><?php echo $lang['link']['services']?></a>
                    </td>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutAs.php"><?php echo $lang['link']['about_as']?></a>
                    </td>
                    <li class="nav-item">
                        <a class="nav-link" href="#section4"><?php echo $lang['link']['how_work']?></a>
                    </td>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboardCustomer.php"><?php echo $lang['link']['my_booking']?></a>
                    </td>
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

    <section class="hero-section">
        <div class="hero-overlay"></div>
         <div class="hero-content">
            <h2><?php echo $lang['text']['save_time']?></h2>
            
            <div class="hero-btn-group">
                <a href="providerSignup.php" class="btn-hero">
                    <i class="bi bi-briefcase"></i> <?php echo $lang['btn']['become_provider']?>
                </a>
                
                <a href="category.php" class="btn-hero">
                    <i class="bi bi-calendar-event"></i> <?php echo $lang['btn']['book_service']?>
                </a>

                <a href="category.php?view=guest" class="btn-hero btn-visitor">
                    <i class="bi bi-eye"></i> <?php echo $lang['lang']['gusset']?>
                </a>
            </div>
        </div>
    </section>
    <main class="container">
        <section id="section2" class="row">
            <div id="text" class="col-sm-6 col-md-6  col-lg-6">
                <h2><?php echo $lang['text']['about_us_title']?></h2>
                <p><?php echo $lang['text']['about_us_text']?></p>

            </div>
            <div id="image" class="col-sm-6 col-md-6 col-lg-6 ">
                <img id="image1" src="p5.jpg" class="rounded" alt="image1" />
                <img id="image2" src="p6.jpg" class="rounded" alt="image2" />
            </div>
        </section>

        <section id="section3" class="row">
    <h2><?php echo $lang['text']['rating_title']?></h2>

    <div id="ratingsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        
        <div class="carousel-indicators" id="carouselIndicators"></div>

        <div class="carousel-inner" id="carouselInner"></div>

        <button class="carousel-control-prev" type="button" data-bs-target="#ratingsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#ratingsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</section>

        <section id="section4" class="row">
            <h2><?php echo $lang['text']['how_it_works_title']?></h2>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <span><i class="bi bi-search"></i></span>
                        <h5 class="card-title"><?php echo $lang['text']['step1_title']?> </h5>
                        <p class="card-text"><?php echo $lang['text']['step1_text']?></p>
                    </div>
                </div>

            </div>


            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <span><i class="bi bi-person-check"></i></span>
                        <h5 class="card-title"> <?php echo $lang['text']['step2_title']?> </h5>
                        <p class="card-text"> <?php echo $lang['text']['step2_text']?></p>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <span><i class="bi bi-calendar-check"></i></span>
                        <h5 class="card-title">  <?php echo $lang['text']['step3_title']?> </h5>
                        <p class="card-text">  <?php echo $lang['text']['step3_text']?> </p>
                    </div>
                </div>
            </div>

        </section>

    </main>


    <footer class="container-fluid">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>PalHomeServices</h5>
                <p> <?php echo $lang['text']['pal_home_text']?></p>
                <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="text-white"><i class="bi bi-whatsapp"></i></a>

            </div>

            <div class="col-md-2 mb-4">
                <h5> <?php echo $lang['text']['quick_links']?> </h5>
                <ul class="list-unstyled">
                    <li><a href="homePage.html"><?php echo $lang['link']['home-page']?></a></li>
                    <li><a href="#"><?php echo $lang['link']['services']?></a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h5><?php echo $lang['text']['contact_us']?></h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-telephone"></i> +970 59 123 4567</li>
                    <li><i class="bi bi-geo-alt"></i> <?php echo $lang['text']['country']?></li>
                </ul>
            </div>

            <hr class="bg-light">
            <div class="text-center">
                <p class="mb-1">&copy; 2026 PalHomeServices. جميع الحقوق محفوظة. تصميم وتطوير: [Leena]</p>
            </div>
        </div>
    </footer>


    <?php 
           if(isset($_SESSION['message'])){?>
    <script>
        let messge1 = "<?php echo $_SESSION['message']?>";
        let status = "<?php echo $_SESSION['status_message']?>";

            Swal.fire({
                icon: "success",
                title: "Notifications",
                text: messge1,
                confirmButtonColor: '#6FA4AF'
});
        </script>
        

<?php
     
      unset($_SESSION['message']);
      unset($_SESSION['status_message']);
      
    } ?>

    <script>
        // دالة 1: مسؤولة عن جلب البيانات من الباك
    function getRatings() {
    fetch("selectRating.php?lang=<?php echo $_SESSION['lang']; ?>")
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.status == "success") {
                displayRatings(data.ratings);
            }
        })
        .catch(function (error) {
            console.log("خطأ: ", error);
        });
    }
    // دالة 2: مسؤولة عن بناء وعرض الكاردز
function displayRatings(ratings) {

    let inner      = document.getElementById("carouselInner");
    let indicators = document.getElementById("carouselIndicators");

    inner.innerHTML      = "";
    indicators.innerHTML = "";

    // تقسيم التقييمات لمجموعات كل مجموعة 3
    let groups = [];
    for (let i = 0; i < ratings.length; i += 3) {
        groups.push(ratings.slice(i, i + 3));
    }

    groups.forEach(function (group, index) {

        // بناء النقطة
        let dot = `<button type="button" 
                        data-bs-target="#ratingsCarousel" 
                        data-bs-slide-to="${index}"
                        class="${index === 0 ? 'active' : ''}"
                        style="background-color: #0C7779;">
                   </button>`;
        indicators.innerHTML += dot;

        // بناء الكاردز للمجموعة
        let cards = "";
        group.forEach(function (rating) {

            // النجوم
            let stars = "";
            for (let i = 1; i <= 5; i++) {
                if (i <= rating.Score) {
                    stars += '<i class="bi bi-star-fill" style="color: gold;"></i>';
                } else {
                    stars += '<i class="bi bi-star" style="color: gold;"></i>';
                }
            }

            // التعليق
            let comment = "";
            if (rating.Comment && rating.Comment.trim() != "") {
                comment = `<p class="card-text">"${rating.Comment}"</p>`;
            }

            cards += `
                <div class="col-sm-12 col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">${rating.Customer_Name}</h5>
                            <h6 class="card-subtitle mb-2">${stars}</h6>
                            ${comment}
                        </div>
                    </div>
                </div>`;
        });

        // بناء الـ slide
        let slide = `
            <div class="carousel-item ${index === 0 ? 'active' : ''}">
                <div class="row justify-content-center px-5">
                    ${cards}
                </div>
            </div>`;

        inner.innerHTML += slide;
    });
}

    document.addEventListener("DOMContentLoaded", function () {
    getRatings();
    });
    </script>


</body>

</html>