<?php
require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link href="navbarStyle.css" rel="stylesheet">
    
    <style>
        /* --- قسم الهيدر والناف بار الجديد (ابقِ عليه) --- */
        .navbar {
            background-color: #0C7779;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-radius: 50px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: white !important;
            font-family: 'Cairo', sans-serif;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #ECE7D1;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: #ECE7D1 !important;
        }

        .btn-login {
            background-color: #ECE7D1 !important;
            color: #0C7779 !important;
            border-radius: 20px;
            padding: 8px 25px !important;
            font-weight: bold;
        }
    </style>
</head>
<body>
        <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.php">
                    <img src="iconHome.jpg" alt="Logo" class="rounded-circle" width="50" height="50">
                    <span>PalHomeServices</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="homePage.php">
                                <?php echo $lang['link']['home-page']?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="category.php">
                                <?php echo $lang['link']['services']?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#section2">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#section4">How it works</a>
                        </li>
                        <?php include __DIR__ . '/language_switcher.php'; ?>
                        <li class="nav-item ms-lg-3">
                            <a class="nav-link btn-login" href="loginPage.php">
                                <i class="bi bi-person-fill"></i>
                                <?php echo $lang['btn']['log_in']?>
                            </a>
                        </li>
                    </ul>
                </div>
        </nav>
</body>
</html>
