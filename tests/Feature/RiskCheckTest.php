<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RiskCheckTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_or_submit_a_risk_assessment(): void
    {
        $this->get('/risk-check')->assertRedirect(route('login'));
        $this->postJson('/risk-check', [])->assertUnauthorized();
    }

    public function test_incomplete_evidence_is_saved_as_pending_without_claiming_a_score(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/risk-check', [
            'latitude' => -0.9471,
            'longitude' => 100.4172,
        ])->assertCreated()
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonPath('data.result', null)
            ->assertJsonPath('data.limitations.0', 'Jarak ke sungai belum tersedia.');

        $this->assertDatabaseHas('risk_assessments', [
            'user_id' => $user->id,
            'status' => 'pending',
            'result' => null,
        ]);
    }

    public function test_invalid_coordinates_are_rejected_without_saving(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/risk-check', [
            'latitude' => 91,
            'longitude' => 181,
        ])->assertUnprocessable();

        $this->assertDatabaseCount('risk_assessments', 0);
    }
}
