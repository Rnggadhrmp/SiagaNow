<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hazard_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hazard_type');
            $table->string('severity')->nullable();
            $table->json('area_geojson')->nullable();
            $table->string('source')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hazard_zones');
    }
};