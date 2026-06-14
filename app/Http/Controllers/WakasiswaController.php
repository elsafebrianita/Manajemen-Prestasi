<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Notification;

class WakasiswaController extends Controller
{
    // Pengecekan role akan dilakukan di masing-masing method

    /**
     * Halaman Validasi Prestasi (hanya yang statusnya pending)
     */
    public function validasi(Request $request)
    {
        if (!in_array(auth()->user()->akses_role, ['wakasiswa', 'admin'])) {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Wakil Kesiswaan.');
        }

        $prestasi = Prestasi::with(['siswa', 'kategori'])
                    ->where('status', 'pending')
                    ->latest()
                    ->get();
                    
        return view('wakasiswa.validasi', compact('prestasi'));
    }

    /**
     * Halaman Data Prestasi (semua data prestasi)
     */
    public function dataPrestasi(Request $request)
    {
        if (!in_array(auth()->user()->akses_role, ['wakasiswa', 'admin'])) {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Wakil Kesiswaan.');
        }

        // Simpan log parameter filter ke file log untuk debugging
        file_put_contents(
            base_path('storage/logs/filter_debug.log'),
            "[" . date('Y-m-d H:i:s') . "] Request: " . json_encode($request->all()) . "\n",
            FILE_APPEND
        );

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
        return view('wakasiswa.data_prestasi', compact('prestasi'));
    }

    /**
     * Halaman Riwayat Validasi (hanya disetujui atau ditolak)
     */
    public function riwayatValidasi(Request $request)
    {
        if (!in_array(auth()->user()->akses_role, ['wakasiswa', 'admin'])) {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Wakil Kesiswaan.');
        }

        $prestasi = Prestasi::with(['siswa', 'kategori'])
                    ->whereIn('status', ['disetujui', 'ditolak'])
                    ->latest()
                    ->get();
                    
        return view('wakasiswa.riwayat', compact('prestasi'));
    }

    /**
     * Proses Verifikasi Prestasi (Approve/Reject)
     */
    public function verifikasi(Request $request, $id)
    {
        if (!in_array(auth()->user()->akses_role, ['wakasiswa', 'admin'])) {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Wakil Kesiswaan.');
        }

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable|string'
        ]);

        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        // Buat notifikasi ke siswa
        $pesan = $request->status == 'disetujui' 
            ? "Selamat! Prestasi '{$prestasi->nama_prestasi}' Anda telah disetujui."
            : "Maaf, pengajuan prestasi '{$prestasi->nama_prestasi}' Anda ditolak. Keterangan: " . ($request->keterangan ?? '-') . ". Silakan ubah dan perbaiki data Anda agar dapat diajukan kembali.";
            
        Notification::create([
            'siswa_id' => $prestasi->siswa_id,
            'from_user_id' => auth()->user()->id,
            'type' => $request->status == 'disetujui' ? 'Pertahankan' : 'Ditolak',
            'message' => $pesan,
            'is_read' => false
        ]);

        return redirect()->back()->with('success', 'Status prestasi berhasil diperbarui!');
    }

    /**
     * Halaman Publikasi Prestasi (Wakasiswa)
     */
    public function publikasi(Request $request)
    {
        if (!in_array(auth()->user()->akses_role, ['wakasiswa', 'admin'])) {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Wakil Kesiswaan.');
        }

        // Ambil data penilaian yang sudah dihitung oleh Wali Kelas (is_verified = true)
        // Kita prioritize yang direkomendasikan oleh Wali Kelas (is_recommended = true)
        $query = \App\Models\Penilaian::with('siswa')
                    ->where('is_verified', true)
                    ->orderBy('kpi_score', 'desc');

        if ($request->has('filter') && $request->filter === 'all') {
            // Tampilkan semua penilaian
        } else {
            // Secara default, tampilkan yang direkomendasikan Walikelas
            $query->where('is_recommended', true);
        }

        $penilaians = $query->get();

        return view('wakasiswa.publikasi', compact('penilaians'));
    }

    /**
     * Usulkan Publikasi ke Kepala Sekolah
     */
    public function proposePublikasi(Request $request, $id)
    {
        if (!in_array(auth()->user()->akses_role, ['wakasiswa', 'admin'])) {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk Wakil Kesiswaan.');
        }

        $penilaian = \App\Models\Penilaian::findOrFail($id);
        
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
}
