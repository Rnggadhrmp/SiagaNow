<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BmkgForecastService;
use App\Services\FloodDetectionService;
use App\Models\NewsArticle;
use App\Models\DonationCampaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicInfoController extends Controller
{
    public function home(BmkgForecastService $forecastService, FloodDetectionService $floodDetection): JsonResponse
    {
        $demoMode = (bool) config('siaganow.demo_mode');
        $forecast = $forecastService->getForecast();
        $statistics = $demoMode
            ? array_merge(config('siaganow.demo_statistics'), ['data_type' => 'simulation'])
            : ['data_type' => 'unavailable', 'message' => 'Sumber statistik kejadian terverifikasi belum terhubung.'];

        return response()->json([
            'data_type' => $forecast['data_type'],
            'updated_at' => now()->toIso8601String(),
            'weather' => array_merge($forecast['current'] ?? [], [
                'data_type' => $forecast['data_type'],
                'source' => $forecast['source'],
                'location' => $forecast['location'],
                'updated_at' => $forecast['updated_at'],
                'message' => $forecast['message'],
            ]),
            'weather_forecast' => $forecast,
            'statistics' => $statistics,
            'flood_detection' => $floodDetection->summary(),
            'warning' => [
                'status' => 'unknown',
                'active' => false,
                'title' => null,
                'message' => 'Status peringatan tidak diperiksa oleh endpoint prakiraan ini. Periksa peringatan BMKG atau BPBD secara terpisah.',
                'source' => null,
            ],
            'demo_mode' => $demoMode,
        ]);
    }

    public function weather(BmkgForecastService $forecastService): JsonResponse
    {
        $forecast = $forecastService->getForecast();

        return response()->json($forecast, $forecast['status'] === 'unavailable' ? 503 : 200);
    }

    public function news(Request $request): JsonResponse
    {
        $articles = NewsArticle::published()->latest('published_at')->limit(50)->get();
        if ($articles->isNotEmpty()) {
            return response()->json([
                'data' => $articles->map(fn (NewsArticle $article) => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'summary' => $article->summary,
                    'published_at' => $article->published_at?->toIso8601String(),
                    'location' => null,
                    'source' => $article->is_simulation ? 'Contoh Data SiagaNow' : $article->source_name,
                    'source_url' => $article->source_url,
                    'image_url' => $article->image_path
                        ? $request->getSchemeAndHttpHost().'/storage/'.ltrim($article->image_path, '/')
                        : null,
                    'image_caption' => $article->image_alt,
                    'is_simulated' => $article->is_simulation,
                    'url' => route('news.show', $article->slug),
                ])->values(),
                'data_type' => 'database',
                'source' => 'SiagaNow',
                'message' => 'Artikel ini dikelola SiagaNow; periksa sumber per artikel.',
            ]);
        }

        if (!config('siaganow.demo_mode')) {
            return response()->json([
                'data' => [],
                'data_type' => 'unavailable',
                'message' => 'Sumber berita terverifikasi belum terhubung.',
            ]);
        }

        return response()->json([
            'data' => config('siaganow.demo_news'),
            'data_type' => 'simulation',
            'source' => 'Contoh Data SiagaNow',
            'message' => 'Semua item adalah contoh, bukan laporan kejadian aktual.',
        ]);
    }

    public function donationCampaigns(): JsonResponse
    {
        $campaigns = DonationCampaign::publiclyActive()->latest('verified_at')->limit(50)->get([
            'id', 'title', 'slug', 'description', 'organizer', 'target_amount',
            'source_name', 'source_url', 'starts_at', 'ends_at', 'verified_at', 'updated_at',
        ]);

        return response()->json([
            'data' => $campaigns,
            'data_type' => 'database',
            'source' => 'SiagaNow — program terverifikasi',
            'message' => 'Pembayaran dalam aplikasi tidak tersedia; API ini tidak mencatat transaksi.',
            'updated_at' => now()->toIso8601String(),
        ]);
    }
}
