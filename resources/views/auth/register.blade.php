
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi | SiagaNow</title>
@vite(['resources/css/app.css'])
<link rel="stylesheet" href="{{ asset('css/siaganow-design.css') }}">
</head>
<body class="min-h-screen bg-emerald-50 text-emerald-950">
<div class="fixed inset-0 -z-0">
    <img src="{{ asset('images/siaganow-bg.png') }}"
         alt=""
         class="h-full w-full object-cover">
    <div class="absolute inset-0 bg-emerald-950/25"></div>
</div>

<main class="relative z-10 flex min-h-screen items-center justify-center p-5">
    <section class="grid w-full max-w-5xl overflow-hidden rounded-3xl bg-white/95 shadow-2xl md:grid-cols-5">
        <div class="flex flex-col justify-center bg-emerald-900 p-8 text-white md:col-span-2">
            <a href="/" class="text-2xl font-black">Siaga<span class="text-orange-400">Now</span></a>
            <h1 class="mt-10 text-3xl font-black">Mulai Bersama SiagaNow</h1>
            <p class="mt-4 text-sm leading-7 text-emerald-100">
                Buat akun untuk mengakses layanan yang memerlukan autentikasi
                dan mendukung kesiapsiagaan bencana.
            </p>
        </div>

        <div class="p-7 md:col-span-3 md:p-10">
            <h2 class="text-2xl font-extrabold">Buat Akun</h2>
            <p class="mt-2 text-sm text-slate-500">Lengkapi data diri kamu.</p>

            @if ($errors->any())
                <div class="mt-5 rounded-xl bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}"
                  class="mt-6 grid gap-4 sm:grid-cols-2">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold">Nama lengkap</label>
                    <input id="name" name="name" value="{{ old('name') }}"
                           required autocomplete="name"
                           class="w-full rounded-xl border border-emerald-100 px-4 py-3 outline-none focus:border-emerald-700">
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-semibold">Nomor telepon</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                           required autocomplete="tel"
                           class="w-full rounded-xl border border-emerald-100 px-4 py-3 outline-none focus:border-emerald-700">
                </div>

                <div class="sm:col-span-2">
                    <label for="email" class="mb-2 block text-sm font-semibold">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}"
                           required autocomplete="email"
                           class="w-full rounded-xl border border-emerald-100 px-4 py-3 outline-none focus:border-emerald-700">
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="mb-2 block text-sm font-semibold">Domisili</label>
                    <input id="address" name="address" value="{{ old('address') }}"
                           required autocomplete="street-address"
                           class="w-full rounded-xl border border-emerald-100 px-4 py-3 outline-none focus:border-emerald-700"
                           placeholder="Kabupaten/kota, provinsi">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold">Password</label>
                    <input id="password" name="password" type="password"
                           required minlength="8" autocomplete="new-password"
                           class="w-full rounded-xl border border-emerald-100 px-4 py-3 outline-none focus:border-emerald-700">
                    <p class="mt-1 text-xs text-slate-500">Minimal 8 karakter.</p>
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold">Konfirmasi password</label>
                    <input id="password_confirmation" name="password_confirmation"
                           type="password" required minlength="8" autocomplete="new-password"
                           class="w-full rounded-xl border border-emerald-100 px-4 py-3 outline-none focus:border-emerald-700">
                </div>

                <label class="flex items-start gap-2 text-sm leading-6 text-slate-600 sm:col-span-2">
                    <input type="checkbox" name="terms" value="1" required
                           class="mt-1 rounded border-emerald-300">
                    Saya menyetujui ketentuan layanan SiagaNow.
                </label>

                <button type="submit"
                        class="rounded-xl bg-emerald-900 px-4 py-3 font-bold text-white hover:bg-emerald-800 sm:col-span-2">
                    Daftar Sekarang
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-emerald-800 hover:underline">
                    Masuk
                </a>
            </p>

            <a href="/" class="mt-4 block text-center text-sm text-slate-500 hover:underline">
                ← Kembali ke beranda
            </a>
        </div>
    </section>
</main>
</body>
</html>
