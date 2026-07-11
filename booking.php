<?php
require "config.php";
include "chatbot.php";

// ===== جلب البيانات اللازمة للتقويم من قاعدة البيانات =====
$js_working_days  = json_encode($_GET['working_days']  ?? ''); // أيام عمل المزود
$js_working_hours = json_encode($_GET['working_hours'] ?? ''); // ساعات عمل المزود
$provider_id_js   = (int)($_GET['provider_id'] ?? 0);          // معرّف المزود
$service_id_js    = (int)($_GET['service_id']  ?? 0);          // معرّف الخدمة

// حساب max_bookings من ساعات العمل لتحديد الأيام المحجوزة كلياً
$working_hours_raw = $_GET['working_hours'] ?? '';
$max_bookings = 8; // قيمة افتراضية لو ما أمكن الحساب
if ($working_hours_raw) {
    $hours_raw = str_replace(['–','—','−'], '-', $working_hours_raw);
    $parts = explode('-', $hours_raw);
    if (count($parts) === 2) {
        $start = strtotime(trim($parts[0]));
        $end   = strtotime(trim($parts[1]));
        if ($start && $end && $end > $start) {
            $max_bookings = (int)(($end - $start) / 3600);
            if ($max_bookings < 1) $max_bookings = 1;
        }
    }
}

// جلب الأيام المحجوزة بالكامل لهذا المزود والخدمة
$fully_booked_dates = [];
$stmt_fb = $db->prepare(
    "SELECT Booking_Date, COUNT(*) as cnt
     FROM booking
     WHERE Provider_ID = ? AND Service_ID = ? AND status != 'cancelled'
     GROUP BY Booking_Date"
);
$stmt_fb->bind_param("ii", $provider_id_js, $service_id_js);
$stmt_fb->execute();
$res_fb = $stmt_fb->get_result();
while ($row_fb = $res_fb->fetch_assoc()) {
    if ((int)$row_fb['cnt'] >= $max_bookings) {
        $fully_booked_dates[] = $row_fb['Booking_Date']; // Y-m-d
    }
}
?>
<script>
    const WORKING_DAYS  = <?php echo $js_working_days; ?>;   // أيام العمل للتقويم
    const WORKING_HOURS = <?php echo $js_working_hours; ?>;  // ساعات العمل
    const FULLY_BOOKED  = <?php echo json_encode($fully_booked_dates); ?>; // أيام ممتلئة
</script>

<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--رابط انواع الخط-->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <!--رابط الicon-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="navbarStyle.css" rel="stylesheet">
    <!--رابط  استدعاء المكتبة ل الاشعارات  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $lang['booking']['page_title'] ?></title>
    <link href="navbarStyle.css" rel="stylesheet">

    <style>
        /* أخضر غامق + درجات فاتحة متناسقة (نعناع، عاجي، كريم) */
        :root {
            --bs-primary: #1B4332;
            --bs-primary-rgb: 27, 67, 50;
            --bs-secondary: #52796f;
            --bs-secondary-rgb: 82, 121, 111;
            --booking-green-mid: #2D6A4F;
            --booking-green-light: #40916C;
            --booking-mint: #D8F3DC;
            --booking-mint-soft: #E8F5E9;
            --booking-cream: #FEFAE0;
            --booking-ivory: #FFFBF7;
            --booking-page-mid: #F0F9F4;
            --glow-mint: rgba(95, 201, 140, 0.55);
            --glow-deep: rgba(27, 67, 50, 0.45);
        }

        .lang-switcher--booking .btn-lang {
            color: #1B4332 !important;
            border: 1px solid rgba(27, 67, 50, 0.35) !important;
            background: rgba(255, 255, 255, 0.9);
        }

        .lang-switcher--booking .btn-lang:hover {
            background: rgba(216, 243, 220, 0.95) !important;
            color: #1B4332 !important;
        }

        .lang-switcher--booking .btn-lang.active {
            background: linear-gradient(145deg, #1B4332 0%, #2D6A4F 100%) !important;
            color: #fff !important;
            border-color: #1B4332 !important;
        }

        body {
            font-family: 'Cairo', 'Quicksand', system-ui, sans-serif;
            background:
                radial-gradient(ellipse 90% 60% at 100% 0%, rgba(216, 243, 220, 0.55) 0%, transparent 55%),
                radial-gradient(ellipse 70% 50% at 0% 100%, rgba(254, 250, 224, 0.45) 0%, transparent 50%),
                linear-gradient(180deg, var(--booking-ivory) 0%, var(--booking-page-mid) 45%, var(--booking-mint-soft) 100%);
            min-height: 100vh;
        }

        .booking-hint-alert {
            background: linear-gradient(135deg, rgba(232, 245, 233, 0.95) 0%, rgba(254, 250, 224, 0.5) 100%);
            color: var(--bs-primary);
            border: 1px solid rgba(27, 67, 50, 0.14) !important;
            border-inline-start: 4px solid var(--booking-green-mid) !important;
        }

        .calendar-card {
            border: 1px solid rgba(27, 67, 50, 0.1);
            box-shadow: 0 0.5rem 1.75rem rgba(27, 67, 50, 0.07) !important;
            background: linear-gradient(180deg, #ffffff 0%, rgba(248, 253, 250, 0.98) 100%);
        }

        #header .btn-calendar-nav {
            width: 3rem;
            height: 3rem;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none !important;
            background: linear-gradient(160deg, #ffffff 0%, var(--booking-mint-soft) 45%, rgba(216, 243, 220, 0.65) 100%) !important;
            box-shadow:
                0 0.2rem 0.65rem rgba(27, 67, 50, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.95),
                0 0 0 1px rgba(45, 106, 79, 0.18);
            transition: transform 0.2s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        #header .btn-calendar-nav i {
            font-size: 1.45rem !important;
            line-height: 1;
            color: #1B4332;
            transition: color 0.2s ease, filter 0.25s ease, transform 0.2s ease;
            filter: drop-shadow(0 0.1rem 0.25rem rgba(27, 67, 50, 0.35));
        }

        #header .btn-calendar-nav:hover {
            transform: scale(1.06);
            background: linear-gradient(160deg, #ffffff 0%, var(--booking-mint) 50%, rgba(180, 230, 195, 0.85) 100%) !important;
            box-shadow:
                0 0.35rem 1rem rgba(27, 67, 50, 0.14),
                0 0 1.35rem rgba(64, 145, 108, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 1);
        }

        #header .btn-calendar-nav:hover i {
            color: #2D6A4F;
            filter: drop-shadow(0 0 0.5rem rgba(64, 145, 108, 0.85)) drop-shadow(0 0.15rem 0.35rem rgba(27, 67, 50, 0.3));
            transform: scale(1.08);
        }

        #header .btn-calendar-nav:active {
            transform: scale(0.97);
        }

        @media (prefers-reduced-motion: reduce) {
            #header .btn-calendar-nav,
            #header .btn-calendar-nav i {
                transition: none;
            }

            #header .btn-calendar-nav:hover {
                transform: none;
            }

            #header .btn-calendar-nav:hover i {
                transform: none;
            }
        }

        #weekDays,
        #daysContainer {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.35rem;
        }

        #calendar.row > #daysContainer {
            flex: 0 0 100%;
            width: 100%;
            max-width: 100%;
        }

        #weekDays .weekday {
            text-align: center;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #52796f;
            padding: 0.35rem 0;
        }

        #daysContainer > div:empty {
            min-height: 2.5rem;
        }

        #daysContainer > div:not(:empty) {
            aspect-ratio: 1;
            max-height: 2.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 0.5rem;
            cursor: pointer;
            background: linear-gradient(180deg, #ffffff 0%, var(--booking-mint-soft) 100%);
            border: 1px solid rgba(27, 67, 50, 0.12);
            color: #1B4332;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease, background 0.15s ease;
        }

        #daysContainer > div:not(:empty):hover {
            border-color: var(--booking-green-mid);
            background: linear-gradient(180deg, #ffffff 0%, var(--booking-mint) 100%);
            box-shadow: 0 0.25rem 0.85rem rgba(27, 67, 50, 0.12);
            transform: translateY(-1px);
        }

        #daysContainer > div:not(:empty).day-selected {
            background: linear-gradient(145deg, #1B4332 0%, var(--booking-green-mid) 55%, var(--booking-green-light) 100%);
            color: #fff;
            border-color: #1B4332;
            box-shadow: 0 0.35rem 1.1rem rgba(27, 67, 50, 0.28);
        }

        #panel.booking-panel--open {
            animation: bookingPanelIn 0.35s ease-out;
        }

        @keyframes bookingPanelIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #panel.booking-panel--open {
                animation: none;
            }
        }

        .booking-date-chip {
            background: linear-gradient(135deg, rgba(232, 245, 233, 0.9) 0%, rgba(254, 250, 224, 0.35) 100%);
            border: 1px solid rgba(27, 67, 50, 0.1) !important;
        }

        /* أزرار اللوحة: توهج ولمعة */
        #panel #btnS {
            position: relative;
            overflow: hidden;
            border: none !important;
            color: #fff !important;
            background: linear-gradient(135deg, #40916C 0%, #2D6A4F 38%, #1B4332 100%) !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            box-shadow:
                0 0.45rem 1.1rem var(--glow-deep),
                0 0 1.5rem var(--glow-mint),
                inset 0 1px 0 rgba(255, 255, 255, 0.22);
            transition: transform 0.2s ease, box-shadow 0.3s ease, filter 0.2s ease;
            animation: panelBtnGlow 2.8s ease-in-out infinite;
        }

        #panel #btnS::after {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, 0.18) 50%, transparent 60%);
            transform: translateX(-100%);
            animation: panelBtnShine 3.5s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes panelBtnGlow {
            0%, 100% {
                box-shadow:
                    0 0.45rem 1.1rem var(--glow-deep),
                    0 0 1.25rem rgba(95, 201, 140, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.22);
            }

            50% {
                box-shadow:
                    0 0.5rem 1.25rem var(--glow-deep),
                    0 0 2rem rgba(120, 224, 165, 0.65),
                    0 0 2.5rem rgba(64, 145, 108, 0.35),
                    inset 0 1px 0 rgba(255, 255, 255, 0.28);
            }
        }

        @keyframes panelBtnShine {
            0%, 35% {
                transform: translateX(-100%);
            }

            50%, 100% {
                transform: translateX(100%);
            }
        }

        #panel #btnS:hover {
            transform: translateY(-2px);
            filter: brightness(1.06);
            box-shadow:
                0 0.55rem 1.35rem rgba(27, 67, 50, 0.5),
                0 0 2rem rgba(120, 224, 165, 0.75),
                0 0 2.75rem rgba(95, 201, 140, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.3) !important;
            animation: none;
        }

        #panel #btnS:active {
            transform: translateY(0);
        }

        #panel #btnS .booking-btn-text {
            position: relative;
            z-index: 1;
        }

        #panel #cancel {
            border-width: 2px !important;
            font-weight: 600;
            color: #3d5a54 !important;
            border-color: rgba(82, 121, 111, 0.45) !important;
            background: rgba(255, 255, 255, 0.65) !important;
            transition: box-shadow 0.25s ease, border-color 0.2s ease, background 0.2s ease, color 0.2s ease;
        }

        #panel #cancel:hover {
            color: #1B4332 !important;
            border-color: #52796f !important;
            background: rgba(232, 245, 233, 0.85) !important;
            box-shadow:
                0 0 1.1rem rgba(82, 121, 111, 0.25),
                0 0 1.75rem rgba(64, 145, 108, 0.2);
        }

        @media (prefers-reduced-motion: reduce) {
            #panel #btnS {
                animation: none;
            }

            #panel #btnS::after {
                display: none;
            }

            #panel #btnS:hover {
                transform: none;
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
    <div class="container py-4 py-lg-5">
        <div class="row g-4 align-items-start">
            <div class="col-12 col-lg-4 order-2 order-lg-1">
                <div class="alert booking-hint-alert mb-3 d-flex align-items-start gap-2 shadow-sm" role="status" id="booking-hint">
                    <i class="bi bi-hand-index fs-4 text-primary flex-shrink-0 mt-1"></i>
                    <span class="fw-semibold"><?php echo $lang['booking']['hint_text'] ?></span>
                </div>

                <div id="panel" class="card border-0 shadow-sm calendar-card d-none">
                    <div class="card-body p-3 p-md-4">
                        <h2 class="h5 fw-bold text-primary mb-2"> <?php echo $lang['booking']['details_title'] ?><</h2>
                        <p class="small text-muted mb-3 p-2 rounded booking-date-chip">
                            التاريخ: <span id="display-date" class="fw-bold text-primary"></span>
                        </p>

                        <form id="bookingForm">
                            <input type="hidden" name="service_id" value="<?php echo isset($_GET['service_id']) ? $_GET['service_id'] : ''; ?>">
                            <input type="hidden" name="provider_id" value="<?php echo isset($_GET['provider_id']) ? $_GET['provider_id'] : ''; ?>">
                            <input type="hidden" name="booking_date" id="dateInput">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="bookingTime"> <?php echo $lang['booking']['date_label'] ?></label>
                                <input type="time" id="bookingTime" name="time" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="serviceNotes"><?php echo $lang['booking']['notes_label'] ?></label>
                                <textarea id="serviceNotes" class="form-control" rows="3"
                                    placeholder=" <?php echo $lang['booking']['notes_placeholder'] ?>" name="notes"></textarea>
                            </div>
                            <!-- حقل الموقع -->
<div class="mb-3">
    <label class="form-label fw-semibold small" for="locationText"> <?php echo $lang['booking']['location_label'] ?></label>
    <div class="input-group">
        <input type="text" id="locationText" name="location_text" 
               class="form-control" placeholder=" <?php echo $lang['booking']['location_placeholder'] ?>  ">
        <button type="button" class="btn btn-outline-primary" id="btnLocation">
            <i class="bi bi-geo-alt-fill"></i>
        </button>
    </div>
    <input type="hidden" name="location_lat" id="locationLat">
    <input type="hidden" name="location_lng" id="locationLng">
    <div id="locationStatus" class="form-text"></div>
</div>

                            
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-2 position-relative" id="btnS" name="submit"><span class="booking-btn-text"> <?php echo $lang['booking']['btn_confirm'] ?> </span></button>
                        </form>
                        <button type="button" class="btn btn-outline-secondary w-100" id="cancel"><?php echo $lang['booking']['btn_cancel'] ?></button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8 order-1 order-lg-2">
                <div class="card border-0 shadow-sm calendar-card h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="row g-2 g-md-3" id="calendar">
                            <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-3 mb-2" id="header">
                                <button type="button" class="btn btn-outline-primary btn-calendar-nav rounded-circle" id="next-month" aria-label="الشهر التالي">
                                    <i class="bi bi-arrow-left-circle-fill fs-5"></i>
                                </button>
                                <div class="text-center flex-grow-1 px-2">
                                    <div id="currentMonth" class="fs-4 fw-bold text-dark"></div>
                                    <div id="currentYear" class="small text-muted fw-semibold"></div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-calendar-nav rounded-circle" id="prev-month" aria-label="الشهر السابق">
                                    <i class="bi bi-arrow-right-circle-fill fs-5"></i>
                                </button>
                            </div>

                            <div id="weekDays" class="col-12">
                                <div class="weekday">Sun</div>
                                <div class="weekday">Mon</div>
                                <div class="weekday">Tue</div>
                                <div class="weekday">Wed</div>
                                <div class="weekday">Thu</div>
                                <div class="weekday">Fri</div>
                                <div class="weekday">Sat</div>
                            </div>
                            <div id="daysContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //هون حددت المتغيرات يلي رح تعرض الوقت الحالي الشهر والسنة 
        let date = new Date();//التاريخ الحالي
        let currentMonth = date.getMonth();//بتعطيني الشهر الحالي بس ارقام من 0-11
        let currentYear = date.getFullYear();//بتعطيني السنة الحالية


        //الpanel
        const bookingPanel = document.getElementById('panel');
        const displayDate = document.getElementById('display-date');
        const btnConfirm = document.getElementById('btnS');
        const cancel = document.getElementById('cancel');
        const hiddenInput = document.getElementById('dateInput');

        //مصفوفة الاشهر
        const arrayMonth = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];


        function drowCelender() {
            let firstDay = new Date(currentYear, currentMonth, 1).getDay();//حسب اول يم بالشهر
            let lastDay = new Date(currentYear, currentMonth + 1, 0).getDate();//بحسب اخر يوم بالشهر


            let monthDisplay = document.getElementById('currentMonth').innerHTML = arrayMonth[currentMonth];
            let yearDisplay = document.getElementById('currentYear').innerHTML = currentYear;


            let daysContainer = document.getElementById('daysContainer');
            daysContainer.innerHTML = "";

            for (let i = 0; i < firstDay; i++) {//هاي اللوب لحتى تحدد اي يوم هو اول شهر
                let emptyDiv = document.createElement('div');
                daysContainer.appendChild(emptyDiv);

            }
            for (let j = 1; j <= lastDay; j++) {//هاي اللوب حددت فيها تواريخ الايام
                let crateDivDay = document.createElement('div');
                crateDivDay.innerHTML = j;
                  const today = new Date();
    const isCurrentMonth = currentYear === today.getFullYear() && currentMonth === today.getMonth();
    const isPast = isCurrentMonth && j < today.getDate();
    const isPastMonth = currentYear < today.getFullYear() || 
                        (currentYear === today.getFullYear() && currentMonth < today.getMonth());

   // أيام العمل المتاحة
    const dayNames = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
    const dayOfWeek = dayNames[new Date(currentYear, currentMonth, j).getDay()];
    const allowedDays = WORKING_DAYS
        ? WORKING_DAYS.split(',').map(d => d.trim().toLowerCase())
        : [];
    const isOffDay = allowedDays.length > 0 && !allowedDays.includes(dayOfWeek);

    // الأيام المحجوزة بالكامل
    const num_month_check = String(currentMonth + 1).padStart(2, '0');
    const num_day_check   = String(j).padStart(2, '0');
    const dateStr = `${currentYear}-${num_month_check}-${num_day_check}`;
    const isFullyBooked = FULLY_BOOKED.includes(dateStr);

    if (isPast || isPastMonth) {
        crateDivDay.style.opacity = '0.35';
        crateDivDay.style.cursor = 'not-allowed';
        crateDivDay.style.pointerEvents = 'none';
    } else if (isOffDay) {
        crateDivDay.style.opacity = '0.4';
        crateDivDay.style.cursor = 'not-allowed';
        crateDivDay.style.pointerEvents = 'none';
        crateDivDay.style.background = '#e0e0e0';
        crateDivDay.style.color = '#999';
    } else if (isFullyBooked) {
        crateDivDay.style.cursor = 'not-allowed';
        crateDivDay.style.pointerEvents = 'none';
        crateDivDay.style.background = 'linear-gradient(180deg, #ffe0e0 0%, #ffb3b3 100%)';
        crateDivDay.style.color = '#c0392b';
        crateDivDay.style.border = '1px solid #e74c3c';
        crateDivDay.title = '<?php echo $lang['booking']['fully_booked_title'] ?> ';
    }

                daysContainer.appendChild(crateDivDay);

                function clickDay(event) {
                    bookingPanel.classList.remove('d-none');
                    bookingPanel.classList.add('d-block', 'booking-panel--open');
                    daysContainer.querySelectorAll('div:not(:empty)').forEach(function (el) {
                        el.classList.remove('day-selected');
                    });
                    crateDivDay.classList.add('day-selected');

                    num_month = currentMonth + 1;
                    let displayFullDate = j + '-' + num_month + '-' + currentYear;
                    displayDate.innerHTML = displayFullDate;

                    hiddenInput.value = currentYear + '-' + num_month + '-' + j;
                }

                crateDivDay.addEventListener('click', clickDay);


            }

        }

        drowCelender();

        let btnPrev = document.getElementById('prev-month');
        let btnNext = document.getElementById('next-month');

        function buttonPrev(event) {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            drowCelender();
        }

        function buttonNext(event) {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            drowCelender();
        }

        btnPrev.addEventListener('click', buttonPrev);
        btnNext.addEventListener('click', buttonNext);

      // ============================================================
// إرسال نموذج الحجز عبر AJAX بدلاً من submit عادي
// ============================================================
document.getElementById('bookingForm').addEventListener('submit', function(event) {
    event.preventDefault(); // نمنع الإرسال التقليدي للصفحة

    const time = document.getElementById('bookingTime').value; // نقرأ الوقت المختار

    // التحقق من أن المستخدم اختار وقتاً قبل الإرسال
    if (time === "") {
        Swal.fire({
            icon: 'warning',
            title: "<?php echo $lang['booking']['warn_title'] ?>",
            text: "<?php echo $lang['booking']['warn_no_time'] ?>",
            confirmButtonColor: '#1B4332'
        });
        return; // نوقف التنفيذ إذا الوقت فارغ
    }

    const formData = new FormData(this); // نجمع كل حقول النموذج تلقائياً
    formData.append('submit', '1');       // نضيف مفتاح submit لأن PHP تتحقق منه

    // نعطّل الزر أثناء الإرسال لمنع الضغط المزدوج
    const btn = document.getElementById('btnS');
    btn.disabled = true;

    // إرسال البيانات إلى booking_process.php بدون تحميل الصفحة
    fetch('saveBooking.php', {
        method: 'POST',        // طريقة الإرسال POST
        body: formData         // البيانات المجمّعة من النموذج
    })
    .then(res => res.json())   // نحوّل الرد من JSON إلى object JS
    .then(data => {
        btn.disabled = false;  // نعيد تفعيل الزر بعد ورود الرد

        if (data.success) {
            // الحجز نجح → نعرض رسالة ثم ننقل المستخدم للداشبورد
            Swal.fire({
                icon: 'success',
                title: " <?php echo $lang['booking']['success_title'] ?>",
                text: data.message,
                confirmButtonColor: '#1B4332',
                timer: 2000,         // تغلق تلقائياً بعد ثانيتين
                showConfirmButton: false
            }).then(() => {
                window.location.href = data.redirect; // ننقل للصفحة المحددة من السيرفر
            });
        } else {
            // الحجز فشل → نعرض رسالة الخطأ القادمة من PHP
            Swal.fire({
                icon: 'error',
                title: "<?php echo $lang['booking']['warn_title'] ?>",
                text: data.message,
                confirmButtonColor: '#1B4332'
            });

            // إذا PHP أرسلت redirect (مثل تسجيل الدخول) ننفذه
            if (data.redirect) {
                setTimeout(() => { window.location.href = data.redirect; }, 2000);
            }
        }
    })
    .catch(() => {
        // خطأ في الشبكة أو في الاتصال بالسيرفر
        btn.disabled = false;
        Swal.fire({
            icon: 'error',
            title: "<?php echo $lang['booking']['err_title'] ?>",
            text: "<?php echo $lang['booking']['err_server'] ?>",
            confirmButtonColor: '#1B4332'
        });
    });
});
        function closePanel(event) {
            bookingPanel.classList.add('d-none');
            bookingPanel.classList.remove('d-block', 'booking-panel--open');
        }
        cancel.addEventListener('click', closePanel);

        
        document.getElementById('btnLocation').addEventListener('click', function() {
    const status = document.getElementById('locationStatus');
    const btn = document.getElementById('btnLocation');
    
    if (!navigator.geolocation) {
        status.innerHTML = '<span class="text-danger"> <?php echo $lang['booking']['loc_unsupported'] ?></span>';
        return;
    }
    
    status.innerHTML = '<span class="text-muted"><i class="bi bi-hourglass-split"></i> <?php echo $lang['booking']['loc_detecting'] ?></span>';
    btn.disabled = true;
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            document.getElementById('locationLat').value = lat;
            document.getElementById('locationLng').value = lng;
            
            // Nominatim API
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`, {
                headers: { 'Accept-Language': 'ar' }
            })
            .then(res => res.json())
            .then(data => {
                const address = data.display_name || `${lat}, ${lng}`;
                document.getElementById('locationText').value = address;
                status.innerHTML = '<span class="text-success"><i class="bi bi-check-circle-fill"></i>  <?php echo $lang['booking']['loc_success'] ?></span>';
                btn.disabled = false;
            })
            .catch(() => {
                document.getElementById('locationText').value = `${lat}, ${lng}`;
                status.innerHTML = '<span class="text-warning"> <?php echo $lang['booking']['loc_no_address'] ?></span>';
                btn.disabled = false;
            });
        },
        function(error) {
            status.innerHTML = '<span class="text-danger"><?php echo $lang['booking']['loc_denied'] ?></span>';
            btn.disabled = false;
        }
    );
});


    </script>
</body>

</html>