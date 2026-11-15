<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiCameraSource extends Model
{
    protected $fillable = ['name', 'location', 'latitude', 'longitude', 'is_enabled', 'notes', 'created_by'];

    protected function casts(): array
    {
        return ['latitude' => 'decimal:7', 'longitude' => 'decimal:7', 'is_enabled' => 'boolean'];
    }

    public function detections(): HasMany
    {
        return $this->hasMany(AiDetection::class, 'camera_source_id');
    }
}
