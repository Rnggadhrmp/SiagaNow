<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiagaNow — Siaga Menghadapi Bencana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: Arial, sans-serif; }
        .hero-bg {
            background: linear-gradient(110deg, #082f49 0%, #075985 60%, #0e7490 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-5 py-4 flex items-center justify-between gap-5">
            <a href="/" class="text-2xl font-extrabold text-sky-800">
                Siaga<span class="text-orange-500">Now</span>
            </a>

            <nav class="hidden md:flex items-center gap-7 text-sm font-medium">
                <a href="/" class="text-sky-700">Home</a>
                <a href="/maps" class="hover:text-sky-700">Maps</a>
                <a href="/report" class="hover:text-sky-700">Report</a>
                <a href="/donate" class="hover:text-sky-700">Donate</a>
                <a href="/other" class="hover:text-sky-700">Other</a>
            </nav>

            <a href="/login"
               class="rounded-lg bg-sky-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-900">
                Login
            </a>
        </div>
    </header>

    <main>
        <section class="hero-bg text-white">
            <div class="max-w-7xl mx-auto px-5 py-20 md:py-28">
                <div class="max-w-3xl">
                    <span class="inline-block rounded-full bg-white/10 px-4 py-2 text-sm mb-6">
                        Platform Informasi Kesiapsiagaan Bencana
                    </span>

                    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                        Lebih Siaga,<br>
                        Lebih Siap Melindungi.
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-sky-100">
                        Pantau informasi bencana, kenali risiko rumah Anda,
                        dan temukan informasi evakuasi untuk menghadapi banjir
                        serta tanah longsor.
                    </p>

                    <div class="mt-9 flex flex-wrap gap-4">
                        <a href="/risk-check"
                           class="rounded-lg bg-orange-500 px-6 py-3.5 font-bold text-white hover:bg-orange-600">
                            Cek Risiko Rumah Anda
                        </a>
                        <a href="/maps"
                           class="rounded-lg border border-white/50 px-6 py-3.5 font-semibold hover:bg-white/10">
                            Jelajahi Peta Bencana
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-5 py-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-6">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-sky-700">
                        Informasi kebencanaan
                    </p>
                    <h2 class="mt-2 text-2xl md:text-3xl font-extrabold">
                        Pantau Kondisi Terkini
                    </h2>
                </div>
                <p class="text-sm text-slate-500">
                    Informasi contoh — integrasi data belum tersedia.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <article class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="text-3xl">🌧️</div>
                    <h3 class="mt-4 font-bold">Informasi Cuaca</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Informasi cuaca dan curah hujan akan ditampilkan di sini.
                    </p>
                    <span class="mt-4 inline-block text-xs text-slate-400">Menunggu integrasi API</span>
                </article>

                <article class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="text-3xl">⚠️</div>
                    <h3 class="mt-4 font-bold">Peringatan Dini</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Informasi peringatan banjir dan tanah longsor.
                    </p>
                    <span class="mt-4 inline-block text-xs text-slate-400">Belum terhubung ke sumber resmi</span>
                </article>

                <article class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="text-3xl">📍</div>
                    <h3 class="mt-4 font-bold">Zona Rawan</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Kenali wilayah yang memiliki potensi bahaya.
                    </p>
                    <a href="/maps" class="mt-4 inline-block text-sm font-bold text-sky-700">
                        Lihat peta →
                    </a>
                </article>

                <article class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="text-3xl">🏠</div>
                    <h3 class="mt-4 font-bold">Shelter Evakuasi</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Informasi lokasi tempat evakuasi yang aman.
                    </p>
                    <a href="/maps" class="mt-4 inline-block text-sm font-bold text-sky-700">
                        Cari shelter →
                    </a>
                </article>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-5 pb-14">
            <div class="rounded-2xl bg-orange-50 border border-orange-200 p-7 md:p-10
                        flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <p class="font-bold text-orange-700">Kenali risiko sejak dini</p>
                    <h2 class="mt-2 text-2xl md:text-3xl font-extrabold">
                        Apakah rumah Anda berisiko?
                    </h2>
                    <p class="mt-3 max-w-2xl text-slate-600 leading-7">
                        Periksa informasi risiko banjir dan tanah longsor
                        berdasarkan data yang nantinya tersedia pada sistem.
                    </p>
                </div>
                <a href="/risk-check"
                   class="shrink-0 rounded-lg bg-orange-500 px-6 py-3.5 text-center font-bold text-white hover:bg-orange-600">
                    Mulai Pemeriksaan
                </a>
            </div>
        </section>
    </main>

    <footer class="bg-slate-900 text-slate-300">
        <div class="max-w-7xl mx-auto px-5 py-8 flex flex-col sm:flex-row
                    justify-between gap-3">
            <p class="font-bold text-white">SiagaNow</p>
            <p class="text-sm">
                Platform Kesiapsiagaan Bencana Banjir dan Tanah Longsor.
            </p>
        </div>
    </footer>

</body>
</html>