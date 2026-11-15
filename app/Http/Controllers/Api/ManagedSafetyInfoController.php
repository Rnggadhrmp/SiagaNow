<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminAlert;
use App\Models\AffectedRoad;
use Illuminate\Http\JsonResponse;

class ManagedSafetyInfoController extends Controller
{
    public function alerts(): JsonResponse
    {
        $alerts = AdminAlert::publiclyActive()->latest('verified_at')->limit(100)->get([
            'id', 'title', 'hazard_type', 'risk_level', 'affected_area', 'description',
            'area_geojson', 'source_name', 'source_url', 'starts_at', 'expires_at', 'verified_at', 'updated_at',
        ]);

        return response()->json([
            'data' => $alerts,
            'data_type' => 'database',
            'source' => 'SiagaNow — informasi yang telah diverifikasi petugas',
            'updated_at' => now()->toIso8601String(),
        ]);
    }

    public function roads(): JsonResponse
    {
        $roads = AffectedRoad::publiclyActive()->latest('observed_at')->limit(100)->get([
            'id', 'name', 'area_description', 'latitude', 'longitude', 'route_geojson',
            'impact_level', 'status', 'source_name', 'source_url', 'observed_at', 'verified_at', 'updated_at',
        ]);

        return response()->json([
            'data' => $roads,
            'data_type' => 'database',
            'source' => 'SiagaNow — status jalan yang telah diverifikasi petugas',
            'updated_at' => now()->toIso8601String(),
            'message' => 'Status jalan yang tidak tercantum tidak berarti jalan tersebut aman.',
        ]);
    }
}
