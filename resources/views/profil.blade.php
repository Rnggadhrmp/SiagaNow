<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil | SiagaNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --forest: #075b49;
            --forest-dark: #064b3d;
            --line: #d1e5da;
            --ink: #153f36;
            --muted: #648078;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--ink);
            background:
                radial-gradient(ellipse at 15% 0%, rgba(115, 211, 180, .42), transparent 38%),
                linear-gradient(145deg, #e5f5ec, #f6fbf7 52%, #d8f0e5);
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
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

        .sn-nav {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: 12px 15px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            color: var(--forest);
            text-decoration: none;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;
        }

        .sn-nav:hover { background: #e7f6ed; border-color: #b9d9c8; transform: translateY(-1px); }
        .sn-nav.active, .sn-nav[aria-expanded="true"] { background: var(--forest); border-color: var(--forest); color: #fff; }

        .sn-other-wrap { position: relative; display: inline-flex; align-items: center; }
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
        .sn-other-item { display: flex; align-items: flex-start; gap: 12px; min-width: 0; padding: 13px; border-left: 4px solid #16a875; border-radius: 10px; background: #f8fcf9; color: inherit; text-decoration: none; }
        .sn-other-icon { display: grid; place-items: center; flex: 0 0 34px; height: 34px; border-radius: 9px; background: #e2f5eb; color: #08745a; font-size: 19px; font-weight: 800; }
        .sn-other-title { display: block; color: var(--forest); font-size: 13px; font-weight: 850; line-height: 1.4; }
        .sn-other-desc { display: block; margin-top: 4px; color: var(--muted); font-size: 11px; line-height: 1.55; }
        .sn-other-tag { display: inline-block; margin-top: 6px; padding: 3px 7px; border-radius: 999px; background: #fff3d8; color: #8a5a08; font-size: 9px; font-weight: 800; }
        .sn-other-footer { margin-top: 14px; padding-top: 12px; border-top: 1px solid #e0eee6; color: var(--muted); font-size: 11px; line-height: 1.6; }
        .sn-other-trigger:focus-visible, .sn-other-item:focus-visible { outline: 3px solid #f0b429; outline-offset: 3px; }

        .profile-card {
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.9);
            border-radius: 24px;
            background: rgba(255,255,255,.94);
            box-shadow: 0 18px 48px rgba(6,75,61,.10);
        }

        .profile-hero {
            padding: 30px;
            color: white;
            background: linear-gradient(125deg, #075b49, #08735a);
        }

        .profile-avatar {
            display: grid;
            width: 76px;
            height: 76px;
            flex-shrink: 0;
            place-items: center;
            border: 3px solid rgba(255,255,255,.65);
            border-radius: 22px;
            background: #e4f6ed;
            color: var(--forest);
            font-size: 30px;
            font-weight: 900;
        }

        .profile-detail {
            min-width: 0;
            padding: 17px 18px;
            border: 1px solid #e0eee6;
            border-radius: 15px;
            background: #fbfefc;
        }

        .profile-label { margin: 0; color: var(--muted); font-size: 13px; font-weight: 600; }
        .profile-value { margin: 6px 0 0; overflow-wrap: anywhere; color: var(--ink); font-size: 15px; font-weight: 750; }
        .logout-button { display: inline-flex; width: 100%; min-height: 48px; align-items: center; justify-content: center; gap: 8px; border: 1px solid #fecaca; border-radius: 13px; background: #fff1f2; color: #b91c1c; font-weight: 800; transition: background .18s ease; }
        .logout-button:hover { background: #ffe4e6; }

        @media (max-width: 1024px) { .sn-header { align-items: flex-start; } }
        @media (max-width: 760px) {
            .sn-header { padding: 14px; gap: 14px; }
            .sn-navigation { width: 100%; justify-content: flex-start; gap: 7px; }
            .sn-nav { min-height: 38px; padding: 9px 10px; font-size: 11px; gap: 5px; }
            .sn-other-panel { left: 0; right: auto; width: min(760px, calc(100vw - 24px)); padding: 15px; }
            .sn-other-grid { grid-template-columns: 1fr; }
            .profile-hero { padding: 22px; }
            .profile-avatar { width: 62px; height: 62px; border-radius: 18px; font-size: 25px; }
        }
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
                <a class="sn-nav" href="{{ route('home') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m3 10 9-7 9 7M5 9v12h14V9"/></svg>
                    Home
                </a>
                <a class="sn-nav" href="{{ route('maps') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3z"/><path d="M9 3v15M15 6v15"/></svg>
                    Maps
                </a>
                <a class="sn-nav" href="{{ url('/risk-check') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="m12 3 10 18H2L12 3Z"/><path d="M12 9v5M12 17h.01"/></svg>
                    Cek Risiko
                </a>
                <a class="sn-nav" href="{{ url('/report') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 22V4"/><path d="M4 4c7-4 9 4 16 0v12c-7 4-9-4-16 0"/></svg>
                    Report
                </a>
                <a class="sn-nav" href="{{ url('/donate') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"/></svg>
                    Donate
                </a>
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
                <a class="sn-nav" href="{{ route('profil') }}" aria-current="page" style="background:var(--forest);border-color:var(--forest);color:#fff">Profil</a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="sn-nav">Keluar</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="mx-auto w-full max-w-[1100px] px-4 py-8 sm:px-6 sm:py-10">
        <div class="mb-6">
            <p class="text-xs font-black uppercase tracking-[.18em] text-emerald-700">Akun Pengguna</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-emerald-950 sm:text-4xl">Profil Saya</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-900/65 sm:text-base">Lihat informasi akun yang terdaftar di SiagaNow.</p>
        </div>

        <section class="profile-card">
            <div class="profile-hero">
                <div class="flex flex-wrap items-center gap-5">
                    <div class="profile-avatar" aria-label="Inisial nama pengguna">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-100">Informasi Akun</p>
                        <h2 class="mt-1 break-words text-2xl font-black sm:text-3xl">{{ Auth::user()->name }}</h2>
                        <p class="mt-1 break-words text-sm text-emerald-100">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <div class="p-5 sm:p-8">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="profile-detail">
                        <p class="profile-label">Nama Lengkap</p>
                        <p class="profile-value">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="profile-detail">
                        <p class="profile-label">Email</p>
                        <p class="profile-value">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="profile-detail">
                        <p class="profile-label">Nomor Telepon</p>
                        <p class="profile-value">{{ Auth::user()->phone ?: 'Belum diisi' }}</p>
                    </div>
                    <div class="profile-detail">
                        <p class="profile-label">Domisili</p>
                        <p class="profile-value">{{ Auth::user()->address ?: 'Belum diisi' }}</p>
                    </div>
                </div>

                <div class="mt-7 flex flex-col-reverse gap-3 border-t border-emerald-100 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('home') }}" class="sn-nav w-full sm:w-auto">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/><path d="M9 12h12"/></svg>
                        Kembali ke Beranda
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="logout-button px-5 py-3">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
                            Keluar dari Akun
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <p class="mt-5 text-center text-xs leading-5 text-emerald-900/55">Informasi yang ditampilkan berasal dari data akun yang tersimpan. Kolom yang belum diisi akan ditandai “Belum diisi”.</p>
    </main>

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
