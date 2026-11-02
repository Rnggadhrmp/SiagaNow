<?php

namespace Tests\Feature;

use App\Models\FamilyGroup;
use App\Models\RiskAssessment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MobileFamilyRiskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_family_api_requires_mobile_authentication(): void
    {
        $this->getJson('/api/family-groups')->assertUnauthorized();
        $this->postJson('/api/family-groups', ['name' => 'Keluarga'])->assertUnauthorized();
        $this->postJson('/api/family-invitations/accept', ['code' => 'x'])->assertUnauthorized();
        $this->getJson('/api/family-memberships')->assertUnauthorized();
        $this->getJson('/api/risk-assessments')->assertUnauthorized();
        $this->postJson('/api/risk-assessments', [])->assertUnauthorized();
    }

    public function test_family_group_members_can_be_managed_only_by_the_owner(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $ownerToken = $owner->createToken('mobile', ['mobile'])->plainTextToken;
        $otherToken = $other->createToken('mobile', ['mobile'])->plainTextToken;

        $groupResponse = $this->withToken($ownerToken)->postJson('/api/family-groups', [
            'name' => 'Keluarga Uji',
        ])->assertCreated()->assertJsonPath('data.name', 'Keluarga Uji');
        $groupId = $groupResponse->json('data.id');

        $memberResponse = $this->withToken($ownerToken)
            ->postJson("/api/family-groups/{$groupId}/members", [
                'name' => 'Anggota Uji',
                'relation' => 'Keluarga',
                'emergency_phone' => '080000000001',
                'notes' => 'Alergi debu',
            ])->assertCreated()->assertJsonPath('data.name', 'Anggota Uji');
        $memberId = $memberResponse->json('data.id');

        Auth::forgetGuards();
        $this->withToken($otherToken)->getJson("/api/family-groups/{$groupId}")
            ->assertNotFound();
        Auth::forgetGuards();
        $this->withToken($otherToken)->getJson('/api/family-groups')
            ->assertOk()->assertJsonCount(0, 'data');
        $this->withToken($otherToken)
            ->putJson("/api/family-groups/{$groupId}/members/{$memberId}", ['name' => 'Penyusup'])
            ->assertNotFound();

        Auth::forgetGuards();
        $this->withToken($ownerToken)->getJson('/api/family-groups')
            ->assertOk()->assertJsonPath('data.0.members.0.emergency_phone', '080000000001')
            ->assertJsonPath('data.0.members.0.notes', 'Alergi debu');
        $this->assertDatabaseHas('family_groups', ['id' => $groupId, 'user_id' => $owner->id]);
    }

    public function test_family_member_validation_and_single_group_rule_are_enforced(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('mobile', ['mobile'])->plainTextToken;
        $group = $this->withToken($token)->postJson('/api/family-groups', ['name' => 'Keluarga'])
            ->assertCreated()->json('data.id');

        $this->withToken($token)->postJson('/api/family-groups', ['name' => 'Kedua'])
            ->assertStatus(409);
        $this->withToken($token)->postJson("/api/family-groups/{$group}/members", ['name' => ''])
            ->assertUnprocessable()->assertJsonValidationErrors(['name']);
    }

    public function test_family_invitation_links_an_account_and_checkin_is_private_and_idempotent(): void
    {
        $owner = User::factory()->create();
        $memberUser = User::factory()->create();
        $outsider = User::factory()->create();
        $ownerToken = $owner->createToken('mobile', ['mobile'])->plainTextToken;
        $memberToken = $memberUser->createToken('mobile', ['mobile'])->plainTextToken;
        $outsiderToken = $outsider->createToken('mobile', ['mobile'])->plainTextToken;

        $groupId = $this->withToken($ownerToken)->postJson('/api/family-groups', [
            'name' => 'Keluarga Aman',
        ])->assertCreated()->json('data.id');
        $memberId = $this->withToken($ownerToken)
            ->postJson("/api/family-groups/{$groupId}/members", [
                'name' => 'Anggota Aman',
                'emergency_phone' => '080000000001',
            ])->assertCreated()->json('data.id');

        $code = $this->withToken($ownerToken)
            ->postJson("/api/family-groups/{$groupId}/members/{$memberId}/invitation")
            ->assertCreated()->json('data.code');
        $this->withToken($memberToken)->postJson('/api/family-invitations/accept', [
            'code' => $code,
        ])->assertOk()->assertJsonPath('data.group.name', 'Keluarga Aman')
            ->assertJsonMissingPath('data.emergency_phone');

        Auth::forgetGuards();
        $this->withToken($outsiderToken)
            ->postJson("/api/family-members/{$memberId}/check-in", ['request_id' => 'req-outsider'])
            ->assertNotFound();
        Auth::forgetGuards();
        $this->withToken($outsiderToken)
            ->getJson("/api/family-groups/{$groupId}/check-ins")
            ->assertNotFound();

        Auth::forgetGuards();
        $this->withToken($memberToken)->getJson('/api/family-memberships')
            ->assertOk()->assertJsonPath('data.0.members.0.status', 'never_confirmed')
            ->assertJsonMissingPath('data.0.members.0.emergency_phone');

        Auth::forgetGuards();
        $first = $this->withToken($memberToken)
            ->postJson("/api/family-members/{$memberId}/check-in", ['request_id' => 'req-123'])
            ->assertOk()->assertJsonPath('data.duplicate', false);
        $checkedAt = $first->json('data.check_in_at');

        Auth::forgetGuards();
        $this->withToken($memberToken)
            ->postJson("/api/family-members/{$memberId}/check-in", ['request_id' => 'req-123'])
            ->assertOk()->assertJsonPath('data.duplicate', true)
            ->assertJsonPath('data.check_in_at', $checkedAt);

        Auth::forgetGuards();
        $this->withToken($ownerToken)->getJson("/api/family-groups/{$groupId}/check-ins")
            ->assertOk()->assertJsonPath('data.0.status', 'confirmed')
            ->assertJsonPath('data.0.check_in_at', $checkedAt)
            ->assertJsonMissingPath('data.0.emergency_phone');
    }

    public function test_reminder_settings_are_authorized_persisted_and_timezone_validated(): void
    {
        $owner = User::factory()->create();
        $memberUser = User::factory()->create();
        $outsider = User::factory()->create();
        $ownerToken = $owner->createToken('mobile', ['mobile'])->plainTextToken;
        $memberToken = $memberUser->createToken('mobile', ['mobile'])->plainTextToken;
        $outsiderToken = $outsider->createToken('mobile', ['mobile'])->plainTextToken;

        $groupId = $this->withToken($ownerToken)->postJson('/api/family-groups', [
            'name' => 'Keluarga Pengingat',
        ])->assertCreated()->json('data.id');
        $memberId = $this->withToken($ownerToken)
            ->postJson("/api/family-groups/{$groupId}/members", ['name' => 'Anggota'])
            ->assertCreated()->json('data.id');

        $this->withToken($outsiderToken)
            ->patchJson("/api/family-members/{$memberId}/reminders", [
                'enabled' => true,
                'frequency_hours' => 24,
                'timezone' => 'Asia/Bangkok',
            ])->assertNotFound();

        Auth::forgetGuards();
        $this->withToken($ownerToken)
            ->patchJson("/api/family-members/{$memberId}/reminders", [
                'enabled' => true,
                'frequency_hours' => 24,
                'timezone' => 'Not/A_Timezone',
            ])->assertUnprocessable()->assertJsonValidationErrors(['timezone']);

        Auth::forgetGuards();
        $response = $this->withToken($ownerToken)
            ->patchJson("/api/family-members/{$memberId}/reminders", [
                'enabled' => true,
                'frequency_hours' => 168,
                'timezone' => 'Asia/Bangkok',
            ])->assertOk()->assertJsonPath('data.enabled', true)
            ->assertJsonPath('data.frequency_hours', 168)
            ->assertJsonPath('data.timezone', 'Asia/Bangkok');

        $this->assertDatabaseHas('family_members', [
            'id' => $memberId,
            'reminder_enabled' => true,
            'reminder_frequency_hours' => 168,
            'reminder_timezone' => 'Asia/Bangkok',
        ]);

        Auth::forgetGuards();
        $this->withToken($ownerToken)
            ->patchJson("/api/family-members/{$memberId}/reminders", [
                'enabled' => false,
                'frequency_hours' => 24,
                'timezone' => 'Asia/Bangkok',
            ])->assertOk()->assertJsonPath('data.next_reminder_at', null);
        $this->assertDatabaseHas('family_members', [
            'id' => $memberId,
            'reminder_enabled' => false,
            'next_reminder_at' => null,
        ]);
    }

    public function test_mobile_risk_requests_are_saved_pending_and_history_is_owner_scoped(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $ownerToken = $owner->createToken('mobile', ['mobile'])->plainTextToken;
        $otherToken = $other->createToken('mobile', ['mobile'])->plainTextToken;

        $this->withToken($ownerToken)->postJson('/api/risk-assessments', [
            'latitude' => -0.9471,
            'longitude' => 100.4172,
            'rainfall_category' => 'unknown',
        ])->assertCreated()
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonPath('data.result', null)
            ->assertJsonPath('data.limitations.0', 'Jarak ke sungai belum tersedia.');

        $this->assertDatabaseHas('risk_assessments', [
            'user_id' => $owner->id,
            'status' => 'pending',
            'result' => null,
        ]);
        $this->withToken($ownerToken)->getJson('/api/risk-assessments')
            ->assertOk()->assertJsonCount(1, 'data');
        Auth::forgetGuards();
        $this->withToken($otherToken)->getJson('/api/risk-assessments')
            ->assertOk()->assertJsonCount(0, 'data');
    }

    public function test_mobile_risk_api_rejects_invalid_coordinates_without_saving(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('mobile', ['mobile'])->plainTextToken;

        $this->withToken($token)->postJson('/api/risk-assessments', [
            'latitude' => 91,
            'longitude' => 181,
        ])->assertUnprocessable()->assertJsonValidationErrors(['latitude', 'longitude']);

        $this->assertDatabaseCount('risk_assessments', 0);
    }
}
