<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisasterReport extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'latitude',
        'longitude',
        'occurred_at',
        'event_type',
        'injured',
        'deceased',
        'damage_level',
        'description',
        'evidence_paths',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'occurred_at' => 'datetime',
            'injured' => 'integer',
            'deceased' => 'integer',
            'evidence_paths' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
