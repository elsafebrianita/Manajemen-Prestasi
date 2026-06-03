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
        // 1. Change role column in users table to string to easily support 'walikelas'
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('siswa')->change();
        });

        // 2. Create kelas table
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas')->unique();
            $table->timestamps();
        });

        // 3. Create mapels table
        Schema::create('mapels', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mapel')->unique();
            $table->timestamps();
        });

        // 4. Create guru_mapels table
        Schema::create('guru_mapels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->timestamps();
        });

        // 5. Add kelas_id and walikelas_id to siswas table
        Schema::table('siswas', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            $table->foreignId('walikelas_id')->nullable()->constrained('users')->onDelete('set null');
        });

        // 6. Create nilai_siswas table
        Schema::create('nilai_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_siswas');

        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
            $table->dropForeign(['walikelas_id']);
            $table->dropColumn('walikelas_id');
        });

        Schema::dropIfExists('guru_mapels');
        Schema::dropIfExists('mapels');
        Schema::dropIfExists('kelas');

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru', 'wakasiswa', 'kepsek', 'siswa'])->default('siswa')->change();
        });
    }
};
