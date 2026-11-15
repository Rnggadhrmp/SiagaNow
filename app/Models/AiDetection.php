<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiDetection extends Model
{
    protected $fillable = [
        'camera_source_id', 'external_reference', 'risk_status', 'confidence', 'observed_at',
        'source_name', 'verification_status', 'verified_by', 'verified_at',
    ];

    protected function casts(): array
    {
        return ['confidence' => 'decimal:4', 'observed_at' => 'datetime', 'verified_at' => 'datetime'];
    }

    public function camera(): BelongsTo
    {
        return $this->belongsTo(AiCameraSource::class, 'camera_source_id');
    }
}
