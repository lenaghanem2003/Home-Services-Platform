<?php
 require "config.php";
 
?>

<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $lang['customer_dash']['page_title']?></title>
  <?php if ($_SESSION['lang'] === 'ar'): ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.rtl.min.css">
  <?php else: ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
  <?php endif; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <link href="navbarStyle.css" rel="stylesheet">
  <style>

    * { box-sizing: border-box; margin: 0; padding: 0 }

    body {
      font-family: 'Cairo', sans-serif;
      min-height: 100vh;
      color: #2d3a35;
      overflow-x: hidden;
      background: linear-gradient(155deg, #eef5f7 0%, #f5ede0 50%, #fdf0e8 100%);
    }

    /* ── خلفية ── */
    .bg-wrap {
      position: fixed; inset: 0; z-index: 0; pointer-events: none;
      background:
        radial-gradient(ellipse 65% 55% at 10% 10%, rgba(111,164,175,.22) 0%, transparent 65%),
        radial-gradient(ellipse 55% 50% at 90% 85%, rgba(201,132,138,.18) 0%, transparent 60%),
        linear-gradient(155deg, #eef5f7 0%, #f5ede0 50%, #fdf0e8 100%);
    }

    .orb {
      position: fixed; border-radius: 50%;
      filter: blur(80px); pointer-events: none; z-index: 0;
      animation: ob 14s ease-in-out infinite;
    }
    .orb-teal  { width:420px; height:420px; background:rgba(111,164,175,.25); top:-140px; right:-100px; opacity:.6; }
    .orb-rose  { width:320px; height:320px; background:rgba(201,132,138,.22); bottom:-80px; left:-60px; opacity:.5; animation-delay:-6s; }
    .orb-gold  { width:220px; height:220px; background:rgba(212,168,67,.18); top:38%; left:35%; opacity:.35; animation-delay:-11s; }

    @keyframes ob {
      0%,100% { transform: translateY(0) }
      50%      { transform: translateY(-22px) }
    }

    /* ── تخطيط ── */
    .layout { display: flex; min-height: 100vh; position: relative; z-index: 1; }

    /* ═══ SIDEBAR ═══ */
    .sidebar {
      width: 70px;
      top:0;
      min-height: 100vh;
      background: rgba(255,255,255,.62);
      backdrop-filter: blur(24px);
      border-left: 1px solid rgba(111,164,175,.28);
      display: flex; flex-direction: column; align-items: center;
      padding: 22px 0;
      position: fixed; top:0; right:0; height:100%; z-index:200;
      transition: width .28s ease;
      overflow: hidden;
      box-shadow: -2px 0 20px rgba(111,164,175,.12);
    }
    .sidebar:hover, .sidebar.open { width: 226px; align-items: flex-start; }

    .sidebar-logo {
      display: flex; align-items: center; gap: 11px;
      padding: 0 16px; margin-bottom: 26px;
      white-space: nowrap; min-width: 226px;
    }
    .sidebar-logo-icon {
      width:40px; height:40px; border-radius:12px; flex-shrink:0;
      background: linear-gradient(135deg, #6FA4AF, #c9848a);
      display:flex; align-items:center; justify-content:center;
      font-size:17px; color:#fff;
      box-shadow: 0 4px 14px rgba(111,164,175,.4);
    }
    .sidebar-logo-text {
      font-size:19px; font-weight:900;
      background: linear-gradient(135deg, #6FA4AF, #c9848a);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      opacity: 0; transition: opacity .18s;
    }
    .sidebar:hover .sidebar-logo-text,
    .sidebar.open  .sidebar-logo-text { opacity: 1; }

    /* دائرة المستخدم */
    .sidebar-avatar {
      width:42px; height:42px; border-radius:50%; flex-shrink:0;
      background: linear-gradient(135deg, #6FA4AF, #c9848a);
      display:flex; align-items:center; justify-content:center;
      font-size:17px; font-weight:800; color:#fff;
      margin: 0 auto 26px;
      box-shadow: 0 0 0 3px rgba(111,164,175,.3), 0 0 0 6px rgba(111,164,175,.1);
      animation: rp 3.2s ease-in-out infinite;
      transition: margin .28s;
    }
    .sidebar:hover .sidebar-avatar,
    .sidebar.open  .sidebar-avatar { margin-right: 16px; margin-left: 0; }

    @keyframes rp {
      0%,100% { box-shadow: 0 0 0 3px rgba(111,164,175,.3), 0 0 0 6px rgba(111,164,175,.1) }
      50%      { box-shadow: 0 0 0 5px rgba(111,164,175,.4), 0 0 0 10px rgba(111,164,175,.06) }
    }

    /* روابط القائمة */
    .sidebar-nav { width:100%; list-style:none; padding:0; flex:1;}
    .sidebar-nav li { margin-bottom: 3px; }
    .sidebar-nav a {
      display:flex; align-items:center; gap:12px;
      padding: 11px 14px; margin: 0 7px;
      color: rgba(45,58,53,.52);
      text-decoration:none; font-size:13.5px; font-weight:600;
      border-radius: 11px; border: 1px solid transparent;
      white-space: nowrap; cursor: pointer;
      transition: background .2s, color .2s;
    }
    .sidebar-nav .nav-icon {
      width:36px; height:36px; border-radius:9px; flex-shrink:0;
      display:flex; align-items:center; justify-content:center; font-size:14px;
      background: rgba(111,164,175,.10);
      transition: background .2s, color .2s;
      
    }
    .sidebar-nav .nav-label { opacity:0; transition: opacity .16s; font-size:13px; }
    .sidebar:hover .sidebar-nav .nav-label,
    .sidebar.open  .sidebar-nav .nav-label { opacity: 1; }

    .sidebar-nav a:hover, .sidebar-nav a.active {
      background: rgba(111,164,175,.18);
      border-color: rgba(111,164,175,.25);
      color: #2d3a35;
    }
    .sidebar-nav a:hover .nav-icon, .sidebar-nav a.active .nav-icon {
      background: linear-gradient(135deg, #6FA4AF, #4d8a96);
      color: #fff;
    }

    /* زر الخروج */
    .sidebar-footer { width:100%; padding: 0 7px; margin-top: 12px; }
    .logout-btn {
      width:100%; padding: 10px 14px; border-radius: 11px;
      background: rgba(201,132,138,.15); border: 1px solid rgba(201,132,138,.3);
      color: #c9848a; font-size:13px; font-weight:600; font-family:'Cairo',sans-serif;
      cursor:pointer; transition: all .22s;
      display:flex; align-items:center; gap:12px; white-space:nowrap;
    }
    .logout-btn .nav-icon {
      width:36px; height:36px; border-radius:9px; flex-shrink:0;
      display:flex; align-items:center; justify-content:center; font-size:14px;
      background: rgba(201,132,138,.15);
    }
    .logout-btn .nav-label { opacity:0; transition: opacity .16s; }
    .sidebar:hover .logout-btn .nav-label,
    .sidebar.open  .logout-btn .nav-label { opacity: 1; }
    .logout-btn:hover { background: rgba(201,132,138,.28); color: #b06068; }

    /* ═══ MAIN ═══ */
    .main-content {
      margin-right: 70px; flex:1; padding: 30px 34px;
      transition: margin-right .28s ease;
    }

    /* TOPBAR */
    .topbar {
      background: rgba(255,255,255,.55);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(111,164,175,.28);
      border-radius: 18px; padding: 13px 20px; margin-bottom: 26px;
      box-shadow: 0 2px 16px rgba(111,164,175,.10);
      animation: fd .42s ease;
    }
    @keyframes fd {
      from { opacity:0; transform: translateY(-14px) }
      to   { opacity:1; transform: none }
    }

    .page-title { font-size:35px; font-weight:900; color:#2d3a35; }
    .page-subtitle { font-size:15px; color: rgba(45,58,53,.82); }

    .date-chip {
      background: rgba(111,164,175,.12); border: 1px solid rgba(111,164,175,.28);
      border-radius:9px; padding: 7px 14px; font-size:12.5px; color:#4d8a96;
      display:flex; align-items:center; gap:7px;
    }
    .mobile-toggle {
      display:none; width:40px; height:40px; border-radius:10px;
      background: rgba(111,164,175,.12); border: 1px solid rgba(111,164,175,.28);
      color:#4d8a96; font-size:16px; cursor:pointer;
      align-items:center; justify-content:center;
    }

    /* ═══ STAT CARD ═══ */
    .stat-card {
      background: rgba(255,255,255,.55);
      backdrop-filter: blur(18px);
      border: 1px solid rgba(111,164,175,.28);
      border-radius: 18px; padding: 20px 18px;
      position: relative; overflow: hidden;
      box-shadow: 0 2px 16px rgba(111,164,175,.08);
      transition: transform .24s, box-shadow .24s;
      animation: slideUp .48s ease both;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(111,164,175,.18); }
    .stat-card::after {
      content:''; position:absolute; bottom:0; left:0; right:0; height:3px;
      border-radius: 0 0 18px 18px;
      background: linear-gradient(90deg, #6FA4AF, #c9848a);
    }
    @keyframes slideUp {
      from { opacity:0; transform: translateY(20px) }
      to   { opacity:1; transform: none }
    }

    .stat-icon {
      width:44px; height:44px; border-radius:12px;
      display:flex; align-items:center; justify-content:center; font-size:18px;
      margin-bottom:13px;
    }
    .stat-number { font-size:28px; font-weight:900; line-height:1; margin-bottom:4px; }
    .stat-label  { font-size:12.5px; color: rgba(45,58,53,.52); }

    /* ═══ TABS ═══ */
    .filter-tabs {
      background: rgba(255,255,255,.5);
      border: 1px solid rgba(111,164,175,.28);
      border-radius:13px; padding:4px;
      display:inline-flex; gap:3px;
      backdrop-filter: blur(10px);
    }
    .filter-tab-btn {
      padding: 8px 18px; border-radius:9px; border:none;
      background: transparent; color: rgba(45,58,53,.52);
      font-size:13px; font-weight:600; font-family:'Cairo',sans-serif;
      cursor:pointer; transition: all .22s;
    }
    .filter-tab-btn.active {
      background: linear-gradient(135deg, #6FA4AF, #4d8a96);
      color:#fff; box-shadow: 0 4px 12px rgba(111,164,175,.35);
    }

    /* ═══ BOOKING CARD — Bootstrap card مخصصة ═══ */
    .booking-card {
      background: rgba(255,255,255,.55) !important;
      backdrop-filter: blur(18px);
      border: 1px solid rgba(111,164,175,.28) !important;
      border-radius: 18px !important;
      margin-bottom:12px;
      position: relative; overflow: hidden;
      box-shadow: 0 2px 12px rgba(111,164,175,.07);
      transition: transform .24s, box-shadow .24s;
      animation: slideUp .4s ease both;
    }
    .booking-card::before {
      content:''; position:absolute; top:0; right:0; bottom:0; width:4px;
      background: #6FA4AF;
      border-radius: 0 18px 18px 0;
    }
    .booking-card:hover {
      transform: translateX(-4px);
      box-shadow: 0 8px 28px rgba(111,164,175,.15);
    }
    .booking-card .card-body { padding: 18px 20px; }

    .booking-title { font-size:25px; font-weight:700; margin-bottom:7px; }
    .booking-meta  { display:flex; flex-wrap:wrap; gap:8px 16px; }
    .booking-meta span { font-size:20px; color: rgba(45,58,53,.52); display:flex; align-items:center; gap:4px; }
    .booking-meta i { color: #6FA4AF; font-size:10.5px; }

    /* شارات الحالة */
    .status-badge { font-size:11px; font-weight:700; padding: 4px 12px; border-radius:20px; }
    .status-confirmed { background: rgba(111,164,175,.15); color:#4d8a96;  border: 1px solid rgba(111,164,175,.3); }
    .status-pending   { background: rgba(212,168,67,.15);  color:#a07820;  border: 1px solid rgba(212,168,67,.3); }
    .status-done      { background: rgba(201,132,138,.12); color:#c9848a;  border: 1px solid rgba(201,132,138,.3); }
    .status-cancelled { background: rgba(180,80,80,.10);   color:#b45050;  border: 1px solid rgba(180,80,80,.25); }

    /* أزرار الأيقونة */
    .booking-actions { display:flex; align-items:center; gap:7px; flex-wrap:wrap; }
    .icon-btn {
      width:35px; height:35px; border-radius:9px;
      display:inline-flex; align-items:center; justify-content:center;
      font-size:14px; cursor:pointer; border:1px solid;
      text-decoration:none; transition: transform .2s, background .2s;
    }
    .icon-btn:hover { transform: scale(1.09); }

    .icon-btn-delete {
      background: rgba(201,132,138,.15);
      border-color: rgba(201,132,138,.35);
      color:#c9848a;
    }
    .icon-btn-delete:hover { background: rgba(201,132,138,.28); }

    .icon-btn-whatsapp {
      background: rgba(37,211,102,.10);
      border-color: rgba(37,211,102,.28);
      color: #1a9e50;
    }
    .icon-btn-whatsapp:hover { background: rgba(37,211,102,.22); }

    .icon-btn-edit {
      background: rgba(212,168,67,.15);
      border-color: rgba(212,168,67,.35);
      color: #a07820;
    }
    .icon-btn-edit:hover { background: rgba(212,168,67,.25); }

    /* زر التقييم */
    .icon-btn-rate {
      background: rgba(212,168,67,.12);
      border-color: rgba(212,168,67,.32);
      color: #a07820;
    }
    .icon-btn-rate:hover { background: rgba(212,168,67,.26); }

    /* ═══ PROFILE ═══ */
    
    .profile-form-card::before {
      content:''; position:absolute; top:0; left:0; right:0; height:4px;
      background: linear-gradient(90deg, #6FA4AF, #c9848a, #d4a843, #6FA4AF);
      background-size: 200%; animation: sh 3.5s linear infinite;
    }
    @keyframes sh {
      0%   { background-position: 200% }
      100% { background-position: -200% }
    }


    /* فورم الملف الشخصي */
    .profile-form-card {
      background: rgba(255,255,255,.55);
      backdrop-filter: blur(18px);
      border: 1px solid rgba(111,164,175,.28);
      border-radius: 18px; padding: 26px;
      box-shadow: 0 2px 16px rgba(111,164,175,.07);
      animation: slideUp .44s ease .08s both;
      position: relative;
      overflow: hidden;
    }
    .section-title {
      font-size:15px; font-weight:700; color:#2d3a35;
      display:flex; align-items:center; gap:9px; margin-bottom:20px;
    }
    .section-title i { color: #6FA4AF; }
    .section-title::after { content:''; flex:1; height:1px; background: rgba(111,164,175,.28); margin-right:9px; }

    .form-label { font-size:12px; font-weight:600; color: rgba(45,58,53,.52); margin-bottom:6px; }

    .form-control, .form-select {
      background: rgba(255,255,255,.65) !important;
      border: 1px solid rgba(111,164,175,.28) !important;
      border-radius: 10px !important;
      color: #2d3a35 !important;
      font-family: 'Cairo', sans-serif; font-size:13.5px; padding: 10px 14px;
    }
    .form-control:focus, .form-select:focus {
      border-color: rgba(111,164,175,.55) !important;
      background: rgba(111,164,175,.08) !important;
      box-shadow: 0 0 0 3px rgba(111,164,175,.12) !important;
      outline: none;
    }
    .form-control::placeholder { color: rgba(45,58,53,.3); }
    .form-select option { background:#fdf8f2; color:#2d3a35; }

    .save-btn {
      background: linear-gradient(135deg, #6FA4AF, #4d8a96);
      border:none; border-radius:11px; color:#fff;
      font-size:14px; font-weight:700; font-family:'Cairo',sans-serif;
      padding: 11px 26px; cursor:pointer;
      box-shadow: 0 4px 14px rgba(111,164,175,.35);
      transition: all .23s;
      display:inline-flex; align-items:center; gap:7px;
    }
    .save-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(111,164,175,.45);}

    /* ═══ EDIT MODAL (يدوي) ═══ */
    .modal-overlay {
      position:fixed; inset:0; background: rgba(45,58,53,.4);
      backdrop-filter: blur(8px); z-index:900;
      display:flex; align-items:center; justify-content:center;
      opacity:0; visibility:hidden; transition: all .26s;
    }
    .modal-overlay.open { opacity:1; visibility:visible; }

    .modal-box {
      background: linear-gradient(145deg, rgba(245,237,224,.96), rgba(253,248,242,.98));
      border: 1px solid rgba(111,164,175,.28);
      border-radius:21px; padding:30px;
      width:94%; max-width:490px; max-height:90vh; overflow-y:auto;
      transform: scale(.91) translateY(16px); transition: all .26s;
      box-shadow: 0 24px 60px rgba(111,164,175,.25);
    }
    .modal-overlay.open .modal-box { transform: scale(1) translateY(0); }

    .modal-header-custom { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    .modal-title-custom {
      font-size:17px; font-weight:800;
      background: linear-gradient(135deg, #6FA4AF, #c9848a);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .modal-close-btn {
      width:32px; height:32px; border-radius:8px;
      background: rgba(201,132,138,.12); border: 1px solid rgba(201,132,138,.25);
      color:#c9848a; cursor:pointer;
      display:flex; align-items:center; justify-content:center;
      transition: all .2s;
    }
    .modal-close-btn:hover { background: rgba(201,132,138,.28); color:#b06068; }

    /* ═══ CANCEL MODAL (Bootstrap) — ألوان مخصصة ═══ */
    #cancelModal .modal-content {
      border-radius: 21px;
      border: 1px solid rgba(111,164,175,.28);
      background: linear-gradient(145deg, rgba(245,237,224,.96), rgba(253,248,242,.98));
      box-shadow: 0 24px 60px rgba(111,164,175,.25);
      font-family: 'Cairo', sans-serif;
    }
    #cancelModal .modal-title-custom {
      font-size:18px; font-weight:800;
      background: linear-gradient(135deg, #6FA4AF, #c9848a);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    /* ═══ RATING MODAL ═══ */
    #ratingModal .modal-content {
      border-radius: 21px;
      border: 1px solid rgba(111,164,175,.28);
      background: linear-gradient(145deg, rgba(245,237,224,.96), rgba(253,248,242,.98));
      box-shadow: 0 24px 60px rgba(111,164,175,.25);
      font-family: 'Cairo', sans-serif;
    }
    .star-rating { display:flex; flex-direction:row-reverse; justify-content:center; gap:6px; margin: 10px 0 18px; }
    .star-rating input { display:none; }
    .star-rating label {
      font-size:36px; cursor:pointer; color:rgba(45,58,53,.18);
      transition: color .2s, transform .2s;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color:#d4a843; transform:scale(1.15); }

    /* ═══ TOAST ═══ */
    .toast-container {
      position:fixed; bottom:26px; left:26px; z-index:9999;
      display:flex; flex-direction:column; gap:9px; pointer-events:none;
    }
    .toast-item {
      background: rgba(245,237,224,.95);
      border: 1px solid rgba(111,164,175,.28);
      border-radius:12px; padding: 12px 17px;
      display:flex; align-items:center; gap:11px;
      backdrop-filter: blur(20px);
      box-shadow: 0 8px 28px rgba(111,164,175,.2);
      font-size:13px; font-weight:600; color:#2d3a35;
      animation: toastIn .32s ease, toastOut .32s ease 2.65s both;
      pointer-events:all; max-width:290px;
    }
    @keyframes toastIn  { from { opacity:0; transform: translateX(-28px) } to { opacity:1; transform:none } }
    @keyframes toastOut { to   { opacity:0; transform: translateX(-28px) } }

    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-thumb { background: rgba(111,164,175,.35); border-radius:3px; }

    /* ═══ RESPONSIVE ═══ */
    @media(max-width:991.98px) {
      .main-content { margin-right:0 !important; padding:16px 14px; }
      .sidebar {
        width:0; padding:0; overflow:hidden;
        transform: translateX(100%); border:none;
        transition: width .28s, transform .28s, padding .28s;
      }
      .sidebar.open {
        width:226px; padding:22px 0;
        transform: translateX(0); border-left: 1px solid rgba(111,164,175,.28);
      }
      .mobile-toggle { display:flex !important; }
      .date-chip     { display:none !important; }
    }
    @media(max-width:575.98px) {
      .stat-number  { font-size:23px; }
      .booking-card .card-body { padding:14px; }
    }

    .view { display:none; }
    .view.active { display:block; }

    .lang-pill {
      padding: 6px 12px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 700;
      text-decoration: none;
      border: 1px solid rgba(111,164,175,.45);
      color: #4d8a96;
      background: rgba(255,255,255,.5);
      transition: background .2s, color .2s;
    }
    .lang-pill:hover { background: rgba(111,164,175,.18); color: #2d3a35; }
    .lang-pill.active {
      background: linear-gradient(135deg, #6FA4AF, #4d8a96);
      color: #fff !important;
      border-color: transparent;
    }

    html[dir="ltr"] .sidebar {
      right: auto;
      left: 0;
      border-left: none;
      border-right: 1px solid rgba(111,164,175,.28);
      box-shadow: 2px 0 20px rgba(111,164,175,.12);
    }
    html[dir="ltr"] .main-content {
      margin-right: 0;
      margin-left: 70px;
      transition: margin-left .28s ease;
    }
    html[dir="ltr"] .sidebar:hover .sidebar-avatar,
    html[dir="ltr"] .sidebar.open .sidebar-avatar {
      margin-left: 16px;
      margin-right: 0;
    }
    html[dir="ltr"] .booking-card::before {
      right: auto;
      left: 0;
      border-radius: 18px 0 0 18px;
    }
    html[dir="ltr"] .booking-card:hover {
      transform: translateX(4px);
    }
    @media(max-width:991.98px) {
      html[dir="ltr"] .main-content { margin-left: 0 !important; }
      html[dir="ltr"] .sidebar {
        left: 0;
        right: auto;
        transform: translateX(-100%);
        border: none;
      }
      html[dir="ltr"] .sidebar.open {
        transform: translateX(0);
        border-right: 1px solid rgba(111,164,175,.28);
        border-left: none;
      }
    }

  </style>
</head>

<body>

<div class="bg-wrap"></div>
<div class="orb orb-teal"></div>
<div class="orb orb-rose"></div>
<div class="orb orb-gold"></div>

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
<div class="layout">

  <div class="sidebar mt-2" id="sidebar">
    <div class="sidebar-avatar" id="sidebar-avatar"></div>
    <div class="sidebar-logo">
      <div class="sidebar-logo-icon"><i class="fas fa-home"></i></div>
      <span class="sidebar-logo-text"><?php echo $lang['customer_dash']['sidebar_app_name']?></span>
    </div>

    <ul class="sidebar-nav">
      <li><a class="active" onclick="showView('bookings',this)" title="<?php echo $lang['customer_dash']['nav_bookings']?>">
          <div class="nav-icon"><i class="fas fa-calendar-check"></i></div>
          <span class="nav-label"><?php echo $lang['customer_dash']['nav_bookings']?></span></a></li>
      <li><a onclick="showView('profile',this)" title="<?php echo $lang['customer_dash']['nav_profile']?>">
          <div class="nav-icon"><i class="fas fa-user"></i></div>
          <span class="nav-label"> <?php echo $lang['customer_dash']['nav_profile']?></span></a></li>
    </ul>

    <div class="sidebar-footer">
  <a href="logout.php" class="logout-btn">
    <div class="nav-icon"><i class="fas fa-sign-out-alt"></i></div>
    <span class="nav-label"> <?php echo $lang['customer_dash']['nav_logout']?></span>
  </a>
</div>
  </div>

  <main class="main-content" id="mainContent">

    <div class="topbar d-flex align-items-center gap-3 mb-4">
      <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <div class="flex-grow-1">
        <div class="page-title" id="pageTitle"> <?php echo $lang['customer_dash']['page_title_bookings']?></div>
        <div class="page-subtitle" id="welcomeName"> <?php echo $lang['customer_dash']['welcome_prefix']?></div>
      </div>
      <div class="date-chip d-none d-md-flex">
        <i class="fas fa-calendar-day" style="color:#6FA4AF"></i>
        <span id="todayDate"></span>
      </div>
    </div>

    <div class="view active" id="view-bookings">

      <div class="row g-3 mb-4">
        <div class="col-12 col-sm-4">
          <div class="stat-card h-100">
            <div class="stat-icon" style="background:rgba(111,164,175,.15);color:#4d8a96">
              <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-number" id="stat-number"></div>
            <div class="stat-label"> <?php echo $lang['customer_dash']['stat_total_label']?></div>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <div class="filter-tabs">
          <button class="filter-tab-btn active" onclick="filterBk('all',this)"> <?php echo $lang['customer_dash']['filter_all']?></button>
          <button class="filter-tab-btn" onclick="filterBk('confirmed',this)"> <?php echo $lang['customer_dash']['filter_confirmed']?></button>
          <button class="filter-tab-btn" onclick="filterBk('pending',this)"><?php echo $lang['customer_dash']['filter_pending']?></button>
          <button class="filter-tab-btn" onclick="filterBk('completed',this)"><?php echo $lang['customer_dash']['filter_completed']?></button>
        </div>
      </div>

      <div id="bookingsList"></div>

    </div>

    <div class="view" id="view-profile">

    </div>

  </main>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:21px; border:1px solid rgba(111,164,175,.28); background:linear-gradient(145deg, rgba(245,237,224,.96), rgba(253,248,242,.98)); font-family:'Cairo',sans-serif;">
      <div class="modal-body p-4">
        <div class="modal-header-custom mb-4">
          <input type="hidden" id="eId">
          <input type="hidden" id="eServiceId">
          <input type="hidden" id="eProviderId">
          <div class="modal-title-custom"> <?php echo $lang['customer_dash']['edit_modal_title']?></div>
          <button class="modal-close-btn" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
        <div class="mb-3">
          <label class="form-label"><?php echo $lang['customer_dash']['edit_service_label']?></label>
          <input type="text" class="form-control" id="eSvc" readonly style="opacity:.68">
        </div>
        <div class="row g-3 mb-3">
          <div class="col-6">
            <label class="form-label"><?php echo $lang['customer_dash']['edit_date_label']?></label>
            <input type="date" class="form-control" id="eDt" onchange="fetchAvailableTimes()">
          </div>
          <div class="col-6">
            <label class="form-label"><?php echo $lang['customer_dash']['edit_time_label']?></label>
            <select class="form-control" id="eTm">
                <option value=""><?php echo $lang['customer_dash']['edit_time_placeholder']?></option>
            </select>
          </div>
        </div>
        <div id="availabilityStatus" class="mt-2" style="font-size: 12px; color: #4d8a96;"></div>
        <div class="mb-3">
          <label class="form-label"><?php echo $lang['customer_dash']['edit_notes_label']?></label>
          <textarea class="form-control" rows="3" placeholder="<?php echo $lang['customer_dash']['edit_notes_placeholder']?>"></textarea>
        </div>
        <button class="save-btn w-100 justify-content-center" onclick="saveEdit()">
          <i class="fas fa-check"></i> <?php echo $lang['customer_dash']['btn_save_edit']?> 
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <div style="font-size:50px;margin-bottom:14px">⚠️</div>
        <div class="modal-title-custom d-block mb-2"> <?php echo $lang['customer_dash']['cancel_modal_title']?> </div>
        <p style="color:rgba(45,58,53,.52);font-size:13px;line-height:1.75;margin-bottom:24px">
          <?php echo $lang['customer_dash']['cancel_modal_body']?>
        </p>
        <div class="d-flex gap-3">
          <button class="save-btn flex-grow-1 justify-content-center"
            style="background:linear-gradient(135deg,#c9848a,#b06068);box-shadow:none"
            onclick="doCancel()">
            <i class="fas fa-trash-alt"></i> <?php echo $lang['customer_dash']['btn_do_cancel']?>
          </button>
          <button class="save-btn flex-grow-1 justify-content-center"
            style="background:rgba(111,164,175,.12);border:1px solid rgba(111,164,175,.28);color:#2d3a35;box-shadow:none"
            data-bs-dismiss="modal">
            <?php echo $lang['customer_dash']['btn_go_back']?>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ratingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <div class="modal-header-custom mb-3">
          <input type="hidden" id="rBookingId">
          <div class="modal-title-custom">  <?php echo $lang['customer_dash']['rating_modal_title']?></div>
          <button class="modal-close-btn" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
        <div style="width:58px;height:58px;border-radius:16px;margin:0 auto 14px;
          background:rgba(212,168,67,.12);border:1px solid rgba(212,168,67,.28);
          display:flex;align-items:center;justify-content:center;font-size:24px;">
          ⭐
        </div>
        <p style="font-size:13px;color:rgba(45,58,53,.52);line-height:1.75;margin-bottom:2px">
            <?php echo $lang['customer_dash']['rating_modal_desc']?>      </p>
        <div class="star-rating">
          <input type="radio" name="rating" id="s5" value="5"><label for="s5">★</label>
          <input type="radio" name="rating" id="s4" value="4"><label for="s4">★</label>
          <input type="radio" name="rating" id="s3" value="3"><label for="s3">★</label>
          <input type="radio" name="rating" id="s2" value="2"><label for="s2">★</label>
          <input type="radio" name="rating" id="s1" value="1"><label for="s1">★</label>
        </div>
        <div class="mb-3">
          <textarea class="form-control" id="rComment" rows="3" placeholder="<?php echo $lang['customer_dash']['rating_comment_placeholder']?>  "></textarea>
        </div>
        <button class="save-btn w-100 justify-content-center" onclick="submitRating()">
          <i class="fas fa-paper-plane"></i>  <?php echo $lang['customer_dash']['btn_submit_rating']?> 
        </button>
      </div>
    </div>
  </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<script>

    // احرف الاسم
    const name="<?php echo $_SESSION['name']?>";
    const letter=name.split(' ').slice(0,2).map(word => word[0]).join('').toUpperCase();
    document.getElementById('sidebar-avatar').textContent=letter;

    // التاريخ
    const today = new Date();
    document.getElementById('todayDate').textContent = today.toLocaleDateString('ar-EG', { weekday: 'long', day: 'numeric', month: 'long' });

    // فتح/إغلاق الـ Sidebar على الموبايل
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    // التنقل بين الصفحات
    function showView(viewName, clickedLink) {
        document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
        document.getElementById('view-' + viewName).classList.add('active');
        document.querySelectorAll('.sidebar-nav a').forEach(a => a.classList.remove('active'));
        clickedLink.classList.add('active');
        const titles = { bookings: ' <?php echo $lang['customer_dash']['page_title_bookings']?>', profile: ' <?php echo $lang['customer_dash']['nav_profile']?>' };
        document.getElementById('pageTitle').textContent = titles[viewName];
        if (window.innerWidth < 992){
          document.getElementById('sidebar').classList.remove('open');
        }
    }

    // إنشاء كارت حجز
    function createBookingCard(b) {
        const statusMap = {
            'confirmed': { text: '<?php echo $lang['customer_dash']['status_confirmed']?>',        cssClass: 'status-confirmed', icon: '✓' },
            'completed': { text: '<?php echo $lang['customer_dash']['status_completed']?>', cssClass: 'status-done', icon: '✔' },
            'pending':   { text: '<?php echo $lang['customer_dash']['status_pending']?> ', cssClass: 'status-pending',   icon: '⏳' }
        };

        const status = statusMap[b.status] || { text: b.status, cssClass: '', icon: '' };
        const waPhone = String(b.Phone_No || '').replace(/\D/g, '');
        return `
        <div class="card booking-card" data-status="${b.status}">
          <div class="card-body">
            <div class="d-flex align-items-start gap-3">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                  <div class="booking-title">${b.Service_Name}</div>
                  <span class="status-badge ${status.cssClass}">${status.icon} ${status.text}</span>
                </div>
                <div class="booking-meta mb-3">
                  <span><i class="fas fa-calendar"></i> ${b.Booking_Date}</span>
                  <span><i class="fas fa-clock"></i> ${b.Booking_Time_Display}</span>
                  <span><i class="fas fa-user-tie"></i> ${b.First_Name} ${b.Last_Name}</span>
                </div>
                <div class="booking-actions">
                  <a class="icon-btn icon-btn-whatsapp" href="https://wa.me/${waPhone}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                  ${b.status !== 'completed' ? `
                  <button class="icon-btn icon-btn-edit" onclick="openEditModal(${b.Booking_ID}, '${b.Service_Name}', '${b.Booking_Date}', '${b.Booking_Time}', ${b.Provider_ID}, ${b.Service_ID})">
                  <i class="fas fa-pen"></i>
                  </button>` : ''}
                  ${b.status === 'completed' ? `
                  <button class="icon-btn icon-btn-rate" onclick="openRatingModal(${b.Booking_ID})" title="تقييم الخدمة">
                  <i class="fas fa-star"></i>
                  </button>` : ''}
                  ${(b.status !== 'completed' && b.status !== 'confirmed') ? `
                    <button class="icon-btn icon-btn-delete" onclick="deleteBookingModal(${b.Booking_ID}, this)">
                    <i class="fas fa-trash-alt"></i>
                    </button>
                    ` : b.status === 'confirmed' ? `
                    <span style="font-size:11px; color:#4d8a96; opacity:.7">
                    <i class="fas fa-lock"></i> <?php echo $lang['customer_dash']['locked_confirmed']?>  
                    </span>
                    ` : ''}
                </div>
              </div>
            </div>
          </div>
        </div>`;
    }

    function openEditModal(id, serviceName, date, time, providerId, serviceId) {
        document.getElementById('eSvc').value        = serviceName;
        document.getElementById('eDt').value         = date;
        document.getElementById('eId').value         = id;
        document.getElementById('eProviderId').value = providerId;
        document.getElementById('eServiceId').value  = serviceId;
        
        // جلب الأوقات المتاحة لهذا التاريخ فور فتح المودال مع الاحتفاظ بالوقت الحالي
        fetchAvailableTimes(time);
        
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    // دالة جديدة تقوم بجلب الأوقات المتاحة بالخلفية وتعبئة الـ Select مباشرة
function fetchAvailableTimes(defaultTime = null) {
    const providerId   = document.getElementById('eProviderId').value;
    const serviceId    = document.getElementById('eServiceId').value;
    const selectedDate = document.getElementById('eDt').value;
    const timeSelect   = document.getElementById('eTm');
    const bookingId    = document.getElementById('eId').value;
    const statusDiv    = document.getElementById('availabilityStatus');

    if (!selectedDate || !providerId || !serviceId) return;

    statusDiv.textContent = "جاري تحميل الأوقات المتاحة...";
    timeSelect.innerHTML = '<option value="">جاري التحميل...</option>';

    // استدعاء مباشر ونظيف متوافق مع الباك-إند المعدل
    fetch(`check_availability.php?provider_id=${providerId}&service_id=${serviceId}&date=${selectedDate}`)
        .then(res => res.json())
        .then(times => {
            timeSelect.innerHTML = '';
            statusDiv.textContent = "";

            if (!times || times.length === 0) {
                timeSelect.innerHTML = '<option value="">لا توجد أوقات متاحة في هذا اليوم (إجازة أو ممتلئ)</option>';
                return;
            }

            times.forEach(t => {
                const option = document.createElement('option');
                option.value = t.value;      
                option.textContent = t.display;  
                
                // مطابقة الوقت الافتراضي للحجز القديم عند تعديله
                if(defaultTime && (t.value === defaultTime || t.value.substring(0,5) === defaultTime.substring(0,5))) {
                    option.selected = true;
                }
                timeSelect.appendChild(option);
            });
        })
        .catch(err => {
            console.error("Error fetching times:", err);
            statusDiv.textContent = "خطأ في الاتصال بالسيرفر";
            timeSelect.innerHTML = '<option value="">خطأ في تحميل البيانات</option>';
        });
}

    function saveEdit() {
        const bookingId  = document.getElementById('eId').value;
        const newDate    = document.getElementById('eDt').value;
        const newTime    = document.getElementById('eTm').value;
        const notes      = document.querySelector('#editModal textarea').value;

        if (!newDate || !newTime) {
            showToast(" <?php echo $lang['customer_dash']['toast_fill_datetime']?>  ", "w");
            return;
        }

        fetch('update_booking.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ booking_id: bookingId, date: newDate, time: newTime, note: notes })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modalEl = document.getElementById('editModal');
                bootstrap.Modal.getInstance(modalEl).hide();
                showToast("<?php echo $lang['customer_dash']['toast_booking_updated']?>✓", "s");
                loadBookingsFromDB('all');
            } else {
                showToast(data.error || data.message || "<?php echo $lang['customer_dash']['toast_udate_falid']?> ", "e");
            }
        })
        .catch(err => {
            console.error("Error:", err);
            showToast(" <?php echo $lang['customer_dash']['toast_server_error']?>", "e");
        });
    }

    // تحميل الحجوزات من قاعدة البيانات
    function loadBookingsFromDB(status = 'all') {
        const bookingsList = document.getElementById('bookingsList');

        fetch(`selectBooking.php?status=${status}`)
            .then(response => response.json())
            .then(data => {
                bookingsList.innerHTML = '';
                document.getElementById('stat-number').innerHTML = data.length;

                if (data.length === 0) {
                    bookingsList.innerHTML = '<div class="text-center p-5"> <?php echo $lang['customer_dash']['no_bookings']?></div>';
                    return;
                }
                data.forEach(booking => {
                    bookingsList.innerHTML += createBookingCard(booking);
                });
            })
            .catch(err => {
                console.error(err);
                bookingsList.innerHTML = '<div class="alert alert-danger"> <?php echo $lang['customer_dash']['alter_message']?></div>';
            });
    }

    function filterBk(status, clickedBtn) {
        document.querySelectorAll('.filter-tab-btn').forEach(b => b.classList.remove('active'));
        clickedBtn.classList.add('active');
        loadBookingsFromDB(status);
    }

    let pendingDeleteId  = null;
    let pendingDeleteBtn = null;

    function deleteBookingModal(id, btnClose) {
        pendingDeleteId  = id;
        pendingDeleteBtn = btnClose;
        new bootstrap.Modal(document.getElementById('cancelModal')).show();
    }

    function doCancel() {
        if (!pendingDeleteId) return;
        bootstrap.Modal.getInstance(document.getElementById('cancelModal')).hide();

        fetch('deleteBooking.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ booking_id: pendingDeleteId })
        })
        .then(response => response.json())
        .then(dataBooking => {
            if (dataBooking.success) {
                const card = pendingDeleteBtn.closest('.booking-card');
                card.style.transition = 'all 0.3s ease';
                card.style.transform  = 'scale(0.9)';
                card.style.opacity    = '0';
                setTimeout(() => {
                    card.remove();
                    showToast("<?php echo $lang['customer_dash']['toast_booking_cancelled']?>✓", "s");
                }, 300);
            } else {
                showToast("<?php echo $lang['customer_dash']['toast_cancel_error']?>", "e");
            }
            pendingDeleteId  = null;
            pendingDeleteBtn = null;
        })
        .catch(err => {
            console.error("Error:", err);
            showToast("<?php echo $lang['customer_dash']['toast_server_error']?>", "e");
        });
    }

    function openRatingModal(bookingId) {
        document.getElementById('rBookingId').value = bookingId;
        document.querySelectorAll('.star-rating input').forEach(r => r.checked = false);
        document.getElementById('rComment').value = '';
        new bootstrap.Modal(document.getElementById('ratingModal')).show();
    }

    function submitRating() {
        const bookingId = document.getElementById('rBookingId').value;
        const rating    = document.querySelector('.star-rating input:checked')?.value;
        const comment   = document.getElementById('rComment').value.trim();

        if (!rating) {
            showToast("يرجى اختيار عدد النجوم", "w");
            return;
        }

        fetch('submit_rating.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                booking_id: parseInt(bookingId),
                rating: parseInt(rating), 
                comment: comment 
            })
        })
        .then(res => {
            if (!res.ok) {
                return res.text().then(text => { throw new Error(text) });
            }
            return res.json();
        })
        .then(data => {
            const modalEl = document.getElementById('ratingModal');
            bootstrap.Modal.getInstance(modalEl).hide();

            if (data.success) {
                showToast("<?php echo $lang['customer_dash']['toast_rating_sent']?>", "s");
                loadBookingsFromDB('all');
            } else {
                showToast(data.message || "  <?php echo $lang['customer_dash']['rating_faild']?> ", "e");
            }
        })
        .catch(err => {
            console.error("Rating error:", err);
            const modalEl = document.getElementById('ratingModal');
            if (modalEl) bootstrap.Modal.getInstance(modalEl).hide();
            showToast(" <?php echo $lang['customer_dash']['toast_rating_error']?>", "e");
        });
    }

    function showToast(msg, type = 's') {
        const container = document.getElementById('toastContainer');
        const typeConfig = {
            s: { icon: 'fa-circle-check',        color: '#4d8a96' },
            e: { icon: 'fa-circle-xmark',        color: '#c9848a' },
            w: { icon: 'fa-triangle-exclamation', color: '#a07820' }
        };
        const { icon, color } = typeConfig[type] || typeConfig.s;

        const toastEl = document.createElement('div');
        toastEl.className = 'toast-item';
        toastEl.innerHTML = `
            <i class="fas ${icon}" style="color:${color};font-size:16px;flex-shrink:0"></i>
            <span>${msg}</span>
        `;
        container.appendChild(toastEl);
        setTimeout(() => toastEl.remove(), 3000);
    }

    function creatModalProfile(data){
      return `
          <div class="profile-form-card">
        <div class="section-title"><i class="fas fa-user-edit"></i> <?php echo $lang['customer_dash']['profile_section_title']?></div>
        <div class="row g-3 mb-3">
          <div class="col-12 col-sm-6">
            <label class="form-label"> <?php echo $lang['customer_dash']['profile_fname']?></label>
            <input type="text" id="p_fname" class="form-control" value="${data.data.First_Name}">
          </div>
          <div class="col-12 col-sm-6">
            <label class="form-label"> <?php echo $lang['customer_dash']['profile_lname']?></label>
            <input type="text" id="p_lname" class="form-control" value="${data.data.Last_Name}">
          </div>
          <div class="col-12 col-sm-6">
            <label class="form-label">  <?php echo $lang['customer_dash']['profile_phone']?></label>
            <input type="tel" id="p_phone" class="form-control" value="${data.data.Phone_No}">
          </div>
          <div class="col-12 col-sm-6">
            <label class="form-label"> <?php echo $lang['customer_dash']['profile_email']?></label>
            <input type="email" id="p_email" class="form-control" value="${data.data.Email}">
          </div>
          <div class="col-12">
            <label class="form-label"><?php echo $lang['customer_dash']['profile_address']?></label>
            <input type="text" id="p_street" class="form-control" value="${data.data.Governorate}">
          </div>
        <div class="section-title mt-3"><i class="fas fa-lock"></i> <?php echo $lang['customer_dash']['security_section']?></div>
        <div class="row g-3 mb-4">
          <div class="col-12 col-sm-6">
            <label class="form-label"> <?php echo $lang['customer_dash']['old_pass_label']?> </label>
            <input type="password" id="p_old_pass" class="form-control" placeholder="••••••••">
          </div>
          <div class="col-12 col-sm-6">
            <label class="form-label"> <?php echo $lang['customer_dash']['new_pass_label']?>  </label>
            <input type="password" id="p_new_pass" class="form-control" placeholder="••••••••">
          </div>
        </div>
        <button class="save-btn btn" onclick="saveProfile()">
          <i class="fas fa-save"></i>  <?php echo $lang['customer_dash']['btn_save_profile']?> 
        </button>
      </div>
      `;
    }

    function loadedProfileData(){
      const profileData = document.getElementById('view-profile');
      fetch('get_profile.php')
      .then(response => response.json())
      .then(data => {
         if(data.success){
            profileData.innerHTML += creatModalProfile(data);
            document.getElementById('welcomeName').textContent = ` <?php echo $lang['customer_dash']['welcome_prefix']?> ${data.data.First_Name} ${data.data.Last_Name}`;
        } else {
            profileData.innerHTML = '<div class="alert alert-danger"> <?php echo $lang['customer_dash']['data_profile']?>  </div>';
        }
      }).catch(err => {
        console.error("Error:", err);
        showToast("<?php echo $lang['customer_dash']['toast_server_error']?>", "e");
      });
    }

    function saveProfile(){
        const fname   = document.getElementById('p_fname').value.trim();
        const lname   = document.getElementById('p_lname').value.trim();
        const phone   = document.getElementById('p_phone').value.trim();
        const email   = document.getElementById('p_email').value.trim();
        const address = document.getElementById('p_street').value.trim();
        const oldPass = document.getElementById('p_old_pass').value;
        const newPass = document.getElementById('p_new_pass').value;

        if (!fname || !lname || !email) {
            showToast("<?php echo $lang['customer_dash']['toast_fill_fields']?> ", "w");
            return;
        }

        fetch('update_profile_customer.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                first_name: fname,
                last_name:  lname,
                phone_no:      phone,
                email:      email,
                Governorate:    address,
                password:   oldPass,
                new_pass:   newPass
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast("<?php echo $lang['customer_dash']['toast_profile_saved']?> ✓", "s");
            } else {
                showToast(data.message || " <?php echo $lang['customer_dash']['faild_save']?>", "e");
            }
        })
        .catch(() => showToast("<?php echo $lang['customer_dash']['toast_server_error']?>", "e"));
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadBookingsFromDB('all');
        loadedProfileData();
    });

</script>
</body>
</html>