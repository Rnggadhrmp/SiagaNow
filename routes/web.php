<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\RiskCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherWarningController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Maps dan pencarian shelter
Route::get('/maps', [MapsController::class, 'index'])
    ->name('maps');

Route::get('/api/shelters', [MapsController::class, 'search'])
    ->name('shelters.search');

// Halaman yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::get('/risk-check', [RiskCheckController::class, 'index'])
        ->name('risk-check');

    Route::post('/risk-check', [RiskCheckController::class, 'store'])
        ->name('risk-check.store');

    Route::get('/report', function () {
        return view('report');
    })->name('report');

    Route::get('/donate', function () {
        return view('donate');
    })->name('donate');

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

    Route::get('/api/weather-warning', [
    WeatherWarningController::class,
    'check',
])->name('weather-warning.check');