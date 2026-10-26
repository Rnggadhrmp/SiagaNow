<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\RiskCheckController;
use App\Models\Shelter;
use App\Services\BmkgForecastService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Route;

Route::get('/', function (BmkgForecastService $forecastService) {
    try {
        $featuredShelters = Shelter::query()
            ->whereNotNull('verified_at')
            ->whereBetween('latitude', [-90, 90])
            ->whereBetween('longitude', [-180, 180])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest('verified_at')
            ->limit(3)
            ->get(['id', 'name', 'address', 'latitude', 'longitude', 'verified_at']);
        $shelterDatabaseAvailable = true;
    } catch (QueryException $exception) {
        report($exception);
        $featuredShelters = collect();
        $shelterDatabaseAvailable = false;
    }

    return view('welcome', [
        'demoMode' => (bool) config('siaganow.demo_mode'),
        'demoWeather' => config('siaganow.demo_weather'),
        'demoStatistics' => config('siaganow.demo_statistics'),
        'weatherForecast' => $forecastService->getForecast(),
        'featuredShelters' => $featuredShelters,
        'shelterDatabaseAvailable' => $shelterDatabaseAvailable,
    ]);
})->name('home');

// Maps dan pencarian shelter
Route::get('/maps', [MapsController::class, 'index'])
    ->name('maps');

// Konten edukasi dan katalog donasi bersifat publik menurut BRD.
Route::view('/informasi-banjir', 'informasi-banjir')->name('informasi-banjir');
Route::view('/informasi-longsor', 'informasi-longsor')->name('informasi-longsor');
Route::view('/statistik-kejadian', 'statistik-kejadian')->name('statistik-kejadian');
Route::view('/panduan-kesiapsiagaan', 'panduan-kesiapsiagaan')->name('panduan-kesiapsiagaan');
Route::view('/berita-kebencanaan', 'berita-kebencanaan')->name('berita-kebencanaan');
Route::get('/donate', function () {
    return view('donate', [
        'demoMode' => (bool) config('siaganow.demo_mode'),
        'demoCampaigns' => config('siaganow.demo_campaigns'),
    ]);
})->name('donate');

Route::get('/donate/program/{campaign}', function (string $campaign) {
    abort_unless((bool) config('siaganow.demo_mode'), 404);

    $selectedCampaign = collect(config('siaganow.demo_campaigns'))
        ->firstWhere('id', $campaign);

    abort_unless(is_array($selectedCampaign), 404);

    return view('donate', [
        'demoMode' => true,
        'demoCampaigns' => config('siaganow.demo_campaigns'),
        'selectedCampaign' => $selectedCampaign,
    ]);
})->name('donate.program.show');

// Halaman yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::get('/risk-check', [RiskCheckController::class, 'index'])
        ->name('risk-check');

    Route::post('/risk-check', [RiskCheckController::class, 'store'])
        ->name('risk-check.store');

    Route::get('/report', function () {
        return view('report');
    })->name('report');

    Route::post('/report', [DisasterReportController::class, 'store'])
        ->name('report.store');

    Route::get('/report/status', [DisasterReportController::class, 'index'])
        ->name('report.status');

    // Profil pengguna
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
});

// Autentikasi untuk pengguna yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

// Logout hanya untuk pengguna yang sudah login
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
