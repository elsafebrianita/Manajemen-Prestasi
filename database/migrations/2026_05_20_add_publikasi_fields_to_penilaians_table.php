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
        Schema::table('penilaians', function (Blueprint $table) {
            // Kolom untuk publikasi berita
            $table->text('berita_publikasi')->nullable()->after('is_published');
            $table->text('admin_catatan')->nullable()->after('berita_publikasi');
            $table->foreignId('admin_published_by')->nullable()->constrained('users')->nullOnDelete()->after('admin_catatan');
            $table->timestamp('admin_published_at')->nullable()->after('admin_published_by');
            $table->enum('status_publikasi', ['pending_admin', 'published', 'draft'])->default('draft')->after('admin_published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropColumn('berita_publikasi');
            $table->dropColumn('admin_catatan');
            $table->dropForeignIdFor(\App\Models\User::class, 'admin_published_by');
            $table->dropColumn('admin_published_by');
            $table->dropColumn('admin_published_at');
            $table->dropColumn('status_publikasi');
        });
    }
};
