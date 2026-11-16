<?php

namespace App\Jobs;

use App\Models\DisasterReport;
use App\Services\YoloReportAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class AnalyzeReportEvidence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;

    public int $timeout = 150;

    public function __construct(public int $reportId)
    {
        $this->onQueue('ai');
    }

    public function handle(YoloReportAnalysisService $service): void
    {
        $report = DisasterReport::query()->with('aiAnalysis')->find($this->reportId);
        if (! $report || ! $report->aiAnalysis || ! $service->isConfigured()) {
            return;
        }
        $analysis = $report->aiAnalysis;
        $analysis->update(['status' => 'processing', 'started_at' => now(), 'error_code' => null]);
        try {
            $paths = $report->evidence_paths ?? [];
            $merged = [];
            $indices = [];
            $model = null;
            foreach ($paths as $index => $path) {
                if (! is_string($path) || ! preg_match('/\.(jpe?g|png|webp)$/i', $path)) {
                    continue;
                }
                $result = $service->analyze($report->id, $index, $path);
                $model ??= $result;
                foreach ($result['detections'] as $detection) {
                    $merged[] = $detection + ['evidence_index' => $index];
                }
                $indices[] = $index;
            }
            $analysis->update(['status' => 'completed', 'model_name' => $model['model_name'] ?? null, 'model_version' => $model['model_version'] ?? null, 'detections' => $merged, 'source_evidence_indices' => $indices, 'analyzed_at' => now()]);
        } catch (Throwable $e) {
            if ($this->attempts() < $this->tries) {
                throw $e;
            }
            $analysis->update(['status' => 'failed', 'error_code' => 'yolo_service_error', 'analyzed_at' => now()]);
            Log::warning('Report evidence analysis failed', ['report_id' => $this->reportId, 'exception' => class_basename($e)]);
        }
    }
}
