<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Risiko Rumah | SiagaNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <style>
        :root { --forest:#075b49; --dark:#064b3d; }
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .shell { background:rgba(255,255,255,.93); border:1px solid #dcebe2; border-radius:21px; box-shadow:0 10px 28px rgba(7,91,73,.06); }
        .navlink { border:1px solid #d6e9df; border-radius:13px; padding:10px 13px; font-weight:750; color:var(--forest); background:white; }
        .navlink:hover,.navlink.active { background:var(--forest); color:white; }
        .btn { background:var(--forest); color:white; border-radius:11px; padding:11px 14px; font-weight:800; }
        .btn:hover { background:var(--dark); }
        .field { width:100%; border:1px solid #cfe2d7; border-radius:11px; padding:12px; outline:none; }
        .field:focus { border-color:#13856c; box-shadow:0 0 0 3px #13856c1f; }
        #risk-map { width:100%; min-height:390px; height:min(63vh,620px); background:#e5eee8; }
        .leaflet-container { font:inherit; }
        .risk-item { border:1px solid #dcebe2; border-radius:14px; padding:15px; background:#fff; }
        @media(max-width:640px){#risk-map{height:52vh;min-height:340px;}}
    </style>
</head>
<body class="min-h-screen" style="background:radial-gradient(ellipse at 12% 0%,#bde7d8 0,transparent 35%),linear-gradient(145deg,#e5f5ec,#f8fbf8 55%,#c5e8d8)">
<header class="mx-auto max-w-[1500px] px-4 pt-5 sm:px-6">
    <div class="flex flex-wrap items-center justify-between gap-4 rounded-[22px] border border-white bg-white/90 px-5 py-4 shadow-lg sm:px-6">
        <a href="/" class="flex items-center gap-3"><span class="grid h-12 w-12 place-items-center rounded-2xl text-2xl text-white" style="background:var(--forest)">⌂</span><span><strong class="block text-2xl font-black" style="color:var(--forest)">SiagaNow</strong><span class="block text-xs font-semibold text-emerald-900/60">Siaga Bencana, Selamat Bersama</span></span></a>
        <nav class="flex flex-wrap gap-2" aria-label="Navigasi utama">
            <a class="navlink" href="/">⌂ Home</a><a class="navlink active" href="/maps">▧ Maps</a><a class="navlink" href="/report">⚑ Report</a><a class="navlink" href="/donate">♡ Donate</a><a class="navlink" href="/other">☰ Other</a>
        </nav>
    </div>
</header>
<main class="mx-auto max-w-[1500px] px-4 py-6 sm:px-6 sm:py-8">
    <section class="mb-5 rounded-[22px] border border-white bg-white/90 px-6 py-6 shadow-lg sm:px-8">
        <p class="text-xs font-extrabold uppercase tracking-[.18em] text-emerald-700">Pemeriksaan lokasi</p>
        <h1 class="mt-2 text-3xl font-black tracking-tight text-emerald-950 sm:text-4xl">Cek Risiko Rumah Anda</h1>
        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600 sm:text-base">Cari alamat rumah dan tandai lokasinya pada peta. Saat ini peta dapat membantu melihat lokasi, tetapi hasil risiko banjir dan tanah longsor belum dapat dihitung karena data risiko resmi belum terhubung.</p>
    </section>

    <section class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.45fr)_minmax(340px,.85fr)]">
        <div class="shell overflow-hidden">
            <div class="border-b border-emerald-100 px-5 py-4"><h2 class="text-lg font-extrabold text-emerald-900">Lokasi Rumah Anda</h2><p class="mt-1 text-sm text-slate-500">Fokus awal peta: Sumatera Barat</p></div>
            <div class="relative"><div id="risk-map" role="application" aria-label="Peta untuk memilih lokasi rumah"></div></div>
            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-emerald-100 px-5 py-4">
                <div class="text-sm text-slate-600"><span class="font-bold text-emerald-900">Koordinat terpilih:</span> <span id="selected-coordinates">Belum dipilih</span></div>
                <button id="locate-home" class="btn" type="button">◎ Gunakan Lokasi Saya</button>
            </div>
            <p id="map-message" class="border-t border-emerald-100 bg-white px-5 py-3 text-sm leading-6 text-slate-600" role="status" aria-live="polite">Klik pada peta untuk menandai lokasi rumah.</p>
        </div>

        <aside class="space-y-5">
            <section class="shell p-5 sm:p-6">
                <h2 class="text-lg font-extrabold text-emerald-900">Cari Alamat Rumah</h2>
                <p class="mt-1 text-sm leading-5 text-slate-500">Masukkan alamat, kelurahan, atau kota untuk mencari titik pada peta.</p>
                <form id="address-form" class="mt-4">
                    <label for="address" class="mb-2 block text-sm font-bold">Alamat atau wilayah</label>
                    <input id="address" class="field" type="search" placeholder="Contoh: Padang, Sumatera Barat" autocomplete="street-address" required>
                    <button id="address-submit" class="btn mt-3 w-full" type="submit">Cari Lokasi</button>
                </form>
                <p id="address-status" class="mt-3 text-xs leading-5 text-slate-500">Pencarian alamat menggunakan layanan geocoding OpenStreetMap dan memerlukan koneksi internet.</p>
            </section>

            <section class="rounded-[21px] border border-red-200 bg-red-50 p-5 sm:p-6">
                <div class="flex items-start gap-3"><span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-red-100 text-xl">⚠️</span><div><h2 class="text-lg font-extrabold text-red-900">Peringatan Risiko</h2><p class="mt-1 text-sm leading-5 text-red-800">Belum dapat ditentukan</p></div></div>
                <p class="mt-3 text-sm leading-6 text-red-800">SiagaNow belum terhubung dengan data peringatan cuaca atau peta bahaya terverifikasi. Panel ini tidak menyatakan lokasi rumah aman maupun berbahaya.</p>
            </section>

            <section class="shell p-5 sm:p-6">
                <h2 class="text-lg font-extrabold text-emerald-900">Hasil Pemeriksaan</h2>
                <p class="mt-1 text-sm text-slate-500">Pemeriksaan berdasarkan lokasi terpilih</p>
                <div class="mt-4 space-y-3">
                    <div class="risk-item"><div class="flex items-center gap-3"><span class="text-xl">🌧️</span><div><h3 class="font-extrabold text-slate-800">Risiko Banjir</h3><p class="mt-1 text-sm text-slate-500">Data belum tersedia</p></div></div></div>
                    <div class="risk-item"><div class="flex items-center gap-3"><span class="text-xl">⛰️</span><div><h3 class="font-extrabold text-slate-800">Risiko Tanah Longsor</h3><p class="mt-1 text-sm text-slate-500">Data belum tersedia</p></div></div></div>
                    <div class="risk-item"><div class="flex items-center gap-3"><span class="text-xl">🌦️</span><div><h3 class="font-extrabold text-slate-800">Curah Hujan</h3><p class="mt-1 text-sm text-slate-500">Belum terhubung ke sumber cuaca</p></div></div></div>
                </div>
                <div class="mt-4 rounded-xl bg-emerald-50 p-4 text-sm leading-6 text-emerald-950"><strong>Langkah selanjutnya:</strong> hubungkan data resmi kebencanaan, elevasi, dan cuaca sebelum menghasilkan skor risiko atau rekomendasi evakuasi.</div>
                <a href="/maps" class="mt-4 inline-flex font-extrabold text-emerald-800 hover:underline">← Kembali ke Peta Kebencanaan</a>
            </section>
        </aside>
    </section>
</main>
<footer class="mt-8 bg-emerald-950 px-5 py-7 text-center text-sm text-emerald-50/80">SiagaNow — Kesiapsiagaan Bencana Banjir dan Tanah Longsor</footer>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('risk-map');
    const message = document.getElementById('map-message');
    const coords = document.getElementById('selected-coordinates');
    const addressStatus = document.getElementById('address-status');
    if (typeof L === 'undefined') {
        message.textContent = 'Leaflet gagal dimuat. Periksa koneksi internet dan muat ulang halaman.';
        return;
    }

    const center = [-0.9471, 100.4172];
    const map = L.map(mapEl).setView(center, 8);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 5, maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    let homeMarker = null;
    function setHomeLocation(lat, lon, label) {
        const point = [lat, lon];
        if (homeMarker) map.removeLayer(homeMarker);
        homeMarker = L.marker(point).addTo(map).bindPopup('Lokasi rumah yang dipilih').openPopup();
        map.setView(point, 15);
        coords.textContent = lat.toFixed(5) + ', ' + lon.toFixed(5);
        message.textContent = label || 'Lokasi ditandai. Penilaian risiko belum tersedia karena data resmi belum terhubung.';
    }

    map.on('click', function (event) {
        setHomeLocation(event.latlng.lat, event.latlng.lng, 'Lokasi dipilih dari peta. Ini hanya penandaan lokasi, bukan hasil penilaian risiko.');
    });

    document.getElementById('locate-home').addEventListener('click', function () {
        if (!navigator.geolocation) {
            message.textContent = 'Browser tidak mendukung fitur lokasi perangkat.';
            return;
        }
        message.textContent = 'Meminta izin lokasi perangkat…';
        navigator.geolocation.getCurrentPosition(function (position) {
            setHomeLocation(position.coords.latitude, position.coords.longitude, 'Lokasi perangkat ditandai. Hasil risiko belum dapat dihitung.');
        }, function (error) {
            const messages = {1:'Izin lokasi ditolak.', 2:'Lokasi perangkat tidak berhasil ditentukan.', 3:'Permintaan lokasi melewati batas waktu.'};
            message.textContent = messages[error.code] || 'Lokasi perangkat tidak tersedia.';
        }, {enableHighAccuracy:true, timeout:10000, maximumAge:60000});
    });

    document.getElementById('address-form').addEventListener('submit', async function (event) {
        event.preventDefault();
        const query = document.getElementById('address').value.trim();
        if (!query) return;
        addressStatus.textContent = 'Mencari alamat…';
        const submit = document.getElementById('address-submit');
        submit.disabled = true;
        submit.classList.add('opacity-60');
        try {
            const url = 'https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&q=' + encodeURIComponent(query + ', Sumatera Barat, Indonesia');
            const response = await fetch(url, {headers:{'Accept':'application/json'}});
            if (!response.ok) throw new Error('Layanan pencarian tidak tersedia');
            const results = await response.json();
            if (!results.length) {
                addressStatus.textContent = 'Alamat tidak ditemukan. Coba gunakan nama wilayah yang lebih spesifik atau tandai langsung pada peta.';
                return;
            }
            const result = results[0];
            setHomeLocation(Number(result.lat), Number(result.lon), 'Lokasi ditemukan: ' + result.display_name + '. Ini bukan penilaian risiko.');
            addressStatus.textContent = 'Lokasi ditemukan dari OpenStreetMap: ' + result.display_name;
        } catch (error) {
            addressStatus.textContent = 'Pencarian alamat gagal. Periksa koneksi internet atau tandai lokasi langsung pada peta.';
        } finally {
            submit.disabled = false;
            submit.classList.remove('opacity-60');
        }
    });

    requestAnimationFrame(function () { map.invalidateSize(); });
});
</script>
</body>
</html>
