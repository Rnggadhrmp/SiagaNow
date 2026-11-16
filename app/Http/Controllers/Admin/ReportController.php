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
        return view('admin.reports.show', ['report' => $report->load('user:id,name,email', 'aiAnalysis')]);
    }

    public function updateStatus(Request $request, DisasterReport $report, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(['submitted', 'under_review', 'verified', 'rejected', 'closed'])]]);
        $previous = $report->status;
        if ($previous === $data['status']) {
            return back()->with('success', 'Status laporan tidak berubah.');
        }

        $report->update(['status' => $data['status']]);
        $audit->record($request, 'report.status_changed', 'Status laporan diubah oleh petugas.', $report, ['from' => $previous, 'to' => $report->status]);

        return back()->with('success', 'Status laporan diperbarui.');
    }

    public function updateAiVerification(Request $request, DisasterReport $report, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['verification_status' => ['required', Rule::in(['verified', 'rejected'])], 'verification_notes' => ['nullable', 'string', 'max:2000']]);
        $analysis = $report->aiAnalysis;
        abort_unless($analysis && $analysis->status === 'completed', 409, 'Hasil analisis belum tersedia untuk diverifikasi.');
        $analysis->update(['verification_status' => $data['verification_status'], 'verification_notes' => $data['verification_notes'] ?? null, 'verified_by' => $request->user()->id, 'verified_at' => now()]);
        $audit->record($request, 'report.ai_verification_changed', 'Hasil analisis AI ditinjau admin.', $report, ['verification_status' => $data['verification_status']]);

        return back()->with('success', 'Verifikasi analisis AI diperbarui. Status laporan resmi tidak berubah.');
    }

    public function evidencePreview(DisasterReport $report, int $index)
    {
        $paths = $report->evidence_paths ?? [];
        abort_unless(isset($paths[$index]) && is_string($paths[$index]), 404);
        $disk = Storage::disk('local');
        abort_unless($disk->exists($paths[$index]), 404);
        $mime = $disk->mimeType($paths[$index]);
        abort_unless(in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true), 404);

        return response()->file($disk->path($paths[$index]), ['Content-Type' => $mime, 'X-Content-Type-Options' => 'nosniff', 'Cache-Control' => 'private, no-store']);
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
