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
            $table->string('status')->default('pending')->after('tahun'); // pending, disetujui, ditolak
            $table->string('sertifikat')->nullable()->after('status');
            $table->text('keterangan')->nullable()->after('sertifikat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn(['status', 'sertifikat', 'keterangan']);
        });
    }
};
