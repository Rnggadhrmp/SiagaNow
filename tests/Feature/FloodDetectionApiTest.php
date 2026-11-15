<?php

namespace Tests\Feature;

use App\Models\AiCameraSource;
use App\Models\AiDetection;
use App\Models\AdminRole;
use App\Models\User;
use App\Services\BmkgForecastService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FloodDetectionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_ingest_is_disabled_until_a_server_token_is_configured(): void
    {
        config(['services.flood_ai.ingest_token' => null]);

        $this->postJson('/api/ai/detections', [])->assertServiceUnavailable()
            ->assertJsonPath('status', 'not_configured');
    }

    public function test_ingest_requires_a_matching_bearer_token(): void
    {
        config(['services.flood_ai.ingest_token' => 'qa-ingest-token']);

        $this->withToken('wrong-token')->postJson('/api/ai/detections', [])->assertUnauthorized();
    }

    public function test_enabled_camera_observation_is_stored_and_public_feed_uses_fresh_status(): void
    {
        config([
            'services.flood_ai.ingest_token' => 'qa-ingest-token',
            'services.flood_ai.stale_after_minutes' => 5,
        ]);
        $camera = AiCameraSource::query()->create([
            'name' => 'Kamera Uji',
            'location' => 'Lokasi uji — bukan sumber operasional',
            'is_enabled' => true,
        ]);

        $payload = [
            'camera_source_id' => $camera->id,
            'external_reference' => 'qa-event-001',
            'risk_status' => 'warning',
            'confidence' => 0.8123,
            'observed_at' => now()->toIso8601String(),
            'model_version' => 'qa-test',
        ];

        $this->withToken('qa-ingest-token')->postJson('/api/ai/detections', $payload)
            ->assertCreated()
            ->assertJsonPath('status', 'accepted')
            ->assertJsonPath('verification_status', 'pending');

        $this->withToken('qa-ingest-token')->postJson('/api/ai/detections', $payload)
            ->assertOk()
            ->assertJsonPath('idempotent', true);

        $this->assertDatabaseCount('ai_detections', 1);
        $this->getJson('/api/flood-detections')
            ->assertOk()
            ->assertJsonPath('service_status', 'receiving')
            ->assertJsonPath('status', 'warning')
            ->assertJsonPath('latest_observation.verification_status', 'pending')
            ->assertJsonPath('latest_observation.source', 'SiagaNow AI Flood Detection');
    }

    public function test_stale_observation_is_exposed_as_unknown_not_normal(): void
    {
        config([
            'services.flood_ai.ingest_token' => 'qa-ingest-token',
            'services.flood_ai.stale_after_minutes' => 5,
        ]);
        $camera = AiCameraSource::query()->create([
            'name' => 'Kamera Uji',
            'location' => 'Lokasi uji',
            'is_enabled' => true,
        ]);
        AiDetection::query()->create([
            'camera_source_id' => $camera->id,
            'external_reference' => 'qa-stale-001',
            'risk_status' => 'normal',
            'observed_at' => now()->subMinutes(10),
            'verification_status' => 'pending',
        ]);

        $this->getJson('/api/flood-detections')
            ->assertOk()
            ->assertJsonPath('service_status', 'stale')
            ->assertJsonPath('status', 'unknown')
            ->assertJsonPath('latest_observation.observed_status', 'normal')
            ->assertJsonPath('latest_observation.status', 'unknown')
            ->assertJsonPath('latest_observation.is_stale', true);
    }

    public function test_observation_from_disabled_camera_is_rejected(): void
    {
        config(['services.flood_ai.ingest_token' => 'qa-ingest-token']);
        $camera = AiCameraSource::query()->create([
            'name' => 'Kamera Nonaktif',
            'location' => 'Lokasi uji',
            'is_enabled' => false,
        ]);

        $this->withToken('qa-ingest-token')->postJson('/api/ai/detections', [
            'camera_source_id' => $camera->id,
            'external_reference' => 'qa-disabled-001',
            'risk_status' => 'danger',
            'observed_at' => now()->toIso8601String(),
        ])->assertUnprocessable()->assertJsonPath('status', 'camera_disabled');

        $this->assertDatabaseCount('ai_detections', 0);
    }

    public function test_website_home_shares_ai_summary_and_keeps_missing_data_unknown(): void
    {
        $this->mock(BmkgForecastService::class)
            ->shouldReceive('getForecast')
            ->twice()
            ->andReturn([
                'data_type' => 'unavailable', 'status' => 'unavailable', 'source' => 'BMKG',
                'message' => 'Unavailable in isolated test.', 'location' => null, 'updated_at' => null,
                'current' => null, 'forecasts' => [],
            ]);

        $this->get('/')->assertOk()->assertSee('AI Flood Detection')->assertSee('Unknown');
        $this->getJson('/api/home')
            ->assertOk()
            ->assertJsonPath('flood_detection.status', 'unknown')
            ->assertJsonPath('flood_detection.service_status', 'not_configured');
    }

    public function test_admin_ai_page_shows_derived_service_state_and_ingest_path(): void
    {
        config(['services.flood_ai.ingest_token' => null]);
        $user = User::factory()->create();
        $user->adminRoles()->attach(AdminRole::query()->where('slug', 'super-admin')->value('id'));

        $this->actingAs($user)->get(route('admin.ai.index'))
            ->assertOk()
            ->assertSee('Belum dikonfigurasi')
            ->assertSee('POST /api/ai/detections');
    }

    public function test_admin_can_allow_an_ai_source_to_ingest_without_claiming_camera_connectivity(): void
    {
        $user = User::factory()->create();
        $user->adminRoles()->attach(AdminRole::query()->where('slug', 'super-admin')->value('id'));

        $this->actingAs($user)->post(route('admin.ai.cameras.store'), [
            'name' => 'Kamera QA',
            'location' => 'Lokasi QA',
            'is_enabled' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('ai_camera_sources', [
            'name' => 'Kamera QA',
            'is_enabled' => true,
        ]);
    }
}
