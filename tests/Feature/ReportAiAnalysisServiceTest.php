<?php

namespace Tests\Feature;

use App\Services\YoloReportAnalysisService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Tests\TestCase;

class ReportAiAnalysisServiceTest extends TestCase
{
    public function test_service_sends_private_image_and_normalizes_a_valid_contract_response(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('reports/evidence.jpg', 'image-bytes');
        config(['services.yolo_reports.enabled' => true, 'services.yolo_reports.url' => 'https://yolo.test/analyze', 'services.yolo_reports.token' => 'test-secret']);
        Http::fake(['yolo.test/*' => Http::response(['model' => ['name' => 'validated-model', 'version' => 'v1'], 'detections' => [['class_name' => 'trained_class', 'confidence' => 0.82, 'bbox' => ['x' => 0.1, 'y' => 0.2, 'width' => 0.3, 'height' => 0.25]]]], 200)]);

        $result = app(YoloReportAnalysisService::class)->analyze(7, 0, 'reports/evidence.jpg');

        $this->assertSame('validated-model', $result['model_name']);
        $this->assertSame('trained_class', $result['detections'][0]['class_name']);
        $this->assertSame(0.82, $result['detections'][0]['confidence']);
        Http::assertSent(fn (Request $request) => $request->url() === 'https://yolo.test/analyze'
            && $request->hasHeader('Authorization', 'Bearer test-secret')
            && $request->isMultipart()
            && $request->hasFile('image', 'image-bytes', 'evidence.jpg')
            && str_contains($request->body(), 'name="report_id"')
            && str_contains($request->body(), 'name="evidence_index"'));
    }

    public function test_service_rejects_out_of_bounds_detection_boxes(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('reports/evidence.jpg', 'image-bytes');
        config(['services.yolo_reports.enabled' => true, 'services.yolo_reports.url' => 'https://yolo.test/analyze', 'services.yolo_reports.token' => 'test-secret']);
        Http::fake(['yolo.test/*' => Http::response(['detections' => [['class_name' => 'untrusted', 'confidence' => 0.8, 'bbox' => ['x' => 0.8, 'y' => 0, 'width' => 0.3, 'height' => 0.2]]]], 200)]);

        $this->expectException(RuntimeException::class);
        app(YoloReportAnalysisService::class)->analyze(7, 0, 'reports/evidence.jpg');
    }
}
