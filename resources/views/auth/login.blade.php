<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SiagaNow</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-pages.css') }}">
</head>
<body class="auth-page auth-page--login" data-page="login">
<main class="auth-stage auth-login-stage">
    <section class="auth-login-composition" aria-labelledby="login-title">
        <div class="auth-login-form-panel">
            <h1 id="login-title" class="auth-login-title">Login</h1>

            @if ($errors->any())
                <div class="auth-message auth-message--error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="auth-message auth-message--success" role="status">{{ session('success') }}</div>
            @endif

            @if (session('status'))
                <div class="auth-message auth-message--success" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="auth-login-form">
                @csrf

                <div class="auth-login-field">
                    <label for="email">Email :</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}"
                           required autocomplete="email" placeholder="Masukkan Email Anda">
                </div>

                <label class="auth-remember" for="remember">
                    <input id="remember" type="checkbox" name="remember" value="1" @checked(old('remember'))>
                    <span>Ingat Saya</span>
                </label>

                <div class="auth-login-field auth-password-field">
                    <label for="password">Password :</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                           placeholder="Masukkan Password">
                    <div class="auth-forgot-slot">
                        @if (\Illuminate\Support\Facades\Route::has('password.request'))
                            <a class="auth-forgot-link" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                        @endif
                    </div>
                </div>

                <button type="submit" class="auth-submit auth-submit--login">Login</button>
            </form>
        </div>

        <aside class="auth-welcome-panel" aria-label="Selamat datang di SiagaNow">
            <a class="auth-close" href="{{ route('home') }}" aria-label="Kembali ke beranda">×</a>
            <img class="auth-emblem" src="{{ asset('images/siaganow-nature-emblem.png') }}" alt="Emblem SiagaNow">
            <p class="auth-welcome-eyebrow">Selamat Datang di</p>
            <h2>SiagaNow</h2>
            <p class="auth-welcome-prompt">Belum Punya Akun?</p>
            <a class="auth-signup-link" href="{{ route('register') }}">Sign Up</a>
        </aside>
    </section>
</main>
</body>
</html>
