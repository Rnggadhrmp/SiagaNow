<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->timestamps();
        });

        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_group_id')->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->string('relation', 80)->nullable();
            $table->string('emergency_phone', 32)->nullable();
            $table->timestamps();
            $table->index(['family_group_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
        Schema::dropIfExists('family_groups');
    }
};