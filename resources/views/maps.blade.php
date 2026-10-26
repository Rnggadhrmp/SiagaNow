<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maps | SiagaNow</title>


    <style>
        :root {
            --forest: #075b49;
            --forest-dark: #064b3d;
            --mint: #eaf7f0;
            --ink: #153f36;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .sn-shell {
            background: rgba(255,255,255,.91);
            border: 1px solid rgba(255,255,255,.8);
            box-shadow: 0 12px 35px rgba(6,75,61,.08);
            backdrop-filter: blur(8px);
        }

        .sn-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            border: 1px solid #d1e5da;
            border-radius: 12px;
            padding: 12px 15px;
            font-family: inherit;
            font-weight: 700;
            color: var(--forest);
            background: #fff;
            text-decoration: none;
            transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;
            cursor: pointer;
            font-size: 14px;
            white-space: nowrap;
        }

        .sn-nav:hover {
            background: #e7f6ed;
            border-color: #b9d9c8;
            transform: translateY(-1px);
        }

        .sn-nav.active,
        .sn-nav[aria-expanded="true"] {
            background: var(--forest);
            border-color: var(--forest);
            color: #fff;
        }

        .sn-header {
            box-sizing: border-box;
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
            padding: 13px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 22px;
            flex-wrap: wrap;
            border: 1px solid rgba(255,255,255,.72);
            border-radius: 19px;
            background: rgba(238,250,243,.92);
            box-shadow: 0 8px 28px rgba(12,83,64,.09);
            backdrop-filter: blur(12px);
            position: relative;
            z-index: 1300;
        }

        .sn-navigation {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
            min-width: 0;
        }

        .sn-brand-symbol {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: var(--forest);
            color: #fff;
            flex-shrink: 0;
        }

        .sn-other-wrap { position: relative; display: inline-flex; align-items: center; }
        .sn-other-trigger { font-family: inherit; cursor: pointer; }
        .sn-other-chevron { transition: transform .18s ease; flex-shrink: 0; }
        .sn-other-panel {
            position: absolute;
            z-index: 1400;
            top: calc(100% + 12px);
            right: 0;
            width: min(760px, calc(100vw - 32px));
            padding: 20px;
            border: 1px solid #d3e7dc;
            border-radius: 18px;
            background: rgba(255,255,255,.98);
            box-shadow: 0 22px 55px rgba(4,55,43,.20);
            color: var(--ink);
            backdrop-filter: blur(12px);
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
        .sn-other-title { display: block; color: var(--forest); font-size: 13px; font-weight: 850; line-height: 1.4; }
        .sn-other-desc { display: block; margin-top: 4px; color: #648078; font-size: 11px; line-height: 1.55; }
        .sn-other-tag { display: inline-block; margin-top: 6px; padding: 3px 7px; border-radius: 999px; background: #fff3d8; color: #8a5a08; font-size: 9px; font-weight: 800; }
        .sn-other-item.is-planned { cursor: default; opacity: .86; }
        .sn-other-footer { margin-top: 14px; padding-top: 12px; border-top: 1px solid #e0eee6; color: #648078; font-size: 11px; line-height: 1.6; }
        .sn-other-trigger:focus-visible, .sn-other-item:focus-visible { outline: 3px solid #f0b429; outline-offset: 3px; }

        .sn-card {
            background: rgba(255,255,255,.94);
            border: 1px solid #dcebe2;
            border-radius: 20px;
            box-shadow: 0 8px 26px rgba(7,91,73,.055);
        }

        .sn-btn {
            background: var(--forest);
            color: white;
            border-radius: 11px;
            padding: 11px 15px;
            font-weight: 750;
            transition: .18s;
        }

        .sn-btn:hover {
            background: var(--forest-dark);
        }

        .sn-btn-light {
            background: #e9f5ee;
            color: var(--forest);
            border: 1px solid #d3e8dc;
            border-radius: 11px;
            padding: 10px 13px;
            font-weight: 700;
        }

        .sn-input {
            width: 100%;
            border: 1px solid #cfe2d7;
            border-radius: 11px;
            padding: 12px 13px;
            outline: none;
            background: #fff;
        }

        .sn-input:focus {
            border-color: #13856c;
            box-shadow: 0 0 0 3px rgba(19,133,108,.12);
        }

        #siaganow-map {
            width: 100%;
            height: min(62vh, 620px);
            min-height: 390px;
            background: #e5eee8;
        }

        .leaflet-container {
            font: inherit;
        }

        .map-float {
            position: absolute;
            z-index: 500;
            left: 14px;
            top: 14px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .map-float button {
            border: 1px solid #dce9e1;
            border-radius: 10px;
            background: white;
            color: #075b49;
            font-weight: 750;
            padding: 9px 12px;
            box-shadow: 0 3px 10px #1232;
        }

        .zone-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 13px;
            border: 1px solid #dfebe4;
            border-radius: 12px;
            background: #fff;
        }

        @media (max-width: 1024px) {
            .sn-header { align-items: flex-start; }
        }

        @media (max-width: 640px) {
            .sn-header { padding: 14px; gap: 14px; }
            .sn-navigation { width: 100%; justify-content: flex-start; gap: 7px; }
            .sn-nav { min-height: 38px; padding: 9px 10px; font-size: 11px; gap: 5px; }
            .sn-other-panel { left: 0; right: auto; width: min(760px, calc(100vw - 24px)); padding: 15px; }
            .sn-other-grid { grid-template-columns: 1fr; }
            #siaganow-map {
                min-height: 350px;
                height: 52vh;
            }
        }
    </style>
@vite(['resources/css/app.css', 'resources/js/maps.js'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>

<body data-page="maps" class="min-h-screen text-slate-800"
      style="background:radial-gradient(ellipse at 15% 0%,#bde7d8 0,transparent 36%),linear-gradient(145deg,#e5f5ec,#f8fbf8 52%,#c5e8d8)">

@include('partials.site-navbar')

<main class="mx-auto max-w-[1500px] px-4 py-6 sm:px-6 sm:py-8">

    <!-- Informasi kebencanaan -->
    <section class="sn-shell mb-6 flex flex-wrap items-center justify-between gap-4 rounded-[22px] px-6 py-6 sm:px-8">
        <div>
            <p class="text-xs font-extrabold uppercase tracking-[.18em] text-emerald-700">
                Informasi kebencanaan
            </p>

            <h1 class="mt-2 text-3xl font-black tracking-tight sm:text-4xl"
                style="color:var(--ink)">
                Peta Zona dan Evakuasi
            </h1>

            <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600 sm:text-base">
                Jelajahi wilayah Sumatera Barat, cari lokasi, dan akses fitur pemeriksaan risiko.
                Zona dan shelter hanya akan ditampilkan setelah sumber data terverifikasi tersedia.
            </p>
        </div>

        <span class="rounded-xl border border-emerald-200 bg-white/80 px-4 py-3 text-sm font-extrabold text-emerald-800">
            @include('partials.siaga-icon', ['name' => 'pin', 'size' => 20]) Fokus: Sumatera Barat
        </span>
    </section>

    <section class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.8fr)_minmax(320px,.92fr)]">

        <!-- Peta interaktif -->
        <div class="sn-card overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-emerald-100 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="text-lg font-extrabold" style="color:var(--forest)">
                        Peta Sumatera Barat &amp; lokasi
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Peta dasar interaktif OpenStreetMap
                    </p>
                </div>

                    <span class="rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800">Peta interaktif</span>
            </div>

            <div class="relative">
                <div id="siaganow-map"
                     role="application"
                     aria-label="Peta interaktif Sumatera Barat">
                </div>

                <div id="map-tile-fallback"
                     class="pointer-events-none absolute inset-x-4 top-4 z-[500] mx-auto hidden max-w-lg border-l-4 border-amber-600 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-950 shadow-sm"
                     role="status" aria-live="polite">
                    Peta dasar belum berhasil dimuat. Periksa koneksi internet; lokasi pada peta tidak dapat dipakai untuk navigasi sampai peta tersedia.
                </div>

                <div class="map-float">
                    <button type="button" id="reset-map">
                        ⌖ Fokus Sumbar
                    </button>

                    <button type="button" id="locate-me">
                        ◎ Lokasi Saya
                    </button>
                </div>
            </div>

            <div id="map-status"
                 class="border-t border-emerald-100 bg-white px-5 py-3 text-sm leading-6 text-slate-600"
                 role="status"
                 aria-live="polite">
                @if ($usingDemoShelters)
                    Lokasi shelter contoh ditampilkan sebagai simulasi, bukan tempat evakuasi terverifikasi.
                @elseif (!$databaseAvailable)
                    Database tidak tersedia. Peta dasar tetap dapat digunakan; lokasi shelter aktual gagal dimuat.
                @else
                    Memuat lokasi shelter yang tersedia…
                @endif
            </div>

            @if ($usingDemoShelters)
                <div class="border-t border-amber-200 bg-amber-50 px-5 py-3 text-xs leading-5 text-amber-900">
                    <strong>Data Simulasi:</strong> penanda contoh di Padang hanya untuk demonstrasi. Titik ini bukan zona bahaya resmi atau shelter yang dipastikan tersedia.
                </div>
            @elseif (!$databaseAvailable)
                <div class="border-t border-amber-200 bg-amber-50 px-5 py-3 text-xs leading-5 text-amber-900">
                    Data aktual gagal dimuat dari database. Tidak ada lokasi contoh yang ditampilkan.
                </div>
            @endif

            <div class="border-t border-emerald-100 px-5 py-4 text-sm leading-6 text-slate-600">
                <strong class="text-emerald-900">Lapisan risiko:</strong> belum ditampilkan pada peta SiagaNow. Peta dasar bukan peta bahaya dan penanda contoh tidak menunjukkan kondisi aman.
                <div class="mt-2 flex flex-wrap gap-x-5 gap-y-2 text-xs">
                    <a href="https://inarisk.bnpb.go.id" target="_blank" rel="noopener noreferrer">Buka InaRISK BNPB ↗</a>
                    <a href="https://data.bnpb.go.id/dataset/data-bencana-indonesia" target="_blank" rel="noopener noreferrer">Buka dataset kejadian BNPB ↗</a>
                </div>
            </div>

        </div>

        <!-- Panel informasi -->
        <aside class="space-y-5">

            <!-- Cari shelter -->
            <section class="sn-card p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-emerald-50 text-xl">
                        @include('partials.siaga-icon', ['name' => 'search'])
                    </span>

                    <div>
                        <h2 class="text-lg font-extrabold" style="color:var(--forest)">
                            Cari Lokasi Shelter
                        </h2>

                        <p class="mt-1 text-sm leading-5 text-slate-500">
                            Cari berdasarkan nama shelter atau wilayah.
                        </p>
                    </div>
                </div>

                <form id="shelter-search" class="mt-4">
                    <label for="shelter"
                           class="mb-2 block text-sm font-bold text-slate-700">
                        Nama shelter atau wilayah
                    </label>

                    <input id="shelter"
                           name="shelter"
                           type="search"
                           class="sn-input"
                           placeholder="Contoh: nama lokasi atau kecamatan"
                           autocomplete="off">

                    <button class="sn-btn mt-3 w-full" type="submit">
                        Cari Shelter
                    </button>
                </form>

                <p id="shelter-status"
                   class="mt-3 text-xs leading-5 text-slate-500">
                    Pencarian shelter akan mengambil data dari database jika tersedia.
                </p>
            </section>

            <!-- Ketersediaan data risiko -->
            <section class="sn-card p-5 sm:p-6">
                <h2 class="text-lg font-extrabold" style="color:var(--forest)">Zona aman dan evakuasi</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Klasifikasi zona A–D dan daftar lokasi resmi belum tersedia di basis data SiagaNow. Penanda contoh pada peta tidak dapat digunakan sebagai arahan evakuasi.</p>
                <a class="mt-3 inline-flex text-sm font-bold text-emerald-900 underline underline-offset-4" href="https://inarisk.bnpb.go.id" target="_blank" rel="noopener noreferrer">Periksa informasi risiko InaRISK ↗</a>
            </section>

            <!-- Data bahaya -->
            <section class="sn-card p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded bg-emerald-50 text-xl text-emerald-900">
                        @include('partials.siaga-icon', ['name' => 'mountain'])
                    </span>

                    <div>
                        <h2 class="text-lg font-extrabold text-emerald-950">
                            Data bahaya InaRISK
                        </h2>

                        <p class="text-xs font-semibold text-slate-600">
                            Belum diintegrasikan
                        </p>
                    </div>
                </div>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Layer resmi tersedia di portal InaRISK. SiagaNow belum menafsirkan nilai raster tersebut menjadi kelas risiko rumah atau zona aman.
                </p>
                <a class="mt-3 inline-flex text-sm font-bold text-emerald-900 underline underline-offset-4" href="https://inarisk.bnpb.go.id" target="_blank" rel="noopener noreferrer">Buka InaRISK ↗</a>
            </section>

        </aside>
    </section>

    <!-- Cek risiko rumah -->
    <section class="mt-6 flex flex-col justify-between gap-5 rounded-[22px] border border-orange-200 bg-orange-50/95 p-6 sm:flex-row sm:items-center sm:p-7">
        <div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-orange-700">
                Kenali risiko sejak dini
            </p>

            <h2 class="mt-2 text-2xl font-black text-slate-900">
                Cek Risiko Rumah Anda
            </h2>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                Pilih alamat rumah untuk menandai lokasinya pada peta.
                Penilaian risiko banjir dan longsor memerlukan sumber data resmi yang belum terhubung.
            </p>
        </div>

        <a href="{{ url('/risk-check') }}"
           class="sn-btn shrink-0 text-center"
           style="background:var(--sn-forest)">
            Buka Cek Risiko Rumah →
        </a>
    </section>

</main>

<footer class="mt-8 bg-emerald-950 px-5 py-7 text-center text-sm text-emerald-50/80">
    SiagaNow — Kesiapsiagaan Bencana Banjir dan Tanah Longsor
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('siaganow-map');
    const statusEl = document.getElementById('map-status');
    const tileFallback = document.getElementById('map-tile-fallback');

    if (!mapEl || !statusEl) return;

    if (typeof L === 'undefined') {
        statusEl.textContent =
            'Leaflet gagal dimuat. Periksa koneksi internet dan coba muat ulang halaman.';
        if (tileFallback) {
            tileFallback.textContent =
                'Pustaka peta gagal dimuat dari layanan eksternal. Periksa koneksi internet; peta dan kontrol lokasi belum dapat digunakan.';
            tileFallback.classList.remove('hidden');
        }
        return;
    }

    const sumbarCenter = [-0.9471, 100.4172];

    const map = L.map(mapEl, {
        scrollWheelZoom: true
    }).setView(sumbarCenter, 8);

    let loadedTiles = 0;
    let tileErrors = 0;
    let tileFailureTimer = null;
    let mapDataStatusMessage = '';
    const tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 5,
        maxZoom: 19,
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    tileLayer.on('tileload', function () {
        loadedTiles++;
        if (tileFallback) tileFallback.classList.add('hidden');
        if (tileFailureTimer) window.clearTimeout(tileFailureTimer);
        if (statusEl.dataset.basemapError === 'true' && mapDataStatusMessage) {
            statusEl.textContent = mapDataStatusMessage;
            delete statusEl.dataset.basemapError;
        }
    });

    tileLayer.on('tileerror', function () {
        tileErrors++;
        if (loadedTiles === 0 && tileFallback) tileFallback.classList.remove('hidden');
        if (loadedTiles === 0) {
            statusEl.dataset.basemapError = 'true';
            statusEl.textContent =
                'Peta dasar OpenStreetMap gagal dimuat. Lokasi dan penanda tidak dapat dipakai untuk menentukan rute evakuasi.';
        }
    });

    tileFailureTimer = window.setTimeout(function () {
        if (loadedTiles === 0 && tileFallback) tileFallback.classList.remove('hidden');
        if (loadedTiles === 0 && tileErrors === 0) {
            statusEl.dataset.basemapError = 'true';
            statusEl.textContent =
                'Peta dasar OpenStreetMap belum merespons. Periksa koneksi internet; peta belum siap digunakan.';
        }
    }, 6000);

    let userMarker = null;
    let accuracyCircle = null;
    const shelters = @js($shelters);
    const simulatedShelters = {{ $usingDemoShelters ? 'true' : 'false' }};

    shelters.forEach((shelter) => {
        const lat = Number(shelter.latitude);
        const lng = Number(shelter.longitude);
        if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

        const marker = L.marker([lat, lng]).addTo(map);
        const popup = document.createElement('div');
        const title = document.createElement('strong');
        title.textContent = shelter.name;
        popup.appendChild(title);
        if (simulatedShelters) {
            const note = document.createElement('p');
            note.textContent = 'Data Simulasi — bukan shelter resmi';
            note.className = 'mt-1 text-xs text-amber-800';
            popup.appendChild(note);
        } else {
            const provenance = document.createElement('p');
            provenance.textContent = (shelter.source || 'Sumber belum dicatat') +
                (shelter.verified_at ? ' · diverifikasi' : ' · belum diverifikasi');
            provenance.className = 'mt-1 text-xs text-slate-600';
            popup.appendChild(provenance);
        }
        marker.bindPopup(popup);
    });

    if (!simulatedShelters && shelters.length === 0) {
        statusEl.textContent = 'Peta dasar berhasil dimuat. Data zona risiko dan shelter belum tersedia.';
    } else if (!simulatedShelters) {
        statusEl.textContent = 'Menampilkan ' + shelters.length +
            ' lokasi dari database. Periksa sumber dan status verifikasi pada tiap penanda.';
    } else {
        statusEl.textContent = 'Menampilkan lokasi contoh sebagai Data Simulasi; bukan shelter resmi atau tujuan evakuasi terverifikasi.';
    }
    mapDataStatusMessage = statusEl.textContent;

    document.getElementById('reset-map')?.addEventListener('click', function () {
        map.setView(sumbarCenter, 8);

        statusEl.textContent = simulatedShelters
            ? 'Peta difokuskan ke Sumatera Barat. Penanda yang terlihat adalah Data Simulasi, bukan shelter resmi.'
            : 'Peta difokuskan ke Sumatera Barat. Zona risiko resmi belum tersedia.';
    });

    document.getElementById('locate-me')?.addEventListener('click', function () {
        if (!navigator.geolocation) {
            statusEl.textContent =
                'Browser ini tidak mendukung fitur lokasi perangkat.';
            return;
        }

        statusEl.textContent =
            'Meminta izin lokasi perangkat. Pilih Izinkan pada browser untuk melanjutkan.';

        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latlng = [
                    position.coords.latitude,
                    position.coords.longitude
                ];

                if (userMarker) map.removeLayer(userMarker);
                if (accuracyCircle) map.removeLayer(accuracyCircle);

                userMarker = L.marker(latlng)
                    .addTo(map)
                    .bindPopup('Perkiraan lokasi perangkat Anda')
                    .openPopup();

                accuracyCircle = L.circle(latlng, {
                    radius: position.coords.accuracy,
                    color: '#2563eb',
                    fillColor: '#60a5fa',
                    fillOpacity: .12,
                    weight: 1
                }).addTo(map);

                map.setView(latlng, 14);

                statusEl.textContent =
                    'Lokasi perangkat ditampilkan. Lingkaran menunjukkan perkiraan akurasi, bukan batas zona risiko.';
            },
            function (error) {
                const messages = {
                    1: 'Izin lokasi ditolak. Anda tetap dapat menjelajahi peta secara manual.',
                    2: 'Lokasi perangkat tidak berhasil ditentukan.',
                    3: 'Permintaan lokasi melewati batas waktu. Coba lagi.'
                };

                statusEl.textContent =
                    messages[error.code] || 'Lokasi tidak tersedia.';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 60000
            }
        );
    });

    document.getElementById('shelter-search')?.addEventListener('submit', async function (event) {
    event.preventDefault();

    const query = document.getElementById('shelter').value.trim();
    const shelterStatus = document.getElementById('shelter-status');

    if (!query) {
        shelterStatus.textContent = 'Masukkan nama shelter atau wilayah terlebih dahulu.';
        return;
    }

    shelterStatus.textContent = 'Sedang mencari shelter...';

    try {
        const params = new URLSearchParams({ q: query });
        const response = await fetch(`/api/shelters?${params.toString()}`, {
            headers: { Accept: 'application/json' }
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Pencarian gagal.');
        }

        shelterStatus.replaceChildren();

        const message = document.createElement('p');
        message.textContent = result.message;
        shelterStatus.appendChild(message);

        result.data.forEach((shelter) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'mt-2 block w-full rounded-lg border border-emerald-100 p-3 text-left';
            button.textContent = shelter.name + (shelter.address ? ' — ' + shelter.address : '') +
                (result.data_type === 'simulation' ? ' · Data Simulasi' : '');

            button.addEventListener('click', () => {
                const lat = Number(shelter.latitude);
                const lng = Number(shelter.longitude);

                if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

                map.setView([lat, lng], 15);

                const popupContent = document.createElement('div');
                const name = document.createElement('strong');
                name.textContent = shelter.name;
                popupContent.appendChild(name);
                if (result.data_type === 'simulation') {
                    const note = document.createElement('p');
                    note.textContent = 'Data Simulasi — bukan shelter resmi';
                    note.className = 'mt-1 text-xs text-amber-800';
                    popupContent.appendChild(note);
                } else {
                    const provenance = document.createElement('p');
                    provenance.textContent = (shelter.source || 'Sumber belum dicatat') +
                        (shelter.verified_at ? ' · diverifikasi' : ' · belum diverifikasi');
                    provenance.className = 'mt-1 text-xs text-slate-600';
                    popupContent.appendChild(provenance);
                }

                L.popup().setLatLng([lat, lng]).setContent(popupContent).openOn(map);
            });

            shelterStatus.appendChild(button);
        });
    } catch (error) {
        shelterStatus.textContent = 'Pencarian gagal. Periksa koneksi server lalu coba lagi.';
    }
});

    requestAnimationFrame(function () {
        map.invalidateSize();
    });
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
            if (event.key === 'Escape') {
                closeMenu();
                trigger.focus();
            }
        });
    });
});
</script>

</body>
</html>
