<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Penilaian;

$penilaians = Penilaian::with('siswa')->get();
echo "=== PROPOSED TO KEPSEK (is_proposed = 1) ===\n";
foreach ($penilaians->where('is_proposed', true) as $p) {
    echo "Siswa: {$p->siswa->nama} | Verified: {$p->is_verified} | Proposed: {$p->is_proposed} | Kepsek Status: {$p->kepsek_status} | Published: {$p->is_published}\n";
}
