<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maps | SiagaNow</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin="">

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
            border: 1px solid #d6e9df;
            border-radius: 15px;
            padding: 10px 14px;
            font-weight: 700;
            color: #075b49;
            background: #fff;
            text-decoration: none;
            transition: .18s;
            cursor: pointer;
            font-size: 14px;
        }

        .sn-nav:hover,
        .sn-nav.active {
            background: var(--forest);
            color: white;
        }

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

        @media (max-width: 640px) {
            #siaganow-map {
                min-height: 350px;
                height: 52vh;
            }
        }
    </style>
</head>

<body class="min-h-screen text-slate-800"
      style="background:radial-gradient(ellipse at 15% 0%,#bde7d8 0,transparent 36%),linear-gradient(145deg,#e5f5ec,#f8fbf8 52%,#c5e8d8)">

<header class="mx-auto max-w-[1500px] px-4 pt-5 sm:px-6">
    <div class="sn-shell flex flex-wrap items-center justify-between gap-4 rounded-[22px] px-5 py-4 sm:px-6">

        <a href="{{ route('home') }}"
           class="flex items-center gap-3"
           aria-label="SiagaNow beranda">

            <span class="grid h-12 w-12 place-items-center rounded-2xl text-2xl text-white"
                  style="background:var(--forest)">
                ⌂
            </span>

            <span>
                <span class="block text-2xl font-black tracking-tight"
                      style="color:var(--forest)">
                    SiagaNow
                </span>

                <span class="block text-xs font-semibold tracking-wide text-emerald-900/60">
                    Siaga Bencana, Selamat Bersama
                </span>
            </span>
        </a>

        <!-- Navbar utama -->
        <nav class="flex flex-wrap items-center gap-2"
             aria-label="Navigasi utama">

            <a class="sn-nav"
               href="{{ route('home') }}">
                ⌂ Home
            </a>

                <a class="sn-nav active" href="{{ route('maps') }}" aria-current="page">
            <svg xmlns="http://www.w3.org/2000/svg"
                width="16" height="16" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                style="vertical-align: -3px; margin-right: 4px;">
                <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                <circle cx="12" cy="10" r="2.5"/>
            </svg>
            Maps
        </a>

            <a class="sn-nav"
               href="{{ url('/risk-check') }}">
                ⚠ Cek Risiko
            </a>

            <a class="sn-nav"
               href="/report">
                ⚑ Report
            </a>

            <a class="sn-nav"
               href="/donate">
                ♡ Donate
            </a>

            <a class="sn-nav"
               href="/other">
                ☰ Other
            </a>

            @auth
                <a class="sn-nav"
                   href="{{ route('profil') }}">
                    Profil
                </a>

                <form action="{{ route('logout') }}"
                      method="POST">
                    @csrf

                    <button type="submit" class="sn-nav">
                        Keluar
                    </button>
                </form>
            @else
                <a class="sn-nav"
                   href="{{ route('login') }}">
                    Masuk
                </a>

                <a class="sn-nav"
                   href="{{ route('register') }}">
                    Daftar
                </a>
            @endauth

        </nav>
    </div>
</header>

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
            📍 Fokus: Sumatera Barat
        </span>
    </section>

    <section class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.8fr)_minmax(320px,.92fr)]">

        <!-- Peta interaktif -->
        <div class="sn-card overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-emerald-100 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="text-lg font-extrabold" style="color:var(--forest)">
                        Peta Lokasi Zona &amp; Evakuasi
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Peta dasar interaktif OpenStreetMap
                    </p>
                </div>

                <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800">
                    Peta interaktif
                </span>
            </div>

            <div class="relative">
                <div id="siaganow-map"
                     role="application"
                     aria-label="Peta interaktif Sumatera Barat">
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
                Memuat peta Sumatera Barat…
            </div>

            <div class="flex flex-wrap gap-x-5 gap-y-3 border-t border-emerald-100 px-5 py-4 text-xs font-semibold text-slate-600 sm:text-sm">
                <span class="flex items-center gap-2">
                    <i class="h-3 w-3 rounded-full bg-emerald-600"></i>
                    Zona aman (data belum tersedia)
                </span>

                <span class="flex items-center gap-2">
                    <i class="h-3 w-3 rounded-full bg-red-600"></i>
                    Zona bahaya (data belum tersedia)
                </span>

                <span class="flex items-center gap-2">
                    <i class="h-3 w-3 rounded-full bg-orange-500"></i>
                    Lokasi terdampak (data belum tersedia)
                </span>
            </div>

            <div class="border-t border-amber-200 bg-amber-50 px-5 py-3 text-xs leading-5 text-amber-900">
                <strong>Catatan penting:</strong>
                peta dasar bukan peta risiko. Belum ada poligon zona, titik shelter,
                atau lokasi terdampak yang ditampilkan karena data terverifikasi belum diintegrasikan.
            </div>
        </div>

        <!-- Panel informasi -->
        <aside class="space-y-5">

            <!-- Cari shelter -->
            <section class="sn-card p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-emerald-50 text-xl">
                        ⌕
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

            <!-- Zona aman -->
            <section class="sn-card p-5 sm:p-6">
                <h2 class="text-lg font-extrabold" style="color:var(--forest)">
                    Temukan Zona Aman
                </h2>

                <p class="mt-1 text-sm leading-5 text-slate-500">
                    Daftar zona A–D sesuai rancangan Figma. Detail wilayah menunggu data resmi.
                </p>

                <div class="mt-4 space-y-2.5">
                    @foreach (['A', 'B', 'C', 'D'] as $zona)
                        <div class="zone-row">
                            <span class="flex items-center gap-3">
                                <span class="grid h-9 w-9 place-items-center rounded-lg bg-emerald-50 font-black text-emerald-800">
                                    {{ $zona }}
                                </span>

                                <span class="font-bold text-slate-700">
                                    Zona Aman {{ $zona }}
                                </span>
                            </span>

                            <span class="text-right text-xs font-semibold text-slate-500">
                                Menunggu data
                            </span>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Zona merah -->
            <section class="rounded-[20px] border border-red-200 bg-red-50 p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-red-100 text-xl">
                        ⚠
                    </span>

                    <div>
                        <h2 class="text-lg font-extrabold text-red-900">
                            Daftar Zona Merah
                        </h2>

                        <p class="text-xs font-semibold text-red-700">
                            Belum terhubung
                        </p>
                    </div>
                </div>

                <p class="mt-3 text-sm leading-6 text-red-800">
                    Daftar wilayah berisiko tinggi baru dapat ditampilkan setelah data
                    kebencanaan resmi tersedia dan diverifikasi.
                </p>
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
           style="background:#ea7a17">
            Buka Cek Risiko Rumah →
        </a>
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
    const mapEl = document.getElementById('siaganow-map');
    const statusEl = document.getElementById('map-status');

    if (!mapEl || !statusEl) return;

    if (typeof L === 'undefined') {
        statusEl.textContent =
            'Leaflet gagal dimuat. Periksa koneksi internet dan coba muat ulang halaman.';
        return;
    }

    const sumbarCenter = [-0.9471, 100.4172];

    const map = L.map(mapEl, {
        scrollWheelZoom: true
    }).setView(sumbarCenter, 8);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 5,
        maxZoom: 19,
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    let userMarker = null;
    let accuracyCircle = null;

    statusEl.textContent =
        'Peta dasar berhasil dimuat. Data zona risiko dan shelter belum terhubung.';

    document.getElementById('reset-map')?.addEventListener('click', function () {
        map.setView(sumbarCenter, 8);

        statusEl.textContent =
            'Peta kembali difokuskan ke Sumatera Barat. Zona risiko dan shelter belum ditampilkan.';
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
            button.textContent = shelter.name + (shelter.address ? ' — ' + shelter.address : '');

            button.addEventListener('click', () => {
                const lat = Number(shelter.latitude);
                const lng = Number(shelter.longitude);

                if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

                map.setView([lat, lng], 15);

                L.popup()
                    .setLatLng([lat, lng])
                    .setContent(
                        document.createTextNode(shelter.name)
                    )
                    .openOn(map);
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

</body>
</html>
