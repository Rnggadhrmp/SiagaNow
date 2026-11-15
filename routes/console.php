<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\AdminRole;
use App\Models\AdminAuditLog;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:assign-role {email} {role}', function (string $email, string $role) {
    $user = User::query()->where('email', $email)->first();
    $adminRole = AdminRole::query()->where('slug', $role)->first();

    if (!$user || !$adminRole) {
        $this->error('Pengguna atau role tidak ditemukan.');
        return self::FAILURE;
    }

    if (!$this->confirm("Tetapkan role {$adminRole->name} pada akun {$user->email}?")) {
        $this->comment('Tidak ada perubahan.');
        return self::SUCCESS;
    }

    $user->adminRoles()->syncWithoutDetaching([$adminRole->id => ['assigned_by' => null]]);
    AdminAuditLog::create([
        'actor_user_id' => null,
        'action' => 'admin.role_assigned',
        'subject_type' => 'User',
        'subject_id' => $user->id,
        'summary' => "Role {$adminRole->slug} ditetapkan melalui perintah CLI.",
        'metadata' => ['role_id' => $adminRole->id],
    ]);
    $this->info('Role admin berhasil ditetapkan. Tidak ada kredensial yang dicetak.');

    return self::SUCCESS;
})->purpose('Tetapkan role dashboard admin ke akun yang sudah ada setelah konfirmasi');

Artisan::command('admin:revoke-role {email} {role}', function (string $email, string $role) {
    $user = User::query()->where('email', $email)->first();
    $adminRole = AdminRole::query()->where('slug', $role)->first();

    if (!$user || !$adminRole) {
        $this->error('Pengguna atau role tidak ditemukan.');
        return self::FAILURE;
    }

    if (!$this->confirm("Cabut role {$adminRole->name} dari akun {$user->email}?")) {
        $this->comment('Tidak ada perubahan.');
        return self::SUCCESS;
    }

    $user->adminRoles()->detach($adminRole->id);
    AdminAuditLog::create([
        'actor_user_id' => null,
        'action' => 'admin.role_revoked',
        'subject_type' => 'User',
        'subject_id' => $user->id,
        'summary' => "Role {$adminRole->slug} dicabut melalui perintah CLI.",
        'metadata' => ['role_id' => $adminRole->id],
    ]);
    $this->info('Role berhasil dicabut.');

    return self::SUCCESS;
})->purpose('Cabut role dashboard admin dari akun setelah konfirmasi');
