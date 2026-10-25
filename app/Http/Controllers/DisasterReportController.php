<?php

namespace App\Http\Controllers;

use App\Models\DisasterReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class DisasterReportController extends Controller
{
    public function apiIndex(Request $request): JsonResponse
    {
        $reports = DisasterReport::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->limit(50)
            ->get([
                'id', 'title', 'latitude', 'longitude', 'occurred_at',
                'event_type', 'injured', 'deceased', 'damage_level',
                'description', 'status', 'created_at',
            ]);

        return response()->json([
            'data' => $reports,
            'message' => $reports->isEmpty()
                ? 'Belum ada laporan pada akun ini.'
                : 'Laporan akun berhasil dimuat.',
        ]);
    }

    public function index(Request $request)
    {
        return view('report-status', [
            'reports' => DisasterReport::query()
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate(10),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'event_date' => ['required', 'date_format:Y-m-d'],
            'event_time' => ['required', 'date_format:H:i'],
            'event_type' => ['required', 'in:Banjir,Tanah longsor'],
            'injured' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'deceased' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'damage_level' => ['required', 'in:Rendah,Sedang,Tinggi'],
            'description' => ['required', 'string', 'max:3000'],
            'evidence' => ['nullable', 'array', 'max:5'],
            'evidence.*' => ['file', 'mimes:jpg,jpeg,png,webp,mp4,webm', 'max:10240'],
        ], [
            'evidence.max' => 'Maksimal 5 file bukti dapat dilampirkan.',
            'evidence.*.max' => 'Ukuran setiap file bukti maksimal 10 MB.',
            'evidence.*.mimes' => 'Format file bukti harus JPG, PNG, WEBP, MP4, atau WEBM.',
        ]);

        $storedPaths = [];

        try {
            $report = DB::transaction(function () use ($request, $validated, &$storedPaths) {
                foreach ($request->file('evidence', []) as $file) {
                    $storedPaths[] = $file->store('disaster-reports/'.$request->user()->id, 'local');
                }

                return DisasterReport::create([
                    'user_id' => $request->user()->id,
                    'title' => $validated['title'],
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                    'occurred_at' => Carbon::createFromFormat(
                        'Y-m-d H:i',
                        $validated['event_date'].' '.$validated['event_time'],
                    ),
                    'event_type' => $validated['event_type'],
                    'injured' => $validated['injured'] ?? 0,
                    'deceased' => $validated['deceased'] ?? 0,
                    'damage_level' => $validated['damage_level'],
                    'description' => $validated['description'],
                    'evidence_paths' => $storedPaths ?: null,
                    'status' => 'submitted',
                ]);
            });
        } catch (Throwable $exception) {
            if ($storedPaths !== []) {
                Storage::disk('local')->delete($storedPaths);
            }

            report($exception);

            return response()->json([
                'message' => 'Laporan belum berhasil disimpan. Periksa koneksi lalu coba lagi.',
            ], 500);
        }

        return response()->json([
            'message' => 'Laporan berhasil disimpan dan menunggu pemeriksaan petugas.',
            'data' => [
                'id' => $report->id,
                'status' => $report->status,
                'created_at' => $report->created_at?->toIso8601String(),
                'status_url' => route('report.status'),
            ],
        ], 201);
    }
}
