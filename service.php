<?php
require "config.php";
include "chatbot.php";

$category_id  = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'ar';      // ← هون
$cat_name_col = ($current_lang === 'en') ? 'Category_Name_en' : 'Category_Name_ar';  // ← هون

$stmt_cat = $db->prepare("SELECT COALESCE($cat_name_col, Category_Name) AS Category_Name FROM category WHERE Category_ID = ?");  // ← عدّلي السطر هاد
$stmt_cat->bind_param("i", $category_id);
$stmt_cat->execute();
$category_data = $stmt_cat->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">

<head>
    <title>Categories page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="navbarStyle.css" rel="stylesheet">
    <script src="chatbot-widget.js"></script>
    <style>
        html, body {
            height: 100%;
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        #titleC {
            background: linear-gradient(135deg, #0C7779 0%, #0a6365 50%, #D4AF37 100%);
            color: white;
            min-height: 350px;
            border-radius: 0 0 80px 80px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        #titleC::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: rgba(255,215,0,0.15);
            border-radius: 50%;
            top: -150px; right: -100px;
            animation: floatBg 8s ease-in-out infinite;
        }
        #titleC::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            bottom: -100px; left: -80px;
            animation: floatBg 10s ease-in-out infinite reverse;
        }
        .category-title {
            font-size: 4rem;
            font-weight: 900;
            position: relative;
            z-index: 2;
            background: linear-gradient(135deg, #FFFFFF 0%, #FFEAA7 50%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
            animation: titleGlow 3s ease-in-out infinite;
        }
        .category-title::after {
            content: '';
            position: absolute;
            bottom: -20px; left: 50%;
            transform: translateX(-50%);
            width: 120px; height: 4px;
            background: linear-gradient(90deg, transparent, #FFD700, #FFA500, #FFD700, transparent);
            border-radius: 2px;
            animation: lineWidth 3s ease-in-out infinite;
        }
        @keyframes floatBg {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-30px) translateX(20px); }
        }
        @keyframes titleGlow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2) drop-shadow(0 0 8px rgba(255,215,0,0.5)); }
        }
        @keyframes lineWidth {
            0%, 100% { width: 120px; opacity: 1; }
            50% { width: 200px; opacity: 0.7; }
        }
        @media (max-width: 768px) {
            #titleC { min-height: 250px; border-radius: 0 0 50px 50px; }
            .category-title { font-size: 2.5rem; }
            .category-title::after { width: 80px; bottom: -15px; }
        }
        .btn { background-color: #0C7779; color: white;  }
        .btn:hover { background-color: #B4D3D9; }
        .filter-block {
            border-radius: 16px;
        }
        .service-filter-panel {
            background: linear-gradient(145deg, rgba(255,255,255,0.97) 0%, rgba(244,249,249,0.98) 100%);
        }
        .service-name { font-size: 1.35rem; font-weight: 700; }
        #section2 .service-item .card {
            transition: transform .25s ease, box-shadow .25s ease;
            position: relative;
            overflow: hidden;
        }
        #section2 .service-item .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2) !important;
        }
        .service-card-decor {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            opacity: 0.35;
        }
        .service-card-decor .decor-icon {
            position: absolute;
            font-size: 2rem;
            color: rgba(255,255,255,0.95);
            animation: decorDrift 7s ease-in-out infinite;
        }
        .service-card-decor .decor-icon:nth-child(1) { top: 12%; left: 8%; }
        .service-card-decor .decor-icon:nth-child(2) { top: 58%; right: 10%; font-size: 1.65rem; }
        .service-card-decor .decor-icon:nth-child(3) { bottom: 14%; left: 18%;  font-size: 1.5rem; }
        .service-card-decor .decor-icon:nth-child(4) { top: 28%; right: 22%; font-size: 1.35rem; }
        @keyframes decorDrift {
            0%, 100% { transform: translate(0,0); }
            33%       { transform: translate(6px,-8px); }
            66%       { transform: translate(-5px,5px); }
        }#section2 .service-item .card {
    background: linear-gradient(135deg, #0C7779 0%, #D4AF37 100%);
}
        #section2 .service-item .service-name {
            color: #fff;
            text-shadow: 1px 2px 6px rgba(0,0,0,.25);
            position: relative;
            z-index: 2;
        }
        #section2 .service-item .card-body { position: relative; z-index: 2; }
        #section2 .service-item .btn.btn-light {
            background-color: #fff;
            border-color: #fff;
            color: #0C7779;
            font-weight: 700;
        }
        #section2 .service-item .btn.btn-light:hover {
            background-color: #f8f5e6;
            color: #0C7779;
        }
        #section3 {
            display: none;
            background: linear-gradient(180deg, rgba(12,119,121,0.06) 0%, rgba(212,175,55,0.08) 100%);
            border-radius: 24px;
            padding: 28px 20px;
        }
        #section3.is-visible { display: block; animation: fadeSlideIn 0.35s ease; }
        .providers-title { color: #0C7779; font-weight: 800; margin-bottom: 6px; }
        .providers-subtitle { color: #5c6b6d; margin-bottom: 20px; }
        .provider-card {
            border: 0;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.09);
            cursor: pointer;
            transition: transform .25s ease, box-shadow .25s ease;
            height: 100%;
        }
        .provider-card:hover { transform: translateY(-6px); box-shadow: 0 18px 34px rgba(0,0,0,0.14); }
        .provider-avatar {
            width: 54px; height: 54px;
            border-radius: 50%;
            margin: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0C7779, #D4AF37);
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .provider-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f4f8f8;
            color: #0C7779;
            border-radius: 50px;
            padding: 6px 12px;
            font-size: .86rem;
            margin: 4px 6px 0 0;
        }
        .modal-provider-header {
            background: linear-gradient(135deg, #0C7779 0%, #D4AF37 100%);
            color: #fff;
            border-radius: 12px;
            padding: 20px;
        }
        .modal-field-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #6b7c7e;
            margin-bottom: 0.35rem;
        }
        .modal-field-label i { margin-left: 0.35rem; opacity: 0.85; }
        .modal-field-value {
            display: block;
            width: 100%;
            background: linear-gradient(135deg, rgba(12,119,121,0.08) 0%, rgba(212,175,55,0.1) 100%);
            border: 1px solid rgba(12,119,121,0.14);
            border-radius: 14px;
            padding: 0.65rem 1rem;
            font-weight: 600;
            color: #0a5a5c;
            line-height: 1.55;
            word-wrap: break-word;
        }
        a.modal-field-value.modal-phone-link:hover {
            color: #fff;
            background: linear-gradient(135deg, #0C7779 0%, #0a6365 100%);
            border-color: transparent;
        }
        .modal-field-desc {
            background: #f6fafb;
            border: 1px solid rgba(12,119,121,0.12);
            border-radius: 16px;
            padding: 1rem 1.1rem;
            font-size: 0.92rem;
            line-height: 1.65;
            color: #2d3b3c;
            min-height: 4.5rem;
            white-space: pre-wrap;
        }
        @keyframes fadeSlideIn {
            0% { opacity: 0; transform: translateY(14px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) { .service-name { font-size: 1.2rem; } }
    </style>
</head>

<body>

<header id="header1">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <h1 class="navbar-brand" href="index.php">
            <img src="iconHome.jpg" alt="Logo" class="rounded-circle" width="50" height="50">
            <span>PalHomeServices</span>
        </h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a href="loginPage.php" class="nav-link btn-login">
                            <i class="bi bi-person-fill"></i><?php echo $lang['btn']['log_in'] ?>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main>
    <div id="titleC" class="text-center d-flex justify-content-center align-items-center mb-5">
        <div class="container">
            <h1 class="category-title"><?php echo $category_data['Category_Name'] ?? ''; ?></h1>
        </div>
    </div>

    <section id="section2" class="container py-5">
        <div class="row g-4" id="servicesGrid">
            <div class="text-center w-100 py-5">
                <div class="spinner-border" style="color:#0C7779;" role="status"></div>
            </div>
        </div>
    </section>

    <section id="section3" class="container mb-5">
        <h3 class="providers-title">
            <i class="bi bi-people-fill me-2"></i><?php echo $lang['category']['providers_title'] ?>
        </h3>
        <p class="providers-subtitle" id="providersSubtitle"><?php echo $lang['category']['providers_subtitle'] ?></p>
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-4">
                <div class="filter-block p-3 service-filter-panel shadow-sm h-100">
                    <small class="text-muted d-block mb-2">
                        <i class="bi bi-database me-1 text-secondary"></i>
                        <label><?php echo $lang['text']['search'] ?></label>
                    </small>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="search" id="serviceSearchInput" class="form-control border-start-0"
                               placeholder="<?php echo $lang['placeholder']['plachoder-price-filter'] ?>"
                               autocomplete="on">
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="resetServiceFilters">
                        <i class="bi bi-arrow-counterclockwise me-1"></i><?php echo $lang['category']['btn_reset_search'] ?>
                    </button>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="filter-block p-3 service-filter-panel shadow-sm h-100">
                    <small class="text-muted d-block mb-2">
                        <i class="bi bi-sliders me-1 text-secondary"></i>
                        <?php echo $lang['text']['Specify the Price Range'] ?>
                    </small>
                    <div class="d-flex justify-content-between align-items-center small mb-0">
                        <span class="text-secondary">0 ₪</span>
                        <span id="priceRangeLabel" class="fw-semibold">—</span>
                        <span id="priceRangeCeilingLabel" class="text-secondary">—</span>
                    </div>
                    <input type="range" class="form-range px-1 mt-1" id="priceRangeMax" min="0" max="100" value="100" step="1">
                    <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="resetPriceFilter">
                        <i class="bi bi-arrow-counterclockwise me-1"></i><?php echo $lang['category']['btn_reset_price'] ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="row g-4" id="providersGrid"></div>
    </section>

    <!-- مودال تفاصيل المزود -->
    <div class="modal fade" id="providerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-body p-4">
                    <div class="modal-provider-header mb-3">
                        <h4 class="mb-1" id="modalProviderName"></h4>
                        <small class="opacity-90" id="modalServiceName"></small>
                    </div>
                    <div class="row g-3 mb-1">
                        <div class="col-12 col-md-4">
                            <label class="modal-field-label"><i class="bi bi-calendar-week"></i><?php echo $lang['category']['modal_working_days'] ?></label>
                            <span class="modal-field-value" id="modalWorkingDays"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="modal-field-label"><i class="bi bi-clock-history"></i><?php echo $lang['category']['modal_working_hours'] ?></label>
                            <span class="modal-field-value" id="modalWorkingHours"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="modal-field-label"><i class="bi bi-star-fill"></i><?php echo $lang['category']['modal_rating'] ?></label>
                            <span class="modal-field-value" id="modalRating"></span>
                        </div>
                    </div>
                    <hr class="my-3 opacity-25">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="modal-field-label"><i class="bi bi-cash-coin"></i><?php echo $lang['category']['modal_price'] ?></label>
                            <span class="modal-field-value" id="modalProviderPrice">—</span>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="modal-field-label"><i class="bi bi-telephone-outbound"></i><?php echo $lang['category']['modal_phone'] ?></label>
                            <a href="#" class="modal-field-value modal-phone-link text-center" id="modalProviderPhone">—</a>
                        </div>
                        <div class="col-12">
                            <label class="modal-field-label"><i class="bi bi-geo-alt-fill"></i><?php echo $lang['category']['modal_areas'] ?></label>
                            <span class="modal-field-value" id="modalProviderResidence">—</span>
                        </div>
                        <div class="col-12">
                            <label class="modal-field-label"><i class="bi bi-card-text"></i><?php echo $lang['category']['modal_description'] ?></label>
                            <div class="modal-field-desc" id="modalProviderDescription">—</div>
                        </div>
                    </div>
                    <div class="mt-4 d-grid">
                        <a id="modalBookingLink" class="btn btn-lg"><?php echo $lang['category']['btn_book_now'] ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const CATEGORY_ID = <?php echo (int)$category_id; ?>;

   
    const providersMap = new Map();

    // -------- helpers --------
    function debounce(fn, ms) {
        let t;
        return function (...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), ms); };
    }

    // -------- بناء كارت الخدمة --------
    function createServiceCard(s) {
        return `
        <div class="col-sm-12 col-md-6 col-lg-4 service-item"
             data-service-name="${s.Service_Name}"
             data-min-price="${s.min_price}">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="service-card-decor" aria-hidden="true">
                    <i class="bi bi-droplet-fill decor-icon"></i>
                    <i class="bi bi-brush decor-icon"></i>
                    <i class="bi bi-house-door decor-icon"></i>
                    <i class="bi bi-stars decor-icon"></i>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-4 gap-3">
                    <h3 class="service-name mb-0">${s.Service_Name}</h3>
                    <button type="button" class="btn btn-light btn-lg rounded-pill px-4"
                            onclick="showProviders(this)"
                            data-service-id="${s.Service_ID}">
                        <?php echo $lang['category']['btn_view_providers'] ?>
                    </button>
                </div>
            </div>
        </div>`;
    }

    // -------- بناء كارت المزود --------
    function createProviderCard(prov, key) {
        const initials = (prov.First_Name + ' ' + prov.Last_Name)
            .split(' ').filter(Boolean).map(w => w[0]).join('').slice(0, 2).toUpperCase();
        return `
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card provider-card p-3" role="button" tabindex="0" onclick="openProviderModal('${key}')">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="provider-avatar">${initials}</span>
                    <div>
                        <h5 class="mb-1">${prov.First_Name + ' ' + prov.Last_Name}</h5>
                        <small class="text-muted">${prov.Service_Name || ''}</small>
                    </div>
                </div>
                <div>
                    <span class="provider-chip"><i class="bi bi-calendar-week"></i>${prov.working_days  || "<?php echo $lang['category']['not_specified'] ?>"}</span>
                    <span class="provider-chip"><i class="bi bi-clock-history"></i>${prov.working_hours || "<?php echo $lang['category']['not_specified'] ?>"}</span>
                </div>
            </div>
        </div>`;
    }

    // -------- تحميل الخدمات --------
    function loadServices(query) {
        const grid = document.getElementById('servicesGrid');
        grid.innerHTML = '<div class="text-center w-100 py-4"><div class="spinner-border" style="color:#0C7779;" role="status"></div></div>';

        const q = encodeURIComponent((query || '').trim());

        fetch(`serviceback.php?ajax=services&id=${CATEGORY_ID}&q=${q}`)
            .then(res => res.json())
            .then(data => {
                if (data.status !== 'success' || !data.services.length) {
                    grid.innerHTML = `<div class="col-12 text-center py-5"><p class="text-muted">"<?php echo $lang['category']['no_providers'] ?>"</p></div>`;
                    return;
                }
                grid.innerHTML = '';
                data.services.forEach(s => { grid.innerHTML += createServiceCard(s); });
                applyPriceFilter();
            })
            .catch(err => {
                console.error(err);
                grid.innerHTML = `<div class="col-12"><div class="alert alert-danger">"<?php echo $lang['category']['error_services'] ?>"</div></div>`;
            });
    }

    // -------- تحميل المزودين --------
    function showProviders(button) {
        const section3  = document.getElementById('section3');
        const grid      = document.getElementById('providersGrid');
        const serviceId = button.dataset.serviceId;

        grid.innerHTML = '<div class="text-center w-100 py-5"><div class="spinner-border" style="color:#0C7779;" role="status"></div></div>';
        section3.classList.add('is-visible');
        section3.scrollIntoView({ behavior: 'smooth', block: 'start' });

        fetch(`serviceback.php?ajax=providers&id=${CATEGORY_ID}&service_id=${serviceId}`)
            .then(res => res.json())
            .then(data => {
                grid.innerHTML = '';
                providersMap.clear();

                if (data.status !== 'success') {
                    grid.innerHTML = `<div class="alert alert-info w-100 text-center">"<?php echo $lang['category']['no_providers'] ?>"</div>`;
                    return;
                }

                data.providers.forEach(prov => {
                    const key = `${prov.Service_ID}-${prov.Provider_ID}`;
                    providersMap.set(key, prov);
                    grid.innerHTML += createProviderCard(prov, key);
                });

                document.getElementById('providersSubtitle').textContent = data.providers[0]?.Service_Name || '';
            })
            .catch(err => {
                console.error(err);
                grid.innerHTML = `<div class="alert alert-danger w-100 text-center">"<?php echo $lang['category']['error_connection'] ?>"</div>`;
            });
    }

    // -------- فتح المودال --------
    function openProviderModal(key) {
        const d = providersMap.get(key);
        if (!d) return;

        document.getElementById('modalProviderName').textContent  = (d.First_Name + ' ' + d.Last_Name).trim();
        document.getElementById('modalServiceName').textContent   = d.Service_Name || '—';
        document.getElementById('modalWorkingDays').textContent   = d.working_days  || "<?php echo $lang['category']['not_available'] ?>";
        document.getElementById('modalWorkingHours').textContent  = d.working_hours || "<?php echo $lang['category']['not_available'] ?>";

        const avg   = parseFloat(d.avg_rating);
        const count = parseInt(d.rating_count);
        document.getElementById('modalRating').textContent = count > 0
            ? `${'★'.repeat(Math.round(avg))}${'☆'.repeat(5 - Math.round(avg))} ${avg} (${count})`
            : "<?php echo $lang['category']['no_rating'] ?>";

        document.getElementById('modalProviderPrice').textContent = d.Price ? `${d.Price} ₪` : '—';

        const phoneEl = document.getElementById('modalProviderPhone');
        phoneEl.textContent = d.Phone_No || '—';
        phoneEl.setAttribute('href', d.Phone_No ? 'tel:' + d.Phone_No : '#');

        document.getElementById('modalProviderResidence').textContent   = d.Governorate || "<?php echo $lang['category']['not_specified'] ?>";
        document.getElementById('modalProviderDescription').textContent = d.Service_Description || "<?php echo $lang['category']['no_description'] ?>";

        document.getElementById('modalBookingLink').setAttribute('href',
            `booking.php?provider_id=${d.Provider_ID}&service_id=${d.Service_ID}` +
            `&working_days=${encodeURIComponent(d.working_days || '')}` +
            `&working_hours=${encodeURIComponent(d.working_hours || '')}`
        );

        new bootstrap.Modal(document.getElementById('providerModal')).show();
    }

    // -------- فلتر السعر --------
    function applyPriceFilter() {
        const slider = document.getElementById('priceRangeMax');
        const maxVal = Number(slider.value);
        document.getElementById('priceRangeLabel').textContent = `حتى ${maxVal} ₪`;

        document.querySelectorAll('#servicesGrid .service-item').forEach(el => {
            el.style.display = Number(el.dataset.minPrice || 0) <= maxVal ? '' : 'none';
        });
    }

    function filterProviders() {
        const search   = document.getElementById('serviceSearchInput').value.toLowerCase().trim();
        const maxPrice = parseFloat(document.getElementById('priceRangeMax').value);
        document.getElementById('priceRangeLabel').textContent = `حتى ${maxPrice} ₪`;

        document.querySelectorAll('#providersGrid > div').forEach(col => {
            const nameEl = col.querySelector('h5');
            if (!nameEl) return;
            const keyMatch = col.querySelector('.provider-card')?.getAttribute('onclick')?.match(/'([^']+)'/);
            if (!keyMatch) return;
            const prov  = providersMap.get(keyMatch[1]);
            const price = parseFloat(prov?.Price || 0);
            col.style.display = (nameEl.textContent.toLowerCase().includes(search) && price <= maxPrice) ? '' : 'none';
        });
    }

    // -------- تهيئة السلايدر --------
    function initPriceSlider() {
        fetch(`serviceback.php?ajax=price_max&id=${CATEGORY_ID}`)
            .then(res => res.json())
            .then(data => {
                const max    = Math.ceil(Number(data.max || 0)) || 100;
                const slider = document.getElementById('priceRangeMax');
                slider.max   = String(max);
                slider.value = String(max);
                document.getElementById('priceRangeCeilingLabel').textContent = `${max} ₪`;
                document.getElementById('priceRangeLabel').textContent        = `حتى ${max} ₪`;
            })
            .catch(() => {
                document.getElementById('priceRangeCeilingLabel').textContent = '100 ₪';
            });

        document.getElementById('priceRangeMax').addEventListener('input', () => {
            document.getElementById('section3').classList.contains('is-visible')
                ? filterProviders()
                : applyPriceFilter();
        });
    }

    // -------- search debounce --------
    const onSearchInput = debounce(() => {
        const v = document.getElementById('serviceSearchInput').value || '';
        document.getElementById('section3').classList.contains('is-visible')
            ? filterProviders()
            : loadServices(v);
    }, 320);

    // -------- DOMContentLoaded --------
    document.addEventListener('DOMContentLoaded', () => {
        loadServices('');
        initPriceSlider();

        document.getElementById('serviceSearchInput')?.addEventListener('input', onSearchInput);

        document.getElementById('resetServiceFilters')?.addEventListener('click', () => {
            document.getElementById('serviceSearchInput').value = '';
            const slider = document.getElementById('priceRangeMax');
            slider.value = slider.max;
            loadServices('');
        });

        document.getElementById('resetPriceFilter')?.addEventListener('click', () => {
            const slider = document.getElementById('priceRangeMax');
            slider.value = slider.max;
            document.getElementById('section3').classList.contains('is-visible')
                ? filterProviders()
                : applyPriceFilter();
        });
    });
</script>

</body>
</html>
