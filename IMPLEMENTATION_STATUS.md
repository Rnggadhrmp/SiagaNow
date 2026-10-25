# Status Implementasi SiagaNow

Pembaruan terakhir: 25 Oktober 2026 — prakiraan BMKG, penyegaran web, smoke test Flutter

## Ringkasan kondisi

Proyek saat ini adalah Laravel 13 dengan PHP 8.3.33. Website sudah memiliki Blade views untuk beranda, autentikasi, peta, pemeriksaan risiko, laporan, donasi, profil, berita, statistik, dan panduan. Skema awal menyediakan akun, shelter, zona bahaya, kejadian, pemeriksaan risiko, serta peringatan cuaca. API Laravel untuk mobile tersedia pada `routes/api.php`; proyek Flutter terpisah tersedia di `D:\laragon\www\SiagaNowMobile`.

Laravel Boost v2.10.3 berhasil ditambahkan ke `composer.json` dan `composer.lock`, package discovery dijalankan, lalu `php artisan boost:install` berhasil. `AGENTS.md` dibaca ulang setelah instalasi dan masih berisi petunjuk bootstrap yang sama; Boost juga menghasilkan konfigurasi/berkas agent yang dicatat pada perubahan.

## Matriks BRD

Status berarti kondisi yang dibuktikan dari kode yang tersedia, bukan penilaian bahwa fitur layak produksi.

| Kebutuhan | Status | Implementasi / bukti | Masalah, prioritas, dan tindak lanjut |
|---|---|---|---|
| BR-01 informasi bencana, cuaca, peringatan | Sebagian | `welcome.blade.php`, `WeatherWarningController.php`, view berita/edukasi | Beranda kini menampilkan cuaca/statistik dan banner peringatan contoh dengan label simulasi; tidak ada feed cuaca aktual. Endpoint BMKG membedakan peringatan, kondisi tidak ditemukan, dan kegagalan. Konten berita adalah contoh yang ditandai belum terverifikasi. |
| BR-02 cek risiko rumah | Sebagian | `RiskCheckController.php`, `RiskAssessment`, view `risk-check` | Titik dapat dipilih, BMKG diperiksa, dan asesmen disimpan sebagai `pending`; tidak ada data risiko terverifikasi atau skor. Keterbatasan sudah dijelaskan dan hasil tidak mengarang skor. Tinggi. |
| BR-03 zona, wilayah terdampak, shelter | Sebagian | `MapsController.php`, tabel `hazard_zones`, `shelters`, `disaster_events`, view `maps` | Peta dasar OSM tersedia. Data zona resmi belum ada. Mode demo kini memberi tiga titik contoh Padang berlabel simulasi saat tabel shelter kosong atau DB gagal; titik tidak diklaim sebagai shelter resmi. |
| BR-04 rute evakuasi (mobile) | Belum tersedia | Tidak ada proyek Flutter | Belum ada perhitungan rute atau UI mobile. Jangan menyebut rute sebagai aman tanpa sumber/kondisi jalur. Tinggi setelah website/API. |
| BR-05 keluarga siaga | Belum tersedia | Tidak ada model/route/proyek Flutter terkait | Pengelolaan anggota, status Aman/Perlu Bantuan, izin lokasi, dan checklist belum tersedia. TBD-10/16 membatasi implementasi final. |
| BR-06 laporan bencana | Sebagian | `DisasterReportController`, `DisasterReport`, migration aditif, `report.blade.php` | Form menyimpan laporan autentikasi dan lampiran privat, status awal `submitted`; belum ada review admin/status lanjutan. Migration sudah diterapkan ke MySQL lokal setelah pemeriksaan skema. |
| BR-07 pemantauan status laporan | Sebagian | Route `/report/status` dan view `report-status.blade.php` | Pengguna hanya melihat laporan miliknya. Status awal tersedia; perubahan oleh petugas/admin belum tersedia karena role/dashboard belum dirancang. |
| BR-08 donasi dan transaksi | Sebagian | `donate.blade.php`, config demo | Dua program contoh tersedia pada Mode Demo dengan progres hitung otomatis, label simulasi, pencarian, dan tombol pembayaran nonaktif. Tidak ada model kampanye/transaksi atau payment gateway nyata. |
| BR-09 layanan darurat/kontak | Belum tersedia | Tidak ada implementasi mobile | Sumber kontak perlu diverifikasi per lokasi; bukan sekadar nomor dummy. |
| BR-10 pengelolaan admin | Belum tersedia | Tidak ada dashboard/policy admin | Peran dan dashboard belum ditentukan (TBD-12/di luar ruang lingkup mockup). Lindungi route admin bila ditambahkan. |
| BR-11 akurasi dan konsistensi | Sebagian | Model shelter menyimpan `source`/`verified_at`; config demo terpusat | Label simulasi ada pada beranda/peta, belum diseragamkan pada seluruh halaman dan platform. |
| BR-12 keamanan dan hak akses | Sebagian | Middleware `auth` untuk risk/report/donate; hashing dan regenerasi sesi di `AuthController` | Edukasi, berita, statistik, panduan dan katalog donasi sekarang publik sesuai BRD; tindakan/profil tetap dibatasi login. Belum ada role/policy. Audit ownership endpoint lanjutan. |
| BR-13 kegagalan proses dijelaskan | Sebagian | API BMKG membedakan `unknown`, `warning_found`, `no_warning_found`; UI cek risiko menangani loading/error | Fallback peta/cuaca/statistik demo terkonfigurasi; pencarian/geocoding eksternal dapat gagal dan belum ada fallback semua halaman. |
| Autentikasi website (FR-WEB-01—05) | Sebagian | Login/register/logout, validasi, remember-me, middleware | Belum ada username login/Google/pemulihan kata sandi/admin. Register mencakup telepon, domisili, persetujuan dan password minimum 8. |
| Beranda dan info (FR-WEB-06—07) | Sebagian | `welcome.blade.php` dan peta mini | UI menyatakan sumber resmi belum terhubung; statistik/cuaca tidak terintegrasi. Audit visual seluruh halaman masih berjalan. |
| Peta dan pemeriksaan (FR-WEB-08—10) | Sebagian | Leaflet + OSM, pencarian shelter API, asesmen tersimpan | Zona tidak tampil dan rute geocoding memakai Nominatim dari browser; perlindungan privasi/rate limit belum ada. Skor memang tidak diklaim. |
| Berita dan edukasi (FR-WEB-11—13) | Sebagian | View daftar berita, banjir, longsor, panduan | Konten statis, belum ada sumber/update timestamp dan belum ada detail berita dinamis. |
| Pelaporan website (FR-WEB-15—18) | Sebagian | Form, controller, tabel `disaster_reports`, disk lokal privat, halaman status | Validasi, simpan, lampiran, dan status milik sendiri sudah berjalan pada SQLite test. Review petugas dan status lanjutan belum tersedia. |
| Donasi website (FR-WEB-19—23) | Sebagian | Halaman daftar/pencarian kosong | Kampanye, kalkulasi dan payment belum tersedia; tidak ada transaksi dummy yang diklaim nyata. |
| Flutter mobile (FR-MOB-01—30) | Sebagian | `D:\laragon\www\SiagaNowMobile`: beranda, pemuatan API, peta/shelter, form laporan, login token, navigasi layanan | Belum ada emulator/perangkat; rute navigasi aktual, Keluarga Siaga, donasi, kontak terverifikasi, dan pendaftaran dari app belum tersedia. |
| Admin (FR-ADM-01—06) | Belum tersedia | Tidak ada modul admin | Butuh perancangan role/policy dan antarmuka; jangan memberi akses berdasar UI saja. |

## Integrasi, data, dan database

- Peta memakai tile OpenStreetMap dan Leaflet dari CDN. Geocoding cek risiko memakai Nominatim; geolokasi browser meminta izin. Ketergantungan eksternal dapat gagal tanpa koneksi.
- `config/siaganow.php` menyediakan sakelar `SIAGANOW_DEMO_MODE` (default `true`), lokasi simulasi Padang, cuaca/statistik dan program donasi contoh. Atur `SIAGANOW_DEMO_MODE=false` untuk mematikan fallback. Data contoh tidak masuk database dan memiliki label simulasi. Banner peringatan homepage adalah contoh tampilan, bukan peringatan aktif. Tombol donasi contoh nonaktif.
- Endpoint pencarian memberi `data_type` dan `source`; UI memberi label simulasi. Shelter dari tabel ditampilkan dengan metadata sumber/status verifikasi bila tersedia.
- Endpoint `/api/weather-warning` mengambil feed `https://www.bmkg.go.id/alerts/nowcast/id`, mengurai RSS/XML dan CAP detail, membatasi timeout, cache 2 menit, menyimpan CAP, serta menguji titik terhadap poligon. Hasil kosong dapat berarti `unknown` bila detail/geometry gagal. Feed hanya nowcast cuaca, bukan penilaian banjir/longsor.
- `routes/api.php` menyediakan 10 endpoint: register/login, home/news/shelters/weather-warning dan endpoint user/logout/reports ber-token Sanctum. CORS dibatasi ke localhost/127.0.0.1 untuk port development. Token bernama mobile berumur 30 hari; route privat memakai `auth:sanctum` dan ability `mobile`.
- Default fallback pada `config/database.php` adalah SQLite; konfigurasi `.env` lokal memilih MySQL `siaganow` di `127.0.0.1:3306` (kredensial tidak dicatat). Koneksi aktif dan `disaster_reports` sudah ada setelah migration baru.
- Migration yang ada sebelumnya membuat tabel users, cache, jobs, weather_warnings, shelters, hazard_zones, disaster_events, dan risk_assessments. Migration aditif baru `2026_10_25_000001_create_disaster_reports_table.php` menambah laporan dan FK ke users. Relasi model tersedia User → RiskAssessment dan User → DisasterReport. Belum ada tabel donasi, keluarga, berita, atau role.
- DatabaseSeeder membuat satu akun factory `test@example.com`; data itu tidak boleh dianggap pengguna/akun demo aman untuk deployment.
- Migration laporan diuji dalam SQLite in-memory oleh test suite dan diterapkan ke MySQL lokal setelah status/skema diverifikasi. Uji round-trip laporan MySQL dilakukan dalam transaksi lalu rollback. Tabel baru berisi 0 baris; data lain tidak diubah.

## Referensi desain dan UI/UX

Nama file aktual sudah diverifikasi: lima screenshot web (`Dashboard.png`, `Halaman Donasi Utama.png`, `Laporkan Bencana.png`, `Lokasi Kejadian.png`, `Semua Berita.png`), delapan screenshot mobile, dan dua gambar inspirasi. Tidak ada file PDF Figma di direktori referensi.

Temuan awal: view web berdiri sendiri dan mengulang header/CSS, beranda memakai 1.100+ baris inline style/script dan CDN Tailwind; beberapa halaman belum konsisten. `donate.blade.php` menggunakan state kosong yang transparan. Perubahan tahap ini menambah state dan label data demo pada beranda/peta; penyegaran visual menyeluruh serta screenshot browser desktop/mobile masih perlu dilakukan.

## Pemeriksaan yang sudah dilakukan

- `php -v`: PHP 8.3.33.
- `composer -V`: terpasang, sempat mengeluarkan peringatan `tempnam()` terkait direktori temp.
- `composer require laravel/boost --dev`: paket ditambahkan setelah Composer memperoleh akses jaringan; proses autoload awal macet dan dihentikan. `composer dump-autoload --no-scripts` dan `php artisan package:discover` berjalan setelah direktori temp diarahkan ke workspace.
- `php artisan boost:install`: berhasil setelah `php artisan package:discover`.
- `php artisan route:list`: berhasil, 23 route termasuk peta, pencarian shelter, cuaca, auth dan halaman publik.
- Hasil suite awal: 5 tes / 13 assertion. Hasil suite terbaru setelah endpoint API: 9 tes / 32 assertion (semua lulus), lihat pembaruan lanjutan.
- `php artisan migrate:status` sebelum migrasi: sembilan migration lama `Ran`, migration laporan `Pending`. `php artisan db:show --counts`: 14 tabel, termasuk 2 user, 3 risk assessment, 95 weather warning, 0 shelter. Pemeriksaan `disaster_reports` menunjukkan tabel belum ada.
- `php artisan migrate --pretend`: menampilkan satu operasi `CREATE TABLE disaster_reports` dengan foreign key/index ke `users`; tidak ada operasi destructive.
- `php artisan migrate`: migration `2026_10_25_000001_create_disaster_reports_table` berhasil. Status sesudahnya `Ran`; tabel InnoDB punya 15 kolom, FK user dan index status/user. `db:show --counts` menunjukkan 15 tabel dan 0 laporan; baris tabel lama tetap sama.
- Uji round-trip model `User`/`DisasterReport` terhadap MySQL lokal berhasil di transaksi yang di-rollback; tidak meninggalkan data uji.
- `php artisan view:cache`: berhasil mengompilasi view setelah halaman status laporan ditambahkan.
- Smoke test HTTP server Laravel sementara: `/`, `/maps`, `/donate`, `/berita-kebencanaan` memberi HTTP 200; `/risk-check` mengarahkan pengunjung tanpa login (302). Homepage/peta merender label demo. Endpoint shelter memberi fallback `simulation` dengan satu hasil untuk pencarian Kuranji saat MySQL mati; respons pertama lambat sekitar 4.7–8.7 detik akibat percobaan koneksi database.
- Smoke test terakhir `/donate`: HTTP 200, dua kartu demo, progress 30%, nominal ditandai contoh, tombol pembayaran nonaktif.
- Saat audit awal Flutter 3.47.2/Dart 3.13.2 tersedia dan emulator/perangkat belum terdeteksi; proyek mobile terpisah dibuat pada tahap lanjutan (lihat pembaruan di bawah).
- Belum dilakukan screenshot/render QA desktop/mobile dan tidak ada tes baru yang ditambahkan.
- Frontend memakai npm; tidak ada npm lockfile/node_modules pada awal tahap. `npm install --no-audit --no-fund` berhasil dan membuat `package-lock.json` (lockfile v3). Versi Node 22.23.2, npm 10.9.8.
- Build Vite awal gagal karena plugin font mengakses Bunny Fonts dari jaringan. Konfigurasi font remote dihapus dan stack sistem lokal digunakan; `npm run build` berhasil offline. Asset terbit di `public/build`.

## Pekerjaan berikutnya

1. Lakukan screenshot QA browser desktop dan mobile untuk halaman web yang sudah diperbarui.
2. Tambahkan pemilih lokasi peta dan upload bukti laporan pada aplikasi Flutter; gunakan server/perangkat lokal untuk memastikan alur end-to-end.
3. Rancang peran petugas dan audit log sebelum membuka perubahan status laporan.
4. Tetapkan sumber terverifikasi untuk berita, data bahaya/shelter, kontak darurat, dan payment sebelum mengklaim produksi.

## Kendala terbuka

- Aplikasi Flutter awal telah tersedia pada folder terpisah. Flutter 3.47.2/Dart 3.13.2, Chrome/Edge/Windows terdeteksi; Android SDK dan emulator/perangkat Android/iOS belum tersedia.
- Ketika MySQL mati, pencarian peta menunggu beberapa detik sebelum menampilkan fallback simulasi.
- Sumber resmi cuaca, data bahaya/shelter, berita, donasi dan payment belum ditetapkan/tersedia.


## Pembaruan 25 Oktober 2026 — data resmi, UI web, dan lanjutan Flutter

### Referensi yang diperiksa secara visual

- Dua gambar `design-reference/inspiration/`: `nature reference.jpg` menampilkan palet hijau hutan dan krem, fotografi alam sebagai bidang utama, tipografi sans-serif, ruang putih, dan aksen CTA terakota. `Weather website themes.jpg` menggunakan langit/foto sebagai hero dengan prakiraan yang tersusun jelas. Gambar latar ilustrasi SiagaNow yang sudah ada juga diperiksa; karakter perbukitan hijaunya dipertahankan.
- Mockup web yang dibuka: `Dashboard.png`, `Lokasi Kejadian.png`, `Laporkan Bencana.png`, `Halaman Donasi Utama.png`, dan `Semua Berita.png`. Struktur utama beranda, peta, pelaporan, donasi, dan berita tetap dipakai.
- Mockup mobile yang dibuka: `Beranda.png`, `Rute Evakuasi.png`, `Berita.png`, `Cuaca .png`, `Laporkan Bencana.png`, `Layanan Darurat.png`, `Login.png`, dan `Profil.png`. Flutter tetap bertahap; palet dan atribusi cuaca kini lebih dekat dengan identitas situs.

### Implementasi dan sumber data

- BMKG: `app/Services/BmkgForecastService.php` mengambil prakiraan resmi berdasarkan kode administrasi `13.71.01.1001` (Belakang Pondok, Padang Selatan). Respons resmi menggunakan prakiraan wilayah bertahap, termasuk suhu, kelembapan udara, deskripsi cuaca, dan angin. Cache file 45 menit, batas koneksi 4 detik, timeout 8 detik, validasi identitas wilayah, waktu analisis UTC, dan atribusi sumber diterapkan. Perubahan terkait: `config/siaganow.php`, `.env.example`, `routes/web.php`, `routes/api.php`, `app/Http/Controllers/Api/PublicInfoController.php`, `resources/views/welcome.blade.php`, `tests/Feature/BmkgForecastTest.php`.
- BMKG mengukur kelembapan udara, bukan kelembapan tanah. Kartu kelembapan tanah sekarang menyatakan belum tersedia. Banner beranda tidak menyebut peringatan aktif; status peringatan tetap `unknown` sampai feed peringatan diperiksa.
- Ketika Mode Demo aktif dan fetch BMKG gagal, hanya nilai cuaca contoh yang ditampilkan, dengan label “Contoh Data SiagaNow”; tidak ada prakiraan per jam palsu. Dengan demo nonaktif, respons layanan adalah `unavailable` (API 503). Endpoint publik `/api/weather-forecast` menyertakan tipe data, lokasi, waktu pembaruan, sumber, dan pesan.
- BNPB: dataset resmi yang diperiksa berupa kompilasi historis (berkas XLSX), bukan feed kejadian terkini yang terhubung. Statistik contoh tetap dilabeli angka latihan; bila demo dimatikan, statistik menjadi belum tersedia. Halaman berita mengganti item kejadian contoh dengan tautan kanal resmi BPBD Sumbar/BNPB dan menjelaskan bahwa feed belum tersinkronisasi.
- InaRISK: layanan resmi berupa layer spasial/raster telah diverifikasi, tetapi SiagaNow belum mengartikan nilai raster menjadi kelas bahaya atau tingkat risiko alamat. Peta kini tidak membuat zona aman/merah; tautan sumber resmi tersedia. Lokasi shelter database tetap menampilkan metadata sumber/verifikasi, sementara fallback demo di peta diberi label simulasi.
- `resources/views/maps.blade.php` tidak lagi menyebut judul peta sebagai zona evakuasi dan menghapus klasifikasi A–D yang belum didukung. `public/css/siaganow-design.css` menerapkan warna natural, permukaan krem, header lebih ringan, hero editorial dengan ilustrasi lanskap, fokus aksesibel, kartu/border yang lebih tenang, dan strip prakiraan responsif. Berita dan edukasi di homepage dibedakan dari berita kejadian terkini.
- Penghapusan CDN Tailwind pada view yang memakai Vite dipertahankan; stylesheet konsisten dimuat dari asset build dan `public/css/siaganow-design.css`. Lockfile npm tidak diganti dan versi dependency tidak diubah.
- Flutter di `D:\laragon\www\SiagaNowMobile\lib\main.dart`: palet hijau hutan/krem, radius kartu diperkecil, dan kartu cuaca menampilkan prakiraan, deskripsi, lokasi administratif BMKG, atau label simulasi/sumber tidak tersedia.

### Pengujian tahap ini

- `npm run build`: berhasil dengan Vite 8; manifest dan CSS produksi dibuat. Dependency sudah terpasang dan `package-lock.json` npm v3 digunakan.
- `php artisan view:cache` dan lint PHP pada view terkompilasi: berhasil. Pemeriksaan ini menemukan directive Blade inline yang tadinya tidak tertutup; directive dipisahkan dan homepage kini dapat dirender.
- `php artisan test`: lulus 12 tes / 53 assertion, termasuk parser/cache BMKG dan fallback demo/unavailable.
- Smoke test Laragon lokal: `/`, `/maps`, `/berita-kebencanaan`, `/donate` dan `/api/weather-forecast`, `/api/home` merespons 200. API mengembalikan `simulation` karena koneksi outbound proses PHP ke `api.bmkg.go.id:443` ditolak pada lingkungan ini; homepage mempertahankan label fallback, statistik simulasi berlabel, dan status peringatan `unknown`. Kegagalan outbound dicatat sebagai keterbatasan uji runtime, bukan sebagai data riil.
- MySQL aktif: MySQL 8.4.3, schema `siaganow`, 16 tabel, 11 migration `Ran`. `disaster_reports` ada dengan 0 laporan. Tidak ada migration baru atau perubahan data pada tahap ini.
- Flutter dari `D:\laragon\www\SiagaNowMobile`: `flutter analyze` bersih, `flutter test` lulus (1 test widget), `flutter build web --release --dart-define=SIAGANOW_API_URL=http://127.0.0.1:8093/api` berhasil. Android SDK/perangkat belum tersedia; build APK belum diulang.
- Chrome headless kini berhasil menghasilkan dan membuka screenshot homepage desktop serta narrow viewport. Komposisi desktop (hero lanskap, peringatan, ringkasan, sidebar) konsisten dengan arah visual referensi. Screenshot narrow viewport menunjukkan sebagian konten/nav terpotong pada konfigurasi headless yang tersedia; responsive QA mobile belum lulus dan perlu diuji ulang di browser dengan viewport CSS/perangkat yang terkontrol. Penyesuaian breakpoint, grid navigasi, wrapping judul, dan batas overflow telah ditambahkan, tetapi screenshot headless yang sama masih memperlihatkan crop sehingga belum diklaim selesai.

### File utama tahap ini dan tindak lanjut

- Berubah: `app/Services/BmkgForecastService.php`, `config/siaganow.php`, `.env.example`, `routes/web.php`, `routes/api.php`, `app/Http/Controllers/Api/PublicInfoController.php`, `resources/views/welcome.blade.php`, `resources/views/maps.blade.php`, `resources/views/berita-kebencanaan.blade.php`, `public/css/siaganow-design.css`, `tests/Feature/BmkgForecastTest.php`, `D:\laragon\www\SiagaNowMobile\lib\main.dart`, dan dokumen ini.
- Migration/database tahap ini: tidak ada perubahan.
- Prioritas berikutnya: atasi kebijakan jaringan/allowlist agar runtime Laravel dapat mencapai API BMKG; ulangi QA responsif menggunakan viewport browser yang terkontrol dan perbaiki crop yang terlihat pada screenshot narrow; pilih feed API resmi BNPB/berita yang terstruktur bila tersedia; tetapkan sumber operasional shelter, peta bahaya, dan kontak; lanjutkan UI lokasi/rute Flutter setelah API dan perangkat dapat diuji.

## Pembaruan — 25 Oktober 2026: warna, Donate, API aktual, dan perangkat

### Referensi dan desain

- Gambar inspirasi `nature reference.jpg` dan `Weather website themes.jpg` dibuka dan diperiksa visual. Ciri yang diterapkan: fotografi/ilustrasi lanskap yang kontekstual, ruang editorial yang lega, hierarki cuaca yang terstruktur, serta dekorasi yang dibatasi. Gambar inspirasi tidak dipakai sebagai klaim lokasi atau kejadian.
- Mockup web `Halaman Donasi Utama.png` dan mockup mobile `Beranda.png` diperiksa visual; mockup web lain dan layar mobile lainnya juga dibandingkan pada pemeriksaan sebelumnya. Struktur halaman mockup dipertahankan. Nilai warna asli CSS proyek/mockup yang tersedia dipertahankan sebagai token utama (`#075b49`, `#064b3d`, `#0b795d`, `#d9f0e5`, `#eff8f2`, `#123d35`, `#cfe3d8`, `#dc4c50`); palet hijau/mint Flutter juga dikembalikan agar sama. Warna teks sekunder digelapkan minimal untuk keterbacaan.
- Website memakai satu keluarga ikon SVG garis lokal di `resources/views/partials/siaga-icon.blade.php`; simbol menu geometris diganti ikon sesuai fungsi. Flutter tetap memakai keluarga Material Icons yang konsisten. Ukuran tombol sentuh dan focus-visible diperbaiki; tidak ada emoji yang dipakai sebagai ikon kebencanaan.
- Screenshot website homepage pada RMX2001 (Chrome, 360 dp) menunjukkan judul, navigasi yang membungkus, ilustrasi, dan bagian peringatan tetap dalam lebar layar tanpa potongan horizontal. Screenshot narrow headless sebelumnya tidak mewakili skala CSS ponsel dan menghasilkan false positive; pemeriksaan nyata ini hanya mencakup homepage, bukan seluruh halaman. Pemeriksaan visual Donate pada ponsel belum valid: layar tertidur saat screenshot, jadi responsivitas halaman Donate di perangkat belum diklaim lulus. Desktop build/rute diuji, tetapi screenshot desktop terkini belum dihasilkan pada tahap ini.

### Donate

- `config/siaganow.php` memiliki tiga program demonstrasi konsisten (banjir, perlengkapan evakuasi, longsor) dengan periode, target, nilai terkumpul, status simulasi dan progres 30%; deskripsi menyebut rencana contoh, tanpa korban/mitra/kejadian nyata.
- `resources/views/donate.blade.php`, `resources/views/partials/donation-illustration.blade.php`, dan `routes/web.php` menampilkan daftar serta halaman detail per program. Ilustrasi SVG menunjukkan tema umum, bukan foto kejadian/lokasi. Satu keterangan menjelaskan program simulasi dan bahwa donasi/transaksi belum diterima; tombol pembayaran tidak aktif. Pencarian daftar dipertahankan.
- Smoke HTTP: `/donate` dan detail program contoh 200; ID yang tak dikenal 404. Tidak ada transaksi atau catatan keuangan yang dibuat.

### Data dan backend

- Fetch baru ke endpoint prakiraan BMKG resmi (`api.bmkg.go.id`, kode wilayah administratif `13.71.01.1001`) berhasil dari proses Laravel yang diberi akses jaringan. Endpoint lokal `/api/weather-forecast` menjawab 200 dengan `data_type=actual`, delapan interval prakiraan, lokasi, waktu analisis, dan atribusi BMKG. HP pada jaringan lokal yang sama berhasil menjangkau Laravel/API `/api/home`; screenshot aplikasi Flutter menampilkan cuaca BMKG aktual. Prakiraan ini mencakup kelurahan, bukan rumah/alamat. Akses dari shell sandbox biasa tetap dapat ditolak kebijakan jaringan; hasil aktual diperoleh melalui proses jaringan yang diizinkan.
- BNPB/InaRISK/BPBD belum diintegrasikan sebagai feed kejadian terkini. Statistik tetap data latihan berlabel, peringatan tetap `unknown` sampai feed peringatan aktual tersedia, kelembapan tanah tidak disimpulkan dari kelembapan udara, serta berita/shelter/zona simulasi tetap ditandai. Sumber BMKG menyatakan prakiraan wilayah hingga 3 hari dengan 8 interval per hari dan pembaruan dua kali sehari ([BMKG](https://data.bmkg.go.id/prakiraan-cuaca/)). Dataset BNPB yang diperiksa bersifat kompilasi, bukan feed real-time ([BNPB](https://data.bnpb.go.id/dataset/data-bencana-indonesia)); InaRISK menyediakan layer GIS tetapi nilai bahayanya belum ditafsirkan pada tingkat alamat ([InaRISK](https://inarisk.bnpb.go.id/perb/faq.html)).
- Pemeriksaan MySQL: koneksi sukses, 16 tabel, 11 migration `Ran`; `disaster_reports` tersedia dan kosong. Tidak ada migration pada tahap penutupan ini, data tidak dihapus/diimpor ulang, dan tidak ada perintah destruktif.

### Flutter dan pengujian yang benar-benar dijalankan

- Pada `D:\laragon\www\SiagaNowMobile`, `flutter analyze` bersih dan widget test lulus (1 test). APK debug berhasil dibangun dengan `SIAGANOW_API_URL=http://192.168.1.3:8093/api`, dipasang dan dibuka di RMX2001 (Android 11; NDK 28.2.13676358). Tampilan beranda aktual BMKG dan navigasi bawah terlihat. GET API aktual dari HP berhasil. Login/pengiriman laporan dari perangkat belum diuji karena tidak ada kredensial uji yang disediakan; jangan menganggap alur itu tervalidasi end-to-end.
- `php artisan test`: 12 test / 53 assertion lulus. `php artisan view:cache`, `npm run build`, `git diff --check`, dan `php artisan migrate:status` lulus. `/maps`, `/berita-kebencanaan`, `/donate`, detail donate, `/api/weather-forecast`, dan `/api/home` memberi 200; ID donate tidak dikenal 404. MySQL `db:show --counts` berhasil.
- Tidak ada migrasi atau perubahan skema baru pada tahap ini. Perubahan utama tersebar di `public/css/siaganow-design.css`, Blade halaman publik/donate, partial ikon/ilustrasi, service BMKG/API, route, konfigurasi demo, test, serta Flutter `lib/main.dart`. Dependensi/lockfile tidak diganti pada penutupan ini.

### Yang masih belum selesai

- QA screenshot desktop serta halaman peta, berita, donate dan halaman lain pada beberapa lebar belum seluruhnya diverifikasi secara visual; bukti ponsel valid saat ini hanya homepage dan aplikasi Flutter.
- Login dan kirim laporan belum diuji end-to-end pada HP; pemilih lokasi peta, unggah lampiran, rute aktual, pendaftaran aplikasi dan Keluarga Siaga tetap perlu dikerjakan sesuai status terdahulu.
- Pembayaran donate tidak tersedia; ketiga program tetap demonstrasi. Feed live BNPB/BPBD, peringatan resmi, statistik real-time, peta InaRISK terinterpretasi, kelembapan tanah, serta verifikasi operasional shelter belum tersedia. Risiko rumah tidak menjadi penilaian alamat terverifikasi.

## QA finalisasi — 25 Oktober 2026

### Website

- Mengambil screenshot Chrome desktop 1440×1000 dan meninjau homepage, peta, berita, daftar Donate, serta detail program. Homepage dan Donate desktop tampil utuh pada viewport tersebut; identitas hijau/mint mockup tetap digunakan. Tampilan peta memperlihatkan area peta kosong pada sesi browser QA, sehingga pemuatan basemap/tile belum dapat dinyatakan berhasil. Halaman tersebut tetap menyebut OpenStreetMap; perlu uji ulang pada jaringan browser yang mengizinkan tile dan, bila tile tetap gagal, keadaan kosong/error perlu dibuat eksplisit.
- Percobaan screenshot mobile Chrome dengan `--window-size=390` ternyata bukan viewport CSS 390: Chrome headless memaksakan layout sekitar 469 CSS px lalu menghasilkan raster 390 px. Untuk itu, screenshot raster tersebut tidak dipakai sebagai bukti lulus/gagal responsif. Dengan emulasi DevTools pada viewport CSS tepat 390, pengukuran DOM menunjukkan lebar halaman 390 untuk peta, berita, Donate, detail, laporan, cek risiko, banjir, statistik, dan panduan. Homepage masih memiliki `scrollWidth` 407 px karena grid tiga kolom metrik. Aturan mobile sudah diperbaiki agar `metrics-grid` bertumpuk menjadi satu kolom; pengukuran ulang sesudah aturan terakhir ini belum berhasil dilakukan.
- Pemeriksaan screenshot Donate secara visual di HP RMX2001 belum berhasil: Android `screencap` menghasilkan berkas kosong saat layar aktif, sehingga jangan menyebut Donate HP lulus. Detail Donate memiliki pengukuran DOM 390 CSS px tanpa overflow; screenshot visualnya pada perangkat belum ada. Uji perangkat memerlukan layar ponsel tidak terkunci serta sesi Chrome dapat ditampilkan/capture.
- Pada viewport desktop, peta belum menampilkan tile dalam screenshot; penyebab (jaringan tile/browser atau kode) belum dibuktikan. Login dari halaman laporan tampil untuk sesi guest; alur laporan yang memerlukan autentikasi belum diuji visual end-to-end. Pengujian beberapa halaman pada font/zoom 200% dan WCAG contrast tool belum dilakukan.

### Sumber data, shelter, dan kontak

- Portal data BNPB saat ini menyediakan dataset kompilasi dan layanan GIS kejadian mingguan. Metadata resmi `Kejadian_Bencana_Mingguan` yang diuji secara read-only hanya mencakup extent sekitar 112–116° BT dan -8.9 sampai -7.3° LS (wilayah di luar Sumatera Barat), sehingga tidak cocok untuk menyajikan kejadian Sumbar. Endpoint query layer mendapat halaman blokir/WAF pada runtime ini. Karena cakupan/akses tersebut, feed itu tidak diintegrasikan dan statistik/peringatan tetap berstatus sesuai ketersediaan, bukan aktual ([daftar REST GIS BNPB](https://gis.bnpb.go.id/server/rest/services), [Portal Satu Data Bencana](https://data.bnpb.go.id/)).
- BPBD Kota Padang memublikasikan nomor kantor 0751-8956977 / 778775, dan Pemerintah Kota Padang menyatakan PCC 112 gratis untuk laporan darurat di Kota Padang. Sumber ini terverifikasi sebagai kanal eksternal; tidak digeneralisasi sebagai nomor layanan operasional seluruh Sumatera Barat. Portal resmi PCC 112 menampilkan data sebaran kejadian berlabel real-time, tetapi saat diperiksa publik tidak memberi payload tabel/API yang dapat diverifikasi untuk integrasi otomatis. Shelter resmi terverifikasi yang dapat dipakai sebagai daftar operasional belum ditemukan ([kontak BPBD Padang](https://bpbd.padang.go.id/kontak), [PCC 112 Kota Padang](https://sigap.padang.go.id/)).
- Belum ada kode integrasi feed, perubahan database, atau penambahan nomor darurat ke aplikasi pada tahap QA ini; status/simulasi yang ada tidak diubah menjadi data aktual.

### Flutter dan QA perangkat

- Tidak tersedia akun uji sah yang dikonfirmasi, maka login dan submit laporan dari RMX2001 tidak dilakukan. Tidak membuat pengguna/kredensial atau laporan palsu untuk mengisi celah tersebut. Tes API/fitur yang ada tetap tercatat dari Laravel Feature Test, bukan bukti alur end-to-end perangkat.
- APK debug dan API LAN telah berhasil diuji pada tahap sebelumnya; `flutter analyze` dan 1 widget test juga lulus. Tidak ada perubahan Dart pada tahap QA ini, tetapi build/test Flutter regresi baru belum dijalankan pada sesi ini.

### Status regresi dan kendala sesi

- Sebelum pembaruan CSS responsif terakhir, `php artisan test` lulus 12 tes / 53 assertion; `npm run build`, `php artisan view:cache`, `git diff --check`, `flutter analyze`, serta `flutter test` lulus. Tidak ada kode Flutter/backend/data yang berubah pada QA terakhir; hanya aturan CSS responsif homepage yang ditambahkan.
- Setelah patch CSS terakhir, proses terminal lokal tidak dapat dimulai karena Windows mengembalikan `CreateProcessWithLogonW failed: 1909`; karena itu build/test pasca-patch dan screenshot sesudah patch belum dapat diverifikasi. Status lulus sebelumnya tidak diperluas menjadi lulus untuk perubahan terakhir ini.
- Database tidak berubah; tidak ada migration baru, reset, penghapusan, atau impor data.


## Pembaruan tahap lanjutan — API, MySQL, dan Flutter

- Dependency frontend: npm dengan `package-lock.json` v3. `npm install --no-audit --no-fund` selesai dan `npm run build` berhasil; konfigurasi font remote dihilangkan agar build tidak bergantung pada Bunny Fonts.
- API mobile dan Sanctum: `AuthController`, `PublicInfoController`, `routes/api.php`, CORS, ability middleware, token login/register/logout, profil aman, berita/home/shelter/weather, daftar dan submit laporan pengguna. API smoke sebelumnya mengonfirmasi fallback `simulation`, preflight localhost, serta reports tanpa token menghasilkan 401.
- Database lokal tersambung ke MySQL 8.4.3, schema `siaganow`; pemeriksaan terbaru menunjukkan 16 tabel dan 11 migration `Ran`. Migration baru hanya membuat `disaster_reports` dan `personal_access_tokens`. Data tabel sebelumnya tetap ada (2 users, 3 risk assessments, 95 weather warnings); tabel baru kosong. Tidak ada `migrate:fresh`, wipe, penghapusan atau impor data. Kredensial tidak disalin ke catatan.
- Backend suite terbaru: `php artisan test` lulus, 9 test / 32 assertion. Route API menampilkan 10 endpoint. `composer validate --no-check-publish` lulus. `php artisan db:show --counts` berhasil ke MySQL.
- Flutter: proyek terpisah `D:\laragon\www\SiagaNowMobile`; dependensi `http ^1.6.0` dan `flutter_secure_storage ^11.2.0`. Token disimpan secure storage, API base URL dikonfigurasi via `SIAGANOW_API_URL` (default Android emulator `10.0.2.2`, web `127.0.0.1`), demo fallback memakai `SIAGANOW_DEMO_MODE`. Implementasi beranda, label demo, shelter, login, laporan bencana, dan placeholder transparan untuk layanan yang belum tersedia.
- Pemeriksaan Flutter: `flutter analyze` bersih; `flutter test` lulus 1 widget smoke test; `flutter build web --release --dart-define=SIAGANOW_API_URL=http://127.0.0.1:8000/api` berhasil. `flutter build apk --debug` terhenti karena Android SDK tidak terpasang/terdeteksi. Android manifest release memiliki izin INTERNET; cleartext HTTP hanya dibuka di manifest debug. Belum uji perangkat atau end-to-end HTTP dari browser Flutter.
- Keterbatasan mobile: form laporan memakai koordinat contoh Padang yang wajib pengguna ubah; jumlah korban boleh kosong jika belum diketahui; belum ada pemilih peta/lokasi, upload lampiran, pendaftaran app, rute navigasi/arah aman. Jika endpoint home gagal dan Mode Demo aktif, client memakai cuaca contoh lokal berlabel simulasi serta menyatakan API aktual gagal. Mode Demo shelter lokal juga berlabel simulasi.
- Pemeriksaan akhir terbaru: `git diff --check` lulus dengan hanya peringatan konversi CRLF/LF di beberapa file; smoke HTTP halaman publik dan API sukses. Percobaan screenshot Chrome/Edge headless tidak berhasil karena proses GPU browser keluar fatal di mesin ini; screenshot QA visual desktop/mobile masih belum terverifikasi.

## Pembaruan QA final — 25 Oktober 2026 (setelah verifikasi Laragon dan RMX2001)

### Website dan responsivitas

- Bagian lama yang menyebut pengukuran setelah patch belum dilakukan kini superseded oleh pengukuran dan screenshot sesi ini. Pada emulasi Chrome DevTools viewport CSS 390 px, homepage setelah perbaikan grid metrik dan halaman peta, berita, Donate, detail program, laporan, cek risiko, statistik, banjir, dan panduan tidak melebihi lebar 390 px. Screenshot Donate/detail terbaru juga diambil langsung dari Chrome RMX2001 melalui server LAN; kartu dan teks membungkus, progres/target terbaca, dan tombol pembayaran tetap nonaktif/berlabel belum tersedia. Tidak ditemukan pemotongan horizontal pada tampilan yang ditinjau.
- Screenshot desktop 1440×1000 homepage, peta, berita, Donate, dan detail program ditinjau; screenshot mobile 390 CSS homepage, peta, berita, Donate, detail program, laporan, cek risiko, statistik, banjir, dan panduan ditinjau. Bukti perangkat: `storage/app/qa-rmx-donate.png`, `qa-rmx-donate-list-mid.png`, `qa-rmx-donate-detail.png`, `qa-rmx-donate-detail-mid.png`; layar Flutter: `storage/app/qa-rmx-api-test.png`.
- Peta kini membundel Leaflet lokal (`resources/js/maps.js`, dependency `leaflet`), bukan mengambil pustaka JS dari CDN. Koneksi tile OpenStreetMap masih gagal di sesi browser ini; overlay menjelaskan tile/lokasi tidak tersedia dan tidak boleh dipakai untuk menentukan rute. Peta serta penandanya tidak dinyatakan lulus data/navigasi operasional.
- Palet hijau/mint mockup dipertahankan. Tipe dan ikon konsisten pada layar yang ditinjau. Belum dilakukan audit otomatis rasio kontras seluruh kombinasi warna atau pembesaran 200% di seluruh halaman.

### API, data, database, dan kontak

- Pengujian akhir: `php artisan test` lulus 12 tes / 53 assertion; `npm run build` sukses; `php artisan view:cache` sukses; `git diff --check` sukses (peringatan hanya normalisasi CRLF/LF). Smoke HTTP `/`, `/maps`, `/berita-kebencanaan`, `/donate`, `/panduan-kesiapsiagaan`, `/api/home`, dan `/api/weather-forecast` menghasilkan 200. Route detail memakai `/donate/program/{campaign}` (bukan `/donate/{slug}`).
- API `/api/home` berhasil dijangkau dari RMX2001 melalui `192.168.1.3:8093`; aplikasi menunjukkan prakiraan BMKG 26° berawan dengan lokasi administratif dan status peringatan terpisah (endpoint prakiraan tidak memeriksa peringatan). Pada pemeriksaan lain, koneksi BMKG runtime pernah ditolak; fallback tetap berlabel simulasi. Data BMKG merupakan prakiraan wilayah, bukan kondisi terukur di rumah.
- `php artisan migrate:status` menampilkan seluruh 11 migration sebagai `Ran`. Tidak ada migration dijalankan, perubahan skema, reset, penghapusan, atau impor pada tahap QA final. Data dan database MySQL yang telah ada dipertahankan.
- Feed kejadian Sumatera Barat, peringatan operasional, daftar shelter terverifikasi, dan statistik live belum tersedia untuk integrasi yang dapat dibuktikan; data contoh tetap memiliki penanda. Kontak PCC 112 diterapkan di panduan web dan layar Layanan Flutter hanya untuk Kota Padang, dengan tautan panggilan yang membuka dialer (tidak otomatis menelepon). Daerah lain diarahkan ke BPBD kabupaten/kota masing-masing.

### Flutter dan QA perangkat

- APK debug berhasil dibuat dengan Gradle setelah Flutter CLI build berulang gagal pada Kotlin incremental cache karena root drive Pub cache (`C:`) berbeda dari proyek (`D:`). APK final dibangun dengan `kotlin.incremental=false` dan `SIAGANOW_API_URL=http://192.168.1.3:8093/api`, dipasang pada RMX2001, dan activity utama dibuka. Screenshot memperlihatkan data BMKG aktual dari endpoint Laravel; jangkauan LAN endpoint diuji terpisah melalui HP. `flutter analyze` bersih, `flutter test` lulus 1 widget test, dan `flutter build web --release` berhasil.
- Tidak ada akun uji sah yang diberikan. Login dan pengiriman laporan berautentikasi tidak diuji end-to-end; tidak dibuat akun/kredensial/laporan uji. Pengujian route/API otomatis tidak menggantikan uji tersebut. Daftar Donate diuji di Chrome RMX2001, sebab aplikasi Flutter tidak memiliki fitur Donate dalam ruang lingkup implementasi saat ini.
- Dependensi baru yang relevan untuk perubahan tahap ini: `leaflet ^1.9.4` pada website dan `url_launcher ^6.3.3` pada Flutter; lockfile masing-masing diperbarui. File Flutter utama yang berubah adalah `D:\laragon\www\SiagaNowMobile\lib\main.dart`.

### Batas QA yang masih ada

- Tile OSM gagal di lingkungan browser, koneksi BMKG runtime dapat berubah/ditolak, dan feed resmi kejadian/shelter/peringatan Sumbar belum operasional.
- Login dan submit laporan dari perangkat memerlukan akun uji sah yang disediakan, lalu dapat diuji tanpa mengubah data produksi. Contrast audit menyeluruh/zoom 200% belum dilakukan. Kesiapan ini tidak sama dengan kelulusan seluruh QA end-to-end.
