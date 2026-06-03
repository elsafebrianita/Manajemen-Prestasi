<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kelas;

class HumasController extends Controller
{
    private function checkRole()
    {
        if (auth()->user()->akses_role !== 'humas' && auth()->user()->akses_role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Humas.');
        }
    }

    public function index()
    {
        $this->checkRole();

        // Stats counts
        $totalRecommended = Penilaian::where('is_recommended', true)->count();
        $totalProposed = Penilaian::where('is_proposed', true)->count();
        $totalApproved = Penilaian::where('is_proposed', true)->where('kepsek_status', 'layak')->count();
        $totalPublished = Penilaian::where('is_published', true)->count();

        // Recent recommended students
        $recentRecommended = Penilaian::with(['siswa', 'prestasi'])
            ->where('is_recommended', true)
            ->where('is_proposed', false)
            ->orderBy('kpi_score', 'desc')
            ->take(5)
            ->get();

        // Recent publication decisions
        $recentDecisions = Penilaian::with('siswa')
            ->where('is_proposed', true)
            ->whereNotNull('kepsek_status')
            ->orderBy('kepsek_reviewed_at', 'desc')
            ->take(5)
            ->get();

        return view('humas.dashboard', compact(
            'totalRecommended',
            'totalProposed',
            'totalApproved',
            'totalPublished',
            'recentRecommended',
            'recentDecisions'
        ));
    }

    public function usulan(Request $request)
    {
        $this->checkRole();

        // Students recommended by Wali Kelas but not yet proposed to Kepsek
        $usulans = Penilaian::with(['siswa', 'prestasi'])
            ->where('is_recommended', true)
            ->where('is_proposed', false)
            ->orderBy('kpi_score', 'desc')
            ->get();

        return view('humas.usulan', compact('usulans'));
    }

    public function propose(Request $request, $id)
    {
        $this->checkRole();

        $penilaian = Penilaian::findOrFail($id);
        $penilaian->update([
            'is_proposed' => true,
            'kepsek_status' => 'menunggu',
            'is_published' => false,
            'status_publikasi' => 'draft',
            'berita_publikasi' => null,
            'admin_catatan' => null,
            'admin_published_by' => null,
            'admin_published_at' => null,
            'kepsek_catatan' => null,
            'kepsek_reviewed_at' => null,
        ]);

        return redirect()->back()->with('success', "Siswa {$penilaian->siswa->nama} berhasil diusulkan untuk publikasi prestasi ke Kepala Sekolah!");
    }

    public function riwayat()
    {
        $this->checkRole();

        // Display all proposed students and their Kepsek/publication status
        $riwayats = Penilaian::with(['siswa', 'prestasi'])
            ->where('is_proposed', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('humas.riwayat', compact('riwayats'));
    }

    public function prestasi(Request $request)
    {
        $this->checkRole();

        // Show all approved student achievements with category and status filter (matching Wakasiswa style)
        $query = Prestasi::with(['siswa', 'kategori'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori_id')) {
            $katId = $request->kategori_id;
            $query->whereHas('kategori', function($q) use ($katId) {
                $q->where('id', $katId)->orWhere('parent_id', $katId);
            });
        }

        $prestasi = $query->get();

        return view('humas.prestasi', compact('prestasi'));
    }

    public function laporan()
    {
        $this->checkRole();

        // Compile counts of achievements and proposed publications
        $kelasStats = Kelas::with(['siswas.penilaian', 'siswas.prestasis'])
            ->get()
            ->map(function($kelas) {
                $totalPrestasi = $kelas->siswas->flatMap(fn($s) => $s->prestasis)->where('status', 'disetujui')->count();
                $totalProposed = $kelas->siswas->flatMap(fn($s) => $s->penilaian ? [$s->penilaian] : [])->where('is_proposed', true)->count();
                $totalLayak = $kelas->siswas->flatMap(fn($s) => $s->penilaian ? [$s->penilaian] : [])->where('kepsek_status', 'layak')->count();
                $totalPublished = $kelas->siswas->flatMap(fn($s) => $s->penilaian ? [$s->penilaian] : [])->where('is_published', true)->count();

                return [
                    'nama_kelas' => $kelas->nama_kelas,
                    'total_prestasi' => $totalPrestasi,
                    'total_proposed' => $totalProposed,
                    'total_layak' => $totalLayak,
                    'total_published' => $totalPublished
                ];
            });

        // Top 5 students by KPI score
        $topStudents = Penilaian::with('siswa')
            ->where('is_verified', true)
            ->orderBy('kpi_score', 'desc')
            ->take(5)
            ->get();

        return view('humas.laporan', compact('kelasStats', 'topStudents'));
    }
}
