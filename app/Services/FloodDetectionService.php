<?php

namespace App\Services;

use App\Models\AiDetection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FloodDetectionService
{
    public function summary(): array
    {
        try {
            $latest = $this->query()->first();
        } catch (QueryException $exception) {
            Log::warning('Flood AI summary database query failed', ['exception' => $exception::class]);

            return $this->databaseUnavailable();
        }

        return $this->summarize($latest);
    }

    public function feed(): array
    {
        try {
            $observations = $this->query()->limit(30)->get();
        } catch (QueryException $exception) {
            Log::warning('Flood AI feed database query failed', ['exception' => $exception::class]);

            return [
                ...$this->databaseUnavailable(),
                'observations' => [],
            ];
        }

        return [
            ...$this->summarize($observations->first()),
            'observations' => $observations->map(fn (AiDetection $detection) => $this->serialize($detection))->values(),
        ];
    }

    private function query()
    {
        return AiDetection::query()
            ->with('camera:id,name,location,is_enabled')
            ->whereHas('camera', fn ($query) => $query->where('is_enabled', true))
            ->whereNotNull('observed_at')
            ->latest('observed_at')
            ->latest('id');
    }

    private function summarize(?AiDetection $latest): array
    {
        $configured = is_string(config('services.flood_ai.ingest_token'))
            && trim((string) config('services.flood_ai.ingest_token')) !== '';
        $staleAfter = max(1, (int) config('services.flood_ai.stale_after_minutes', 5));
        $isFresh = $latest !== null && $this->isFresh($latest, $staleAfter);

        $serviceStatus = ! $configured
            ? 'not_configured'
            : ($latest === null ? 'waiting' : ($isFresh ? 'receiving' : 'stale'));

        $message = match ($serviceStatus) {
            'not_configured' => 'Layanan AI belum dikonfigurasi pada server.',
            'waiting' => 'Menunggu observasi pertama dari layanan AI.',
            'stale' => 'Observasi terakhir sudah kedaluwarsa; status banjir saat ini tidak diketahui.',
            default => 'Observasi terbaru diterima dari layanan AI. Hasil ini bukan peringatan resmi dan menunggu tinjauan petugas.',
        };

        return [
            'service_status' => $serviceStatus,
            'status' => $isFresh ? $latest->risk_status : 'unknown',
            'is_stale' => ! $isFresh,
            'data_type' => $latest === null ? 'unavailable' : 'database',
            'source' => 'SiagaNow AI Flood Detection',
            'message' => $message,
            'stale_after_minutes' => $staleAfter,
            'updated_at' => $latest?->observed_at?->toIso8601String(),
            'latest_observation' => $latest ? $this->serialize($latest) : null,
        ];
    }

    private function databaseUnavailable(): array
    {
        return [
            'service_status' => 'unavailable',
            'status' => 'unknown',
            'is_stale' => true,
            'data_type' => 'unavailable',
            'source' => 'SiagaNow AI Flood Detection',
            'message' => 'Data AI belum dapat dibaca dari database. Status banjir tidak diketahui.',
            'stale_after_minutes' => max(1, (int) config('services.flood_ai.stale_after_minutes', 5)),
            'updated_at' => null,
            'latest_observation' => null,
        ];
    }

    private function serialize(AiDetection $detection): array
    {
        $staleAfter = max(1, (int) config('services.flood_ai.stale_after_minutes', 5));
        $isFresh = $this->isFresh($detection, $staleAfter);

        return [
            'id' => $detection->id,
            'camera' => $detection->camera ? [
                'id' => $detection->camera->id,
                'name' => $detection->camera->name,
                'location' => $detection->camera->location,
            ] : null,
            // A stale model result is historical only; it must never imply Normal now.
            'status' => $isFresh ? $detection->risk_status : 'unknown',
            'observed_status' => $detection->risk_status,
            'confidence' => $detection->confidence,
            'observed_at' => $detection->observed_at?->toIso8601String(),
            'received_at' => $detection->created_at?->toIso8601String(),
            'verification_status' => $detection->verification_status,
            'verified_at' => $detection->verified_at?->toIso8601String(),
            'is_stale' => ! $isFresh,
            'source' => 'SiagaNow AI Flood Detection',
        ];
    }

    private function isFresh(AiDetection $detection, int $staleAfterMinutes): bool
    {
        $observedAt = $detection->observed_at;

        return $observedAt !== null
            && $observedAt->lessThanOrEqualTo(now())
            && $observedAt->greaterThanOrEqualTo(now()->subMinutes($staleAfterMinutes));
    }
}
