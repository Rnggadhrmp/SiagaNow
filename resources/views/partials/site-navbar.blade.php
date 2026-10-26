@php
    $isHome = request()->routeIs('home');
    $isMaps = request()->routeIs('maps*');
    $isRisk = request()->routeIs('risk-check*');
    $isReport = request()->routeIs('report*');
    $isDonate = request()->routeIs('donate*');
    $isProfile = request()->routeIs('profil*');
    $isOther = request()->routeIs('informasi-*', 'statistik-kejadian*', 'panduan-kesiapsiagaan*', 'berita-kebencanaan*');
@endphp

<header class="sn-site-header">
    <a class="sn-site-brand {{ $isHome ? 'sn-site-brand--home' : '' }}" href="{{ route('home') }}" aria-label="SiagaNow — Siaga Bencana, Selamat Bersama">
        <img src="{{ asset('images/siaganow-nature-emblem.png') }}" alt="Lambang SiagaNow">
        <span class="sn-site-brand-copy">
        @if ($isHome)
            <span class="sn-site-brand-welcome">Selamat Datang di</span>
        @endif
            <span class="sn-site-brand-name">SiagaNow</span>
            <span class="sn-site-brand-tagline">Siaga Bencana, Selamat Bersama</span>
        </span>
    </a>

    <nav class="sn-site-navigation" aria-label="Navigasi utama">
        <a class="sn-site-nav-link {{ $isHome ? 'is-active' : '' }}" href="{{ route('home') }}" @if($isHome) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 10 9-7 9 7M5 9v12h14V9M9 21v-7h6v7"/></svg>Home
        </a>
        <a class="sn-site-nav-link {{ $isMaps ? 'is-active' : '' }}" href="{{ route('maps') }}" @if($isMaps) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3zM9 3v15M15 6v15"/></svg>Maps
        </a>
        <a class="sn-site-nav-link {{ $isRisk ? 'is-active' : '' }}" href="{{ route('risk-check') }}" @if($isRisk) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 10 18H2L12 3ZM12 9v5M12 17h.01"/></svg>Cek Risiko
        </a>
        <a class="sn-site-nav-link {{ $isReport ? 'is-active' : '' }}" href="{{ route('report') }}" @if($isReport) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 22V4M4 5c7-4 9 4 16 0v12c-7 4-9-4-16 0"/></svg>Report
        </a>
        <a class="sn-site-nav-link {{ $isDonate ? 'is-active' : '' }}" href="{{ route('donate') }}" @if($isDonate) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"/></svg>Donate
        </a>
        <div class="sn-site-other {{ $isOther ? 'is-active' : '' }}">
            @include('partials.other-menu')
        </div>
        @auth
            <a class="sn-site-nav-link {{ $isProfile ? 'is-active' : '' }}" href="{{ route('profil') }}" @if($isProfile) aria-current="page" @endif>Profil</a>
            <form action="{{ route('logout') }}" method="POST" class="sn-site-logout-form">
                @csrf
                <button class="sn-site-nav-link" type="submit">Keluar</button>
            </form>
        @else
            <a class="sn-site-nav-link {{ request()->routeIs('login') ? 'is-active' : '' }}" href="{{ route('login') }}">Masuk</a>
            <a class="sn-site-nav-link {{ request()->routeIs('register') ? 'is-active' : '' }}" href="{{ route('register') }}">Daftar</a>
        @endauth
    </nav>
</header>
