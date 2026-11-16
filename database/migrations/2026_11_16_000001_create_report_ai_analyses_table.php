<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_ai_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disaster_report_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->string('model_name')->nullable();
            $table->string('model_version')->nullable();
            $table->json('detections')->nullable();
            $table->json('source_evidence_indices')->nullable();
            $table->string('error_code')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('analyzed_at')->nullable();
            $table->string('verification_status')->default('pending');
            $table->text('verification_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_ai_analyses');
    }
};
