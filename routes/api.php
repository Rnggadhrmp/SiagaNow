<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicInfoController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\WeatherWarningController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:6,1')
    ->name('api.register');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:6,1')
    ->name('api.login');

Route::get('/home', [PublicInfoController::class, 'home'])->name('api.home');
Route::get('/weather-forecast', [PublicInfoController::class, 'weather'])->name('api.weather-forecast');
Route::get('/news', [PublicInfoController::class, 'news'])->name('api.news');
Route::get('/shelters', [MapsController::class, 'search'])->name('api.shelters.search');
Route::get('/weather-warning', [WeatherWarningController::class, 'check'])
    ->name('api.weather-warning.check');

Route::middleware(['auth:sanctum', 'abilities:mobile'])->group(function () {
    Route::get('/user', [AuthController::class, 'me'])->name('api.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/reports', [DisasterReportController::class, 'apiIndex'])
        ->name('api.reports.index');
    Route::post('/reports', [DisasterReportController::class, 'store'])
        ->name('api.reports.store');
});
