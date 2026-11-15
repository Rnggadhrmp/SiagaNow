<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminAlert extends Model
{
    protected $fillable = [
        'title', 'hazard_type', 'risk_level', 'affected_area', 'description', 'area_geojson',
        'source_name', 'source_url', 'is_simulation', 'status', 'starts_at', 'expires_at',
        'verified_by', 'verified_at', 'author_user_id',
    ];

    protected function casts(): array
    {
        return [
            'area_geojson' => 'array', 'is_simulation' => 'boolean',
            'starts_at' => 'datetime', 'expires_at' => 'datetime', 'verified_at' => 'datetime',
        ];
    }

    public function scopePubliclyActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where('is_simulation', false)
            ->whereNotNull('verified_at')
            ->where(fn (Builder $q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn (Builder $q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
