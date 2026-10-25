<!DOCTYPE html>
<!-- Tambahkan route di routes/web.php: Route::view('/berita-kebencanaan', 'berita-kebencanaan')->name('berita-kebencanaan'); -->

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Berita Kebencanaan | SiagaNow</title>

<meta name="description" content="Informasi berita kebencanaan SiagaNow. Berita akan ditampilkan setelah sumber informasi yang terverifikasi ditetapkan.">

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

    transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;

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


.stats-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-top:22px}
.stat-card{padding:20px;border:1px solid #d4e9dd;border-radius:16px;background:rgba(255,255,255,.94);box-shadow:0 6px 18px rgba(7,91,73,.06)}
.stat-symbol{display:grid;place-items:center;width:44px;height:44px;border-radius:13px;background:#d9f2e5;color:#075b49;font-size:25px;font-weight:800}
.stat-label{margin:15px 0 7px;color:#648078;font-size:14px;font-weight:750}
.stat-value{margin:0;color:#075b49;font-size:clamp(20px,2.3vw,28px);font-weight:900;line-height:1.25}
.stat-note{margin:9px 0 0;color:#648078;font-size:12px;line-height:1.6}
.data-status{display:flex;gap:14px;align-items:flex-start;margin-top:20px;padding:20px;border:1px solid #e8d9ad;border-radius:15px;background:#fff9e9}
.status-icon{display:grid;place-items:center;flex:0 0 34px;height:34px;border-radius:50%;background:#f4e5b8;color:#805b0a;font-size:20px;font-weight:900}
.data-status h2{margin:1px 0 7px;color:#73510a;font-size:18px}
.data-status p{margin:0;color:#6f613f;font-size:14px;line-height:1.7}
.stats-info-grid{margin-top:20px}
.plain-list{margin:0;padding-left:22px;color:#234c40;line-height:1.8}
@media(max-width:760px){.stats-grid{grid-template-columns:1fr}.data-status{padding:15px}.stat-card{padding:17px}}


/* Tata letak daftar berita mengikuti mockup pengguna */
.news-page{padding:22px 8px 30px}
.news-page-title{margin:0 0 20px;padding:0 14px;color:var(--forest);font-size:clamp(30px,4vw,48px);font-weight:900;letter-spacing:-.8px;line-height:1.15;text-shadow:0 2px 2px #075b4920}
.news-list{display:flex;flex-direction:column;gap:18px}
.news-row{display:grid;grid-template-columns:minmax(230px,31%) minmax(0,1fr);gap:clamp(18px,4vw,48px);align-items:center;padding:10px 14px;border:1px solid rgba(255,255,255,.72);border-radius:14px;background:rgba(226,246,237,.52);box-shadow:0 3px 5px rgba(5,65,50,.22)}
.news-image{display:block;width:100%;height:clamp(150px,14vw,205px);object-fit:cover;border-radius:17px;border:1px solid rgba(7,91,73,.16);box-shadow:0 3px 5px #0002;background:#d9eee4}
.news-detail{min-width:0;display:grid;grid-template-columns:minmax(0,1fr) 36px;align-items:center;gap:12px;padding:12px 14px;border:1px solid rgba(75,112,98,.55);border-radius:15px;background:rgba(255,255,255,.53);box-shadow:0 3px 4px rgba(0,0,0,.2)}
.news-copy{min-width:0}
.news-title{margin:0 0 6px;color:#111;font-size:clamp(17px,1.8vw,22px);font-weight:900;line-height:1.2}
.news-description{margin:0;color:#17231f;font-size:clamp(12px,1.1vw,13px);font-weight:550;line-height:1.35}
.news-meta{display:flex;flex-wrap:wrap;align-items:center;gap:18px;margin-top:12px;color:#15231e;font-size:12px}
.news-meta-item{display:inline-flex;align-items:center;gap:8px}
.news-meta-icon{width:26px;height:26px;display:inline-grid;place-items:center;color:#111;font-size:23px;line-height:1}
.news-arrow{display:grid;place-items:center;color:var(--forest);font-size:56px;font-weight:300;line-height:1}
.news-pagination{display:flex;align-items:center;flex-wrap:wrap;gap:10px;margin:28px 0 0 24px}
.news-page-button{min-width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;padding:0 12px;border:0;border-radius:9px;background:#d6e9e1;color:#102b24;text-decoration:none;font:inherit;font-size:22px;cursor:pointer}
.news-page-button.active{background:var(--forest);color:#fff}
.news-page-button:focus-visible{outline:3px solid #f0b429;outline-offset:3px}
.news-page-ellipsis{padding:0 2px;color:var(--forest);font-weight:900;letter-spacing:3px}
.news-demo-note{margin:0 14px 16px;padding:10px 13px;border-left:4px solid #d99a35;border-radius:7px;background:#fff8e8;color:#6f541d;font-size:12px;line-height:1.5}
@media(max-width:760px){.news-page{padding:15px 0 24px}.news-page-title{padding:0 8px}.news-row{grid-template-columns:1fr;gap:12px;padding:10px}.news-image{height:210px}.news-detail{grid-template-columns:minmax(0,1fr) 26px;padding:12px}.news-arrow{font-size:42px}.news-pagination{margin-left:8px;gap:7px}.news-page-button{min-width:36px;height:38px;font-size:18px}}

</style>

@vite(['resources/css/app.css'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>

<body>

<div class="landscape" aria-hidden="true"></div>

<div class="page-shell">

<header class="site-header-wrap">

<div class="sn-header">

<a href="{{ route('home') }}" class="sn-brand" aria-label="SiagaNow beranda"><span class="sn-brand-symbol" aria-hidden="true">

<svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m3 10 9-7 9 7"/><path d="M5 9v12h14V9"/><path d="M9 21v-7h6v7"/></svg>

</span><span class="sn-brand-copy"><span class="sn-brand-name">SiagaNow</span><span class="sn-brand-caption">Siaga Bencana, Selamat Bersama</span></span></a>

<nav class="sn-navigation" aria-label="Navigasi utama">

<a class="sn-nav" href="{{ route('home') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m3 10 9-7 9 7M5 9v12h14V9"/></svg>Home</a>

<a class="sn-nav" href="{{ route('maps') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>Maps</a>

<a class="sn-nav" href="{{ url('/risk-check') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true"><path d="m12 3 10 18H2L12 3Z"/><path d="M12 9v5M12 17h.01"/></svg>Cek Risiko</a>

<a class="sn-nav" href="{{ route('report') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 22V4"/><path d="M4 4c7-4 9 4 16 0v12c-7 4-9-4-16 0"/></svg>Report</a>

<a class="sn-nav" href="{{ route('donate') }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"/></svg>Donate</a>

<div class="sn-other-wrap" data-sn-other>

<button class="sn-nav sn-other-trigger active" type="button" aria-expanded="false" aria-controls="sn-other-panel" data-sn-other-trigger>

<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>

Other

<svg class="sn-other-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>

</button>

<div class="sn-other-panel" id="sn-other-panel" data-sn-other-panel hidden>

<h2 class="sn-other-panel-heading">Informasi &amp; Kesiapsiagaan Bencana</h2>

<div class="sn-other-grid">

<a href="{{ route('informasi-banjir') }}" class="sn-other-item">
<span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'water', 'size' => 20])</span>
<span><span class="sn-other-title">Informasi Bencana Banjir</span><span class="sn-other-desc">Tanda bahaya dan langkah kesiapsiagaan banjir.</span><span class="sn-other-tag">Lihat Informasi</span></span>
</a>

<a href="{{ route('informasi-longsor') }}" class="sn-other-item"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'mountain', 'size' => 20])</span><span><span class="sn-other-title">Informasi Tanah Longsor</span><span class="sn-other-desc">Tanda awal, faktor risiko, dan tindakan saat terjadi longsor.</span><span class="sn-other-tag">Lihat Informasi</span></span></a>

<a href="{{ route('statistik-kejadian') }}" class="sn-other-item"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'list', 'size' => 20])</span><span><span class="sn-other-title">Statistik Kejadian</span><span class="sn-other-desc">Ringkasan kejadian banjir dan tanah longsor setelah sumber data tersedia.</span><span class="sn-other-tag">Lihat Statistik</span></span></a>

<a href="{{ route('panduan-kesiapsiagaan') }}" class="sn-other-item"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'shield', 'size' => 20])</span><span><span class="sn-other-title">Panduan Kesiapsiagaan</span><span class="sn-other-desc">Panduan persiapan sebelum, saat, dan setelah bencana.</span><span class="sn-other-tag">Lihat Panduan</span></span></a>

<div class="sn-other-item sn-other-current" aria-current="page"><span class="sn-other-icon">@include('partials.siaga-icon', ['name' => 'info', 'size' => 20])</span><span><span class="sn-other-title">Berita Kebencanaan</span><span class="sn-other-desc">Informasi berita setelah sumber terverifikasi ditentukan.</span><span class="sn-other-tag">Sedang dibuka</span></span></div>

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

<main class="content">
<section class="hero-card news-page" aria-labelledby="page-title">
  <h1 class="news-page-title" id="page-title">Semua Berita</h1>
  <p class="news-demo-note"><strong>Feed berita belum terhubung.</strong> SiagaNow tidak menampilkan kartu kejadian contoh sebagai berita aktual. Buka kanal resmi BNPB atau BPBD Sumatera Barat untuk pembaruan terkini.</p>

  <div class="news-list" aria-label="Sumber berita resmi">
    <article class="news-row source-row">
      <div class="news-detail">
        <div class="news-copy">
          <p class="source-kicker">BPBD Provinsi Sumatera Barat</p>
          <h2 class="news-title">Publikasi dan informasi wilayah Sumatera Barat</h2>
          <p class="news-description">Kanal resmi BPBD Sumbar. Periksa tanggal publikasi dan wilayah pada setiap berita sebelum mengambil tindakan.</p>
          <div class="news-meta"><span class="news-meta-item">Sumber pemerintah daerah · tautan eksternal</span></div>
        </div>
        <a class="news-arrow" href="https://bpbd.sumbarprov.go.id/publikasi/berita" target="_blank" rel="noopener noreferrer" aria-label="Buka berita BPBD Sumatera Barat">↗</a>
      </div>
    </article>
    <article class="news-row source-row">
      <div class="news-detail">
        <div class="news-copy">
          <p class="source-kicker">Badan Nasional Penanggulangan Bencana</p>
          <h2 class="news-title">Indeks berita dan perkembangan penanganan</h2>
          <p class="news-description">Kanal berita BNPB nasional. Artikel belum disalin ke SiagaNow karena belum tersedia feed terstruktur yang terverifikasi untuk sinkronisasi.</p>
          <div class="news-meta"><span class="news-meta-item">Sumber resmi BNPB · tautan eksternal</span></div>
        </div>
        <a class="news-arrow" href="https://bnpb.go.id/berita" target="_blank" rel="noopener noreferrer" aria-label="Buka berita BNPB">↗</a>
      </div>
    </article>
  </div>
  <p class="news-source-note">Data kejadian historis BNPB tersedia pada <a href="https://data.bnpb.go.id/dataset/data-bencana-indonesia" target="_blank" rel="noopener noreferrer">Portal Satu Data Bencana</a>. Rekap pada dataset tersebut sampai 2024 dan tidak digunakan sebagai laporan kejadian terkini.</p>
</section>
</main>

<footer class="footer-note">SiagaNow — Berita Kebencanaan</footer>

</div>

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
