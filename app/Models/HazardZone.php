<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardZone extends Model
{
    protected $fillable = [
        'name',
        'hazard_type',
        'severity',
        'area_geojson',
        'source',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'area_geojson' => 'array',
            'verified_at' => 'datetime',
        ];
    }
}