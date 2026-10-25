<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disaster_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 140);
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamp('occurred_at');
            $table->string('event_type', 40);
            $table->unsignedInteger('injured')->default(0);
            $table->unsignedInteger('deceased')->default(0);
            $table->string('damage_level', 20);
            $table->text('description');
            $table->json('evidence_paths')->nullable();
            $table->string('status', 30)->default('submitted');
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disaster_reports');
    }
};
