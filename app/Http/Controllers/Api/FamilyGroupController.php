<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FamilyGroup;
use App\Models\FamilyMember;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FamilyGroupController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $request->user()->familyGroups()->with('members')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);

        if ($request->user()->familyGroups()->exists()) {
            return response()->json([
                'message' => 'Akun ini sudah memiliki grup keluarga.',
            ], 409);
        }

        $group = FamilyGroup::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
        ]);

        return response()->json(['data' => $group->load('members')], 201);
    }

    public function show(Request $request, FamilyGroup $familyGroup): JsonResponse
    {
        $this->ensureOwner($request, $familyGroup);

        return response()->json(['data' => $familyGroup->load('members')]);
    }

    public function update(Request $request, FamilyGroup $familyGroup): JsonResponse
    {
        $this->ensureOwner($request, $familyGroup);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
        ]);
        $familyGroup->update($validated);

        return response()->json(['data' => $familyGroup->load('members')]);
    }

    public function destroy(Request $request, FamilyGroup $familyGroup): JsonResponse
    {
        $this->ensureOwner($request, $familyGroup);
        $familyGroup->delete();

        return response()->json(['message' => 'Grup keluarga dihapus.']);
    }

    public function storeMember(Request $request, FamilyGroup $familyGroup): JsonResponse
    {
        $this->ensureOwner($request, $familyGroup);
        $member = $familyGroup->members()->create($this->validatedMember($request));

        return response()->json(['data' => $member], 201);
    }

    public function updateMember(
        Request $request,
        FamilyGroup $familyGroup,
        FamilyMember $member,
    ): JsonResponse {
        $this->ensureOwner($request, $familyGroup);
        abort_unless($member->family_group_id === $familyGroup->id, 404);
        $member->update($this->validatedMember($request));

        return response()->json(['data' => $member]);
    }

    public function destroyMember(
        Request $request,
        FamilyGroup $familyGroup,
        FamilyMember $member,
    ): JsonResponse {
        $this->ensureOwner($request, $familyGroup);
        abort_unless($member->family_group_id === $familyGroup->id, 404);
        $member->delete();

        return response()->json(['message' => 'Anggota dihapus.']);
    }

    public function createInvitation(
        Request $request,
        FamilyGroup $familyGroup,
        FamilyMember $member,
    ): JsonResponse {
        $this->ensureOwner($request, $familyGroup);
        abort_unless($member->family_group_id === $familyGroup->id, 404);
        abort_if($member->user_id !== null, 409, 'Anggota sudah terhubung ke akun.');

        $code = Str::random(48);
        $expiresAt = Carbon::now('UTC')->addDay();
        $member->invite_code_hash = hash('sha256', $code);
        $member->invite_expires_at = $expiresAt;
        $member->save();

        return response()->json([
            'data' => ['code' => $code, 'expires_at' => $expiresAt->toIso8601String()],
        ], 201);
    }

    public function acceptInvitation(Request $request): JsonResponse
    {
        $validated = $request->validate(['code' => ['required', 'string', 'max:100']]);
        $member = FamilyMember::query()
            ->where('invite_code_hash', hash('sha256', $validated['code']))
            ->first();

        abort_if(
            $member === null || $member->invite_expires_at === null ||
            $member->invite_expires_at->isPast(),
            422,
            'Kode undangan tidak berlaku atau sudah kedaluwarsa.',
        );
        abort_if($member->user_id !== null && $member->user_id !== $request->user()->id, 409);

        $member->user_id = $request->user()->id;
        $member->invite_code_hash = null;
        $member->invite_expires_at = null;
        $member->save();

        return response()->json(['data' => $this->membershipData($member->load('familyGroup'))]);
    }

    public function memberships(Request $request): JsonResponse
    {
        $memberships = FamilyMember::query()
            ->with(['familyGroup.members'])
            ->where('user_id', $request->user()->id)
            ->orderBy('id')
            ->get()
            ->map(fn (FamilyMember $member) => $this->membershipData($member));

        return response()->json(['data' => $memberships]);
    }

    public function checkIns(Request $request, FamilyGroup $familyGroup): JsonResponse
    {
        $this->ensureCanViewCheckIns($request, $familyGroup);

        return response()->json(['data' => $this->checkInData($familyGroup)]);
    }

    public function checkIn(Request $request, FamilyMember $member): JsonResponse
    {
        abort_unless($member->user_id === $request->user()->id, 404);
        $validated = $request->validate([
            'request_id' => ['required', 'string', 'max:100'],
        ]);

        $duplicate = $member->last_check_in_request_id === $validated['request_id'];
        if (! $duplicate) {
            $checkedAt = Carbon::now('UTC');
            $member->check_in_at = $checkedAt;
            $member->last_check_in_request_id = $validated['request_id'];
            $member->next_reminder_at = $member->reminder_enabled
                ? $checkedAt->copy()->addHours($member->reminder_frequency_hours)
                : null;
            $member->save();
        }

        return response()->json(['data' => [
            'member_id' => $member->id,
            'check_in_at' => $member->check_in_at?->toIso8601String(),
            'next_reminder_at' => $member->next_reminder_at?->toIso8601String(),
            'duplicate' => $duplicate,
        ]]);
    }

    public function updateReminder(Request $request, FamilyMember $member): JsonResponse
    {
        $this->ensureCanManageReminder($request, $member);
        $validated = $request->validate([
            'enabled' => ['required', 'boolean'],
            'frequency_hours' => ['required', 'integer', 'in:24,168'],
            'timezone' => ['required', 'string', 'max:64', function ($attribute, $value, $fail) {
                if (! in_array($value, timezone_identifiers_list(), true)) {
                    $fail('Zona waktu harus menggunakan nama IANA yang valid.');
                }
            }],
        ]);

        $member->reminder_enabled = (bool) $validated['enabled'];
        $member->reminder_frequency_hours = (int) $validated['frequency_hours'];
        $member->reminder_timezone = $validated['timezone'];
        $member->next_reminder_at = $member->reminder_enabled
            ? Carbon::now('UTC')->addHours($member->reminder_frequency_hours)
            : null;
        $member->save();

        return response()->json(['data' => [
            'member_id' => $member->id,
            'enabled' => $member->reminder_enabled,
            'frequency_hours' => $member->reminder_frequency_hours,
            'timezone' => $member->reminder_timezone,
            'next_reminder_at' => $member->next_reminder_at?->toIso8601String(),
        ]]);
    }

    private function membershipData(FamilyMember $member): array
    {
        $group = $member->familyGroup;
        return [
            'id' => $member->id,
            'name' => $member->name,
            'relation' => $member->relation,
            'check_in_at' => $member->check_in_at?->toIso8601String(),
            'reminder_enabled' => $member->reminder_enabled,
            'reminder_frequency_hours' => $member->reminder_frequency_hours,
            'reminder_timezone' => $member->reminder_timezone,
            'next_reminder_at' => $member->next_reminder_at?->toIso8601String(),
            'group' => ['id' => $group->id, 'name' => $group->name],
            'members' => $this->checkInData($group),
        ];
    }

    private function checkInData(FamilyGroup $familyGroup): array
    {
        $now = Carbon::now('UTC');
        return $familyGroup->members->map(function (FamilyMember $member) use ($now) {
            $overdue = $member->reminder_enabled && $member->next_reminder_at !== null
                && $member->next_reminder_at->lessThanOrEqualTo($now);
            $status = $member->check_in_at === null
                ? ($overdue ? 'waiting' : 'never_confirmed')
                : ($overdue ? 'waiting' : 'confirmed');

            return [
                'id' => $member->id,
                'name' => $member->name,
                'status' => $status,
                'overdue' => $overdue,
                'check_in_at' => $member->check_in_at?->toIso8601String(),
                'reminder_enabled' => $member->reminder_enabled,
                'reminder_frequency_hours' => $member->reminder_frequency_hours,
                'reminder_timezone' => $member->reminder_timezone,
                'next_reminder_at' => $member->next_reminder_at?->toIso8601String(),
            ];
        })->values()->all();
    }

    private function ensureCanViewCheckIns(Request $request, FamilyGroup $familyGroup): void
    {
        abort_unless(
            $familyGroup->user_id === $request->user()->id ||
            $familyGroup->members()->where('user_id', $request->user()->id)->exists(),
            404,
        );
    }

    private function ensureCanManageReminder(Request $request, FamilyMember $member): void
    {
        $isOwner = $member->familyGroup()->where('user_id', $request->user()->id)->exists();
        abort_unless($isOwner || $member->user_id === $request->user()->id, 404);
    }

    private function validatedMember(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'relation' => ['nullable', 'string', 'max:80'],
            'emergency_phone' => ['nullable', 'string', 'max:32'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function ensureOwner(Request $request, FamilyGroup $familyGroup): void
    {
        abort_unless($familyGroup->user_id === $request->user()->id, 404);
    }
}
