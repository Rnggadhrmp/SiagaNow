<?php

namespace Tests\Feature;

use App\Models\Shelter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MapsShelterTest extends TestCase
{
    use RefreshDatabase;

    public function test_maps_page_and_shelter_search_use_only_valid_database_coordinates(): void
    {
        config(['siaganow.demo_mode' => false]);

        Shelter::create([
            'name' => 'Shelter Terverifikasi',
            'address' => 'Padang',
            'latitude' => -0.9471,
            'longitude' => 100.4172,
            'source' => 'BPBD',
            'verified_at' => now(),
        ]);
        Shelter::create([
            'name' => 'Koordinat Tidak Valid',
            'latitude' => 95,
            'longitude' => 100,
            'verified_at' => now(),
        ]);
        Shelter::create([
            'name' => 'Shelter Belum Diverifikasi',
            'address' => 'Padang',
            'latitude' => -0.948,
            'longitude' => 100.418,
            'source' => 'Sumber belum dikonfirmasi',
        ]);

        $this->get('/maps')
            ->assertOk()
            ->assertSee('Shelter Terverifikasi')
            ->assertDontSee('Koordinat Tidak Valid')
            ->assertDontSee('Shelter Belum Diverifikasi');

        $this->getJson('/api/shelters?q=Padang')
            ->assertOk()
            ->assertJsonPath('data_type', 'database')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Shelter Terverifikasi')
            ->assertJsonMissing(['name' => 'Shelter Belum Diverifikasi']);
    }
}
