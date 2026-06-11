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
        Schema::create('konsultasi_bks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal_pengajuan');
            $table->string('tipe_konsultasi'); // akademik, non_akademik, disiplin, karir, lainnya
            $table->text('keluhan');
            $table->string('status')->default('pending'); // pending, diproses, selesai
            $table->foreignId('bimbingan_bk_id')->nullable()->constrained('bimbingan_bks')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi_bks');
    }
};
