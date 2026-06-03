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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->double('c1')->default(0); // Nilai Rapor
            $table->double('c2')->default(0); // Prestasi Akademik
            $table->double('c3')->default(0); // Organisasi
            $table->double('c4')->default(0); // Prestasi Non Akademik
            $table->double('skor_akhir')->nullable();
            $table->integer('ranking')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
