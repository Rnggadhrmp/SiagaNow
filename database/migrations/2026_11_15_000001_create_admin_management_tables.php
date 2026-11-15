<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'account_status')) {
                $table->string('account_status', 20)->default('active');
            }
        });

        Schema::table('shelters', function (Blueprint $table) {
            if (!Schema::hasColumn('shelters', 'source_url')) $table->text('source_url')->nullable();
            if (!Schema::hasColumn('shelters', 'verified_by')) $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
        });
        Schema::table('hazard_zones', function (Blueprint $table) {
            if (!Schema::hasColumn('hazard_zones', 'source_url')) $table->text('source_url')->nullable();
            if (!Schema::hasColumn('hazard_zones', 'verified_by')) $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 60)->unique();
            $table->json('permissions');
            $table->timestamps();
        });

        Schema::create('admin_user_roles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_role_id')->constrained('admin_roles')->cascadeOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->primary(['user_id', 'admin_role_id']);
        });

        Schema::create('admin_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 80);
            $table->string('subject_type', 100)->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('summary', 255);
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['subject_type', 'subject_id']);
            $table->index(['actor_user_id', 'created_at']);
        });

        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->string('category', 60)->default('edukasi');
            $table->text('summary');
            $table->longText('body');
            $table->string('image_path')->nullable();
            $table->string('image_alt', 180)->nullable();
            $table->string('source_name', 120)->nullable();
            $table->text('source_url')->nullable();
            $table->boolean('is_simulation')->default(false);
            $table->string('publication_status', 20)->default('draft');
            $table->foreignId('author_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['publication_status', 'published_at']);
        });

        Schema::create('admin_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->string('hazard_type', 40);
            $table->string('risk_level', 20);
            $table->text('affected_area');
            $table->longText('description');
            $table->json('area_geojson')->nullable();
            $table->string('source_name', 120);
            $table->text('source_url');
            $table->boolean('is_simulation')->default(false);
            $table->string('status', 20)->default('draft');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('author_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'verified_at', 'expires_at']);
        });

        Schema::create('donation_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->text('description');
            $table->string('organizer', 180);
            $table->unsignedBigInteger('target_amount');
            $table->string('source_name', 120)->nullable();
            $table->text('source_url')->nullable();
            $table->boolean('is_simulation')->default(false);
            $table->string('status', 20)->default('draft');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('author_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'verified_at', 'ends_at']);
        });

        Schema::create('ai_camera_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160);
            $table->string('location', 255);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('ai_detections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camera_source_id')->nullable()->constrained('ai_camera_sources')->nullOnDelete();
            $table->string('external_reference', 180)->nullable()->unique();
            $table->string('risk_status', 20)->default('unknown');
            $table->decimal('confidence', 5, 4)->nullable();
            $table->timestamp('observed_at')->nullable();
            $table->string('source_name', 120)->nullable();
            $table->string('verification_status', 20)->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->index(['risk_status', 'observed_at']);
            $table->index(['verification_status', 'observed_at']);
        });

        Schema::create('affected_roads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->text('area_description');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->json('route_geojson')->nullable();
            $table->string('impact_level', 20)->default('unknown');
            $table->string('status', 20)->default('draft');
            $table->string('source_name', 120);
            $table->text('source_url');
            $table->boolean('is_simulation')->default(false);
            $table->timestamp('observed_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('author_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'verified_at', 'observed_at']);
        });

        DB::table('admin_roles')->insertOrIgnore([
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'permissions' => json_encode(['*']), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Petugas Kebencanaan', 'slug' => 'disaster-officer', 'permissions' => json_encode(['dashboard.view', 'alerts.manage', 'shelters.manage', 'zones.manage', 'reports.manage', 'ai.manage', 'roads.manage']), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Admin Konten dan Donasi', 'slug' => 'content-admin', 'permissions' => json_encode(['dashboard.view', 'news.manage', 'donations.manage']), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('affected_roads');
        Schema::dropIfExists('ai_detections');
        Schema::dropIfExists('ai_camera_sources');
        Schema::dropIfExists('donation_campaigns');
        Schema::dropIfExists('admin_alerts');
        Schema::dropIfExists('news_articles');
        Schema::dropIfExists('admin_audit_logs');
        Schema::dropIfExists('admin_user_roles');
        Schema::dropIfExists('admin_roles');

        Schema::table('hazard_zones', function (Blueprint $table) {
            if (Schema::hasColumn('hazard_zones', 'verified_by')) $table->dropConstrainedForeignId('verified_by');
            if (Schema::hasColumn('hazard_zones', 'source_url')) $table->dropColumn('source_url');
        });
        Schema::table('shelters', function (Blueprint $table) {
            if (Schema::hasColumn('shelters', 'verified_by')) $table->dropConstrainedForeignId('verified_by');
            if (Schema::hasColumn('shelters', 'source_url')) $table->dropColumn('source_url');
        });

        if (Schema::hasColumn('users', 'account_status')) {
            Schema::table('users', fn (Blueprint $table) => $table->dropColumn('account_status'));
        }
    }
};
