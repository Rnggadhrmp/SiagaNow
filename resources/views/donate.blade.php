<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate | SiagaNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root{--forest:#075b49;--dark:#064b3d;--line:#cfe3d8;--ink:#153f36}
        *{box-sizing:border-box}
        body{margin:0;color:#173d34;font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:radial-gradient(ellipse at 12% 0%,rgba(189,231,216,.9) 0,transparent 35%),linear-gradient(145deg,#e5f5ec,#f8fbf8 55%,#c5e8d8)}
        .panel{background:rgba(255,255,255,.88);border:1px solid var(--line);border-radius:20px;box-shadow:0 10px 28px rgba(7,91,73,.07)}
        .sn-header{box-sizing:border-box;width:100%;max-width:1440px;margin:0 auto;padding:13px 20px;display:flex;justify-content:space-between;align-items:center;gap:22px;flex-wrap:wrap;border:1px solid rgba(255,255,255,.72);border-radius:19px;background:rgba(238,250,243,.92);box-shadow:0 8px 28px rgba(12,83,64,.09);backdrop-filter:blur(12px);position:relative;z-index:1300}
        .sn-navigation{display:flex;align-items:center;justify-content:flex-end;gap:8px;flex-wrap:wrap;min-width:0}
        .sn-brand-symbol{width:60px;height:60px;border-radius:18px;display:grid;place-items:center;background:var(--forest);color:#fff;flex-shrink:0}
        .sn-nav{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:44px;padding:12px 15px;border:1px solid #d1e5da;border-radius:12px;background:#fff;color:var(--forest);text-decoration:none;font-family:inherit;font-size:14px;font-weight:700;white-space:nowrap;cursor:pointer;transition:background .18s ease,color .18s ease,border-color .18s ease,transform .18s ease}
        .sn-nav:hover{background:#e7f6ed;border-color:#b9d9c8;transform:translateY(-1px)}
        .sn-nav.active,.sn-nav[aria-expanded="true"]{background:var(--forest);border-color:var(--forest);color:#fff}
        .sn-other-wrap{position:relative;display:inline-flex;align-items:center}
        .sn-other-trigger{font-family:inherit;cursor:pointer}
        .sn-other-chevron{transition:transform .18s ease;flex-shrink:0}
        .sn-other-panel{position:absolute;z-index:1400;top:calc(100% + 12px);right:0;width:min(760px,calc(100vw - 32px));padding:20px;border:1px solid #d3e7dc;border-radius:18px;background:rgba(255,255,255,.98);box-shadow:0 22px 55px rgba(4,55,43,.20);color:var(--ink);backdrop-filter:blur(12px)}
        .sn-other-panel[hidden]{display:none}
        .sn-other-panel-heading{margin:0 0 14px;color:#07805f;font-size:12px;font-weight:900;letter-spacing:.14em;text-transform:uppercase}
        .sn-other-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 16px}
        .sn-other-item{display:flex;align-items:flex-start;gap:12px;min-width:0;padding:13px;border-left:4px solid #16a875;border-radius:10px;background:#f8fcf9;color:inherit;text-decoration:none}
        .sn-other-icon{display:grid;place-items:center;flex:0 0 34px;height:34px;border-radius:9px;background:#e2f5eb;color:#08745a;font-size:19px;font-weight:800}
        .sn-other-title{display:block;color:var(--forest);font-size:13px;font-weight:850;line-height:1.4}
        .sn-other-desc{display:block;margin-top:4px;color:#648078;font-size:11px;line-height:1.55}
        .sn-other-tag{display:inline-block;margin-top:6px;padding:3px 7px;border-radius:999px;background:#fff3d8;color:#8a5a08;font-size:9px;font-weight:800}
        .sn-other-footer{margin-top:14px;padding-top:12px;border-top:1px solid #e0eee6;color:#648078;font-size:11px;line-height:1.6}
        .sn-other-trigger:focus-visible,.sn-other-item:focus-visible{outline:3px solid #f0b429;outline-offset:3px}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border:1px solid transparent;border-radius:11px;padding:10px 15px;background:var(--forest);color:#fff;font-size:13px;font-weight:800;cursor:pointer;transition:.18s;text-decoration:none}
        .btn:hover{background:var(--dark)}
        .field{width:100%;border:1px solid #cfe2d7;border-radius:11px;padding:11px 13px;background:#fff;color:#173d34;outline:none}
        .field:focus{border-color:#13856c;box-shadow:0 0 0 3px #13856c1f}
        .campaign-card{display:grid;grid-template-columns:minmax(130px,.72fr) minmax(0,1.25fr);gap:14px;padding:12px;border:1px solid #c9ddd2;border-radius:15px;background:rgba(255,255,255,.8);box-shadow:0 3px 8px #064b3d12}
        .campaign-image{display:grid;min-height:145px;place-items:center;align-self:stretch;overflow:hidden;border-radius:11px;background:linear-gradient(145deg,#e5f6ed,#c7e7d9);color:#397b67}
        .campaign-image svg{width:42px;height:42px}
        .progress{height:9px;overflow:hidden;border-radius:999px;background:#d9eee4}
        .progress>span{display:block;height:100%;width:0;border-radius:inherit;background:linear-gradient(90deg,#18b98a,#08715a)}
        .muted{color:#617c73}
        .empty-state{display:grid;justify-items:center;text-align:center;padding:36px 22px;border:1px dashed #9bcbb7;border-radius:15px;background:rgba(239,250,244,.8)}
        .empty-state svg{width:42px;height:42px;color:#397b67}
        @media(max-width:800px){.campaign-card{grid-template-columns:1fr}.campaign-image{min-height:150px}}
        @media(max-width:1024px){.sn-header{align-items:flex-start}}@media(max-width:760px){.sn-header{padding:14px;gap:14px}.sn-navigation{width:100%;justify-content:flex-start;gap:7px}.sn-nav{min-height:38px;padding:9px 10px;font-size:11px;gap:5px}.sn-other-panel{left:0;right:auto;width:min(760px,calc(100vw - 24px));padding:15px}.sn-other-grid{grid-template-columns:1fr}}@media(max-width:800px){.campaign-card{grid-template-columns:1fr}.campaign-image{min-height:150px}}@media(max-width:640px){.campaign-card{padding:10px}}
    </style>
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
            <a class="sn-nav" href="{{ route('maps') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3z"/><path d="M9 3v15M15 6v15"/></svg>Maps</a>
            <a class="sn-nav" href="{{ url('/risk-check') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="m12 3 10 18H2L12 3Z"/><path d="M12 9v5M12 17h.01"/></svg>Cek Risiko</a>
            <a class="sn-nav" href="{{ url('/report') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 22V4"/><path d="M4 4c7-4 9 4 16 0v12c-7 4-9-4-16 0"/></svg>Report</a>
            <a class="sn-nav active" href="{{ url('/donate') }}" aria-current="page"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"/></svg>Donate</a>
            <div class="sn-other-wrap" data-sn-other>
                <button class="sn-nav sn-other-trigger" type="button" aria-expanded="false" aria-controls="sn-other-panel" data-sn-other-trigger>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Other
                    <svg class="sn-other-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="sn-other-panel" id="sn-other-panel" data-sn-other-panel hidden>
                    <h2 class="sn-other-panel-heading">Informasi &amp; Kesiapsiagaan Bencana</h2>
                    <div class="sn-other-grid">
                        <div class="sn-other-item"><span class="sn-other-icon" aria-hidden="true">≋</span><span><span class="sn-other-title">Informasi Bencana Banjir</span><span class="sn-other-desc">Tanda bahaya dan langkah kesiapsiagaan banjir.</span><span class="sn-other-tag">Halaman belum dibuat</span></span></div>
                        <div class="sn-other-item"><span class="sn-other-icon" aria-hidden="true">⌁</span><span><span class="sn-other-title">Informasi Tanah Longsor</span><span class="sn-other-desc">Tanda awal, faktor risiko, dan tindakan saat terjadi longsor.</span><span class="sn-other-tag">Halaman belum dibuat</span></span></div>
                        <div class="sn-other-item"><span class="sn-other-icon" aria-hidden="true">▥</span><span><span class="sn-other-title">Statistik Kejadian</span><span class="sn-other-desc">Ringkasan statistik setelah sumber data tersedia.</span><span class="sn-other-tag">Menunggu data</span></span></div>
                        <div class="sn-other-item"><span class="sn-other-icon" aria-hidden="true">☷</span><span><span class="sn-other-title">Panduan Kesiapsiagaan</span><span class="sn-other-desc">Panduan persiapan sebelum, saat, dan setelah bencana.</span><span class="sn-other-tag">Halaman belum dibuat</span></span></div>
                        <div class="sn-other-item"><span class="sn-other-icon" aria-hidden="true">▤</span><span><span class="sn-other-title">Berita Kebencanaan</span><span class="sn-other-desc">Informasi berita setelah sumber terverifikasi ditentukan.</span><span class="sn-other-tag">Menunggu sumber data</span></span></div>
                    </div>
                    <p class="sn-other-footer">Menu yang diberi label belum dibuat atau menunggu data belum tersedia sebagai fitur aktif.</p>
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
        <div><p class="text-xs font-extrabold uppercase tracking-[.18em] text-emerald-700">Dukungan kemanusiaan</p><h1 class="mt-2 text-3xl font-black tracking-tight sm:text-4xl" style="color:#123f34">Program Donasi</h1><p class="mt-2 max-w-3xl text-sm leading-6 muted sm:text-base">Temukan program penggalangan dana untuk membantu masyarakat terdampak bencana. Informasi program ditampilkan setelah datanya tersedia dan dapat diverifikasi.</p></div>
        <span class="rounded-full bg-amber-50 px-4 py-2 text-sm font-bold text-amber-800">Data program belum terhubung</span>
    </section>

    <div class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.55fr)_minmax(350px,.95fr)]">
        <section class="panel p-4 sm:p-5">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3"><div><h2 class="text-2xl font-black text-emerald-900">Program Donasi Terbaru</h2><p class="mt-1 text-sm muted">Daftar program yang tersedia akan ditampilkan di sini.</p></div><span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800">0 program tersedia</span></div>
            <div id="campaign-list" class="space-y-4">
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v18M17 7.5c0-1.7-2.2-3-5-3s-5 1.3-5 3 2.2 3 5 3 5 1.3 5 3-2.2 3-5 3-5-1.3-5-3"/></svg>
                    <h3 class="mt-3 font-extrabold text-emerald-900">Belum ada program donasi</h3>
                    <p class="mt-2 max-w-md text-sm leading-6 muted">Program, penyelenggara, foto, target, dan jumlah dana akan muncul setelah sumber datanya tersedia. Kami tidak menampilkan data contoh seolah-olah nyata.</p>
                </div>
            </div>
            <button id="show-more" type="button" class="btn mt-5 w-full" disabled aria-disabled="true">Lihat Donasi Lainnya</button>
        </section>

        <aside class="space-y-5">
            <section class="panel overflow-hidden">
                <div class="border-b border-emerald-100 px-5 py-4"><h2 class="text-lg font-black text-emerald-900">Donasi yang Sering Dikunjungi</h2><p class="mt-1 text-xs muted">Sorotan program donasi</p></div>
                <div class="p-4">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"/></svg>
                        <h3 class="mt-3 font-extrabold text-emerald-900">Belum ada sorotan</h3>
                        <p class="mt-2 text-sm leading-6 muted">Program yang tersedia dan terverifikasi dapat ditampilkan di area ini.</p>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-xl border border-emerald-100 bg-white p-3"><p class="text-xs muted">Penyelenggara</p><p class="mt-1 font-bold text-emerald-900">Belum tersedia</p></div>
                        <div class="rounded-xl border border-emerald-100 bg-white p-3"><p class="text-xs muted">Dana terkumpul</p><p class="mt-1 font-bold text-emerald-900">Belum tersedia</p></div>
                    </div>
                </div>
            </section>

            <section class="panel p-5">
                <h2 class="text-center text-lg font-black text-emerald-900">Temukan Layanan Donasi</h2>
                <p class="mt-1 text-center text-sm muted">Cari berdasarkan judul program atau wilayah.</p>
                <form id="campaign-search" class="mt-4 flex gap-2">
                    <label for="search-query" class="sr-only">Judul program atau wilayah</label>
                    <input id="search-query" class="field min-w-0" type="search" placeholder="Contoh: banjir atau nama wilayah">
                    <button class="btn" type="submit" aria-label="Cari program donasi">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                    </button>
                </form>
                <p id="search-message" class="mt-3 text-sm muted" role="status" aria-live="polite">Belum ada data program untuk dicari.</p>
            </section>

            <section class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                <h2 class="font-extrabold text-amber-900">Pastikan donasi aman</h2>
                <ul class="mt-2 list-disc space-y-2 pl-5 text-sm leading-6 text-amber-900">
                    <li>Periksa identitas penyelenggara dan penerima bantuan.</li>
                    <li>Pastikan target dan penggunaan dana dijelaskan secara transparan.</li>
                    <li>Gunakan metode pembayaran resmi yang sudah diverifikasi.</li>
                </ul>
            </section>
        </aside>
    </div>
</main>
<footer class="mt-8 bg-emerald-950 px-5 py-7 text-center text-sm text-emerald-50/80">SiagaNow — Kesiapsiagaan Bencana Banjir dan Tanah Longsor</footer>
<script>
document.getElementById('campaign-search').addEventListener('submit', function(event){
    event.preventDefault();
    const query = document.getElementById('search-query').value.trim();
    const status = document.getElementById('search-message');
    status.textContent = query
        ? 'Belum ada data program yang terhubung. Pencarian untuk "' + query + '" belum dapat menghasilkan daftar program.'
        : 'Masukkan judul program atau wilayah. Belum ada data program untuk dicari.';
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-sn-other]').forEach(function (wrap) {
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
            if (event.key === 'Escape') { closeMenu(); trigger.focus(); }
        });
    });
});
</script>

</body>
</html>
