<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAlert;
use App\Models\AdminAuditLog;
use App\Models\AiCameraSource;
use App\Models\AiDetection;
use App\Models\DisasterReport;
use App\Models\DonationCampaign;
use App\Models\NewsArticle;
use App\Models\Shelter;
use App\Models\User;
use App\Models\WeatherWarning;
use App\Services\BmkgForecastService;
use App\Services\FloodDetectionService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(FloodDetectionService $floodDetection): View
    {
        $aiSummary = $floodDetection->summary();

        return view('admin.dashboard', [
            'stats' => [
                'users' => User::query()->count(),
                'reports' => DisasterReport::query()->count(),
                'pendingReports' => DisasterReport::query()->whereIn('status', ['submitted', 'pending', 'under_review'])->count(),
                'verifiedShelters' => Shelter::query()->whereNotNull('verified_at')->count(),
                'news' => NewsArticle::query()->count(),
                'activeAlerts' => AdminAlert::publiclyActive()->count(),
            ],
            'aiServiceStatus' => $aiSummary['service_status'],
            'aiSummary' => $aiSummary,
            'aiCameraCount' => AiCameraSource::query()->count(),
            'latestDetection' => AiDetection::query()->with('camera')->latest('observed_at')->first(),
            'recentActivity' => AdminAuditLog::query()->with('actor')->latest('created_at')->limit(8)->get(),
            'campaignCount' => DonationCampaign::query()->count(),
        ]);
    }

    public function weather(BmkgForecastService $forecastService): View
    {
        return view('admin.weather', [
            'forecast' => $forecastService->getForecast(),
            'warnings' => WeatherWarning::query()->latest('last_fetched_at')->paginate(15),
        ]);
    }
}
