<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Penilaian;
use App\Models\Prestasi;
use App\Models\BimbinganBk;
use App\Models\Kelas;
use App\Models\Notification;
use Illuminate\Http\Request;

class GuruBkController extends Controller
{
    private function checkRole()
    {
        if (auth()->user()->akses_role !== 'bk') {
            abort(403, 'Akses hanya untuk Guru Bimbingan Konseling.');
        }
    }

    // 1. Dashboard Guru BK
    public function index()
    {
        $this->checkRole();

        $totalSiswa = Siswa::count();
        
        // Siswa KPI Tinggi (>= 80)
        $kpiTinggi = Penilaian::where('kpi_score', '>=', 80)->count();
        
        // Siswa KPI Rendah (< 70)
        $kpiRendah = Penilaian::where('kpi_score', '<', 70)->count();
        
        // Siswa Butuh Pembinaan (KPI < 70 ATAU memiliki pembinaan aktif status 'proses')
        $siswaButuhPembinaanIds = Penilaian::where('kpi_score', '<', 70)->pluck('siswa_id')->toArray();
        $siswaActiveBimbinganIds = BimbinganBk::where('status', 'proses')->pluck('siswa_id')->toArray();
        $mergedIds = array_unique(array_merge($siswaButuhPembinaanIds, $siswaActiveBimbinganIds));
        
        $butuhPembinaanCount = count($mergedIds);

        // Daftar Siswa Butuh Pembinaan (untuk tabel di dashboard)
        $daftarButuhPembinaan = Siswa::whereIn('id', $mergedIds)
            ->with(['penilaian', 'walikelas'])
            ->get()
            ->map(function($siswa) {
                // Cari status bimbingan terakhir
                $lastBimbingan = BimbinganBk::where('siswa_id', $siswa->id)->latest()->first();
                $siswa->status_bimbingan = $lastBimbingan ? $lastBimbingan->status : 'belum_pernah';
                $siswa->kpi_score = $siswa->penilaian ? $siswa->penilaian->kpi_score : 0;
                return $siswa;
            })
            ->sortBy('kpi_score')
            ->take(5);

        // Riwayat Konseling Terbaru (5 data terakhir)
        $riwayatTerbaru = BimbinganBk::with(['siswa', 'guru'])
            ->latest()
            ->take(5)
            ->get();

        return view('guru_bk.dashboard', compact(
            'totalSiswa',
            'kpiTinggi',
            'kpiRendah',
            'butuhPembinaanCount',
            'daftarButuhPembinaan',
            'riwayatTerbaru'
        ));
    }

    // 2. Monitoring KPI Siswa
    public function monitoring(Request $request)
    {
        $this->checkRole();

        $kelasId = $request->get('kelas_id');
        $statusFilter = $request->get('status'); // tinggi, sedang, rendah

        $query = Siswa::with(['penilaian', 'kelasRel']);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        if ($statusFilter) {
            $query->whereHas('penilaian', function($q) use ($statusFilter) {
                if ($statusFilter === 'tinggi') {
                    $q->where('kpi_score', '>=', 80);
                } elseif ($statusFilter === 'sedang') {
                    $q->where('kpi_score', '>=', 70)->where('kpi_score', '<', 80);
                } elseif ($statusFilter === 'rendah') {
                    $q->where('kpi_score', '<', 70);
                }
            });
        }

        $siswas = $query->get()->map(function($siswa) {
            $kpi = $siswa->penilaian ? $siswa->penilaian->kpi_score : 0;
            
            // Tentukan Kategori Status
            if ($kpi >= 80) {
                $siswa->kpi_status = 'Sangat Baik';
            } elseif ($kpi >= 70) {
                $siswa->kpi_status = 'Baik';
            } elseif ($kpi >= 60) {
                $siswa->kpi_status = 'Cukup';
            } else {
                $siswa->kpi_status = 'Perlu Pembinaan';
            }

            $siswa->ranking = $siswa->penilaian ? $siswa->penilaian->ranking : '-';
            return $siswa;
        })->sortByDesc(function($siswa) {
            return $siswa->penilaian ? $siswa->penilaian->kpi_score : 0;
        });

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('guru_bk.monitoring', compact('siswas', 'kelas'));
    }

    // 3. Detail Perkembangan Siswa
    public function detail($siswa_id)
    {
        $this->checkRole();

        $siswa = Siswa::with(['penilaian', 'prestasis.kategori', 'walikelas', 'kelasRel'])->findOrFail($siswa_id);
        
        // Histori Pembinaan
        $riwayatBimbingan = BimbinganBk::where('siswa_id', $siswa_id)
            ->with('guru')
            ->latest()
            ->get();

        // Cari prestasi akademik, non akademik, organisasi
        $prestasiAkademik = $siswa->prestasis->filter(function($p) {
            return $p->kategori && ($p->kategori->id == 2 || $p->kategori->parent_id == 2);
        });

        $prestasiNonAkademik = $siswa->prestasis->filter(function($p) {
            return $p->kategori && ($p->kategori->id == 4 || $p->kategori->parent_id == 4);
        });

        $prestasiOrganisasi = $siswa->prestasis->filter(function($p) {
            return $p->kategori && ($p->kategori->id == 3 || $p->kategori->parent_id == 3);
        });

        // Simulasi perkembangan KPI Semester 1 & Semester 2
        $currentKpi = $siswa->penilaian ? $siswa->penilaian->kpi_score : 0;
        $simulasiSem1 = round($currentKpi * 0.9 + ($siswa->id % 5) - 2);
        // Batasi range 0-100
        $simulasiSem1 = max(0, min(100, $simulasiSem1));
        
        $chartData = [
            'labels' => ['Semester 1', 'Semester 2 (Sekarang)'],
            'data' => [$simulasiSem1, round($currentKpi)]
        ];

        return view('guru_bk.detail', compact(
            'siswa',
            'riwayatBimbingan',
            'prestasiAkademik',
            'prestasiNonAkademik',
            'prestasiOrganisasi',
            'chartData'
        ));
    }

    // 4. Form Pembinaan Siswa
    public function bembinaan(Request $request) // typo safe alias / backup
    {
        return $this->pembinaan($request);
    }

    public function pembinaan(Request $request)
    {
        $this->checkRole();

        $siswaId = $request->get('siswa_id');
        $siswas = Siswa::orderBy('nama')->get();

        return view('guru_bk.pembinaan', compact('siswas', 'siswaId'));
    }

    // Simpan Pembinaan Siswa
    public function storePembinaan(Request $request)
    {
        $this->checkRole();

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'jenis_pembinaan' => 'required|in:akademik,non_akademik,disiplin',
            'catatan' => 'required|string',
            'status' => 'required|in:proses,selesai',
            'rekomendasi_lomba' => 'nullable|string|max:255',
            'rekomendasi_organisasi' => 'nullable|string|max:255',
            'rekomendasi_pengembangan' => 'nullable|string|max:255',
        ], [
            'siswa_id.required' => 'Siswa wajib dipilih.',
            'tanggal.required' => 'Tanggal pembinaan wajib diisi.',
            'jenis_pembinaan.required' => 'Jenis pembinaan wajib dipilih.',
            'catatan.required' => 'Catatan pembinaan wajib diisi.',
        ]);

        BimbinganBk::create([
            'siswa_id' => $request->siswa_id,
            'guru_id' => auth()->id(),
            'tanggal' => $request->tanggal,
            'jenis_pembinaan' => $request->jenis_pembinaan,
            'catatan' => $request->catatan,
            'status' => $request->status,
            'rekomendasi_lomba' => $request->rekomendasi_lomba,
            'rekomendasi_organisasi' => $request->rekomendasi_organisasi,
            'rekomendasi_pengembangan' => $request->rekomendasi_pengembangan,
        ]);

        // Kirim Notifikasi ke Siswa
        $jenisFormatted = match($request->jenis_pembinaan) {
            'akademik' => 'Akademik',
            'non_akademik' => 'Non Akademik',
            'disiplin' => 'Disiplin/Tata Tertib',
            default => str_replace('_', ' ', $request->jenis_pembinaan)
        };

        Notification::create([
            'siswa_id' => $request->siswa_id,
            'from_user_id' => auth()->id(),
            'type' => 'Binaan BK',
            'message' => 'Anda memiliki catatan bimbingan baru dari Guru BK pada tanggal ' . \Carbon\Carbon::parse($request->tanggal)->translatedFormat('d M Y') . ' (' . $jenisFormatted . '). Silakan cek dashboard untuk melihat detail rekomendasi minat dan bakat Anda.',
            'is_read' => false,
        ]);

        return redirect()->route('guru-bk.riwayat')->with('success', 'Catatan pembinaan siswa berhasil disimpan.');
    }

    // 5. Riwayat Pembinaan BK
    public function riwayat(Request $request)
    {
        $this->checkRole();

        $riwayats = BimbinganBk::with(['siswa.kelasRel', 'guru'])
            ->latest()
            ->get();

        return view('guru_bk.riwayat', compact('riwayats'));
    }

    // 6. Monitoring Bakat dan Prestasi
    public function bakat(Request $request)
    {
        $this->checkRole();

        $kelasId = $request->get('kelas_id');

        $query = Siswa::with(['penilaian', 'kelasRel', 'prestasis.kategori']);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $siswas = $query->get()->map(function($siswa) {
            // Bakat Dominan
            $siswa->bakat = $siswa->penilaian ? $siswa->penilaian->bakat_dominan : 'Belum Teranalisis';
            return $siswa;
        });

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('guru_bk.bakat', compact('siswas', 'kelas'));
    }
}
