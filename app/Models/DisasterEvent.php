<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterEvent extends Model
{
    protected $fillable = [
        'name',
        'event_type',
        'description',
        'latitude',
        'longitude',
        'occurred_at',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'occurred_at' => 'datetime',
        ];
    }
}