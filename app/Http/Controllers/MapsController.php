<?php

namespace App\Http\Controllers;

use App\Models\DisasterEvent;
use App\Models\HazardZone;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\View\View;

class MapsController extends \App\Http\Controllers\Controller
{
    public function index(): View
    {
        $demoMode = (bool) config('siaganow.demo_mode');

        try {
            $shelters = Shelter::query()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->whereBetween('latitude', [-90, 90])
                ->whereBetween('longitude', [-180, 180])
                ->get();
            $hazardZones = HazardZone::query()->get();
            $disasterEvents = DisasterEvent::query()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();
            $databaseAvailable = true;
        } catch (QueryException $exception) {
            report($exception);
            $shelters = collect();
            $hazardZones = collect();
            $disasterEvents = collect();
            $databaseAvailable = false;
        }

        $usingDemoShelters = $demoMode && $shelters->isEmpty();
        if ($usingDemoShelters) {
            $shelters = collect(config('siaganow.demo_shelters'));
        }

        return view('maps', [
            'shelters' => $shelters,
            'hazardZones' => $hazardZones,
            'disasterEvents' => $disasterEvents,
            'demoMode' => $demoMode,
            'usingDemoShelters' => $usingDemoShelters,
            'databaseAvailable' => $databaseAvailable,
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $query = trim((string) ($validated['q'] ?? ''));

        try {
            $shelters = Shelter::query()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->whereBetween('latitude', [-90, 90])
                ->whereBetween('longitude', [-180, 180])
                ->when($query !== '', function ($builder) use ($query) {
                    $builder->where(function ($nested) use ($query) {
                        $nested->where('name', 'like', "%{$query}%")
                            ->orWhere('address', 'like', "%{$query}%");
                    });
                })
                ->limit(20)
                ->get([
                    'id', 'name', 'address', 'latitude', 'longitude',
                    'capacity', 'status', 'source', 'verified_at',
                ]);
            $usingSimulation = false;
        } catch (QueryException $exception) {
            report($exception);
            $shelters = collect();
            $usingSimulation = false;
        }

        if ($shelters->isEmpty() && config('siaganow.demo_mode')) {
            $shelters = collect(config('siaganow.demo_shelters'))
                ->filter(fn (array $shelter) => $query === '' || str_contains(
                    mb_strtolower($shelter['name'].' '.$shelter['address']),
                    mb_strtolower($query),
                ))
                ->values();
            $usingSimulation = $shelters->isNotEmpty();
        }

        return response()->json([
            'data' => $shelters,
            'message' => $shelters->isEmpty()
                ? 'Belum ada shelter yang cocok dengan pencarian.'
                : ($usingSimulation
                    ? 'Contoh lokasi ditemukan. Data ini simulasi, bukan shelter resmi.'
                    : 'Shelter berhasil ditemukan.'),
            'data_type' => $usingSimulation ? 'simulation' : 'database',
            'source' => $usingSimulation ? 'Data Simulasi SiagaNow' : 'Database SiagaNow',
            'demo_mode' => (bool) config('siaganow.demo_mode'),
        ]);
    }
}
