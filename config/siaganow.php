<?php

return [
    'demo_mode' => (bool) env('SIAGANOW_DEMO_MODE', true),
    // BMKG forecast is issued by village/kelurahan code (adm4), not an exact address.
    'bmkg_adm4' => env('SIAGANOW_BMKG_ADM4', '13.71.01.1001'),

    'demo_weather' => [
        'location' => 'Padang, Sumatera Barat (contoh lokasi)',
        'temperature' => 28,
        'condition' => 'Cerah berawan',
        'feels_like' => 29,
        'rain_chance' => 35,
        'wind_kmh' => 12,
        'low' => 24,
        'high' => 31,
        'source' => 'Contoh Data SiagaNow — bukan prakiraan aktual',
    ],

    'demo_statistics' => [
        'events' => 20,
        'affected_people' => 1020,
        'source' => 'Data latihan, bukan statistik kejadian aktual',
    ],

    'demo_campaigns' => [
        [
            'id' => 'demo-campaign-flood-padang',
            'title' => 'Paket Kesiapsiagaan Banjir',
            'location' => 'Padang, Sumatera Barat (contoh)',
            'description' => 'Contoh rencana pengadaan tas siaga, lampu darurat, dan perlengkapan air bersih untuk demonstrasi tampilan.',
            'organizer' => 'Penyelenggara simulasi SiagaNow',
            'target' => 50000000,
            'collected' => 15000000,
            'period_start' => '2026-10-01',
            'period_end' => '2026-12-31',
            'illustration' => 'flood',
        ],
        [
            'id' => 'demo-campaign-evacuation-kit',
            'title' => 'Perlengkapan Evakuasi Keluarga',
            'location' => 'Sumatera Barat (contoh)',
            'description' => 'Contoh rencana paket kebutuhan dasar: peluit, senter, kotak P3K, dan tas dokumen untuk latihan antarmuka.',
            'organizer' => 'Penyelenggara simulasi SiagaNow',
            'target' => 80000000,
            'collected' => 24000000,
            'period_start' => '2026-10-15',
            'period_end' => '2027-01-31',
            'illustration' => 'kit',
        ],
        [
            'id' => 'demo-campaign-landslide-kit',
            'title' => 'Paket Tanggap Tanah Longsor',
            'location' => 'Sumatera Barat (contoh)',
            'description' => 'Contoh daftar perlengkapan logistik awal dan kebersihan untuk memperlihatkan rencana program, bukan penyaluran nyata.',
            'organizer' => 'Penyelenggara simulasi SiagaNow',
            'target' => 60000000,
            'collected' => 18000000,
            'period_start' => '2026-10-20',
            'period_end' => '2027-02-28',
            'illustration' => 'landslide',
        ],
    ],

    'demo_news' => [
        [
            'id' => 'demo-news-flood-padang',
            'title' => 'Contoh berita simulasi banjir di Kota Padang',
            'summary' => 'Item ini hanya contoh antarmuka dan tidak menyatakan adanya kejadian saat ini.',
            'published_at' => '2026-10-01T09:00:00+07:00',
            'location' => 'Padang, Sumatera Barat (contoh)',
            'source' => 'Contoh Data SiagaNow',
            'is_simulated' => true,
        ],
        [
            'id' => 'demo-news-landslide-preparedness',
            'title' => 'Contoh materi kesiapsiagaan tanah longsor',
            'summary' => 'Contoh konten edukasi. Ikuti informasi resmi BPBD dan BNPB di wilayah Anda.',
            'published_at' => '2026-10-03T09:00:00+07:00',
            'location' => 'Sumatera Barat (contoh)',
            'source' => 'Contoh Data SiagaNow',
            'is_simulated' => true,
        ],
    ],

    // Contoh koordinat untuk menguji tampilan saja; bukan shelter resmi.
    'demo_shelters' => [
        [
            'id' => 'demo-shelter-kuranji',
            'name' => 'Contoh Shelter Kuranji',
            'address' => 'Kuranji, Kota Padang (lokasi simulasi)',
            'latitude' => -0.9135,
            'longitude' => 100.3972,
            'capacity' => 120,
            'status' => 'simulation',
            'source' => 'Data Simulasi SiagaNow',
            'is_simulated' => true,
        ],
        [
            'id' => 'demo-shelter-padang-utara',
            'name' => 'Contoh Titik Evakuasi Padang Utara',
            'address' => 'Padang Utara, Kota Padang (lokasi simulasi)',
            'latitude' => -0.9102,
            'longitude' => 100.3548,
            'capacity' => 80,
            'status' => 'simulation',
            'source' => 'Data Simulasi SiagaNow',
            'is_simulated' => true,
        ],
        [
            'id' => 'demo-shelter-pauh',
            'name' => 'Contoh Titik Evakuasi Pauh',
            'address' => 'Pauh, Kota Padang (lokasi simulasi)',
            'latitude' => -0.9203,
            'longitude' => 100.4561,
            'capacity' => 60,
            'status' => 'simulation',
            'source' => 'Data Simulasi SiagaNow',
            'is_simulated' => true,
        ],
    ],
];
