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
        Schema::create('bimbingan_bks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jenis_pembinaan'); // akademik, non_akademik, disiplin
            $table->text('catatan');
            $table->string('status')->default('proses'); // proses, selesai
            $table->text('rekomendasi_lomba')->nullable();
            $table->text('rekomendasi_organisasi')->nullable();
            $table->text('rekomendasi_pengembangan')->nullable(); // saran pengembangan bakat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingan_bks');
    }
};
