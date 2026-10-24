{{-- Mega menu Other SiagaNow. Letakkan di resources/views/partials/other-menu.blade.php --}}
<style>
    .sn-other-wrap{position:relative;display:inline-flex;align-items:center}
    .sn-other-trigger{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 13px;border:1px solid #d6e9df;border-radius:13px;background:#fff;color:#075b49;font-size:14px;font-weight:750;white-space:nowrap;cursor:pointer;transition:.18s}
    .sn-other-trigger:hover,.sn-other-trigger[aria-expanded="true"]{background:#075b49;color:#fff}
    .sn-other-trigger svg{flex:none}
    .sn-other-panel{position:absolute;z-index:1000;top:calc(100% + 12px);right:0;width:min(760px,calc(100vw - 32px));padding:20px;background:rgba(255,255,255,.98);border:1px solid #d3e7dc;border-radius:18px;box-shadow:0 22px 55px rgba(4,55,43,.2);color:#173d34}
    .sn-other-panel[hidden]{display:none}
    .sn-other-heading{margin:0 0 14px;font-size:12px;font-weight:900;letter-spacing:.14em;text-transform:uppercase;color:#07805f}
    .sn-other-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 18px}
    .sn-other-item{display:flex;gap:12px;align-items:flex-start;min-width:0;padding:13px;border-left:4px solid #16a875;border-radius:10px;text-decoration:none;color:#173d34;background:#f8fcf9;transition:background .15s,transform .15s}
    .sn-other-item:hover{background:#eaf8f0;transform:translateY(-1px)}
    .sn-other-item:focus-visible,.sn-other-trigger:focus-visible{outline:3px solid #f0b429;outline-offset:3px}
    .sn-other-icon{display:grid;place-items:center;flex:none;width:34px;height:34px;border-radius:9px;background:#e2f5eb;color:#08745a}
    .sn-other-title{display:block;font-size:14px;font-weight:850;line-height:1.35;color:#075b49}
    .sn-other-desc{display:block;margin-top:4px;font-size:12px;line-height:1.45;color:#617c73}
    .sn-other-item.is-planned{cursor:default;opacity:.8}
    .sn-other-item.is-planned:hover{transform:none;background:#f8fcf9}
    .sn-other-tag{display:inline-block;margin-top:5px;padding:2px 7px;border-radius:999px;background:#fff3d8;color:#8a5a08;font-size:10px;font-weight:800}
    .sn-other-footer{margin-top:15px;padding-top:13px;border-top:1px solid #e0eee6;font-size:12px;line-height:1.5;color:#617c73}
    @media(max-width:760px){
      .sn-other-wrap{position:static}
      .sn-other-panel{position:absolute;top:calc(100% + 8px);left:12px;right:12px;width:auto;max-height:75vh;overflow:auto;padding:14px}
      .sn-other-grid{grid-template-columns:1fr;gap:8px}
      .sn-other-item{padding:11px}
    }
</style>

<div class="sn-other-wrap" data-sn-other>
    <button class="sn-other-trigger" type="button" aria-expanded="false" aria-controls="sn-other-panel" data-sn-other-trigger>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        Other
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-sn-chevron><path d="m6 9 6 6 6-6"/></svg>
    </button>

    <div class="sn-other-panel" id="sn-other-panel" data-sn-other-panel hidden>
        <p class="sn-other-heading">Informasi & Kesiapsiagaan Bencana</p>
        <div class="sn-other-grid">
            <a class="sn-other-item" href="{{ url('/maps') }}">
                <span class="sn-other-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3z"/><path d="M9 3v15M15 6v15"/></svg></span>
                <span><span class="sn-other-title">Zona Rawan & Evakuasi</span><span class="sn-other-desc">Buka peta untuk melihat wilayah dan informasi lokasi yang tersedia.</span></span>
            </a>
            <a class="sn-other-item" href="{{ url('/risk-check') }}">
                <span class="sn-other-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 22 20H2L12 3Z"/><path d="M12 9v5M12 17h.01"/></svg></span>
                <span><span class="sn-other-title">Cek Risiko Rumah</span><span class="sn-other-desc">Periksa informasi risiko rumah melalui halaman Cek Risiko.</span></span>
            </a>

            <a href="{{ route('informasi-banjir') }}" class="sn-other-item">
                <span class="sn-other-icon">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <path d="M3 11 12 3l9 8v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>
                        <path d="M9 21v-7h6v7"/>
                    </svg>
                </span>

                <span>
                    <span class="sn-other-title">Informasi Bencana Banjir</span>
                    <span class="sn-other-desc">
                        Informasi penyebab, dampak, tanda bahaya, dan langkah kesiapsiagaan banjir.
                    </span>
                    <span class="sn-other-tag">Lihat Informasi</span>
                </span>
            </a>

            <div class="sn-other-item is-planned" aria-disabled="true">
                <span class="sn-other-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 18 6-6 4 3 8-9"/><path d="M14 6h7v7"/></svg></span>
                <span><span class="sn-other-title">Informasi Tanah Longsor</span><span class="sn-other-desc">Informasi tanda awal, faktor risiko, dan tindakan saat terjadi longsor.</span><span class="sn-other-tag">Halaman belum dibuat</span></span>
            </div>
            <div class="sn-other-item is-planned" aria-disabled="true">
                <span class="sn-other-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19V5M4 19h17"/><path d="m7 15 4-4 3 2 5-7"/></svg></span>
                <span><span class="sn-other-title">Statistik Kejadian</span><span class="sn-other-desc">Ringkasan kejadian dan statistik bencana saat sumber data tersedia.</span><span class="sn-other-tag">Menunggu data</span></span>
            </div>
            <div class="sn-other-item is-planned" aria-disabled="true">
                <span class="sn-other-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg></span>
                <span><span class="sn-other-title">Panduan Kesiapsiagaan</span><span class="sn-other-desc">Langkah persiapan sebelum, saat, dan setelah bencana.</span><span class="sn-other-tag">Halaman belum dibuat</span></span>
            </div>
            <div class="sn-other-item is-planned" aria-disabled="true">
                <span class="sn-other-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 5h18v14H3z"/><path d="m3 7 9 6 9-6"/></svg></span>
                <span><span class="sn-other-title">Berita Kebencanaan</span><span class="sn-other-desc">Informasi dan kabar kebencanaan setelah sumber berita ditentukan.</span><span class="sn-other-tag">Menunggu sumber data</span></span>
            </div>
            <a class="sn-other-item" href="{{ url('/report') }}">
                <span class="sn-other-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 21V4"/><path d="M5 4c5-3 9 3 14 0v11c-5 3-9-3-14 0"/></svg></span>
                <span><span class="sn-other-title">Laporkan Kejadian</span><span class="sn-other-desc">Buka halaman Report untuk mengisi formulir pelaporan.</span></span>
            </a>
        </div>
        <div class="sn-other-footer">Menu berlabel “Halaman belum dibuat” atau “Menunggu data” adalah penanda rancangan, bukan tautan aktif. Fitur dan data akan diaktifkan setelah halaman atau sumbernya tersedia.</div>
    </div>
</div>

<script>
(function () {
    const root = document.currentScript && document.currentScript.previousElementSibling;
    const wrap = root && root.matches('[data-sn-other]') ? root : document.querySelector('[data-sn-other]');
    if (!wrap || wrap.dataset.snInitialized === 'true') return;
    wrap.dataset.snInitialized = 'true';
    const trigger = wrap.querySelector('[data-sn-other-trigger]');
    const panel = wrap.querySelector('[data-sn-other-panel]');
    const chevron = wrap.querySelector('[data-sn-chevron]');
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
    panel.addEventListener('click', function (event) {
        if (event.target.closest('a')) closeMenu();
    });
})();
</script>
