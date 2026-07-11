<?php
require "config.php";
?>
<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - PalHomeServices</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet"/>
  <link href="navbarStyle.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Tajawal', sans-serif;
      background: #fafaf8;
      direction: rtl;
    }

    /* HERO */
    .hero-section {
      background: linear-gradient(135deg, #0d3d2e 0%, #1D6F5A 55%, #2A9B7F 100%);
      padding: 90px 0 100px;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      width: 500px; height: 500px;
      border-radius: 50%;
      border: 1px solid rgba(255,255,255,0.06);
      top: -120px; right: -100px;
      pointer-events: none;
    }

    .hero-section::after {
      content: '';
      position: absolute;
      width: 300px; height: 300px;
      border-radius: 50%;
      border: 1px solid rgba(255,255,255,0.04);
      bottom: -60px; left: 60px;
      pointer-events: none;
    }

    .hero-badge {
      display: inline-block;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      color: rgba(255,255,255,0.9);
      font-size: 12px;
      letter-spacing: 2px;
      padding: 6px 18px;
      border-radius: 20px;
      margin-bottom: 22px;
      font-weight: 500;
    }

    .hero-title {
      font-family: 'DM Serif Display', serif;
      font-size: 54px;
      color: #fff;
      line-height: 1.15;
    }

    .hero-title span { color: #9FE1CB; }

    .hero-sub {
      font-size: 17px;
      color: rgba(255,255,255,0.75);
      line-height: 1.9;
      font-weight: 300;
      max-width: 560px;
      margin: 0 auto 40px;
    }

    .stat-num {
      font-size: 34px;
      font-weight: 700;
      color: #fff;
      display: block;
    }

    .stat-label {
      font-size: 13px;
      color: rgba(255,255,255,0.6);
    }

    /* SECTION LABELS */
    .section-label {
      font-size: 11px;
      letter-spacing: 3px;
      color: #1D6F5A;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 10px;
    }

    .section-title {
      font-family: 'DM Serif Display', serif;
      font-size: 34px;
      color: #1a1a1a;
      line-height: 1.3;
    }

    .section-desc {
      font-size: 16px;
      color: #555;
      line-height: 1.9;
    }

    /* MISSION CARDS — النصف دائرة من اليسار */
    .mission-card {
      background: #fff;
      border: 0.5px solid rgba(0,0,0,0.08);
      border-radius: 16px;
      padding: 28px;
      height: 100%;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s;
    }

    .mission-card:hover { transform: translateY(-4px); }

    .mission-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;                      /* جهة اليسار */
      width: 70px;
      height: 70px;
      background: #E1F5EE;
      border-radius: 0 0 70px 0;   /* نصف دائرة تخرج من الزاوية اليسارية العليا */
    }

    .mission-icon {
      font-size: 30px;
      color: #1D6F5A;
      margin-bottom: 14px;
      display: block;
    }

    .mission-card h5 {
      font-size: 16px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 10px;
    }

    .mission-card p {
      font-size: 14px;
      color: #666;
      line-height: 1.8;
      margin: 0;
    }

    /* PROBLEM / SOLUTION */
    .problem-section { background: #fff; border-top: 0.5px solid rgba(0,0,0,0.07); border-bottom: 0.5px solid rgba(0,0,0,0.07); }

    .problem-list { list-style: none; padding: 0; margin: 0; }

    .problem-list li {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 13px 0;
      border-bottom: 0.5px solid rgba(0,0,0,0.07);
      font-size: 15px;
      color: #555;
      line-height: 1.6;
    }

    .problem-list li:last-child { border-bottom: none; }

    .prob-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: #D85A30;
      flex-shrink: 0;
      margin-top: 8px;
    }

    .chip {
      display: inline-block;
      background: #E1F5EE;
      color: #1D6F5A;
      font-size: 13px;
      font-weight: 500;
      padding: 7px 15px;
      border-radius: 20px;
      border: 1px solid rgba(29,111,90,0.15);
      margin: 4px;
    }

    /* FEATURES */
    .features-section { background: #fff; border-top: 0.5px solid rgba(0,0,0,0.07); }

    .feat-card {
      background: #fafaf8;
      border: 0.5px solid rgba(0,0,0,0.08);
      border-radius: 14px;
      padding: 22px;
      height: 100%;
      transition: background 0.2s;
    }

    .feat-card:hover { background: #E1F5EE; }

    .feat-icon {
      font-size: 24px;
      color: #1D6F5A;
      margin-bottom: 12px;
      display: block;
    }

    .feat-card h6 {
      font-size: 15px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 6px;
    }

    .feat-card p {
      font-size: 13px;
      color: #666;
      line-height: 1.7;
      margin: 0;
    }

    /* TEAM */
    .team-banner {
      background: linear-gradient(120deg, #0d3d2e 0%, #1D6F5A 100%);
      border-radius: 20px;
      padding: 40px 48px;
      color: white;
      display: flex;
      align-items: center;
      gap: 32px;
    }

    .team-avatar-big {
      width: 90px; height: 90px;
      border-radius: 50%;
      background: rgba(255,255,255,0.15);
      border: 2px solid rgba(255,255,255,0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      font-weight: 700;
      color: white;
      flex-shrink: 0;
      font-family: 'Tajawal', sans-serif;
    }

    .team-banner h3 {
      font-size: 22px;
      font-weight: 700;
      color: white;
      margin-bottom: 6px;
    }

    .team-banner .role-badge {
      display: inline-block;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.2);
      color: rgba(255,255,255,0.9);
      font-size: 12px;
      padding: 4px 14px;
      border-radius: 10px;
      margin-bottom: 12px;
    }

    .team-banner p {
      font-size: 15px;
      color: rgba(255,255,255,0.8);
      line-height: 1.8;
      margin: 0;
    }

    /* SUPERVISOR ROW */
    .supervisor-row {
      display: flex;
      align-items: center;
      gap: 18px;
      background: #fff;
      border: 0.5px solid rgba(0,0,0,0.08);
      border-radius: 14px;
      padding: 20px 24px;
      margin-top: 16px;
    }

    .sup-avatar {
      width: 52px; height: 52px;
      border-radius: 50%;
      background: #E1F5EE;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      font-weight: 700;
      color: #1D6F5A;
      flex-shrink: 0;
    }

    .supervisor-row h6 {
      font-size: 15px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 2px;
    }

    .supervisor-row p {
      font-size: 13px;
      color: #666;
      margin: 0;
      line-height: 1.6;
    }

    .sup-label {
      font-size: 11px;
      background: #E1F5EE;
      color: #1D6F5A;
      padding: 3px 10px;
      border-radius: 8px;
      font-weight: 600;
      margin-bottom: 4px;
      display: inline-block;
    }

    /* TECH */
    .tech-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #fff;
      border: 0.5px solid rgba(0,0,0,0.08);
      border-radius: 10px;
      padding: 9px 16px;
      font-size: 14px;
      font-weight: 500;
      color: #1a1a1a;
      margin: 4px;
    }

    .tech-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: #1D6F5A;
    }

    .tech-dot.accent { background: #D85A30; }
    .tech-dot.blue   { background: #185FA5; }

    /* FOOTER */
    .site-footer {
      background: #0d3d2e;
      color: rgba(255,255,255,0.7);
      font-size: 14px;
      line-height: 1.9;
    }

    .site-footer strong { color: #fff; }

    /* DIVIDER */
    .fancy-divider {
      height: 1px;
      background: linear-gradient(to left, transparent, rgba(0,0,0,0.08), transparent);
      margin: 0;
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

<!-- HERO -->
<section class="hero-section text-center">
  <div class="container position-relative">
    <div class="hero-badge"><?php echo $lang['about']['hero_badge'] ?></div>
    <h1 class="hero-title mb-3">PalHome<span>Services</span></h1>
    <p class="hero-sub mx-auto"><?php echo $lang['about']['hero_sub'] ?></p>
  </div>
</section>

<!-- ABOUT -->
<section class="py-5 my-3">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-7 text-center">
        <div class="section-label"><?php echo $lang['about']['about_label'] ?></div>
        <h2 class="section-title mb-3"><?php echo $lang['about']['about_title'] ?></h2>
        <p class="section-desc"><?php echo $lang['about']['about_desc'] ?></p>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="mission-card">
          <i class="bi bi-bullseye mission-icon"></i>
          <h5><?php echo $lang['about']['vision_title'] ?></h5>
          <p><?php echo $lang['about']['vision_text'] ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="mission-card">
          <i class="bi bi-rocket-takeoff mission-icon"></i>
          <h5><?php echo $lang['about']['mission_title'] ?></h5>
          <p><?php echo $lang['about']['mission_text'] ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="mission-card">
          <i class="bi bi-heart mission-icon"></i>
          <h5><?php echo $lang['about']['values_title'] ?></h5>
          <p><?php echo $lang['about']['values_text'] ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="mission-card">
          <i class="bi bi-flag mission-icon"></i>
          <h5><?php echo $lang['about']['identity_title'] ?></h5>
          <p><?php echo $lang['about']['identity_text'] ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="fancy-divider"></div>

<!-- PROBLEM / SOLUTION -->
<section class="problem-section py-5">
  <div class="container py-3">
    <div class="row g-5 align-items-start">
      <div class="col-lg-6">
        <div class="section-label"><?php echo $lang['about']['problem_label'] ?></div>
        <h3 class="section-title mb-4" style="font-size:28px"><?php echo $lang['about']['problem_title'] ?></h3>
        <ul class="problem-list">
          <li><span class="prob-dot"></span> <?php echo $lang['about']['prob1'] ?></li>
          <li><span class="prob-dot"></span> <?php echo $lang['about']['prob2'] ?></li>
          <li><span class="prob-dot"></span> <?php echo $lang['about']['prob3'] ?></li>
          <li><span class="prob-dot"></span> <?php echo $lang['about']['prob4'] ?></li>
          <li><span class="prob-dot"></span> <?php echo $lang['about']['prob5'] ?></li>
          <li><span class="prob-dot"></span> <?php echo $lang['about']['prob6'] ?></li>
        </ul>
      </div>
      <div class="col-lg-6">
        <div class="section-label"><?php echo $lang['about']['solution_label'] ?></div>
        <h3 class="section-title mb-3" style="font-size:28px"><?php echo $lang['about']['solution_title'] ?></h3>
        <p class="section-desc mb-4"><?php echo $lang['about']['solution_desc'] ?></p>
        <div>
          <span class="chip"><i class="bi bi-calendar-check me-1"></i> <?php echo $lang['about']['chip1'] ?></span>
          <span class="chip"><i class="bi bi-chat-dots me-1"></i> <?php echo $lang['about']['chip2'] ?></span>
          <span class="chip"><i class="bi bi-star me-1"></i> <?php echo $lang['about']['chip3'] ?></span>
          <span class="chip"><i class="bi bi-bell me-1"></i> <?php echo $lang['about']['chip4'] ?></span>
          <span class="chip"><i class="bi bi-person-check me-1"></i> <?php echo $lang['about']['chip5'] ?></span>
          <span class="chip"><i class="bi bi-translate me-1"></i> <?php echo $lang['about']['chip6'] ?></span>
          <span class="chip"><i class="bi bi-geo-alt me-1"></i> <?php echo $lang['about']['chip7'] ?></span>
          <span class="chip"><i class="bi bi-bar-chart me-1"></i> <?php echo $lang['about']['chip8'] ?></span>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="fancy-divider"></div>

<!-- FEATURES -->
<section class="features-section py-5">
  <div class="container py-3">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-6 text-center">
        <div class="section-label"><?php echo $lang['about']['features_label'] ?></div>
        <h2 class="section-title mb-3"><?php echo $lang['about']['features_title'] ?></h2>
      </div>
    </div>
    <div class="row g-3">
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <i class="bi bi-search feat-icon"></i>
          <h6><?php echo $lang['about']['feat1_title'] ?></h6>
          <p><?php echo $lang['about']['feat1_text'] ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <i class="bi bi-calendar2-check feat-icon"></i>
          <h6><?php echo $lang['about']['feat2_title'] ?></h6>
          <p><?php echo $lang['about']['feat2_text'] ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <i class="bi bi-shield-check feat-icon"></i>
          <h6><?php echo $lang['about']['feat3_title'] ?></h6>
          <p><?php echo $lang['about']['feat3_text'] ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <i class="bi bi-whatsapp feat-icon"></i>
          <h6><?php echo $lang['about']['feat4_title'] ?></h6>
          <p><?php echo $lang['about']['feat4_text'] ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <i class="bi bi-graph-up-arrow feat-icon"></i>
          <h6><?php echo $lang['about']['feat5_title'] ?></h6>
          <p><?php echo $lang['about']['feat5_text'] ?></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feat-card">
          <i class="bi bi-phone feat-icon"></i>
          <h6><?php echo $lang['about']['feat6_title'] ?></h6>
          <p><?php echo $lang['about']['feat6_text'] ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="fancy-divider"></div>

<!-- TEAM -->
<section class="py-5 my-2">
  <div class="container">
    <div class="section-label"><?php echo $lang['about']['team_label'] ?></div>
    <h2 class="section-title mb-2"><?php echo $lang['about']['team_title'] ?></h2>
    <p class="section-desc mb-5"><?php echo $lang['about']['team_desc'] ?></p>

    <div class="team-banner mb-3">
      <div class="team-avatar-big">ل.غ</div>
      <div>
        <span class="role-badge"><?php echo $lang['about']['dev_role'] ?></span>
        <h3><?php echo $lang['about']['dev_name'] ?></h3>
        <p><?php echo $lang['about']['dev_bio'] ?></p>
      </div>
    </div>

    <div class="supervisor-row">
      <div class="sup-avatar">S.H</div>
      <div>
        <span class="sup-label"><?php echo $lang['about']['sup_label'] ?></span>
        <h6><?php echo $lang['about']['sup_name'] ?></h6>
        <p><?php echo $lang['about']['sup_bio'] ?></p>
      </div>
    </div>
  </div>
</section>

<div class="fancy-divider"></div>

<!-- FOOTER -->
<footer class="site-footer py-5 text-center">
  <div class="container">
    <div class="mb-2"><strong><?php echo $lang['about']['footer_line1'] ?></strong></div>
    <div><?php echo $lang['about']['footer_line2'] ?></div>
    <div class="mt-2" style="font-size:12px; opacity:0.55"><?php echo $lang['about']['footer_line3'] ?></div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
