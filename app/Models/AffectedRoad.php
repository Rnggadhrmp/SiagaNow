<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AffectedRoad extends Model
{
    protected $fillable = [
        'name', 'area_description', 'latitude', 'longitude', 'route_geojson', 'impact_level', 'status',
        'source_name', 'source_url', 'is_simulation', 'observed_at', 'verified_by', 'verified_at',
        'closed_at', 'author_user_id',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7', 'longitude' => 'decimal:7', 'route_geojson' => 'array',
            'is_simulation' => 'boolean', 'observed_at' => 'datetime', 'verified_at' => 'datetime', 'closed_at' => 'datetime',
        ];
    }

    public function scopePubliclyActive(Builder $query): Builder
    {
        return $query->where('status', 'active')->where('is_simulation', false)->whereNotNull('verified_at');
    }
}
