<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class BmkgForecastService
{
    private const ENDPOINT = 'https://api.bmkg.go.id/publik/prakiraan-cuaca';

    public function getForecast(): array
    {
        $adm4 = trim((string) config('siaganow.bmkg_adm4'));

        if (! preg_match('/^\d{2}\.\d{2}\.\d{2}\.\d{4}$/', $adm4)) {
            return $this->unavailable('Kode wilayah BMKG belum dikonfigurasi.');
        }

        try {
            return Cache::store('file')->remember(
                'bmkg_forecast_adm4_'.str_replace('.', '_', $adm4),
                now()->addMinutes(45),
                fn () => $this->fetch($adm4),
            );
        } catch (Throwable $exception) {
            Log::warning('Prakiraan BMKG tidak dapat dimuat', [
                'adm4' => $adm4,
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            if (config('siaganow.demo_mode')) {
                $demo = config('siaganow.demo_weather');

                return [
                    'data_type' => 'simulation',
                    'status' => 'fallback',
                    'source' => 'Contoh Data SiagaNow',
                    'source_url' => self::ENDPOINT,
                    'message' => 'Permintaan ke BMKG gagal. Angka berikut hanya contoh demonstrasi.',
                    'location' => $demo['location'],
                    'updated_at' => null,
                    'current' => [
                        'temperature' => $demo['temperature'],
                        'condition' => $demo['condition'],
                        'humidity' => null,
                        'rain_mm' => null,
                        'wind_kmh' => null,
                        'local_datetime' => null,
                    ],
                    'forecasts' => [],
                ];
            }

            return $this->unavailable('Data prakiraan BMKG gagal diambil. Coba lagi nanti.');
        }
    }

    private function fetch(string $adm4): array
    {
        $response = Http::acceptJson()
            ->withUserAgent('SiagaNow/1.0 (public weather display)')
            ->connectTimeout(4)
            ->timeout(8)
            ->get(self::ENDPOINT, ['adm4' => $adm4]);
        $response->throw();

        $payload = $response->json();
        $location = data_get($payload, 'lokasi');
        $groups = data_get($payload, 'data');

        if (! is_array($location) || data_get($location, 'adm4') !== $adm4 || ! is_array($groups)) {
            throw new \UnexpectedValueException('Respons BMKG tidak memiliki identitas lokasi dan prakiraan yang sesuai.');
        }

        $forecasts = [];
        foreach ($groups as $group) {
            foreach (data_get($group, 'cuaca', []) as $periods) {
                foreach ($periods as $period) {
                    if (is_array($period)) {
                        $forecasts[] = $period;
                    }
                }
            }
        }

        if ($forecasts === []) {
            throw new \UnexpectedValueException('Respons BMKG tidak memuat rentang prakiraan.');
        }

        usort($forecasts, fn (array $left, array $right) =>
            $this->forecastTime($left)->getTimestamp() <=> $this->forecastTime($right)->getTimestamp()
        );

        $now = now('Asia/Jakarta');
        $current = collect($forecasts)->first(fn (array $forecast) => $this->forecastTime($forecast)->greaterThanOrEqualTo($now))
            ?? $forecasts[0];

        return [
            'data_type' => 'actual',
            'status' => 'available',
            'source' => 'BMKG',
            'source_url' => self::ENDPOINT.'?adm4='.$adm4,
            'message' => 'Prakiraan wilayah administrasi, bukan pengukuran di alamat rumah.',
            'attribution' => 'Prakiraan BMKG 3 hari, 8 interval per hari; pembaruan sumber dua kali sehari.',
            'location' => implode(', ', array_filter([
                data_get($location, 'desa'),
                data_get($location, 'kecamatan'),
                data_get($location, 'kotkab'),
                data_get($location, 'provinsi'),
            ])),
            'administrative_code' => $adm4,
            'updated_at' => $this->analysisDate($current['analysis_date'] ?? $forecasts[0]['analysis_date'] ?? null),
            'current' => $this->normalize($current),
            'forecasts' => array_map(fn (array $forecast) => $this->normalize($forecast), array_slice($forecasts, 0, 8)),
        ];
    }

    private function normalize(array $forecast): array
    {
        return [
            'local_datetime' => data_get($forecast, 'local_datetime') ?: data_get($forecast, 'datetime'),
            'temperature' => is_numeric(data_get($forecast, 't')) ? (float) data_get($forecast, 't') : null,
            'condition' => data_get($forecast, 'weather_desc'),
            'humidity' => is_numeric(data_get($forecast, 'hu')) ? (int) data_get($forecast, 'hu') : null,
            'rain_mm' => is_numeric(data_get($forecast, 'tp')) ? (float) data_get($forecast, 'tp') : null,
            'wind_kmh' => is_numeric(data_get($forecast, 'ws')) ? (float) data_get($forecast, 'ws') : null,
            'wind_direction' => data_get($forecast, 'wd'),
            'analysis_date' => data_get($forecast, 'analysis_date'),
        ];
    }

    private function forecastTime(array $forecast): Carbon
    {
        return Carbon::parse(
            data_get($forecast, 'local_datetime') ?: data_get($forecast, 'datetime'),
            'Asia/Jakarta',
        );
    }

    private function analysisDate(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return Carbon::parse($value, 'UTC')->utc()->toIso8601String();
    }

    private function unavailable(string $message): array
    {
        return [
            'data_type' => 'unavailable',
            'status' => 'unavailable',
            'source' => 'BMKG',
            'source_url' => self::ENDPOINT,
            'attribution' => 'Sumber prakiraan wilayah administrasi: BMKG.',
            'message' => $message,
            'location' => null,
            'administrative_code' => null,
            'updated_at' => null,
            'current' => null,
            'forecasts' => [],
        ];
    }
}
