<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\KpiSetting;

class WaliKelasController extends Controller
{
    // ==========================================
    // WALI KELAS MANAGEMENT
    // ==========================================

    // Show Wali Kelas Class Students
    public function walikelasSiswa()
    {
        $user = auth()->user();
        $siswas = Siswa::with(['kelasRel', 'penilaian'])->where('walikelas_id', $user->id)->get();

        if ($siswas->isEmpty()) {
            $mapels = collect();
            $nilaiSiswas = collect();
            $namaKelas = 'Tidak Ada Kelas';
            return view('walikelas.siswa.index', compact('siswas', 'mapels', 'nilaiSiswas', 'namaKelas'));
        }

        $kelasId = $siswas->first()->kelas_id;
        $namaKelas = $siswas->first()->kelasRel->nama_kelas ?? $siswas->first()->kelas;
        $mapels = $this->getClassMapels($kelasId, $siswas->first()->kelas);

        $siswaIds = $siswas->pluck('id')->toArray();
        $nilaiSiswas = \App\Models\NilaiSiswa::whereIn('siswa_id', $siswaIds)->get()->groupBy('siswa_id');

        return view('walikelas.siswa.index', compact('siswas', 'mapels', 'nilaiSiswas', 'namaKelas'));
    }

    // Show Wali Kelas Analisis KPI/SPI Rankings
    public function walikelasKpi()
    {
        $user = auth()->user();
        $siswas = Siswa::with(['kelasRel', 'penilaian'])->where('walikelas_id', $user->id)->get();

        foreach ($siswas as $s) {
            $s->live_indicators = \App\Models\Penilaian::getKpiIndicators($s->id);
        }

        $weights = KpiSetting::all()->pluck('weight', 'code');
        $wA = $weights['A'] ?? 0.25;
        $wB = $weights['B'] ?? 0.25;
        $wC = $weights['C'] ?? 0.25;
        $wD = $weights['D'] ?? 0.25;

        return view('walikelas.kpi', compact('siswas', 'wA', 'wB', 'wC', 'wD'));
    }

    // Process KPI / SAW Calculation for Wali Kelas Class
    public function walikelasKalkulasiKpi()
    {
        $user = auth()->user();
        $siswas = Siswa::where('walikelas_id', $user->id)->get();

        if ($siswas->isEmpty()) {
            return back()->with('error', 'Tidak ada data siswa di kelas Anda untuk diproses.');
        }

        foreach ($siswas as $s) {
            Penilaian::kalkulasiKpiSiswa($s->id);
        }

        return back()->with('success', 'Kalkulasi KPI Siswa Kelas Anda berhasil diproses!');
    }

    // Toggle recommendation status of student for publication
    public function walikelasRekomendasiKpi(Request $request, $id)
    {
        $user = auth()->user();
        $penilaian = Penilaian::whereHas('siswa', function($query) use ($user) {
            $query->where('walikelas_id', $user->id);
        })->findOrFail($id);

        $penilaian->is_recommended = !$penilaian->is_recommended;
        $penilaian->save();

        $statusText = $penilaian->is_recommended ? 'direkomendasikan untuk publikasi' : 'batal direkomendasikan';
        return back()->with('success', "Siswa {$penilaian->siswa->nama} berhasil {$statusText}!");
    }

    // Show Wali Kelas Evaluasi / Hasil Bakat
    public function walikelasEvaluasi()
    {
        $user = auth()->user();
        $siswas = Siswa::where('walikelas_id', $user->id)->pluck('id')->toArray();
        $hasilBakat = Penilaian::with('siswa')->whereIn('siswa_id', $siswas)->orderBy('ranking', 'asc')->get();
        return view('walikelas.evaluasi', compact('hasilBakat'));
    }

    // Show Wali Kelas Grafik Prestasi
    public function walikelasGrafik()
    {
        $user = auth()->user();
        $siswas = Siswa::where('walikelas_id', $user->id)->pluck('id')->toArray();
        $penilaians = Penilaian::with('siswa')->whereIn('siswa_id', $siswas)->get();
        return view('walikelas.grafik', compact('penilaians'));
    }

    // Show Wali Kelas Rapor Finalisasi Halaman
    public function walikelasRapor()
    {
        $user = auth()->user();
        $siswas = Siswa::with(['kelasRel', 'penilaian'])->where('walikelas_id', $user->id)->get();

        if ($siswas->isEmpty()) {
            $mapels = collect();
            $nilaiSiswas = collect();
            $namaKelas = 'Tidak Ada Kelas';
            return view('walikelas.rapor.index', compact('siswas', 'mapels', 'nilaiSiswas', 'namaKelas'));
        }

        $kelasId = $siswas->first()->kelas_id;
        $namaKelas = $siswas->first()->kelasRel->nama_kelas ?? $siswas->first()->kelas;

        // Fetch subjects associated with this class using normalized class matching
        $mapels = $this->getClassMapels($kelasId, $namaKelas);

        $siswaIds = $siswas->pluck('id')->toArray();
        $nilaiSiswas = \App\Models\NilaiSiswa::whereIn('siswa_id', $siswaIds)->get()->groupBy('siswa_id');

        return view('walikelas.rapor.index', compact('siswas', 'mapels', 'nilaiSiswas', 'namaKelas'));
    }

    // Finalize report card grades
    public function walikelasFinalisasiRapor(Request $request)
    {
        $user = auth()->user();
        $siswas = Siswa::where('walikelas_id', $user->id)->get();

        if ($siswas->isEmpty()) {
            return back()->with('error', 'Tidak ada data siswa untuk difinalisasi.');
        }

        $siswaIds = $siswas->pluck('id')->toArray();

        // Calculate C1 (Akademik Rata-rata) automatically from subjects grades
        $nilaiRataRata = \App\Models\NilaiSiswa::whereIn('siswa_id', $siswaIds)
            ->groupBy('siswa_id')
            ->selectRaw('siswa_id, AVG(nilai) as rata_rata')
            ->pluck('rata_rata', 'siswa_id');

        foreach ($siswas as $s) {
            $c1Val = $nilaiRataRata[$s->id] ?? 70; // Fallback to 70

            // Check if there is an existing Penilaian to maintain other criteria, or create new
            \App\Models\Penilaian::updateOrCreate(
                ['siswa_id' => $s->id],
                [
                    'c1' => $c1Val,
                    'is_verified' => true,
                    'is_published' => true
                ]
            );
        }

        return back()->with('success', 'Seluruh Rapor Kelas berhasil difinalisasi dan diterbitkan ke Siswa!');
    }

    // Show class grades average
    public function walikelasRataNilai()
    {
        $user = auth()->user();
        $siswas = Siswa::where('walikelas_id', $user->id)->get();

        if ($siswas->isEmpty()) {
            $mapels = collect();
            $subjectAverages = [];
            $namaKelas = 'Tidak Ada Kelas';
            return view('walikelas.rapor.rata_nilai', compact('mapels', 'subjectAverages', 'namaKelas'));
        }

        $kelasId = $siswas->first()->kelas_id;
        $namaKelas = $siswas->first()->kelasRel->nama_kelas ?? $siswas->first()->kelas;

        $mapels = $this->getClassMapels($kelasId, $namaKelas);

        $siswaIds = $siswas->pluck('id')->toArray();
        
        $subjectAverages = [];
        foreach ($mapels as $m) {
            $avg = \App\Models\NilaiSiswa::whereIn('siswa_id', $siswaIds)->where('mapel_id', $m->id)->avg('nilai');
            $subjectAverages[$m->id] = $avg ?? 0;
        }

        return view('walikelas.rapor.rata_nilai', compact('mapels', 'subjectAverages', 'namaKelas'));
    }

    // Show achievements of students in the class
    public function walikelasPrestasiSiswa()
    {
        $user = auth()->user();
        $siswas = Siswa::where('walikelas_id', $user->id)->get();

        if ($siswas->isEmpty()) {
            $prestasis = collect();
            return view('walikelas.siswa.prestasi', compact('prestasis'));
        }

        $siswaIds = $siswas->pluck('id')->toArray();
        $prestasis = \App\Models\Prestasi::whereIn('siswa_id', $siswaIds)->with(['siswa', 'kategori'])->latest()->get();

        return view('walikelas.siswa.prestasi', compact('prestasis'));
    }

    // Show official report card of a specific student for Wali Kelas
    public function walikelasSiswaRapor($siswa_id)
    {
        $user = auth()->user();
        $siswa = Siswa::with('kelasRel')->where('walikelas_id', $user->id)->findOrFail($siswa_id);
        
        $penilaian = Penilaian::where('siswa_id', $siswa->id)->first();

        // Get class subjects with normalized matching
        $kelasId = $siswa->kelas_id;
        $mapels = $this->getClassMapels($kelasId, $siswa->kelas);

        // Get student grades
        $nilaiSiswas = \App\Models\NilaiSiswa::with('guru')->where('siswa_id', $siswa->id)->get()->keyBy('mapel_id');

        return view('walikelas.siswa.rapor_detail', compact('siswa', 'penilaian', 'mapels', 'nilaiSiswas'));
    }

    public function walikelasEditNilai($siswa_id)
    {
        $user = auth()->user();
        $siswa = Siswa::with('kelasRel')->where('walikelas_id', $user->id)->findOrFail($siswa_id);

        $kelasId = $siswa->kelas_id;
        $mapels = $this->getClassMapels($kelasId, $siswa->kelas);
        $nilaiSiswas = \App\Models\NilaiSiswa::with('guru')->where('siswa_id', $siswa->id)->get()->keyBy('mapel_id');

        return view('walikelas.siswa.edit_nilai', compact('siswa', 'mapels', 'nilaiSiswas'));
    }

    public function walikelasUpdateNilai(Request $request, $siswa_id)
    {
        $user = auth()->user();
        $siswa = Siswa::where('walikelas_id', $user->id)->findOrFail($siswa_id);

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->nilai as $mapel_id => $nilaiVal) {
            $existing = \App\Models\NilaiSiswa::where('siswa_id', $siswa->id)
                ->where('mapel_id', $mapel_id)
                ->first();

            if ($nilaiVal === null || $nilaiVal === '') {
                if ($existing) {
                    $existing->delete();
                }
                continue;
            }

            \App\Models\NilaiSiswa::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'mapel_id' => $mapel_id,
                ],
                [
                    'nilai' => $nilaiVal,
                    'guru_id' => $existing->guru_id ?? $user->id,
                ]
            );
        }

        return redirect('/walikelas/siswa')->with('success', 'Nilai siswa berhasil diperbarui.');
    }

    public function walikelasDeleteNilai(Request $request, $siswa_id)
    {
        $user = auth()->user();
        $siswa = Siswa::where('walikelas_id', $user->id)->findOrFail($siswa_id);

        \App\Models\NilaiSiswa::where('siswa_id', $siswa->id)->delete();
        Penilaian::where('siswa_id', $siswa->id)->update([
            'is_verified' => false,
            'is_published' => false,
        ]);

        return redirect('/walikelas/siswa')->with('success', 'Semua nilai siswa berhasil dihapus.');
    }

    // Helper to get mapels using normalized class name matching
    private function getClassMapels($kelasId, $kelasName = null)
    {
        $kelas = null;
        if ($kelasId) {
            $kelas = \App\Models\Kelas::find($kelasId);
        }
        
        $kelasName = $kelasName ?? ($kelas->nama_kelas ?? null);
        $classMapelIds = [];
        
        if ($kelasName) {
            $kelasNorm = str_replace(['TKJT', 'TBSM'], ['TKJ', 'TSM'], strtoupper(str_replace(' ', '', $kelasName)));
            $allGms = \App\Models\GuruMapel::with('kelas')->get();
            foreach ($allGms as $gm) {
                if (!$gm->kelas) continue;
                $gmNorm = str_replace(['TKJT', 'TBSM'], ['TKJ', 'TSM'], strtoupper(str_replace(' ', '', $gm->kelas->nama_kelas)));
                if ($gmNorm === $kelasNorm || str_starts_with($kelasNorm, $gmNorm) || str_starts_with($gmNorm, $kelasNorm)) {
                    $classMapelIds[] = $gm->mapel_id;
                }
            }
            $classMapelIds = array_unique($classMapelIds);
        }
        
        if (empty($classMapelIds) && $kelasId) {
            $classMapelIds = \App\Models\GuruMapel::where('kelas_id', $kelasId)->pluck('mapel_id')->unique()->toArray();
        }
        
        return \App\Models\Mapel::whereIn('id', $classMapelIds)->orderBy('nama_mapel')->get();
    }
}
