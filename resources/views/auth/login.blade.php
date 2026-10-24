<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SiagaNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-emerald-50 text-emerald-950">
<div class="fixed inset-0 -z-0">
    <img src="{{ asset('images/siaganow-bg.png') }}"
         alt=""
         class="h-full w-full object-cover">
    <div class="absolute inset-0 bg-emerald-950/25"></div>
</div>

<main class="relative z-10 flex min-h-screen items-center justify-center p-5">
    <section class="grid w-full max-w-4xl overflow-hidden rounded-3xl bg-white/95 shadow-2xl md:grid-cols-2">
        <div class="flex flex-col justify-center bg-emerald-900 p-8 text-white md:p-10">
            <a href="{{ route('home') }}" class="text-2xl font-black">Siaga<span class="text-orange-400">Now</span></a>
            <p class="mt-2 text-sm text-emerald-100">Siaga Bencana, Selamat Bersama</p>

            <h1 class="mt-12 text-3xl font-black leading-tight">
                Bersama Lebih Siaga Menghadapi Bencana
            </h1>
            <p class="mt-4 text-sm leading-7 text-emerald-100">
                Akses informasi kesiapsiagaan, peta kebencanaan,
                dan layanan SiagaNow melalui akunmu.
            </p>
        </div>

        <div class="p-7 md:p-10">
            <h2 class="text-2xl font-extrabold">Selamat Datang</h2>
            <p class="mt-2 text-sm text-slate-500">Masuk ke akun SiagaNow.</p>

            @if ($errors->any())
                <div class="mt-5 rounded-xl bg-red-50 p-3 text-sm text-red-700" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="mt-5 rounded-xl bg-emerald-50 p-3 text-sm text-emerald-800" role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('status'))
                <div class="mt-5 rounded-xl bg-emerald-50 p-3 text-sm text-emerald-800" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}" required autocomplete="email"
                           class="w-full rounded-xl border border-emerald-100 bg-white px-4 py-3 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-100"
                           placeholder="nama@email.com">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold">Password</label>
                    <input id="password" name="password" type="password"
                           required autocomplete="current-password"
                           class="w-full rounded-xl border border-emerald-100 bg-white px-4 py-3 outline-none transition focus:border-emerald-700 focus:ring-2 focus:ring-emerald-100"
                           placeholder="Masukkan password">
                    <div class="mt-2 flex justify-end">
                        <a href="{{ url('/forgot-password') }}"
                           class="text-sm font-semibold text-emerald-800 hover:text-emerald-950 hover:underline">
                            Lupa sandi?
                        </a>
                    </div>
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1"
                           class="rounded border-emerald-300 focus:ring-emerald-700">
                    Ingat Saya
                </label>

                <button type="submit"
                        class="w-full rounded-xl bg-emerald-900 px-4 py-3 font-bold text-white transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:ring-offset-2">
                    Masuk
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-emerald-800 hover:underline">
                    Daftar sekarang
                </a>
            </p>

            <a href="{{ route('home') }}" class="mt-5 block text-center text-sm text-slate-500 hover:text-emerald-800 hover:underline">
                ← Kembali ke beranda
            </a>
        </div>
    </section>
</main>
</body>
</html>
