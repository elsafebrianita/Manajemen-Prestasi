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
        Schema::table('penilaians', function (Blueprint $col) {
            $col->double('kpi_score')->nullable()->after('c4');
            $col->string('bakat_dominan')->nullable()->after('kpi_score');
            $col->text('insight_kinerja')->nullable()->after('bakat_dominan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $col) {
            $col->dropColumn(['kpi_score', 'bakat_dominan', 'insight_kinerja']);
        });
    }
};
