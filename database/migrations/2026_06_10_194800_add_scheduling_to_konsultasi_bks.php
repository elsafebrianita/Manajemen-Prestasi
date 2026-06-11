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
        Schema::table('konsultasi_bks', function (Blueprint $table) {
            $table->date('tanggal_konsultasi')->nullable()->after('tanggal_pengajuan');
            $table->string('jam_konsultasi')->nullable()->after('tanggal_konsultasi');
            $table->string('ruangan_konsultasi')->nullable()->after('jam_konsultasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasi_bks', function (Blueprint $table) {
            $table->dropColumn(['tanggal_konsultasi', 'jam_konsultasi', 'ruangan_konsultasi']);
        });
    }
};
