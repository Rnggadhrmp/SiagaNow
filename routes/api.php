<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FamilyGroupController;
use App\Http\Controllers\RiskCheckController;
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
    Route::get('/risk-assessments', [RiskCheckController::class, 'indexMobile'])
        ->name('api.risk-assessments.index');
    Route::post('/risk-assessments', [RiskCheckController::class, 'store'])
        ->name('api.risk-assessments.store');

    Route::get('/family-groups', [FamilyGroupController::class, 'index'])
        ->name('api.family-groups.index');
    Route::post('/family-groups', [FamilyGroupController::class, 'store'])
        ->name('api.family-groups.store');
    Route::get('/family-groups/{familyGroup}', [FamilyGroupController::class, 'show'])
        ->name('api.family-groups.show');
    Route::put('/family-groups/{familyGroup}', [FamilyGroupController::class, 'update'])
        ->name('api.family-groups.update');
    Route::delete('/family-groups/{familyGroup}', [FamilyGroupController::class, 'destroy'])
        ->name('api.family-groups.destroy');
    Route::post('/family-groups/{familyGroup}/members', [FamilyGroupController::class, 'storeMember'])
        ->name('api.family-groups.members.store');
    Route::put('/family-groups/{familyGroup}/members/{member}', [FamilyGroupController::class, 'updateMember'])
        ->name('api.family-groups.members.update');
    Route::delete('/family-groups/{familyGroup}/members/{member}', [FamilyGroupController::class, 'destroyMember'])
        ->name('api.family-groups.members.destroy');
    Route::post('/family-groups/{familyGroup}/members/{member}/invitation', [FamilyGroupController::class, 'createInvitation'])
        ->name('api.family-groups.members.invitation');
    Route::post('/family-invitations/accept', [FamilyGroupController::class, 'acceptInvitation'])
        ->name('api.family-invitations.accept');
    Route::get('/family-memberships', [FamilyGroupController::class, 'memberships'])
        ->name('api.family-memberships.index');
    Route::get('/family-groups/{familyGroup}/check-ins', [FamilyGroupController::class, 'checkIns'])
        ->name('api.family-groups.check-ins');
    Route::post('/family-members/{member}/check-in', [FamilyGroupController::class, 'checkIn'])
        ->name('api.family-members.check-in');
    Route::patch('/family-members/{member}/reminders', [FamilyGroupController::class, 'updateReminder'])
        ->name('api.family-members.reminders');
});
