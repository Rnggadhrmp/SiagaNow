
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil | SiagaNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-emerald-50 text-emerald-950">

    <header class="bg-emerald-900 px-6 py-5 text-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between">
            <a href="/" class="text-2xl font-black">
                Siaga<span class="text-orange-400">Now</span>
            </a>
            <a href="/" class="text-sm hover:text-emerald-200">
                ← Kembali ke Beranda
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-5 py-10">
        <section class="overflow-hidden rounded-3xl bg-white shadow-lg">

            <div class="bg-emerald-800 px-7 py-8 text-white">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl font-bold text-emerald-800">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Profil Saya</h1>
                        <p class="mt-1 text-sm text-emerald-100">
                            Informasi akun SiagaNow
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-5 p-7">
                <div>
                    <p class="text-sm text-slate-500">Nama Lengkap</p>
                    <p class="mt-1 font-semibold">{{ Auth::user()->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Email</p>
                    <p class="mt-1 font-semibold">{{ Auth::user()->email }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Nomor Telepon</p>
                    <p class="mt-1 font-semibold">
                        {{ Auth::user()->phone ?: 'Belum diisi' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Domisili</p>
                    <p class="mt-1 font-semibold">
                        {{ Auth::user()->address ?: 'Belum diisi' }}
                    </p>
                </div>

                <div class="border-t border-emerald-100 pt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-xl bg-red-600 px-5 py-3 font-bold text-white hover:bg-red-700">
                            Keluar dari Akun
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
