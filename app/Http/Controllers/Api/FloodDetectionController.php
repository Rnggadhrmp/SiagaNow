<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiCameraSource;
use App\Models\AiDetection;
use App\Services\AdminAuditLogger;
use App\Services\FloodDetectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FloodDetectionController extends Controller
{
    public function index(FloodDetectionService $detections): JsonResponse
    {
        return response()->json($detections->feed());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'camera_source_id' => ['required', 'integer', 'exists:ai_camera_sources,id'],
            'external_reference' => ['required', 'string', 'max:180'],
            'risk_status' => ['required', Rule::in(['normal', 'warning', 'danger', 'unknown'])],
            'confidence' => ['nullable', 'numeric', 'between:0,1'],
            'observed_at' => ['required', 'date', 'before_or_equal:now'],
            'model_version' => ['nullable', 'string', 'max:80'],
        ]);

        $camera = AiCameraSource::query()->findOrFail($data['camera_source_id']);

        if (! $camera->is_enabled) {
            return response()->json([
                'status' => 'camera_disabled',
                'message' => 'Sumber kamera belum diaktifkan oleh administrator.',
            ], 422);
        }

        $detection = DB::transaction(function () use ($data, $camera) {
            return AiDetection::query()->firstOrCreate(
                ['external_reference' => $data['external_reference']],
                [
                    'camera_source_id' => $camera->id,
                    'risk_status' => $data['risk_status'],
                    'confidence' => $data['confidence'] ?? null,
                    'observed_at' => $data['observed_at'],
                    'source_name' => Str::limit('SiagaNow AI Flood Detection'.(isset($data['model_version']) ? ' · '.$data['model_version'] : ''), 120, ''),
                    'verification_status' => 'pending',
                ],
            );
        });

        return response()->json([
            'status' => 'accepted',
            'idempotent' => ! $detection->wasRecentlyCreated,
            'detection_id' => $detection->id,
            'verification_status' => $detection->verification_status,
        ], $detection->wasRecentlyCreated ? 201 : 200);
    }
}
