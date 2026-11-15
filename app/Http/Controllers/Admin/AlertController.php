<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAlert;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function index(Request $request): View
    {
        $alerts = AdminAlert::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.alerts.index', compact('alerts'));
    }

    public function create(): View
    {
        return view('admin.alerts.form', ['alert' => new AdminAlert]);
    }

    public function store(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['area_geojson'] = $this->decodeGeoJson($data['area_geojson'] ?? null);
        $data['is_simulation'] = $request->boolean('is_simulation');
        $data['status'] = 'draft';
        $data['author_user_id'] = $request->user()->id;
        $alert = AdminAlert::create($data);
        $audit->record($request, 'alert.created', 'Draf informasi peringatan ditambahkan.', $alert);

        return redirect()->route('admin.alerts.edit', $alert)->with('success', 'Draf peringatan berhasil disimpan.');
    }

    public function edit(AdminAlert $alert): View
    {
        return view('admin.alerts.form', compact('alert'));
    }

    public function update(Request $request, AdminAlert $alert, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['area_geojson'] = $this->decodeGeoJson($data['area_geojson'] ?? null);
        $data['is_simulation'] = $request->boolean('is_simulation');
        if ($data['is_simulation']) {
            $data['verified_at'] = null;
            $data['verified_by'] = null;
            if ($alert->status === 'active') $data['status'] = 'draft';
        }
        $alert->update($data);
        $audit->record($request, 'alert.updated', 'Informasi peringatan diperbarui.', $alert, ['changed_fields' => array_keys($data)]);

        return back()->with('success', 'Perubahan peringatan disimpan.');
    }

    public function verify(Request $request, AdminAlert $alert, AdminAuditLogger $audit): RedirectResponse
    {
        if ($alert->is_simulation || !$alert->source_name || !$alert->source_url) {
            return back()->withErrors(['source_url' => 'Informasi simulasi tidak dapat diverifikasi atau dipublikasikan sebagai peringatan aktual.']);
        }

        $alert->forceFill(['verified_by' => $request->user()->id, 'verified_at' => now()])->save();
        $audit->record($request, 'alert.verified', 'Sumber informasi peringatan diverifikasi oleh petugas.', $alert);

        return back()->with('success', 'Verifikasi sumber dicatat. Aktifkan hanya bila informasi masih berlaku.');
    }

    public function updateStatus(Request $request, AdminAlert $alert, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(['draft', 'active', 'closed'])]]);
        if ($data['status'] === 'active' && ($alert->is_simulation || !$alert->verified_at || !$alert->source_url)) {
            return back()->withErrors(['status' => 'Peringatan hanya dapat diaktifkan setelah diverifikasi dari sumber yang dicantumkan.']);
        }

        $previous = $alert->status;
        $alert->update(['status' => $data['status']]);
        $audit->record($request, 'alert.status_changed', 'Status peringatan diubah.', $alert, ['from' => $previous, 'to' => $alert->status]);

        return back()->with('success', 'Status peringatan diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'hazard_type' => ['required', Rule::in(['Banjir', 'Tanah longsor', 'Cuaca ekstrem', 'Lainnya'])],
            'risk_level' => ['required', Rule::in(['unknown', 'waspada', 'siaga', 'bahaya'])],
            'affected_area' => ['required', 'string', 'max:3000'],
            'description' => ['required', 'string', 'max:10000'],
            'area_geojson' => ['nullable', 'json'],
            'source_name' => ['required', 'string', 'max:120'],
            'source_url' => ['required', 'url:http,https', 'max:2000'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);
    }

    private function decodeGeoJson(?string $value): ?array
    {
        return $value ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;
    }
}
