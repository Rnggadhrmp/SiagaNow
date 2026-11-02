<?php

namespace Tests\Feature;

use App\Models\DisasterReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MobileApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_mobile_registration_issues_a_bearer_token_and_safe_profile(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Mobile Demo',
            'phone' => '081234567890',
            'email' => 'mobile@example.test',
            'password' => 'Strong-test-password-1',
            'password_confirmation' => 'Strong-test-password-1',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.email', 'mobile@example.test')
            ->assertJsonPath('token_type', 'Bearer')
            ->assertJsonMissingPath('data.password');

        $token = $response->json('token');
        $this->withToken($token)->getJson('/api/user')
            ->assertOk()
            ->assertJsonPath('data.phone', '081234567890');
    }

    public function test_mobile_registration_and_login_validation_failures_are_reported(): void
    {
        $this->postJson('/api/register', [])->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'phone', 'email', 'password']);

        $this->postJson('/api/login', [
            'identifier' => 'missing@example.test',
            'password' => 'wrong-password',
        ])->assertUnprocessable()
            ->assertJsonPath('message', 'Email/nomor HP atau password tidak sesuai.');
    }

    public function test_mobile_login_accepts_phone_and_logout_revokes_token(): void
    {
        $user = User::factory()->create([
            'phone' => '081111111111',
            'password' => 'correct-password',
        ]);

        $response = $this->postJson('/api/login', [
            'identifier' => $user->phone,
            'password' => 'correct-password',
        ])->assertOk();

        $token = $response->json('token');
        $this->withToken($token)->postJson('/api/logout')->assertOk();
        $tokenId = explode('|', $token, 2)[0];
        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $tokenId]);
        Auth::forgetGuards(); // Each HTTP request has a fresh guard in the deployed app.
        $this->getJson('/api/user', ['Authorization' => 'Bearer '.$token])->assertUnauthorized();
    }

    public function test_public_demo_home_and_shelter_endpoints_are_marked_simulation(): void
    {
        Cache::store('file')->forget('bmkg_forecast_adm4_13_71_01_1001');
        Http::fake(['https://api.bmkg.go.id/*' => Http::response([], 503)]);

        $this->getJson('/api/home')
            ->assertOk()
            ->assertJsonPath('data_type', 'simulation')
            ->assertJsonPath('warning.active', false);

        $this->getJson('/api/shelters')
            ->assertOk()
            ->assertJsonPath('data_type', 'simulation')
            ->assertJsonPath('data.0.is_simulated', true);

        $this->getJson('/api/shelters?q=Kuranji')
            ->assertOk()
            ->assertJsonPath('data_type', 'simulation')
            ->assertSee('Contoh Shelter Kuranji');
    }

    public function test_guest_cannot_access_mobile_report_history(): void
    {
        $this->getJson('/api/reports')->assertUnauthorized();
    }

    public function test_mobile_report_preserves_unknown_casualty_counts_and_explicit_zero(): void
    {
        $owner = User::factory()->create();
        $token = $owner->createToken('mobile', ['mobile'])->plainTextToken;
        $payload = [
            'title' => 'Laporan tanpa data korban',
            'latitude' => -0.95,
            'longitude' => 100.42,
            'event_date' => now()->toDateString(),
            'event_time' => '09:30',
            'event_type' => 'Banjir',
            'damage_level' => 'Rendah',
            'description' => 'Kondisi korban belum dapat dipastikan di lokasi.',
        ];

        $this->withToken($token)->postJson('/api/reports', $payload)->assertCreated();
        $this->assertDatabaseHas('disaster_reports', [
            'user_id' => $owner->id,
            'title' => 'Laporan tanpa data korban',
            'injured' => null,
            'deceased' => null,
        ]);

        $payload['title'] = 'Tidak ada korban terkonfirmasi';
        $payload['injured'] = 0;
        $payload['deceased'] = 0;
        $this->withToken($token)->postJson('/api/reports', $payload)->assertCreated();
        $this->assertDatabaseHas('disaster_reports', [
            'user_id' => $owner->id,
            'title' => 'Tidak ada korban terkonfirmasi',
            'injured' => 0,
            'deceased' => 0,
        ]);
    }

    public function test_mobile_report_attachment_is_validated_and_stored_on_private_disk(): void
    {
        Storage::fake('local');
        $owner = User::factory()->create();
        $token = $owner->createToken('mobile', ['mobile'])->plainTextToken;
        $payload = [
            'title' => 'Bukti banjir di lokasi',
            'latitude' => -0.95,
            'longitude' => 100.42,
            'event_date' => now()->toDateString(),
            'event_time' => '09:30',
            'event_type' => 'Banjir',
            'damage_level' => 'Rendah',
            'description' => 'Air menggenang pada bagian jalan dekat lokasi.',
            'evidence' => [UploadedFile::fake()->image('kondisi.jpg')],
        ];

        $this->withToken($token)->post('/api/reports', $payload, [
            'Accept' => 'application/json',
        ])->assertCreated();

        $report = DisasterReport::query()->where('user_id', $owner->id)->firstOrFail();
        $this->assertCount(1, $report->evidence_paths);
        Storage::disk('local')->assertExists($report->evidence_paths[0]);

        $payload['evidence'] = [UploadedFile::fake()->create('tidak-didukung.txt', 1, 'text/plain')];
        $this->withToken($token)->post('/api/reports', $payload, [
            'Accept' => 'application/json',
        ])->assertUnprocessable();
        $this->assertDatabaseCount('disaster_reports', 1);
    }

    public function test_mobile_reports_are_limited_to_the_authenticated_user(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        DisasterReport::create([
            'user_id' => $owner->id,
            'title' => 'Laporan milik saya',
            'latitude' => -0.95,
            'longitude' => 100.42,
            'occurred_at' => now(),
            'event_type' => 'Banjir',
            'injured' => 0,
            'deceased' => 0,
            'damage_level' => 'Rendah',
            'description' => 'Deskripsi laporan milik pemilik.',
            'status' => 'submitted',
        ]);
        DisasterReport::create([
            'user_id' => $otherUser->id,
            'title' => 'Laporan pengguna lain',
            'latitude' => -0.91,
            'longitude' => 100.39,
            'occurred_at' => now(),
            'event_type' => 'Tanah longsor',
            'injured' => 0,
            'deceased' => 0,
            'damage_level' => 'Sedang',
            'description' => 'Deskripsi privat pengguna lain.',
            'status' => 'submitted',
        ]);

        $this->withToken($owner->createToken('mobile', ['mobile'])->plainTextToken)
            ->getJson('/api/reports')
            ->assertOk()
            ->assertSee('Laporan milik saya')
            ->assertDontSee('Laporan pengguna lain');
    }
}
