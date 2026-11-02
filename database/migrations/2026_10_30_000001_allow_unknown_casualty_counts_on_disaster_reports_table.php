<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disaster_reports', function (Blueprint $table) {
            $table->unsignedInteger('injured')->nullable()->default(null)->change();
            $table->unsignedInteger('deceased')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        if (DB::table('disaster_reports')->whereNull('injured')->orWhereNull('deceased')->exists()) {
            throw new \RuntimeException('Cannot roll back casualty nullability while unknown counts exist; preserve those reports.');
        }

        Schema::table('disaster_reports', function (Blueprint $table) {
            $table->unsignedInteger('injured')->default(0)->nullable(false)->change();
            $table->unsignedInteger('deceased')->default(0)->nullable(false)->change();
        });
    }
};
