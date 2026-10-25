<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report / Pelaporan Bencana | SiagaNow</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

    <style>
        :root { --forest: #075b49; --dark: #064b3d; --line: #cfe3d8; --ink: #153f36; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: #173d34;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(ellipse at 12% 0%, rgba(189,231,216,.9) 0, transparent 35%),
                linear-gradient(145deg, #e5f5ec, #f8fbf8 55%, #c5e8d8);
        }
        .panel {
            background: rgba(255,255,255,.88);
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: 0 10px 28px rgba(7,91,73,.07);
        }
        .sn-header {
            box-sizing: border-box; width: 100%; max-width: 1440px; margin: 0 auto;
            padding: 13px 20px; display: flex; justify-content: space-between;
            align-items: center; gap: 22px; flex-wrap: wrap;
            border: 1px solid rgba(255,255,255,.72); border-radius: 19px;
            background: rgba(238,250,243,.92); box-shadow: 0 8px 28px rgba(12,83,64,.09);
            backdrop-filter: blur(12px); position: relative; z-index: 1300;
        }
        .sn-navigation { display: flex; align-items: center; justify-content: flex-end; gap: 8px; flex-wrap: wrap; min-width: 0; }
        .sn-brand-symbol { width: 60px; height: 60px; border-radius: 18px; display: grid; place-items: center; background: var(--forest); color: #fff; flex-shrink: 0; }
        .sn-nav {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            min-height: 44px; padding: 12px 15px; border: 1px solid #d1e5da; border-radius: 12px;
            background: #fff; color: var(--forest); text-decoration: none; font-family: inherit;
            font-size: 14px; font-weight: 700; white-space: nowrap; cursor: pointer;
            transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;
        }
        .sn-nav:hover { background: #e7f6ed; border-color: #b9d9c8; transform: translateY(-1px); }
        .sn-nav.active, .sn-nav[aria-expanded="true"] { background: var(--forest); border-color: var(--forest); color: #fff; }
        .sn-other-wrap { position: relative; display: inline-flex; align-items: center; }
        .sn-other-trigger { font-family: inherit; cursor: pointer; }
        .sn-other-chevron { transition: transform .18s ease; flex-shrink: 0; }
        .sn-other-panel {
            position: absolute; z-index: 1400; top: calc(100% + 12px); right: 0;
            width: min(760px, calc(100vw - 32px)); padding: 20px;
            border: 1px solid #d3e7dc; border-radius: 18px; background: rgba(255,255,255,.98);
            box-shadow: 0 22px 55px rgba(4,55,43,.20); color: var(--ink); backdrop-filter: blur(12px);
        }
        .sn-other-panel[hidden] { display: none; }
        .sn-other-panel-heading { margin: 0 0 14px; color: #07805f; font-size: 12px; font-weight: 900; letter-spacing: .14em; text-transform: uppercase; }
        .sn-other-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px 16px; }
        .sn-other-item { display: flex; align-items: flex-start; gap: 12px; min-width: 0; padding: 13px; border-left: 4px solid #16a875; border-radius: 10px; background: #f8fcf9; color: inherit; text-decoration: none; }
        a.sn-other-item:hover { background: #eaf8f0; transform: translateY(-1px); }
        .sn-other-icon { display: grid; place-items: center; flex: 0 0 34px; height: 34px; border-radius: 9px; background: #e2f5eb; color: #08745a; font-size: 19px; font-weight: 800; }
        .sn-other-title { display: block; color: var(--forest); font-size: 13px; font-weight: 850; line-height: 1.4; }
        .sn-other-desc { display: block; margin-top: 4px; color: #648078; font-size: 11px; line-height: 1.55; }
        .sn-other-tag { display: inline-block; margin-top: 6px; padding: 3px 7px; border-radius: 999px; background: #fff3d8; color: #8a5a08; font-size: 9px; font-weight: 800; }
        .sn-other-footer { margin-top: 14px; padding-top: 12px; border-top: 1px solid #e0eee6; color: #648078; font-size: 11px; line-height: 1.6; }
        .sn-other-trigger:focus-visible, .sn-other-item:focus-visible { outline: 3px solid #f0b429; outline-offset: 3px; }
        @media (max-width: 1024px) { .sn-header { align-items: flex-start; } }
        @media (max-width: 760px) {
            #report-map { height: 230px; }
            .sn-header { padding: 14px; gap: 14px; }
            .sn-navigation { width: 100%; justify-content: flex-start; gap: 7px; }
            .sn-nav { min-height: 38px; padding: 9px 10px; font-size: 11px; gap: 5px; }
            .sn-other-panel { left: 0; right: auto; width: min(760px, calc(100vw - 24px)); padding: 15px; }
            .sn-other-grid { grid-template-columns: 1fr; }
        }
        .field {
            width: 100%; border: 1px solid #cfe2d7; border-radius: 11px;
            padding: 12px 13px; background: #fff; color: #173d34; outline: none;
        }
        .field:focus { border-color: #13856c; box-shadow: 0 0 0 3px #13856c1f; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            border: 1px solid transparent; border-radius: 11px; padding: 12px 16px;
            background: var(--forest); color: #fff; font-weight: 800; cursor: pointer; transition: .18s;
        }
        .btn:hover { background: var(--dark); }
        .btn:disabled { opacity: .55; cursor: not-allowed; }
        .btn-secondary { background: #fff; color: var(--forest); border-color: #cfe2d7; }
        .btn-secondary:hover { background: #edf8f2; }
        #report-map { height: 270px; width: 100%; background: #e5eee8; z-index: 1; }
        .file-drop {
            min-height: 118px; border: 1px dashed #77b5a0; border-radius: 12px;
            background: #f0faf5; display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 18px; cursor: pointer;
        }
        .choice {
            border: 1px solid #cfe2d7; border-radius: 11px; padding: 11px 8px;
            background: white; color: var(--forest); font-size: 13px; font-weight: 800; cursor: pointer;
        }
        .choice[aria-pressed="true"] { background: var(--forest); color: white; border-color: var(--forest); }
        .section-label { display: block; margin-bottom: 7px; font-size: 14px; font-weight: 800; color: #243d36; }
        .muted { color: #617c73; }
        .preview-img { width: 68px; height: 68px; object-fit: cover; border-radius: 10px; border: 1px solid #cfe2d7; }
        @media (max-width: 760px) {
            #report-map { height: 230px; }
            .navlink { padding: 9px 10px; font-size: 13px; }
        }
    </style>
@vite(['resources/css/app.css'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>
<body class="min-h-screen">
<header class="mx-auto w-full max-w-[1440px] px-4 pt-5 sm:px-6">
    <div class="sn-header">
        <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline" aria-label="SiagaNow beranda">
            <span class="sn-brand-symbol" aria-hidden="true">
                <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m3 10 9-7 9 7"/><path d="M5 9v12h14V9"/><path d="M9 21v-7h6v7"/></svg>
            </span>
            <span>
                <span class="block text-[30px] font-black tracking-tight leading-none" style="color:var(--forest)">SiagaNow</span>
                <span class="mt-1 block text-sm font-semibold tracking-wide text-emerald-900/60">Siaga Bencana, Selamat Bersama</span>
            </span>
        </a>
        <nav class="sn-navigation" aria-label="Navigasi utama">
            <a class="sn-nav" href="{{ route('home') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m3 10 9-7 9 7M5 9v12h14V9"/></svg>Home</a>
            <a class="sn-nav" href="{{ route('maps') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>Maps</a>
            <a class="sn-nav" href="{{ url('/risk-check') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="m12 3 10 18H2L12 3Z"/><path d="M12 9v5M12 17h.01"/></svg>Cek Risiko</a>
            <a class="sn-nav active" href="{{ url('/report') }}" aria-current="page"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 22V4"/><path d="M4 4c7-4 9 4 16 0v12c-7 4-9-4-16 0"/></svg>Report</a>
            <a class="sn-nav" href="/donate"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"/></svg>Donate</a>
            <div class="sn-other-wrap" data-sn-other>
                <button class="sn-nav sn-other-trigger" type="button" aria-expanded="false" aria-controls="sn-other-panel" data-sn-other-trigger>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Other
                    <svg class="sn-other-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="sn-other-panel" id="sn-other-panel" data-sn-other-panel hidden>
                    <h2 class="sn-other-panel-heading">Informasi &amp; Kesiapsiagaan Bencana</h2>
                    <div class="sn-other-grid">
                        <a href="{{ route('informasi-banjir') }}" class="sn-other-item"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'water', 'size' => 20])</span><span><span class="sn-other-title">Informasi Bencana Banjir</span><span class="sn-other-desc">Tanda bahaya dan langkah kesiapsiagaan banjir.</span><span class="sn-other-tag">Lihat Informasi</span></span></a>
                        <a href="{{ route('informasi-longsor') }}" class="sn-other-item"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'mountain', 'size' => 20])</span><span><span class="sn-other-title">Informasi Tanah Longsor</span><span class="sn-other-desc">Tanda awal, faktor risiko, dan tindakan saat terjadi longsor.</span><span class="sn-other-tag">Lihat Informasi</span></span></a>
                        <a href="{{ route('statistik-kejadian') }}" class="sn-other-item"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'list', 'size' => 20])</span><span><span class="sn-other-title">Statistik Kejadian</span><span class="sn-other-desc">Ringkasan kejadian banjir dan tanah longsor.</span><span class="sn-other-tag">Lihat Statistik</span></span></a>
                        <a href="{{ route('panduan-kesiapsiagaan') }}" class="sn-other-item"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'shield', 'size' => 20])</span><span><span class="sn-other-title">Panduan Kesiapsiagaan</span><span class="sn-other-desc">Panduan persiapan sebelum, saat, dan setelah bencana.</span><span class="sn-other-tag">Lihat Panduan</span></span></a>
                        <a href="{{ route('berita-kebencanaan') }}" class="sn-other-item"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'info', 'size' => 20])</span><span><span class="sn-other-title">Berita Kebencanaan</span><span class="sn-other-desc">Informasi berita kebencanaan.</span><span class="sn-other-tag">Lihat Berita</span></span></a>
                    </div>
                    <p class="sn-other-footer">Pilih salah satu menu untuk membuka halaman informasi terkait kebencanaan.</p>
                </div>
            </div>
            @auth
                <a class="sn-nav" href="{{ route('profil') }}">Profil</a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">@csrf<button type="submit" class="sn-nav">Keluar</button></form>
            @else
                <a class="sn-nav" href="{{ route('login') }}">Masuk</a>
                <a class="sn-nav" href="{{ route('register') }}">Daftar</a>
            @endauth
        </nav>
    </div>
</header>

<main class="mx-auto max-w-[1600px] px-4 py-5 sm:px-6 sm:py-7">
    <section class="panel mb-5 flex flex-wrap items-center justify-between gap-4 px-6 py-6 sm:px-8">
        <div>
            <p class="text-xs font-extrabold uppercase tracking-[.18em] text-emerald-700">Laporan masyarakat</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight sm:text-4xl" style="color:#123f34">Laporkan Kejadian</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 muted sm:text-base">Bantu sampaikan informasi kejadian banjir atau tanah longsor dengan jelas. Pastikan laporan berdasarkan kondisi yang benar-benar kamu ketahui.</p>
        </div>
        <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-800">Formulir pelaporan</span>
    </section>

    <div class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.55fr)_minmax(340px,.9fr)]">
        <section class="panel overflow-hidden">
            <form id="report-form" class="p-4 sm:p-6" action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="mb-5">
                    <label class="section-label" for="title">Judul & lokasi kejadian <span class="text-red-600">*</span></label>
                    <input class="field" id="title" name="title" maxlength="140" required placeholder="Contoh: Banjir di Kecamatan Koto Tangah">
                    <p class="mt-1 text-xs muted">Tuliskan kejadian dan wilayah secara singkat.</p>
                </div>

                <div class="mb-5 overflow-hidden rounded-xl border border-emerald-100 bg-white">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-emerald-100 px-4 py-3">
                        <div><h2 class="font-extrabold text-emerald-900">Pilih Lokasi Kejadian</h2><p class="mt-1 text-xs muted">Klik peta atau gunakan lokasi perangkat.</p></div>
                        <button type="button" id="locate-me" class="btn btn-secondary !py-2 !text-sm">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2"/></svg>
                            Lokasi Saya
                        </button>
                    </div>
                    <div id="report-map" role="application" aria-label="Peta untuk memilih lokasi kejadian"></div>
                    <div class="flex flex-wrap items-center justify-between gap-2 border-t border-emerald-100 bg-emerald-50/70 px-4 py-3 text-sm">
                        <span class="font-bold text-emerald-900">Koordinat:</span>
                        <span id="coordinates" class="muted">Belum dipilih</span>
                    </div>
                    <p id="map-status" class="px-4 py-3 text-xs muted" role="status" aria-live="polite">Peta berpusat di Sumatera Barat. Pilih titik lokasi kejadian.</p>
                </div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">

                <div class="mb-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="section-label" for="event-date">Tanggal kejadian <span class="text-red-600">*</span></label>
                        <input class="field" id="event-date" name="event_date" type="date" required>
                    </div>
                    <div>
                        <label class="section-label" for="event-time">Waktu kejadian <span class="text-red-600">*</span></label>
                        <input class="field" id="event-time" name="event_time" type="time" required>
                    </div>
                </div>

                <div class="mb-5">
                    <span class="section-label">Jenis kejadian <span class="text-red-600">*</span></span>
                    <div class="grid grid-cols-2 gap-3" id="event-type-options">
                        <button type="button" class="choice" data-value="Banjir" aria-pressed="true">Banjir</button>
                        <button type="button" class="choice" data-value="Tanah longsor" aria-pressed="false">Tanah longsor</button>
                    </div>
                    <input type="hidden" id="event-type" name="event_type" value="Banjir">
                </div>

                <div class="mb-5">
                    <span class="section-label">Korban terdampak</span>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="mb-1 block text-xs font-bold text-slate-600" for="injured">Luka-luka (orang)</label><input class="field" id="injured" name="injured" type="number" min="0" step="1" value="0" inputmode="numeric"></div>
                        <div><label class="mb-1 block text-xs font-bold text-slate-600" for="deceased">Meninggal (orang)</label><input class="field" id="deceased" name="deceased" type="number" min="0" step="1" value="0" inputmode="numeric"></div>
                    </div>
                    <p class="mt-1 text-xs muted">Isi angka yang diketahui. Gunakan 0 jika tidak ada atau belum ada informasi korban.</p>
                </div>

                <div class="mb-5">
                    <span class="section-label">Tingkat kerusakan</span>
                    <div class="grid grid-cols-3 gap-2" id="damage-options">
                        <button type="button" class="choice" data-value="Rendah" aria-pressed="false">Rendah</button>
                        <button type="button" class="choice" data-value="Sedang" aria-pressed="true">Sedang</button>
                        <button type="button" class="choice" data-value="Tinggi" aria-pressed="false">Tinggi</button>
                    </div>
                    <input type="hidden" id="damage-level" name="damage_level" value="Sedang">
                </div>

                <div class="mb-5">
                    <label class="section-label" for="description">Deskripsi kejadian <span class="text-red-600">*</span></label>
                    <textarea class="field" id="description" name="description" rows="4" maxlength="3000" required placeholder="Jelaskan kondisi yang kamu lihat, dampak yang diketahui, dan informasi penting lainnya."></textarea>
                    <div class="mt-1 flex justify-between gap-2 text-xs muted"><span>Jangan masukkan informasi yang belum terverifikasi sebagai fakta.</span><span id="description-count">0/3000</span></div>
                </div>

                <div class="mb-5">
                    <label class="section-label" for="evidence">Unggah foto / video (opsional)</label>
                    <label class="file-drop" for="evidence">
                        <span class="flex flex-col items-center gap-2">
                            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#075b49" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6M12 18v-6m-3 3 3-3 3 3"/></svg>
                            <strong class="text-emerald-900">Pilih foto atau video</strong>
                            <span class="text-xs muted">Gambar: JPG, PNG, WEBP · Video: MP4, WEBM · Maks. 10 MB per file</span>
                        </span>
                    </label>
                    <input class="sr-only" id="evidence" name="evidence[]" type="file" accept="image/jpeg,image/png,image/webp,video/mp4,video/webm" multiple>
                    <div id="file-list" class="mt-3 flex flex-wrap gap-2"></div>
                    <p id="file-status" class="mt-2 text-xs muted" role="status" aria-live="polite">Lampiran akan diunggah secara privat saat formulir dikirim.</p>
                </div>

                <div id="form-message" class="mb-4 hidden rounded-xl border px-4 py-3 text-sm" role="status" aria-live="polite"></div>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-emerald-100 pt-5">
                    <button type="reset" id="cancel-report" class="btn btn-secondary min-w-28">Batal</button>
                    <button type="submit" id="submit-report" class="btn min-w-40">Kirim Laporan</button>
                </div>
                <p class="mt-3 text-xs leading-5 muted">Laporan akan tersimpan dengan status <strong>Menunggu pemeriksaan</strong>. Unggahan disimpan secara privat.</p>
            </form>
        </section>

        <aside class="space-y-5">
            <section class="panel overflow-hidden">
                <div class="flex items-center justify-between gap-3 border-b border-emerald-100 px-5 py-4">
                    <div><h2 class="text-lg font-black text-emerald-900">Lihat Status</h2><p class="mt-1 text-xs muted">Daftar laporan yang tersedia</p></div>
                    <a href="{{ route('report.status') }}" class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-800">Lihat laporan saya</a>
                </div>
                <div class="p-5">
                    <div class="grid justify-items-center gap-2 rounded-xl border border-dashed border-emerald-200 bg-emerald-50/60 px-4 py-8 text-center">
                        <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#397c68" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 6h13M8 12h13M8 18h13"/><path d="M3 6h.01M3 12h.01M3 18h.01"/></svg>
                        <h3 class="font-extrabold text-emerald-900">Status laporan tersimpan</h3>
                        <p class="max-w-xs text-sm leading-6 muted">Lihat laporan yang dikirim dari akun ini, termasuk status pemeriksaannya.</p>
                    </div>
                </div>
            </section>

            <section class="panel p-5 sm:p-6">
                <div class="mb-4 flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-50 text-emerald-800">
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 14.8 8.7 21 9.6l-4.5 4.4 1.1 6.2L12 17.3l-5.6 2.9 1.1-6.2L3 9.6l6.2-.9Z"/></svg>
                    </span>
                    <h2 class="text-lg font-black text-emerald-900">Tips Pelaporan Kejadian</h2>
                </div>
                <ol class="list-decimal space-y-3 pl-5 text-sm leading-6 text-slate-700">
                    <li><strong>Gunakan fakta yang benar.</strong> Bedakan hal yang dilihat langsung dengan informasi dari orang lain.</li>
                    <li><strong>Pastikan data tidak menyesatkan.</strong> Jangan menebak jumlah korban atau tingkat kerusakan.</li>
                    <li><strong>Perjelas lokasi.</strong> Pilih titik yang sesuai pada peta dan tuliskan wilayah pada judul.</li>
                    <li><strong>Lampirkan bukti bila aman.</strong> Jangan mendekati area berbahaya hanya untuk mengambil foto atau video.</li>
                    <li><strong>Jaga privasi.</strong> Hindari mengunggah dokumen pribadi atau menampilkan data sensitif korban.</li>
                </ol>
            </section>

            <section class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                <h2 class="font-extrabold text-amber-900">Penting untuk keselamatan</h2>
                <p class="mt-2 text-sm leading-6 text-amber-900">Jangan menunggu laporan website jika kamu atau orang lain berada dalam bahaya langsung. Menjauhlah ke tempat aman dan hubungi layanan darurat atau petugas setempat.</p>
            </section>
        </aside>
    </div>
</main>

<footer class="mt-8 bg-emerald-950 px-5 py-7 text-center text-sm text-emerald-50/80">
    SiagaNow — Kesiapsiagaan Bencana Banjir dan Tanah Longsor
</footer>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('report-form');
    const message = document.getElementById('form-message');
    const mapStatus = document.getElementById('map-status');
    const coordinateText = document.getElementById('coordinates');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    let map = null;
    let marker = null;

    function showMessage(text, kind) {
        message.textContent = text;
        message.classList.remove('hidden', 'border-red-200', 'bg-red-50', 'text-red-800', 'border-emerald-200', 'bg-emerald-50', 'text-emerald-900', 'border-amber-200', 'bg-amber-50', 'text-amber-900');
        const cls = kind === 'error'
            ? ['border-red-200', 'bg-red-50', 'text-red-800']
            : kind === 'success'
                ? ['border-emerald-200', 'bg-emerald-50', 'text-emerald-900']
                : ['border-amber-200', 'bg-amber-50', 'text-amber-900'];
        message.classList.add(...cls);
        message.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function setLocation(lat, lon, source) {
        latitudeInput.value = Number(lat).toFixed(6);
        longitudeInput.value = Number(lon).toFixed(6);
        coordinateText.textContent = Number(lat).toFixed(5) + ', ' + Number(lon).toFixed(5);
        if (map && window.L) {
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lon]).addTo(map).bindPopup('Lokasi kejadian yang dipilih').openPopup();
            map.setView([lat, lon], 14);
        }
        mapStatus.textContent = source || 'Lokasi dipilih. Pastikan titik sudah sesuai dengan kejadian.';
    }

    const mapEl = document.getElementById('report-map');
    if (mapEl && typeof L !== 'undefined') {
        map = L.map(mapEl).setView([-0.9471, 100.4172], 8);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            minZoom: 5, maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map);
        map.on('click', function (event) {
            setLocation(event.latlng.lat, event.latlng.lng, 'Titik lokasi dipilih dari peta.');
        });
        requestAnimationFrame(function () { map.invalidateSize(); });
    } else {
        mapStatus.textContent = 'Peta tidak berhasil dimuat. Periksa koneksi internet; kamu tetap dapat mengisi formulir, tetapi lokasi belum dipilih.';
    }

    document.getElementById('locate-me').addEventListener('click', function () {
        if (!navigator.geolocation) {
            mapStatus.textContent = 'Browser tidak mendukung fitur lokasi. Pilih titik langsung pada peta.';
            return;
        }
        mapStatus.textContent = 'Meminta izin lokasi perangkat…';
        navigator.geolocation.getCurrentPosition(function (position) {
            setLocation(position.coords.latitude, position.coords.longitude, 'Lokasi perangkat ditandai. Pastikan titik sesuai dengan kejadian.');
        }, function (error) {
            const errors = {
                1: 'Izin lokasi ditolak. Kamu dapat memilih titik langsung pada peta.',
                2: 'Lokasi perangkat tidak berhasil ditentukan.',
                3: 'Permintaan lokasi melewati batas waktu.'
            };
            mapStatus.textContent = errors[error.code] || 'Lokasi perangkat tidak tersedia.';
        }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 });
    });

    function bindChoices(containerId, inputId) {
        const container = document.getElementById(containerId);
        const hidden = document.getElementById(inputId);
        container.querySelectorAll('button[data-value]').forEach(function (button) {
            button.addEventListener('click', function () {
                container.querySelectorAll('button[data-value]').forEach(function (other) {
                    other.setAttribute('aria-pressed', other === button ? 'true' : 'false');
                });
                hidden.value = button.dataset.value;
            });
        });
    }
    bindChoices('event-type-options', 'event-type');
    bindChoices('damage-options', 'damage-level');

    const description = document.getElementById('description');
    const descriptionCount = document.getElementById('description-count');
    description.addEventListener('input', function () {
        descriptionCount.textContent = description.value.length + '/3000';
    });

    const evidence = document.getElementById('evidence');
    const fileList = document.getElementById('file-list');
    const fileStatus = document.getElementById('file-status');
    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'video/webm'];
    const maxFileSize = 10 * 1024 * 1024;
    evidence.addEventListener('change', function () {
        fileList.replaceChildren();
        const files = Array.from(evidence.files || []);
        const invalid = files.filter(file => !allowedTypes.includes(file.type) || file.size > maxFileSize);
        if (invalid.length) {
            fileStatus.textContent = 'Ada file yang tidak sesuai format atau melebihi 10 MB. Pilih ulang file yang valid.';
            fileStatus.classList.add('text-red-700');
            evidence.value = '';
            return;
        }
        fileStatus.classList.remove('text-red-700');
        fileStatus.textContent = files.length
            ? files.length + ' file dipilih. Lampiran akan diunggah secara privat saat formulir dikirim.'
            : 'Lampiran akan diunggah secara privat saat formulir dikirim.';
        files.forEach(function (file) {
            const item = document.createElement('div');
            item.className = 'flex max-w-full items-center gap-2 rounded-lg border border-emerald-100 bg-white p-2 text-xs';
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.className = 'preview-img';
                img.alt = 'Pratinjau ' + file.name;
                img.src = URL.createObjectURL(file);
                item.appendChild(img);
            } else {
                const videoIcon = document.createElement('span');
                videoIcon.className = 'grid h-[68px] w-[68px] place-items-center rounded-lg bg-emerald-50 text-emerald-800';
                videoIcon.textContent = 'VIDEO';
                item.appendChild(videoIcon);
            }
            const details = document.createElement('span');
            details.className = 'max-w-[180px] break-words';
            details.textContent = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
            item.appendChild(details);
            fileList.appendChild(item);
        });
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        if (!form.reportValidity()) {
            showMessage('Periksa kembali kolom wajib yang belum diisi.', 'error');
            return;
        }
        if (!latitudeInput.value || !longitudeInput.value) {
            showMessage('Pilih titik lokasi kejadian pada peta atau gunakan tombol Lokasi Saya sebelum melanjutkan.', 'error');
            return;
        }
        const injured = Number(document.getElementById('injured').value);
        const deceased = Number(document.getElementById('deceased').value);
        if (!Number.isInteger(injured) || injured < 0 || !Number.isInteger(deceased) || deceased < 0) {
            showMessage('Jumlah korban harus berupa bilangan bulat nol atau lebih.', 'error');
            return;
        }
        const submitButton = document.getElementById('submit-report');
        submitButton.disabled = true;
        submitButton.textContent = 'Mengirim…';
        showMessage('Mengirim laporan dan lampiran secara aman…', 'info');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: new FormData(form)
        }).then(async function (response) {
            const payload = await response.json().catch(function () { return {}; });
            if (!response.ok) {
                const validationMessages = payload.errors ? Object.values(payload.errors).flat() : [];
                throw new Error(validationMessages.join(' ') || payload.message || 'Laporan belum berhasil dikirim.');
            }
            showMessage((payload.message || 'Laporan berhasil disimpan.') + ' Nomor laporan: #' + payload.data.id + '.', 'success');
            window.setTimeout(function () { window.location.assign(payload.data.status_url); }, 1800);
        }).catch(function (error) {
            showMessage(error.message || 'Laporan gagal dikirim. Periksa koneksi lalu coba lagi.', 'error');
        }).finally(function () {
            submitButton.disabled = false;
            submitButton.textContent = 'Kirim Laporan';
        });
    });

    form.addEventListener('reset', function () {
        window.setTimeout(function () {
            latitudeInput.value = '';
            longitudeInput.value = '';
            coordinateText.textContent = 'Belum dipilih';
            mapStatus.textContent = 'Peta berpusat di Sumatera Barat. Pilih titik lokasi kejadian.';
            if (marker && map) { map.removeLayer(marker); marker = null; }
            if (map) map.setView([-0.9471, 100.4172], 8);
            document.getElementById('event-type').value = 'Banjir';
            document.getElementById('damage-level').value = 'Sedang';
            document.querySelectorAll('#event-type-options button, #damage-options button').forEach(function (button) {
                const selected = button.dataset.value === (button.closest('#event-type-options') ? 'Banjir' : 'Sedang');
                button.setAttribute('aria-pressed', selected ? 'true' : 'false');
            });
            fileList.replaceChildren();
            fileStatus.textContent = 'Lampiran akan diunggah secara privat saat formulir dikirim.';
            fileStatus.classList.remove('text-red-700');
            descriptionCount.textContent = '0/3000';
            message.classList.add('hidden');
        }, 0);
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-sn-other]').forEach(function (wrap) {
        const trigger = wrap.querySelector('[data-sn-other-trigger]');
        const panel = wrap.querySelector('[data-sn-other-panel]');
        const chevron = wrap.querySelector('.sn-other-chevron');
        if (!trigger || !panel || wrap.dataset.snInitialized === 'true') return;
        wrap.dataset.snInitialized = 'true';

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
            if (event.key === 'Escape') { closeMenu(); trigger.focus(); }
        });
    });
});
</script>

</body>
</html>
