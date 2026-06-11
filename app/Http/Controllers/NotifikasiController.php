<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Siswa;
use App\Models\KonsultasiBk;
use App\Models\BimbinganBk;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // Halaman Kirim Notifikasi
    public function create()
    {
        if (!in_array(auth()->user()->akses_role, ['admin', 'guru', 'walikelas', 'wakasiswa'])) {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        // Wali Kelas can only notify their own students
        if (auth()->user()->akses_role === 'walikelas') {
            $siswas = Siswa::with('penilaian')
                ->where('walikelas_id', auth()->id())
                ->orderBy('nama')
                ->get();
        } else {
            $siswas = Siswa::with('penilaian')->orderBy('nama')->get();
        }

        $recent = Notification::with(['siswa', 'sender'])
            ->where('from_user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        // Calculate class analysis if Wali Kelas or Admin/Wakasiswa/Guru and we have students
        $classAnalysis = null;
        if ($siswas->count() > 0) {
            $studentIds = $siswas->pluck('id');
            $penilaians = \App\Models\Penilaian::whereIn('siswa_id', $studentIds)->get();
            
            if ($penilaians->count() > 0) {
                $c1_avg = $penilaians->avg('c1') ?? 0;
                $c2_avg = $penilaians->avg('c2') ?? 0;
                $c3_avg = $penilaians->avg('c3') ?? 0;
                $c4_avg = $penilaians->avg('c4') ?? 0;
                
                // Lowest 5 students in the class by KPI score (verified or unverified)
                $lowestStudents = $penilaians->sortBy('kpi_score')
                    ->take(5)
                    ->map(function($p) use ($siswas) {
                        $p->siswa = $siswas->firstWhere('id', $p->siswa_id);
                        return $p;
                    })
                    ->filter(fn($p) => !is_null($p->siswa))
                    ->values();
                
                // Gaps list for students
                $pushList = [];
                foreach ($penilaians as $p) {
                    $siswa = $siswas->firstWhere('id', $p->siswa_id);
                    if (!$siswa) continue;
                    
                    $gaps = [];
                    // C3 is organization
                    if ($p->c3 == 0) {
                        $gaps[] = [
                            'field' => 'Organisasi (C3)',
                            'message' => "Halo {$siswa->nama}, kami melihat kamu belum memiliki keikutsertaan atau jabatan dalam organisasi (C3). Disarankan untuk bergabung ke dalam OSIS, MPK, kepengurusan kelas, atau ekskul kepemimpinan guna meningkatkan soft skill organisasi dan menaikkan nilai KPI prestasimu!",
                            'type' => 'Perlu Ditingkatkan',
                            'label' => 'Organisasi Kosong',
                            'icon' => 'fa-users'
                        ];
                    }
                    // C2 is academic achievements
                    if ($p->c2 == 0) {
                        $gaps[] = [
                            'field' => 'Prestasi Akademik (C2)',
                            'message' => "Halo {$siswa->nama}, kamu belum memiliki catatan prestasi akademik (C2). Yuk, coba tantang dirimu mengikuti olimpiade sains, lomba mata pelajaran, karya ilmiah, atau kompetisi akademis lainnya!",
                            'type' => 'Perlu Ditingkatkan',
                            'label' => 'Akademik Kosong',
                            'icon' => 'fa-book'
                        ];
                    }
                    // C4 is non-academic
                    if ($p->c4 == 0) {
                        $gaps[] = [
                            'field' => 'Seni & Olahraga (C4)',
                            'message' => "Halo {$siswa->nama}, kami perhatikan kamu belum memiliki catatan prestasi di bidang seni, olahraga, bahasa, atau budaya (C4). Coba ikuti ajang perlombaan non-akademik di luar sekolah untuk menyalurkan minat bakatmu!",
                            'type' => 'Perlu Ditingkatkan',
                            'label' => 'Minat/Bakat Kosong',
                            'icon' => 'fa-running'
                        ];
                    }
                    // C1 is average grades
                    if ($p->c1 < 75) {
                        $gaps[] = [
                            'field' => 'Rata-rata Rapor (C1)',
                            'message' => "Halo {$siswa->nama}, nilai rata-rata rapormu (C1) saat ini masih di bawah optimal (skor: " . number_format($p->c1, 1) . "). Mari tingkatkan fokus belajar dan konsistensi di kelas agar di semester berikutnya nilaimu bisa lebih baik!",
                            'type' => 'Perlu Ditingkatkan',
                            'label' => 'Rapor Rendah',
                            'icon' => 'fa-graduation-cap'
                        ];
                    }
                    
                    if (!empty($gaps)) {
                        $pushList[] = [
                            'siswa_id' => $siswa->id,
                            'nama' => $siswa->nama,
                            'kpi_score' => $p->kpi_score,
                            'gaps' => $gaps
                        ];
                    }
                }
                
                // Sort push list by KPI score ascending
                usort($pushList, function($a, $b) {
                    return $a['kpi_score'] <=> $b['kpi_score'];
                });
                
                // Take top 6
                $pushList = array_slice($pushList, 0, 6);

                $classAnalysis = [
                    'c1_avg' => round($c1_avg, 1),
                    'c2_avg' => round($c2_avg, 1),
                    'c3_avg' => round($c3_avg, 1),
                    'c4_avg' => round($c4_avg, 1),
                    'lowest_students' => $lowestStudents,
                    'push_list' => $pushList
                ];
            }
        }

        return view('notifikasi.create', compact('siswas', 'recent', 'classAnalysis'));
    }

    // Kirim Notifikasi
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'type'     => 'required|string',
            'message'  => 'required|string|max:1000',
        ]);

        Notification::create([
            'siswa_id'     => $request->siswa_id,
            'from_user_id' => auth()->id(),
            'type'         => $request->type,
            'message'      => $request->message,
        ]);

        return redirect('/notifikasi')->with('success', 'Notifikasi berhasil dikirim ke siswa!');
    }

    // Riwayat Notifikasi
    public function riwayat()
    {
        if (!in_array(auth()->user()->akses_role, ['admin', 'guru', 'walikelas', 'wakasiswa'])) {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        $notifications = Notification::with(['siswa', 'sender'])
            ->latest()
            ->get();

        $total = $notifications->count();
        $totalPertahankan = $notifications->where('type', 'Pertahankan')->count();
        $totalTingkatkan  = $notifications->where('type', 'Perlu Ditingkatkan')->count();

        return view('notifikasi.riwayat', compact('notifications', 'total', 'totalPertahankan', 'totalTingkatkan'));
    }

    // Halaman Inbox Notifikasi Siswa
    public function siswaIndex()
    {
        if (auth()->user()->akses_role !== 'siswa') {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        $siswa = Siswa::where('nis', auth()->user()->username)->first();
        if (!$siswa) {
            return redirect('/dashboard')->with('error', 'Data profil siswa tidak ditemukan.');
        }

        $notifications = Notification::with('sender')
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        // Mark unread notifications as read
        Notification::where('siswa_id', $siswa->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('notifikasi.siswa', compact('notifications', 'siswa'));
    }

    // Tandai Semua Notifikasi Sudah Dibaca
    public function markAllAsRead()
    {
        if (auth()->user()->akses_role !== 'siswa') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $siswa = Siswa::where('nis', auth()->user()->username)->first();
        if ($siswa) {
            Notification::where('siswa_id', $siswa->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }

    // Halaman Bimbingan Konseling Siswa
    public function siswaBimbingan()
    {
        if (auth()->user()->akses_role !== 'siswa') {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        $siswa = Siswa::where('nis', auth()->user()->username)->first();
        if (!$siswa) {
            return redirect('/dashboard')->with('error', 'Data profil siswa tidak ditemukan.');
        }

        // Ambil riwayat pengajuan konsultasi
        $pengajuans = KonsultasiBk::with('guru')
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        // Ambil riwayat pembinaan BK resmi
        $bimbingans = BimbinganBk::with('guru')
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('siswa.bimbingan', compact('siswa', 'pengajuans', 'bimbingans'));
    }

    // Simpan Pengajuan Konsultasi Siswa
    public function siswaBimbinganStore(Request $request)
    {
        if (auth()->user()->akses_role !== 'siswa') {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        $siswa = Siswa::where('nis', auth()->user()->username)->first();
        if (!$siswa) {
            return redirect('/dashboard')->with('error', 'Data profil siswa tidak ditemukan.');
        }

        $request->validate([
            'tanggal_pengajuan' => 'required|date|after_or_equal:today',
            'tipe_konsultasi' => 'required|string|in:akademik,non_akademik,disiplin,karir,lainnya',
            'keluhan' => 'required|string|max:1000',
        ], [
            'tanggal_pengajuan.required' => 'Tanggal pengajuan wajib diisi.',
            'tanggal_pengajuan.after_or_equal' => 'Tanggal pengajuan tidak boleh hari kemarin.',
            'tipe_konsultasi.required' => 'Kategori bimbingan wajib dipilih.',
            'keluhan.required' => 'Alasan atau keluhan bimbingan wajib diisi.',
        ]);

        KonsultasiBk::create([
            'siswa_id' => $siswa->id,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'tipe_konsultasi' => $request->tipe_konsultasi,
            'keluhan' => $request->keluhan,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan konsultasi berhasil dikirim ke Guru BK. Silakan pantau status pengajuan Anda.');
    }
}
