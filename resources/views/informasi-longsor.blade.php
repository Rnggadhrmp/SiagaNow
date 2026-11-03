<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Tanah Longsor | SiagaNow</title>
    <meta name="description" content="Mengenal tanda dan langkah kesiapsiagaan menghadapi tanah longsor.">
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landslide-page.css') }}">
</head>
<body data-page="landslide">
    @include('partials.site-navbar')

    <main class="ls-main" aria-labelledby="ls-page-title">
        <section class="ls-overview">
            <h1 class="ls-title" id="ls-page-title">
                <span class="ls-title-icon" aria-hidden="true"><img src="{{ asset('images/figma-landslide-title-icon.svg') }}" alt=""></span>
                Mengenal Bencana Tanah Longsor
            </h1>

            <figure class="ls-banner">
                <img src="{{ asset('images/figma-landslide-banner.png') }}" alt="Material longsor di lereng dekat rumah" fetchpriority="high">
            </figure>

            <div class="ls-intro">
                <p>Tanah longsor adalah peristiwa bergeraknya massa tanah, batuan, atau material lainnya menuruni lereng akibat kondisi lereng yang tidak stabil, yang dapat terjadi secara tiba-tiba dan membahayakan manusia serta lingkungan. Bencana ini umumnya dipicu oleh hujan deras, kondisi tanah yang labil, erosi, atau aktivitas manusia seperti penebangan pohon. Tanah longsor dapat menyebabkan kerusakan rumah, jalan, lahan pertanian, serta mengancam keselamatan masyarakat di sekitarnya.</p>
                <img src="{{ asset('images/figma-landslide-info-art.png') }}" alt="" aria-hidden="true">
            </div>
        </section>

        <div class="ls-lower-grid">
            <div class="ls-left-column">
                <section class="ls-panel ls-actions" aria-labelledby="ls-actions-title">
                    <div class="ls-panel-heading ls-actions-heading">
                        <img src="{{ asset('images/figma-landslide-action-heading.png') }}" alt="" aria-hidden="true">
                        <h2 id="ls-actions-title">Apa yang harus dilakukan ketika Terjadi Tanah Longsor?</h2>
                    </div>
                    <ul class="ls-action-list">
                        <li>Segera evakuasi ke tempat yang lebih aman dan menjauh dari lereng.</li>
                        <li>Jika berada di dalam rumah dan mendengar suara gemuruh, segera keluar menuju tempat yang lapang dan jauh dari arah longsoran.</li>
                        <li>Jika berada di luar, jauhi lereng, tebing, dan aliran material longsor.</li>
                    </ul>
                </section>

                <section class="ls-panel ls-before" aria-labelledby="ls-before-title">
                    <div class="ls-panel-heading ls-before-heading">
                        <img src="{{ asset('images/figma-landslide-pre-disaster-heading.png') }}" alt="" aria-hidden="true">
                        <span class="ls-megaphone" aria-hidden="true"><img src="{{ asset('images/figma-landslide-pre-icon.svg') }}" alt=""></span>
                        <h2 id="ls-before-title">Pra-Bencana</h2>
                    </div>
                    <ul class="ls-number-list">
                        <li>Ketahui apakah rumah atau lingkungan berada di dekat lereng/tebing yang rawan.</li>
                        <li>Waspadai retakan tanah, pohon atau tiang yang miring, serta munculnya rembesan air di lereng.</li>
                        <li>Hindari menebang pohon sembarangan dan tanam vegetasi yang memiliki akar kuat.</li>
                    </ul>
                </section>
            </div>

            <section class="ls-panel ls-tips" aria-labelledby="ls-tips-title">
                <div class="ls-panel-heading ls-tips-heading">
                    <img src="{{ asset('images/figma-landslide-tips-heading.png') }}" alt="" aria-hidden="true">
                    <h2 id="ls-tips-title">Tips Mitigasi</h2>
                </div>
                <ul class="ls-number-list">
                    <li>Kenali daerah rawan longsor di sekitar tempat tinggal.</li>
                    <li>Tanam pohon atau vegetasi berakar kuat untuk membantu memperkuat tanah.</li>
                    <li>Jaga saluran air tetap bersih agar air tidak menggenang di lereng.</li>
                    <li>Hindari memotong atau menggali lereng secara sembarangan.</li>
                    <li>Perhatikan retakan pada tanah atau bangunan sebagai tanda awal longsor.</li>
                    <li>Siapkan jalur dan tempat evakuasi yang aman, serta tas siaga bencana berisi kebutuhan penting.</li>
                    <li>Pantau informasi cuaca dan peringatan dini, terutama saat hujan deras. Segera mengungsi jika kondisi lereng menunjukkan tanda-tanda longsor.</li>
                </ul>
                <img class="ls-tips-art" src="{{ asset('images/figma-landslide-pre-disaster-art.png') }}" alt="" aria-hidden="true">
            </section>
        </div>
    </main>

    <footer class="ls-footer">SiagaNow — Kesiapsiagaan Bencana Tanah Longsor</footer>
</body>
</html>
