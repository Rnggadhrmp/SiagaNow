
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SiagaNow | Siaga Bencana, Selamat Bersama</title>
    <meta name="description" content="SiagaNow membantu masyarakat mendapatkan informasi kebencanaan, cuaca, shelter, dan kesiapsiagaan banjir serta tanah longsor.">

    <script src="https://cdn.tailwindcss.com"></script>

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

        .landscape {
            position: fixed;
            inset: 0;
            z-index: -2;
            pointer-events: none;
            background-image: url('/images/siaganow-bg.png');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
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
            min-height: 205px;
            border-radius: 13px;
            border: 1px solid #c9e2d6;
            background:
                radial-gradient(ellipse at 30% 40%, #c4e8d0 0%, transparent 45%),
                linear-gradient(145deg, #d9eee4, #a8d7c0);
        }

        .map-preview::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .7;
            background-image:
                linear-gradient(35deg, transparent 46%, #f5fff7 47%, #f5fff7 48%, transparent 49%),
                linear-gradient(125deg, transparent 46%, #f5fff7 47%, #f5fff7 48%, transparent 49%);
            background-size: 110px 90px, 140px 100px;
        }

        .map-water {
            position: absolute;
            width: 44%;
            height: 130%;
            top: -15%;
            left: -14%;
            transform: rotate(18deg);
            background: #9bd3d8;
            border-radius: 40% 60% 70% 30%;
            opacity: .9;
        }

        .map-label {
            position: absolute;
            z-index: 2;
            top: 45%;
            left: 48%;
            transform: translate(-50%, -50%);
            padding: 9px 12px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,.8);
            background: rgba(248,252,248,.92);
            color: #356c59;
            font-size: 12px;
            font-weight: 800;
            text-align: center;
        }

        .map-marker {
            position: absolute;
            z-index: 2;
            width: 12px;
            height: 12px;
            border: 3px solid #fff;
            border-radius: 50%;
            background: #db5757;
            box-shadow: 0 1px 6px #497c69;
        }

        .map-caption {
            position: absolute;
            z-index: 2;
            bottom: 10px;
            left: 10px;
            padding: 7px 9px;
            border-radius: 8px;
            background: rgba(255,255,255,.9);
            font-size: 10px;
            color: #4d6e60;
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
</head>

<body>

<!-- Background ilustrasi lanskap dari public/images/siaganow-bg.png -->
<div class="landscape" aria-hidden="true"></div>

<div class="page-shell">

    <!-- NAVBAR -->
    <header class="site-header">
        <a href="/" class="brand">
            <div class="brand-symbol">⌂</div>
            <div>
                <div class="brand-name">SiagaNow</div>
                <span class="brand-caption">Siaga Bencana, Selamat Bersama</span>
            </div>
        </a>

        <nav class="navigation" aria-label="Navigasi utama">
            <a href="/" class="nav-link active">
                <span>⌂</span> Home
            </a>
            <a href="/maps" class="nav-link">
                <span>▧</span> Maps
            </a>
            <a href="/report" class="nav-link">
                <span>⚑</span> Report
            </a>
            <a href="/donate" class="nav-link">
                <span>♡</span> Donate
            </a>
            <a href="/other" class="nav-link">
                <span>☰</span> Other
            </a>
        </nav>
    </header>

    <main class="dashboard">

        <!-- WELCOME -->
        <section class="welcome-card">
            <div>
                <div class="eyebrow">Platform Kesiapsiagaan Bencana</div>
                <h1 class="welcome-title">
                    Selamat Datang di SiagaNow
                </h1>
                <p class="welcome-description">
                    Tetap waspada, kenali risiko di sekitarmu, dan dapatkan
                    informasi kesiapsiagaan banjir serta tanah longsor
                    dalam satu platform.
                </p>
            </div>

            <div class="date-chip">
                📍 Fokus: Sumatera Barat
            </div>
        </section>

        <!-- INFORMASI PERINGATAN -->
        <section class="warning-panel">
            <div class="warning-icon">⚠️</div>

            <div>
                <div class="warning-title">
                    Pusat Informasi Kesiapsiagaan
                </div>
                <p class="warning-text">
                    Informasi peringatan dini belum terhubung dengan sumber
                    resmi. Periksa pengumuman BMKG dan BPBD untuk mendapatkan
                    informasi kebencanaan terkini.
                </p>
            </div>

            <span class="warning-badge">
                Belum terhubung
            </span>
        </section>

        <div class="main-grid">

            <!-- KOLOM UTAMA -->
            <div class="content-column">

                <!-- RINGKASAN -->
                <section class="panel panel-padding">
                    <div class="section-title-row">
                        <div>
                            <h2 class="section-heading">
                                Ringkasan Informasi
                            </h2>
                            <p class="section-subtitle">
                                Informasi penting untuk membantu kesiapsiagaan.
                            </p>
                        </div>

                        <span class="status-pill">
                            <span class="status-dot"></span>
                            Menunggu data
                        </span>
                    </div>

                    <div class="metrics-grid">

                        <article class="metric-card">
                            <div class="metric-top">
                                <div class="metric-icon">🌦️</div>
                            </div>
                            <div class="metric-label">Informasi Cuaca</div>
                            <div class="metric-value">Belum tersedia</div>
                            <p class="metric-note">
                                Menunggu integrasi sumber cuaca.
                            </p>
                        </article>

                        <article class="metric-card">
                            <div class="metric-top">
                                <div class="metric-icon">🌱</div>
                            </div>
                            <div class="metric-label">Kelembapan Tanah</div>
                            <div class="metric-value">Belum tersedia</div>
                            <p class="metric-note">
                                Menunggu integrasi sumber data.
                            </p>
                        </article>

                        <article class="metric-card">
                            <div class="metric-top">
                                <div class="metric-icon">📊</div>
                            </div>
                            <div class="metric-label">Statistik Bencana</div>
                            <div class="metric-value">Belum tersedia</div>
                            <p class="metric-note">
                                Data kejadian belum terhubung.
                            </p>
                        </article>

                    </div>
                </section>

                <!-- PRATINJAU PETA -->
                <section class="panel panel-padding">
                    <div class="section-title-row">
                        <div>
                            <h2 class="section-heading">
                                Peta Kebencanaan
                            </h2>
                            <p class="section-subtitle">
                                Jelajahi wilayah dan informasi geografis Sumatera Barat.
                            </p>
                        </div>
                    </div>

                    <div class="map-preview" aria-label="Ilustrasi pratinjau peta">
                        <div class="map-water"></div>

                        <div class="map-label">
                            📍 Sumatera Barat
                        </div>

                        <span class="map-marker" style="top:32%;left:37%;"></span>
                        <span class="map-marker" style="top:61%;left:60%;"></span>
                        <span class="map-marker" style="top:72%;left:46%;"></span>

                        <div class="map-caption">
                            Ilustrasi tampilan peta · Data risiko belum ditampilkan
                        </div>
                    </div>

                    <a href="/maps" class="map-open">
                        Buka Peta Interaktif →
                    </a>
                </section>

                <!-- AKSES FITUR -->
                <section class="panel panel-padding">
                    <div class="section-title-row">
                        <div>
                            <h2 class="section-heading">
                                Layanan SiagaNow
                            </h2>
                            <p class="section-subtitle">
                                Akses layanan yang kamu butuhkan.
                            </p>
                        </div>
                    </div>

                    <div class="feature-list">

                        <a href="/risk-check" class="feature-link">
                            <div class="feature-row">
                                <div class="feature-icon">🏠</div>
                                <div>
                                    <div class="feature-title">
                                        Cek Risiko Rumah Anda
                                    </div>
                                    <p class="feature-description">
                                        Periksa informasi risiko banjir dan tanah longsor.
                                    </p>
                                </div>
                                <span class="feature-arrow">›</span>
                            </div>
                        </a>

                        <a href="/maps" class="feature-link">
                            <div class="feature-row">
                                <div class="feature-icon">🗺️</div>
                                <div>
                                    <div class="feature-title">
                                        Cari Zona Aman dan Shelter
                                    </div>
                                    <p class="feature-description">
                                        Akses peta dan informasi lokasi yang tersedia.
                                    </p>
                                </div>
                                <span class="feature-arrow">›</span>
                            </div>
                        </a>

                        <a href="/report" class="feature-link">
                            <div class="feature-row">
                                <div class="feature-icon">📝</div>
                                <div>
                                    <div class="feature-title">
                                        Laporkan Kejadian Bencana
                                    </div>
                                    <p class="feature-description">
                                        Buka halaman pelaporan untuk menyampaikan kejadian.
                                    </p>
                                </div>
                                <span class="feature-arrow">›</span>
                            </div>
                        </a>

                    </div>
                </section>

                <!-- BERITA -->
                <section class="panel panel-padding">
                    <div class="section-title-row">
                        <div>
                            <h2 class="section-heading">
                                Berita dan Edukasi
                            </h2>
                            <p class="section-subtitle">
                                Informasi dan pengetahuan kesiapsiagaan bencana.
                            </p>
                        </div>
                    </div>

                    <div class="news-placeholder">

                        <article class="news-item">
                            <div class="news-thumbnail">🌧️</div>
                            <div>
                                <h3 class="news-title">
                                    Kesiapsiagaan Menghadapi Banjir
                                </h3>
                                <p class="news-description">
                                    Materi edukasi akan tersedia setelah konten
                                    terverifikasi dimasukkan ke sistem.
                                </p>
                            </div>
                        </article>

                        <article class="news-item">
                            <div class="news-thumbnail">⛰️</div>
                            <div>
                                <h3 class="news-title">
                                    Mengenali Risiko Tanah Longsor
                                </h3>
                                <p class="news-description">
                                    Materi mitigasi dan informasi kebencanaan
                                    belum terhubung ke sumber berita.
                                </p>
                            </div>
                        </article>

                    </div>
                </section>

            </div>

            <!-- SIDEBAR -->
            <aside class="side-column">

                <!-- STATUS INFORMASI -->
                <section class="panel panel-padding">
                    <div class="section-title-row">
                        <div>
                            <h2 class="section-heading">
                                Status Informasi
                            </h2>
                            <p class="section-subtitle">
                                Ketersediaan sumber informasi.
                            </p>
                        </div>
                    </div>

                    <div class="feature-list">

                        <div class="feature-row">
                            <div class="feature-icon">🌦️</div>
                            <div>
                                <div class="feature-title">Data Cuaca</div>
                                <p class="feature-description">
                                    Belum terhubung ke API cuaca.
                                </p>
                            </div>
                        </div>

                        <div class="feature-row">
                            <div class="feature-icon">⚠️</div>
                            <div>
                                <div class="feature-title">Peringatan Dini</div>
                                <p class="feature-description">
                                    Menunggu sumber peringatan resmi.
                                </p>
                            </div>
                        </div>

                        <div class="feature-row">
                            <div class="feature-icon">🏠</div>
                            <div>
                                <div class="feature-title">Data Shelter</div>
                                <p class="feature-description">
                                    Data lokasi belum tersedia.
                                </p>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- SHELTER -->
                <section class="panel panel-padding">
                    <div class="section-title-row">
                        <div>
                            <h2 class="section-heading">
                                Informasi Shelter
                            </h2>
                            <p class="section-subtitle">
                                Lokasi evakuasi yang telah diverifikasi.
                            </p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-dashed border-emerald-200 bg-emerald-50 p-5 text-center">
                        <div class="text-3xl">🏠</div>
                        <h3 class="mt-3 text-sm font-extrabold text-emerald-900">
                            Data Shelter Belum Tersedia
                        </h3>
                        <p class="mt-2 text-xs leading-6 text-emerald-800">
                            Daftar shelter akan ditampilkan setelah
                            sumber data dan koordinatnya diverifikasi.
                        </p>
                    </div>

                    <a href="/maps" class="map-open">
                        Lihat Peta →
                    </a>
                </section>

                <!-- DONASI -->
                <section class="panel panel-padding">
                    <div class="section-title-row">
                        <div>
                            <h2 class="section-heading">
                                Program Donasi
                            </h2>
                            <p class="section-subtitle">
                                Informasi bantuan kebencanaan.
                            </p>
                        </div>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-5 text-center">
                        <div class="text-3xl">🤝</div>
                        <h3 class="mt-3 text-sm font-extrabold text-emerald-900">
                            Bantu Sesama
                        </h3>
                        <p class="mt-2 text-xs leading-6 text-emerald-800">
                            Lihat program bantuan setelah informasi
                            penggalangan dana tersedia.
                        </p>
                    </div>

                    <a href="/donate" class="map-open">
                        Lihat Program Donasi →
                    </a>
                </section>

            </aside>

        </div>

        <!-- CALL TO ACTION -->
        <section class="donation-banner mt-6">
            <div>
                <h2 class="donation-title">
                    Ada Kejadian Bencana di Sekitarmu?
                </h2>
                <p class="donation-description">
                    Sampaikan laporan kejadian untuk membantu proses
                    penyampaian informasi dan penanganan bencana.
                </p>
            </div>

            <a href="/report" class="donation-button">
                Buat Laporan Bencana →
            </a>
        </section>

    </main>

    <footer class="footer">
        <p class="font-bold">SiagaNow — Siaga Bencana, Selamat Bersama</p>
        <p>
            Platform informasi kesiapsiagaan banjir dan tanah longsor.
            Informasi risiko dan peringatan harus merujuk pada sumber resmi.
        </p>
    </footer>

</div>

</body>
</html>
