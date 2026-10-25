<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Status Laporan Saya | SiagaNow</title>
@vite(['resources/css/app.css'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>
<body class="min-h-screen bg-emerald-50 text-slate-800">
    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6">
        <a href="{{ route('report') }}" class="text-sm font-bold text-emerald-800">← Kembali ke formulir laporan</a>
        <header class="mt-5 rounded-3xl bg-white p-6 shadow-sm sm:p-8">
            <p class="text-xs font-extrabold uppercase tracking-[.16em] text-emerald-700">Area akun</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-emerald-950">Status Laporan Saya</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">Hanya laporan yang dikirim dari akun ini yang ditampilkan. Status awal menunggu pemeriksaan petugas.</p>
        </header>

        <section class="mt-5 space-y-3" aria-label="Daftar laporan">
            @forelse ($reports as $report)
                <article class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold text-slate-500">Laporan #{{ $report->id }} · {{ $report->created_at?->format('d M Y, H:i') }}</p>
                            <h2 class="mt-1 text-lg font-extrabold text-emerald-950">{{ $report->title }}</h2>
                            <p class="mt-1 text-sm text-slate-600">{{ $report->event_type }} · Kejadian {{ $report->occurred_at?->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-900">
                            {{ $report->status === 'submitted' ? 'Menunggu pemeriksaan' : str($report->status)->replace('_', ' ')->title() }}
                        </span>
                    </div>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $report->description }}</p>
                    @if ($report->evidence_paths)
                        <p class="mt-3 text-xs font-semibold text-slate-500">{{ count($report->evidence_paths) }} lampiran tersimpan secara privat</p>
                    @endif
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-emerald-200 bg-white px-5 py-12 text-center">
                    <div class="text-3xl" aria-hidden="true">▤</div>
                    <h2 class="mt-3 font-extrabold text-emerald-950">Belum ada laporan</h2>
                    <p class="mt-2 text-sm text-slate-600">Laporan yang kamu kirim akan tampil di sini setelah berhasil disimpan.</p>
                    <a href="{{ route('report') }}" class="mt-4 inline-flex rounded-xl bg-emerald-800 px-4 py-2.5 text-sm font-bold text-white">Buat laporan</a>
                </div>
            @endforelse
        </section>

        <div class="mt-5">{{ $reports->links() }}</div>
        <p class="mt-6 text-xs leading-5 text-slate-500">Status hanya berubah setelah tindakan pemeriksaan yang berwenang. Saat ini laporan baru tercatat sebagai menunggu pemeriksaan.</p>
    </main>
</body>
</html>
