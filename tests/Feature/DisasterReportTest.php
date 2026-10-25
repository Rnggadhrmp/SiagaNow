<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisasterReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_submit_a_disaster_report(): void
    {
        $this->post('/report', [])->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_submit_and_view_their_report(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/report', [
            'title' => 'Banjir di Koto Tangah',
            'latitude' => -0.75,
            'longitude' => 100.32,
            'event_date' => now()->toDateString(),
            'event_time' => '09:30',
            'event_type' => 'Banjir',
            'injured' => 0,
            'deceased' => 0,
            'damage_level' => 'Sedang',
            'description' => 'Air menggenang di jalan utama. Informasi ini perlu diperiksa petugas.',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.status', 'submitted')
            ->assertJsonPath('data.status_url', route('report.status'));

        $this->assertDatabaseHas('disaster_reports', [
            'user_id' => $user->id,
            'title' => 'Banjir di Koto Tangah',
            'status' => 'submitted',
        ]);

        $this->actingAs($user)->get(route('report.status'))
            ->assertOk()
            ->assertSee('Banjir di Koto Tangah')
            ->assertSee('Menunggu pemeriksaan');
    }

    public function test_invalid_report_does_not_create_a_record(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/report', [
            'title' => '',
            'latitude' => 120,
            'longitude' => 0,
        ])->assertUnprocessable();

        $this->assertDatabaseCount('disaster_reports', 0);
    }
}
