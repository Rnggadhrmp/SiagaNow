<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cek Risiko Rumah | SiagaNow</title>


    <link rel="stylesheet"

          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"

          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="

          crossorigin="">

    <style>

        :root {

            --forest: #075b49;

            --dark: #064b3d;

            --ink: #153f36;

        }

        body {

            font-family: Inter, ui-sans-serif, system-ui, -apple-system,

                BlinkMacSystemFont, "Segoe UI", sans-serif;

        }

        .shell {

            background: rgba(255,255,255,.93);

            border: 1px solid #dcebe2;

            border-radius: 21px;

            box-shadow: 0 10px 28px rgba(7,91,73,.06);

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

            color: var(--ink, #153f36);

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

        @media (max-width: 1024px) {

            .sn-header { align-items: flex-start; }

        }

        @media (max-width: 640px) {

            .sn-header { padding: 14px; gap: 14px; }

            .sn-navigation { width: 100%; justify-content: flex-start; gap: 7px; }

            .sn-nav { min-height: 38px; padding: 9px 10px; font-size: 11px; gap: 5px; }

            .sn-other-panel { left: 0; right: auto; width: min(760px, calc(100vw - 24px)); padding: 15px; }

            .sn-other-grid { grid-template-columns: 1fr; }

        }

        .btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            background: var(--forest);

            color: white;

            border-radius: 11px;

            padding: 11px 14px;

            font-weight: 800;

            transition: .18s;

            cursor: pointer;

        }

        .btn:hover {

            background: var(--dark);

        }

        .btn:disabled {

            cursor: not-allowed;

            opacity: .6;

        }

        .field {

            width: 100%;

            border: 1px solid #cfe2d7;

            border-radius: 11px;

            padding: 12px;

            outline: none;

            background: white;

        }

        .field:focus {

            border-color: #13856c;

            box-shadow: 0 0 0 3px #13856c1f;

        }

        #risk-map {

            width: 100%;

            min-height: 390px;

            height: min(63vh, 620px);

            background: #e5eee8;

        }

        .leaflet-container {

            font: inherit;

        }

        .risk-item {

            border: 1px solid #dcebe2;

            border-radius: 14px;

            padding: 15px;

            background: white;

        }

        @media (max-width: 640px) {

            #risk-map {

                height: 52vh;

                min-height: 340px;

            }

        }

    </style>

@vite(['resources/css/app.css'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>

<body data-page="risk-check" class="min-h-screen"

      style="background:radial-gradient(ellipse at 12% 0%,#bde7d8 0,transparent 35%),linear-gradient(145deg,#e5f5ec,#f8fbf8 55%,#c5e8d8)">

@include('partials.site-navbar')

<main class="mx-auto max-w-[1500px] px-4 py-6 sm:px-6 sm:py-8">

    <!-- Judul halaman -->

    <section class="mb-5 rounded-[22px] border border-white bg-white/90 px-6 py-6 shadow-lg sm:px-8">

        <p class="text-xs font-extrabold uppercase tracking-[.18em] text-emerald-700">

            Pemeriksaan lokasi

        </p>

        <h1 class="mt-2 text-3xl font-black tracking-tight text-emerald-950 sm:text-4xl">

            Cek Risiko Rumah Anda

        </h1>

        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600 sm:text-base">

            Cari alamat rumah dan tandai lokasinya pada peta.

        </p>

    </section>

    <section class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.45fr)_minmax(340px,.85fr)]">

        <!-- Peta dan lokasi rumah -->

        <div class="shell overflow-hidden">

            <div class="border-b border-emerald-100 px-5 py-4">

                <h2 class="text-lg font-extrabold text-emerald-900">

                    Lokasi Rumah Anda

                </h2>

                <p class="mt-1 text-sm text-slate-500">

                    Fokus awal peta: Sumatera Barat

                </p>

            </div>

            <div class="relative">

                <div id="risk-map"

                     role="application"

                     aria-label="Peta untuk memilih lokasi rumah">

                </div>

            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-emerald-100 px-5 py-4">

                <div class="text-sm text-slate-600">

                    <span class="font-bold text-emerald-900">

                        Koordinat terpilih:

                    </span>

                    <span id="selected-coordinates">

                        Belum dipilih

                    </span>

                </div>

                <button id="locate-home"

                        class="btn"

                        type="button">

                    ◎ Gunakan Lokasi Saya

                </button>

            </div>

            <p id="map-message"

               class="border-t border-emerald-100 bg-white px-5 py-3 text-sm leading-6 text-slate-600"

               role="status"

               aria-live="polite">

                Klik pada peta untuk menandai lokasi rumah.

            </p>

        </div>

        <!-- Panel samping -->

        <aside class="space-y-5">

            <!-- Pencarian alamat -->

            <section class="shell p-5 sm:p-6">

                <h2 class="text-lg font-extrabold text-emerald-900">

                    Cari Alamat Rumah

                </h2>

                <p class="mt-1 text-sm leading-5 text-slate-500">

                    Masukkan alamat, kelurahan, atau kota untuk mencari titik pada peta.

                </p>

                <form id="address-form" class="mt-4">

                    <label for="address"

                           class="mb-2 block text-sm font-bold">

                        Alamat atau wilayah

                    </label>

                    <input id="address"

                           name="address"

                           class="field"

                           type="search"

                           placeholder="Contoh: Padang, Sumatera Barat"

                           autocomplete="street-address"

                           required>

                    <button id="address-submit"

                            class="btn mt-3 w-full"

                            type="submit">

                        Cari Lokasi

                    </button>

                </form>

                <p id="address-status"

                   class="mt-3 text-xs leading-5 text-slate-500"

                   role="status"

                   aria-live="polite">

                    Pencarian alamat menggunakan layanan geocoding OpenStreetMap

                    dan memerlukan koneksi internet.

                </p>

            </section>

            <!-- Peringatan risiko -->

            <section class="rounded-[21px] border border-red-200 bg-red-50 p-5 sm:p-6">

                <div class="flex items-start gap-3">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-red-100 text-xl">@include('partials.siaga-icon', ['name' => 'warning'])</span>
                    <div>
                        <h2 class="text-lg font-extrabold text-red-900">Peringatan Cuaca BMKG</h2>
                        <p id="warning-heading-status" class="mt-1 text-sm leading-5 text-red-800">
                            Pilih lokasi untuk memeriksa peringatan BMKG.
                        </p>

                    </div>

                </div>

                <div id="weather-warning-results" class="mt-3 space-y-3" aria-live="polite">
                    <p class="text-sm leading-6 text-red-800">
                        Peringatan BMKG akan diperiksa setelah lokasi dipilih. Hasil kosong bukan jaminan lokasi aman.
                    </p>
                </div>
                <p class="mt-3 text-xs leading-5 text-red-800">
                    Sumber: <a href="https://www.bmkg.go.id/alerts/nowcast/id" target="_blank" rel="noopener noreferrer" class="font-bold underline">BMKG</a>.
                    Peringatan cuaca bukan pengganti informasi resmi darurat. Risiko banjir dan longsor belum dinilai oleh panel ini.


                <p class="mt-3 text-sm leading-6 text-red-800">

                    SiagaNow belum terhubung dengan data peringatan cuaca atau

                    peta bahaya terverifikasi. Panel ini tidak menyatakan lokasi

                    rumah aman maupun berbahaya.


                </p>

            </section>

            <!-- Hasil pemeriksaan -->

            <section class="shell p-5 sm:p-6">

                <h2 class="text-lg font-extrabold text-emerald-900">

                    Hasil Pemeriksaan

                </h2>

                <p class="mt-1 text-sm text-slate-500">

                    Pemeriksaan berdasarkan lokasi terpilih

                </p>

                <div class="mt-4 space-y-3">

                    <div class="risk-item">

                        <div class="flex items-center gap-3">

                            <span class="text-xl">@include('partials.siaga-icon', ['name' => 'rain'])</span>

                            <div>

                                <h3 class="font-extrabold text-slate-800">

                                    Risiko Banjir

                                </h3>

                                <p class="mt-1 text-sm text-slate-500">

                                    Data belum tersedia

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="risk-item">

                        <div class="flex items-center gap-3">

                            <span class="text-xl">@include('partials.siaga-icon', ['name' => 'mountain'])</span>

                            <div>

                                <h3 class="font-extrabold text-slate-800">

                                    Risiko Tanah Longsor

                                </h3>

                                <p class="mt-1 text-sm text-slate-500">

                                    Data belum tersedia

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="risk-item">

                        <div class="flex items-center gap-3">

                            <span class="text-xl">@include('partials.siaga-icon', ['name' => 'cloud'])</span>

                            <div>

                                <h3 class="font-extrabold text-slate-800">

                                    Curah Hujan

                                </h3>

                                <p class="mt-1 text-sm text-slate-500">

                                    Belum terhubung ke sumber cuaca

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="mt-4 rounded-xl border border-emerald-100 bg-white p-4">
                    <h3 class="font-extrabold text-emerald-900">Simpan Pemeriksaan</h3>
                    <p class="mt-1 text-sm leading-5 text-slate-600">
                        Pilih lokasi rumah pada peta terlebih dahulu. Pemeriksaan akan disimpan ke akun Anda;
                        skor risiko belum tersedia karena data pendukung terverifikasi belum terhubung.
                    </p>
                    <button id="save-assessment" type="button" class="btn mt-3 w-full">
                        Simpan Pemeriksaan
                    </button>
                    <p id="assessment-status" class="mt-3 text-sm leading-5 text-slate-600"
                       role="status" aria-live="polite"></p>
                </div>

                <div class="mt-4 rounded-xl bg-emerald-50 p-4 text-sm leading-6 text-emerald-950">
                    <strong>Catatan:</strong>
                    hasil risiko dan rekomendasi evakuasi belum dapat diberikan sampai data resmi
                    kebencanaan, elevasi, dan cuaca tersedia.

                    <strong>Langkah selanjutnya:</strong>

                    hubungkan data resmi kebencanaan, elevasi, dan cuaca

                    sebelum menghasilkan skor risiko atau rekomendasi evakuasi.

                </div>

                <a href="{{ route('maps') }}"

                   class="mt-4 inline-flex font-extrabold text-emerald-800 hover:underline">

                    ← Kembali ke Peta Kebencanaan

                </a>

            </section>

        </aside>

    </section>

</main>

<footer class="mt-8 bg-emerald-950 px-5 py-7 text-center text-sm text-emerald-50/80">

    SiagaNow — Kesiapsiagaan Bencana Banjir dan Tanah Longsor

</footer>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"

        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="

        crossorigin=""></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const mapEl = document.getElementById('risk-map');

    const message = document.getElementById('map-message');

    const coords = document.getElementById('selected-coordinates');

    const addressStatus = document.getElementById('address-status');

    if (!mapEl || !message || !coords || !addressStatus) {

        return;

    }

    if (typeof L === 'undefined') {

        message.textContent =

            'Leaflet gagal dimuat. Periksa koneksi internet dan muat ulang halaman.';

        return;

    }

    const center = [-0.9471, 100.4172];

    const map = L.map(mapEl).setView(center, 8);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {

        minZoom: 5,

        maxZoom: 19,

        attribution:

            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>'

    }).addTo(map);

    let homeMarker = null;
    let selectedHomeLat = null;
    let selectedHomeLon = null;
    let warningRequestNumber = 0;

    const warningHeadingStatus = document.getElementById('warning-heading-status');
    const warningResults = document.getElementById('weather-warning-results');

    function clearWarningResults() {
        if (warningResults) warningResults.replaceChildren();
    }

    function addWarningText(parent, tagName, text, className) {
        const element = document.createElement(tagName);
        element.textContent = text;
        if (className) element.className = className;
        parent.appendChild(element);
        return element;
    }

    function renderWeatherWarnings(data) {
        if (!warningHeadingStatus || !warningResults) return;
        clearWarningResults();

        const status = data && data.status ? data.status : 'unknown';
        const warnings = Array.isArray(data && data.warnings) ? data.warnings : [];
        const heading = {
            warning_found: 'Peringatan BMKG ditemukan untuk titik ini.',
            no_warning_found: 'Tidak ditemukan poligon peringatan BMKG yang mencakup titik ini.',
            unknown: 'Status peringatan belum dapat diverifikasi.'
        };
        warningHeadingStatus.textContent = heading[status] || heading.unknown;

        if (status === 'warning_found' && warnings.length > 0) {
            warningHeadingStatus.className = 'mt-1 text-sm leading-5 font-bold text-red-900';
            warnings.forEach(function (warning) {
                const card = document.createElement('article');
                card.className = 'rounded-xl border border-red-200 bg-white p-3';
                addWarningText(card, 'h3', warning.title || 'Peringatan cuaca BMKG', 'font-extrabold text-red-900');
                if (warning.area) addWarningText(card, 'p', 'Wilayah: ' + warning.area, 'mt-1 text-sm text-slate-700');
                if (warning.description) addWarningText(card, 'p', warning.description, 'mt-2 whitespace-pre-line text-sm leading-6 text-slate-700');
                if (warning.effective_at) addWarningText(card, 'p', 'Mulai: ' + warning.effective_at, 'mt-2 text-xs text-slate-600');
                if (warning.expires_at) addWarningText(card, 'p', 'Berakhir: ' + warning.expires_at, 'text-xs text-slate-600');
                if (warning.detail_url && /^https:\/\//i.test(warning.detail_url)) {
                    const link = document.createElement('a');
                    link.href = warning.detail_url;
                    link.target = '_blank';
                    link.rel = 'noopener noreferrer';
                    link.textContent = 'Lihat detail BMKG';
                    link.className = 'mt-2 inline-block text-sm font-bold text-emerald-800 underline';
                    card.appendChild(link);
                }
                warningResults.appendChild(card);
            });
            addWarningText(warningResults, 'p', 'Ikuti arahan BMKG dan otoritas setempat. Hasil ini hanya pemeriksaan peringatan cuaca, bukan penilaian lengkap risiko bencana.', 'text-xs leading-5 text-red-900');
            return;
        }

        warningHeadingStatus.className = 'mt-1 text-sm leading-5 ' + (status === 'no_warning_found' ? 'text-amber-900' : 'text-red-800');
        const messageText = data && data.message ? data.message : 'Peringatan belum dapat diperiksa. Coba lagi nanti.';
        addWarningText(warningResults, 'p', messageText, 'text-sm leading-6 text-red-800');
        if (status === 'no_warning_found') {
            addWarningText(warningResults, 'p', 'Tidak ditemukannya peringatan pada titik ini bukan jaminan lokasi aman dan tidak menggantikan peringatan darurat.', 'text-xs leading-5 text-amber-900');
        }
    }

    async function checkWeatherWarnings(lat, lon) {
        const requestNumber = ++warningRequestNumber;
        if (warningHeadingStatus) warningHeadingStatus.textContent = 'Memeriksa feed peringatan BMKG…';
        if (warningResults) {
            clearWarningResults();
            addWarningText(warningResults, 'p', 'Mengambil peringatan BMKG untuk koordinat terpilih…', 'text-sm leading-6 text-red-800');
        }

        try {
            const query = new URLSearchParams({ lat: String(lat), lng: String(lon) });
            const response = await fetch('/api/weather-warning?' + query.toString(), {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();
            if (requestNumber !== warningRequestNumber) return;
            if (!response.ok && (!data || !data.status)) throw new Error('Layanan peringatan tidak tersedia.');
            renderWeatherWarnings(data);
        } catch (error) {
            if (requestNumber !== warningRequestNumber) return;
            renderWeatherWarnings({
                status: 'unknown',
                message: 'Peringatan BMKG tidak dapat diperiksa saat ini. Coba lagi nanti; lokasi belum dapat dinyatakan aman.',
                warnings: []
            });
        }
    }

    function setHomeLocation(lat, lon, label) {
        selectedHomeLat = lat;
        selectedHomeLon = lon;

        const point = [lat, lon];

        if (homeMarker) {

            map.removeLayer(homeMarker);

        }

        homeMarker = L.marker(point)

            .addTo(map)

            .bindPopup('Lokasi rumah yang dipilih')

            .openPopup();

        map.setView(point, 15);

        coords.textContent =

            lat.toFixed(5) + ', ' + lon.toFixed(5);

        message.textContent = label ||
            'Lokasi ditandai. Peringatan cuaca BMKG akan diperiksa; penilaian bahaya banjir dan longsor belum tersedia.';

        checkWeatherWarnings(lat, lon);
    }

    // Memilih lokasi rumah dengan mengeklik peta.

    map.on('click', function (event) {

        setHomeLocation(

            event.latlng.lat,

            event.latlng.lng,

            'Lokasi dipilih dari peta. Ini hanya penandaan lokasi, bukan hasil penilaian risiko.'

        );

    });

    // Menggunakan lokasi perangkat setelah pengguna memberi izin.

    document.getElementById('locate-home').addEventListener('click', function () {

        if (!navigator.geolocation) {

            message.textContent =

                'Browser tidak mendukung fitur lokasi perangkat.';

            return;

        }

        message.textContent =

            'Meminta izin lokasi perangkat…';

        navigator.geolocation.getCurrentPosition(

            function (position) {

                setHomeLocation(

                    position.coords.latitude,

                    position.coords.longitude,

                    'Lokasi perangkat ditandai. Hasil risiko belum dapat dihitung.'

                );

            },

            function (error) {

                const messages = {

                    1: 'Izin lokasi ditolak. Anda dapat memilih lokasi dengan mengeklik peta.',

                    2: 'Lokasi perangkat tidak berhasil ditentukan.',

                    3: 'Permintaan lokasi melewati batas waktu.'

                };

                message.textContent =

                    messages[error.code] ||

                    'Lokasi perangkat tidak tersedia.';

            },

            {

                enableHighAccuracy: true,

                timeout: 10000,

                maximumAge: 60000

            }

        );

    });

    // Pencarian alamat menggunakan Nominatim / OpenStreetMap.

    document.getElementById('address-form').addEventListener('submit', async function (event) {

        event.preventDefault();

        const query = document.getElementById('address').value.trim();

        if (!query) {

            return;

        }

        addressStatus.textContent = 'Mencari alamat…';

        const submit = document.getElementById('address-submit');

        submit.disabled = true;

        try {

            const url =

                'https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&q=' +

                encodeURIComponent(query + ', Sumatera Barat, Indonesia');

            const response = await fetch(url, {

                headers: {

                    'Accept': 'application/json'

                }

            });

            if (!response.ok) {

                throw new Error('Layanan pencarian tidak tersedia');

            }

            const results = await response.json();

            if (!results.length) {

                addressStatus.textContent =

                    'Alamat tidak ditemukan. Coba gunakan nama wilayah yang lebih spesifik atau tandai langsung pada peta.';

                return;

            }

            const result = results[0];

            const lat = Number(result.lat);

            const lon = Number(result.lon);

            if (!Number.isFinite(lat) || !Number.isFinite(lon)) {

                throw new Error('Koordinat alamat tidak valid');

            }

            setHomeLocation(

                lat,

                lon,

                'Lokasi ditemukan: ' + result.display_name +

                '. Ini bukan penilaian risiko.'

            );

            addressStatus.textContent =

                'Lokasi ditemukan dari OpenStreetMap: ' +

                result.display_name;

        } catch (error) {

            addressStatus.textContent =

                'Pencarian alamat gagal. Periksa koneksi internet atau tandai lokasi langsung pada peta.';

        } finally {

            submit.disabled = false;

        }

    });

    // Simpan lokasi dan status pemeriksaan ke backend.
    document.getElementById('save-assessment').addEventListener('click', async function () {
        const status = document.getElementById('assessment-status');
        const button = document.getElementById('save-assessment');

        if (selectedHomeLat === null || selectedHomeLon === null) {
            status.textContent = 'Pilih lokasi rumah pada peta atau cari alamat terlebih dahulu.';
            return;
        }

        button.disabled = true;
        status.textContent = 'Menyimpan pemeriksaan…';

        try {
            const response = await fetch('/risk-check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    latitude: selectedHomeLat,
                    longitude: selectedHomeLon
                })
            });

            const contentType = response.headers.get('content-type') || '';
            const result = contentType.includes('application/json')
                ? await response.json()
                : {};

            if (response.status === 401 || response.redirected) {
                status.textContent = 'Silakan masuk ke akun SiagaNow terlebih dahulu untuk menyimpan pemeriksaan.';
                return;
            }

            if (!response.ok) {
                if (response.status === 419) {
                    status.textContent = 'Sesi halaman kedaluwarsa. Muat ulang halaman lalu coba lagi.';
                    return;
                }
                if (response.status === 422 && result.errors) {
                    status.textContent = Object.values(result.errors).flat().join(' ');
                    return;
                }
                throw new Error(result.message || 'Pemeriksaan gagal disimpan.');
            }

            status.textContent = (result.message || 'Pemeriksaan berhasil disimpan.') +
                ' Status: ' + (result.data?.status || 'pending') +
                '. Skor risiko belum dihitung.';
        } catch (error) {
            status.textContent = 'Gagal menyimpan pemeriksaan. Periksa koneksi dan pastikan Anda sudah masuk.';
        } finally {
            button.disabled = false;
        }
    });

    // Memastikan ukuran peta benar setelah layout selesai.

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
