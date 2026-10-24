<?php

namespace App\Http\Controllers;

use App\Models\RiskAssessment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class RiskCheckController extends Controller
{
    public function index(): View
    {
        return view('risk-check');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'distance_to_river' => ['nullable', 'numeric', 'min:0'],
            'elevation' => ['nullable', 'numeric'],
            'flood_history' => ['nullable', 'boolean'],
            'landslide_history' => ['nullable', 'boolean'],
            'rainfall_category' => [
                'nullable',
                'in:low,moderate,high,unknown',
            ],
        ]);

        $missingData = [];

        if (!isset($validated['distance_to_river'])) {
            $missingData[] = 'Jarak ke sungai belum tersedia.';
        }

        if (!isset($validated['elevation'])) {
            $missingData[] = 'Data ketinggian belum tersedia.';
        }

        if (!isset($validated['flood_history'])) {
            $missingData[] = 'Riwayat banjir belum tersedia.';
        }

        if (!isset($validated['landslide_history'])) {
            $missingData[] = 'Riwayat longsor belum tersedia.';
        }

        if (
            !isset($validated['rainfall_category']) ||
            $validated['rainfall_category'] === 'unknown'
        ) {
            $missingData[] = 'Kategori curah hujan belum diketahui.';
        }

        $assessment = RiskAssessment::create([
            'user_id' => $request->user()->id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'input_parameters' => $validated,
            'result' => null,
            'limitations' => $missingData,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Pemeriksaan berhasil disimpan.',
            'data' => [
                'id' => $assessment->id,
                'status' => $assessment->status,
                'limitations' => $assessment->limitations,
                'result' => null,
                'note' => 'Skor risiko belum dihitung karena data pendukung terverifikasi belum lengkap.',
            ],
        ], 201);
    }
}
