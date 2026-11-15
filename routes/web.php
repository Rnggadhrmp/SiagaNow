<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\ShelterController;
use App\Http\Controllers\Admin\HazardZoneController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\DonationCampaignController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AiMonitoringController;
use App\Http\Controllers\Admin\AffectedRoadController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\NewsPublicController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\RiskCheckController;
use App\Models\Shelter;
use App\Services\BmkgForecastService;
use App\Services\FloodDetectionService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Route;

Route::get('/', function (BmkgForecastService $forecastService, FloodDetectionService $floodDetection) {
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
        'floodDetection' => $floodDetection->summary(),
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
Route::get('/berita-kebencanaan', [NewsPublicController::class, 'index'])->name('berita-kebencanaan');
Route::get('/berita/{article:slug}', [NewsPublicController::class, 'show'])->name('news.show');
Route::get('/donate', function () {
    $campaigns = \App\Models\DonationCampaign::publiclyActive()->latest('verified_at')->get();
    return view('donate', [
        'demoMode' => (bool) config('siaganow.demo_mode'),
        'demoCampaigns' => config('siaganow.demo_campaigns'),
        'verifiedCampaigns' => $campaigns,
    ]);
})->name('donate');

Route::get('/donate/program/{campaign}', function (string $campaign) {
    $verifiedCampaign = \App\Models\DonationCampaign::publiclyActive()->where('slug', $campaign)->first();
    if ($verifiedCampaign) {
        return view('donate', [
            'demoMode' => false,
            'demoCampaigns' => config('siaganow.demo_campaigns'),
            'verifiedCampaigns' => \App\Models\DonationCampaign::publiclyActive()->latest('verified_at')->get(),
            'selectedCampaign' => $verifiedCampaign,
        ]);
    }

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
Route::middleware(['auth', 'active.account'])->group(function () {
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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])->middleware('throttle:6,1')->name('login.store');
    });

    Route::middleware(['auth', 'active.account'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::middleware('admin.permission:dashboard.view')->group(function () {
            Route::get('/', DashboardController::class)->name('dashboard');
        });

        Route::middleware('admin.permission:alerts.manage')->group(function () {
            Route::resource('alerts', AlertController::class)->except('show', 'destroy');
            Route::patch('/alerts/{alert}/verification', [AlertController::class, 'verify'])->name('alerts.verify');
            Route::patch('/alerts/{alert}/status', [AlertController::class, 'updateStatus'])->name('alerts.status');
        });

        Route::middleware('admin.permission:zones.manage')->group(function () {
            Route::get('/hazard-zones', [HazardZoneController::class, 'index'])->name('zones.index');
            Route::get('/hazard-zones/create', [HazardZoneController::class, 'create'])->name('zones.create');
            Route::post('/hazard-zones', [HazardZoneController::class, 'store'])->name('zones.store');
            Route::get('/hazard-zones/{zone}/edit', [HazardZoneController::class, 'edit'])->name('zones.edit');
            Route::put('/hazard-zones/{zone}', [HazardZoneController::class, 'update'])->name('zones.update');
            Route::patch('/hazard-zones/{zone}/verification', [HazardZoneController::class, 'verify'])->name('zones.verify');
        });

        Route::middleware('admin.permission:shelters.manage')->group(function () {
            Route::resource('shelters', ShelterController::class)->except('show', 'destroy');
            Route::patch('/shelters/{shelter}/verification', [ShelterController::class, 'verify'])->name('shelters.verify');
        });

        Route::middleware('admin.permission:reports.manage')->group(function () {
            Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
            Route::patch('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.status');
            Route::get('/reports/{report}/evidence/{index}', [AdminReportController::class, 'evidence'])->name('reports.evidence');
        });

        Route::middleware('admin.permission:news.manage')->group(function () {
            Route::resource('news', AdminNewsController::class)->except('show')->parameters(['news' => 'article']);
            Route::patch('/news/{article}/publication', [AdminNewsController::class, 'updatePublication'])->name('news.publication');
        });

        Route::middleware('admin.permission:donations.manage')->group(function () {
            Route::resource('donations', DonationCampaignController::class)->except('show', 'destroy');
            Route::patch('/donations/{campaign}/verification', [DonationCampaignController::class, 'verify'])->name('donations.verify');
            Route::patch('/donations/{campaign}/status', [DonationCampaignController::class, 'updateStatus'])->name('donations.status');
        });

        Route::middleware('admin.permission:users.view')->group(function () {
            Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
            Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        });
        Route::middleware('admin.permission:users.manage')->group(function () {
            Route::patch('/users/{user}/status', [AdminUserController::class, 'updateStatus'])->name('users.status');
            Route::patch('/users/{user}/roles', [AdminUserController::class, 'updateRoles'])->name('users.roles');
        });

        Route::middleware('admin.permission:ai.manage')->group(function () {
            Route::get('/ai', [AiMonitoringController::class, 'index'])->name('ai.index');
            Route::post('/ai/cameras', [AiMonitoringController::class, 'storeCamera'])->name('ai.cameras.store');
            Route::get('/ai/cameras/{camera}/edit', [AiMonitoringController::class, 'editCamera'])->name('ai.cameras.edit');
            Route::put('/ai/cameras/{camera}', [AiMonitoringController::class, 'updateCamera'])->name('ai.cameras.update');
            Route::patch('/ai/detections/{detection}/verification', [AiMonitoringController::class, 'verifyDetection'])->name('ai.detections.verify');
        });

        Route::middleware('admin.permission:roads.manage')->group(function () {
            Route::resource('roads', AffectedRoadController::class)->except('show', 'destroy');
            Route::patch('/roads/{road}/verification', [AffectedRoadController::class, 'verify'])->name('roads.verify');
            Route::patch('/roads/{road}/status', [AffectedRoadController::class, 'updateStatus'])->name('roads.status');
        });

        Route::middleware('admin.permission:audit.view')->group(function () {
            Route::get('/audit-logs', AuditLogController::class)->name('audit.index');
        });

        Route::middleware('admin.permission:alerts.manage')->group(function () {
            Route::get('/weather', [DashboardController::class, 'weather'])->name('weather');
        });
    });
});
