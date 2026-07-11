<?php
require "config.php";           // اتصال قاعدة البيانات
?>
<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo $lang['provider_dash']['page_title']; ?></title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>

    <link href="navbarStyle.css" rel="stylesheet">
  <style>
    /* ============================================
   style.css — Service Provider Dashboard
   ============================================ */

/* --- Google Font & Base Reset --- */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  background-color: #f4f7f9;
  color: #333;
}

/* ============================================
   SIDEBAR STYLES
   ============================================ */
.sidebar {
  width: 250px;
  min-height: 100vh;
  background: linear-gradient(180deg, #0C7779 0%, #085e60 100%);
  color: white;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  transition: transform 0.3s ease;
  display: flex;
  flex-direction: column;
  margin-top:80px;
}

.sidebar-brand {
  padding: 20px 20px 10px 20px;
  color: white;
  letter-spacing: 0.5px;
}

.sidebar-user {
  padding: 10px 20px;
}

.sidebar-user img {
  border: 3px solid rgba(255, 255, 255, 0.3);
}

.sidebar-divider {
  border-color: rgba(255, 255, 255, 0.15);
  margin: 5px 15px;
}

.sidebar-nav .nav-link {
  color: rgba(255, 255, 255, 0.8);
  border-radius: 10px;
  padding: 10px 15px;
  font-size: 0.9rem;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  cursor: pointer;
}

.sidebar-nav .nav-link.active,
.sidebar-nav .nav-link:hover {
  background-color: rgba(255, 255, 255, 0.15);
  color: white;
  text-decoration: none;
}

.sidebar-nav .logout-link {
  color: rgba(255, 150, 150, 0.9);
}

.sidebar-nav .logout-link:hover {
  background-color: rgba(255, 100, 100, 0.2);
  color: #ffaaaa;
}

/* ============================================
   MAIN CONTENT AREA
   ============================================ */
.main-content {
  margin-left: 250px;
  padding: 30px 25px;
  min-height: 100vh;
  transition: margin-left 0.3s ease;
}

.page-header {
  background: white;
  border-radius: 16px;
  padding: 18px 22px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

/* ============================================
   STAT CARDS
   ============================================ */
.stat-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  cursor: default;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
}

.stat-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.bg-primary-soft { background-color: #e0f0ff; }
.bg-teal-soft    { background-color: #d4f0f0; }
.bg-success-soft { background-color: #d4edda; }
.bg-warning-soft { background-color: #fff3cd; }
.text-teal       { color: #0C7779 !important; }

.btn-teal {
  background-color: #0C7779;
  color: white;
  border: none;
}
.btn-teal:hover {
  background-color: #085e60;
  color: white;
}

/* ============================================
   TABLE STYLES
   ============================================ */
.table th {
  font-size: 0.82rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #888;
}
.table td {
  font-size: 0.88rem;
  vertical-align: middle;
}

.btn-whatsapp {
  background-color: #25D366;
  color: white;
  border: none;
  border-radius: 20px;
  padding: 4px 12px;
  font-size: 0.8rem;
  transition: background-color 0.2s;
  text-decoration: none;
  display: inline-block;
}
.btn-whatsapp:hover {
  background-color: #1ebe5a;
  color: white;
}

/* ============================================
   STATUS BADGES
   ============================================ */
.badge-confirmed {
  background-color: #d1ecf1; color: #0c5460;
  padding: 5px 12px; border-radius: 20px;
  font-size: 0.78rem; font-weight: 500;
}
.badge-pending {
  background-color: #fff3cd; color: #856404;
  padding: 5px 12px; border-radius: 20px;
  font-size: 0.78rem; font-weight: 500;
}
.badge-completed {
  background-color: #d4edda; color: #155724;
  padding: 5px 12px; border-radius: 20px;
  font-size: 0.78rem; font-weight: 500;
}
.badge-rejected {
  background-color: #f8d7da; color: #721c24;
  padding: 5px 12px; border-radius: 20px;
  font-size: 0.78rem; font-weight: 500;
}

.dot {
  display: inline-block;
  width: 10px; height: 10px;
  border-radius: 50%;
  margin-right: 6px;
}

/* ============================================
   TOP NAVBAR (Mobile Only)
   ============================================ */
.top-navbar {
  background: linear-gradient(90deg, #0C7779, #085e60);
  position: sticky;
  top: 0;
  z-index: 1100;
}

.sidebar-overlay {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
}
.sidebar-overlay.active { display: block; }

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 991px) {
  .sidebar { transform: translateX(-100%); }
  .sidebar.open { transform: translateX(0); }
  .main-content { margin-left: 0; padding: 15px; }
  .page-header {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 5px;
  }
}
@media (max-width: 575px) {
  h4 { font-size: 1.1rem; }
  .stat-card h4 { font-size: 1.4rem; }
}

/* ============================================
   EDIT PROFILE — NEW STYLES ADDED BELOW
   (لم نغير أي شي من فوق، فقط أضفنا هنا)
   ============================================ */

.profile-avatar-box {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #d4f0f0;
}

.profile-section-title {
  font-size: 0.78rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #0C7779;
  border-bottom: 2px solid #d4f0f0;
  padding-bottom: 6px;
  margin-bottom: 16px;
}

.profile-input {
  border: 1.5px solid #e2e8f0;
  border-radius: 10px;
  padding: 9px 14px;
  font-size: 0.88rem;
  font-family: 'Poppins', sans-serif;
  background-color: #fafcfc;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.profile-input:focus {
  border-color: #0C7779;
  box-shadow: 0 0 0 3px rgba(12, 119, 121, 0.1);
  background-color: #fff;
  outline: none;
}

.profile-card-section {
  background: white;
  border-radius: 16px;
  padding: 22px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  margin-bottom: 20px;
  transition: box-shadow 0.2s;
}
.profile-card-section:hover {
  box-shadow: 0 4px 18px rgba(0,0,0,0.08);
}

.time-slot-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: 1.5px solid #e2e8f0;
  border-radius: 10px;
  padding: 7px 12px;
  font-size: 0.83rem;
  cursor: pointer;
  background: #fafcfc;
  transition: all 0.18s ease;
  user-select: none;
  margin-bottom: 6px;
}
.time-slot-label:hover {
  border-color: #0C7779;
  background: #f0fafa;
  color: #0C7779;
}
.time-slot-label input[type="checkbox"] {
  accent-color: #0C7779;
  width: 15px;
  height: 15px;
  cursor: pointer;
}
.time-slot-label.slot-checked {
  border-color: #0C7779;
  background: #d4f0f0;
  color: #0C7779;
  font-weight: 500;
}

.area-tag {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #d4f0f0;
  color: #0C7779;
  border-radius: 20px;
  padding: 5px 12px;
  font-size: 0.83rem;
  font-weight: 500;
  margin: 3px;
}
.area-tag button {
  background: none;
  border: none;
  color: #0C7779;
  font-size: 1rem;
  line-height: 1;
  cursor: pointer;
  padding: 0;
  opacity: 0.7;
}
.area-tag button:hover { opacity: 1; }

.form-check-input:checked {
  background-color: #0C7779;
  border-color: #0C7779;
}

.save-toast {
  position: fixed;
  bottom: 24px;
  right: 24px;
  background: #0C7779;
  color: white;
  padding: 12px 22px;
  border-radius: 12px;
  font-size: 0.88rem;
  font-weight: 500;
  box-shadow: 0 4px 16px rgba(0,0,0,0.15);
  z-index: 9999;
  display: none;
  animation: fadeInUp 0.3s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to   { opacity: 1; transform: translateY(0); }
}
/* ============================================
   ALL BOOKINGS PAGE — BOOKING CARDS
   ============================================ */
.bkg-card {
  background: white;
  border-radius: 16px;
  padding: 18px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border-top: 4px solid transparent;
  height: 100%;
}
.bkg-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}
.bkg-card.status-pending   { border-top-color: #ffc107; }
.bkg-card.status-confirmed { border-top-color: #0dcaf0; }
.bkg-card.status-completed { border-top-color: #198754; }
.bkg-card.status-cancelled { border-top-color: #dc3545; }

.bkg-card .client-initial {
  width: 42px; height: 42px;
  border-radius: 50%;
  background: #d4f0f0;
  color: #0C7779;
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 1rem;
  flex-shrink: 0;
}
.bkg-card .bkg-info-row {
  display: flex; align-items: flex-start; gap: 7px;
  font-size: 0.8rem; color: #666; margin-bottom: 5px;
}
.bkg-card .bkg-info-row i { color: #0C7779; margin-top: 1px; }

.bkg-filter-btn.active {
  background-color: #0C7779 !important;
  border-color: #0C7779 !important;
  color: white !important;
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
  <!-- ===== TOP NAVBAR (Mobile) ===== -->
  <nav class="navbar navbar-dark top-navbar d-lg-none">
    <div class="container-fluid">
      <span class="navbar-brand fw-bold">
        <i class="bi bi-tools me-2"></i><?php echo $lang['provider_dash']['sidebar_brand']; ?>
      </span>
      <button class="btn btn-outline-light btn-sm" id="sidebarToggle">
        <i class="bi bi-list fs-5"></i>
      </button>
    </div>
  </nav>

  <!-- ===== MAIN LAYOUT WRAPPER ===== -->
  <div class="wrapper d-flex">

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">

      <div class="sidebar-brand d-none d-lg-flex align-items-center">
        <i class="bi bi-tools me-2 fs-5"></i>
        <span class="fw-bold fs-5"><?php echo $lang['provider_dash']['sidebar_brand']; ?></span>
      </div>

      <div class="sidebar-user text-center py-3">
        <p class="mb-0 fw-semibold text-white" id="sidebarName"></p>   <!-- بيتملى من الـ AJAX -->
        <small class="text-white-50" id="sidebarRole"></small>          <!-- بيتملى من الـ AJAX -->
      </div>

      <hr class="sidebar-divider"/>

      <ul class="sidebar-nav list-unstyled px-3">

        <li class="nav-item mb-1">
          <a class="nav-link active" id="nav-dashboard" onclick="showPage('dashboard')">
            <i class="bi bi-speedometer2 me-2"></i> <?php echo $lang['provider_dash']['nav_dashboard']; ?>
          </a>
        </li>

        <li class="nav-item mb-1">
          <a class="nav-link" id="nav-profile" onclick="showPage('profile')">
            <i class="bi bi-person-circle me-2"></i> <?php echo $lang['provider_dash']['nav_profile']; ?>
          </a>
        </li>

        <li class="nav-item mb-1">
  <a class="nav-link" id="nav-bookings" onclick="showPage('bookings')">
    <i class="bi bi-calendar-check me-2"></i> <?php echo $lang['provider_dash']['nav_bookings']; ?>
  </a>
</li>

        <li class="nav-item mt-3">
          <a href="logout.php" class="nav-link logout-link">
            <i class="bi bi-box-arrow-right me-2"></i> <?php echo $lang['provider_dash']['nav_logout']; ?>
          </a>
        </li>

      </ul>
    </aside>

    <!-- ===== MAIN CONTENT AREA ===== -->
    <main class="main-content flex-grow-1">

      <!-- ======================================
           PAGE 1: DASHBOARD
           ====================================== -->
      <div id="page-dashboard">

        <!-- Page Title -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="fw-bold mb-0"><?php echo $lang['provider_dash']['dash_title']; ?></h4>
            <!-- اسم المستخدم بيتملى من الـ AJAX بدل PHP echo -->
            <small class="text-muted"><?php echo $lang['provider_dash']['dash_welcome_prefix']; ?> <span id="welcomeName"></span>👋</small>
          </div>
          <div class="text-muted small">
            <i class="bi bi-calendar3 me-1"></i>
            <span id="currentDate"></span>
          </div>
        </div>

        <!-- STATS CARDS — الأرقام فاضية هنا وبتتملى من الـ AJAX -->
        <div class="row g-3 mb-4">

          <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card card border-0 shadow-sm rounded-4 p-3">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-primary-soft me-3">
                  <i class="bi bi-calendar-week text-primary fs-4"></i>
                </div>
                <div>
                  <p class="text-muted mb-0 small"><?php echo $lang['provider_dash']['stat_weekly']; ?></p>
                  <!-- id="weeklyCount" بيتملى بالـ JS بعد الـ AJAX -->
                  <h4 class="fw-bold mb-0" id="weeklyCount">—</h4>
                </div>
              </div>
              <div class="mt-2">
                <span class="badge bg-success-soft text-success">
                  <i class="bi bi-arrow-up-short"></i> 
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card card border-0 shadow-sm rounded-4 p-3">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-teal-soft me-3">
                  <i class="bi bi-collection fs-4 text-teal"></i>
                </div>
                <div>
                  <p class="text-muted mb-0 small"><?php echo $lang['provider_dash']['stat_total']; ?></p>
                  <!-- id="totalCount" بيتملى بالـ JS بعد الـ AJAX -->
                  <h4 class="fw-bold mb-0" id="totalCount">—</h4>
                </div>
              </div>
              <div class="mt-2">
                <span class="badge bg-teal-soft text-teal">
                  <i class="bi bi-arrow-up-short"></i> <?php echo $lang['provider_dash']['stat_all_time']; ?>
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card card border-0 shadow-sm rounded-4 p-3">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-success-soft me-3">
                  <i class="bi bi-check-circle fs-4 text-success"></i>
                </div>
                <div>
                  <p class="text-muted mb-0 small"><?php echo $lang['provider_dash']['stat_completed']; ?></p>
                  <!-- id="completedCount" بيتملى بالـ JS بعد الـ AJAX -->
                  <h4 class="fw-bold mb-0" id="completedCount">—</h4>
                </div>
              </div>
              <div class="mt-2">
                <!-- id="completionRate" بيتملى بنسبة الإنجاز من الـ AJAX -->
                <span class="badge bg-success-soft text-success" id="completionRate">—% completion rate</span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card card border-0 shadow-sm rounded-4 p-3">
              <div class="d-flex align-items-center">
                <div class="stat-icon bg-warning-soft me-3">
                  <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                </div>
                <div>
                  <p class="text-muted mb-0 small"><?php echo $lang['provider_dash']['stat_pending']; ?></p>
                  <!-- id="pendingCount" بيتملى بالـ JS بعد الـ AJAX -->
                  <h4 class="fw-bold mb-0" id="pendingCount">—</h4>
                </div>
              </div>
              <div class="mt-2">
                <span class="badge bg-warning-soft text-warning">
                  <i class="bi bi-clock"></i> <?php echo $lang['provider_dash']['stat_needs_attention']; ?>
                </span>
              </div>
            </div>
          </div>

        </div>

        <!-- CHART SECTION -->
        <div class="row g-3 mb-4">
          <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
              <h6 class="fw-semibold mb-3">
                <i class="bi bi-bar-chart-line me-2 text-teal"></i>
                <?php echo $lang['provider_dash']['chart_title']; ?>
              </h6>
              <!-- الـ canvas بيبقى فاضي لحد ما الـ AJAX يرجع البيانات -->
              <canvas id="locationsChart" height="120"></canvas>
            </div>
          </div>
        </div>

        <!-- RECENT BOOKINGS TABLE -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
          <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h6 class="fw-semibold mb-0">
              <i class="bi bi-table me-2 text-teal"></i>
              <?php echo $lang['provider_dash']['recent_bookings_title']; ?>
            </h6>
            <a href="javascript:void(0)" onclick="showPage('bookings')" class="btn btn-teal btn-sm rounded-pill px-3">
              <?php echo $lang['provider_dash']['btn_view_all']; ?> <i class="bi bi-arrow-right ms-1"></i>
            </a>
          </div>
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th><?php echo $lang['provider_dash']['tbl_order_id']; ?></th>
                  <th><?php echo $lang['provider_dash']['tbl_client']; ?></th>
                  <th><?php echo $lang['provider_dash']['tbl_location']; ?></th>
                  <th><?php echo $lang['provider_dash']['tbl_datetime']; ?></th>
                  <th><?php echo $lang['provider_dash']['tbl_whatsapp']; ?></th>
                  <th><?php echo $lang['provider_dash']['tbl_status']; ?></th>
                </tr>
              </thead>
              <!-- tbody فاضي وبيتملى من buildTable() بعد الـ AJAX -->
              <tbody id="bookingsTableBody"></tbody>
            </table>
          </div>
        </div>

      </div>
      <!-- END PAGE: DASHBOARD -->


      <!-- ======================================
           PAGE 2: EDIT PROFILE
           ====================================== -->
      <div id="page-profile" style="display: none;">

        <div class="page-header d-flex justify-content-between align-items-center mb-4">
          <div>
            <h4 class="fw-bold mb-0"><?php echo $lang['provider_dash']['profile_page_title']; ?></h4>
            <small class="text-muted"><?php echo $lang['provider_dash']['profile_page_subtitle']; ?></small>
          </div>
          <div class="text-muted small">
            <i class="bi bi-person-circle me-1 text-teal"></i>
            <!-- اسم المستخدم في هيدر البروفايل بيجي من الـ AJAX -->
            <span id="profileHeaderName">...</span>
          </div>
        </div>

        <div class="profile-card-section d-flex align-items-center gap-3 mb-4">
          <!-- صورة البروفايل بتتحدث من الـ AJAX لما نجيب الاسم -->
          <img id="profileAvatar"
               src="https://ui-avatars.com/api/?background=0C7779&color=fff&size=90"
               class="profile-avatar-box"
               alt="Profile Photo"/>
          <div>
            <!-- الاسم والمهنة بيتملوا من الـ AJAX -->
            <h5 class="fw-bold mb-0" id="profileName">...</h5>
            <small class="text-teal fw-medium">
              <i class="bi bi-lightning-charge-fill me-1"></i>
              <span id="profileServiceType">...</span>
            </small>
          </div>
        </div>

        <div class="profile-card-section">
          <p class="profile-section-title">
            <i class="bi bi-person-lines-fill me-1"></i> <?php echo $lang['provider_dash']['section_basic_info']; ?>
          </p>
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_full_name']; ?></label>
              <!-- الـ id="inputName" بيتملى من الـ AJAX -->
              <input type="text" class="form-control profile-input" id="inputName" placeholder="Enter your full name"/>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_phone']; ?></label>
              <!-- الـ id="inputPhone" بيتملى من الـ AJAX -->
              <input type="tel" class="form-control profile-input" id="inputPhone" placeholder="Phone number"/>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_email']; ?></label>
              <!-- الـ id="inputEmail" بيتملى من الـ AJAX -->
              <input type="email" class="form-control profile-input" id="inputEmail" placeholder="Email"/>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_service_type']; ?></label>
              <select class="form-select profile-input" id="inputServiceType">
                <option></option>
                <option></option>
                <option></option>
                <option></option>
                <option></option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_description']; ?></label>
              <!-- الـ id="inputBio" بيتملى من الـ AJAX -->
              <textarea class="form-control profile-input" id="inputBio" rows="3" placeholder="<?php echo $lang['provider_dash']['desc_placeholder']; ?>"></textarea>
            </div>
          </div>
        </div>

        <div class="profile-card-section">
          <p class="profile-section-title">
            <i class="bi bi-cash-stack me-1"></i> <?php echo $lang['provider_dash']['section_pricing']; ?>
          </p>
          <div class="row g-3">
            <div class="col-12 col-md-4">
              <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_hourly_rate']; ?></label>
              <div class="input-group">
                <!-- الـ id="priceInput" بيتملى من الـ AJAX -->
                <input type="number" class="form-control profile-input" id="priceInput" min="0" placeholder="0"/>
                <span class="input-group-text" style="border-radius:0 10px 10px 0; background:#d4f0f0; color:#0C7779; border:1.5px solid #e2e8f0; font-weight:600;">₪/hr</span>
              </div>
            </div>
          </div>
        </div>

        <div class="profile-card-section">
          <p class="profile-section-title">
            <i class="bi bi-clock me-1"></i> <?php echo $lang['provider_dash']['section_work_hours']; ?>
          </p>
          <p class="small text-muted fw-semibold mb-2">Available Time Slots:</p>
          <div class="d-flex align-items-center gap-3 mb-3">
    <div>
        <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_time_from']; ?></label>
        <input type="time" class="form-control profile-input" id="workTimeFrom"/>
    </div>
    <span class="fw-bold text-muted mt-3">—</span>
    <div>
        <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_time_to']; ?></label>
        <input type="time" class="form-control profile-input" id="workTimeTo"/>
    </div>
</div>
          <p class="small text-muted fw-semibold mb-2"><?php echo $lang['provider_dash']['label_working_days']; ?></p>
          <div class="row g-2" id="workDays"></div>
        </div>

        <div class="profile-card-section">
          <p class="profile-section-title">
            <i class="bi bi-geo-alt me-1"></i> <?php echo $lang['provider_dash']['section_areas']; ?>
          </p>
          <p class="small text-muted fw-semibold mb-2"><?php echo $lang['provider_dash']['areas_label']; ?></p>
          <div class="mb-3" id="areaTags">
            <span class="area-tag">Jenin   <button onclick="removeArea(this)" title="Remove">×</button></span>
            <span class="area-tag">Nablus  <button onclick="removeArea(this)" title="Remove">×</button></span>
            <span class="area-tag">Tulkarm <button onclick="removeArea(this)" title="Remove">×</button></span>
          </div>
          <p class="small text-muted fw-semibold mb-2"><?php echo $lang['provider_dash']['add_area_label']; ?></p>
          <div class="input-group" style="max-width: 360px;">
            <input type="text" class="form-control profile-input" id="newAreaInput" placeholder="<?php echo $lang['provider_dash']['add_area_placeholder']; ?>"/>
            <button class="btn btn-teal px-3" type="button" onclick="addArea()">
              <i class="bi bi-plus-lg"></i>
            </button>
          </div>
        </div>

        <div class="profile-card-section">
          <p class="profile-section-title">
            <i class="bi bi-shield-lock me-1"></i> <?php echo $lang['provider_dash']['section_security']; ?>
          </p>
          <div class="row g-3">
            <!-- [تعديل] أضفنا حقل كلمة المرور القديمة لأن الباك-اند يتوقع old_pass للتحقق قبل التغيير -->
<div class="col-12 col-md-6">
  <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_current_pass']; ?></label>
  <div class="input-group">
    <input type="password" class="form-control profile-input" id="currentPass" 
           placeholder="<?php echo $lang['provider_dash']['current_pass_placeholder']; ?>" 
           style="border-radius: 10px 0 0 10px;"/>
    <button class="btn btn-outline-secondary" type="button" 
            style="border-radius:0 10px 10px 0;" 
            onclick="togglePass('currentPass', this)">
      <i class="bi bi-eye"></i>
    </button>
  </div>
</div>
            <div class="col-12 col-md-6">
              <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_new_pass']; ?></label>
              <div class="input-group">
                <input type="password" class="form-control profile-input" id="newPass" placeholder="<?php echo $lang['provider_dash']['new_pass_placeholder']; ?>" style="border-radius: 10px 0 0 10px;"/>
                <button class="btn btn-outline-secondary" type="button" style="border-radius:0 10px 10px 0;" onclick="togglePass('newPass', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label small fw-semibold text-muted"><?php echo $lang['provider_dash']['label_confirm_pass']; ?></label>
              <div class="input-group">
                <input type="password" class="form-control profile-input" id="confirmPass" placeholder="<?php echo $lang['provider_dash']['confirm_pass_placeholder']; ?>" style="border-radius: 10px 0 0 10px;"/>
                <button class="btn btn-outline-secondary" type="button" style="border-radius:0 10px 10px 0;" onclick="togglePass('confirmPass', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 justify-content-end mb-4">
          <button class="btn btn-outline-secondary rounded-pill px-4" onclick="showPage('dashboard')">
            <i class="bi bi-x-lg me-1"></i> <?php echo $lang['provider_dash']['btn_cancel_profile']; ?>
          </button>
          <button class="btn btn-teal rounded-pill px-4" onclick="saveProfile()">
            <i class="bi bi-floppy me-1"></i> <?php echo $lang['provider_dash']['btn_save_profile']; ?>
          </button>
        </div>

      </div>
      <!-- END PAGE: EDIT PROFILE -->
<!-- ======================================
     PAGE 3: ALL BOOKINGS
     ====================================== -->
<div id="page-bookings" style="display: none;">

  <div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-0"><?php echo $lang['provider_dash']['all_bookings_title']; ?></h4>
      <small class="text-muted"><?php echo $lang['provider_dash']['all_bookings_subtitle']; ?></small>
    </div>
    <div class="text-muted small">
      <i class="bi bi-calendar3 me-1"></i>
      <span id="bookingsDate"></span>
    </div>
  </div>

  <!-- Mini Stats Row -->
  <div class="row g-3 mb-4" id="bookingsStatsRow">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <h3 class="fw-bold mb-0 text-teal" id="bs-total">—</h3>
        <small class="text-muted"><?php echo $lang['provider_dash']['bs_total']; ?></small>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <h3 class="fw-bold mb-0" style="color:#ffc107" id="bs-pending">—</h3>
        <small class="text-muted"><?php echo $lang['provider_dash']['bs_pending']; ?></small>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <h3 class="fw-bold mb-0 text-success" id="bs-completed">—</h3>
        <small class="text-muted"><?php echo $lang['provider_dash']['bs_completed']; ?></small>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <h3 class="fw-bold mb-0 text-danger" id="bs-cancelled">—</h3>
        <small class="text-muted"><?php echo $lang['provider_dash']['bs_cancelled']; ?></small>
      </div>
    </div>
  </div>

  <!-- Filter & Search Bar -->
  <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center">
      <button class="btn btn-teal btn-sm rounded-pill px-3 bkg-filter-btn active" data-filter="all"><?php echo $lang['provider_dash']['filter_all']; ?></button>
      <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 bkg-filter-btn" data-filter="pending"><?php echo $lang['provider_dash']['filter_pending']; ?></button>
      <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 bkg-filter-btn" data-filter="confirmed"><?php echo $lang['provider_dash']['filter_confirmed']; ?></button>
      <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 bkg-filter-btn" data-filter="completed"><?php echo $lang['provider_dash']['filter_completed']; ?></button>
      <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 bkg-filter-btn" data-filter="cancelled"><?php echo $lang['provider_dash']['filter_cancelled']; ?></button>
      <select class="form-select form-select-sm rounded-pill ms-auto" style="max-width:180px;" id="bkgSort">
        <option value="newest"><?php echo $lang['provider_dash']['sort_newest']; ?></option>
        <option value="oldest"><?php echo $lang['provider_dash']['sort_oldest']; ?></option>
        <option value="status"><?php echo $lang['provider_dash']['sort_status']; ?></option>
      </select>
      <div class="input-group input-group-sm" style="max-width:220px;">
        <span class="input-group-text rounded-start-pill bg-white border-end-0">
          <i class="bi bi-search text-muted"></i>
        </span>
        <input type="text" class="form-control rounded-end-pill border-start-0"
               id="bkgSearch" placeholder="<?php echo $lang['provider_dash']['search_placeholder']; ?>"/>
      </div>
    </div>
  </div>

  <!-- Bookings Cards Grid -->
  <div class="row g-3" id="bookingsCardsContainer">
    <div class="col-12 text-center py-5 text-muted">
      <i class="bi bi-hourglass-split fs-3 mb-2 d-block"></i>
      Loading bookings...
    </div>
  </div>

</div>
<!-- END PAGE: ALL BOOKINGS -->
    </main>
  </div>

  <div class="modal fade" id="bookingModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">

      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center gap-3">
          <div class="stat-icon bg-warning-soft" id="modal-status-icon-wrap">
            <i class="bi bi-hourglass-split text-warning fs-5" id="modal-status-icon"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0" id="modal-order-id"><?php echo $lang['provider_dash']['modal_booking_title']; ?> #—</h6>
            <span class="mt-1 d-inline-block" id="modal-status-badge"></span>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body py-3">
        <div class="d-flex flex-column gap-2">
          <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8feff">
            <i class="bi bi-person text-teal"></i>
            <span class="text-muted small" style="min-width:80px"><?php echo $lang['provider_dash']['modal_client_label']; ?></span>
            <span class="fw-semibold small" id="modal-client">—</span>
          </div>
          <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8feff">
    <i class="bi bi-geo-alt text-teal"></i>
    <span class="text-muted small" style="min-width:80px"><?php echo $lang['provider_dash']['modal_location_label']; ?></span>
    <span class="fw-semibold small" id="modal-location">—</span>
</div>
<div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8feff" id="modal-map-row">
    <i class="bi bi-map text-teal"></i>
    <span class="text-muted small" style="min-width:80px"><?php echo $lang['provider_dash']['modal_map_label']; ?></span>
    <a id="modal-map-link" href="#" target="_blank" 
       class="btn btn-sm btn-outline-success rounded-pill px-3"
       style="font-size:.78rem; display:none;">
        <i class="bi bi-map-fill me-1"></i> <?php echo $lang['provider_dash']['modal_map_btn']; ?>
    </a>
</div>
          <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8feff">
            <i class="bi bi-calendar3 text-teal"></i>
            <span class="text-muted small" style="min-width:80px"><?php echo $lang['provider_dash']['modal_datetime_label']; ?></span>
            <span class="fw-semibold small" id="modal-datetime">—</span>
          </div>
          <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8feff">
            <i class="bi bi-chat-left-text text-teal"></i>
            <span class="text-muted small" style="min-width:80px"><?php echo $lang['provider_dash']['modal_note_label']; ?></span>
            <span class="fw-semibold small" id="modal-note">—</span>
          </div>
        </div>
      </div>

      <div class="modal-footer border-0 pt-0 gap-2">
    <button type="button" class="btn btn-outline-danger rounded-pill px-4 flex-grow-1"
            id="rejectBtn">
        <i class="bi bi-x-lg me-1"></i> <?php echo $lang['provider_dash']['btn_reject_booking']; ?>
    </button>
    <button type="button" class="btn btn-teal rounded-pill px-4 flex-grow-1"
            id="confirmBtn">
        <i class="bi bi-check-lg me-1"></i> <?php echo $lang['provider_dash']['btn_confirm_booking']; ?>
    </button>
</div>

    </div>
  </div>
</div>



  <!-- Sidebar Overlay (Mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- Toast رسالة النجاح -->
  <div class="save-toast" id="saveToast">
    <i class="bi bi-check-circle-fill me-2"></i> Changes saved successfully!
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ==========================================
// 1. NAVIGATION & INITIALIZATION
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
    // عرض التاريخ الحالي
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('currentDate').innerText = new Date().toLocaleDateString('en-US', options);

    // جلب البيانات فور تحميل الصفحة
    loadDashboardData();
    loadProfileData();
});

// التنقل بين الصفحات السلس (Single Page Application Style)
function showPage(pageId) {
    // إخفاء جميع الصفحات
    document.getElementById('page-dashboard').style.display = 'none';
    document.getElementById('page-profile').style.display = 'none';
    
    // إزالة الفعالية من لينكات القائمة
    document.getElementById('nav-dashboard').classList.remove('active');
    document.getElementById('nav-profile').classList.remove('active');

    document.getElementById('page-bookings').style.display = 'none';
    document.getElementById('nav-bookings').classList.remove('active');

    // إظهار الصفحة المطلوبة وتفعيل اللينك الخاص بها
    if (pageId === 'dashboard') {
        document.getElementById('page-dashboard').style.display = 'block';
        document.getElementById('nav-dashboard').classList.add('active');
        loadDashboardData(); // تحديث البيانات
    } else if (pageId === 'profile') {
        document.getElementById('page-profile').style.display = 'block';
        document.getElementById('nav-profile').classList.add('active');
        loadProfileData(); // جلب بيانات البروفايل
    }// داخل دالة showPage — بعد else if (pageId === 'profile') { ... }
else if (pageId === 'bookings') {
    document.getElementById('page-bookings').style.display = 'block';
    document.getElementById('nav-bookings').classList.add('active');
    loadAllBookings();
}
}

// ==========================================
// 2. DASHBOARD AJAX FUNCTIONS
// ==========================================
function loadDashboardData() {
    fetch('dashboardData.php')
        .then(response => response.json())
        .then(data => {
          console.log(data);
            if (data.success) {
                // تعبئة كروت الإحصائيات
                document.getElementById('weeklyCount').innerText = data.stats.weekly;
                document.getElementById('totalCount').innerText = data.stats.total;
                document.getElementById('completedCount').innerText = data.stats.completed;
                document.getElementById('pendingCount').innerText = data.stats.pending;
                document.getElementById('completionRate').innerText = `${data.stats.completion_rate}% completion rate`;

                // تعبئة بيانات المستخدم في السايدبار والهيدر
                document.getElementById('sidebarName').innerText = data.user.name;
                document.getElementById('sidebarRole').innerText = data.user.role;
                document.getElementById('welcomeName').innerText = data.user.name;
                

                // بناء جدول الحجوزات الأخيرة
                buildBookingsTable(data.recent_bookings);

                // بناء الرسم البياني للمناطق
                buildChart(data.chart_data);
            } else {
            console.error('API Error:', data); // ← وهاي
        }
        })
        .catch(error => console.error('Error fetching dashboard data:', error));
}


function buildBookingsTable(bookings) {
    const tbody = document.getElementById('bookingsTableBody');
    

    tbody.innerHTML = '';

    if (bookings.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-3"><?php echo $lang['provider_dash']['tbl_no_bookings']; ?></td></tr>`;
        return;
    }

    // ← خزّن الحجوزات هون عشان نوصلها بالـ index بدل JSON.stringify
        window._bookingsData = bookings;

    bookings.forEach((book, index) => {
        const waPhone = String(book.whatsapp || '').replace(/\D/g, '').replace(/^0/, '970');
        let statusBadge = '';

        if (book.status === 'completed') {
            statusBadge = '<span class="badge-completed"><?php echo $lang['provider_dash']['status_completed']; ?></span>';
        }  else if (book.status === 'confirmed') {
              statusBadge = `
              <span class="badge-confirmed" 
              style="cursor:pointer;" 
              onclick="openBookingModalConfirmed(${index})"
              title="Click to update">
            <?php echo $lang['provider_dash']['status_confirmed']; ?>
        </span>`;
        } else if (book.status === 'cancelled') {
            statusBadge = '<span class="badge-rejected"><?php echo $lang['provider_dash']['status_cancelled']; ?></span>';
        } else if (book.status === 'pending') {
            // ← بنمرر index بس بدل الـ object كامل
            statusBadge = `
                <span class="badge-pending" 
                      style="cursor:pointer;" 
                      onclick="openBookingModal(${index})"
                      title="Click to review">
                    <i class="bi bi-hourglass-split me-1"></i> <?php echo $lang['provider_dash']['status_pending']; ?>
                </span>`;
        } else {
            statusBadge = `<span class="badge bg-secondary">${book.status}</span>`;
        }

        tbody.innerHTML += `
            <tr>
                <td class="fw-bold">#${book.order_id}</td>
                <td>${book.client_name}</td>
                <td>
    <i class="bi bi-geo-alt text-muted me-1"></i>${book.location}
    ${book.lat && book.lng && book.status !== 'cancelled' ? 
        `<a href="https://www.google.com/maps?q=${book.lat},${book.lng}" 
            target="_blank" 
            class="btn btn-sm btn-outline-success rounded-pill px-2 ms-1"
            style="font-size:.72rem;">
            <i class="bi bi-map-fill"></i>
        </a>` : ''}
</td>
                <td>${book.date_time}</td>
                <td>
                    <a href="https://wa.me/${waPhone}" target="_blank" 
                       class="btn btn-sm btn-success rounded-circle">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </td>
                <td>${statusBadge}</td>
            </tr>
        `;
    });
}

// [إضافة] دالة موحّدة تحدّث شكل الـ badge والأيقونة جوا المودال حسب حالة الحجز
// هاد بيحل مشكلة إنو عنوان المودال كان دايماً عم يظهر "Pending" حتى للحجوزات confirmed
function setModalStatusBadge(status) {
    const badge = document.getElementById('modal-status-badge');
    const iconWrap = document.getElementById('modal-status-icon-wrap');
    const icon = document.getElementById('modal-status-icon');

    const statusConfig = {
        pending: {
            badgeClass: 'badge-pending',
            text: '<?php echo $lang['provider_dash']['status_pending']; ?>',
            iconWrapClass: 'stat-icon bg-warning-soft',
            iconClass: 'bi bi-hourglass-split text-warning fs-5'
        },
        confirmed: {
            badgeClass: 'badge-confirmed',
            text: '<?php echo $lang['provider_dash']['status_confirmed']; ?>',
            iconWrapClass: 'stat-icon bg-primary-soft',
            iconClass: 'bi bi-check2-circle text-primary fs-5'
        }
    };

    const cfg = statusConfig[status] || statusConfig.pending;

    badge.className = cfg.badgeClass + ' mt-1 d-inline-block';
    badge.innerText = cfg.text;

    iconWrap.className = cfg.iconWrapClass;
    icon.className = cfg.iconClass;
}

let currentBookingId = null;

function openBookingModalConfirmed(index) {
    const book = window._bookingsData[index];
    currentBookingId = book.order_id;

    document.getElementById('modal-order-id').innerText = `<?php echo $lang['provider_dash']['modal_booking_title']; ?> #${book.order_id}`;
    document.getElementById('modal-client').innerText   = book.client_name;
    document.getElementById('modal-location').innerText = book.location;
    document.getElementById('modal-datetime').innerText = book.date_time;
    document.getElementById('modal-note').innerText     = book.note || '<?php echo $lang['provider_dash']['modal_note_empty']; ?>';

    setModalStatusBadge('confirmed'); // [إضافة] يخلي عنوان المودال يظهر "Confirmed" مش "Pending"

    const mapLink = document.getElementById('modal-map-link');
    if (book.lat && book.lng) {
        mapLink.href = `https://www.google.com/maps?q=${book.lat},${book.lng}`;
        mapLink.style.display = 'inline-block';
    } else {
        mapLink.style.display = 'none';
    }

    // غيري نص الأزرار
    document.getElementById('confirmBtn').innerHTML = '<i class="bi bi-check-circle me-1"></i> <?php echo $lang['provider_dash']['btn_completed']; ?>';
    document.getElementById('rejectBtn').innerHTML  = '<i class="bi bi-x-lg me-1"></i> <?php echo $lang['provider_dash']['btn_cancel_booking']; ?>';

    document.getElementById('confirmBtn').onclick = () => submitBookingAction('completed');
    document.getElementById('rejectBtn').onclick  = () => submitBookingAction('cancelled');

    new bootstrap.Modal(document.getElementById('bookingModal')).show();
}

function openBookingModal(index) {

// ← نجيب الـ object من الـ array المخزنة
    const book = window._bookingsData[index];
    currentBookingId = book.order_id;

    document.getElementById('modal-order-id').innerText = `<?php echo $lang['provider_dash']['modal_booking_title']; ?> #${book.order_id}`;
    document.getElementById('modal-client').innerText   = book.client_name;
    document.getElementById('modal-location').innerText = book.location;
    document.getElementById('modal-datetime').innerText = book.date_time;
    document.getElementById('modal-note').innerText     = book.note || '<?php echo $lang['provider_dash']['modal_note_empty']; ?>';

    setModalStatusBadge('pending'); // [إضافة] يضمن إنو يضل "Pending" لحجز لسا قيد الانتظار

    // زر الخريطة
const mapLink = document.getElementById('modal-map-link');
if (book.lat && book.lng) {
    mapLink.href = `https://www.google.com/maps?q=${book.lat},${book.lng}`;
    mapLink.style.display = 'inline-block';
} else {
    mapLink.style.display = 'none';
}

    document.getElementById('confirmBtn').innerHTML = '<i class="bi bi-check-lg me-1"></i> <?php echo $lang['provider_dash']['btn_confirm_booking']; ?>';
    document.getElementById('rejectBtn').innerHTML  = '<i class="bi bi-x-lg me-1"></i> <?php echo $lang['provider_dash']['btn_reject_booking']; ?>';

    document.getElementById('confirmBtn').onclick = () => submitBookingAction('confirmed');
    document.getElementById('rejectBtn').onclick  = () => submitBookingAction('cancelled');

    new bootstrap.Modal(document.getElementById('bookingModal')).show();
}

function submitBookingAction(newStatus) {
    fetch('update_booking_status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ booking_id: currentBookingId, status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
        bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();
        if (data.success) {
            // ← حدّث الصفحة اللي أنت عليها
            const activePage = document.getElementById('page-bookings').style.display !== 'none'
                ? 'bookings' : 'dashboard';
            if (activePage === 'bookings') {
                loadAllBookings();
            } else {
                loadDashboardData();
            }
        } else {
            alert('Error: ' + data.message);
        }
    });
}

let locationsChart = null; // لتفادي تكرار إنشاء التشاريت فوق بعضه
function buildChart(chartData) {
    const ctx = document.getElementById('locationsChart').getContext('2d');
    
    if (locationsChart) {
        locationsChart.destroy(); // تدمير التشاريت القديم إذا كان موجوداً
    }

    locationsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels, // مثل: ['Tulkarm', 'Nablus', 'Jenin']
            datasets: [{
                label: 'Bookings',
                data: chartData.values, // مثل: [12, 19, 8]
                backgroundColor: '#0C7779',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

// ==========================================
// 3. EDIT PROFILE AJAX FUNCTIONS
// ==========================================
function loadProfileData() {
    fetch('dashboardData.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const name  = data.user.name;
                const extra = data.profile_extra || {};

                document.getElementById('profileHeaderName').innerText  = name;
                document.getElementById('profileName').innerText        = name;
                document.getElementById('profileServiceType').innerText = data.user.role;
                document.getElementById('profileAvatar').src =
                    `https://ui-avatars.com/api/?background=0C7779&color=fff&size=90&name=${encodeURIComponent(name)}`;

                document.getElementById('inputName').value  = name;
                document.getElementById('inputPhone').value = extra.phone || '';
                document.getElementById('inputEmail').value = extra.email || '';
                document.getElementById('inputBio').value   = extra.bio   || '';
                document.getElementById('priceInput').value = extra.price || '';

                if (data.services) {
                  buildServiceTypeSelect(data.services, extra.service_id);
                }

                // [إصلاح] working_days قادم كـ string "Sunday,Monday" من قاعدة البيانات
                // نحوّله لـ array قبل ما نمرره لـ buildWorkingDays وإلا الأيام ما بتتعلّم
                const daysArray = extra.working_days
                    ? (Array.isArray(extra.working_days)
                        ? extra.working_days
                        : extra.working_days.split(',').map(d => d.trim()).filter(Boolean))
                    : [];

                // [إصلاح] نفس المشكلة مع working_hours — نحوّله لـ array للـ timeSlots
                if (extra.working_hours) {
    const parts = extra.working_hours.split(',').map(h => h.trim());
    if (parts[0]) document.getElementById('workTimeFrom').value = parts[0];
    if (parts[1]) document.getElementById('workTimeTo').value   = parts[1];
}

                // [إصلاح] Governorate قادم كـ string "Jenin,Nablus" نحوّله لـ array للـ areaTags
                const areasArray = extra.governorate
                    ? (Array.isArray(extra.governorate)
                        ? extra.governorate
                        : extra.governorate.split(',').map(a => a.trim()).filter(Boolean))
                    : [];

                buildWorkingDays(daysArray);
                buildAreaTags(areasArray);

                // [إصلاح] نعلّم الـ timeSlots بناءً على working_hours المخزنة
                document.querySelectorAll('#timeSlots input[type="checkbox"]').forEach(cb => {
                    const slotText = cb.parentElement.textContent.trim();
                    const isChecked = hoursArray.some(h => slotText.includes(h) || h.includes(slotText));
                    cb.checked = isChecked;
                    if (isChecked) {
                        cb.parentElement.classList.add('slot-checked');
                    } else {
                        cb.parentElement.classList.remove('slot-checked');
                    }
                });
            }
        })
        .catch(error => console.error('Error fetching profile data:', error));
}



function buildServiceTypeSelect(services, selectedServiceId) {
    const select = document.getElementById('inputServiceType');
    select.innerHTML = '';
    services.forEach(service => {
        const selected = (service.id == selectedServiceId) ? 'selected' : '';
        select.innerHTML += `<option value="${service.id}" ${selected}>${service.name}</option>`;
    });
}

function buildWorkingDays(savedDays) {
    const daysContainer = document.getElementById('workDays');
    const allDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    daysContainer.innerHTML = '';

    allDays.forEach(day => {
        const isChecked = savedDays.includes(day) ? 'checked' : '';
        const activeClass = savedDays.includes(day) ? 'slot-checked' : '';
        
        daysContainer.innerHTML += `
            <div class="col-6 col-sm-4 col-md-3">
                <label class="time-slot-label ${activeClass} d-block text-center">
                    <input type="checkbox" name="work_days[]" value="${day}" ${isChecked} onchange="toggleSlot(this)"/> ${day}
                </label>
            </div>
        `;
    });
}

function buildAreaTags(areas) {
    const container = document.getElementById('areaTags');
    container.innerHTML = '';
    areas.forEach(area => {
        container.innerHTML += `
            <span class="area-tag">${area} <button onclick="removeArea(this)" type="button" title="Remove">×</button></span>
        `;
    });
}

// تفعيل وتغيير شكل التشيك بوكس عند الضغط (أيام وساعات العمل)
function toggleSlot(checkbox) {
    if (checkbox.checked) {
        checkbox.parentElement.classList.add('slot-checked');
    } else {
        checkbox.parentElement.classList.remove('slot-checked');
    }
}

// إضافة منطقة جديدة للـ UI
function addArea() {
    const input = document.getElementById('newAreaInput');
    const areaName = input.value.trim();
    if (areaName === '') return;

    const container = document.getElementById('areaTags');
    // التأكد من عدم تكرار المنطقة
    const existingAreas = Array.from(container.querySelectorAll('.area-tag')).map(el => el.textContent.replace('×', '').trim());
    if (existingAreas.includes(areaName)) {
        alert('This area is already added!');
        return;
    }

    container.innerHTML += `
        <span class="area-tag">${areaName} <button onclick="removeArea(this)" type="button" title="Remove">×</button></span>
    `;
    input.value = '';
}

// إزالة منطقة من الـ UI
function removeArea(button) {
    button.parentElement.remove();
}

// إظهار وإخفاء كلمة المرور
function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        btn.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        input.type = "password";
        btn.innerHTML = '<i class="bi bi-eye"></i>';
    }
}



// ==========================================
// 4. SAVE PROFILE (POST DATA)
// ==========================================
function saveProfile() {
    const oldPass     = document.getElementById('currentPass').value;
    const pass        = document.getElementById('newPass').value;
    const confirmPass = document.getElementById('confirmPass').value;

    if (pass !== confirmPass) {
        alert("Passwords do not match!");
        return;
    }

    // [إصلاح] منع الإرسال إذا الإيميل فاضي — يحمي من Duplicate entry '' for key 'Email'
    const email = document.getElementById('inputEmail').value.trim();
    if (!email) {
        alert("Email address is required!");
        document.getElementById('inputEmail').focus();
        return;
    }

    const selectedDays = [];
    document.querySelectorAll('input[name="work_days[]"]:checked').forEach(cb => {
        selectedDays.push(cb.value);
    });

    const selectedAreas = [];
    document.querySelectorAll('#areaTags .area-tag').forEach(el => {
        selectedAreas.push(el.textContent.replace('×', '').trim());
    });

    const fullName  = document.getElementById('inputName').value.trim();
    const nameParts = fullName.split(' ');
    const firstName = nameParts[0] || '';
    const lastName  = nameParts.slice(1).join(' ') || '';

    // [إصلاح] أضفنا تحقق — لو الاسم فاضي ما نكمل لأن الباك-اند يتوقع first_name
    if (!firstName) {
        alert("Full name is required!");
        document.getElementById('inputName').focus();
        return;
    }

   
const timeFrom = document.getElementById('workTimeFrom').value;
const timeTo   = document.getElementById('workTimeTo').value;

    const profileData = {
        first_name:    firstName,
        last_name:     lastName,
        phone_no:      document.getElementById('inputPhone').value.trim(),
        email:         email,
        // [إصلاح] service_id نرسله كـ رقم صحيح وليس string فاضي
        // لأن الباك-اند bind_param نوعه "i" (integer) وقيمة فاضية بتسبب فشل صامت
        service_id:    parseInt(document.getElementById('inputServiceType').value) || 0,
        description:   document.getElementById('inputBio').value.trim(),
        price:         parseFloat(document.getElementById('priceInput').value) || 0,
        governorate:   selectedAreas.join(','),
        working_days:  selectedDays.join(','),
        working_hours: `${timeFrom}-${timeTo}`,
        old_pass:      oldPass,
        new_pass:      pass
    };

    fetch('update_profile.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(profileData)
    })
    .then(res => res.text()) // [إصلاح] نقرأ كـ text أولاً لنرى الخطأ الخام إذا كان في مشكلة PHP
    .then(text => {
        console.log('update_profile raw response:', text);
        let result;
        try {
            result = JSON.parse(text);
        } catch (e) {
            alert('Server error — check console for details');
            return;
        }
        if (result.success) {
            alert('Profile updated successfully!');
            loadDashboardData();
            showPage('dashboard');
        } else {
            alert('Error: ' + result.message);
        }
    })
    .catch(error => console.error('Error updating profile:', error));
}
// ==========================================
// 5. ALL BOOKINGS PAGE
// ==========================================
let _allBookings = [];
let _currentFilter = 'all';

function loadAllBookings() {
  fetch('dashboardData.php')
    .then(r => r.json())
    .then(data => {
      if (!data.success) return;

      _allBookings = data.all_bookings || data.recent_bookings || [];

      // عبّي الإحصائيات
      document.getElementById('bs-total').innerText     = _allBookings.length;
      document.getElementById('bs-pending').innerText   = _allBookings.filter(b => b.status === 'pending').length;
      document.getElementById('bs-completed').innerText = _allBookings.filter(b => b.status === 'completed').length;
      document.getElementById('bs-cancelled').innerText = _allBookings.filter(b => b.status === 'cancelled').length;
      document.getElementById('bookingsDate').innerText =
        new Date().toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

      renderBookingCards();
    })
    .catch(err => console.error('loadAllBookings error:', err));
}

function renderBookingCards() {
  const search = (document.getElementById('bkgSearch')?.value || '').toLowerCase();
  const sort   = document.getElementById('bkgSort')?.value || 'newest';

  let filtered = _allBookings.filter(b => {
    const matchFilter = _currentFilter === 'all' || b.status === _currentFilter;
    const matchSearch = b.client_name.toLowerCase().includes(search) ||
                        (b.location || '').toLowerCase().includes(search);
    return matchFilter && matchSearch;
  });

  // Sorting
  if (sort === 'oldest') {
    filtered = filtered.slice().reverse();
  } else if (sort === 'status') {
    const order = { pending:0, confirmed:1, completed:2, cancelled:3 };
    filtered = filtered.slice().sort((a,b) => (order[a.status]||99) - (order[b.status]||99));
  }

  const container = document.getElementById('bookingsCardsContainer');

  if (filtered.length === 0) {
    container.innerHTML = `
      <div class="col-12 text-center py-5 text-muted">
        <i class="bi bi-inbox fs-2 mb-2 d-block"></i>
        <?php echo $lang['provider_dash']['no_bookings_found']; ?>
      </div>`;
    return;
  }

  // اخزن للـ modal
  window._bookingsData = _allBookings;

  container.innerHTML = filtered.map((book, idx) => {
    const initial = (book.client_name || '?').charAt(0).toUpperCase();

    const statusBadgeMap = {
      pending:   '<span class="badge-pending"><?php echo $lang['provider_dash']['filter_pending']; ?></span>',
      confirmed: '<span class="badge-confirmed"><?php echo $lang['provider_dash']['filter_confirmed']; ?></span>',
      completed: '<span class="badge-completed"><?php echo $lang['provider_dash']['filter_completed']; ?></span>',
      cancelled: '<span class="badge-rejected"><?php echo $lang['provider_dash']['filter_cancelled']; ?></span>',
    };
    const badge = statusBadgeMap[book.status] ||
                  `<span class="badge bg-secondary">${book.status}</span>`;

    const realIdx = _allBookings.indexOf(book);
const footerActions = book.status === 'pending' ? `
    <button class="btn btn-sm btn-success rounded-pill px-2 py-1"
            style="font-size:.75rem;"
            onclick="event.stopPropagation(); openBookingModal(${realIdx})">
      <?php echo $lang['provider_dash']['card_review_btn']; ?>
    </button>` :
  book.status === 'confirmed' ? `
    <button class="btn btn-sm btn-outline-info rounded-pill px-2 py-1"
            style="font-size:.75rem;"
            onclick="event.stopPropagation(); openBookingModalConfirmed(${realIdx})">
      <i class="bi bi-check2-circle me-1"></i> <?php echo $lang['provider_dash']['card_update_btn']; ?>
    </button>` :
  `<span class="text-muted" style="font-size:.78rem;">${book.status === 'completed' ? '<?php echo $lang['provider_dash']['card_finished']; ?>' : '<?php echo $lang['provider_dash']['card_no_action']; ?>'}</span>`;
    return `
      <div class="col-12 col-sm-6 col-xl-4">
        <div class="bkg-card status-${book.status}">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
              <div class="client-initial">${initial}</div>
              <div>
                <p class="mb-0 fw-semibold" style="font-size:.9rem;">${book.client_name}</p>
                <small class="text-muted">#${book.order_id}</small>
              </div>
            </div>
            ${badge}
          </div>

          <div class="bkg-info-row">
    <i class="bi bi-geo-alt"></i>
    <span>${book.location || '—'}</span>
    ${book.lat && book.lng && book.status !== 'cancelled' ? 
        `<a href="https://www.google.com/maps?q=${book.lat},${book.lng}" 
            target="_blank"
            class="btn btn-sm btn-outline-success rounded-pill px-2 ms-1"
            style="font-size:.72rem;">
            <i class="bi bi-map-fill"></i>
        </a>` : ''}
</div>
          <div class="bkg-info-row">
            <i class="bi bi-calendar3"></i>
            <span>${book.date_time || '—'}</span>
          </div>
          ${book.note ? `
          <div class="bkg-info-row">
            <i class="bi bi-chat-left-text"></i>
            <span style="color:#999">${book.note}</span>
          </div>` : ''}

          <div class="d-flex justify-content-between align-items-center mt-3 pt-2"
               style="border-top:1px solid #f0f0f0;">
            <a href="https://wa.me/${String(book.whatsapp || '').replace(/\D/g, '').replace(/^0/, '970')}"target="_blank"
               class="btn-whatsapp" onclick="event.stopPropagation()">
              <i class="bi bi-whatsapp"></i> <?php echo $lang['provider_dash']['tbl_whatsapp']; ?>
            </a>
            ${footerActions}
          </div>
        </div>
      </div>`;
  }).join('');
}

// ربط فلاتر الأزرار
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.bkg-filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.bkg-filter-btn').forEach(b => {
        b.classList.remove('active','btn-teal');
        b.classList.add('btn-outline-secondary');
      });
      this.classList.add('active','btn-teal');
      this.classList.remove('btn-outline-secondary');
      _currentFilter = this.dataset.filter;
      renderBookingCards();
    });
  });

  document.getElementById('bkgSearch')?.addEventListener('input', renderBookingCards);
  document.getElementById('bkgSort')?.addEventListener('change', renderBookingCards);
});

// ==========================================
// 6. MOBILE SIDEBAR TOGGLE
// ==========================================
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('active');
});

document.getElementById('sidebarOverlay').addEventListener('click', function () {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('active');
});

</script>
</body>
</html>