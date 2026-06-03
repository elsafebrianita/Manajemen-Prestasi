<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KpiSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['code' => 'A', 'name' => 'Akademik (Nilai Rapor)', 'weight' => 0.25],
            ['code' => 'B', 'name' => 'Prestasi Akademik', 'weight' => 0.25],
            ['code' => 'C', 'name' => 'Organisasi (Kepemimpinan)', 'weight' => 0.25],
            ['code' => 'D', 'name' => 'Non-akademik (Seni/Olahraga)', 'weight' => 0.25],
        ];

        foreach ($settings as $setting) {
            \App\Models\KpiSetting::updateOrCreate(['code' => $setting['code']], $setting);
        }
    }
}
