<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruMapel;
use App\Models\Siswa;
use App\Models\NilaiSiswa;
use App\Models\Penilaian;
use App\Models\Prestasi;
use App\Models\KpiSetting;

class AcademicController extends Controller
{
    // ==========================================
    // ADMIN MASTER DATA MANAGEMENT
    // ==========================================

    // Manage Teachers (Guru)
    public function adminGuru()
    {
        // Include semua user dengan role guru (lama: walikelas/wakasiswa/kepsek, baru: guru+jabatan)
        $gurus = User::where('role', 'guru')
            ->orWhereIn('role', ['walikelas', 'wakasiswa', 'kepsek'])
            ->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:guru,walikelas',
            'password' => 'required|string|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'is_verified' => true
        ]);

        return back()->with('success', 'Data Guru berhasil ditambahkan!');
    }

    public function importGuru(Request $request)
    {
        $filePath = null;

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|file'
            ]);
            $filePath = $request->file('file')->getRealPath();
        } else {
            // Check default path
            $defaultPath = 'C:\\Users\\acer\\Downloads\\DATA GURU SMKN 1 TALAMAU.xlsx';
            if (file_exists($defaultPath)) {
                $filePath = $defaultPath;
            }
        }

        if (!$filePath) {
            return back()->with('error', 'File Excel tidak ditemukan. Unggah file .xlsx Anda.');
        }

        if ($xlsx = \Shuchkin\SimpleXLSX::parse($filePath)) {
            $rows = $xlsx->rows(0);
            $importedCount = 0;

            // Valid rows are from index 15 to 74
            for ($i = 15; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                // Skip footer rows or rows with empty NAMA
                if (empty($row[1]) || trim($row[1]) == '' || count($row) < 3) {
                    continue;
                }

                $nama = trim($row[1]);
                $nip = trim($row[2]);
                $jabatan = trim($row[3] ?? 'Guru');

                // Determine unique username and fallback email
                $username = !empty($nip) && $nip != '-' ? $nip : strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nama));
                $email = $username . '@example.com';

                // Determine role
                $role = 'guru';
                if (stripos($jabatan, 'Kepala Sekolah') !== false) {
                    $role = 'kepsek';
                } elseif (stripos($jabatan, 'Kesiswaan') !== false || stripos($jabatan, 'wakasiswa') !== false) {
                    $role = 'wakasiswa';
                } elseif (stripos($jabatan, 'Waka') !== false) {
                    $role = 'wakasiswa'; // Any Vice Principal
                }

                // Create or update User safely
                $existingUser = User::where('username', $username)->first();
                if ($existingUser) {
                    $updateData = [
                        'name' => $nama,
                        'nip' => !empty($nip) && $nip != '-' ? $nip : null,
                        'jabatan' => $jabatan,
                    ];
                    
                    // Only overwrite password and is_verified if still using default 'password'
                    if (\Illuminate\Support\Facades\Hash::check('password', $existingUser->password)) {
                        $updateData['password'] = bcrypt('password');
                        $updateData['is_verified'] = true;
                    }
                    
                    $existingUser->update($updateData);
                } else {
                    User::create([
                        'username' => $username,
                        'name' => $nama,
                        'email' => $email,
                        'role' => $role,
                        'password' => bcrypt('password'),
                        'is_verified' => true,
                        'nip' => !empty($nip) && $nip != '-' ? $nip : null,
                        'jabatan' => $jabatan
                    ]);
                }
                $importedCount++;
            }

            return back()->with('success', "$importedCount data Guru & Wali Kelas berhasil diimpor dan disinkronisasikan!");
        }

        return back()->with('error', 'Gagal membaca file Excel.');
    }

    public function updateGuru(Request $request, $id)
    {
        $guru = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:guru,walikelas',
        ]);

        $guru->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $guru->update(['password' => bcrypt($request->password)]);
        }

        return back()->with('success', 'Data Guru berhasil diubah!');
    }

    public function destroyGuru($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Data Guru berhasil dihapus!');
    }

    // Manage Kelas
    public function adminKelas()
    {
        // Sync classes from student data
        $distinctClasses = Siswa::whereNotNull('kelas')->where('kelas', '!=', '')->distinct()->pluck('kelas')->toArray();
        foreach ($distinctClasses as $className) {
            $kelasRecord = Kelas::firstOrCreate(['nama_kelas' => $className]);
            Siswa::where('kelas', $className)->where(function($q) use ($kelasRecord) {
                $q->whereNull('kelas_id')->orWhere('kelas_id', '!=', $kelasRecord->id);
            })->update(['kelas_id' => $kelasRecord->id]);
        }

        $kelas = Kelas::all();
        // Include semua guru (lama & baru)
        $gurus = User::where('role', 'guru')
            ->orWhere('role', 'walikelas')
            ->get();
        return view('admin.kelas.index', compact('kelas', 'gurus'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate(['nama_kelas' => 'required|string|unique:kelas,nama_kelas']);
        Kelas::create(['nama_kelas' => $request->nama_kelas]);
        return back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function updateKelas(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $request->validate(['nama_kelas' => 'required|string|unique:kelas,nama_kelas,' . $id]);
        $kelas->update(['nama_kelas' => $request->nama_kelas]);
        return back()->with('success', 'Kelas berhasil diubah!');
    }

    public function destroyKelas($id)
    {
        Kelas::findOrFail($id)->delete();
        return back()->with('success', 'Kelas berhasil dihapus!');
    }

    public function assignWaliKelas(Request $request, $id)
    {
        $request->validate([
            'walikelas_id' => 'nullable|exists:users,id'
        ]);

        if ($request->filled('walikelas_id')) {
            $user = User::find($request->walikelas_id);
            if ($user && $user->role == 'guru') {
                $user->update(['role' => 'walikelas']);
            }
        }

        Siswa::where('kelas_id', $id)->update([
            'walikelas_id' => $request->walikelas_id
        ]);

        return back()->with('success', 'Wali Kelas berhasil ditugaskan ke kelas ini!');
    }

    // Manage Mapel
    public function adminMapel()
    {
        $mapels = Mapel::with('guruMapels')->orderBy('nama_mapel')->get();
        $totalGurus = User::whereIn('role', ['guru', 'walikelas', 'wakasiswa'])->count();
        $totalKelas = \App\Models\Kelas::count();
        $totalRelasi = \App\Models\GuruMapel::count();
        return view('admin.mapel.index', compact('mapels', 'totalGurus', 'totalKelas', 'totalRelasi'));
    }

    public function storeMapel(Request $request)
    {
        $request->validate(['nama_mapel' => 'required|string|unique:mapels,nama_mapel']);
        Mapel::create(['nama_mapel' => $request->nama_mapel]);
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    public function updateMapel(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);
        $request->validate(['nama_mapel' => 'required|string|unique:mapels,nama_mapel,' . $id]);
        $mapel->update(['nama_mapel' => $request->nama_mapel]);
        return back()->with('success', 'Mata Pelajaran berhasil diubah!');
    }

    public function destroyMapel($id)
    {
        Mapel::findOrFail($id)->delete();
        return back()->with('success', 'Mata Pelajaran berhasil dihapus!');
    }

    // Manage Relasi Guru & Mapel & Kelas
    public function adminRelasi()
    {
        $relasis = GuruMapel::with(['guru', 'mapel', 'kelas'])
            ->join('users', 'guru_mapels.guru_id', '=', 'users.id')
            ->orderBy('users.name')
            ->select('guru_mapels.*')
            ->get();
        // Include semua user yg bisa mengajar (role guru lama & baru)
        $gurus = User::where(function($q) {
                $q->where('role', 'guru')
                  ->orWhereIn('role', ['walikelas', 'wakasiswa']);
            })
            ->where('is_verified', true)
            ->orderBy('name')
            ->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.relasi.index', compact('relasis', 'gurus', 'mapels', 'kelas'));
    }

    public function storeRelasi(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        // Check duplicate
        $exists = GuruMapel::where('guru_id', $request->guru_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('kelas_id', $request->kelas_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Relasi Guru, Mapel, dan Kelas ini sudah ada!');
        }

        GuruMapel::create($request->only(['guru_id', 'mapel_id', 'kelas_id']));
        return back()->with('success', 'Relasi Guru & Mapel berhasil ditambahkan!');
    }

    public function destroyRelasi($id)
    {
        GuruMapel::findOrFail($id)->delete();
        return back()->with('success', 'Relasi Guru & Mapel berhasil dihapus!');
    }

    // Manage Users
    public function adminUser()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:admin,guru,walikelas,wakasiswa,kepsek,siswa',
            'password' => 'required|string|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'is_verified' => true
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,guru,walikelas,wakasiswa,kepsek,siswa',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return back()->with('success', 'User berhasil diubah!');
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }


    // ==========================================
    // GURU MATA PELAJARAN MANAGEMENT
    // ==========================================

    // Show Mapel Saya
    public function guruMapelSaya()
    {
        $user = auth()->user();
        $mapels = GuruMapel::with(['mapel', 'kelas'])->where('guru_id', $user->id)->get();
        return view('guru.mapel.index', compact('mapels'));
    }

    // Show Kelas Yang Diajar
    public function guruKelasDiajar()
    {
        $user = auth()->user();
        $kelasIds = GuruMapel::where('guru_id', $user->id)->pluck('kelas_id')->unique();
        $kelas = Kelas::whereIn('id', $kelasIds)->get();
        return view('guru.kelas.index', compact('kelas'));
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

        return view('guru.siswa.index', compact('siswas'));
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

        return view('guru.nilai.index', compact('guruMapels', 'siswas', 'nilaiSiswas'));
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

        return view('walikelas.kpi.index', compact('siswas', 'wA', 'wB', 'wC', 'wD'));
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
        return view('walikelas.evaluasi.index', compact('hasilBakat'));
    }

    // Show Wali Kelas Grafik Prestasi
    public function walikelasGrafik()
    {
        $user = auth()->user();
        $siswas = Siswa::where('walikelas_id', $user->id)->pluck('id')->toArray();
        $penilaians = Penilaian::with('siswa')->whereIn('siswa_id', $siswas)->get();
        return view('walikelas.grafik.index', compact('penilaians'));
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
