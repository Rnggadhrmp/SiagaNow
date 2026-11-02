<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('family_members', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('check_in_at')->nullable();
            $table->string('last_check_in_request_id', 100)->nullable();
            $table->boolean('reminder_enabled')->default(false);
            $table->unsignedSmallInteger('reminder_frequency_hours')->default(24);
            $table->string('reminder_timezone', 64)->default('UTC');
            $table->timestamp('next_reminder_at')->nullable();
            $table->string('invite_code_hash', 64)->nullable()->unique();
            $table->timestamp('invite_expires_at')->nullable();
            $table->index(['user_id', 'family_group_id']);
        });
    }

    public function down(): void
    {
        Schema::table('family_members', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'family_group_id']);
            $table->dropUnique(['invite_code_hash']);
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn([
                'notes',
                'check_in_at',
                'last_check_in_request_id',
                'reminder_enabled',
                'reminder_frequency_hours',
                'reminder_timezone',
                'next_reminder_at',
                'invite_code_hash',
                'invite_expires_at',
            ]);
        });
    }
};
