<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // Keputusan Kepala Sekolah
            $table->enum('kepsek_status', ['menunggu', 'layak', 'tidak_layak'])->default('menunggu')->after('is_verified');
            $table->text('kepsek_catatan')->nullable()->after('kepsek_status');
            $table->timestamp('kepsek_reviewed_at')->nullable()->after('kepsek_catatan');
            // Status Publikasi (dieksekusi Admin setelah kepsek approve)
            $table->boolean('is_published')->default(false)->after('kepsek_reviewed_at');
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropColumn(['kepsek_status', 'kepsek_catatan', 'kepsek_reviewed_at', 'is_published']);
        });
    }
};
