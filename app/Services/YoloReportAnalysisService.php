<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class YoloReportAnalysisService
{
    public function isConfigured(): bool
    {
        return (bool) config('services.yolo_reports.enabled') && filled(config('services.yolo_reports.url')) && filled(config('services.yolo_reports.token'));
    }

    public function analyze(int $reportId, int $evidenceIndex, string $path): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('yolo_service_not_configured');
        }
        $disk = Storage::disk('local');
        if (! $disk->exists($path)) {
            throw new RuntimeException('evidence_missing');
        }
        $response = Http::withToken(config('services.yolo_reports.token'))
            ->acceptJson()->timeout(125)->connectTimeout(10)
            ->attach('image', $disk->get($path), basename($path))
            ->post(config('services.yolo_reports.url'), ['report_id' => $reportId, 'evidence_index' => $evidenceIndex]);
        $response->throw();
        $payload = $response->json();
        if (! is_array($payload) || ! is_array($payload['detections'] ?? null)) {
            throw new RuntimeException('invalid_yolo_response');
        }
        $detections = [];
        foreach ($payload['detections'] as $item) {
            if (! is_array($item) || ! is_string($item['class_name'] ?? null) || ! is_numeric($item['confidence'] ?? null) || ! is_array($item['bbox'] ?? null)) {
                throw new RuntimeException('invalid_yolo_detection');
            }
            $box = $item['bbox'];
            $confidence = (float) $item['confidence'];
            $coords = array_map(fn ($key) => $box[$key] ?? null, ['x', 'y', 'width', 'height']);
            if ($confidence < 0 || $confidence > 1 || count(array_filter($coords, 'is_numeric')) !== 4 || min(array_map('floatval', $coords)) < 0 || max(array_map('floatval', $coords)) > 1 || (float) $coords[0] + (float) $coords[2] > 1 || (float) $coords[1] + (float) $coords[3] > 1) {
                throw new RuntimeException('invalid_yolo_detection');
            }
            $detections[] = ['class_name' => mb_substr($item['class_name'], 0, 80), 'confidence' => $confidence, 'bbox' => array_combine(['x', 'y', 'width', 'height'], array_map('floatval', $coords))];
        }

        return ['model_name' => mb_substr((string) data_get($payload, 'model.name', 'unknown'), 0, 100), 'model_version' => mb_substr((string) data_get($payload, 'model.version', 'unknown'), 0, 100), 'detections' => $detections];
    }
}
