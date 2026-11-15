<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DonationCampaign extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'organizer', 'target_amount', 'source_name', 'source_url',
        'is_simulation', 'status', 'starts_at', 'ends_at', 'verified_by', 'verified_at', 'author_user_id',
    ];

    protected function casts(): array
    {
        return [
            'target_amount' => 'integer', 'is_simulation' => 'boolean',
            'starts_at' => 'datetime', 'ends_at' => 'datetime', 'verified_at' => 'datetime',
        ];
    }

    public function scopePubliclyActive(Builder $query): Builder
    {
        return $query->where('status', 'open')
            ->where('is_simulation', false)
            ->whereNotNull('verified_at')
            ->where(fn (Builder $q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn (Builder $q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }
}
