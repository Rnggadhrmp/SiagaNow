<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function __invoke(Request $request): View
    {
        $logs = AdminAuditLog::query()->with('actor:id,name,email')
            ->when($request->filled('action'), fn ($q) => $q->where('action', 'like', '%'.$request->string('action').'%'))
            ->when($request->filled('actor'), fn ($q) => $q->where('actor_user_id', $request->integer('actor')))
            ->latest('created_at')->paginate(30)->withQueryString();

        return view('admin.audit.index', compact('logs'));
    }
}
