<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $article->title }} · SiagaNow</title>
    <meta name="description" content="{{ $article->summary }}">
    <link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
    <style>
        body { margin: 0; background: #d9eee2; color: #123d35; font: 16px/1.75 "Poppins", "Segoe UI", Arial, sans-serif; }
        .shell { box-sizing: border-box; width: min(1680px, calc(100% - 80px)); max-width: 1680px; margin: auto; padding: 20px; }
        .article { margin-top: 24px; padding: clamp(24px, 4vw, 64px); background: #eff8f2; border: 1px solid #cfe3d8; border-radius: 14px; }
        .article h1 { font-size: clamp(28px, 3.2vw, 52px); line-height: 1.2; color: #075c49; }
        .meta { color: #526f65; }
        .article img { display: block; width: 100%; max-height: min(62vh, 720px); object-fit: cover; margin: 26px 0; }
        .body { white-space: pre-line; }
        .source { padding: 14px; background: #d9f0e5; border-left: 4px solid #0b795d; }
        .return { display: inline-flex; min-height: 48px; align-items: center; gap: 9px; padding: 9px 16px; border: 1px solid #b9d9c8; border-radius: 10px; background: #e7f3eb; color: #063e32; font-weight: 700; text-decoration: none; box-shadow: 0 2px 0 rgba(6,62,50,.14); transition: background .16s ease, transform .16s ease; }
        .return:hover { background: #ccEFde; transform: translateY(-1px); }
        .return:focus-visible { outline: 3px solid #b76e35; outline-offset: 3px; }
        @media (max-width: 760px) {
            .shell { width: calc(100% - 24px); padding: 12px 0; }
            .article { margin-top: 14px; padding: 20px; }
            .article img { max-height: 42vh; }
        }
    </style>
</head>
<body data-page="news">
    <div class="shell">
        @include('partials.site-navbar')
        <main class="article">
            <a class="return" href="{{ route('berita-kebencanaan') }}"><span aria-hidden="true">←</span><span>Kembali ke berita</span></a>
            <p class="meta">{{ $article->category }} · {{ $article->published_at?->format('d M Y') }} · @if($article->is_simulation)Data Simulasi @else{{ $article->source_name ?? 'Sumber tidak dicantumkan' }}@endif</p>
            <h1>{{ $article->title }}</h1>
            <p><strong>{{ $article->summary }}</strong></p>
            @if($article->image_path)
                <img src="{{ asset('storage/'.$article->image_path) }}" alt="{{ $article->image_alt }}">
            @endif
            <div class="body">{{ $article->body }}</div>
            @if(!$article->is_simulation && $article->source_url)
                <p class="source">Sumber: <a href="{{ $article->source_url }}" target="_blank" rel="noopener noreferrer">{{ $article->source_name }}</a></p>
            @endif
        </main>
    </div>
</body>
</html>
