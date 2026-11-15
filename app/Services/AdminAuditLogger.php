<?php

namespace App\Services;

use App\Models\AdminAuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminAuditLogger
{
    public function record(Request $request, string $action, string $summary, ?Model $subject = null, array $metadata = []): void
    {
        AdminAuditLog::create([
            'actor_user_id' => $request->user()?->id,
            'action' => $action,
            'subject_type' => $subject ? class_basename($subject) : null,
            'subject_id' => $subject?->getKey(),
            'summary' => $summary,
            // Store only explicitly supplied non-sensitive audit details. Never store raw form payloads.
            'metadata' => $metadata ?: null,
        ]);
    }
}
