<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Penilaian;
use App\Models\Siswa;

class LandingController extends Controller
{
    public function index()
    {
        // 1. STATISTIK DINAMIS
        $totalSiswa = Siswa::count();
        $totalPrestasi = Prestasi::where('status', 'disetujui')->count();
        $lombaDiikuti = Prestasi::distinct('nama_prestasi')->count('nama_prestasi');
        $siswaBerprestasi = Prestasi::where('status', 'disetujui')->distinct('siswa_id')->count('siswa_id');

        $stats = [
            'total_siswa'       => $totalSiswa > 0 ? $totalSiswa : 0,
            'total_prestasi'    => $totalPrestasi > 0 ? $totalPrestasi : 0,
            'lomba_diikuti'     => $lombaDiikuti > 0 ? $lombaDiikuti : 0,
            'siswa_berprestasi' => $siswaBerprestasi > 0 ? $siswaBerprestasi : 0,
        ];

        // 2. PUBLIKASI PRESTASI - MENGGUNAKAN WORKFLOW BARU (status_publikasi='published')
        // Ambil penilaian yang sudah published dengan berita_publikasi
        $publishedPenilaians = Penilaian::with(['siswa', 'prestasi'])
            ->where('status_publikasi', 'published')
            ->whereNotNull('berita_publikasi')
            ->latest('admin_published_at')
            ->get();

        // Juga include prestasi yang lama (sebelum workflow baru) untuk backward compatibility
        $publishedSiswaIds = Penilaian::where('is_published', true)
            ->pluck('siswa_id')
            ->toArray();

        $prestasis = Prestasi::with('siswa')
            ->whereIn('siswa_id', $publishedSiswaIds)
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        return view('landing', compact('prestasis', 'stats', 'publishedPenilaians'));
    }
}

