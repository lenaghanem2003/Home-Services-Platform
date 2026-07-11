<?php
require "config.php";
require "translate_helper.php";

?>
<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $lang['admin']['page_title']; ?></title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <link href="navbarStyle.css" rel="stylesheet">
  <style>
    /* ===== متغيرات الألوان ===== */
    :root {
      --primary:       #1a3c6e;   /* أزرق داكن - لون رئيسي */
      --primary-light: #2563a8;   /* أزرق فاتح */
      --accent:        #f59e0b;   /* برتقالي - لون مميز */
      --bg:            #f0f4f8;   /* خلفية الصفحة */
      --sidebar-bg:    #0f2444;   /* خلفية الشريط الجانبي */
      --sidebar-text:  #c8d8f0;   /* نص الشريط الجانبي */
      --card-bg:       #ffffff;   /* خلفية البطاقات */
      --danger:        #dc3545;
      --success:       #198754;
      --border:        #dee2e6;
    }

    /* ===== الأساس ===== */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Cairo', sans-serif;  /* خط عربي */
      background: var(--bg);
      color: #1e293b;
      display: flex;
      min-height: 100vh;
    }
/* ===== الشريط الجانبي المطوّر ===== */
#sidebar {
  width: 250px;
  height: 100vh;
  background: var(--sidebar-bg);
  color: var(--sidebar-text);
  display: flex;
  flex-direction: column;
  position: fixed;         /* يثبت على الشاشة */
  top: 0;
  z-index: 1040;           /* أعلى من الـ topbar لضمان عدم التداخل */
  transition: transform 0.3s ease, right 0.3s ease, left 0.3s ease;
}

/* ضبط مكان الـ sidebar بناءً على اتجاه لغة الموقع */
[dir="rtl"] #sidebar { right: 0; left: auto; }
[dir="ltr"] #sidebar { left: 0;  right: auto; }
    /* شعار الشريط الجانبي */
    .sidebar-logo {
      padding: 1.5rem 1.2rem;
      border-bottom: 1px solid rgba(255,255,255,0.1);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .sidebar-logo .logo-icon {
      width: 38px; height: 38px;
      background: var(--accent);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 18px;
    }
    .sidebar-logo span {
      font-size: 15px; font-weight: 700; color: #fff;
      line-height: 1.3;
    }
    /* روابط الشريط الجانبي */
    .sidebar-nav { padding: 1rem 0; flex: 1; }
    .nav-section-title {
      font-size: 11px; text-transform: uppercase;
      color: rgba(200,216,240,0.5);
      padding: 0.5rem 1.2rem 0.3rem;
      letter-spacing: 1px;
    }
    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 0.65rem 1.2rem;
      color: var(--sidebar-text);
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
       border-inline-end: 3px solid transparent;
      transition: all 0.2s;
      cursor: pointer;

    }
    .sidebar-link:hover, .sidebar-link.active {
      background: rgba(255,255,255,0.08);
      color: #fff;
      
    }
    .sidebar-link i { font-size: 17px; }

    /* ===== المحتوى الرئيسي ===== */
    #main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    [dir="rtl"] #main-content { margin-right: 250px; margin-left: 0; }
[dir="ltr"] #main-content { margin-left: 250px;  margin-right: 0; }

    /* ===== شريط الأعلى ===== */
    #topbar {
      background: var(--card-bg);
      border-bottom: 1px solid var(--border);
      padding: 0.8rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky; top: 0; z-index: 999;
    }
    #topbar {
    display: flex !important;
  }
    .topbar-title { font-size: 18px; font-weight: 700; color: var(--primary); }
    #sidebar-toggle {
      background: none; border: none;
      font-size: 22px; color: var(--primary);
      display: none;   /* مخفي على الشاشة الكبيرة */
      cursor: pointer;
    }

    /* ===== منطقة المحتوى ===== */
    .page-content { padding: 1.5rem; flex: 1; }

    /* ===== البطاقات الإحصائية ===== */
    .stat-card {
      background: var(--card-bg);
      border-radius: 14px;
      padding: 1.2rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      border: 1px solid var(--border);
    }
    .stat-icon {
      width: 52px; height: 52px;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; color: #fff;
      flex-shrink: 0;
    }
    .stat-info .label { font-size: 12px; color: #64748b; font-weight: 600; }
    .stat-info .value { font-size: 26px; font-weight: 800; color: var(--primary); }

    /* ===== البطاقات العامة ===== */
    .card-box {
      background: var(--card-bg);
      border-radius: 14px;
      border: 1px solid var(--border);
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      overflow: hidden;
    }
    .card-box-header {
      padding: 1rem 1.2rem;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #fafbfc;
    }
    .card-box-header h5 {
      font-size: 15px; font-weight: 700;
      color: var(--primary); margin: 0;
      display: flex; align-items: center; gap: 8px;
    }
    .card-box-body { padding: 1rem 1.2rem; }

    /* ===== الجداول ===== */
    .table-hover tbody tr:hover { background: #f8faff; }  /* تلوين عند المرور */
    .table th {
      font-size: 12px; text-transform: uppercase;
      color: #64748b; font-weight: 700;
      background: #f8fafc;
      border-bottom: 2px solid var(--border);
    }
    .table td { font-size: 13px; vertical-align: middle; }

    /* ===== الصفحات - تبويبات ===== */
    .page-section { display: none; }        /* مخفي افتراضياً */
    .page-section.active { display: block; } /* يظهر عند الاختيار */

    /* ===== شارات الحالة ===== */
    .badge-role {
      font-size: 11px; padding: 3px 8px;
      border-radius: 6px; font-weight: 600;
    }

    /* ===== زر الحذف ===== */
    .btn-delete {
      background: none; border: 1px solid #fca5a5;
      color: var(--danger); border-radius: 7px;
      padding: 3px 10px; font-size: 12px;
      transition: all 0.2s; cursor: pointer;
    }
    .btn-delete:hover { background: var(--danger); color: #fff; }

    /* ===== حقل البحث ===== */
    .search-box {
      position: relative; max-width: 280px;
    }
    .search-box input {
      padding-right: 36px;   /* مسافة للأيقونة */
      border-radius: 8px;
      border: 1px solid var(--border);
      font-family: 'Cairo', sans-serif;
      font-size: 13px;
    }
    .search-box i {
      position: absolute; right: 10px; top: 50%;
      transform: translateY(-50%);
      color: #94a3b8; font-size: 14px;
    }

    /* ===== النماذج في المودال ===== */
    .modal-header { background: var(--primary); color: #fff; }
    .modal-header .btn-close { filter: invert(1); }  /* زر الإغلاق يظهر بالأبيض */
    .form-label { font-size: 13px; font-weight: 600; color: #374151; }
    .form-control, .form-select {
      font-family: 'Cairo', sans-serif;
      font-size: 13px; border-radius: 8px;
    }

    /* ===== الصفحة المصغرة المتجاوبة (Responsive) ===== */
    @media (max-width: 991.98px) {
      #sidebar {
        transform: translateX(100%); 
      }
      [dir="ltr"] #sidebar {
        transform: translateX(-100%);
      }
      #sidebar.show {
        transform: translateX(0) !important;     
      }
      #main-content { 
        margin-right: 0 !important; 
        margin-left: 0 !important;
        width: 100% !important; 
      }
      #sidebar-toggle { 
        display: block;
      } 
    }
    #sidebar-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.4);
      z-index: 999;
    }
    #sidebar-overlay.show { display: block; }

    /* ===== قسم الأصناف - accordion ===== */
    .category-accordion .accordion-button {
      font-family: 'Cairo', sans-serif;
      font-weight: 600; font-size: 14px;
      background: #f0f4f8;
    }
    .category-accordion .accordion-button:not(.collapsed) {
      background: #dbeafe; color: var(--primary);
    }
    .service-row {
      display: flex; align-items: center;
      justify-content: space-between;
      padding: 0.5rem 0;
      border-bottom: 1px solid #f1f5f9;
    }
    .service-row:last-child { border-bottom: none; }
    .service-name { font-size: 13px; font-weight: 600; }
    
    /* ===== تعديل الـ Toast Notifications لتصبح بالأسفل يسار وبألوان صحيحة ===== */
    #toast-container {
      position: fixed;
      bottom: 24px;
      left: 24px;       /* النقل إلى جهة اليسار */
      right: auto;      /* إلغاء اليمين لضمان بقائها يساراً دائماً */
      z-index: 99999;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .toast-item {
      min-width: 280px;
      max-width: 360px;
      padding: 12px 16px;
      border-radius: 10px;
      font-family: 'Cairo', sans-serif;
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.15);
      animation: toastIn 0.3s ease;
      color: #ffffff !important; /* ضمان ظهور الخط بالأبيض */
    }
    /* فرض الألوان بشكل صريح بقوة الـ !important */
    .toast-item.toast-success { background-color: #198754 !important; background: #198754 !important; }
    .toast-item.toast-danger  { background-color: #dc3545 !important; background: #dc3545 !important; }
    .toast-item.toast-warning { background-color: #f59e0b !important; background: #f59e0b !important; color: #1e293b !important; }
    
    @keyframes toastIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>


<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<aside id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon"><i class="bi bi-house-heart-fill"></i></div>
    <span><?php echo nl2br($lang['admin']['sidebar_title']); ?></span>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section-title"><?php echo $lang['admin']['nav_section_main']; ?></div>
    <a class="sidebar-link active" onclick="showPage('dashboard', event)">
      <i class="bi bi-grid-1x2-fill"></i> <?php echo $lang['admin']['nav_dashboard']; ?>
    </a>
    <a class="sidebar-link" onclick="showPage('categories', event)">
      <i class="bi bi-tags-fill"></i> <?php echo $lang['admin']['nav_categories']; ?>
    </a>
    <a class="sidebar-link" onclick="showPage('customers', event)">
      <i class="bi bi-people-fill"></i> <?php echo $lang['admin']['nav_customers']; ?>
    </a>
    <a class="sidebar-link" onclick="showPage('providers', event)">
      <i class="bi bi-person-badge-fill"></i> <?php echo $lang['admin']['nav_providers']; ?>
    </a>
    <a class="sidebar-link" href="logout.php">
      <i class="bi bi-box-arrow-left"></i> <?php echo $lang['admin']['nav_logout']; ?>
    </a>
  </nav>
</aside>

<div id="main-content">
     <div id="topbar">
    <button id="sidebar-toggle" onclick="toggleSidebar()">
      <i class="bi bi-list"></i>
    </button>
     <div class="d-flex gap-2">
        <a href="?lang=ar"
           class="btn btn-sm <?php echo ($_SESSION['lang'] ?? 'en') == 'ar' ? 'btn-primary' : 'btn-outline-primary'; ?>">
           العربية
        </a>

        <a href="?lang=en"
           class="btn btn-sm <?php echo ($_SESSION['lang'] ?? 'en') == 'en' ? 'btn-primary' : 'btn-outline-primary'; ?>">
           English
        </a>
    </div>
  </div>


  <div class="page-content">

    <section id="page-dashboard" class="page-section active">
      <div class="mb-3">
        <h4 class="fw-bold" style="color:var(--primary)"><?php echo $lang['admin']['dash_welcome']; ?></h4>
        <p class="text-muted" style="font-size:13px"><?php echo $lang['admin']['dash_subtitle']; ?></p>
      </div>
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#2563a8"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
              <div class="label"><?php echo $lang['admin']['stat_customers']; ?></div>
              <div class="value" id="stat-customers">-</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#059669"><i class="bi bi-person-badge-fill"></i></div>
            <div class="stat-info">
              <div class="label"><?php echo $lang['admin']['stat_providers']; ?></div>
              <div class="value" id="stat-providers">-</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#d97706"><i class="bi bi-tags-fill"></i></div>
            <div class="stat-info">
              <div class="label"><?php echo $lang['admin']['stat_categories']; ?></div>
              <div class="value" id="stat-categories">-</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#7c3aed"><i class="bi bi-tools"></i></div>
            <div class="stat-info">
              <div class="label"><?php echo $lang['admin']['stat_services']; ?></div>
              <div class="value" id="stat-services">-</div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-box mb-4">
        <div class="card-box-header">
          <h5><i class="bi bi-clock-history"></i> <?php echo $lang['admin']['recent_customers_title']; ?></h5>
        </div>
        <div class="card-box-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th><?php echo $lang['admin']['tbl_num']; ?></th><th><?php echo $lang['admin']['tbl_name']; ?></th><th><?php echo $lang['admin']['tbl_phone']; ?></th><th><?php echo $lang['admin']['tbl_governorate']; ?></th>
                </tr>
              </thead>
              <tbody id="dash-customers-table">
                <tr><td colspan="4" class="text-center text-muted py-3"><?php echo $lang['admin']['loading']; ?></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <section id="page-categories" class="page-section">
      <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0" style="color:var(--primary)">
          <i class="bi bi-tags-fill me-2"></i><?php echo $lang['admin']['categories_title']; ?>
        </h5>
        <button class="btn btn-sm btn-primary" style="font-family:'Cairo'" onclick="openModal('modal-add-category')">
          <i class="bi bi-plus-lg me-1"></i><?php echo $lang['admin']['btn_add_category']; ?>
        </button>
      </div>
      <div id="categories-list" class="accordion category-accordion">
        <div class="text-center text-muted py-4"><?php echo $lang['admin']['loading']; ?></div>
      </div>
    </section>

    <section id="page-customers" class="page-section">
      <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0" style="color:var(--primary)">
          <i class="bi bi-people-fill me-2"></i><?php echo $lang['admin']['customers_title']; ?>
        </h5>
        <div class="search-box">
          <i class="bi bi-search"></i>
          <input type="text" class="form-control" id="search-customers"
                 placeholder="<?php echo $lang['admin']['search_customers_ph']; ?>"
                 oninput="filterTable('customers-table', this.value)" />
        </div>
      </div>
      <div class="card-box">
        <div class="table-responsive">
          <table class="table table-hover mb-0" id="customers-table">
            <thead>
              <tr>
                <th><?php echo $lang['admin']['tbl_num']; ?></th><th><?php echo $lang['admin']['tbl_name']; ?></th><th><?php echo $lang['admin']['tbl_phone']; ?></th>
                <th><?php echo $lang['admin']['tbl_governorate']; ?></th><th><?php echo $lang['admin']['tbl_email']; ?></th><th><?php echo $lang['admin']['tbl_actions']; ?></th>
              </tr>
            </thead>
            <tbody id="customers-tbody">
              <tr><td colspan="6" class="text-center text-muted py-3"><?php echo $lang['admin']['loading']; ?></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <section id="page-providers" class="page-section">
      <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0" style="color:var(--primary)">
          <i class="bi bi-person-badge-fill me-2"></i><?php echo $lang['admin']['providers_title']; ?>
        </h5>
        <div class="search-box">
          <i class="bi bi-search"></i>
          <input type="text" class="form-control" id="search-providers"
                 placeholder="<?php echo $lang['admin']['search_providers_ph']; ?>"
                 oninput="filterTable('providers-table', this.value)" />
        </div>
      </div>
      <div class="card-box">
        <div class="table-responsive">
          <table class="table table-hover mb-0" id="providers-table">
            <thead>
              <tr>
                <th><?php echo $lang['admin']['tbl_num']; ?></th><th><?php echo $lang['admin']['tbl_name']; ?></th><th><?php echo $lang['admin']['tbl_phone']; ?></th>
                <th><?php echo $lang['admin']['tbl_governorate']; ?></th><th><?php echo $lang['admin']['tbl_email']; ?></th><th><?php echo $lang['admin']['tbl_actions']; ?></th>
              </tr>
            </thead>
            <tbody id="providers-tbody">
              <tr><td colspan="6" class="text-center text-muted py-3"><?php echo $lang['admin']['loading']; ?></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

  </div>
</div>

<div class="modal fade" id="modal-add-category" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-family:'Cairo'">
          <i class="bi bi-plus-circle me-2"></i><?php echo $lang['admin']['modal_add_cat_title']; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label"><?php echo $lang['admin']['cat_name_label']; ?> </label>
          <input type="text" id="cat-name-en" class="form-control" placeholder="<?php echo $lang['admin']['cat_name_placeholder']; ?>" />
        </div>
        <div class="mb-3">
          <label class="form-label"><?php echo $lang['admin']['cat_desc_label']; ?> </label>
          <textarea id="cat-desc-en" class="form-control" rows="2" placeholder="<?php echo $lang['admin']['cat_desc_placeholder']; ?>"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-family:'Cairo'"><?php echo $lang['admin']['btn_cancel']; ?></button>
        <button class="btn btn-primary btn-sm" style="font-family:'Cairo'" onclick="addCategory()">
          <i class="bi bi-check-lg me-1"></i><?php echo $lang['admin']['btn_save']; ?>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-add-service" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-family:'Cairo'">
          <i class="bi bi-plus-circle me-2"></i><?php echo $lang['admin']['modal_add_svc_title']; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="svc-category-id" />
        <div class="mb-3">
          <label class="form-label"><?php echo $lang['admin']['svc_name_ar_label']; ?></label>
          <input type="text" id="svc-name-ar" class="form-control" placeholder="<?php echo $lang['admin']['svc_name_ar_ph']; ?>" />
        </div>
        <div class="mb-3">
          <label class="form-label"><?php echo $lang['admin']['svc_name_en_label']; ?></label>
          <input type="text" id="svc-name-en" class="form-control" placeholder="<?php echo $lang['admin']['svc_name_en_ph']; ?>" />
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-family:'Cairo'"><?php echo $lang['admin']['btn_cancel']; ?></button>
        <button class="btn btn-primary btn-sm" style="font-family:'Cairo'" onclick="addService()">
          <i class="bi bi-check-lg me-1"></i><?php echo $lang['admin']['btn_save']; ?>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-confirm-delete" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="background:#dc3545">
        <h5 class="modal-title" style="font-family:'Cairo'">
          <i class="bi bi-exclamation-triangle me-2"></i><?php echo $lang['admin']['modal_delete_title']; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center" style="font-family:'Cairo';font-size:14px">
        <p id="delete-confirm-msg"><?php echo $lang['admin']['delete_confirm_default']; ?></p>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="font-family:'Cairo'"><?php echo $lang['admin']['btn_cancel']; ?></button>
        <button class="btn btn-danger btn-sm" style="font-family:'Cairo'" id="confirm-delete-btn">
          <i class="bi bi-trash me-1"></i><?php echo $lang['admin']['btn_confirm_delete']; ?>
        </button>
      </div>
    </div>
  </div>
</div>

<div id="toast-container"></div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function showPage(pageName, event) {
    document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
    document.getElementById('page-' + pageName).classList.add('active');
 
    document.querySelectorAll('.sidebar-link').forEach(a => a.classList.remove('active'));
    if(event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
 
    if (window.innerWidth < 992) {
        closeSidebar();
    }
}
 
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');   
    document.getElementById('sidebar-overlay').classList.toggle('show'); 
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('show');   
    document.getElementById('sidebar-overlay').classList.remove('show'); 
}
 
function openModal(id) {
    const el = document.getElementById(id);
    let instance = bootstrap.Modal.getInstance(el);
    if (!instance) {
        instance = new bootstrap.Modal(el);
    }
    instance.show();
}
 
function closeModal(id) {
    const el = document.getElementById(id);
    const instance = bootstrap.Modal.getInstance(el);
    if (instance) {
        instance.hide();
    }
}

function filterTable(tableId, query) {
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    const q = query.trim().toLowerCase();
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
 
function loadDashboardStats() {
    fetch('admin_actions.php?action=get_stats')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('stat-customers').textContent  = data.customers  ?? '0';
                document.getElementById('stat-providers').textContent  = data.providers  ?? '0';
                document.getElementById('stat-categories').textContent = data.categories ?? '0';
                document.getElementById('stat-services').textContent   = data.services   ?? '0';
            }
        })
        .catch(err => console.error('Stats error:', err));
}
 
function loadDashboardCustomers() {
    const tbody = document.getElementById('dash-customers-table');
    fetch('admin_actions.php?action=get_recent_customers')
        .then(res => res.json())
        .then(data => {
            tbody.innerHTML = '';
            if (!data.success || data.customers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3"><?php echo $lang['admin']['no_data']; ?></td></tr>';
                return;
            }
            data.customers.forEach((c, i) => {
                tbody.innerHTML += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${c.full_name}</td>
                    <td>${c.phone}</td>
                    <td>${c.governorate ?? '—'}</td>
                </tr>`;
            });
        })
        .catch(err => {
            console.error('Recent customers error:', err);
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger py-3"><?php echo $lang['admin']['toast_server_error']; ?></td></tr>';
        });
}
 
function loadCustomers() {
    const tbody = document.getElementById('customers-tbody');
    fetch('admin_actions.php?action=get_customers')
        .then(res => res.json())
        .then(data => {
            tbody.innerHTML = '';
            if (!data.success || data.customers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-3"><?php echo $lang['admin']['no_data']; ?></td></tr>';
                return;
            }
            data.customers.forEach((c, i) => {
                tbody.innerHTML += createUserRow(c, i + 1, 'customer');
            });
        })
        .catch(err => {
            console.error('Customers error:', err);
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger py-3"><?php echo $lang['admin']['toast_server_error']; ?></td></tr>';
        });
}
 
function loadProviders() {
    const tbody = document.getElementById('providers-tbody');
    fetch('admin_actions.php?action=get_providers')
        .then(res => res.json())
        .then(data => {
            tbody.innerHTML = '';
            if (!data.success || data.providers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-3"><?php echo $lang['admin']['no_data']; ?></td></tr>';
                return;
            }
            data.providers.forEach((p, i) => {
                tbody.innerHTML += createUserRow(p, i + 1, 'provider');
            });
        })
        .catch(err => {
            console.error('Providers error:', err);
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger py-3"><?php echo $lang['admin']['toast_server_error']; ?></td></tr>';
        });
}
 
function createUserRow(u, index, type) {
    return `
    <tr>
        <td>${index}</td>
        <td>${u.first_name} ${u.last_name}</td>
        <td>${u.phone ?? '—'}</td>
        <td>${u.governorate ?? '—'}</td>
        <td>${u.email ?? '—'}</td>
        <td>
            <button class="btn btn-danger btn-sm" onclick="confirmDelete('${type}', ${u.id}, '${u.first_name} ${u.last_name}')">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>`;
}
 
function loadCategories() {
    const container = document.getElementById('categories-list');
    Promise.all([
        fetch('admin_actions.php?action=get_categories').then(res => res.json()),
        fetch('admin_actions.php?action=get_services').then(res => res.json())
    ])
    .then(([categoriesData, servicesData]) => {
        container.innerHTML = '';
        if (!categoriesData.success || categoriesData.categories.length === 0) {
            container.innerHTML = '<div class="text-center text-muted py-4"><?php echo $lang['admin']['no_categories']; ?></div>';
            return;
        }
        const allCategories = categoriesData.categories;
        const allServices = (servicesData.success && servicesData.services) ? servicesData.services : [];
        allCategories.forEach(cat => {
            cat.services = allServices.filter(svc => parseInt(svc.category_id) === parseInt(cat.id));
            container.innerHTML += createCategoryAccordion(cat);
        });
    })
    .catch(err => {
        console.error('Categories & Services load error:', err);
        container.innerHTML = '<div class="text-center text-danger py-4"><?php echo $lang['admin']['toast_server_error']; ?></div>';
    });
}
 
function createCategoryAccordion(cat) {
    const services = (cat.services && cat.services.length > 0)
        ? cat.services.map(s => `
            <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                <span>
                    <i class="bi bi-wrench me-2 text-muted"></i>
                    ${s.name_ar} <small class="text-muted">(${s.name_en})</small>
                </span>
                <button class="btn btn-outline-danger btn-sm" onclick="event.stopPropagation(); confirmDelete('service', ${s.id}, '${s.name_ar}')">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`).join('')
        : '<div class="text-muted py-2" style="font-size:13px"><?php echo $lang['admin']['no_services_in_cat']; ?></div>';
 
    return `
    <div class="accordion-item mb-2" id="cat-item-${cat.id}">
        <div class="accordion-header d-flex align-items-center justify-content-between p-3"
             style="cursor:pointer;background:var(--bs-light);border-radius:8px"
             onclick="toggleAccordion(${cat.id})">
            <span class="fw-bold">
                <i class="bi bi-tags-fill me-2" style="color:var(--primary)"></i>
                ${cat.name_ar ? cat.name_ar : cat.name_en} </span>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary btn-sm" onclick="event.stopPropagation(); openAddServiceModal(${cat.id})">
                    <i class="bi bi-plus-lg"></i> <?php echo $lang['admin']['btn_add_service']; ?>
                </button>
                <button class="btn btn-outline-danger btn-sm" onclick="event.stopPropagation(); confirmDelete('category', ${cat.id}, '${cat.name_ar ?? cat.name_en}')">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        <div class="accordion-body px-3 py-2" id="cat-body-${cat.id}" style="display:none">
            ${services}
        </div>
    </div>`;
}
 
function toggleAccordion(catId) {
    const body = document.getElementById('cat-body-' + catId);
    body.style.display = body.style.display === 'none' ? 'block' : 'none';
}
 
function addCategory() {
    const name = document.getElementById('cat-name-en').value.trim();
    const desc = document.getElementById('cat-desc-en').value.trim();
 
    if (!name) {
        showAlert('<?php echo $lang['admin']['toast_fill_cat_name']; ?>', 'w');
        return;
    }
 
    fetch('add_category.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ Category_Name: name, Category_Description: desc })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeModal('modal-add-category');
            document.getElementById('cat-name-en').value = '';
            document.getElementById('cat-desc-en').value = '';
            showAlert('<?php echo $lang['admin']['toast_added_cat']; ?>', 's');
            loadCategories();
            loadDashboardStats();
        } else {
            showAlert(data.message || 'فشلت إضافة الصنف', 'e');
        }
    })
    .catch(err => {
        console.error('Add category error:', err);
        showAlert('<?php echo $lang['admin']['toast_server_error']; ?>', 'e');
    });
}
 
function openAddServiceModal(categoryId) {
    document.getElementById('svc-category-id').value = categoryId;
    document.getElementById('svc-name-ar').value = '';
    document.getElementById('svc-name-en').value = '';
    openModal('modal-add-service');
}
 
function addService() {
    const categoryId = document.getElementById('svc-category-id').value;
    const nameAr     = document.getElementById('svc-name-ar').value.trim();
    const nameEn     = document.getElementById('svc-name-en').value.trim();
 
    if (!nameAr && !nameEn) {
        showAlert('<?php echo $lang['admin']['toast_fill_svc_name']; ?>', 'w');
        return;
    }
    const serviceName = nameEn || nameAr; 
 
    fetch('add_service.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ Service_Name: serviceName, Category_ID: categoryId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeModal('modal-add-service');
            showAlert('<?php echo $lang['admin']['toast_added_svc']; ?>', 's');
            loadCategories();
            loadDashboardStats();
        } else {
            showAlert(data.message || 'فشلت إضافة الخدمة', 'e');
        }
    })
    .catch(err => {
        console.error('Add service error:', err);
        showAlert('<?php echo $lang['admin']['toast_server_error']; ?>', 'e');
    });
}
 
let pendingDeleteType = null;
let pendingDeleteId   = null;
 
function confirmDelete(type, id, name) {
    pendingDeleteType = type;
    pendingDeleteId   = id;
    const typeLabels = { customer: 'العميل', provider: 'مزود الخدمة', category: 'الصنف', service: 'الخدمة' };
    document.getElementById('delete-confirm-msg').textContent = `هل أنت متأكد من حذف ${typeLabels[type] || ''}: "${name}"؟`;
    document.getElementById('confirm-delete-btn').onclick = doDelete;
    openModal('modal-confirm-delete');
}
 
function doDelete() {
    if (!pendingDeleteType || !pendingDeleteId) return;
    closeModal('modal-confirm-delete');
 
    fetch('admin_delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete_' + pendingDeleteType, id: pendingDeleteId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showAlert('<?php echo $lang['admin']['toast_deleted']; ?>', 's');
            if (pendingDeleteType === 'customer') {
                loadCustomers(); loadDashboardStats(); loadDashboardCustomers();
            } else if (pendingDeleteType === 'provider') {
                loadProviders(); loadDashboardStats();
            } else if (pendingDeleteType === 'category' || pendingDeleteType === 'service') {
                loadCategories(); loadDashboardStats();
            }
        } else {
            showAlert(data.message || 'فشل الحذف', 'e');
        }
        pendingDeleteType = null; pendingDeleteId = null;
    })
    .catch(err => {
        console.error('Delete error:', err);
        showAlert('<?php echo $lang['admin']['toast_server_error']; ?>', 'e');
    });
}

/* ===== تم التعديل لتسريع الاختفاء إلى ثانيتين فقط وجلب الخصائص بنجاح ===== */
function showAlert(msg, type = 's') {
    const container = document.getElementById('toast-container');
    const map = {
        s: { cls: 'toast-success', icon: 'bi-check-circle-fill' },
        e: { cls: 'toast-danger',  icon: 'bi-x-circle-fill'     },
        w: { cls: 'toast-warning', icon: 'bi-exclamation-triangle-fill' }
    };
    const { cls, icon } = map[type] || map.s;
    const toast = document.createElement('div');
    toast.className = `toast-item ${cls}`;
    toast.innerHTML = `<i class="bi ${icon}" style="font-size:16px;flex-shrink:0"></i><span>${msg}</span>`;
    container.appendChild(toast);
    
    // يختفي التنبيه بعد 2000 ميلي ثانية (ثانيتين) بدلاً من 3200 ثانية
    setTimeout(() => {
        toast.style.transition = 'opacity 0.2s';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 200);
    }, 2000);
}
 
document.addEventListener('DOMContentLoaded', () => {
    loadDashboardStats();
    loadDashboardCustomers();
    loadCustomers();
    loadProviders();
    loadCategories();
});
</script>
</body>
</html>