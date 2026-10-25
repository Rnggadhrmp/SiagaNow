# **BUSINESS RECUIREMENT DOCUMENT (BRD)** 

_“Desain Web dan Apk Tema Bencana Alam”_ 

## **PEMROGRAMAN BERBASIS PLATFORM** 

## **DOSEN PENGAMPU:** 

**Dr. Resmi Darni, S.Kom., M.Kom.** 



<!-- Start of picture text -->
«é mec’)<br>% a)<br>i é<br>Zz FS<br>Or 15)<br>ONY<br><!-- End of picture text -->

## **OLEH:** 

**Imam Atthahira (24343037)** 

**Rangga Dharma Putra (24343045)** 

## **PROGRAM STUDI INFORMATIKA** 

## **DEPARTEMEN TEKNIK ELEKTRONIKA** 

**FAKULTAS TEKNIK** 

## **UNIVERSITAS NEGERI PADANG** 

**2026** 

1 

### **BUSINESS REQUIREMENTS DOCUMENT (BRD)** 

### **SiagaNow** 

Website dan Aplikasi Mobile untuk Kesiapsiagaan Bencana Banjir dan Tanah Longsor 

**Status Dokumen:** Belum Final **Versi:** 1.0 **Tanggal:** 13 Oktober 2026 **Nama Sistem:** SiagaNow 

### **Riwayat Revisi** 

|**Versi**|**Tanggal**|**Keterangan**|
|---|---|---|
|1.0|13 Oktober 2026|Draf awal BRD dan penyesuaian BRD dengan sistem web|
|||dan apk.|



### **1. Pendahuluan** 

### **1.1 Latar Belakang** 

Bencana alam berupa banjir dan tanah longsor dapat menimbulkan kerusakan lingkungan, kerugian material, korban jiwa, serta gangguan terhadap aktivitas masyarakat. Informasi mengenai kondisi cuaca, wilayah rawan bencana, lokasi evakuasi, dan kondisi anggota keluarga menjadi bagian penting dalam mendukung kesiapsiagaan masyarakat menghadapi bencana. 

SiagaNow merupakan sistem informasi kebencanaan yang dikembangkan dalam bentuk website dan aplikasi mobile. Sistem ini dirancang untuk menyediakan informasi kebencanaan, membantu pengguna mengenali potensi risiko di sekitar tempat tinggal, menemukan lokasi evakuasi, melaporkan kejadian bencana, mempersiapkan keluarga, dan menyalurkan bantuan melalui program donasi. 

Website SiagaNow berfokus pada fitur **Cek Risiko Rumah Anda** , yang memberikan informasi mengenai potensi risiko banjir dan tanah longsor di sekitar lokasi rumah pengguna. Sementara itu, aplikasi mobile berfokus pada fitur **Rute Evakuasi** dan **Keluarga Siaga** , yang mendukung pencarian shelter, informasi perjalanan menuju tempat evakuasi, serta komunikasi status keselamatan anggota keluarga. 

Dokumen Business Requirements Document (BRD) ini disusun untuk mendefinisikan kebutuhan bisnis, ruang lingkup, kebutuhan fungsional, aturan sistem, dan kebutuhan nonfungsional SiagaNow sebagai acuan pengembangan website dan aplikasi mobile. 

### **1.2 Tujuan Dokumen** 

Dokumen BRD ini bertujuan untuk: 

1. Mendokumentasikan kebutuhan bisnis SiagaNow berdasarkan alur dan mockup website serta aplikasi mobile. 

2 

1. Menjelaskan tujuan, ruang lingkup, dan fungsi utama sistem. 

2. Mendefinisikan kebutuhan pengguna dan pihak yang terlibat dalam pengelolaan sistem. 

3. Menetapkan aturan akses, pengelolaan informasi, pelaporan, donasi, dan perlindungan data. 

4. Menjadi acuan dalam proses perancangan, implementasi, pengujian, dan evaluasi sistem. 

5. Mengidentifikasi kebutuhan yang belum ditentukan agar tidak terjadi penambahan fitur atau asumsi yang tidak sesuai dengan rancangan. 

### **1.3 Gambaran Umum Sistem** 

SiagaNow terdiri atas dua platform utama: 

### **A. Website SiagaNow** 

Website menyediakan informasi kebencanaan, peta zona aman dan zona bahaya, pemeriksaan risiko rumah, berita dan edukasi, pelaporan bencana, serta informasi dan transaksi donasi sesuai fitur yang dirancang. 

### **B. Aplikasi Mobile SiagaNow** 

Aplikasi mobile menyediakan informasi kebencanaan yang dapat diakses melalui perangkat seluler, pencarian rute evakuasi, informasi shelter, kesiapsiagaan keluarga, pelaporan bencana, donasi, layanan darurat, serta profil dan pengaturan pengguna. 

Kedua platform memiliki kebutuhan informasi yang saling berkaitan, tetapi memiliki fokus fitur dan aturan autentikasi yang berbeda sesuai rancangan masing-masing. 

### **1.4 Dokumen Acuan** 

BRD ini disusun berdasarkan dokumen berikut: 

1. Mockup website SiagaNow (APK_BENCANA_web.pdf). 

2. Mockup aplikasi mobile SiagaNow (APK_BENCANA_MOBile.pdf). 

3. Alur penggunaan website dan aplikasi mobile SiagaNow. 

4. Aturan Sistem SiagaNow (revisi) yang mengatur aturan website, aturan mobile, hak akses dan kebutuhan admin, serta keamanan dan konsistensi sistem. 

### **1. Tujuan dan Kebutuhan Bisnis** 

### **1.1 Tujuan Bisnis** 

Pengembangan SiagaNow bertujuan untuk: 

1. Menyediakan akses informasi mengenai bencana banjir dan tanah longsor. 

2. Membantu pengguna mengenali potensi risiko bencana di sekitar tempat tinggal melalui fitur pemeriksaan risiko rumah. 

3. Membantu pengguna menemukan shelter dan memperoleh informasi rute evakuasi. 

4. Mendukung kesiapsiagaan keluarga melalui informasi status anggota keluarga dan checklist kesiapsiagaan. 

3 

5. Menyediakan sarana pelaporan kejadian bencana dengan informasi lokasi, waktu, dampak, dan bukti pendukung. 

6. Menyediakan informasi program donasi untuk mendukung bantuan bagi masyarakat terdampak bencana. 

7. Mendukung pengelolaan informasi kebencanaan dan pemeriksaan laporan oleh pihak yang berwenang. 

8. Menjaga keakuratan, konsistensi, dan keamanan informasi yang ditampilkan kepada pengguna. 

### **1.2 Permasalahan yang Ingin Didukung Penyelesaiannya** 

Berdasarkan tujuan dan fitur yang dirancang, SiagaNow ditujukan untuk mendukung kebutuhan berikut: 

- Pengguna membutuhkan informasi mengenai kondisi dan potensi risiko bencana di suatu wilayah. 

- Pengguna membutuhkan informasi zona aman, zona bahaya, dan lokasi shelter. 

- Pengguna membutuhkan informasi untuk mempersiapkan diri dan keluarga ketika menghadapi bencana. 

- Pengguna membutuhkan sarana untuk melaporkan kejadian bencana. 

- Pengguna membutuhkan akses terhadap informasi program bantuan dan donasi. 

- Pengelola membutuhkan mekanisme untuk memperbarui informasi kebencanaan dan memeriksa laporan sesuai kewenangannya. 

Permasalahan tersebut merupakan dasar kebutuhan sistem, bukan pernyataan bahwa seluruh proses penanganan bencana telah terintegrasi atau otomatis. 

### **1.3 Indikator Keberhasilan Bisnis** 

Keberhasilan SiagaNow dinilai berdasarkan kemampuan sistem memenuhi kebutuhan yang telah ditetapkan. 

1. Informasi kebencanaan dapat diakses sesuai hak akses pengguna. 

2. Fitur pemeriksaan risiko rumah dapat menampilkan informasi yang didukung data yang tersedia. 

3. Pengguna dapat menemukan informasi shelter dan rute evakuasi sesuai data yang tersedia. 

4. Pengguna dapat mengirimkan status Aman atau Perlu Bantuan melalui fitur Keluarga Siaga. 

5. Pengguna dapat mengirim laporan bencana dan mengetahui status laporan sesuai informasi yang tersedia. 

6. Informasi program donasi dan status transaksi ditampilkan secara konsisten dengan data transaksi. 

7. Data pribadi dan informasi yang dibatasi terlindungi dari akses tidak sah. 

4 

Target kuantitatif, seperti persentase keberhasilan, batas waktu respons, dan jumlah pengguna, belum ditetapkan dalam bahan kebutuhan yang diberikan dan perlu ditetapkan bersama pemangku kepentingan proyek (lihat TBD-14). 

### **1.4 Fokus dan Prioritas Fitur** 

Fokus fitur mengikuti rancangan pada bagian 1.1. Klasifikasi prioritas rinci (misalnya Must, Should, Could) belum ditetapkan dan tercatat sebagai TBD-18. 

|**Platform**|**Fitur fokus**|**Fitur pendukung**|
|---|---|---|
|Website|Cek Risiko Rumah Anda.|Beranda dan informasi kebencanaan, peta<br>kebencanaan, berita dan edukasi,<br>pelaporan bencana, serta donasi.|
|Mobile|Rute Evakuasi dan Keluarga<br>Siaga.|Beranda, berita, dan cuaca, pelaporan<br>bencana, donasi, layanan darurat dan<br>kontak, serta profil dan pengaturan.|



### **1.5 Kebutuhan Bisnis** 

|**ID**|**Kebutuhan Bisnis**|**Deskripsi Kebutuhan**|**Platform**|
|---|---|---|---|
|BR-01|Penyediaan<br>Informasi<br>Kebencanaan|Sistem harus menyediakan informasi<br>mengenai bencana banjir dan tanah<br>longsor, termasuk berita, edukasi,<br>cuaca, serta peringatan dini sesuai<br>informasiyangtersedia.|Website dan<br>Mobile|
|BR-02|Informasi Risiko<br>Bencana di Sekitar<br>Rumah|Sistem harus membantu pengguna<br>mengenali potensi risiko banjir dan<br>tanah longsor di sekitar lokasi rumah<br>melalui fitur Cek Risiko Rumah<br>Anda berdasarkan datayangtersedia.|Website|
|BR-03|Informasi Zona dan<br>Lokasi Evakuasi|Sistem harus menyediakan informasi<br>zona aman, zona bahaya, wilayah<br>terdampak, dan lokasi shelter untuk<br>mendukung pengguna dalam<br>mengenali area serta tempat<br>evakuasi.|Website dan<br>Mobile|
|BR-04|Informasi Rute<br>Evakuasi|Sistem harus membantu pengguna<br>menemukan shelter dan memperoleh<br>informasi rute perjalanan menuju<br>lokasi evakuasi berdasarkan data rute<br>yangtersedia.|Mobile|
|BR-05|Kesiapsiagaan<br>Keluarga|Sistem harus mendukung persiapan<br>keluarga menghadapi bencana<br>melalui fitur Keluarga Siaga,<br>penyampaian status Aman atau Perlu|Mobile|



5 

|BR-06|Pelaporan Kejadian<br>Bencana|Bantuan, checklist kesiapsiagaan,<br>dan informasi titik kumpul keluarga<br>sesuai rancangan.<br>Sistem harus menyediakan sarana<br>bagi pengguna untuk melaporkan<br>kejadian bencana dengan informasi<br>yang relevan, seperti lokasi, waktu,<br>dampak,dan buktipendukung.|Website dan<br>Mobile|
|---|---|---|---|
|BR-07|Pemantauan Status<br>Laporan|Sistem harus memungkinkan<br>pengguna memperoleh informasi<br>status laporan dan mendukung<br>petugas berwenang dalam memeriksa<br>laporan sesuai hak akses yang<br>ditetapkan.|Website dan<br>Mobile|
|BR-08|Penyediaan<br>Informasi dan<br>Transaksi Donasi|Sistem harus menyediakan informasi<br>program donasi, detail program,<br>nominal bantuan, serta proses donasi<br>dan informasi status transaksi sesuai<br>fituryangdirancang.|Website dan<br>Mobile|
|BR-09|Akses Layanan<br>Darurat|Sistem harus menyediakan akses<br>terhadap informasi layanan darurat<br>dan pengelolaan kontak yang<br>mendukung pengguna ketika<br>membutuhkan bantuan dalam situasi<br>bencana.|Mobile|
|BR-10|Pengelolaan<br>Informasi<br>Kebencanaan|Sistem harus mendukung admin atau<br>petugas berwenang dalam mengelola<br>informasi kebencanaan dan<br>memeriksa laporan sesuai peran serta<br>kewenanganyangditetapkan.|Admin|
|BR-11|Keakuratan dan<br>Konsistensi<br>Informasi|Sistem harus menjaga agar informasi<br>yang ditampilkan sesuai dengan data<br>yang tersedia, tervalidasi, dan<br>konsisten pada halaman maupun<br>platform yang menampilkan<br>informasiyangsama.|Website dan<br>Mobile|
|BR-12|Perlindungan Data<br>dan Hak Akses|Sistem harus melindungi data pribadi<br>dan informasi yang dibatasi dari<br>akses tidak sah serta menerapkan<br>pembatasan akses sesuai peran dan<br>ketentuan sistem.|Website, Mobile,<br>dan Admin|
|BR-13|Penyampaian<br>Informasi dan|Sistem harus memberikan keterangan<br>yang jelas ketika informasi tidak|Website dan<br>Mobile|



6 

|Kegagalan Proses|tersedia atau suatu proses gagal, serta|
|---|---|
|secara Jelas|tidak menampilkan informasi yang|
||belum terverifikasi seolah-olah|
||merupakan informasipasti.|



### **2. Ruang Lingkup Sistem** 

### **2.1 Ruang Lingkup Website** 

Website SiagaNow mencakup: 

1. Beranda dan informasi kebencanaan. 

2. Peta zona aman, zona bahaya, lokasi terdampak, dan zona merah. 

3. Informasi shelter dan pencarian lokasi. 

4. Fitur Cek Risiko Rumah Anda. 

5. Daftar berita, detail berita, dan edukasi kebencanaan. 

6. Pelaporan kejadian bencana dan tampilan status laporan. 

7. Informasi program donasi, detail program, dan proses pembayaran sesuai mockup. 

8. Autentikasi pengguna dan pembatasan akses fitur. 

9. Navigasi utama website (Home, Maps, Report, Donate, dan Other). 

10. Menu Other berupa menu dropdown pada navigasi, dengan isi yang belum ditetapkan. 

11. Kebutuhan pengelolaan informasi dan data oleh admin atau petugas berwenang. 

### **2.2 Ruang Lingkup Aplikasi Mobile** 

Aplikasi mobile SiagaNow mencakup: 

1. Pendaftaran, login, dan keluar akun. 

2. Beranda, berita, peringatan dini, dan informasi cuaca. 

3. Rute Evakuasi dan informasi shelter. 

4. Navigasi menuju shelter sesuai informasi rute yang tersedia. 

5. Keluarga Siaga dan pengiriman status Aman atau Perlu Bantuan. 

6. Checklist kesiapsiagaan dan titik kumpul keluarga. 

7. Pelaporan bencana dan status laporan. 

8. Program donasi, pemilihan nominal, dan metode pembayaran. 

9. Layanan darurat dan pengelolaan kontak. 

10. Profil, aktivitas, riwayat, dan pengaturan. 

11. Navigasi utama melalui bilah menu bawah (Beranda, Rute Evakuasi, Laporkan Bencana, Donasi, dan Layanan Darurat). 

7 

### **2.3 Di Luar Ruang Lingkup yang Telah Ditentukan** 

Fitur berikut belum memiliki rancangan lengkap sehingga tidak dianggap sebagai bagian dari fungsi yang sudah ditetapkan: 

1. Halaman Laporan Risiko Lengkap setelah tombol pada fitur Cek Risiko Rumah Anda. 

2. Halaman pemulihan kata sandi. 

3. Mekanisme lengkap pendaftaran melalui Google. 

4. Fitur Galang Dana sebagai proses pengajuan penggalangan dana, baik pada website maupun alur lanjutan mobile. 

5. Penagihan berulang untuk Donasi Bulanan. 

6. Halaman setelah pengguna melanjutkan pembayaran. 

7. Opsi Sembunyikan Nama dan daftar donatur pada website. 

8. Halaman konfirmasi setelah laporan berhasil dikirim pada website. 

9. Pengelolaan anggota keluarga dan perizinan akses keluarga secara lengkap, serta isi tab berlabel "Sebelum" pada halaman Keluarga Siaga. 

10. Mekanisme tindak lanjut terhadap status Perlu Bantuan. 

11. Isi menu Other pada website. 

12. Isi menu Riwayat Bantuan dan halaman lanjutan pengaturan mobile. 

13. Halaman lanjutan dari tombol panah pada kartu beranda website (kelembapan tanah, jumlah kejadian, jumlah korban, dan statistik bencana alam) serta tujuan tombol Selengkapnya pada Info Shelter. 

14. Halaman detail berita pada aplikasi mobile. 

15. Cara pengguna menentukan atau menyimpan lokasi rumah pada fitur Cek Risiko Rumah Anda. 

16. Fungsi panel Perlu Bantuan? pada halaman Maps website. 

17. Isi tiga menu tanpa label pada tampilan Profil ringkas di aplikasi mobile. 

18. Dashboard admin sebagai antarmuka khusus, karena pembagian peran admin belum memiliki mockup. 

19. Integrasi otomatis dengan instansi kebencanaan, penyedia peta, sumber cuaca, atau penyedia pembayaran yang belum ditentukan. 

Daftar tersebut merupakan batasan berdasarkan bahan yang tersedia, bukan larangan untuk merancang fitur tersebut pada tahap pengembangan berikutnya. 

### **2.4 Asumsi dan Batasan** 

### **Asumsi** 

1. Kebutuhan disusun berdasarkan mockup website, mockup aplikasi mobile, dan Aturan Sistem SiagaNow. 

2. Nama lokasi, angka, nominal, tanggal, dan teks contoh pada mockup merupakan contoh tampilan, bukan data aktual. Data aktual berasal dari sumber data yang akan ditetapkan. 

8 

3. Implementasi dapat menggunakan satu jenis akun admin dengan tetap menerapkan pembatasan kewenangan berdasarkan tugas. 

### **Batasan** 

1. Fitur yang belum dirancang tidak dianggap sebagai kebutuhan final (lihat bagian 3.3). 

2. Target performa, kapasitas, ketersediaan, dan kompatibilitas belum ditetapkan. 

3. Penyedia data cuaca, peta, rute, dan pembayaran belum ditentukan. 

4. Teknologi pengembangan mengikuti bagian 10. 

### **3. Pemangku Kepentingan dan Jenis Pengguna** 

### **3.1 Pemangku Kepentingan** 

Pihak yang berkaitan dengan sistem meliputi: 

- Pengguna atau masyarakat. 

- Pengunjung website yang belum memiliki akun. 

- Pengguna terdaftar. 

- Admin sistem. 

- Admin atau petugas kebencanaan. 

- Pengelola program donasi. 

- Pihak penyedia data cuaca, peta, rute, atau pembayaran apabila integrasi diperlukan. Ketersediaan dan bentuk integrasi dengan pihak eksternal masih perlu ditentukan. 

### **3.2 Jenis Pengguna dan Hak Akses** 

|**Jenis pengguna**|**Hak akses dan tanggung jawab**|
|---|---|
|Pengunjung|Mengakses informasi publik sesuai platform tanpa login.|
|Pengguna terdaftar|Menggunakan fitur yang memerlukan autentikasi, sesuai<br>platform dan hak akses.|
|Admin sistem|Mengelola data, akun, konten, dan konfigurasi sesuai<br>kewenangan.|
|Admin atau petugas|Memeriksa laporan, memperbarui status penanganan, dan|
|kebencanaan|mengelola informasi zona serta shelter sesuai kewenangan.|
|Pengelola donasi|Mengelola informasi program, pemeriksaan kelengkapan<br>program, dan pemantauan transaksi sesuai kewenangan.|



Pembagian admin sistem, petugas kebencanaan, dan pengelola donasi merupakan rancangan kebutuhan peran dan belum memiliki mockup. Pembagian tersebut dapat digabung apabila implementasi menggunakan satu jenis akun admin, dengan tetap menerapkan pembatasan kewenangan. 

9 

### **4. Kebutuhan Fungsional Website** 

### **4.1 Autentikasi dan Hak Akses** 

### **FR-WEB-01 - Akses informasi publik** 

Sistem harus memungkinkan pengunjung mengakses beranda, berita, edukasi kebencanaan, peta yang tersedia, zona aman, zona bahaya, dan informasi shelter tanpa login. 

### **FR-WEB-02 - Login pengguna** 

Sistem harus menyediakan halaman login dengan kolom Username/Email dan Password, pilihan Ingat Saya, tautan Lupa kata sandi?, dan tautan Sign Up. 

### **FR-WEB-03 - Pendaftaran akun** 

Sistem harus menyediakan formulir pendaftaran yang mencakup nama lengkap, nomor telepon, email, wilayah domisili, password, konfirmasi password, serta persetujuan Syarat Layanan dan Ketentuan Privasi. 

Mockup juga menyediakan opsi Lanjutkan Dengan Google. Mekanisme opsi tersebut belum dirancang lengkap. Mockup juga menampilkan keterangan batas minimal karakter pada kolom password, tetapi jumlahnya belum ditetapkan (TBD-25). Kolom wilayah domisili dan persetujuan Syarat Layanan hanya ada pada formulir website dan belum ada pada formulir mobile (TBD-20). 

### **FR-WEB-04 - Pembatasan akses** 

Pengguna harus login sebelum menggunakan fitur Donasi, Cek Risiko Rumah Anda, dan membuat laporan bencana melalui website. Daftar dan detail program donasi tetap dapat dilihat pengunjung, sedangkan tindakan donasi dan pembayaran dibatasi sampai pengguna login. 

Jika pengguna belum login dan memilih fitur yang memerlukan autentikasi, sistem harus mengarahkan pengguna ke halaman Login terlebih dahulu. 

### **FR-WEB-05 - Pengelolaan akses admin** 

Sistem harus membatasi akses pengelolaan data dan informasi berdasarkan kewenangan admin atau petugas. 

### **4.2 Beranda dan Informasi Kebencanaan** 

### **FR-WEB-06 - Tampilan informasi beranda** 

Sistem harus menampilkan informasi yang tersedia, meliputi: 

- Peringatan dini dan tingkat peringatan. 

- Suhu dan kondisi cuaca. 

- Suhu terasa, peluang hujan, kecepatan angin, suhu terendah, dan suhu tertinggi. 

- Kelembapan tanah beserta kategorinya. 

- Jumlah kejadian dan jumlah korban beserta persentase perubahan dan keterangan pembandingnya (7 hari terakhir dan seluruh wilayah terdampak), serta statistik bencana alam menurut jenis (tanah longsor dan banjir bandang). 

- Jumlah provinsi terdampak. 

10 

- Berita terbaru. 

- Informasi shelter. 

- Ringkasan program donasi (dana terkumpul, persentase pencapaian, penggalang dana, dan label Identitas Terverifikasi) serta ajakan membuat laporan. 

### **FR-WEB-07 - Penanganan data tidak tersedia** 

Sistem harus memberikan keterangan yang jelas apabila informasi gagal dimuat atau belum tersedia. Pada mockup, kartu Jumlah Provinsi Terdampak menampilkan angka beserta peta, sedangkan kartu COMING SOON adalah kartu terpisah yang menjadi penampung fitur yang belum dirancang. Sistem tidak boleh menampilkan data atau fungsi pada kartu COMING SOON sebelum dirancang, dan angka pada kartu Jumlah Provinsi Terdampak harus berasal dari data kejadian yang tersedia. 

### **4.3 Peta dan Pemeriksaan Risiko Rumah** 

### **FR-WEB-08 - Peta kebencanaan** 

Sistem harus menyediakan peta zona aman dan zona bahaya, lokasi terdampak, daftar zona aman A sampai D beserta kecamatannya, pencarian shelter, daftar zona merah, dan akses ke fitur Cek Risiko Rumah Anda. Pada mockup, panel ketiga di bawah peta tampil dalam dua versi, yaitu Perlu Bantuan? dan Cek Rumah Anda. Fungsi panel Perlu Bantuan? belum ditentukan (TBD-22). 

### **FR-WEB-09 - Pemeriksaan risiko rumah** 

Setelah pengguna login, sistem harus menyediakan informasi pemeriksaan risiko yang mencakup: 

- Zona rawan banjir pada lokasi rumah. 

- Lokasi rumah pada peta. 

- Jarak dari sungai terdekat. 

- Elevasi rumah. 

- Jumlah kejadian dalam lima tahun. 

- Risiko banjir dan perkiraan genangan. 

- Risiko longsor dan jarak dari lereng rawan. 

- Curah hujan beserta kategori dan rentang waktunya. 

- Peringatan untuk lokasi pengguna. 

- Tindakan yang disarankan. 

### **FR-WEB-10 - Validitas hasil pemeriksaan** 

Hasil pemeriksaan harus didasarkan pada data lokasi dan parameter yang tersedia. Jika sebagian data tidak tersedia, sistem harus menjelaskan keterbatasan hasil tersebut. Tindakan yang disarankan tidak boleh menjamin bahwa rumah sepenuhnya aman dari bencana. 

Tombol Lihat Laporan Risiko Lengkap mengikuti mockup, tetapi halaman lanjutannya belum ditentukan. Cara pengguna menentukan atau menyimpan lokasi rumah juga belum 

11 

ditampilkan pada mockup (TBD-21). Lokasi rumah termasuk data pribadi sehingga hanya boleh diakses oleh pemiliknya dan pihak yang berwenang. 

### **4.4 Berita dan Edukasi** 

### **FR-WEB-11 - Daftar berita** 

Sistem harus menampilkan daftar berita dengan judul, ringkasan, tanggal, lokasi kejadian, dan penomoran halaman. 

### **FR-WEB-12 - Detail berita** 

Sistem harus menampilkan judul, kategori kota, jenis bencana dan provinsi, tanggal, isi berita, serta daftar Berita Terkini. Judul, lokasi, dan tanggal pada daftar berita harus sesuai dengan isi detail beritanya. 

### **FR-WEB-13 - Edukasi kebencanaan** 

Sistem harus menyediakan materi Mengenal Bencana Tanah Longsor yang mencakup pengertian, tindakan saat kejadian, langkah pra-bencana, dan tips mitigasi. 

**FR-WEB-14 - Pengelolaan konten** 

Admin atau pengelola konten berwenang dapat menerbitkan, mengubah, atau menghapus berita dan materi edukasi. 

### **4.5 Pelaporan Bencana Website** 

### **FR-WEB-15 - Formulir laporan** 

Sistem harus menyediakan formulir yang memuat judul kejadian, lokasi dan pemilihan lokasi melalui peta, tanggal dan waktu, jumlah korban luka-luka, jumlah korban meninggal, tingkat kerusakan, serta deskripsi kejadian. 

### **FR-WEB-16 - Bukti pendukung** 

Sistem harus memungkinkan pengguna mengunggah gambar atau video jika tersedia. 

### **FR-WEB-17 - Validasi dan pengiriman** 

Sistem harus memvalidasi data sebelum laporan dikirim serta menyediakan tombol Batal, Kirim, dan panel Tips Pelaporan Kejadian. Konfirmasi hanya boleh ditampilkan setelah laporan berhasil disimpan. Tampilan konfirmasi pada website belum dirancang. 

### **FR-WEB-18 - Status laporan** 

Sistem harus menampilkan daftar laporan dengan judul, ringkasan jumlah korban, dan status sesuai data yang tersedia, termasuk Terverifikasi atau Di Tangani. 

Laporan baru tidak boleh langsung dianggap terverifikasi atau sedang ditangani tanpa pemeriksaan yang sesuai. Status awal laporan dan cakupan laporan yang ditampilkan (milik pengguna atau laporan lain) belum ditentukan pada mockup (lihat TBD-05 dan TBD-06). 

### **4.6 Donasi Website** 

### **FR-WEB-19 - Daftar program donasi** 

Sistem harus menampilkan Program Donasi Terbaru, Donasi yang Sering Dikunjungi, kolom pencarian, dan tombol Lihat Donasi Lainnya. 

12 

### **FR-WEB-20 - Detail program** 

Sistem harus menampilkan judul, kategori kota, jenis bencana dan provinsi, dana terkumpul beserta target, persentase pencapaian, informasi penggalang dana, label Identitas Terverifikasi jika sah, serta deskripsi program. 

### **FR-WEB-21 - Nominal dan jenis donasi** 

Sistem harus menyediakan pilihan nominal Rp10.000, Rp20.000, Rp50.000, dan Rp100.000, serta kolom nominal sendiri dengan minimal donasi Rp5.000. Mockup juga menyediakan pilihan Donasi Sekali dan Donasi Bulanan. 

### **FR-WEB-22 - Pembayaran donasi** 

Sistem harus menyediakan ringkasan program, nominal donasi, pesan opsional maksimal 200 karakter, informasi penyaluran dana, dan pilihan metode pembayaran yang benar-benar didukung. 

Pilihan metode pada rancangan meliputi QRIS, transfer bank BCA, BRI, BNI, BSI dan bank lainnya, E-Wallet, serta Virtual Account. Pada mockup, logo e-wallet yang tampil adalah ShopeePay, DANA, GoPay, OVO, dan LinkAja, sedangkan daftar bank pada transfer bank dan Virtual Account juga memuat Mandiri. Daftar akhir mengikuti metode yang benar-benar didukung penyedia pembayaran (TBD-07). 

### **FR-WEB-23 - Perhitungan transaksi** 

Sistem harus menampilkan nominal donasi, biaya layanan, dan total pembayaran berdasarkan perhitungan transaksi yang sebenarnya. Dana terkumpul hanya diperbarui berdasarkan transaksi yang berhasil dikonfirmasi. Mockup menampilkan biaya layanan Rp0 dan menuliskan nominal sebagai "Rp. 50.000.00", sehingga format mata uang perlu diseragamkan. 

Opsi Sembunyikan Nama dan daftar donatur belum dirancang pada website. Fitur Galang Dana sebagai proses pengajuan penggalangan dana juga belum dirancang pada website. 

### **4.7 Navigasi Website** 

### **FR-WEB-24 - Navigasi utama** 

Sistem harus menampilkan bilah navigasi dengan menu Home, Maps, Report, Donate, dan Other pada halaman website, dengan penanda menu yang sedang aktif. Menu Other pada mockup berbentuk menu dropdown yang isinya belum ditetapkan. Panah pada kartu beranda dan tombol Selengkapnya pada Info Shelter mengarah ke halaman lanjutan yang belum seluruhnya dirancang, sehingga tujuannya tidak boleh diasumsikan (TBD-24). 

### **5. Kebutuhan Fungsional Aplikasi Mobile** 

- **5.1 Autentikasi** 

### **FR-MOB-01 - Pendaftaran akun** 

Sistem harus menyediakan formulir nama lengkap, nomor HP, email, password, dan konfirmasi password. Formulir mobile belum memuat wilayah domisili dan persetujuan Syarat 

13 

Layanan seperti pada website. Apakah satu akun berlaku untuk kedua platform perlu ditetapkan (TBD-20). 

### **FR-MOB-02 - Login dan keluar akun** 

Sistem harus menyediakan login menggunakan Username/Email dan Password, tautan Lupa Kata Sandi?, serta mengakhiri sesi ketika pengguna memilih tombol keluar akun (Logout). 

### **FR-MOB-03 - Pembatasan akses** 

Pengguna wajib login untuk mengakses Donasi, membuat laporan bencana, dan menggunakan Keluarga Siaga. Jika pengguna belum login, sistem harus mengarahkan pengguna ke halaman Login. 

Fitur mobile lain, yaitu beranda, berita, cuaca, rute evakuasi, dan layanan darurat, tidak termasuk fitur yang diwajibkan login pada ketentuan saat ini. Kebutuhan akses tanpa login untuk fitur tersebut, termasuk data kontak pribadi, perlu ditetapkan (lihat TBD-15). 

### **5.2 Beranda, Berita, dan Cuaca** 

### **FR-MOB-04 - Beranda mobile** 

Sistem harus menampilkan Berita Terbaru, Peringatan Dini beserta tingkatnya, kartu Keluarga Siaga, dan Cuaca Hari Ini. Beranda juga menampilkan foto profil pengguna di pojok kanan atas serta tombol panah pada kartu berita, Keluarga Siaga, dan cuaca. Akses menuju halaman Profil dari beranda perlu dipastikan (TBD-23). 

### **FR-MOB-05 - Informasi berita** 

Sistem harus menyediakan daftar berita dengan judul, ringkasan, tanggal, lokasi, dan penomoran halaman. Mockup mobile hanya memuat daftar berita sehingga halaman detail berita belum dirancang (TBD-24). 

### **FR-MOB-06 - Informasi cuaca** 

Sistem harus menyediakan pencarian lokasi dan informasi suhu, kondisi cuaca, kelembapan air, kelembapan tanah, kecepatan angin, prakiraan per jam, serta prakiraan harihari mendatang. 

Nilai yang belum tersedia pada mockup tidak boleh dibuat-buat oleh sistem. Suhu dan kondisi cuaca untuk lokasi dan waktu yang sama pada beranda dan halaman Cuaca harus sama. 

### **5.3 Rute Evakuasi dan Shelter** 

### **FR-MOB-07 - Pencarian rute** 

Sistem harus menyediakan peta, pencarian lokasi, tombol Temukan Rute Teraman, dan daftar shelter terdekat beserta jarak serta estimasi waktu perjalanan. Rute yang ditampilkan berdasarkan data yang tersedia dan bukan jaminan keamanan rute. 

### **FR-MOB-08 - Informasi shelter** 

Sistem harus menampilkan foto, nama, alamat, jarak, estimasi waktu, status Shelter Resmi, deskripsi, fasilitas logistik, keamanan, medis, dan toilet, serta tombol Lihat Rute. 

14 

### **FR-MOB-09 - Navigasi evakuasi** 

Sistem harus menampilkan petunjuk arah, jarak ke belokan berikutnya, sisa jarak, estimasi tiba, tombol Lihat Langkah, dan tombol tutup. 

### **FR-MOB-10 - Konfirmasi kedatangan** 

Halaman Anda Telah Tiba harus menampilkan nama dan alamat shelter, jarak, waktu tempuh, kondisi jalur, mode perjalanan, dan tombol Kirim Status Aman. 

Jarak dan estimasi waktu untuk shelter yang sama harus konsisten pada halaman yang berkaitan. Kolom kondisi jalur hanya menampilkan keterangan yang didukung data. Sistem tidak boleh menjamin keamanan rute. 

### **5.4 Keluarga Siaga** 

### **FR-MOB-11 - Informasi keluarga** 

Sistem harus menampilkan rencana aktif, nama keluarga, jumlah anggota yang sudah berkabar, daftar anggota dan statusnya, checklist kesiapsiagaan, titik kumpul keluarga, dan kontak darurat. 

### **FR-MOB-12 - Status anggota** 

Sistem harus membedakan status Aman, Perlu Bantuan, dan No Info. Status No Info tidak boleh dianggap sebagai Aman atau Perlu Bantuan, dan status Perlu Bantuan harus dapat dibedakan jelas pada tampilan. Mockup saat ini menandai anggota berstatus No Info dengan warna merah dan belum menampilkan contoh status Perlu Bantuan. Karena merah lazim dipahami sebagai tanda bahaya, penanda No Info perlu dibedakan dari penanda Perlu Bantuan agar keluarga tidak salah menilai kondisi anggota. 

### **FR-MOB-13 - Pengiriman status** 

Sistem harus menyediakan pilihan Aman dan Perlu Bantuan, kotak centang Bagikan Lokasi Terakhir kepada Keluarga, dan tombol Simpan Status. Pilihan status tidak boleh terisi otomatis. Pada mockup, pilihan Aman tampak sudah terpilih sebelum pengguna memilih, padahal status Aman hanya boleh tampil jika pengguna benar-benar memilihnya. 

**FR-MOB-14 - Konfirmasi status** 

Sistem harus menampilkan halaman Status Tersimpan setelah status berhasil disimpan. Lokasi terakhir hanya dibagikan dan ditampilkan apabila pengguna menyetujui pembagian lokasi. 

Pengelolaan anggota keluarga, izin akses secara lengkap, isi tab berlabel "Sebelum", dan tindak lanjut status Perlu Bantuan belum dirancang. 

### **5.5 Pelaporan Bencana Mobile** 

### **FR-MOB-15 - Formulir laporan** 

Sistem harus menyediakan nama kejadian, lokasi melalui peta, tanggal dan waktu, jumlah korban luka-luka, jumlah korban meninggal, tingkat bencana, dan deskripsi kejadian. 

15 

### **FR-MOB-16 - Pengiriman dan konfirmasi** 

Sistem harus memvalidasi formulir, menyediakan unggahan gambar atau video jika tersedia, serta menampilkan halaman Laporan Tersimpan setelah data berhasil disimpan. Informasi lokasi terakhir pada halaman tersebut harus berasal dari data lokasi yang benar-benar tersedia. Halaman Laporan Tersimpan pada mockup menampilkan nama shelter sebagai lokasi terakhir, sedangkan formulir memuat lokasi kejadian. Apakah yang ditampilkan adalah lokasi kejadian atau lokasi terakhir pengguna perlu ditetapkan (lihat Lampiran B). 

### **FR-MOB-17 - Riwayat laporan** 

Pengguna harus dapat melihat laporan miliknya melalui menu Laporan Bencana Saya sesuai informasi yang tersedia. 

### **5.6 Donasi Mobile** 

### **FR-MOB-18 - Daftar program** 

Sistem harus menampilkan tab Donasi dan Galang Dana, tombol Kategori, pencarian, serta daftar program beserta judul, deskripsi singkat, dana terkumpul dari target, progres, dan tombol Donasi Sekarang. 

### **FR-MOB-19 - Detail donasi** 

Sistem harus menampilkan foto, dana terkumpul, persentase pencapaian, penggalang dana, status verifikasi, informasi kejadian, ucapan penyemangat, serta tombol Donasi Sekarang. Informasi kejadian harus sesuai dengan judul, lokasi, dan jenis bencana pada program. 

### **FR-MOB-20 - Pemilihan nominal** 

Sistem harus menyediakan nominal Rp5.000, Rp10.000, Rp20.000, Rp50.000, Rp100.000, Rp150.000, Rp200.000, Rp500.000, dan Rp1.000.000, serta kolom Nominal Donasi Lainnya. Batas minimal pada kolom Nominal Donasi Lainnya belum tercantum pada mockup mobile. Batas minimal Rp5.000 pada website diusulkan berlaku sama (TBD-25). 

### **FR-MOB-21 - Metode pembayaran** 

Sistem harus menampilkan QRIS, BCA, BRI, ShopeePay, BNI, dan Metode Lainnya. Pengguna hanya dapat memilih metode yang benar-benar didukung. Daftar metode pada mobile berbeda bentuk dengan website (QRIS, transfer bank, e-wallet, dan Virtual Account), sehingga keduanya perlu mengacu pada satu daftar metode yang didukung penyedia pembayaran (TBD-07). 

### **FR-MOB-22 - Data donatur** 

Sistem harus menyediakan kolom nama, opsi Sembunyikan Nama, email, serta ucapan atau keterangan. Data wajib divalidasi sebelum proses pembayaran dilanjutkan. 

### **FR-MOB-23 - Privasi donatur** 

Pilihan Sembunyikan Nama harus diterapkan pada tampilan publik, tanpa menghilangkan data yang dibutuhkan untuk pemrosesan transaksi. 

Halaman setelah tombol Lanjutkan Pembayaran dan alur pengajuan Galang Dana belum dirancang. 

16 

### **5.7 Layanan Darurat dan Kontak** 

### **FR-MOB-24 - Layanan darurat** 

Sistem harus menyediakan kartu BASARNAS dan BPBD dengan tombol Hubungi, kontak orang terdekat, tombol Daftar Kontak Darurat, serta opsi Tinggalkan Pesan Suara. Nomor instansi yang tersedia pada awal penggunaan adalah nomor instansi sesuai lokasi pengguna yang terlacak. 

### **FR-MOB-25 - Daftar kontak** 

Sistem harus menyediakan kontak BPBD, Basarnas, Polisi, Pemadam Kebakaran, Rumah Sakit Terdekat, serta kontak orang tua atau kerabat. 

### **FR-MOB-26 - Pengelolaan kontak** 

Pengguna dapat mengubah atau menambahkan kontak melalui tombol Edit/Tambah Kontak, termasuk apabila nomor instansi tidak sesuai atau tidak tersedia. Informasi kontak instansi harus diperiksa dan diperbarui agar tidak mengarahkan pengguna ke nomor yang salah. 

Tombol Hubungi dan Tinggalkan Pesan Suara hanya boleh menyatakan tindakan berhasil apabila tindakan tersebut benar-benar berhasil. 

### **5.8 Profil dan Pengaturan** 

### **FR-MOB-27 - Profil** 

Sistem harus menampilkan foto profil, nama, username, tombol Edit, Hubungi Kami, dan tombol keluar akun. Mockup memuat dua tampilan profil. Tampilan ringkas berisi nama, username, tiga menu tanpa label, tombol Hubungi Kami, dan tombol Logout. Tampilan lengkap berisi tombol Edit, menu Aktivitas, menu Pengaturan, dan tombol Keluar. Hubungan antara kedua tampilan serta isi tiga menu tanpa label belum ditentukan (TBD-23). 

### **FR-MOB-28 - Aktivitas pengguna** 

Sistem harus menyediakan menu Riwayat Donasi, Laporan Bencana Saya, dan Riwayat Bantuan. Pengguna hanya dapat melihat riwayat yang berkaitan dengan akunnya. 

### **FR-MOB-29 - Pengaturan** 

Sistem harus menyediakan menu Notifikasi, Gaya dan Tampilan, Keamanan dan Privasi, Pusat Bantuan, serta Tentang Aplikasi. 

Isi halaman lanjutan menu pengaturan dan Riwayat Bantuan masih perlu ditentukan. 

### **5.9 Navigasi Aplikasi** 

### **FR-MOB-30 - Navigasi utama** 

Sistem harus menyediakan bilah navigasi bawah dengan lima ikon menuju Beranda, Rute Evakuasi, Laporkan Bencana, Donasi, dan Layanan Darurat, serta penanda ikon yang sedang aktif. Ikon pada mockup tidak diberi label teks sehingga nama menu mengikuti judul halaman tujuannya. Halaman Berita, Cuaca, dan Keluarga Siaga dibuka dari kartu pada beranda, sedangkan akses Profil perlu dipastikan (TBD-23). Pada halaman Keluarga Siaga, penanda aktif menyorot ikon Layanan Darurat sehingga perlu diseragamkan (lihat Lampiran B). 

17 

### **6. Kebutuhan Pengelolaan Admin** 

Bagian ini memuat kebutuhan pengelolaan oleh admin yang tercantum pada Aturan Sistem SiagaNow. Mockup website dan mobile hanya menampilkan sisi pengguna, sehingga antarmuka admin belum memiliki rancangan tampilan (TBD-12). 

### **FR-ADM-01 - Pengelolaan informasi kebencanaan** 

Admin atau petugas berwenang harus dapat memperbarui peringatan dini, data cuaca yang digunakan, statistik, zona risiko, informasi shelter, dan jalur evakuasi sesuai kewenangannya. 

### **FR-ADM-02 - Pemeriksaan laporan** 

Admin atau petugas berwenang harus dapat melihat laporan yang masuk dari website dan mobile, memeriksa informasi serta bukti pendukungnya, dan memperbarui status laporan sesuai hasil pemeriksaan. 

### **FR-ADM-03 - Pengelolaan konten** 

Admin atau pengelola konten harus dapat menambah, mengubah, dan menghapus berita serta materi edukasi sesuai kewenangannya. 

### **FR-ADM-04 - Pengelolaan program donasi** 

Pengelola donasi harus dapat memperbarui informasi program, memeriksa kelengkapan program, memastikan label Identitas Terverifikasi dan dana terkumpul sesuai data yang sah, serta memantau status transaksi. 

### **FR-ADM-05 - Pengelolaan hak akses** 

Sistem harus memastikan setiap pengguna dan admin hanya dapat membuka dan mengubah data yang menjadi kewenangannya, termasuk pengelolaan akun pengguna oleh admin sistem. 

### **FR-ADM-06 - Pemantauan aktivitas penting** 

Sistem harus menyediakan catatan perubahan data dan status yang memuat waktu serta pihak yang melakukan perubahan, untuk keperluan pemeriksaan apabila terjadi kesalahan atau penyalahgunaan. 

Apabila implementasi hanya menggunakan satu jenis akun admin, kewenangan di atas dapat digabung dengan tetap membatasi akses berdasarkan tugas. 

### **7. Aturan Bisnis dan Sistem** 

### **7.1 Autentikasi** 

1. Website mewajibkan login untuk Donasi, Cek Risiko Rumah Anda, dan pembuatan laporan bencana. 

2. Daftar dan detail program donasi pada website dapat dilihat pengunjung, sedangkan tindakan donasi dan pembayaran memerlukan login. 

3. Mobile mewajibkan login untuk Donasi, pembuatan laporan bencana, dan Keluarga Siaga. 

4. Sistem harus memvalidasi data pendaftaran dan login. 

18 

5. Pengguna hanya boleh mengakses data dan fungsi sesuai hak aksesnya. 

6. Keluar akun (Logout) harus mengakhiri sesi pengguna. 

### **7.2 Akurasi Informasi Kebencanaan** 

1. Data risiko, cuaca, korban, zona bencana, shelter, dan rute harus didukung sumber data yang tersedia. 

2. Informasi yang belum tersedia atau belum terverifikasi tidak boleh disajikan seolaholah pasti. 

3. Sumber dan waktu pembaruan informasi dinamis sebaiknya ditampilkan. 

4. Informasi rute, kondisi jalur, dan hasil pemeriksaan risiko bukan jaminan keselamatan. 

5. Jika data gagal dimuat, sistem harus memberikan keterangan yang jelas dan tidak menganggap kondisi tersebut sebagai kondisi aman. 

6. Label Shelter Resmi hanya diberikan berdasarkan verifikasi yang dapat dipertanggungjawabkan. 

7. Data contoh pada mockup yang saling bertentangan (lihat Lampiran B) harus diseragamkan sebelum digunakan sebagai data uji atau data awal. 

### **7.3 Pelaporan dan Pemeriksaan** 

1. Data laporan harus divalidasi sebelum dikirim. 

2. Bukti pendukung dapat disertakan jika tersedia. 

3. Laporan baru harus melalui proses pemeriksaan sebelum dinyatakan terverifikasi atau ditangani. 

4. Status laporan hanya dapat diperbarui oleh pihak berwenang dan tidak dapat diubah pengguna secara sepihak. 

5. Perubahan status penting sebaiknya memiliki catatan waktu dan pihak yang melakukan perubahan. 

6. Informasi korban hilang hanya boleh ditampilkan apabila datanya tersedia pada laporan. 

### **7.4 Donasi dan Pembayaran** 

1. Persentase pencapaian dihitung berdasarkan dana terkumpul dibandingkan target. 

2. Label Identitas Terverifikasi hanya diberikan setelah verifikasi yang ditetapkan. 

3. Total pembayaran harus sesuai dengan nominal donasi dan biaya layanan. 

4. Dana terkumpul hanya diperbarui berdasarkan transaksi berhasil yang telah dikonfirmasi. 

5. Data donatur dan riwayat donasi harus dilindungi. 

6. Opsi pembayaran hanya boleh menampilkan metode yang benar-benar didukung. 

7. Opsi Sembunyikan Nama tersedia pada mobile dan belum dirancang pada website. 

8. Penggalangan dana dan Donasi Bulanan tidak boleh dianggap memiliki mekanisme lengkap sebelum dirancang. 

19 

### **7.5 Keluarga Siaga dan Privasi Lokasi** 

1. Status Aman hanya ditampilkan setelah anggota terkait mengirim status tersebut. 

2. Status No Info tidak boleh dianggap sebagai kondisi aman. 

3. Status Perlu Bantuan harus dibedakan secara jelas dari status Aman dan No Info. 

4. Jumlah anggota yang sudah berkabar dihitung berdasarkan anggota yang telah mengirim status. 

5. Lokasi terakhir hanya dibagikan sesuai pilihan dan persetujuan pengguna. 

6. Informasi keluarga dan lokasi hanya boleh diakses oleh pihak yang memiliki izin. 

7. Pilihan status Aman atau Perlu Bantuan tidak boleh terpilih sebelum pengguna memilihnya. 

### **7.6 Hak Akses Admin** 

Admin atau petugas hanya boleh mengelola informasi sesuai kewenangan yang diberikan. Pengelolaan dapat mencakup data kebencanaan, shelter, berita, edukasi, laporan, program donasi, akun, dan konfigurasi sistem. 

### **8. Kebutuhan Nonfungsional** 

### **8.1 Keamanan** 

- Password dan data pribadi harus dilindungi dari akses yang tidak sah. 

- Akses terhadap laporan, lokasi, kontak keluarga, dan riwayat transaksi harus dibatasi. 

- Lokasi rumah pada pemeriksaan risiko dan lokasi terakhir pengguna diperlakukan sebagai data pribadi. 

- Pengelolaan data harus mengikuti hak akses pengguna. 

- Perubahan penting pada data sebaiknya dapat ditelusuri. 

### **8.2 Keakuratan dan Konsistensi Data** 

- Informasi yang sama harus konsisten antarhalaman dan antarplatform. 

- Informasi cuaca pada beranda dan halaman Cuaca harus berasal dari sumber data yang sama untuk lokasi dan waktu yang sama. 

- Jarak dan estimasi waktu shelter harus konsisten pada daftar, detail, navigasi, dan halaman kedatangan. 

- Dana terkumpul, target, persentase pencapaian, dan status transaksi harus konsisten, termasuk untuk program donasi yang sama pada website dan mobile. 

- Informasi kejadian, judul, dan lokasi pada satu program donasi harus saling sesuai. 

### **8.3 Validasi dan Penanganan Kesalahan** 

- Sistem harus memvalidasi kelengkapan dan format data sebelum menyimpan informasi. 

- Sistem harus memberikan keterangan ketika koneksi gagal, data tidak ditemukan, atau proses tidak berhasil. 

20 

- Konfirmasi keberhasilan hanya boleh ditampilkan setelah proses terkait benar-benar berhasil. 

- Sistem tidak boleh mengarang hasil ketika data pendukung tidak tersedia. 

### **8.4 Ketersediaan Informasi** 

- Informasi kebencanaan yang dinamis sebaiknya mencantumkan sumber dan waktu pembaruan. 

- Data yang sudah tidak tersedia atau gagal dimuat harus ditangani dengan keterangan yang jelas. 

- Informasi penting mengenai rute dan kondisi jalur harus menunjukkan keterbatasan data apabila relevan. 

### **8.5 Kompatibilitas Platform** 

Sistem dikembangkan dalam bentuk website dan aplikasi mobile dengan kebutuhan teknologi yang telah ditentukan. Pengujian kompatibilitas perangkat, browser, ukuran layar, dan versi sistem operasi masih perlu ditetapkan pada tahap teknis. 

Target performa, waktu respons, kapasitas pengguna, ketersediaan layanan, dan target pemulihan sistem belum ditentukan dalam bahan kebutuhan. 

### **9. Teknologi dan Lingkungan Pengembangan** 

Teknologi yang telah ditentukan untuk pengembangan SiagaNow adalah: 

|**Komponen**|**Teknologi**|**Versi**|
|---|---|---|
|Framework aplikasi mobile|Flutter (channel stable)|3.47.2|
|Framework Website|Laravel|13.35.0|
|Bahasa pemrograman aplikasi<br>mobile|Dart|3.13.2|
|Alat bantu pengembangan|Flutter DevTools|2.60.0|
|Lingkungan pengembangan<br>lokal|Laragon|8.7.0|
|Sistem basis data|MySQL|8.4.3|
|Web server|Apache|2.4.68|



Versi Flutter, Dart, dan DevTools dicatat sesuai keluaran perintah flutter --version, sedangkan versi komponen lainnya dicatat sesuai informasi yang diberikan. 

Pembagian arsitektur website, API antara website dan mobile, struktur basis data, autentikasi teknis, layanan penyimpanan media, lingkungan produksi, bahasa atau framework website, serta metode integrasi eksternal belum ditentukan secara lengkap dalam bahan BRD ini (lihat TBD-19). 

21 

### **10. Ketergantungan dan Hal yang Belum Ditentukan** 

Beberapa kebutuhan memerlukan penetapan lebih lanjut sebelum implementasi. 

|**ID**|**Kebutuhan yang perlu**<br>**dipastikan**|**Keterangan**|
|---|---|---|
|TBD-01|Sumber data cuaca dan<br>peringatan dini|Penyedia data dan frekuensi pembaruan belum<br>ditentukan.|
|TBD-02|Data zona risiko dan<br>pemeriksaan rumah|Sumber data elevasi, sungai, kejadian lima tahun,<br>genangan, lereng rawan, dan curah hujan belum<br>ditentukan.|
|TBD-03|Peta dan navigasi|Penyedia peta, perhitungan rute, dan pembaruan<br>kondisi jalur belum ditentukan.|
|TBD-04|Autentikasi|Mekanisme sesi, pemulihan kata sandi, dan<br>pendaftaran Google belum dirancang lengkap.|
|TBD-05|Status laporan|Status awal laporan dan alur pemeriksaan perlu<br>ditetapkan.|
|TBD-06|Cakupan Lihat Status|Belum ditentukan apakah pengguna melihat<br>laporan miliknya saja atau laporan lain.|
|TBD-07|Pembayaran donasi|Penyedia pembayaran, konfirmasi transaksi, biaya<br>layanan, dan dukungan metode pembayaran perlu<br>ditetapkan.|
|TBD-08|Donasi Bulanan|Mekanisme penagihan berulang belum dirancang.|
|TBD-09|Galang Dana|Proses pengajuan, verifikasi, dan pengelolaan<br>penggalangan dana belum dirancang.|
|TBD-10|Keluarga Siaga|Pengelolaan anggota keluarga, izin akses, dan isi<br>tab berlabel "Sebelum" belum dirancang lengkap.|
|TBD-11|Kontak dan pesan suara|Mekanisme panggilan, perekaman atau<br>pengiriman pesan suara, dan sumber data nomor<br>instansi sesuai lokasi perlu ditentukan.|
|TBD-12|Admin|Antarmuka, pembagian peran, dan detail<br>kewenangan perlu ditetapkan.|
|TBD-13|Halaman lanjutan|Laporan Risiko Lengkap, pembayaran, pemulihan<br>kata sandi, konfirmasi laporan pada website,<br>menu Other, dan beberapa halaman pengaturan<br>belum dirancang lengkap.|
|TBD-14|Target nonfungsional|Target performa, kapasitas, ketersediaan,<br>kompatibilitas, dan target indikator keberhasilan<br>perlu ditetapkan.|



22 

|**ID**|**Kebutuhan yang perlu**<br>**dipastikan**|**Keterangan**|
|---|---|---|
|TBD-15|Akses fitur mobile tanpa<br>login|Perlu ditetapkan apakah beranda, berita, cuaca,<br>rute evakuasi, layanan darurat, dan data kontak<br>pribadi dapat diakses tanpa login. (Berita, Kondisi<br>Cuaca Serta Peringatan Dini daerah Lokasi<br>pengguna bisa digunakan tanpa login, dengan<br>syarat pengizinan penggunaan Lokasi meskipun<br>tanpa login, untuk fitur lainnya diperlukan login<br>akun)|
|TBD-16|Tindak lanjut status Perlu<br>Bantuan|Penerima dan tindak lanjut status Perlu Bantuan<br>belum ditentukan.|
|TBD-17|Izin lokasi|Mekanisme izin akses lokasi pada perangkat<br>untuk pelacakan lokasi pengguna perlu<br>ditentukan.|
|TBD-18|Prioritas kebutuhan|Klasifikasi prioritas rinci setiap kebutuhan<br>fungsional belum ditetapkan.|
|TBD-19|Lingkungan teknis|Lingkungan produksi, arsitektur, dan API belum<br>ditentukan.|
|TBD-20|Akun lintas platform|Belum ditentukan apakah satu akun berlaku untuk<br>website dan mobile, serta perbedaan kolom<br>wilayah domisili dan persetujuan Syarat Layanan<br>antarplatform.|
|TBD-21|Lokasi rumah pada Cek<br>Risiko|Cara pengguna menentukan dan menyimpan<br>lokasi rumah, jumlah rumah yang dapat disimpan,<br>dan sumber penentuan zona rawan banjir belum<br>ditentukan.|
|TBD-22|Panel Perlu Bantuan?|Fungsi panel pada halaman Maps website dan<br>hubungannya dengan panel Cek Rumah Anda<br>belum ditentukan.|
|TBD-23|Profil mobile|Akses ke Profil dari beranda perlu ditentukan.<br>(akses ke profil di pojok atas kanan beranda.<br>Done)|
|TBD-24|Halaman lanjutan informasi|Detail berita mobile, halaman lanjutan kartu<br>beranda website belum dirancang. (Sudah<br>Terpikirkan, Belum DI Tambahkan. Done)|



23 

|**ID**|**Kebutuhan yang perlu**<br>**dipastikan**|**Keterangan**|
|---|---|---|
|TBD-25|Aturan isian|Jumlah minimal karakter password, batas<br>minimal Nominal Donasi Lainnya pada mobile,<br>dan batas panjang ucapan donasi mobile belum<br>ditetapkan. (Done)|
|TBD-26|Data contoh mockup|Ketidaksesuaian data pada mockup (Lampiran B)<br>perlu diperbaiki atau dinyatakan sebagai data<br>contoh sebelum dijadikan data uji. (Data Memang<br>masi absurd karen Buat uji desain saja. Done)|



Daftar ini bukan penambahan fitur. Daftar ini menunjukkan bagian yang belum memiliki keputusan cukup jelas untuk dijadikan ketentuan implementasi final. 

### **11. Kriteria Penerimaan Bisnis** 

Sistem dapat dievaluasi terhadap kriteria berikut: 

1. Pengunjung dapat mengakses informasi publik sesuai rancangan. 

2. Sistem menerapkan kewajiban login sesuai aturan masing-masing platform, dan daftar program donasi pada website tetap dapat dilihat pengunjung. 

3. Website menyediakan peta kebencanaan dan fitur pemeriksaan risiko rumah berdasarkan data yang tersedia. 

4. Aplikasi mobile menyediakan rute evakuasi, informasi shelter, dan Keluarga Siaga sesuai mockup. 

5. Formulir laporan memvalidasi data dan hanya menampilkan konfirmasi setelah penyimpanan berhasil. 

6. Status laporan mencerminkan proses pemeriksaan dan tidak berubah tanpa kewenangan. 

7. Informasi program donasi, nominal, target, dana terkumpul, dan status pembayaran konsisten. 

8. Pengguna dapat mengirim status keluarga dengan pilihan pembagian lokasi yang jelas. 

9. Sistem membatasi akses terhadap informasi pribadi sesuai hak akses. 

10. Sistem memberikan keterangan yang jelas ketika data tidak tersedia atau proses gagal. 

11. Fitur yang belum dirancang tidak ditampilkan seolah-olah sudah memiliki mekanisme lengkap. 

12. Informasi rute, kondisi jalur, dan hasil pemeriksaan risiko tidak disajikan sebagai jaminan keselamatan. 

13. Data yang sama tampil identik pada seluruh halaman dan platform, sesuai Lampiran B setelah diperbaiki. 

14. Pilihan status Aman atau Perlu Bantuan tidak terisi otomatis sebelum dipilih pengguna. 

24 

Kriteria tersebut merupakan dasar evaluasi bisnis. Detail skenario pengujian, data uji, dan target kuantitatif perlu ditentukan pada tahap pengujian sistem. 

### **12. Kesimpulan** 

SiagaNow merupakan sistem informasi kebencanaan berbasis website dan aplikasi mobile yang berfokus pada bencana banjir dan tanah longsor. 

Website menonjolkan fitur Cek Risiko Rumah Anda sebagai sarana memperoleh informasi risiko di sekitar tempat tinggal, didukung peta kebencanaan, berita, edukasi, pelaporan, dan donasi. 

Aplikasi mobile menonjolkan fitur Rute Evakuasi dan Keluarga Siaga untuk membantu pengguna menemukan shelter, memperoleh informasi perjalanan, mempersiapkan keluarga, serta menyampaikan status Aman atau Perlu Bantuan. 

Pengembangan sistem harus memperhatikan akurasi informasi, validasi data, keamanan, privasi, konsistensi antarplatform, serta pembatasan hak akses. Informasi risiko dan rute harus diperlakukan sebagai informasi pendukung, bukan jaminan keselamatan. 

BRD ini menjadi dasar kebutuhan bisnis awal SiagaNow. Hal-hal yang belum memiliki keputusan atau rancangan lengkap harus ditetapkan lebih lanjut sebelum dijadikan persyaratan implementasi final. 

**Lampiran A. Glosarium** 

|**Istilah**|**Pengertian dalam SiagaNow**|
|---|---|
|Shelter|Tempat yang disiapkan sebagai lokasi evakuasi sementara untuk<br>berkumpul dan berlindung hingga kondisi sekitar dinyatakan<br>aman.|
|Shelter Resmi|Label pada shelter yang hanya diberikan berdasarkan verifikasi<br>yang dapat dipertanggungjawabkan.|
|Zona Aman|Wilayah yang ditampilkan pada peta sebagai zona aman, seperti<br>Zona Aman A sampai D pada mockup website.|
|Zona Bahaya|Wilayah yang ditampilkan pada peta sebagai zona bahaya.|
|Zona Merah|Wilayah yang pada mockup website tercantum sebagai zona<br>yang perlu dihindari pengguna.|
|Cek Risiko Rumah<br>Anda|Fitur website untuk melihat informasi risiko banjir dan longsor<br>pada lokasi rumah pengguna berdasarkan data yang tersedia.|
|Keluarga Siaga|Fitur mobile untuk memantau status anggota keluarga, checklist<br>kesiapsiagaan, titik kumpul, dan pengiriman status.|
|Status Aman|Status yang hanya ditampilkan setelah anggota keluarga yang<br>bersangkutan memilih atau mengirimkannya.|



25 

|**Istilah**|**Pengertian dalam SiagaNow**|
|---|---|
|Status Perlu Bantuan|Status yang dikirim anggota keluarga untuk menyatakan<br>membutuhkan bantuan, dan dibedakan dari Aman dan No Info.|
|No Info|Keadaan ketika anggota belum mengirim status; tidak dianggap<br>Aman maupun Perlu Bantuan.|
|Titik Kumpul Keluarga|Lokasi berkumpul keluarga yang pada mockup ditampilkan<br>berupa shelter beserta jaraknya.|
|Identitas Terverifikasi|Label penggalang dana yang hanya diberikan setelah proses<br>verifikasi yang ditetapkan.|
|Peringatan Dini|Informasi peringatan beserta tingkatnya yang mengikuti kategori<br>dari sumber informasi.|
|Galang Dana|Tab pada mockup mobile dan konsep pengajuan penggalangan<br>dana oleh pengguna; belum memiliki halaman dan mekanisme.|
|Donasi Bulanan|Pilihan pada mockup website yang mekanisme penagihan<br>berulangnya belum dirancang.|
|Lokasi Terakhir|Informasi lokasi pengguna yang dibagikan pada status keluarga<br>atau ditampilkan setelah data tersimpan, sesuai data yang<br>tersedia dan persetujuan pengguna.|



### **Lampiran B. Ketidaksesuaian Data dan Tampilan pada Mockup** 

Tabel berikut mencatat bagian mockup yang saling bertentangan atau berpotensi menimbulkan salah tafsir saat implementasi. Data pada mockup diperlakukan sebagai contoh tampilan, tetapi pertentangan antarhalaman perlu diperbaiki lebih dahulu karena dapat terbawa menjadi data uji atau aturan sistem yang keliru. 

|**ID**|**Temuan pada mockup**|**Alasan dan tindak lanjut**|
|---|---|---|
|B-01|Jarak dan waktu Shelter Kuranji berbeda<br>antarhalaman mobile: daftar Rute<br>Evakuasi menampilkan 500 M dan +3<br>Menit, Keluarga Siaga 500 Meter,<br>Informasi Shelter 300 M dan 4+ Menit,<br>navigasi 300 M dan 3 Menit, serta Anda<br>Telah Tiba 300 Meter dan 3 Menit.|Shelter yang sama harus memakai<br>satu sumber data. Tetapkan satu nilai<br>jarak dan waktu per shelter. Jika<br>yang dimaksud adalah sisa jarak saat<br>bernavigasi, beri label yang<br>membedakannya.|
|B-02|Suhu Padang berbeda: beranda mobile<br>menampilkan 25° C, sedangkan halaman<br>Cuaca mobile dan beranda website<br>menampilkan 28° C dengan kondisi yang<br>sama (Cerah Berawan).|Lokasi dan waktu yang sama harus<br>menampilkan nilai yang sama.<br>Samakan nilai pada ketiga halaman.|



26 

|**ID**|**Temuan pada mockup**|**Alasan dan tindak lanjut**|
|---|---|---|
|B-03|Prakiraan cuaca per jam memakai ikon<br>hujan petir pada semua jam, padahal<br>kondisi saat ini Cerah Berawan, dan<br>prakiraan hari mendatang memakai satu<br>ikon yang sama untuk semua hari.|Ikon harus mengikuti data prakiraan<br>agar tidak menyesatkan. Gunakan<br>ikon sesuai kondisi tiap jam dan hari.|
|B-04|Persentase donasi tidak sesuai hitungan:<br>mobile menampilkan Rp90.000.000 dari<br>Rp95.000.000 dengan 92%, sedangkan<br>hasil bagi kedua angka sekitar 94,7%.<br>Pada website, target ditampilkan<br>terpotong ("dari p..." atau "dari 000000").|Persentase dihitung dari dana<br>terkumpul dibanding target, dan<br>target harus tampil lengkap. Perbaiki<br>angka dan tampilkan target secara<br>utuh.|
|B-05|Angka Rp90.000.000 dan 92% muncul<br>pada program yang berbeda: Bantuan<br>korban Tanah Longsor oleh Basnaz.Hub<br>(mobile) dan Bantuan Banjir Kota Padang<br>oleh Ratatoulie Corp. (halaman detail<br>website). Beranda website menampilkan<br>donasi banjir bandang Rp40.000.000<br>(80%) oleh Basnaz.Hub, sedangkan<br>program banjir bandang pada daftar<br>donasi website menampilkan<br>Rp12.000.000 oleh Ratatoulie Corp.<br>Nama penggalang dana juga ditulis<br>berbeda-beda (Basnaz.Hub,<br>BAZNAZ.HUB, Ratatoulie, Ratatouile).|Program yang sama harus memiliki<br>penggalang dana, dana terkumpul,<br>dan target yang sama di semua<br>halaman dan platform. Tetapkan data<br>contoh per program dan seragamkan<br>penulisan nama penggalang dana.|
|B-06|Informasi Kejadian pada program<br>Bantuan korban Tanah Longsor di Padang<br>(mobile) berisi gempa M7,7 dan tsunami<br>di Flores, Nusa Tenggara Timur, tanggal<br>15 Agustus 2026.|Informasi kejadian harus sesuai<br>judul, lokasi, dan jenis bencana pada<br>program. Ganti teks dengan kejadian<br>tanah longsor di Padang.|
|B-07|Daftar shelter berbeda antarplatform:<br>beranda website menampilkan Shelter<br>UNP, Nurul Iman, dan Ahmad Yani,<br>sedangkan mobile menampilkan Shelter<br>Kuranji, Kurao, dan Lumin.|Jika perbedaan disebabkan oleh<br>lokasi pengguna, kedua platform<br>tetap harus membaca data dari<br>sumber shelter yang sama.|
|B-08|Ringkasan berita Banjir bandang landa<br>Kota Sawahlunto pada halaman Semua<br>Berita website menyebut Kota Padang.|Judul, lokasi, dan ringkasan berita<br>harus sesuai. Perbaiki ringkasan.|



27 

|**ID**|**Temuan pada mockup**|**Alasan dan tindak lanjut**|
|---|---|---|
|B-09|Rincian pembayaran donasi website<br>menuliskan nominal "Rp. 50.000.00".|Seragamkan format mata uang,<br>misalnya Rp50.000.|
|B-10|Pada Keluarga Siaga, anggota berstatus<br>No Info (Adek) ditandai merah dan tidak<br>ada contoh status Perlu Bantuan.|Merah lazim berarti bahaya sehingga<br>bisa tertukar dengan Perlu Bantuan.<br>Beri penanda berbeda untuk No Info<br>dan Perlu Bantuan.|
|B-11|Pada halaman Status Aman, pilihan Aman<br>tampak sudah terpilih sebelum pengguna<br>memilih.|Status Aman hanya boleh tampil jika<br>dipilih pengguna. Buat kedua pilihan<br>kosong pada awal tampilan.|
|B-12|Halaman Laporan Tersimpan dan Status<br>Tersimpan sama-sama menampilkan<br>"Shelter Kuranji, Lokasi Terakhir, Baru<br>Saja".|Pada laporan bencana, lokasi yang<br>relevan adalah lokasi kejadian.<br>Tentukan lokasi apa yang<br>ditampilkan dan pastikan berasal dari<br>data yang tersedia.|
|B-13|Bilah navigasi bawah mobile tidak<br>memiliki label teks, dan pada halaman<br>Keluarga Siaga penanda aktif menyorot<br>ikon telepon (Layanan Darurat).|Tambahkan label dan sesuaikan<br>penanda aktif dengan halaman yang<br>sedang dibuka.|
|B-14|Satu halaman memiliki dua versi: panel<br>ketiga pada Maps website (Perlu Bantuan?<br>dan Cek Rumah Anda) serta tampilan<br>Profil mobile (ringkas dan lengkap).|Tentukan versi yang berlaku atau<br>hubungan keduanya (TBD-22 dan<br>TBD-23).|
|B-15|BRD versi 1.2 dan Aturan Sistem<br>menyebut kartu Jumlah Provinsi<br>Terdampak bertanda COMING SOON.<br>Pada mockup, kartu tersebut menampilkan<br>7 provinsi beserta peta, sedangkan<br>COMING SOON berada pada kartu<br>terpisah.|BRD telah dikoreksi pada FR-WEB-<br>07. Aturan Sistem bagian 3.1.B butir<br>5 sebaiknya diperbarui agar sama.|
|B-16|Foto pada identitas penggalang dana dan<br>foto profil pengguna pada mockup berupa<br>foto orang.|Pada pengembangan, gunakan logo<br>resmi penggalang dana dan foto yang<br>izin penggunaannya jelas.|



28 

