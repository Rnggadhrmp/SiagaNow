<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi | SiagaNow</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-pages.css') }}">
</head>
<body class="auth-page auth-page--register" data-page="register">
<main class="auth-stage auth-register-stage">
    <div class="auth-register-layout">
        <section class="auth-register-information" aria-labelledby="register-intro-title">
            <div class="auth-register-headline">
                <h1 id="register-intro-title">Satu Akun Untuk Aksi yang lebih cepat.</h1>
            </div>

            <p class="auth-register-description">
                Pantau informasi banjir dan tanah longsor, temukan lokasi penting di sekitar Anda, dan bantu tingkatkan
                kesiapsiagaan bencana bersama SiagaNow.
            </p>

            <ul class="auth-benefits" aria-label="Manfaat SiagaNow">
                <li class="auth-benefit">
                    <img src="{{ asset('images/auth-benefit-home.svg') }}" alt="" aria-hidden="true">
                    <span>
                        <strong>Pantauan Personal</strong>
                        <small>Pantau rumah anda apakah aman atau tidak</small>
                    </span>
                </li>
                <li class="auth-benefit">
                    <img src="{{ asset('images/auth-benefit-home.svg') }}" alt="" aria-hidden="true">
                    <span>
                        <strong>Akses Zona Aman</strong>
                        <small>Temukan Zona aman dan shelter terdekat</small>
                    </span>
                </li>
                <li class="auth-benefit">
                    <img src="{{ asset('images/auth-benefit-home.svg') }}" alt="" aria-hidden="true">
                    <span>
                        <strong>Terhubung Dengan Komunitas</strong>
                        <small>Laporkan Kondisi dan dukung respons bersama.</small>
                    </span>
                </li>
            </ul>
        </section>

        <section class="auth-register-panel" aria-labelledby="register-title">
            <h1 id="register-title">Buat Akun Baru</h1>

            @if ($errors->any())
                <div class="auth-message auth-message--error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="auth-register-form">
                @csrf

                <div class="auth-register-fields">
                    <div class="auth-register-field">
                        <label for="name">Nama :</label>
                        <input id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                               placeholder="Masukan Nama Lengkap">
                    </div>

                    <div class="auth-register-field">
                        <label for="phone">Nomor Telepon :</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required autocomplete="tel"
                               placeholder="Ex : 08xxxxxxxxxx">
                    </div>

                    <div class="auth-register-field auth-register-field--wide">
                        <label for="email">Email :</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                               placeholder="Masukan Email Anda">
                    </div>

                    <div class="auth-register-field auth-register-field--wide auth-address-field">
                        <label for="address">Wilayah Domisili :</label>
                        <input id="address" name="address" value="{{ old('address') }}" required autocomplete="street-address"
                               placeholder="Pilih Wilayah Anda">
                        <span class="auth-address-chevron" aria-hidden="true"></span>
                    </div>

                    <div class="auth-register-field auth-register-field--wide">
                        <label for="password">Password :</label>
                        <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password"
                               placeholder="Minimal 8 Karakter">
                    </div>

                    <div class="auth-register-field auth-register-field--wide">
                        <label for="password_confirmation">Konfirmasi Password :</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8"
                               autocomplete="new-password" placeholder="Masukan Kembali Password">
                    </div>
                </div>

                <label class="auth-terms" for="terms">
                    <input id="terms" type="checkbox" name="terms" value="1" required @checked(old('terms'))>
                    <span>Saya Menyetujui Syarat Layanan Dan Ketentuan Privasi</span>
                </label>

                <button type="submit" class="auth-submit auth-submit--register">Daftar Sekarang</button>
            </form>

            <div class="auth-or-divider" aria-hidden="true"><span>Atau Lanjutkan Dengan</span></div>

            <button class="auth-google-button" type="button" disabled aria-label="Google sign-up belum tersedia">
                <img src="{{ asset('images/auth-google-g.svg') }}" alt="" aria-hidden="true">
                <span>Google</span>
                <small>Belum tersedia</small>
            </button>

            <p class="auth-login-prompt">
                <span>Sudah Punya Akun?</span>
                <a href="{{ route('login') }}">Masuk Di Sini</a>
            </p>
        </section>
    </div>
</main>
</body>
</html>
