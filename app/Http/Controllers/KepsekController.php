<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\Prestasi;
use App\Models\KategoriPrestasi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KepsekController extends Controller
{
    private function checkRole()
    {
        if (auth()->user()->akses_role !== 'kepsek') {
            abort(403, 'Akses hanya untuk Kepala Sekolah.');
        }
    }

    // Dashboard utama Kepsek - dengan grafik dan analisis
    // Dashboard utama Kepsek - dengan grafik dan analisis
    public function index()
    {
        $this->checkRole();

        $penilaians = Penilaian::with('siswa')
            ->orderBy('kpi_score', 'desc')
            ->get();

        $stats = [
            'total'        => $penilaians->count(),
            'menunggu'     => $penilaians->where('is_proposed', true)->where('kepsek_status', 'menunggu')->count(),
            'high'         => $penilaians->where('kpi_score', '>=', 85)->count(),
            'medium'       => $penilaians->where('kpi_score', '>=', 70)->where('kpi_score', '<', 85)->count(),
            'low'          => $penilaians->where('kpi_score', '<', 70)->count(),
        ];

        // === DATA UNTUK 4 INDIKATOR ===
        // 1. Rata-rata Nilai Sekolah per Indikator
        $c1_avg = Penilaian::avg('c1') ?? 0;
        $c2_avg = Penilaian::avg('c2') ?? 0;
        $c3_avg = (Penilaian::avg('c3') ?? 0) * 25; // Skala 0-100
        $c4_avg = Penilaian::avg('c4') ?? 0;

        $indicators_avg = [
            'Rapor (C1)' => round($c1_avg, 2),
            'Prestasi Akademik (C2)' => round($c2_avg, 2),
            'Jabatan Organisasi (C3)' => round($c3_avg, 2),
            'Seni, Budaya, Bahasa, Olahraga (C4)' => round($c4_avg, 2),
        ];

        // 2. Juara masing-masing bidang (Siswa dengan nilai tertinggi per kriteria)
        $juara_rapor = Penilaian::with('siswa')->whereNotNull('c1')->orderBy('c1', 'desc')->first();
        $juara_akademik = Penilaian::with('siswa')->whereNotNull('c2')->orderBy('c2', 'desc')->first();
        $juara_organisasi = Penilaian::with('siswa')->whereNotNull('c3')->orderBy('c3', 'desc')->first();
        $juara_seni_olahraga = Penilaian::with('siswa')->whereNotNull('c4')->orderBy('c4', 'desc')->first();

        // === DATA UNTUK GRAFIK TINGKAT (Nasional, Internasional, dll) ===
        $tingkat_data = [];
        $tingkat_list = ['Internasional', 'Nasional', 'Provinsi', 'Kabupaten', 'Kecamatan'];
        
        foreach ($tingkat_list as $tingkat) {
            $tingkat_data[$tingkat] = Prestasi::where('tingkat', $tingkat)
                ->where('status', 'disetujui')
                ->count();
        }

        // Leaderboard per Tingkat Prestasi (Siswa dengan poin tertinggi di tingkat tersebut)
        $tingkat_leaders = [];
        foreach ($tingkat_list as $tingkat) {
            $tingkat_leaders[$tingkat] = Prestasi::with('siswa')
                ->where('tingkat', $tingkat)
                ->where('status', 'disetujui')
                ->get()
                ->sortByDesc('poin')
                ->take(3)
                ->values();
        }

        // === 10 SISWA TERTINGGI & TERENDAH ===
        $top_10 = Penilaian::with('siswa')
            ->orderBy('kpi_score', 'desc')
            ->take(10)
            ->get();

        $bottom_10 = Penilaian::with('siswa')
            ->orderBy('kpi_score', 'asc')
            ->take(10)
            ->get();

        // === KELAS DENGAN PRESTASI RENDAH & TINGGI ===
        $kelas_all = Kelas::with('siswas.penilaian')
            ->get()
            ->map(function ($kelas) {
                $rata_kpi = $kelas->siswas->flatMap(function ($s) {
                    return $s->penilaian ? [$s->penilaian->kpi_score] : [];
                });
                
                return [
                    'nama_kelas' => $kelas->nama_kelas,
                    'rata_kpi' => $rata_kpi->count() > 0 ? $rata_kpi->average() : 0,
                    'jumlah_siswa' => $kelas->siswas->count(),
                ];
            });

        // 5 Kelas terendah
        $kelas_rendah = $kelas_all->sortBy('rata_kpi')->take(5)->values()->toArray();
        // 5 Kelas tertinggi
        $kelas_tinggi = $kelas_all->sortByDesc('rata_kpi')->take(5)->values()->toArray();

        // === PEMENANG PER BIDANG (Top 3 dari Kategori Prestasi) ===
        $kategoris = KategoriPrestasi::all();
        $pemenang_bidang = [];
        foreach ($kategoris as $kat) {
            $top_bidang = Prestasi::where('kategori_id', $kat->id)
                ->where('status', 'disetujui')
                ->with('siswa')
                ->get()
                ->sortByDesc('poin')
                ->take(3);
            
            $pemenang_bidang[$kat->nama_kategori] = $top_bidang;
        }

        // === GRAFIK NILAI PER MAPEL ===
        $mapels_list = \App\Models\Mapel::all();
        $mapel_averages = [];
        foreach ($mapels_list as $m) {
            $avg = \App\Models\NilaiSiswa::where('mapel_id', $m->id)->avg('nilai');
            $mapel_averages[$m->nama_mapel] = $avg ? round($avg, 2) : 0;
        }

        // === RATA-RATA AKADEMIK (C1) PER KELAS ===
        $kelas_akademik = Kelas::with('siswas.penilaian')
            ->get()
            ->map(function ($kelas) {
                $c1_scores = $kelas->siswas->flatMap(function ($s) {
                    return $s->penilaian ? [$s->penilaian->c1] : [];
                });
                
                return [
                    'nama_kelas' => $kelas->nama_kelas,
                    'rata_akademik' => $c1_scores->count() > 0 ? $c1_scores->average() : 0,
                    'jumlah_siswa' => $kelas->siswas->count(),
                ];
            })
            ->sortByDesc('rata_akademik');

        // Tampilkan siswa yang diusulkan oleh Wakasiswa ATAU yang sudah memiliki status keputusan Kepsek untuk tabel keputusan publikasi
        $proposed_penilaians = Penilaian::with('siswa')
            ->where(function($q) {
                $q->where('is_proposed', true)
                  ->orWhereIn('kepsek_status', ['layak', 'tidak_layak']);
            })
            ->orderByRaw("CASE WHEN kepsek_status = 'menunggu' THEN 1 WHEN kepsek_status = 'layak' THEN 2 WHEN kepsek_status = 'tidak_layak' THEN 3 ELSE 4 END")
            ->orderBy('kpi_score', 'desc')
            ->get();

        return view('kepsek.dashboard_grafik', compact(
            'penilaians', 'proposed_penilaians', 'stats', 'indicators_avg', 'tingkat_data', 'tingkat_leaders',
            'juara_rapor', 'juara_akademik', 'juara_organisasi', 'juara_seni_olahraga',
            'top_10', 'bottom_10', 'kelas_rendah', 'kelas_tinggi', 'pemenang_bidang', 'kategoris',
            'mapel_averages', 'kelas_akademik'
        ));
    }

    // Detail siswa untuk kepsek
    public function show($id)
    {
        $this->checkRole();
        $siswa = Siswa::with(['penilaian', 'prestasis.kategori'])->findOrFail($id);

        $kelasId = $siswa->kelas_id;
        $kelasName = $siswa->kelas;
        $classMapelIds = [];
        if ($kelasName) {
            $kelasNorm = str_replace('TKJT', 'TKJ', strtoupper(str_replace(' ', '', $kelasName)));
            $allGms = \App\Models\GuruMapel::with('kelas')->get();
            foreach ($allGms as $gm) {
                if (!$gm->kelas) continue;
                $gmNorm = str_replace('TKJT', 'TKJ', strtoupper(str_replace(' ', '', $gm->kelas->nama_kelas)));
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
        $nilaiSiswas = \App\Models\NilaiSiswa::with('guru')->where('siswa_id', $siswa->id)->get()->keyBy('mapel_id');

        return view('kepsek.show', compact('siswa', 'mapels', 'nilaiSiswas'));
    }

    // Kepsek ambil keputusan (layak / tidak_layak)
    public function keputusan(Request $request, $penilaian_id)
    {
        $this->checkRole();

        $request->validate([
            'kepsek_status'  => 'required|in:layak,tidak_layak',
            'kepsek_catatan' => 'nullable|string|max:500',
        ]);

        Penilaian::findOrFail($penilaian_id)->update([
            'kepsek_status'     => $request->kepsek_status,
            'kepsek_catatan'    => $request->kepsek_catatan,
            'kepsek_reviewed_at'=> now(),
            // Jangan langsung publish ke landing page agar dikelola oleh admin terlebih dahulu
            'is_published'      => false, 
        ]);

        $msg = $request->kepsek_status === 'layak'
            ? 'Siswa dinyatakan Layak Publikasi! Selanjutnya Admin akan memposting berita prestasi siswa.'
            : 'Siswa dinyatakan Tidak Layak Publikasi.';

        return redirect('/admin/publikasi')->with('success', $msg);
    }

    // Admin/Kepsek: halaman publikasi siswa berprestasi
    public function adminPublikasi()
    {
        if (!in_array(auth()->user()->akses_role, ['admin', 'kepsek'])) abort(403);

        // Tampilkan siswa yang diusulkan, memiliki keputusan Kepsek, ATAU yang sudah dipublikasikan
        $penilaians = Penilaian::with('siswa')
            ->where(function($q) {
                $q->where('is_proposed', true)
                  ->orWhereIn('kepsek_status', ['layak', 'tidak_layak'])
                  ->orWhere('is_published', true)
                  ->orWhere('status_publikasi', 'published');
            })
            ->orderByRaw("CASE WHEN kepsek_status = 'menunggu' THEN 1 WHEN kepsek_status = 'layak' THEN 2 WHEN kepsek_status = 'tidak_layak' THEN 3 ELSE 4 END")
            ->orderBy('kpi_score', 'desc')
            ->get();

        $pending = Penilaian::where('is_proposed', true)->where('kepsek_status', 'menunggu')->count();

        return view('kepsek.admin_publikasi', compact('penilaians', 'pending'));
    }

    // Admin/Kepsek: publikasi setelah kepsek approve
    public function publish($penilaian_id)
    {
        if (!in_array(auth()->user()->akses_role, ['admin', 'kepsek'])) {
            abort(403);
        }

        $penilaian = Penilaian::findOrFail($penilaian_id);

        if ($penilaian->kepsek_status !== 'layak') {
            return redirect()->back()->with('error', 'Siswa belum mendapat persetujuan Kepala Sekolah!');
        }
        $newPublished = !$penilaian->is_published;
        $penilaian->update([
            'is_published' => $newPublished,
            'status_publikasi' => $newPublished ? 'published' : 'draft'
        ]);

        $msg = $newPublished ? 'Siswa berhasil dipublikasikan!' : 'Publikasi siswa dibatalkan.';
        return redirect()->back()->with('success', $msg);
    }

    // Admin: Form edit berita publikasi
    public function editBerita($penilaian_id)
    {
        if (auth()->user()->akses_role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat menambah berita publikasi.');
        }

        $penilaian = Penilaian::with('siswa')->findOrFail($penilaian_id);

        if ($penilaian->kepsek_status !== 'layak') {
            return redirect('/admin/publikasi')->with('error', 'Siswa belum mendapat persetujuan Kepala Sekolah!');
        }

        return view('kepsek.edit_berita', compact('penilaian'));
    }

    // Admin: Simpan berita dan publikasikan
    public function simpanBerita(Request $request, $penilaian_id)
    {
        if (auth()->user()->akses_role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat menyimpan berita publikasi.');
        }

        $request->validate([
            'berita_publikasi' => 'required|string|max:1000',
            'admin_catatan' => 'nullable|string|max:500',
        ]);

        $penilaian = Penilaian::findOrFail($penilaian_id);

        $penilaian->update([
            'berita_publikasi' => $request->berita_publikasi,
            'admin_catatan' => $request->admin_catatan,
            'admin_published_by' => auth()->id(),
            'admin_published_at' => now(),
            'status_publikasi' => 'published',
            'is_published' => true,
        ]);

        return redirect('/admin/publikasi')->with('success', 'Berita berhasil dipublikasikan!');
    }
}

