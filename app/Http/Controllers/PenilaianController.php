<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Penilaian;
use App\Models\Prestasi;
use App\Models\KpiSetting;
use App\Models\Notification;

class PenilaianController extends Controller
{
    public function index()
    {
        // Ambil semua siswa dengan data penilaiannya
        $siswas = Siswa::with('penilaian')->get();
        return view('walikelas.penilaian.index', compact('siswas'));
    }

    public function rapor()
    {
        $user = auth()->user();
        if ($user->role !== 'siswa') {
            return redirect('/dashboard')->with('error', 'Hanya siswa yang dapat mengakses halaman Nilai Rapor.');
        }

        $siswa = Siswa::with('kelasRel')->where('nis', $user->username)->first();
        if (! $siswa) {
            return redirect('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $penilaian = Penilaian::where('siswa_id', $siswa->id)->first();

        // Get class subjects with normalized matching
        $kelasId = $siswa->kelas_id;
        $kelasName = $siswa->kelas;
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
        $mapels = \App\Models\Mapel::whereIn('id', $classMapelIds)->orderBy('nama_mapel')->get();

        // Get student grades
        $nilaiSiswas = \App\Models\NilaiSiswa::with('guru')->where('siswa_id', $siswa->id)->get()->keyBy('mapel_id');

        return view('siswa.rapor', compact('siswa', 'penilaian', 'mapels', 'nilaiSiswas'));
    }

    public function create($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $computed = Penilaian::getKpiIndicators($siswa_id);

        $prestasi_akademik = Prestasi::where('siswa_id', $siswa_id)
            ->where('status', 'disetujui')
            ->whereHas('kategori', function($q) {
                $q->where('id', 2)->orWhere('parent_id', 2);
            })->get();

        $prestasi_non = Prestasi::where('siswa_id', $siswa_id)
            ->where('status', 'disetujui')
            ->whereHas('kategori', function($q) {
                $q->where('id', 4)->orWhere('parent_id', 4);
            })->get();

        $prestasi_organisasi = Prestasi::where('siswa_id', $siswa_id)
            ->where('status', 'disetujui')
            ->whereHas('kategori', function($q) {
                $q->where('id', 3)->orWhere('parent_id', 3);
            })->get();

        return view('walikelas.penilaian.create', compact(
            'siswa', 'prestasi_akademik', 'prestasi_non', 'prestasi_organisasi', 'computed'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
        ]);

        Penilaian::kalkulasiKpiSiswa($request->siswa_id);

        return redirect('/penilaian')->with('success', 'Penilaian KPI siswa berhasil dihitung dan disimpan secara otomatis!');
    }

    public function prosesKpi()
    {
        $penilaians = Penilaian::all();

        if ($penilaians->isEmpty()) {
            return redirect('/penilaian')->with('error', 'Belum ada data penilaian untuk diproses.');
        }

        // Ambil Bobot dari Database
        $weights = KpiSetting::all()->pluck('weight', 'code');
        $wA = $weights['A'] ?? 0.25;
        $wB = $weights['B'] ?? 0.25;
        $wC = $weights['C'] ?? 0.25;
        $wD = $weights['D'] ?? 0.25;

        // Target KPI (Normalisasi)
        $targetA = 100; // Akademik
        $targetB = 100; // Prestasi Akademik
        $targetC = 100; // Organisasi
        $targetD = 100; // Non-Akademik

        $hasilRaw = [];

        foreach ($penilaians as $p) {
            $nA = min($p->c1 / $targetA, 1);
            $nB = min($p->c2 / $targetB, 1);
            $nC = min($p->c3 / $targetC, 1);
            $nD = min($p->c4 / $targetD, 1);

            // Perhitungan KPI Sesuai Formula Dosen: (A*Wa) + (B*Wb) + (C*Wc) + (D*Wd)
            $totalSkor = ($nA * $wA) + ($nB * $wB) + ($nC * $wC) + ($nD * $wD);
            
            // Kategori
            $kategori = 'Kurang';
            if($totalSkor >= 0.8) $kategori = 'Sangat Baik';
            elseif($totalSkor >= 0.6) $kategori = 'Baik';
            elseif($totalSkor >= 0.4) $kategori = 'Cukup';

            // Dominasi Bakat (Mapping ke Kode A, B, C, D)
            $scores = ['A' => $nA, 'B' => $nB, 'C' => $nC, 'D' => $nD];
            $maxScore = max($scores);
            $dominantKey = array_keys($scores, $maxScore)[0];
            $bakat = match($dominantKey) {
                'A' => 'Akademik Umum',
                'B' => 'Prestasi Akademik',
                'C' => 'Organisasi / Kepemimpinan',
                'D' => 'Seni / Olahraga (Non-Akademik)',
            };

            $hasilRaw[] = [
                'id' => $p->id,
                'skor' => $totalSkor,
                'bakat' => $bakat,
                'kategori' => $kategori
            ];
        }

        usort($hasilRaw, function($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        foreach ($hasilRaw as $rank => $data) {
            Penilaian::where('id', $data['id'])->update([
                'skor_akhir' => $data['skor'],
                'kpi_score' => $data['skor'] * 100,
                'bakat_dominan' => $data['bakat'],
                'insight_kinerja' => "Kinerja siswa berkategori " . $data['kategori'] . ".",
                'ranking' => $rank + 1
            ]);
        }

        return redirect('/kpi')->with('success', 'Perhitungan KPI Berhasil Diproses!');
    }

    public function perhitungan()
    {
        $penilaians = Penilaian::with('siswa')->get();

        if ($penilaians->isEmpty()) {
            return redirect('/penilaian')->with('error', 'Belum ada data penilaian untuk dihitung.');
        }

        $weights = KpiSetting::all()->pluck('weight', 'code');
        $wA = $weights['A'] ?? 0.25;
        $wB = $weights['B'] ?? 0.25;
        $wC = $weights['C'] ?? 0.25;
        $wD = $weights['D'] ?? 0.25;

        $targetA = 100; $targetB = 100; $targetC = 100; $targetD = 100;

        $dataKpi = [];
        foreach ($penilaians as $p) {
            $nA = min($p->c1 / $targetA, 1);
            $nB = min($p->c2 / $targetB, 1);
            $nC = min($p->c3 / $targetC, 1);
            $nD = min($p->c4 / $targetD, 1);

            $totalSkor = ($nA * $wA) + ($nB * $wB) + ($nC * $wC) + ($nD * $wD);

            $dataKpi[] = [
                'nama' => $p->siswa->nama,
                'nA' => $nA, 'nB' => $nB, 'nC' => $nC, 'nD' => $nD,
                'total' => $totalSkor,
                'p' => $p
            ];
        }

        usort($dataKpi, function($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        return view('walikelas.penilaian.perhitungan', compact(
            'penilaians', 'targetA', 'targetB', 'targetC', 'targetD', 
            'dataKpi', 'wA', 'wB', 'wC', 'wD'
        ));
    }

    public function hasilBakat(Request $request)
    {
        $user = auth()->user();
        $query = Penilaian::with('siswa')->whereNotNull('kpi_score');
        $isSingle = false;

        // Jika Siswa, filter hanya milik dia sendiri
        if ($user->role == 'siswa') {
            $siswa = \App\Models\Siswa::where('nis', $user->username)->first();
            if (!$siswa) {
                return redirect('/dashboard')->with('error', 'Data profil siswa tidak ditemukan.');
            }
            $query->where('siswa_id', $siswa->id);
            $isSingle = true;
        } else {
            // Jika Admin/Guru, cek apakah sedang melihat detail 1 siswa
            if ($request->has('siswa_id')) {
                $query->where('siswa_id', $request->siswa_id);
                $isSingle = true;
            }
        }

        $penilaians = $query->orderBy('ranking', 'asc')->get();

        $hasilBakat = [];

        foreach ($penilaians as $p) {
            // Tentukan icon kriteria berdasarkan teks bakat_dominan
            $kriteria = 'GI';
            if(str_contains($p->bakat_dominan, 'Spesifik')) $kriteria = 'SA';
            if(str_contains($p->bakat_dominan, 'Kepemimpinan')) $kriteria = 'GS';
            if(str_contains($p->bakat_dominan, 'Seni')) $kriteria = 'GA';

            $hasilBakat[] = [
                'siswa' => $p->siswa,
                'penilaian' => $p,
                'bakat' => $p->bakat_dominan,
                'kriteria' => $kriteria,
                'deskripsi' => $p->insight_kinerja,
                'alasan' => 'Berdasarkan analisis instrumen evaluasi kinerja siswa (KPI) dengan skor capaian tertinggi pada indikator terkait.'
            ];
        }

        return view('walikelas.penilaian.bakat', compact('hasilBakat', 'isSingle'));
    }

    public function destroy($id)
    {
        Penilaian::destroy($id);
        return redirect('/penilaian')->with('success', 'Data penilaian berhasil dihapus.');
    }

    public function acc($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->update(['is_verified' => true]);

        return redirect('/dashboard')->with('success', 'Penilaian berhasil di-ACC oleh Pimpinan!');
    }

    public function show($id)
    {
        $siswa = Siswa::with(['penilaian', 'prestasis.kategori', 'notifications.sender'])->findOrFail($id);
        
        // Data Pendukung
        $prestasi_akademik = Prestasi::where('siswa_id', $id)->where('status', 'disetujui')
            ->whereHas('kategori', function($q){ $q->where('id', 2)->orWhere('parent_id', 2); })->get();
        $prestasi_non = Prestasi::where('siswa_id', $id)->where('status', 'disetujui')
            ->whereHas('kategori', function($q){ $q->where('id', 4)->orWhere('parent_id', 4); })->get();

        return view('walikelas.penilaian.show', compact('siswa', 'prestasi_akademik', 'prestasi_non'));
    }

    public function settings()
    {
        if (auth()->user()->akses_role != 'admin') {
            return redirect('/dashboard')->with('error', 'Hanya Admin yang dapat mengelola bobot KPI.');
        }

        $settings = KpiSetting::all();
        return view('admin.penilaian.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        if (auth()->user()->akses_role != 'admin') {
            return redirect('/dashboard')->with('error', 'Hanya Admin yang dapat mengelola bobot KPI.');
        }

        $request->validate([
            'weights' => 'required|array',
            'weights.*' => 'required|numeric|min:0|max:1',
        ]);

        $totalWeight = array_sum($request->weights);
        if (abs($totalWeight - 1.0) > 0.0001) {
            return redirect()->back()->with('error', 'Total bobot harus sama dengan 1.0 (Sekarang: ' . $totalWeight . ')');
        }

        foreach ($request->weights as $code => $weight) {
            KpiSetting::where('code', $code)->update(['weight' => $weight]);
        }

        return redirect()->back()->with('success', 'Bobot KPI berhasil diperbarui!');
    }

    public function storeNotification(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'type' => 'required|string',
            'message' => 'required|string',
        ]);

        Notification::create([
            'siswa_id' => $request->siswa_id,
            'from_user_id' => auth()->id(),
            'type' => $request->type,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Notifikasi berhasil dikirim ke siswa!');
    }

    public function siswaStore(Request $request)
    {
        $siswa = Siswa::where('nis', auth()->user()->username)->first();
        if (!$siswa) return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');

        $request->validate([
            'organization_role' => 'required|in:anggota,bendahara,sekretaris,wakil_ketua,ketua',
        ]);

        $roleScores = [
            'anggota' => 75,
            'bendahara' => 88,
            'sekretaris' => 85,
            'wakil_ketua' => 90,
            'ketua' => 95,
        ];

        $score = $roleScores[$request->organization_role] ?? 75;

        Penilaian::updateOrCreate(
            ['siswa_id' => $siswa->id],
            [
                'c3' => $score,
                'is_verified' => false,
            ]
        );

        Penilaian::kalkulasiKpiSiswa($siswa->id);

        return redirect('/dashboard')->with('success', 'Usulan jabatan organisasi berhasil disimpan. Skor dihitung otomatis.');
    }
}
