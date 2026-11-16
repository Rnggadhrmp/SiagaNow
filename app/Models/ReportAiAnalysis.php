<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportAiAnalysis extends Model
{
    protected $fillable = ['disaster_report_id', 'status', 'model_name', 'model_version', 'detections', 'source_evidence_indices', 'error_code', 'started_at', 'analyzed_at', 'verification_status', 'verification_notes', 'verified_by', 'verified_at'];

    protected function casts(): array
    {
        return ['detections' => 'array', 'source_evidence_indices' => 'array', 'started_at' => 'datetime', 'analyzed_at' => 'datetime', 'verified_at' => 'datetime'];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(DisasterReport::class, 'disaster_report_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
