<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\GuruMapel;
use App\Models\Siswa;
use App\Models\NilaiSiswa;

class GuruController extends Controller
{
    // ==========================================
    // GURU MATA PELAJARAN MANAGEMENT
    // ==========================================

    // Show Mapel Saya
    public function guruMapelSaya()
    {
        $user = auth()->user();
        $mapels = GuruMapel::with(['mapel', 'kelas'])->where('guru_id', $user->id)->get();
        return view('guru.mapel', compact('mapels'));
    }

    // Show Kelas Yang Diajar
    public function guruKelasDiajar()
    {
        $user = auth()->user();
        $kelasIds = GuruMapel::where('guru_id', $user->id)->pluck('kelas_id')->unique();
        $kelas = Kelas::whereIn('id', $kelasIds)->get();
        return view('guru.kelas', compact('kelas'));
    }

    // Show List Siswa in taught classes
    public function guruSiswa()
    {
        $user = auth()->user();
        $guruMapels = GuruMapel::with('kelas')->where('guru_id', $user->id)->get();
        
        $kelasNamesNorm = $guruMapels->map(fn($gm) => str_replace(['TKJT', 'TBSM'], ['TKJ', 'TSM'], strtoupper(str_replace(' ', '', $gm->kelas->nama_kelas ?? ''))))->filter()->unique()->toArray();
        $kelasIds = $guruMapels->pluck('kelas_id')->unique()->toArray();
        
        $allSiswas = Siswa::with('kelasRel')->orderBy('nama')->get();
        $siswas = $allSiswas->filter(function($s) use ($kelasIds, $kelasNamesNorm) {
            if (in_array($s->kelas_id, $kelasIds)) return true;
            $sNorm = str_replace(['TKJT', 'TBSM'], ['TKJ', 'TSM'], strtoupper(str_replace(' ', '', $s->kelas)));
            foreach ($kelasNamesNorm as $targetNorm) {
                if (!empty($targetNorm) && ($sNorm === $targetNorm || str_starts_with($sNorm, $targetNorm))) {
                    return true;
                }
            }
            return false;
        })->values();

        return view('guru.siswa', compact('siswas'));
    }

    // Input Nilai view
    public function guruInputNilai()
    {
        $user = auth()->user();
        $guruMapels = GuruMapel::with(['mapel', 'kelas'])->where('guru_id', $user->id)->get();
        
        $kelasNamesNorm = $guruMapels->map(fn($gm) => str_replace(['TKJT', 'TBSM'], ['TKJ', 'TSM'], strtoupper(str_replace(' ', '', $gm->kelas->nama_kelas ?? ''))))->filter()->unique()->toArray();
        $kelasIds = $guruMapels->pluck('kelas_id')->unique()->toArray();
        
        $allSiswas = Siswa::orderBy('nama')->get();
        $siswas = $allSiswas->filter(function($s) use ($kelasIds, $kelasNamesNorm) {
            if (in_array($s->kelas_id, $kelasIds)) return true;
            $sNorm = str_replace(['TKJT', 'TBSM'], ['TKJ', 'TSM'], strtoupper(str_replace(' ', '', $s->kelas)));
            foreach ($kelasNamesNorm as $targetNorm) {
                if (!empty($targetNorm) && ($sNorm === $targetNorm || str_starts_with($sNorm, $targetNorm))) {
                    return true;
                }
            }
            return false;
        })->values();

        // Get already stored grades
        $nilaiSiswas = NilaiSiswa::where('guru_id', $user->id)->get()->keyBy(function($item) {
            return $item->siswa_id . '-' . $item->mapel_id;
        });

        return view('guru.nilai', compact('guruMapels', 'siswas', 'nilaiSiswas'));
    }

    // Store student grades
    public function guruStoreNilai(Request $request)
    {
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:users,id',
        ]);

        $mapel_id = $request->mapel_id;
        $guru_id = $request->guru_id;

        foreach ($request->nilai as $siswa_id => $nilaiVal) {
            if ($nilaiVal !== null && $nilaiVal !== '') {
                NilaiSiswa::updateOrCreate(
                    [
                        'siswa_id' => $siswa_id,
                        'guru_id' => $guru_id,
                        'mapel_id' => $mapel_id
                    ],
                    ['nilai' => $nilaiVal]
                );
                
                // Auto-recalculate KPI for the student since their academic score changed
                \App\Models\Penilaian::kalkulasiKpiSiswa($siswa_id);
            }
        }

        return back()->with('success', 'Nilai Siswa berhasil disimpan!');
    }
}
