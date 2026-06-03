<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Siswa;

class LaporanController extends Controller
{
    public function index()
    {
        $data = Penilaian::with('siswa')
            ->whereNotNull('kpi_score')
            ->orderBy('ranking', 'asc')
            ->get();



        $rekap = [];
        foreach ($data as $p) {
            $rekap[] = [
                'rank' => $p->ranking,
                'nama' => $p->siswa->nama ?? 'Siswa Terhapus',
                'nis' => $p->siswa->nis ?? '-',
                'skor' => $p->kpi_score,
                'bakat' => $p->bakat_dominan
            ];
        }

        return view('laporan.index', compact('rekap'));
    }
}
