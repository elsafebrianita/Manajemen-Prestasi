<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Prestasi;
use App\Models\KategoriPrestasi;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruMapel;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->akses_role === 'bk') {
            return redirect()->route('guru-bk.dashboard');
        }
        
        if ($user->akses_role === 'humas') {
            return redirect('/humas');
        }
        
        // Sync kelas_id and walikelas_id for all students based on their kelas string value
        $distinctClasses = Siswa::whereNotNull('kelas')->where('kelas', '!=', '')->distinct()->pluck('kelas')->toArray();
        foreach ($distinctClasses as $className) {
            $kelasRecord = Kelas::firstOrCreate(['nama_kelas' => $className]);
            Siswa::where('kelas', $className)->where(function($q) use ($kelasRecord) {
                $q->whereNull('kelas_id')->orWhere('kelas_id', '!=', $kelasRecord->id);
            })->update(['kelas_id' => $kelasRecord->id]);

            // Sync walikelas_id if another student in the same class already has a walikelas assigned
            $existingWaliId = Siswa::where('kelas_id', $kelasRecord->id)
                ->whereNotNull('walikelas_id')
                ->value('walikelas_id');
                
            if ($existingWaliId) {
                Siswa::where('kelas_id', $kelasRecord->id)
                    ->whereNull('walikelas_id')
                    ->update(['walikelas_id' => $existingWaliId]);
            }
        }
        
        $data = [
            'total_siswa' => class_exists(Siswa::class) ? Siswa::count() : 0,
            'total_prestasi' => class_exists(Prestasi::class) ? Prestasi::count() : 0,
            'total_kategori' => class_exists(KategoriPrestasi::class) ? KategoriPrestasi::count() : 0,
            'total_kelas' => Kelas::count(),
            'total_penilaian' => Penilaian::count(),
            'total_pending' => Prestasi::where('status', 'pending')->count(),
            'all_siswa' => Siswa::with('penilaian')->latest()->get(),
            'recent_activities' => Prestasi::with('siswa')->latest()->take(5)->get(),
        ];

        // GURU MATA PELAJARAN DASHBOARD DATA
        if ($user->akses_role == 'guru' || $user->akses_role == 'walikelas') {
            $myMapelRelations = GuruMapel::with(['mapel', 'kelas'])->where('guru_id', $user->id)->get();
            $myKelasIds = $myMapelRelations->pluck('kelas_id')->unique()->toArray();
            
            $data['my_mapels'] = $myMapelRelations;
            $data['my_kelas_count'] = count($myKelasIds);
            
            // Fetch students grouped by their class and mapel (space-insensitive)
            $mapelKelasData = [];
            $allStudents = Siswa::orderBy('nama')->get();
            foreach ($myMapelRelations as $relation) {
                if ($relation->kelas_id) {
                    $className = $relation->kelas->nama_kelas ?? '';
                    $targetNorm = str_replace('TKJT', 'TKJ', strtoupper(str_replace(' ', '', $className)));
                    
                    $students = $allStudents->filter(function($s) use ($relation, $targetNorm) {
                        if ($s->kelas_id == $relation->kelas_id) return true;
                        $sNorm = str_replace('TKJT', 'TKJ', strtoupper(str_replace(' ', '', $s->kelas)));
                        return !empty($targetNorm) && ($sNorm === $targetNorm || str_starts_with($sNorm, $targetNorm));
                    })->values();
                    
                    // Get grades for these students in this mapel
                    $studentIds = $students->pluck('id')->toArray();
                    $grades = NilaiSiswa::where('mapel_id', $relation->mapel_id)
                        ->where('guru_id', $user->id)
                        ->whereIn('siswa_id', $studentIds)
                        ->pluck('nilai', 'siswa_id')
                        ->toArray();
                    
                    $mapelKelasData[] = [
                        'relation' => $relation,
                        'students' => $students,
                        'grades' => $grades,
                    ];
                }
            }
            
            $data['mapel_kelas_data'] = $mapelKelasData;
            
            // Total unique students across all mapped classes (suffix-aware)
            $taughtStudentIds = [];
            foreach ($mapelKelasData as $mkD) {
                foreach ($mkD['students'] as $s) {
                    $taughtStudentIds[] = $s->id;
                }
            }
            $data['my_siswas_count'] = count(array_unique($taughtStudentIds));
            $data['my_nilai_count'] = NilaiSiswa::where('guru_id', $user->id)->count();
            
            $data['recent_grades'] = NilaiSiswa::with(['siswa', 'mapel'])->where('guru_id', $user->id)->latest()->take(5)->get();
        }

        // WALI KELAS DASHBOARD DATA
        if ($user->akses_role == 'walikelas') {
            $myClass = Kelas::whereHas('siswas', function($q) use ($user) {
                $q->where('walikelas_id', $user->id);
            })->first();
            
            $data['walikelas_kelas'] = $myClass ? $myClass->nama_kelas : 'Tidak Ada Kelas';
            $data['walikelas_siswa_count'] = Siswa::where('walikelas_id', $user->id)->count();
            $data['walikelas_kpi_calculated'] = Penilaian::whereHas('siswa', function($q) use ($user) {
                $q->where('walikelas_id', $user->id);
            })->count();
            
            $data['walikelas_siswa_list'] = Siswa::with('penilaian')->where('walikelas_id', $user->id)->latest()->get();
            $data['walikelas_recent_achievements'] = Prestasi::with('siswa')
                ->whereHas('siswa', function($q) use ($user) {
                    $q->where('walikelas_id', $user->id);
                })->latest()->take(5)->get();
        }

        // WAKIL KESISWAAN DASHBOARD DATA
        if ($user->akses_role == 'wakasiswa') {
            $data['total_approved'] = Prestasi::where('status', 'disetujui')->count();
            $data['total_rejected'] = Prestasi::where('status', 'ditolak')->count();
        }

        // SISWA DASHBOARD DATA
        if ($user->akses_role == 'siswa') {
            $siswa = Siswa::where('nis', $user->username)->first();
            $data['siswa_detail'] = $siswa;
            $data['my_penilaian'] = $siswa ? Penilaian::where('siswa_id', $siswa->id)->first() : null;
            $data['my_prestasi'] = $siswa ? Prestasi::where('siswa_id', $siswa->id)->with('kategori')->get() : collect();
            $data['my_notifications'] = $siswa ? \App\Models\Notification::where('siswa_id', $siswa->id)->with('sender')->latest()->get() : collect();
            $data['my_grades'] = $siswa ? NilaiSiswa::with(['mapel', 'guru'])->where('siswa_id', $siswa->id)->get() : collect();
            $data['my_bimbingan'] = $siswa ? \App\Models\BimbinganBk::where('siswa_id', $siswa->id)->with('guru')->latest()->get() : collect();
        }

        return view('dashboard', $data);
    }

    public function updateFotoProfil(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto.required' => 'Foto profil wajib diunggah',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $user = auth()->user();

        // Hapus foto lama jika ada
        if ($user->foto && file_exists(public_path('uploads/profil/' . $user->foto))) {
            @unlink(public_path('uploads/profil/' . $user->foto));
        }

        // Upload foto baru
        $destinationPath = public_path('uploads/profil');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $fotoName = time() . '_' . $request->foto->getClientOriginalName();
        $request->foto->move($destinationPath, $fotoName);

        // Update database
        $user->update([
            'foto' => $fotoName
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
