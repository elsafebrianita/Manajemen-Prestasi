<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;

// 1. Inspect existing students with non-null walikelas_id
$siswasWithWali = Siswa::whereNotNull('walikelas_id')->get();
echo "Total students with Wali Kelas: " . $siswasWithWali->count() . "\n";

$classWaliMapping = [];
foreach ($siswasWithWali as $s) {
    $waliName = User::find($s->walikelas_id)->name ?? 'Unknown';
    echo "Siswa: {$s->nama} | Kelas: {$s->kelas} (ID: {$s->kelas_id}) | Wali: {$waliName} (ID: {$s->walikelas_id})\n";
    
    if ($s->kelas_id) {
        $classWaliMapping[$s->kelas_id] = $s->walikelas_id;
    }
}

echo "\nClass Wali Kelas Mapping to Apply:\n";
print_r($classWaliMapping);
