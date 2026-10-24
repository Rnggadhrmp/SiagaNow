<?php

namespace app\Http\Controllers;

use App\Models\DisasterEvent;
use App\Models\HazardZone;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MapsController extends \App\Http\Controllers\Controller
{
    public function index(): View
    {
        return view('maps', [
            'shelters' => Shelter::query()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(),

            'hazardZones' => HazardZone::query()->get(),

            'disasterEvents' => DisasterEvent::query()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'max:100'],
        ]);

        $query = trim($validated['q']);

        $shelters = Shelter::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where(function ($builder) use ($query) {
                $builder->where('name', 'like', "%{$query}%")
                    ->orWhere('address', 'like', "%{$query}%");
            })
            ->limit(20)
            ->get([
                'id',
                'name',
                'address',
                'latitude',
                'longitude',
                'capacity',
                'status',
            ]);

        return response()->json([
            'data' => $shelters,
            'message' => $shelters->isEmpty()
                ? 'Belum ada shelter yang cocok dengan pencarian.'
                : 'Shelter berhasil ditemukan.',
        ]);
    }
}
