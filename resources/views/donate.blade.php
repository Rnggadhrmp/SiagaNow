<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Donate | SiagaNow</title>


    <style>

        :root{--forest:#075b49;--dark:#064b3d;--line:#cfe3d8;--ink:#123d35}

        *{box-sizing:border-box}

        body{margin:0;color:#123d35;font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:#d9eee2}

        .panel{background:#eff8f2;border:1px solid var(--line);border-radius:7px;box-shadow:none}

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

        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:46px;border:1px solid transparent;border-radius:4px;padding:10px 15px;background:var(--forest);color:#fff;font-size:15px;font-weight:750;cursor:pointer;transition:background-color .18s;text-decoration:none}

        .btn:hover{background:var(--dark)}

        .field{width:100%;min-height:48px;border:1px solid #cfe2d7;border-radius:4px;padding:11px 13px;background:#fff;color:#173d34;outline:none;font-size:16px}

        .field:focus{border-color:#13856c;box-shadow:0 0 0 3px #13856c1f}

        .campaign-card{display:grid;grid-template-columns:minmax(140px,.52fr) minmax(0,1.48fr);gap:18px;padding:16px;border:1px solid var(--line);border-radius:7px;background:#fff;box-shadow:none}

        .campaign-image{display:grid;min-height:180px;place-items:center;align-self:stretch;overflow:hidden;border-radius:4px;background:var(--sn-sage);color:var(--forest)}

        .campaign-image svg{width:64px;height:64px}

        .progress{height:12px;overflow:hidden;border-radius:2px;background:#d9f0e5}

        .progress>span{display:block;height:100%;width:0;border-radius:inherit;background:#0b795d}

        .muted{color:#526f65}

        .demo-note{margin-bottom:18px;padding:13px 16px;border-left:4px solid #075b49;background:#d9f0e5;color:#123d35;font-size:15px;line-height:1.55}
        .campaign-title{font-size:21px;line-height:1.3;font-weight:800;color:#075b49}
        .campaign-meta{display:flex;flex-wrap:wrap;gap:8px 20px;color:#526f65;font-size:14px;line-height:1.5}
        .campaign-actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:16px}
        .campaign-actions .btn{flex:1 1 180px}
        .campaign-secondary{border:1px solid #075b49;background:#eff8f2;color:#075b49}
        .campaign-secondary:hover{background:#d9f0e5}
        .campaign-detail-grid{display:grid;grid-template-columns:minmax(0,1fr) minmax(250px,.65fr);gap:24px}
        .campaign-detail-image{display:grid;min-height:250px;place-items:center;background:#d9f0e5;color:#075b49}
        .campaign-detail-image svg{width:100px;height:100px}
        .campaign-detail-aside{padding:18px;border-left:1px solid var(--line);background:#fff}
        .campaign-facts{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin:20px 0}
        .campaign-fact{padding:12px 0;border-top:1px solid var(--line)}
        .campaign-fact dt{font-size:13px;color:#526f65}
        .campaign-fact dd{margin:5px 0 0;font-size:17px;font-weight:750;color:#075b49}
        .campaign-card[hidden]{display:none}
        .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
        .btn:focus-visible,.field:focus-visible,a:focus-visible{outline:3px solid #0b795d;outline-offset:3px}

        .empty-state{display:grid;justify-items:center;text-align:center;padding:36px 22px;border:1px dashed #9bcbb7;border-radius:15px;background:rgba(239,250,244,.8)}

        .empty-state svg{width:42px;height:42px;color:#397b67}

        @media(max-width:800px){.campaign-card{grid-template-columns:1fr}.campaign-image{min-height:140px}.campaign-detail-grid{grid-template-columns:1fr}.campaign-detail-aside{border-left:0;border-top:1px solid var(--line)}.campaign-detail-image{min-height:180px}}

        @media(max-width:1024px){.sn-header{align-items:flex-start}}@media(max-width:760px){.sn-header{padding:14px;gap:14px}.sn-navigation{width:100%;justify-content:flex-start;gap:7px}.sn-nav{min-height:38px;padding:9px 10px;font-size:11px;gap:5px}.sn-other-panel{left:0;right:auto;width:min(760px,calc(100vw - 24px));padding:15px}.sn-other-grid{grid-template-columns:1fr}}@media(max-width:800px){.campaign-card{grid-template-columns:1fr}.campaign-image{min-height:150px}}@media(max-width:640px){.campaign-card{padding:10px}}

    </style>

@vite(['resources/css/app.css'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>

<body data-page="donate" class="min-h-screen">

@include('partials.site-navbar')



<main class="mx-auto max-w-[1600px] px-4 py-5 sm:px-6 sm:py-7">

    @if (!empty($selectedCampaign))
        @php($campaign = $selectedCampaign)
        @php($progress = min(100, (int) floor(($campaign['collected'] / max(1, $campaign['target'])) * 100)))
        <a href="{{ route('donate') }}" class="mb-4 inline-flex min-h-11 items-center gap-2 text-base font-bold text-emerald-900 underline underline-offset-4">← Kembali ke daftar program</a>
        <section class="panel p-5 sm:p-8">
            <p class="text-sm font-bold uppercase tracking-wide text-emerald-800">Detail program demonstrasi</p>
            <h1 class="mt-2 text-3xl font-black leading-tight text-emerald-950 sm:text-4xl">{{ $campaign['title'] }}</h1>
            <p class="mt-2 text-base muted">{{ $campaign['location'] }}</p>
            <div class="campaign-detail-grid mt-6">
                <div>
                    <div class="campaign-detail-image" aria-label="Ilustrasi tematik; bukan foto kejadian nyata">
                        @include('partials.donation-illustration', ['type' => $campaign['illustration']])
                    </div>
                    <p class="mt-5 text-base leading-7 muted">{{ $campaign['description'] }}</p>
                    <dl class="campaign-facts">
                        <div class="campaign-fact"><dt>Periode contoh</dt><dd>{{ \Illuminate\Support\Carbon::parse($campaign['period_start'])->locale('id')->translatedFormat('j M Y') }} – {{ \Illuminate\Support\Carbon::parse($campaign['period_end'])->locale('id')->translatedFormat('j M Y') }}</dd></div>
                        <div class="campaign-fact"><dt>Status</dt><dd>Contoh program simulasi</dd></div>
                        <div class="campaign-fact"><dt>Penyelenggara</dt><dd>{{ $campaign['organizer'] }}</dd></div>
                        <div class="campaign-fact"><dt>Wilayah contoh</dt><dd>{{ $campaign['location'] }}</dd></div>
                    </dl>
                </div>
                <aside class="campaign-detail-aside">
                    <p class="text-base font-bold text-emerald-950">Ringkasan angka contoh</p>
                    <div class="progress mt-4" role="progressbar" aria-label="Progres simulasi" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $progress }}" aria-valuetext="{{ $progress }} persen, contoh simulasi"><span style="width:{{ $progress }}%"></span></div>
                    <p class="mt-3 text-xl font-extrabold text-emerald-900">Rp{{ number_format($campaign['collected'], 0, ',', '.') }} <span class="text-sm font-normal muted">terkumpul (contoh)</span></p>
                    <p class="mt-2 text-base muted">Target contoh Rp{{ number_format($campaign['target'], 0, ',', '.') }} · {{ $progress }}%</p>
                    <button class="btn mt-6 w-full cursor-not-allowed opacity-60" type="button" disabled aria-disabled="true">Pembayaran belum tersedia</button>
                    <p class="mt-3 text-sm leading-6 muted">Belum ada penyelenggara atau payment gateway yang diverifikasi untuk menerima dana.</p>
                </aside>
            </div>
        </section>
    @else

    <section class="panel mb-5 flex flex-wrap items-center justify-between gap-4 px-6 py-6 sm:px-8">

        <div><p class="text-sm font-bold uppercase tracking-wide text-emerald-800">Dukungan kesiapsiagaan</p><h1 class="mt-2 text-3xl font-black tracking-tight sm:text-4xl" style="color:#123d35">Program Donasi</h1><p class="mt-2 max-w-3xl text-base leading-7 muted">Contoh program untuk memperlihatkan informasi, target, dan progres yang kelak dapat disediakan oleh mitra terverifikasi.</p></div>

        <span class="rounded-sm bg-emerald-50 px-4 py-2 text-base font-bold text-emerald-900">{{ $demoMode ? 'Contoh tampilan' : 'Program belum tersedia' }}</span>

    </section>

    @if ($demoMode)
        <p class="demo-note">Data Simulasi: seluruh nama, nilai, dan periode di halaman ini hanya contoh. SiagaNow belum menerima donasi atau memproses transaksi.</p>
    @endif



    <div class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.55fr)_minmax(350px,.95fr)]">

        <section class="panel p-4 sm:p-5">

            <div class="mb-4 flex flex-wrap items-center justify-between gap-3"><div><h2 class="text-2xl font-black text-emerald-900">Program Donasi Terbaru</h2><p class="mt-1 text-base muted">{{ $demoMode ? 'Rencana kesiapsiagaan yang disusun sebagai ilustrasi.' : 'Daftar program terverifikasi belum tersedia.' }}</p></div><span class="rounded-sm bg-emerald-50 px-3 py-2 text-sm font-bold text-emerald-900">{{ $demoMode ? count($demoCampaigns) . ' program contoh' : '0 program' }}</span></div>

            <div id="campaign-list" class="space-y-4">
                @if ($demoMode)
                    @foreach ($demoCampaigns as $campaign)
                        @php($progress = min(100, (int) floor(($campaign['collected'] / max(1, $campaign['target'])) * 100)))
                        <article class="campaign-card" data-campaign-card data-search-text="{{ mb_strtolower($campaign['title'].' '.$campaign['location']) }}">
                            <div class="campaign-image" aria-label="Ilustrasi tematik, bukan foto kejadian nyata">
                                @include('partials.donation-illustration', ['type' => $campaign['illustration']])
                            </div>
                            <div>
                                <div class="campaign-meta"><span>Periode contoh: {{ \Illuminate\Support\Carbon::parse($campaign['period_start'])->locale('id')->translatedFormat('j M Y') }} – {{ \Illuminate\Support\Carbon::parse($campaign['period_end'])->locale('id')->translatedFormat('j M Y') }}</span><span>{{ $campaign['location'] }}</span></div>
                                <h3 class="campaign-title mt-2">{{ $campaign['title'] }}</h3>
                                <p class="mt-2 text-base leading-6 muted">{{ $campaign['description'] }}</p>
                                <div class="progress mt-4" role="progressbar" aria-label="Progres simulasi" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $progress }}" aria-valuetext="{{ $progress }} persen, contoh simulasi"><span style="width:{{ $progress }}%"></span></div>
                                <div class="campaign-meta mt-2"><strong>Rp{{ number_format($campaign['collected'], 0, ',', '.') }} terkumpul (contoh)</strong><span>Target Rp{{ number_format($campaign['target'], 0, ',', '.') }} · {{ $progress }}%</span></div>
                                <div class="campaign-actions">
                                    <a class="btn campaign-secondary" href="{{ route('donate.program.show', ['campaign' => $campaign['id']]) }}">Lihat detail</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @else
                <div class="empty-state">

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v18M17 7.5c0-1.7-2.2-3-5-3s-5 1.3-5 3 2.2 3 5 3 5 1.3 5 3-2.2 3-5 3-5-1.3-5-3"/></svg>

                    <h3 class="mt-3 font-extrabold text-emerald-900">Belum ada program donasi</h3>

                    <p class="mt-2 max-w-md text-sm leading-6 muted">Program, penyelenggara, foto, target, dan jumlah dana akan muncul setelah sumber datanya tersedia. Kami tidak menampilkan data contoh seolah-olah nyata.</p>

                </div>
                @endif
            </div>

            @if ($demoMode)
                <p class="mt-4 text-base muted">{{ count($demoCampaigns) }} program contoh ditampilkan.</p>
            @endif

        </section>



        <aside class="space-y-5">

            <section class="panel overflow-hidden">

                <div class="border-b border-emerald-100 px-5 py-4"><h2 class="text-lg font-black text-emerald-900">Sorotan program</h2><p class="mt-1 text-base muted">Program kesiapsiagaan pilihan.</p></div>

                <div class="divide-y divide-emerald-100 p-4">
                    @if ($demoMode)
                        @foreach (array_slice($demoCampaigns, 0, 2) as $campaign)
                            <a class="block py-4 first:pt-0 last:pb-0" href="{{ route('donate.program.show', ['campaign' => $campaign['id']]) }}">
                                <span class="block text-base font-bold text-emerald-900">{{ $campaign['title'] }}</span>
                                <span class="mt-1 block text-sm muted">Rp{{ number_format($campaign['collected'], 0, ',', '.') }} dari target contoh Rp{{ number_format($campaign['target'], 0, ',', '.') }}</span>
                            </a>
                        @endforeach
                    @else
                        <p class="py-2 text-base leading-6 muted">Belum ada program terverifikasi untuk ditampilkan.</p>
                    @endif
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

                <p id="search-message" class="mt-3 text-base muted" role="status" aria-live="polite">{{ $demoMode ? 'Masukkan judul atau wilayah untuk menyaring program.' : 'Belum ada data program untuk dicari.' }}</p>

            </section>



        </aside>

    </div>

    @endif
</main>

<footer class="mt-8 bg-emerald-950 px-5 py-7 text-center text-sm text-emerald-50/80">SiagaNow — Kesiapsiagaan Bencana Banjir dan Tanah Longsor</footer>

<script>

const campaignSearchForm = document.getElementById('campaign-search');
if (campaignSearchForm) campaignSearchForm.addEventListener('submit', function(event){

    event.preventDefault();

    const query = document.getElementById('search-query').value.trim();

    const status = document.getElementById('search-message');

    const demoCards = Array.from(document.querySelectorAll('[data-campaign-card]'));
    if (demoCards.length) {
        const matches = demoCards.filter(function(card) {
            const found = !query || card.dataset.searchText.includes(query.toLocaleLowerCase('id'));
            card.hidden = !found;
            return found;
        });
        status.textContent = matches.length
            ? matches.length + ' program ditemukan.'
            : 'Tidak ada program yang cocok dengan pencarian tersebut.';
        return;
    }

    status.textContent = query

        ? 'Belum ada data program yang terhubung. Pencarian untuk "' + query + '" belum dapat menghasilkan daftar program.'

        : 'Masukkan judul program atau wilayah. Belum ada data program untuk dicari.';

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
