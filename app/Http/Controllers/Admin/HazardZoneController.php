<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HazardZone;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HazardZoneController extends Controller
{
    public function index(): View
    {
        return view('admin.zones.index', ['zones' => HazardZone::query()->latest()->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.zones.form', ['zone' => new HazardZone]);
    }

    public function store(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['area_geojson'] = $this->decodeGeoJson($data['area_geojson'] ?? null);
        $zone = HazardZone::create($data + ['verified_at' => null, 'verified_by' => null]);
        $audit->record($request, 'zone.created', 'Draf zona informasi dibuat dan belum ditampilkan ke publik.', $zone);

        return redirect()->route('admin.zones.edit', $zone)->with('success', 'Zona disimpan sebagai belum terverifikasi.');
    }

    public function edit(HazardZone $zone): View
    {
        return view('admin.zones.form', compact('zone'));
    }

    public function update(Request $request, HazardZone $zone, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['area_geojson'] = $this->decodeGeoJson($data['area_geojson'] ?? null);
        $zone->update($data);
        $audit->record($request, 'zone.updated', 'Informasi zona diperbarui.', $zone, ['changed_fields' => array_keys($data)]);

        return back()->with('success', 'Informasi zona diperbarui.');
    }

    public function verify(Request $request, HazardZone $zone, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['verified' => ['required', 'boolean']]);
        if ($data['verified'] && (!$zone->source_url || !$zone->area_geojson)) {
            return back()->withErrors(['verified' => 'Cantumkan sumber rujukan dan geometri sebelum verifikasi.']);
        }
        $zone->forceFill([
            'verified_at' => $data['verified'] ? now() : null,
            'verified_by' => $data['verified'] ? $request->user()->id : null,
        ])->save();
        $audit->record($request, $data['verified'] ? 'zone.verified' : 'zone.unverified', $data['verified'] ? 'Zona diverifikasi petugas.' : 'Verifikasi zona dicabut.', $zone);

        return back()->with('success', $data['verified'] ? 'Zona kini dapat digunakan sebagai informasi terverifikasi.' : 'Zona tidak lagi ditampilkan sebagai terverifikasi.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'hazard_type' => ['required', Rule::in(['Banjir', 'Tanah longsor', 'Lainnya'])],
            'severity' => ['nullable', Rule::in(['unknown', 'low', 'moderate', 'high', 'critical'])],
            'area_geojson' => ['required', 'json'],
            'source' => ['required', 'string', 'max:255'],
            'source_url' => ['required', 'url:http,https', 'max:2000'],
        ]);
    }

    private function decodeGeoJson(string $value): array
    {
        $geojson = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($geojson) || !isset($geojson['type'])) {
            throw \Illuminate\Validation\ValidationException::withMessages(['area_geojson' => 'GeoJSON harus memiliki properti type.']);
        }
        return $geojson;
    }
}
