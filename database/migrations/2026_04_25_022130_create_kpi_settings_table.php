<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kpi_settings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // A, B, C, D
            $table->string('name'); // Akademik, Prestasi Akademik, etc.
            $table->double('weight')->default(0.25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_settings');
    }
};
