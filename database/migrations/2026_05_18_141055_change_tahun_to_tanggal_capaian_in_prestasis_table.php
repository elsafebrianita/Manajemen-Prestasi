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
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn('tahun');
            $table->date('tanggal_capaian')->nullable()->after('juara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn('tanggal_capaian');
            $table->integer('tahun')->nullable()->after('juara');
        });
    }
};
