<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DemoNewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_news_is_labeled_and_has_illustration_attribution(): void
    {
        config(['siaganow.demo_mode' => true]);

        $this->getJson('/api/news')
            ->assertOk()
            ->assertJsonPath('data_type', 'simulation')
            ->assertJsonPath('source', 'Contoh Data SiagaNow')
            ->assertJsonPath('data.0.image_key', 'flood_jakarta')
            ->assertJsonPath('data.0.image_credit', 'Iqro Rinaldi / Unsplash')
            ->assertJsonPath('data.1.image_key', 'mountain_rain')
            ->assertJsonPath('data.1.is_simulated', true)
            ->assertJsonCount(3, 'data');
    }

    public function test_demo_news_is_not_returned_as_actual_when_demo_mode_is_disabled(): void
    {
        config(['siaganow.demo_mode' => false]);

        $this->getJson('/api/news')
            ->assertOk()
            ->assertJsonPath('data_type', 'unavailable')
            ->assertJsonCount(0, 'data');
    }

    public function test_news_menu_links_to_the_public_news_page(): void
    {
        $this->get('/berita-kebencanaan')
            ->assertOk()
            ->assertSee('Berita Kebencanaan')
            ->assertSee('href="'.route('berita-kebencanaan').'"', false);
    }

    public function test_dashboard_header_can_open_the_public_news_page(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Berita Kebencanaan')
            ->assertSee('href="'.route('berita-kebencanaan').'"', false)
            ->assertSee('dashboard-warning-illustration-soft.png')
            ->assertSee('dashboard-weather-illustration-soft.png')
            ->assertSee('dashboard-soil-illustration-soft.png')
            ->assertSee('dashboard-indonesia-map-soft.png');

        $html = $response->getContent();

        $this->assertSame(1, substr_count($html, 'href="'.route('berita-kebencanaan').'"'));
        $this->assertStringContainsString('<div class="sn-other-panel" id="sn-other-panel" data-sn-other-panel hidden>', $html);
        $this->assertStringContainsString('<div class="sn-other-item is-planned" aria-disabled="true">', $html);
        $this->assertStringContainsString('<span class="dash-stat-mark" aria-hidden="true"><svg viewBox="0 0 24 24"', $html);
        $this->assertStringContainsString('<span class="dash-shelter-mark" aria-hidden="true"><svg viewBox="0 0 24 24"', $html);
        $this->assertStringContainsString('<span class="dash-pin" aria-hidden="true"><svg viewBox="0 0 24 24"', $html);
    }
}
