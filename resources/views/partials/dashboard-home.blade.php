<main id="home-dashboard" class="dashboard-page" aria-label="Dashboard informasi SiagaNow">
    @php
        $homeShelters = $featuredShelters->isNotEmpty()
            ? $featuredShelters
            : ($demoMode ? collect(config('siaganow.demo_shelters', [])) : collect());
        $forecastCurrent = $weatherForecast['current'] ?? null;
        $weatherIsActual = ($weatherForecast['data_type'] ?? 'unavailable') === 'actual';
        $weatherIsSimulated = ($weatherForecast['data_type'] ?? 'unavailable') === 'simulation';
    @endphp

    <div class="dashboard-columns">
        <section class="dashboard-primary" aria-label="Informasi utama kesiapsiagaan">
            <article class="dash-alert" aria-labelledby="alert-title">
                <img class="dash-illustration dash-alert-art" src="{{ asset('images/dashboard-warning-illustration-soft.png') }}" alt="">
                <div class="dash-alert-copy">
                    <p class="dash-kicker">Peringatan dini</p>
                    <h1 id="alert-title">Status peringatan belum diperiksa</h1>
                    <p>Halaman ini tidak memeriksa poligon peringatan secara otomatis. Periksa kanal resmi BMKG dan BPBD sebelum mengambil keputusan.</p>
                </div>
                <a class="dash-source-link" href="https://www.bmkg.go.id/alerts/nowcast/id" target="_blank" rel="noopener noreferrer">Periksa BMKG <span aria-hidden="true">↗</span></a>
            </article>

            <article class="dash-weather" aria-labelledby="weather-title">
                <img class="dash-illustration dash-weather-art" src="{{ asset('images/dashboard-weather-illustration-soft.png') }}" alt="">
                <div class="dash-weather-main">
                    <h2 id="weather-title">Kondisi Cuaca</h2>
                    <p class="dash-location">{{ $weatherForecast['location'] ?? 'Wilayah belum tersedia' }}</p>
                    @if (is_array($forecastCurrent) && is_numeric($forecastCurrent['temperature'] ?? null))
                        <p class="dash-temperature">{{ number_format($forecastCurrent['temperature'], 0) }}<span>°C</span></p>
                        <p class="dash-condition">{{ $forecastCurrent['condition'] ?: 'Kondisi belum tersedia' }}</p>
                    @else
                        <p class="dash-condition dash-unavailable">Prakiraan belum tersedia</p>
                    @endif
                </div>
                <dl class="dash-weather-details">
                    @if ($weatherIsActual && is_array($forecastCurrent))
                        @if (is_numeric($forecastCurrent['rain_mm'] ?? null))
                            <div><dt>Curah hujan</dt><dd>{{ number_format($forecastCurrent['rain_mm'], 1) }} mm</dd></div>
                        @endif
                        @if (is_numeric($forecastCurrent['wind_kmh'] ?? null))
                            <div><dt>Kecepatan angin</dt><dd>{{ number_format($forecastCurrent['wind_kmh'], 0) }} km/jam</dd></div>
                        @endif
                        @if (is_numeric($forecastCurrent['humidity'] ?? null))
                            <div><dt>Kelembapan udara</dt><dd>{{ $forecastCurrent['humidity'] }}%</dd></div>
                        @endif
                    @elseif ($weatherIsSimulated)
                        <div><dt>Peluang hujan · simulasi</dt><dd>{{ $demoWeather['rain_chance'] ?? '—' }}%</dd></div>
                        <div><dt>Kecepatan angin · simulasi</dt><dd>{{ $demoWeather['wind_kmh'] ?? '—' }} km/jam</dd></div>
                        <div><dt>Sumber</dt><dd>Data contoh</dd></div>
                    @else
                        <div><dt>Data cuaca</dt><dd>Belum tersedia</dd></div>
                    @endif
                </dl>
                <p class="dash-weather-note">
                    @if ($weatherIsActual)
                        Prakiraan BMKG untuk wilayah administrasi. Pembaruan sumber: {{ $weatherForecast['updated_at'] ?? 'waktu tidak tersedia' }}.
                    @elseif ($weatherIsSimulated)
                        Nilai demonstrasi, bukan prakiraan aktual. {{ $weatherForecast['message'] ?? '' }}
                    @else
                        {{ $weatherForecast['message'] ?? 'Sumber prakiraan belum tersedia.' }}
                    @endif
                </p>
            </article>

            <article class="dash-soil" aria-labelledby="soil-title">
                <img class="dash-illustration dash-soil-art" src="{{ asset('images/dashboard-soil-illustration-soft.png') }}" alt="">
                <div class="dash-soil-copy">
                    <h2 id="soil-title">Kelembapan Tanah</h2>
                    <p class="dash-soil-value">Belum tersedia</p>
                    <p>SiagaNow belum memiliki sensor tanah terverifikasi untuk wilayah ini.</p>
                </div>
                <span class="dash-status-label">Data belum tersedia</span>
            </article>

            @php
                $floodStatusLabels = ['normal' => 'Normal · hasil model', 'warning' => 'Waspada', 'danger' => 'Bahaya', 'unknown' => 'Unknown'];
                $floodReviewLabels = ['pending' => 'Belum ditinjau petugas', 'verified' => 'Ditinjau petugas', 'rejected' => 'Ditolak petugas'];
                $floodLatest = $floodDetection['latest_observation'] ?? null;
            @endphp
            <article class="dash-ai-flood" aria-labelledby="ai-flood-title">
                <div class="dash-ai-flood-mark" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M3 16c2.2 0 2.2-2 4.5-2S9.8 16 12 16s2.2-2 4.5-2S18.8 16 21 16M3 20c2.2 0 2.2-2 4.5-2s2.3 2 4.5 2 2.2-2 4.5-2 2.3 2 4.5 2M12 3v8m-3-3 3 3 3-3"/></svg></div>
                <div class="dash-ai-flood-copy">
                    <h2 id="ai-flood-title">AI Flood Detection</h2>
                    <p class="dash-ai-flood-status">{{ $floodStatusLabels[$floodDetection['status'] ?? 'unknown'] ?? 'Unknown' }}</p>
                    <p>{{ $floodDetection['message'] ?? 'Observasi AI belum tersedia.' }}</p>
                    @if ($floodLatest)
                        <small>{{ data_get($floodLatest, 'camera.name', 'Sumber tidak tersedia') }} · Observasi {{ $floodLatest['observed_at'] ?? 'waktu tidak tersedia' }}@if(is_numeric($floodLatest['confidence'] ?? null)) · Confidence {{ number_format($floodLatest['confidence'] * 100, 1) }}%@endif · {{ $floodReviewLabels[$floodLatest['verification_status'] ?? 'pending'] ?? 'Status tinjauan tidak diketahui' }}</small>
                    @endif
                </div>
                <p class="dash-ai-flood-note">Hasil AI bukan peringatan resmi. Jika data tidak ada atau kedaluwarsa, status tetap Unknown.</p>
            </article>

            <div class="dash-stat-row" aria-label="Ringkasan statistik bencana">
                <article class="dash-stat" aria-labelledby="events-title">
                    <h2 id="events-title">Jumlah Kejadian</h2>
                    <div class="dash-stat-content">
                        <span class="dash-stat-mark" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M4 20V4M4 20h16M8 16v-4M12 16V8M16 16v-7"/></svg></span>
                        <div>
                            <p class="dash-stat-value">{{ $demoMode ? number_format($demoStatistics['events'] ?? 0) : '—' }}</p>
                            <p class="dash-stat-note">{{ $demoMode ? 'Angka latihan, bukan rekap aktual' : 'Sumber statistik belum terhubung' }}</p>
                        </div>
                    </div>
                </article>
                <article class="dash-stat" aria-labelledby="people-title">
                    <h2 id="people-title">Jumlah Korban</h2>
                    <div class="dash-stat-content">
                        <span class="dash-stat-mark" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><circle cx="9" cy="8" r="3"/><path d="M3.5 19c.6-3.1 2.4-4.7 5.5-4.7s4.9 1.6 5.5 4.7M17 5.5a2.5 2.5 0 0 1 0 5M16.5 14.5c2.2.4 3.5 1.9 4 4.5"/></svg></span>
                        <div>
                            <p class="dash-stat-value">{{ $demoMode ? number_format($demoStatistics['affected_people'] ?? 0) : '—' }}</p>
                            <p class="dash-stat-note">{{ $demoMode ? 'Contoh terdampak · data simulasi' : 'Data korban belum tersedia' }}</p>
                        </div>
                    </div>
                </article>
            </div>

            <article class="dash-disaster-stats" aria-labelledby="disaster-stats-title">
                <span class="dash-stats-mark" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M4 20V4M4 20h16M8 16v-4M12 16V8M16 16v-7"/></svg></span>
                <div>
                    <h2 id="disaster-stats-title">Statistik Bencana Alam</h2>
                    <p>Rincian kejadian terverifikasi belum tersedia.</p>
                </div>
                <a href="https://data.bnpb.go.id/dataset/data-bencana-indonesia" target="_blank" rel="noopener noreferrer">Lihat sumber BNPB <span aria-hidden="true">↗</span></a>
            </article>
        </section>

        <aside class="dashboard-aside" aria-label="Informasi terbaru dan layanan">
            <section class="dash-latest" aria-labelledby="latest-title">
                <div class="dash-news-photo">
                    <img src="{{ asset('images/figma-dashboard-news.jpeg') }}" alt="Ilustrasi kondisi rumah setelah banjir, dari aset mockup SiagaNow">
                    <span class="dash-news-label" id="latest-title">Informasi Terbaru</span>
                    <span class="dash-photo-note">Foto ilustrasi mockup, bukan dokumentasi kejadian terkini</span>
                </div>
                <div class="dash-latest-copy">
                    <h2>Berita kebencanaan</h2>
                    <p>Feed berita terverifikasi belum terhubung. Lihat pembaruan dari kanal resmi BPBD atau BNPB.</p>
                    <div class="dash-news-links">
                        <a href="https://bpbd.sumbarprov.go.id/publikasi/berita" target="_blank" rel="noopener noreferrer">BPBD Sumatera Barat ↗</a>
                        <a href="https://bnpb.go.id/berita" target="_blank" rel="noopener noreferrer">BNPB ↗</a>
                    </div>
                </div>
                <div class="dash-campaign-state">
                    <div><span class="dash-campaign-mark" aria-hidden="true">♡</span><div><h3>Informasi Donasi</h3><p>Belum ada penggalangan dana terverifikasi yang terhubung.</p></div></div>
                    <a href="{{ route('donate') }}">Lihat program <span aria-hidden="true">›</span></a>
                </div>
            </section>

            <section class="dash-shelters" aria-labelledby="shelter-title">
                <div class="dash-shelter-heading">
                    <span class="dash-shelter-mark" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="m3 10 9-7 9 7M5 9v12h14V9M9 21v-7h6v7"/></svg></span>
                    <div><h2 id="shelter-title">Info Shelter</h2><p>{{ $featuredShelters->isNotEmpty() ? 'Lokasi terverifikasi dari database' : ($demoMode ? 'Data simulasi · bukan lokasi evakuasi resmi' : 'Belum ada lokasi terverifikasi') }}</p></div>
                </div>
                @if ($homeShelters->isNotEmpty())
                    <ul class="dash-shelter-list">
                        @foreach ($homeShelters->take(3) as $shelter)
                            @php
                                $shelterIsSimulated = (bool) data_get($shelter, 'is_simulated', false);
                                $shelterAddress = data_get($shelter, 'address');
                            @endphp
                            <li>
                                <span class="dash-pin" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
                                <span><strong>{{ data_get($shelter, 'name', 'Shelter') }}</strong><small>{{ $shelterIsSimulated ? 'Contoh simulasi' : ($shelterAddress ?: 'Alamat belum dicatat') }}</small></span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="dash-shelter-empty">Daftar shelter akan ditampilkan setelah koordinat dan sumbernya diverifikasi.</p>
                @endif
                <a class="dash-shelter-action" href="{{ route('maps') }}">Selengkapnya</a>
            </section>
        </aside>
    </div>

    <section class="dashboard-bottom" aria-label="Aksi dan informasi lainnya">
        <article class="dash-bottom-report">
            <span class="dash-report-mark" aria-hidden="true">＋</span>
            <div><h2>Buat Laporan Bencana</h2><p>Laporkan kejadian yang kamu saksikan untuk membantu proses pemeriksaan.</p><a href="{{ route('report') }}">Buat laporan sekarang</a></div>
        </article>
        <article class="dash-bottom-provinces">
            <div><h2>Jumlah Provinsi Terdampak</h2><p>Belum tersedia</p><small>Belum ada ringkasan terverifikasi yang terhubung.</small></div>
            <img src="{{ asset('images/dashboard-indonesia-map-soft.png') }}" alt="Ilustrasi peta kepulauan Indonesia dari mockup">
        </article>
        <article class="dash-coming-soon"><h2>COMING<br>SOON</h2><p>Informasi ini belum tersedia.</p></article>
    </section>
</main>
