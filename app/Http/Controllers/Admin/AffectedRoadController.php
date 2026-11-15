<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffectedRoad;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AffectedRoadController extends Controller
{
    public function index(Request $request): View
    {
        $roads = AffectedRoad::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', '%'.$request->string('q').'%')->orWhere('area_description', 'like', '%'.$request->string('q').'%')))
            ->latest('observed_at')->paginate(15)->withQueryString();

        return view('admin.roads.index', compact('roads'));
    }

    public function create(): View
    {
        return view('admin.roads.form', ['road' => new AffectedRoad]);
    }

    public function store(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['route_geojson'] = $this->decodeGeoJson($data['route_geojson'] ?? null);
        $data['is_simulation'] = $request->boolean('is_simulation');
        $data['status'] = 'draft';
        $data['author_user_id'] = $request->user()->id;
        $road = AffectedRoad::create($data);
        $audit->record($request, 'road.created', 'Draf insiden ruas jalan dicatat.', $road);

        return redirect()->route('admin.roads.edit', $road)->with('success', 'Draf insiden jalan disimpan dan belum ditampilkan sebagai kondisi terverifikasi.');
    }

    public function edit(AffectedRoad $road): View
    {
        return view('admin.roads.form', compact('road'));
    }

    public function update(Request $request, AffectedRoad $road, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['route_geojson'] = $this->decodeGeoJson($data['route_geojson'] ?? null);
        $data['is_simulation'] = $request->boolean('is_simulation');
        if ($data['is_simulation']) {
            $data['verified_at'] = null;
            $data['verified_by'] = null;
            if ($road->status === 'active') $data['status'] = 'draft';
        }
        $road->update($data);
        $audit->record($request, 'road.updated', 'Informasi insiden jalan diperbarui.', $road, ['changed_fields' => array_keys($data)]);

        return back()->with('success', 'Informasi jalan diperbarui.');
    }

    public function verify(Request $request, AffectedRoad $road, AdminAuditLogger $audit): RedirectResponse
    {
        if ($road->is_simulation || !$road->source_url || !$road->source_name) {
            return back()->withErrors(['source_url' => 'Insiden jalan simulasi atau tanpa sumber tidak dapat diverifikasi.']);
        }
        $road->forceFill(['verified_by' => $request->user()->id, 'verified_at' => now()])->save();
        $audit->record($request, 'road.verified', 'Sumber insiden jalan diverifikasi.', $road);

        return back()->with('success', 'Verifikasi sumber dicatat.');
    }

    public function updateStatus(Request $request, AffectedRoad $road, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(['draft', 'active', 'closed'])]]);
        if ($data['status'] === 'active' && ($road->is_simulation || !$road->verified_at || !$road->source_url)) {
            return back()->withErrors(['status' => 'Status aktif memerlukan sumber yang diverifikasi. Data ini tidak menyatakan rute lain aman.']);
        }

        $previous = $road->status;
        $road->update([
            'status' => $data['status'],
            'closed_at' => $data['status'] === 'closed' ? now() : null,
        ]);
        $audit->record($request, 'road.status_changed', 'Status insiden jalan diubah.', $road, ['from' => $previous, 'to' => $road->status]);

        return back()->with('success', 'Status insiden jalan diperbarui. Tidak ada klaim bahwa jalan lain aman.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'area_description' => ['required', 'string', 'max:3000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'route_geojson' => ['nullable', 'json'],
            'impact_level' => ['required', Rule::in(['unknown', 'low', 'moderate', 'high', 'critical'])],
            'source_name' => ['required', 'string', 'max:120'],
            'source_url' => ['required', 'url:http,https', 'max:2000'],
            'observed_at' => ['nullable', 'date'],
        ]);
    }

    private function decodeGeoJson(?string $value): ?array
    {
        return $value ? json_decode($value, true, 512, JSON_THROW_ON_ERROR) : null;
    }
}
