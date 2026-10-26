<!DOCTYPE html>

<!-- Tambahkan route: Route::view('/informasi-longsor', 'informasi-longsor')->name('informasi-longsor'); -->



<html lang="id">



<head>



<meta charset="UTF-8">



<meta name="viewport" content="width=device-width, initial-scale=1.0">



<title>Informasi Tanah Longsor | SiagaNow</title>



<meta name="description" content="Panduan edukasi tanah longsor dan kesiapsiagaan dari SiagaNow.">



<style>



:root{--forest:#075b49;--dark:#064b3d;--line:#cfe3d8;--ink:#153f36;--main:#0b795d;--soft:#d9f0e5;--pale:#eff8f2;--text:#123d35;--muted:#648078}



*{box-sizing:border-box}



body{margin:0;color:#173d34;font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:radial-gradient(ellipse at 12% 0%,rgba(189,231,216,.9) 0,transparent 35%),linear-gradient(145deg,#e5f5ec,#f8fbf8 55%,#c5e8d8)}



.landscape{position:fixed;inset:0;z-index:-1;background:radial-gradient(ellipse at 12% 0%,rgba(189,231,216,.7) 0,transparent 35%),linear-gradient(145deg,#e5f5ec,#b8e0cf 55%,#75bda0)}



.page-shell{min-height:100vh;padding:20px 16px 42px}



.sn-header{box-sizing:border-box;width:100%;max-width:1440px;margin:0 auto 24px;padding:13px 20px;display:flex;justify-content:space-between;align-items:center;gap:22px;flex-wrap:wrap;border:1px solid rgba(255,255,255,.72);border-radius:19px;background:rgba(238,250,243,.92);box-shadow:0 8px 28px rgba(12,83,64,.09);backdrop-filter:blur(12px);position:relative;z-index:1300}



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



.sn-other-current{cursor:default;}

.sn-other-current:hover{background:#f8fcf9;transform:none;}

.sn-other-item{display:flex;align-items:flex-start;gap:12px;min-width:0;padding:13px;border:0;border-left:4px solid #16a875;border-radius:10px;background:#f8fcf9;color:inherit;text-decoration:none;text-align:left}



a.sn-other-item{cursor:pointer;transition:background .15s ease,transform .15s ease}



a.sn-other-item:hover{background:#edf8f1;transform:translateY(-1px)}



.sn-other-icon{display:grid;place-items:center;flex:0 0 34px;height:34px;border-radius:9px;background:#e2f5eb;color:#08745a;font-size:19px;font-weight:800}



.sn-other-title{display:block;color:var(--forest);font-size:13px;font-weight:850;line-height:1.4}



.sn-other-desc{display:block;margin-top:4px;color:#648078;font-size:11px;line-height:1.55}



.sn-other-tag{display:inline-block;margin-top:6px;padding:3px 7px;border-radius:999px;background:#fff3d8;color:#8a5a08;font-size:9px;font-weight:800}



.sn-other-footer{margin-top:14px;padding-top:12px;border-top:1px solid #e0eee6;color:#648078;font-size:11px;line-height:1.6}



.sn-other-trigger:focus-visible,.sn-other-item:focus-visible{outline:3px solid #f0b429;outline-offset:3px}



.content{max-width:1440px;margin:0 auto}



.hero-card{padding:22px;border:1px solid rgba(255,255,255,.85);border-radius:20px;background:rgba(255,255,255,.92);box-shadow:0 10px 28px rgba(7,91,73,.07)}



.section-title{display:flex;align-items:center;gap:12px;margin:0 0 12px;color:var(--dark);font-size:clamp(23px,3vw,34px);font-weight:850}



.title-icon{width:48px;height:48px;display:grid;place-items:center;border-radius:14px;background:#d0f0e2;font-size:27px;flex-shrink:0}



.flood-banner{min-height:210px;border-radius:12px;display:flex;align-items:flex-end;padding:24px;background:linear-gradient(0deg,#03312bbf,transparent 80%),linear-gradient(135deg,#79c6b4,#d4eee2 45%,#559f91 46%,#247d75 70%,#d7eadd);box-shadow:0 3px 5px #0003}



.banner-caption{color:white;font-size:clamp(22px,3vw,32px);font-weight:900;text-shadow:0 2px 6px #0008}



.intro{margin-top:14px;padding:18px 22px;border:1px solid #d2e9de;border-radius:12px;background:linear-gradient(110deg,#e7f8effa,#d2f1e2eb);font-size:clamp(16px,1.6vw,20px);line-height:1.55}



.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:20px;align-items:stretch}



.info-card{padding:18px;border:1px solid #ffffffdf;border-radius:14px;background:#e8f9f1f5;box-shadow:0 5px 12px #06463821}



.info-card.white{background:#fffffffa}



.card-heading{min-height:68px;display:flex;align-items:center;gap:10px;margin:0 0 12px;padding:12px 14px;border-radius:10px;color:var(--dark);background:linear-gradient(110deg,#c9efdf,#e8f8ef);font-size:20px;font-weight:850}



.card-heading span{font-size:25px}



.number-list{list-style:none;counter-reset:steps;padding:0;margin:0}



.number-list li{counter-increment:steps;position:relative;padding:4px 0 13px 42px;line-height:1.45}



.number-list li:before{content:counter(steps);position:absolute;left:0;top:1px;width:30px;height:30px;border-radius:50%;display:grid;place-items:center;background:var(--forest);color:white;font-weight:800}



.safety-note{margin-top:20px;padding:16px 18px;border-left:5px solid #d99a35;border-radius:10px;background:#fff7e5;color:#634b1f;line-height:1.5}



.footer-note{text-align:center;color:#f4fff8;margin:24px auto 0;font-size:13px;text-shadow:0 1px 3px #0006}



@media(max-width:1024px){.sn-header{align-items:flex-start}}



@media(max-width:850px){.info-grid{grid-template-columns:1fr}}



@media(max-width:760px){.sn-header{padding:14px;gap:14px}.sn-navigation{width:100%;justify-content:flex-start;gap:7px}.sn-nav{min-height:38px;padding:9px 10px;font-size:11px;gap:5px}.sn-other-panel{left:0;right:auto;width:min(760px,calc(100vw - 24px));padding:15px}.sn-other-grid{grid-template-columns:1fr}}



@media(max-width:520px){.page-shell{padding:12px 10px 28px}.sn-header{padding:12px}.sn-brand-symbol{width:48px;height:48px}.hero-card{padding:12px}.intro{padding:14px}.flood-banner{min-height:165px;padding:16px}.card-heading{font-size:18px}}



.site-header-wrap{width:100%;max-width:1440px;margin:0 auto 24px;padding:0 16px}



.sn-header{flex-wrap:nowrap}



.sn-brand{display:flex;align-items:center;gap:12px;min-width:245px;flex:0 0 auto;color:var(--forest);text-decoration:none!important}



.sn-brand:link,.sn-brand:visited,.sn-brand:hover,.sn-brand:active{color:var(--forest);text-decoration:none!important}



.sn-brand-copy{display:flex;flex-direction:column;gap:4px;min-width:0}



.sn-brand-name{display:block;font-size:30px;font-weight:900;letter-spacing:-.8px;line-height:1;color:var(--forest)}



.sn-brand-caption{display:block;font-size:13px;font-weight:600;line-height:1.3;color:#648078}



.sn-nav:link,.sn-nav:visited{text-decoration:none!important}



.sn-nav.active,.sn-nav[aria-expanded="true"]{background:var(--forest);border-color:var(--forest);color:#fff}



.content{max-width:1440px;margin:0 auto;padding:0 8px}



.flood-banner{position:relative;isolation:isolate;min-height:clamp(260px,34vw,440px);overflow:hidden;align-items:flex-end;padding:clamp(22px,4vw,48px);background:#174f43}



.flood-banner-photo{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 48%;z-index:-2}



.banner-overlay{position:absolute;inset:0;z-index:-1;background:linear-gradient(90deg,rgba(2,42,34,.83) 0%,rgba(2,42,34,.42) 54%,rgba(2,42,34,.08) 100%),linear-gradient(0deg,rgba(2,42,34,.45),transparent 60%)}



.banner-caption{display:flex;flex-direction:column;gap:10px;max-width:760px;color:#fff}



.banner-kicker{font-size:12px;letter-spacing:.18em;font-weight:900;color:#baf3d8}



.banner-title{font-size:clamp(27px,4vw,48px);line-height:1.08;font-weight:900;text-shadow:0 2px 12px #0007}



.banner-subtitle{font-size:clamp(14px,1.5vw,18px);line-height:1.5;font-weight:600;color:#effff7}



.photo-gallery{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px;margin-top:20px}



.photo-card{overflow:hidden;margin:0;border:1px solid #d2e9de;border-radius:16px;background:#fff;box-shadow:0 8px 22px rgba(6,70,56,.09)}



.photo-card img{display:block;width:100%;height:clamp(190px,22vw,300px);object-fit:cover;background:#d8eee4}



.photo-card figcaption{display:flex;flex-direction:column;gap:5px;padding:14px 16px 17px;line-height:1.5}



.photo-card figcaption strong{color:var(--forest);font-size:16px}



.photo-card figcaption span{color:var(--muted);font-size:13px}



.photo-source{margin:10px 2px 0;color:#668278;font-size:11px;line-height:1.5}



@media(max-width:1180px){.sn-header{flex-wrap:wrap}.sn-navigation{width:100%;justify-content:flex-start;flex-wrap:wrap}.sn-brand{min-width:0}}



@media(max-width:850px){.info-grid,.photo-gallery{grid-template-columns:1fr}}



@media(max-width:760px){.site-header-wrap{padding:0 4px}.sn-header{padding:14px;gap:14px;flex-wrap:wrap}.sn-brand-name{font-size:24px}.sn-brand-caption{font-size:11px}.sn-navigation{width:100%;justify-content:flex-start;gap:7px;flex-wrap:wrap}.sn-nav{min-height:38px;padding:9px 10px;font-size:12px;gap:5px}.sn-other-panel{left:0;right:auto;width:min(760px,calc(100vw - 24px));padding:15px}.sn-other-grid{grid-template-columns:1fr}.flood-banner{min-height:280px}}



@media(max-width:520px){.page-shell{padding:12px 10px 28px}.sn-header{padding:12px}.sn-brand-symbol{width:48px;height:48px}.sn-brand-name{font-size:21px}.sn-navigation{gap:6px}.sn-nav{padding:8px 9px;font-size:11px}.hero-card{padding:12px}.intro{padding:14px}.flood-banner{min-height:250px;padding:18px}.banner-title{font-size:29px}.card-heading{font-size:18px}.photo-card img{height:210px}}



/* Navbar disamakan dengan halaman Cek Risiko; konten halaman tidak diubah. */



.site-header-wrap {



    box-sizing: border-box;



    width: 100%;



    max-width: 1440px;



    margin: 0 auto 24px;



    padding: 0;



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



.sn-brand {



    display: flex;



    align-items: center;



    gap: 12px;



    min-width: 245px;



    flex: 0 0 auto;



    color: var(--forest);



    text-decoration: none !important;



}



.sn-brand:link, .sn-brand:visited, .sn-brand:hover, .sn-brand:active {



    color: var(--forest);



    text-decoration: none !important;



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



.sn-brand-copy { display: flex; flex-direction: column; gap: 4px; min-width: 0; }



.sn-brand-name {



    display: block;



    font-size: 30px;



    font-weight: 900;



    letter-spacing: -.8px;



    line-height: 1;



    color: var(--forest);



}



.sn-brand-caption {



    display: block;



    font-size: 13px;



    font-weight: 600;



    line-height: 1.3;



    color: #648078;



}



.sn-nav {



    display: inline-flex;



    align-items: center;



    justify-content: center;



    gap: 8px;



    min-height: 44px;



    padding: 12px 15px;



    border: 1px solid #d1e5da;



    border-radius: 12px;



    background: #fff;



    color: var(--forest);



    text-decoration: none;



    font-family: inherit;



    font-size: 14px;



    font-weight: 700;



    white-space: nowrap;



    cursor: pointer;



    transition: *background* .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;



}



.sn-nav:link, .sn-nav:visited { text-decoration: none !important; }



.sn-nav:hover { background: #e7f6ed; border-color: #b9d9c8; transform: translateY(-1px); }



.sn-nav.active, .sn-nav[aria-expanded="true"] { background: var(--forest); border-color: var(--forest); color: #fff; }



.sn-other-wrap { position: relative; display: inline-flex; align-items: center; }



.sn-other-trigger { font-family: inherit; cursor: pointer; }



.sn-other-chevron { transition: transform .18s ease; flex-shrink: 0; }



@media (max-width: 1024px) {



    .sn-header { align-items: flex-start; }



}



@media (max-width: 1180px) {



    .sn-header { flex-wrap: wrap; }



    .sn-navigation { width: 100%; justify-content: flex-start; flex-wrap: wrap; }



    .sn-brand { min-width: 0; }



}



@media (max-width: 760px) {



    .site-header-wrap { padding: 0; }



    .sn-header { padding: 14px; gap: 14px; flex-wrap: wrap; }



    .sn-brand-name { font-size: 24px; }



    .sn-brand-caption { font-size: 11px; }



    .sn-navigation { width: 100%; justify-content: flex-start; gap: 7px; flex-wrap: wrap; }



    .sn-nav { min-height: 38px; padding: 9px 10px; font-size: 11px; gap: 5px; }



    .sn-other-panel { left: 0; right: auto; width: min(760px, calc(100vw - 24px)); padding: 15px; }



    .sn-other-grid { grid-template-columns: 1fr; }



}



@media (max-width: 520px) {



    .sn-header { padding: 12px; }



    .sn-brand-symbol { width: 48px; height: 48px; }



    .sn-brand-name { font-size: 21px; }



    .sn-navigation { gap: 6px; }



    .sn-nav { padding: 8px 9px; font-size: 11px; }



}



</style>



@vite(['resources/css/app.css'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>



<body data-page="landslide">



<div class="landscape" aria-hidden="true"></div>



<div class="page-shell">



@include('partials.site-navbar')



<main class="content">



<section class="hero-card" aria-labelledby="page-title">



<h1 class="section-title" id="page-title"><span class="title-icon">@include('partials.siaga-icon', ['name' => 'mountain'])</span>Mengenal Bencana Tanah Longsor</h1>



<div class="flood-banner">



<img class="flood-banner-photo" src="{{ asset('images/figma-education-photo-1.png') }}" alt="Ilustrasi rumah di bawah lereng longsor dari mockup SiagaNow; bukan dokumentasi kejadian" loading="eager">



<div class="banner-overlay"></div>



<div class="banner-caption"><span class="banner-kicker">SIAGA LONGSOR</span><span class="banner-title">Kenali Tanda, Jauhi Lereng, Selamatkan Diri</span><span class="banner-subtitle">Kenali langkah aman sebelum, saat, dan setelah tanah longsor.</span></div>



</div>



<div class="photo-gallery" aria-label="Foto dokumentasi bencana tanah longsor">



<figure class="photo-card">



<img src="https://commons.wikimedia.org/wiki/Special:FilePath/Nganjuk_landslide.jpg" alt="Dampak tanah longsor di Kabupaten Nganjuk, Jawa Timur" loading="lazy">



<figcaption><strong>Dampak tanah longsor</strong><span>Material tanah dan bebatuan dapat menimbun rumah, jalan, serta fasilitas umum.</span></figcaption>



</figure>



<figure class="photo-card">



<img src="https://commons.wikimedia.org/wiki/Special:FilePath/Serasan_landslide_aftermath.jpg" alt="Dampak tanah longsor di Pulau Serasan, Kabupaten Natuna" loading="lazy">



<figcaption><strong>Waspadai lereng</strong><span>Hujan deras yang berlangsung lama dapat meningkatkan risiko pergerakan tanah.</span></figcaption>



</figure>



</div>



<p class="photo-source">Ilustrasi dari aset mockup SiagaNow; bukan dokumentasi atau informasi kondisi longsor secara langsung.</p>



<div class="intro">Tanah longsor adalah pergerakan massa tanah, batuan, atau material lain menuruni lereng. Longsor dapat dipicu oleh hujan deras atau berkepanjangan, kondisi lereng yang labil, erosi, serta perubahan tata guna lahan. Peristiwa ini dapat merusak rumah, jalan, dan fasilitas umum serta membahayakan keselamatan. Mengenali tanda awal dan mengetahui jalur evakuasi membantu masyarakat bertindak lebih aman.</div>



</section>



<section class="info-grid" aria-label="Panduan kesiapsiagaan tanah longsor">

<article class="info-card"><h2 class="card-heading"><span>@include('partials.siaga-icon', ['name' => 'warning'])</span>Tanda-Tanda Tanah Longsor</h2><ol class="number-list">

<li>Muncul retakan baru pada tanah, jalan, atau dinding bangunan di sekitar lereng.</li>

<li>Pohon, tiang, pagar, atau bangunan mulai miring atau bergeser.</li>

<li>Air keluar dari lereng atau berubah menjadi keruh setelah hujan.</li>

<li>Terdengar suara gemuruh, atau terlihat guguran tanah dan batu dari lereng.</li>

<li>Jika melihat tanda bahaya, segera menjauh dari lereng dan laporkan kepada aparat setempat.</li>

</ol></article>

<article class="info-card white"><h2 class="card-heading"><span>@include('partials.siaga-icon', ['name' => 'leaf'])</span>Mitigasi Tanah Longsor</h2><ol class="number-list">

<li>Kenali wilayah rawan longsor di sekitar rumah dan jalur yang aman untuk evakuasi.</li>

<li>Hindari memotong kaki lereng atau melakukan penggalian tanpa perencanaan teknis yang sesuai.</li>

<li>Jaga saluran air agar tidak tersumbat dan aliran air tidak terkonsentrasi ke lereng yang rentan.</li>

<li>Ikuti informasi cuaca dan peringatan dari instansi berwenang, terutama saat hujan deras berkepanjangan.</li>

<li>Siapkan tas siaga, dokumen penting, obat pribadi, senter, dan alat komunikasi.</li>

</ol></article>

<article class="info-card"><h2 class="card-heading"><span>@include('partials.siaga-icon', ['name' => 'shield'])</span>Saat Terjadi Longsor</h2><ol class="number-list">

<li>Segera menjauh dari jalur luncuran material dan bergerak ke tempat yang lebih aman jika jalurnya tidak terhalang.</li>

<li>Jangan mendekati lokasi longsor untuk menonton atau mengambil foto.</li>

<li>Hindari menyeberangi timbunan longsor atau jalan yang retak dan tidak stabil.</li>

<li>Hubungi petugas darurat atau aparat setempat jika ada orang yang terancam atau membutuhkan bantuan.</li>

<li>Ikuti arahan evakuasi dan jangan kembali sebelum lokasi dinyatakan aman.</li>

</ol></article>

<article class="info-card white"><h2 class="card-heading"><span>@include('partials.siaga-icon', ['name' => 'shelter'])</span>Setelah Longsor</h2><ol class="number-list">

<li>Waspadai longsor susulan, terutama jika hujan masih berlangsung.</li>

<li>Jauhi bangunan, tebing, dan tiang yang rusak atau tampak tidak stabil.</li>

<li>Jangan memasuki area terdampak sebelum diizinkan petugas.</li>

<li>Laporkan kabel listrik putus, kebocoran gas, atau kerusakan berbahaya tanpa mendekatinya.</li>

<li>Gunakan informasi resmi untuk mengetahui kapan area dapat diakses kembali.</li>

</ol></article>

</section>



<aside class="safety-note"><strong>Catatan keselamatan:</strong> Halaman ini berisi edukasi umum, bukan peringatan tanah longsor secara langsung. Untuk keadaan darurat, menjauhlah dari area berbahaya dan ikuti arahan petugas serta informasi resmi instansi berwenang.</aside>



</main>



<footer class="footer-note">SiagaNow — Kesiapsiagaan Bencana Tanah Longsor</footer>



</div>



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
