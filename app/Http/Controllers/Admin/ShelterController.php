<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shelter;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ShelterController extends Controller
{
    public function index(Request $request): View
    {
        $shelters = Shelter::query()
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($where) => $where->where('name', 'like', '%'.$request->string('q').'%')->orWhere('address', 'like', '%'.$request->string('q').'%')))
            ->when($request->input('verified') === 'yes', fn ($q) => $q->whereNotNull('verified_at'))
            ->when($request->input('verified') === 'no', fn ($q) => $q->whereNull('verified_at'))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.shelters.index', compact('shelters'));
    }

    public function create(): View
    {
        return view('admin.shelters.form', ['shelter' => new Shelter]);
    }

    public function store(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $shelter = Shelter::create($data + ['verified_at' => null]);
        $audit->record($request, 'shelter.created', 'Data shelter ditambahkan sebagai belum terverifikasi.', $shelter);

        return redirect()->route('admin.shelters.edit', $shelter)->with('success', 'Shelter disimpan sebagai belum terverifikasi.');
    }

    public function edit(Shelter $shelter): View
    {
        return view('admin.shelters.form', compact('shelter'));
    }

    public function update(Request $request, Shelter $shelter, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $shelter->update($data);
        $audit->record($request, 'shelter.updated', 'Data shelter diperbarui.', $shelter, ['changed_fields' => array_keys($data)]);

        return back()->with('success', 'Data shelter diperbarui.');
    }

    public function verify(Request $request, Shelter $shelter, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['verified' => ['required', 'boolean']]);
        if ($data['verified'] && (!$shelter->address || $shelter->latitude === null || $shelter->longitude === null || !$shelter->source || !$shelter->source_url)) {
            return back()->withErrors(['verified' => 'Alamat, koordinat valid, nama sumber, dan URL sumber verifikasi wajib tersedia.']);
        }

        $shelter->forceFill(['verified_at' => $data['verified'] ? now() : null])->save();
        $audit->record(
            $request,
            $data['verified'] ? 'shelter.verified' : 'shelter.unverified',
            $data['verified'] ? 'Shelter diverifikasi petugas.' : 'Verifikasi shelter dicabut.',
            $shelter,
        );

        return back()->with('success', $data['verified'] ? 'Shelter kini ditandai terverifikasi.' : 'Shelter tidak lagi ditampilkan sebagai shelter terverifikasi.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:5000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'capacity' => ['nullable', 'integer', 'min:0', 'max:10000000'],
            'status' => ['required', Rule::in(['unknown', 'open', 'closed'])],
            'source' => ['required', 'string', 'max:255'],
            'source_url' => ['nullable', 'url:http,https', 'max:2000'],
        ]);
    }
}
