<?php

namespace Tests\Feature;

use App\Models\DisasterReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
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
        $this->getJson('/api/home')
            ->assertOk()
            ->assertJsonPath('data_type', 'simulation')
            ->assertJsonPath('warning.active', false);

        $this->getJson('/api/shelters')
            ->assertOk()
            ->assertJsonPath('data_type', 'simulation')
            ->assertJsonPath('data.0.is_simulated', true);
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
