<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BmkgForecastService;
use Illuminate\Http\JsonResponse;

class PublicInfoController extends Controller
{
    public function home(BmkgForecastService $forecastService): JsonResponse
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

    public function news(): JsonResponse
    {
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
}
