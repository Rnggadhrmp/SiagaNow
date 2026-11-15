<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterReport;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $reports = DisasterReport::query()->with('user:id,name,email')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('type'), fn ($q) => $q->where('event_type', $request->string('type')))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w->where('title', 'like', '%'.$request->string('q').'%')->orWhere('description', 'like', '%'.$request->string('q').'%')))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function show(DisasterReport $report): View
    {
        return view('admin.reports.show', ['report' => $report->load('user:id,name,email')]);
    }

    public function updateStatus(Request $request, DisasterReport $report, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(['submitted', 'under_review', 'verified', 'rejected', 'closed'])]]);
        $previous = $report->status;
        if ($previous === $data['status']) return back()->with('success', 'Status laporan tidak berubah.');

        $report->update(['status' => $data['status']]);
        $audit->record($request, 'report.status_changed', 'Status laporan diubah oleh petugas.', $report, ['from' => $previous, 'to' => $report->status]);

        return back()->with('success', 'Status laporan diperbarui.');
    }

    public function evidence(DisasterReport $report, int $index): StreamedResponse
    {
        $paths = $report->evidence_paths ?? [];
        abort_unless(isset($paths[$index]) && is_string($paths[$index]), 404);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($paths[$index]), 404);

        return $disk->download($paths[$index], basename($paths[$index]));
    }
}
