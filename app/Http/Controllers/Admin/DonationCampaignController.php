<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationCampaign;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DonationCampaignController extends Controller
{
    public function index(Request $request): View
    {
        $campaigns = DonationCampaign::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.donations.index', compact('campaigns'));
    }

    public function create(): View
    {
        return view('admin.donations.form', ['campaign' => new DonationCampaign]);
    }

    public function store(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_simulation'] = $request->boolean('is_simulation');
        $data['status'] = 'draft';
        $data['author_user_id'] = $request->user()->id;
        $campaign = DonationCampaign::create($data);
        $audit->record($request, 'donation.created', 'Draf program donasi ditambahkan.', $campaign);

        return redirect()->route('admin.donations.edit', $campaign)->with('success', 'Draf program disimpan; pembayaran tidak tersedia.');
    }

    public function edit(DonationCampaign $donation): View
    {
        return view('admin.donations.form', ['campaign' => $donation]);
    }

    public function update(Request $request, DonationCampaign $donation, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_simulation'] = $request->boolean('is_simulation');
        if ($data['title'] !== $donation->title) $data['slug'] = $this->uniqueSlug($data['title'], $donation->id);
        if ($data['is_simulation']) {
            $data['verified_at'] = null;
            $data['verified_by'] = null;
            if ($donation->status === 'open') $data['status'] = 'draft';
        }
        $donation->update($data);
        $audit->record($request, 'donation.updated', 'Informasi program donasi diperbarui.', $donation, ['changed_fields' => array_keys($data)]);

        return back()->with('success', 'Program donasi diperbarui.');
    }

    public function verify(Request $request, DonationCampaign $donation, AdminAuditLogger $audit): RedirectResponse
    {
        if ($donation->is_simulation || !$donation->source_name || !$donation->source_url) {
            return back()->withErrors(['source_url' => 'Program simulasi tidak dapat diverifikasi sebagai penggalangan nyata.']);
        }

        $donation->forceFill(['verified_by' => $request->user()->id, 'verified_at' => now()])->save();
        $audit->record($request, 'donation.verified', 'Sumber program donasi diverifikasi.', $donation);

        return back()->with('success', 'Verifikasi sumber dicatat. Ini tidak mengaktifkan pembayaran.');
    }

    public function updateStatus(Request $request, DonationCampaign $donation, AdminAuditLogger $audit): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(['draft', 'open', 'closed'])]]);
        if ($data['status'] === 'open' && ($donation->is_simulation || !$donation->verified_at || !$donation->source_url)) {
            return back()->withErrors(['status' => 'Program hanya dapat dibuka setelah sumber nyata diverifikasi. Sistem pembayaran belum tersedia.']);
        }

        $previous = $donation->status;
        $donation->update(['status' => $data['status']]);
        $audit->record($request, 'donation.status_changed', 'Status program donasi diubah.', $donation, ['from' => $previous, 'to' => $donation->status]);

        return back()->with('success', 'Status program diperbarui. Tidak ada transaksi yang dicatat.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'max:5000'],
            'organizer' => ['required', 'string', 'max:180'],
            'target_amount' => ['required', 'integer', 'min:1', 'max:1000000000000'],
            'source_name' => ['nullable', 'string', 'max:120'],
            'source_url' => ['nullable', 'url:http,https', 'max:2000'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_simulation' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'program';
        $slug = $base;
        $suffix = 2;
        while (DonationCampaign::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }
        return $slug;
    }
}
