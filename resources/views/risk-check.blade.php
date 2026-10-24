
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Risiko Rumah | SiagaNow</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin="">

    <style>
        :root {
            --forest: #075b49;
            --dark: #064b3d;
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

        .navlink {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d6e9df;
            border-radius: 13px;
            padding: 10px 13px;
            font-weight: 750;
            color: var(--forest);
            background: white;
            text-decoration: none;
            transition: .18s;
            cursor: pointer;
            font-size: 14px;
        }

        .navlink:hover,
        .navlink.active {
            background: var(--forest);
            color: white;
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
</head>

<body class="min-h-screen"
      style="background:radial-gradient(ellipse at 12% 0%,#bde7d8 0,transparent 35%),linear-gradient(145deg,#e5f5ec,#f8fbf8 55%,#c5e8d8)">

<header class="mx-auto max-w-[1500px] px-4 pt-5 sm:px-6">
    <div class="flex flex-wrap items-center justify-between gap-4 rounded-[22px] border border-white bg-white/90 px-5 py-4 shadow-lg sm:px-6">

        <a href="{{ route('home') }}"
           class="flex items-center gap-3"
           aria-label="SiagaNow beranda">

            <span class="grid h-12 w-12 place-items-center rounded-2xl text-2xl text-white"
                  style="background:var(--forest)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m3 10 9-7 9 7"/>
                    <path d="M5 9v12h14V9"/>
                </svg>
            </span>

            <span>
                <strong class="block text-2xl font-black"
                        style="color:var(--forest)">
                    SiagaNow
                </strong>

                <span class="block text-xs font-semibold text-emerald-900/60">
                    Siaga Bencana, Selamat Bersama
                </span>
            </span>
        </a>

        <!-- Navigasi utama -->
        <nav class="flex flex-wrap items-center gap-2"
             aria-label="Navigasi utama">

            <a class="navlink"
               href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m3 10 9-7 9 7"/>
                    <path d="M5 9v12h14V9"/>
                </svg>
                Home
            </a>

            <a class="navlink"
               href="{{ route('maps') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                    <circle cx="12" cy="10" r="2.5"/>
                </svg>
                Maps
            </a>

            <a class="navlink active"
               href="{{ url('/risk-check') }}"
               aria-current="page">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 3 22 20H2L12 3Z"/>
                    <path d="M12 9v5"/>
                    <path d="M12 17h.01"/>
                </svg>
                Cek Risiko
            </a>

            <a class="navlink"
               href="/report">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 21V4"/>
                    <path d="M5 4c5-3 9 3 14 0v11c-5 3-9-3-14 0"/>
                </svg>
                Report
            </a>

            <a class="navlink"
               href="/donate">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"/>
                </svg>
                Donate
            </a>

            <a class="navlink"
               href="/other">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Other
            </a>

            @auth
                <a class="navlink"
                   href="{{ route('profil') }}">
                    Profil
                </a>

                <form action="{{ route('logout') }}"
                      method="POST">
                    @csrf

                    <button type="submit" class="navlink">
                        Keluar
                    </button>
                </form>
            @else
                <a class="navlink"
                   href="{{ route('login') }}">
                    Masuk
                </a>

                <a class="navlink"
                   href="{{ route('register') }}">
                    Daftar
                </a>
            @endauth

        </nav>
    </div>
</header>

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
            Saat ini peta dapat membantu melihat lokasi, tetapi hasil risiko
            banjir dan tanah longsor belum dapat dihitung karena data risiko
            resmi belum terhubung.
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
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-red-100 text-xl">
                        ⚠️
                    </span>

                    <div>
                        <h2 class="text-lg font-extrabold text-red-900">
                            Peringatan Risiko
                        </h2>

                        <p class="mt-1 text-sm leading-5 text-red-800">
                            Belum dapat ditentukan
                        </p>
                    </div>
                </div>

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
                            <span class="text-xl">🌧️</span>

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
                            <span class="text-xl">⛰️</span>

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
                            <span class="text-xl">🌦️</span>

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

                <div class="mt-4 rounded-xl bg-emerald-50 p-4 text-sm leading-6 text-emerald-950">
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

    function setHomeLocation(lat, lon, label) {
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
            'Lokasi ditandai. Penilaian risiko belum tersedia karena data resmi belum terhubung.';
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

    // Memastikan ukuran peta benar setelah layout selesai.
    requestAnimationFrame(function () {
        map.invalidateSize();
    });
});
</script>

</body>
</html>
