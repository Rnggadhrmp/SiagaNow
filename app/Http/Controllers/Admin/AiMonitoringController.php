<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiCameraSource;
use App\Models\AiDetection;
use App\Services\AdminAuditLogger;
use App\Services\FloodDetectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AiMonitoringController extends Controller
{
    public function index(FloodDetectionService $floodDetection): View
    {
        $summary = $floodDetection->summary();

        return view('admin.ai.index', [
            'serviceStatus' => $summary['service_status'],
            'serviceSummary' => $summary,
            'cameras' => AiCameraSource::query()->withCount('detections')->orderBy('name')->paginate(15, ['*'], 'cameras_page'),
            'detections' => AiDetection::query()->with('camera')->latest('observed_at')->paginate(20, ['*'], 'detections_page'),
        ]);
    }

    public function storeCamera(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validatedCamera($request);
        $data['is_enabled'] = $request->boolean('is_enabled');
        $data['created_by'] = $request->user()->id;
        $camera = AiCameraSource::create($data);
        $audit->record($request, 'ai.camera_created', 'Metadata sumber kamera dicatat; konfigurasi ingest '.($camera->is_enabled ? 'diaktifkan.' : 'dinonaktifkan.'), $camera);

        return back()->with('success', $camera->is_enabled
            ? 'Metadata disimpan dan sumber dapat menerima ingest. Ini tidak menyambungkan kamera/video secara otomatis.'
            : 'Metadata kamera disimpan dalam keadaan nonaktif.');
    }

    public function editCamera(AiCameraSource $camera): View
    {
        return view('admin.ai.camera-form', compact('camera'));
    }

    public function updateCamera(Request $request, AiCameraSource $camera, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validatedCamera($request);
        // Enabling a record is only administrative metadata; it does not claim the feed is online.
        $data['is_enabled'] = $request->boolean('is_enabled');
        $camera->update($data);
        $audit->record($request, 'ai.camera_updated', 'Metadata sumber kamera dan izin ingest diperbarui.', $camera, ['changed_fields' => array_keys($data)]);

        return back()->with('success', 'Metadata sumber diperbarui. Observasi akan diterima hanya jika konfigurasi token ingest aktif dan sumber ini diaktifkan.');
    }

    public function verifyDetection(Request $request, AiDetection $detection, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['verification_status' => ['required', Rule::in(['verified', 'rejected'])]]);
        if ($detection->risk_status === 'unknown') {
            return back()->withErrors(['verification_status' => 'Hasil Unknown tidak dapat diverifikasi sebagai keadaan Normal atau Bahaya.']);
        }

        $detection->update([
            'verification_status' => $data['verification_status'],
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);
        $audit->record($request, 'ai.detection_reviewed', 'Status verifikasi hasil observasi AI diperbarui.', $detection, ['verification_status' => $detection->verification_status]);

        return back()->with('success', 'Status verifikasi hasil observasi dicatat.');
    }

    private function validatedCamera(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'notes' => ['nullable', 'string', 'max:3000'],
            'is_enabled' => ['nullable', 'boolean'],
        ]);
    }
}
