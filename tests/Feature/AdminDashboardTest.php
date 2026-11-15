<?php

namespace Tests\Feature;

use App\Models\AdminRole;
use App\Models\NewsArticle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_require_an_authenticated_admin(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));

        $user = User::factory()->create();
        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_super_admin_can_login_and_open_dashboard(): void
    {
        $user = User::factory()->create(['account_status' => 'active']);
        $user->adminRoles()->attach(AdminRole::query()->where('slug', 'super-admin')->value('id'));

        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Pemantauan AI Flood Detection');
    }

    public function test_content_admin_cannot_open_disaster_reports(): void
    {
        $user = User::factory()->create();
        $user->adminRoles()->attach(AdminRole::query()->where('slug', 'content-admin')->value('id'));

        $this->actingAs($user)->get(route('admin.reports.index'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.news.index'))->assertOk();
    }

    public function test_admin_module_pages_render_with_empty_database_state(): void
    {
        config(['siaganow.bmkg_adm4' => 'not-configured']);
        $user = User::factory()->create();
        $user->adminRoles()->attach(AdminRole::query()->where('slug', 'super-admin')->value('id'));

        foreach ([
            'admin.alerts.index', 'admin.alerts.create', 'admin.zones.index', 'admin.zones.create',
            'admin.shelters.index', 'admin.shelters.create', 'admin.reports.index', 'admin.news.index',
            'admin.news.create', 'admin.donations.index', 'admin.donations.create', 'admin.users.index',
            'admin.ai.index', 'admin.roads.index', 'admin.roads.create', 'admin.audit.index', 'admin.weather',
        ] as $routeName) {
            $this->actingAs($user)->get(route($routeName))->assertOk();
        }
    }

    public function test_published_admin_article_is_available_to_public_api_with_simulation_label(): void
    {
        $user = User::factory()->create();
        $user->adminRoles()->attach(AdminRole::query()->where('slug', 'super-admin')->value('id'));

        $this->actingAs($user)->post(route('admin.news.store'), [
            'title' => 'Contoh edukasi kesiapsiagaan',
            'category' => 'Edukasi',
            'summary' => 'Konten demonstrasi.',
            'body' => 'Ini bukan laporan kejadian aktual.',
            'publication_status' => 'published',
            'is_simulation' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('news_articles', [
            'title' => 'Contoh edukasi kesiapsiagaan',
            'publication_status' => 'published',
            'is_simulation' => true,
        ]);

        $this->getJson('/api/news')
            ->assertOk()
            ->assertJsonPath('data.0.is_simulated', true)
            ->assertJsonPath('data.0.source', 'Contoh Data SiagaNow');
    }

    public function test_public_article_image_url_uses_the_current_request_host(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('news/flood.jpg', 'image-bytes');

        NewsArticle::query()->create([
            'title' => 'Banjir historis dengan foto',
            'slug' => 'banjir-historis-dengan-foto',
            'category' => 'Banjir',
            'summary' => 'Ringkasan historis.',
            'body' => 'Laporan historis.',
            'image_path' => 'news/flood.jpg',
            'source_name' => 'BNPB',
            'source_url' => 'https://bnpb.go.id/berita',
            'is_simulation' => false,
            'publication_status' => 'published',
            'published_at' => now(),
        ]);

        $this->getJson('http://192.168.1.25:8000/api/news')
            ->assertOk()
            ->assertJsonPath('data.0.image_url', 'http://192.168.1.25:8000/storage/news/flood.jpg');
    }
}
