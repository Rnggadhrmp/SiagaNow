

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SiagaNow | Siaga Bencana, Selamat Bersama</title>

    <meta name="description" content="SiagaNow membantu masyarakat mendapatkan informasi kebencanaan, cuaca, shelter, dan kesiapsiagaan banjir serta tanah longsor.">

    <style>

        :root {

            --green-dark: #075c49;

            --green-deep: #064638;

            --green-main: #0b795d;

            --green-soft: #d9f0e5;

            --green-pale: #eff8f2;

            --text-dark: #123d35;

            --text-muted: #648078;

            --danger: #dc4c50;

        }

        * {

            box-sizing: border-box;

        }

        body {

            margin: 0;

            color: var(--text-dark);

            font-family: Arial, Helvetica, sans-serif;

            background: #d9eee2;

        }

        a, button {

            -webkit-tap-highlight-color: transparent;

        }

        .page-shell {

            position: relative;

            min-height: 100vh;

            padding: 22px 20px 40px;

        }

        .site-header {

            max-width: 1440px;

            margin: 0 auto 24px;

            padding: 13px 20px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 22px;

            flex-wrap: wrap;

            border: 1px solid rgba(255,255,255,.65);

            border-radius: 19px;

            background: rgba(238, 250, 243, .88);

            box-shadow: 0 8px 28px rgba(12, 83, 64, .09);

            backdrop-filter: blur(12px);

        }

        .brand {

            display: flex;

            align-items: center;

            gap: 12px;

            text-decoration: none;

            color: var(--green-dark);

        }

        .brand-symbol {

            width: 48px;

            height: 48px;

            border-radius: 15px;

            display: grid;

            place-items: center;

            background: var(--green-dark);

            color: white;

            font-size: 25px;

            flex-shrink: 0;

        }

        .brand-name {

            font-size: 25px;

            font-weight: 900;

            letter-spacing: -.8px;

        }

        .brand-caption {

            display: block;

            margin-top: 2px;

            font-size: 11px;

            font-weight: 600;

            letter-spacing: .3px;

            color: #65857a;

        }

        .navigation {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 9px;

            flex-wrap: wrap;

        }

        .nav-link {

            display: inline-flex;

            justify-content: center;

            align-items: center;

            gap: 8px;

            padding: 12px 17px;

            border: 1px solid #d1e5da;

            border-radius: 12px;

            background: #fff;

            color: var(--green-dark);

            text-decoration: none;

            font-size: 14px;

            font-weight: 700;

            transition: .2s ease;

        }

        .nav-link:hover {

            transform: translateY(-1px);

            background: #e7f6ed;

        }

        .nav-link.active {

            color: white;

            background: var(--green-dark);

            border-color: var(--green-dark);

        }

        .dashboard {

            max-width: 1440px;

            margin: 0 auto;

        }

        .welcome-card {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 20px;

            padding: 25px 28px;

            border: 1px solid rgba(255,255,255,.8);

            border-radius: 20px;

            background: rgba(246, 251, 247, .94);

            box-shadow: 0 8px 24px rgba(9, 71, 54, .08);

        }

        .eyebrow {

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 1.5px;

            font-weight: 800;

            color: #218568;

        }

        .welcome-title {

            margin: 8px 0;

            font-size: clamp(25px, 3vw, 37px);

            line-height: 1.15;

            font-weight: 900;

            letter-spacing: -1.2px;

        }

        .welcome-description {

            max-width: 700px;

            color: var(--text-muted);

            font-size: 14px;

            line-height: 1.8;

        }

        .date-chip {

            padding: 11px 15px;

            border: 1px solid #c7e3d4;

            border-radius: 12px;

            background: #f5fbf6;

            color: var(--green-dark);

            font-size: 12px;

            font-weight: 700;

            white-space: nowrap;

        }

        .section-heading {

            margin: 0;

            font-size: 17px;

            font-weight: 850;

            color: var(--green-dark);

        }

        .section-subtitle {

            margin: 7px 0 0;

            font-size: 12px;

            line-height: 1.7;

            color: var(--text-muted);

        }

        .panel {

            border: 1px solid rgba(255,255,255,.85);

            border-radius: 17px;

            background: rgba(248, 252, 248, .96);

            box-shadow: 0 6px 22px rgba(8, 72, 53, .08);

        }

        .panel-padding {

            padding: 20px;

        }

        .section-title-row {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 12px;

            margin-bottom: 17px;

        }

        .status-pill {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            border-radius: 30px;

            background: #e5f5e9;

            color: #226c4e;

            font-size: 10px;

            font-weight: 800;

        }

        .status-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background: #d99c28;

        }

        .warning-panel {

            display: grid;

            grid-template-columns: auto minmax(0, 1fr) auto;

            gap: 17px;

            align-items: center;

            padding: 19px 22px;

            border: 1px solid #f1d8a9;

            border-radius: 17px;

            background: #fff8e8;

            margin-bottom: 22px;

        }

        .warning-icon {

            width: 47px;

            height: 47px;

            border-radius: 14px;

            display: grid;

            place-items: center;

            background: #f7e7bf;

            font-size: 24px;

        }

        .warning-title {

            font-weight: 850;

            font-size: 15px;

            color: #79551a;

        }

        .warning-text {

            margin-top: 5px;

            font-size: 12px;

            line-height: 1.7;

            color: #866e47;

        }

        .warning-badge {

            padding: 8px 11px;

            border-radius: 9px;

            background: #f4e8c9;

            color: #78591e;

            font-size: 10px;

            font-weight: 800;

            white-space: nowrap;

        }

        .main-grid {

            display: grid;

            grid-template-columns: minmax(0, 1.8fr) minmax(290px, .85fr);

            gap: 21px;

            align-items: start;

        }

        .content-column,

        .side-column {

            display: grid;

            gap: 21px;

            min-width: 0;

        }

        .metrics-grid {

            display: grid;

            grid-template-columns: repeat(3, minmax(0, 1fr));

            gap: 13px;

        }

        .metric-card {

            padding: 18px;

            border: 1px solid #d9eae0;

            border-radius: 15px;

            background: #fff;

        }

        .metric-top {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 8px;

        }

        .metric-icon {

            width: 37px;

            height: 37px;

            display: grid;

            place-items: center;

            border-radius: 11px;

            background: #e3f4e9;

            font-size: 19px;

        }

        .metric-label {

            margin-top: 14px;

            font-size: 12px;

            font-weight: 700;

            color: #55776b;

        }

        .metric-value {

            margin-top: 9px;

            font-size: 16px;

            font-weight: 850;

            color: var(--green-dark);

        }

        .metric-note {

            margin-top: 7px;

            font-size: 10px;

            line-height: 1.6;

            color: #83968e;

        }

        .map-preview {

            position: relative;

            overflow: hidden;

            height: 300px;

            border-radius: 13px;

            border: 1px solid #c9e2d6;

            background: #e8f0e9;

            isolation: isolate;

        }

        #home-map {

            width: 100%;

            height: 100%;

            z-index: 1;

        }

        .map-preview-label {

            position: absolute;

            z-index: 500;

            top: 12px;

            left: 12px;

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 9px 12px;

            border: 1px solid rgba(255,255,255,.9);

            border-radius: 10px;

            background: rgba(255,255,255,.95);

            color: #075c49;

            font-size: 12px;

            font-weight: 800;

            box-shadow: 0 2px 10px rgba(20,70,50,.12);

            pointer-events: none;

        }

        .map-caption {

            position: absolute;

            z-index: 500;

            bottom: 10px;

            left: 10px;

            max-width: calc(100% - 20px);

            padding: 7px 9px;

            border: 1px solid rgba(255,255,255,.8);

            border-radius: 8px;

            background: rgba(255,255,255,.94);

            font-size: 10px;

            color: #4d6e60;

            pointer-events: none;

        }

        .home-map-pin {

            display: flex;

            align-items: center;

            justify-content: center;

            width: 30px;

            height: 30px;

            border: 2px solid #fff;

            border-radius: 50% 50% 50% 0;

            background: #dc4c50;

            color: #fff;

            font-size: 15px;

            font-weight: 800;

            box-shadow: 0 2px 8px rgba(0,0,0,.25);

            transform: rotate(-45deg);

        }

        .home-map-pin span {

            transform: rotate(45deg);

        }

        .map-open {

            display: block;

            margin-top: 14px;

            text-align: center;

            text-decoration: none;

            color: white;

            background: var(--green-dark);

            border-radius: 11px;

            padding: 12px;

            font-size: 12px;

            font-weight: 800;

            transition: .2s;

        }

        .map-open:hover {

            background: var(--green-deep);

        }

        .feature-list {

            display: grid;

            gap: 10px;

        }

        .feature-row {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 13px;

            border: 1px solid #dfede4;

            border-radius: 12px;

            background: #fff;

        }

        .feature-icon {

            width: 39px;

            height: 39px;

            flex-shrink: 0;

            display: grid;

            place-items: center;

            border-radius: 11px;

            background: #e6f4eb;

            font-size: 20px;

        }

        .feature-title {

            font-size: 12px;

            font-weight: 800;

            color: var(--green-dark);

        }

        .feature-description {

            margin-top: 5px;

            font-size: 10px;

            line-height: 1.6;

            color: var(--text-muted);

        }

        .feature-arrow {

            margin-left: auto;

            color: #54816f;

            font-size: 19px;

        }

        .feature-link {

            color: inherit;

            text-decoration: none;

        }

        .feature-link:hover .feature-row {

            border-color: #9acbb2;

            background: #f3faf5;

        }

        .news-placeholder {

            display: grid;

            gap: 12px;

        }

        .news-item {

            display: flex;

            gap: 12px;

            align-items: start;

            padding-bottom: 12px;

            border-bottom: 1px solid #e4eee7;

        }

        .news-item:last-child {

            padding-bottom: 0;

            border-bottom: none;

        }

        .news-thumbnail {

            width: 65px;

            height: 58px;

            flex-shrink: 0;

            display: grid;

            place-items: center;

            border-radius: 11px;

            background: #e3f2e7;

            font-size: 23px;

        }

        .news-title {

            font-size: 12px;

            font-weight: 800;

            line-height: 1.6;

        }

        .news-description {

            margin-top: 5px;

            color: var(--text-muted);

            font-size: 10px;

            line-height: 1.7;

        }

        .donation-banner {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 24px;

            border: 1px solid rgba(255,255,255,.8);

            border-radius: 17px;

            color: white;

            background: linear-gradient(115deg, #075b47, #12866a);

            box-shadow: 0 8px 24px rgba(8, 72, 53, .13);

        }

        .donation-title {

            font-size: 19px;

            font-weight: 900;

        }

        .donation-description {

            margin-top: 8px;

            max-width: 580px;

            font-size: 12px;

            line-height: 1.8;

            color: #d3eee1;

        }

        .donation-button {

            display: inline-block;

            flex-shrink: 0;

            padding: 13px 18px;

            border-radius: 11px;

            background: #f5fbf6;

            color: var(--green-dark);

            text-decoration: none;

            font-size: 12px;

            font-weight: 850;

        }

        .donation-button:hover {

            background: #dff3e7;

        }

        .footer {

            max-width: 1440px;

            margin: 28px auto 0;

            text-align: center;

            color: #e4f5eb;

            font-size: 11px;

            line-height: 1.8;

        }

        /* Mega menu Other */

        .sn-other-wrap { position: relative; display: inline-flex; align-items: center; }

        .sn-other-trigger { font-family: inherit; cursor: pointer; }

        .sn-other-trigger[aria-expanded="true"] { background: var(--green-dark); color: #fff; border-color: var(--green-dark); }

        .sn-other-chevron { transition: transform .18s ease; flex-shrink: 0; }

        .sn-other-panel {

            position: absolute; z-index: 1200; top: calc(100% + 12px); right: 0;

            width: min(760px, calc(100vw - 32px)); padding: 20px;

            border: 1px solid #d3e7dc; border-radius: 18px;

            background: rgba(255,255,255,.98); box-shadow: 0 22px 55px rgba(4,55,43,.20);

            color: var(--text-dark); backdrop-filter: blur(12px);

        }

        .sn-other-panel[hidden] { display: none; }

        .sn-other-panel-heading { margin: 0 0 14px; color: #07805f; font-size: 12px; font-weight: 900; letter-spacing: .14em; text-transform: uppercase; }

        .sn-other-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px 16px; }

        .sn-other-item {

            display: flex; align-items: flex-start; gap: 12px; min-width: 0; padding: 13px;

            border-left: 4px solid #16a875; border-radius: 10px; background: #f8fcf9;

            color: inherit; text-decoration: none; transition: background .15s, transform .15s;

        }

        a.sn-other-item:hover { background: #eaf8f0; transform: translateY(-1px); }

        .sn-other-icon { display: grid; place-items: center; flex: 0 0 34px; height: 34px; border-radius: 9px; background: #e2f5eb; color: #08745a; font-size: 19px; font-weight: 800; }

        .sn-other-title { display: block; color: var(--green-dark); font-size: 13px; font-weight: 850; line-height: 1.4; }

        .sn-other-desc { display: block; margin-top: 4px; color: var(--text-muted); font-size: 11px; line-height: 1.55; }

        .sn-other-tag { display: inline-block; margin-top: 6px; padding: 3px 7px; border-radius: 999px; background: #fff3d8; color: #8a5a08; font-size: 9px; font-weight: 800; }

        .sn-other-item.is-planned { cursor: default; opacity: .86; }

        .sn-other-footer { margin-top: 14px; padding-top: 12px; border-top: 1px solid #e0eee6; color: var(--text-muted); font-size: 11px; line-height: 1.6; }

        .sn-other-trigger:focus-visible, .sn-other-item:focus-visible { outline: 3px solid #f0b429; outline-offset: 3px; }

        @media (max-width: 1024px) {

            .main-grid {

                grid-template-columns: 1fr;

            }

            .side-column {

                grid-template-columns: repeat(2, minmax(0, 1fr));

                align-items: start;

            }

            .site-header {

                align-items: flex-start;

            }

        }

        @media (max-width: 640px) {

            .page-shell {

                padding: 12px 11px 25px;

            }

            .site-header {

                padding: 14px;

                margin-bottom: 14px;

                gap: 14px;

            }

            .brand-name {

                font-size: 22px;

            }

            .navigation {

                width: 100%;

                justify-content: flex-start;

                gap: 7px;

            }

            .nav-link {

                padding: 9px 10px;

                font-size: 11px;

                gap: 5px;

            }

            .welcome-card {

                align-items: flex-start;

                flex-direction: column;

                padding: 20px;

                margin-bottom: 14px;

            }

            .welcome-title {

                font-size: 27px;

            }

            .warning-panel {

                grid-template-columns: auto minmax(0, 1fr);

                padding: 15px;

                gap: 11px;

                margin-bottom: 14px;

            }

            .warning-badge {

                grid-column: 2;

                justify-self: start;

            }

            .main-grid,

            .content-column,

            .side-column {

                gap: 14px;

            }

            .side-column {

                grid-template-columns: 1fr;

            }

            .metrics-grid {

                grid-template-columns: 1fr;

            }

            .metric-card {

                display: grid;

                grid-template-columns: auto minmax(0, 1fr);

                gap: 0 13px;

                align-items: center;

            }

            .metric-top {

                grid-row: span 3;

            }

            .metric-label,

            .metric-value,

            .metric-note {

                margin-top: 0;

            }

            .metric-value {

                margin-top: 4px;

            }

            .metric-note {

                margin-top: 4px;

            }

            .donation-banner {

                align-items: flex-start;

                flex-direction: column;

                padding: 20px;

            }

            .donation-button {

                width: 100%;

                text-align: center;

            }

            .panel-padding {

                padding: 16px;

            }

        }

    </style>

@vite(['resources/css/app.css', 'resources/js/maps.js'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>

<body data-page="home">

<div class="page-shell">

    <!-- NAVBAR -->

    @include('partials.site-navbar')

@include('partials.dashboard-home')

    <footer class="footer">

        <p class="font-bold">SiagaNow — Siaga Bencana, Selamat Bersama</p>

        <p>

            Platform informasi kesiapsiagaan banjir dan tanah longsor.

            Informasi risiko dan peringatan harus merujuk pada sumber resmi.

        </p>

    </footer>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const mapElement = document.getElementById('home-map');

        if (!mapElement || typeof L === 'undefined') return;

        const homeMap = L.map('home-map', {

            scrollWheelZoom: false,

            zoomControl: true

        }).setView([-0.9471, 100.4172], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap</a>',

            maxZoom: 19

        }).addTo(homeMap);

        // Penanda ini hanya menunjukkan pusat wilayah Sumatera Barat, bukan titik bahaya.

        const centerPin = L.divIcon({

            className: '',

            html: '<div class="home-map-pin"><span>•</span></div>',

            iconSize: [30, 30],

            iconAnchor: [15, 30]

        });

        L.marker([-0.9471, 100.4172], { icon: centerPin })

            .addTo(homeMap)

            .bindPopup('<strong>Sumatera Barat</strong><br>Pusat tampilan peta');

        setTimeout(function () { homeMap.invalidateSize(); }, 150);

    });

</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-sn-other]').forEach(function (wrap) {

        if (wrap.dataset.snInitialized === 'true') return;

        wrap.dataset.snInitialized = 'true';

        const trigger = wrap.querySelector('[data-sn-other-trigger]');

        const panel = wrap.querySelector('[data-sn-other-panel]');

        const chevron = wrap.querySelector('.sn-other-chevron');

        if (!trigger || !panel) return;

        function closeMenu() {

            panel.hidden = true;

            trigger.setAttribute('aria-expanded', 'false');

            if (chevron) chevron.style.transform = '';

        }

        trigger.addEventListener('click', function (event) {

            event.stopPropagation();

            const open = trigger.getAttribute('aria-expanded') !== 'true';

            panel.hidden = !open;

            trigger.setAttribute('aria-expanded', String(open));

            if (chevron) chevron.style.transform = open ? 'rotate(180deg)' : '';

        });

        document.addEventListener('click', function (event) {

            if (!wrap.contains(event.target)) closeMenu();

        });

        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                closeMenu();

                trigger.focus();

            }

        });

        panel.addEventListener('click', function (event) {

            if (event.target.closest('a')) closeMenu();

        });

    });

});

</script>

</body>

</html>
