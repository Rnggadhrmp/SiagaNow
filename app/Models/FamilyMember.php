<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    // User-editable contact fields only. Link, check-in, invitation, and
    // reminder state is assigned explicitly by authorized controller actions.
    protected $fillable = ['name', 'relation', 'emergency_phone', 'notes'];

    protected $hidden = [
        'user_id',
        'last_check_in_request_id',
        'invite_code_hash',
        'invite_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'check_in_at' => 'datetime',
            'next_reminder_at' => 'datetime',
            'invite_expires_at' => 'datetime',
            'reminder_enabled' => 'boolean',
            'reminder_frequency_hours' => 'integer',
        ];
    }

    public function familyGroup(): BelongsTo
    {
        return $this->belongsTo(FamilyGroup::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
