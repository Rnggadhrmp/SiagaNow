<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'phone', 'address', 'account_status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function riskAssessments(): HasMany
    {
        return $this->hasMany(RiskAssessment::class);
    }

    public function familyGroups(): HasMany
    {
        return $this->hasMany(FamilyGroup::class);
    }
    public function disasterReports(): HasMany
    {
        return $this->hasMany(DisasterReport::class);
    }

    public function adminRoles(): BelongsToMany
    {
        return $this->belongsToMany(AdminRole::class, 'admin_user_roles')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    public function hasAdminPermission(string $permission): bool
    {
        if (($this->account_status ?? 'active') !== 'active') {
            return false;
        }

        return $this->adminRoles->contains(function (AdminRole $role) use ($permission): bool {
            $permissions = $role->permissions ?? [];

            return in_array('*', $permissions, true) || in_array($permission, $permissions, true);
        });
    }
}
