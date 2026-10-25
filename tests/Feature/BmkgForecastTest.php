<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BmkgForecastTest extends TestCase
{
    use RefreshDatabase;

    private const ADM4 = '13.71.01.1001';

    protected function setUp(): void
    {
        parent::setUp();
        config(['siaganow.bmkg_adm4' => self::ADM4]);
        Cache::store('file')->forget('bmkg_forecast_adm4_13_71_01_1001');
    }

    public function test_bmkg_forecast_is_parsed_attribution_is_preserved_and_result_is_cached(): void
    {
        $forecastTime = now('Asia/Jakarta')->addHours(2)->format('Y-m-d H:i:s');
        Http::fake([
            'https://api.bmkg.go.id/publik/prakiraan-cuaca*' => Http::response([
                'lokasi' => [
                    'adm4' => self::ADM4,
                    'provinsi' => 'Sumatera Barat',
                    'kotkab' => 'Kota Padang',
                    'kecamatan' => 'Padang Selatan',
                    'desa' => 'Belakang Pondok',
                ],
                'data' => [[
                    'cuaca' => [[[
                        'local_datetime' => $forecastTime,
                        't' => 26,
                        'hu' => 84,
                        'tp' => 1.5,
                        'ws' => 8.2,
                        'wd' => 'NW',
                        'weather_desc' => 'Hujan Ringan',
                        'analysis_date' => now('UTC')->toIso8601String(),
                    ]]],
                ]],
            ]),
        ]);

        $response = $this->getJson('/api/weather-forecast')
            ->assertOk()
            ->assertJsonPath('data_type', 'actual')
            ->assertJsonPath('source', 'BMKG')
            ->assertJsonPath('location', 'Belakang Pondok, Padang Selatan, Kota Padang, Sumatera Barat')
            ->assertJsonPath('current.temperature', 26)
            ->assertJsonPath('current.humidity', 84)
            ->assertJsonPath('current.rain_mm', 1.5)
            ->assertJsonPath('current.condition', 'Hujan Ringan');

        $this->getJson('/api/home')
            ->assertOk()
            ->assertJsonPath('weather.data_type', 'actual')
            ->assertJsonPath('weather_forecast.current.temperature', 26);

        Http::assertSentCount(1);
    }

    public function test_failed_bmkg_request_uses_only_labeled_demo_fallback_when_demo_mode_is_enabled(): void
    {
        config(['siaganow.demo_mode' => true]);
        Http::fake(['https://api.bmkg.go.id/*' => Http::response([], 503)]);

        $this->getJson('/api/weather-forecast')
            ->assertOk()
            ->assertJsonPath('data_type', 'simulation')
            ->assertJsonPath('status', 'fallback')
            ->assertJsonPath('source', 'Contoh Data SiagaNow')
            ->assertJsonPath('current.humidity', null)
            ->assertJsonPath('forecasts', []);
    }

    public function test_failed_bmkg_request_is_unavailable_when_demo_mode_is_disabled(): void
    {
        config(['siaganow.demo_mode' => false]);
        Http::fake(['https://api.bmkg.go.id/*' => Http::response([], 503)]);

        $this->getJson('/api/weather-forecast')
            ->assertStatus(503)
            ->assertJsonPath('data_type', 'unavailable')
            ->assertJsonPath('current', null);
    }
}
