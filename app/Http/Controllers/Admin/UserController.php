<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\User;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()->select(['id', 'name', 'email', 'phone', 'address', 'account_status', 'created_at'])
            ->with('adminRoles:id,name,slug')
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', '%'.$request->string('q').'%')->orWhere('email', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('status'), fn ($q) => $q->where('account_status', $request->string('status')))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->makeHidden(['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes']);
        $user->load('adminRoles:id,name,slug');

        return view('admin.users.show', compact('user'));
    }

    public function updateStatus(Request $request, User $user, AdminAuditLogger $audit): RedirectResponse
    {
        abort_if($request->user()->is($user), 422, 'Admin tidak dapat menonaktifkan akunnya sendiri.');
        $data = $request->validate(['account_status' => ['required', Rule::in(['active', 'suspended'])]]);
        $previous = $user->account_status ?? 'active';
        if ($previous === $data['account_status']) return back()->with('success', 'Status akun tidak berubah.');

        if ($data['account_status'] === 'suspended' && $user->hasAdminPermission('dashboard.view')) {
            $remaining = User::query()->where('account_status', 'active')->whereKeyNot($user->id)
                ->whereHas('adminRoles', fn ($q) => $q->whereJsonContains('permissions', '*'))
                ->exists();
            abort_unless($remaining, 422, 'Setidaknya satu Super Admin aktif harus dipertahankan.');
        }

        $user->update(['account_status' => $data['account_status']]);
        $audit->record($request, 'user.status_changed', 'Status akun pengguna diubah.', $user, ['from' => $previous, 'to' => $user->account_status]);

        return back()->with('success', 'Status akun diperbarui.');
    }

    public function updateRoles(Request $request, User $user, AdminAuditLogger $audit): RedirectResponse
    {
        abort_if($request->user()->is($user), 422, 'Gunakan akun Super Admin lain untuk mengubah role akun sendiri.');
        $data = $request->validate(['role_ids' => ['nullable', 'array'], 'role_ids.*' => ['integer', 'exists:admin_roles,id']]);
        $newIds = $data['role_ids'] ?? [];

        $removesLastSuperAdmin = $user->adminRoles()->where('slug', 'super-admin')->exists()
            && !in_array(AdminRole::query()->where('slug', 'super-admin')->value('id'), $newIds);
        if ($removesLastSuperAdmin) {
            $activeSuperAdminExists = User::query()->where('account_status', 'active')->whereKeyNot($user->id)
                ->whereHas('adminRoles', fn ($q) => $q->where('slug', 'super-admin'))->exists();
            abort_unless($activeSuperAdminExists, 422, 'Role Super Admin terakhir tidak boleh dicabut.');
        }

        DB::transaction(function () use ($user, $newIds, $request): void {
            $user->adminRoles()->sync(collect($newIds)->mapWithKeys(fn ($id) => [$id => ['assigned_by' => $request->user()->id]])->all());
        });
        $audit->record($request, 'user.roles_changed', 'Role admin akun diubah.', $user, ['role_ids' => array_values($newIds)]);

        return back()->with('success', 'Role dan hak akses diperbarui.');
    }
}
