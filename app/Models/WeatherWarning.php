<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherWarning extends Model
{
    protected $fillable = [
        'external_id',
        'title',
        'description',
        'area_description',
        'detail_url',
        'category',
        'published_at',
        'effective_at',
        'expires_at',
        'polygons',
        'source',
        'last_fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'effective_at' => 'datetime',
            'expires_at' => 'datetime',
            'last_fetched_at' => 'datetime',
            'polygons' => 'array',
        ];
    }
}
