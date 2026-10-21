
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Maps | SiagaNow</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet CSS -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    >

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #siaganow-map {
            width: 100%;
            height: 480px;
            min-height: 360px;
            background: #e2e8f0;
            z-index: 1;
        }

        .leaflet-container {
            font-family: Arial, sans-serif;
        }

        .map-action {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            padding: 9px 12px;
            color: #0f172a;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgb(15 23 42 / 12%);
            cursor: pointer;
        }

        .map-action:hover {
            background: #f8fafc;
        }

        @media (max-width: 640px) {
            #siaganow-map {
                height: 380px;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

<header class="border-b bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4">
        <a href="/" class="text-2xl font-extrabold text-sky-800">
            Siaga<span class="text-orange-500">Now</span>
        </a>

        <nav class="flex flex-wrap gap-3 text-sm font-medium sm:gap-4">
            <a href="/" class="hover:text-sky-700">Home</a>
            <a href="/maps" class="font-bold text-sky-700">Maps</a>
            <a href="/report" class="hover:text-sky-700">Report</a>
            <a href="/donate" class="hover:text-sky-700">Donate</a>
            <a href="/other" class="hover:text-sky-700">Other</a>
        </nav>
    </div>
</header>

<main class="mx-auto max-w-7xl px-5 py-10">

    <!-- Judul halaman -->
    <section class="mb-8">
        <p class="text-sm font-bold uppercase tracking-wider text-sky-700">
            Informasi Kebencanaan
        </p>

        <h1 class="mt-2 text-3xl font-extrabold md:text-4xl">
            Peta Zona dan Evakuasi
        </h1>

        <p class="mt-3 max-w-3xl leading-7 text-slate-600">
            Jelajahi peta Sumatera Barat untuk mendukung pencarian informasi
            wilayah, lokasi shelter, serta informasi kebencanaan yang telah
            tersedia dan terverifikasi.
        </p>
    </section>

    <section class="grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(280px,1fr)]">

        <!-- PETA INTERAKTIF -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b p-5">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="font-bold">Peta Kebencanaan Sumatera Barat</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Peta dasar menggunakan OpenStreetMap.
                        </p>
                    </div>

                    <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-800">
                        Peta Interaktif
                    </span>
                </div>
            </div>

            <div class="relative">
                <div
                    id="siaganow-map"
                    role="application"
                    aria-label="Peta interaktif Sumatera Barat"
                ></div>

                <!-- Tombol peta -->
                <div class="absolute left-3 top-3 z-[500] flex flex-col gap-2">
                    <button
                        id="reset-map"
                        type="button"
                        class="map-action"
                    >
                        Fokus Sumbar
                    </button>

                    <button
                        id="locate-me"
                        type="button"
                        class="map-action"
                    >
                        Lokasi Saya
                    </button>
                </div>
            </div>

            <!-- Status peta -->
            <div
                id="map-status"
                class="border-t bg-white px-4 py-3 text-sm leading-6 text-slate-600"
                role="status"
                aria-live="polite"
            >
                Memuat peta Sumatera Barat...
            </div>

            <!-- Legenda: tidak berarti data zonanya sudah tersedia -->
            <div class="flex flex-wrap gap-x-5 gap-y-3 border-t p-4 text-sm">

                <span class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-green-600"></span>
                    Zona aman
                </span>

                <span class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-red-600"></span>
                    Zona bahaya
                </span>

                <span class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-orange-500"></span>
                    Lokasi terdampak
                </span>

                <span class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-blue-600"></span>
                    Lokasi perangkat
                </span>
            </div>

            <div class="border-t bg-amber-50 px-4 py-3 text-xs leading-5 text-amber-900">
                <strong>Catatan:</strong> lapisan zona aman, zona bahaya,
                lokasi terdampak, jalur evakuasi, dan shelter belum ditampilkan
                karena sumber data geografisnya belum diintegrasikan.
                Peta dasar bukan penilaian risiko bencana.
            </div>
        </div>

        <!-- PANEL INFORMASI -->
        <aside class="space-y-5">

            <!-- Pencarian shelter -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="font-bold">Cari Shelter</h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Cari lokasi shelter berdasarkan nama atau wilayah.
                </p>

                <form action="/maps" method="GET" class="mt-4">
                    <label for="shelter" class="mb-2 block text-sm font-medium">
                        Nama shelter atau wilayah
                    </label>

                    <input
                        id="shelter"
                        name="shelter"
                        type="search"
                        value="{{ request('shelter') }}"
                        placeholder="Masukkan kata kunci..."
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-sky-600 focus:ring-2 focus:ring-sky-100"
                    >

                    <button
                        type="submit"
                        class="mt-3 w-full rounded-lg bg-sky-800 px-4 py-3 font-semibold text-white hover:bg-sky-900"
                    >
                        Cari Shelter
                    </button>
                </form>

                <p class="mt-3 text-xs leading-5 text-slate-500">
                    Pencarian belum terhubung ke database shelter.
                    Hasil pencarian belum tersedia.
                </p>
            </div>

            <!-- Zona aman A-D -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="font-bold">Daftar Zona Aman A–D</h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Detail zona dan kecamatan akan ditampilkan setelah data
                    wilayah diverifikasi.
                </p>

                <div class="mt-4 space-y-3">
                    @foreach (['A', 'B', 'C', 'D'] as $zona)
                        <div class="flex items-center justify-between gap-3 rounded-lg border border-slate-200 p-3">
                            <span class="font-semibold">Zona {{ $zona }}</span>
                            <span class="text-right text-xs text-slate-500">
                                Data belum tersedia
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Zona merah -->
            <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
                <div class="flex items-center gap-2">
                    <span class="text-xl" aria-hidden="true">⚠️</span>
                    <h2 class="font-bold text-red-800">Daftar Zona Merah</h2>
                </div>

                <p class="mt-3 text-sm leading-6 text-red-700">
                    Informasi wilayah berisiko tinggi akan ditampilkan
                    setelah data kebencanaan yang relevan tersedia dan
                    diverifikasi.
                </p>

                <p class="mt-3 text-xs text-red-700">
                    Belum ada data zona merah yang terhubung.
                </p>
            </div>

        </aside>
    </section>

    <!-- AKSES CEK RISIKO RUMAH -->
    <section class="mt-8 rounded-2xl border border-orange-200 bg-orange-50 p-6 md:flex md:items-center md:justify-between md:gap-6">

        <div>
            <p class="text-sm font-bold text-orange-700">
                Kenali risiko sejak dini
            </p>

            <h2 class="mt-2 text-xl font-extrabold md:text-2xl">
                Cek Risiko Rumah Anda
            </h2>

            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                Periksa informasi risiko banjir dan tanah longsor berdasarkan
                lokasi dan parameter yang tersedia. Hasil pemeriksaan belum
                tersedia sebelum sumber data risiko diintegrasikan.
            </p>
        </div>

        <a
            href="/risk-check"
            class="mt-4 inline-block shrink-0 rounded-lg bg-orange-500 px-5 py-3 text-center font-bold text-white hover:bg-orange-600 md:mt-0"
        >
            Cek Risiko Rumah
        </a>
    </section>

</main>

<footer class="mt-10 bg-slate-900 px-5 py-7 text-center text-sm text-slate-300">
    SiagaNow — Kesiapsiagaan Bencana Banjir dan Tanah Longsor
</footer>

<!-- Leaflet JavaScript -->
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('siaganow-map');
    const statusElement = document.getElementById('map-status');
    const resetButton = document.getElementById('reset-map');
    const locateButton = document.getElementById('locate-me');

    if (!mapElement || !statusElement) {
        return;
    }

    if (typeof L === 'undefined') {
        statusElement.textContent =
            'Library peta gagal dimuat. Periksa koneksi internet atau akses CDN Leaflet.';
        return;
    }

    // Titik pusat tampilan awal di Padang.
    // Ini bukan posisi pengguna atau batas zona risiko.
    const sumbarCenter = [-0.9471, 100.4172];
    const initialZoom = 9;

    const map = L.map('siaganow-map', {
        zoomControl: true
    }).setView(sumbarCenter, initialZoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 5,
        maxZoom: 19,
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">' +
            'OpenStreetMap contributors</a>'
    }).addTo(map);

    let userMarker = null;
    let accuracyCircle = null;

    statusElement.textContent =
        'Peta dasar berhasil dimuat. Data zona risiko dan shelter belum terhubung.';

    // Kembali ke fokus awal Sumatera Barat.
    resetButton.addEventListener('click', function () {
        map.setView(sumbarCenter, initialZoom);

        statusElement.textContent =
            'Tampilan kembali ke fokus awal Sumatera Barat. ' +
            'Lapisan zona risiko dan shelter belum tersedia.';
    });

    // Lokasi perangkat hanya diakses setelah pengguna menekan tombol.
    locateButton.addEventListener('click', function () {
        if (!navigator.geolocation) {
            statusElement.textContent =
                'Browser ini tidak mendukung layanan lokasi.';
            return;
        }

        statusElement.textContent =
            'Meminta izin lokasi perangkat. Izinkan akses pada browser jika ingin melanjutkan.';

        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = position.coords.accuracy;

                if (userMarker) {
                    map.removeLayer(userMarker);
                }

                if (accuracyCircle) {
                    map.removeLayer(accuracyCircle);
                }

                userMarker = L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup('Perkiraan lokasi perangkat Anda');

                accuracyCircle = L.circle([lat, lng], {
                    radius: accuracy,
                    color: '#2563eb',
                    fillColor: '#60a5fa',
                    fillOpacity: 0.12,
                    weight: 1
                }).addTo(map);

                map.setView([lat, lng], 14);
                userMarker.openPopup();

                statusElement.textContent =
                    'Lokasi perangkat ditampilkan. Lingkaran menunjukkan perkiraan akurasi, bukan batas zona risiko.';
            },
            function (error) {
                const messages = {
                    1: 'Akses lokasi ditolak. Anda tetap dapat menjelajahi peta secara manual.',
                    2: 'Lokasi perangkat tidak berhasil ditentukan.',
                    3: 'Permintaan lokasi melewati batas waktu. Silakan coba lagi.'
                };

                statusElement.textContent =
                    messages[error.code] ||
                    'Lokasi tidak tersedia. Anda tetap dapat menjelajahi peta.';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 60000
            }
        );
    });

    // Menyesuaikan ukuran peta setelah layout selesai.
    requestAnimationFrame(function () {
        map.invalidateSize();
    });
});
</script>

</body>
</html>
