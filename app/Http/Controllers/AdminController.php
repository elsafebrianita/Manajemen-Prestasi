<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruMapel;
use App\Models\Siswa;
use App\Models\Penilaian;

class AdminController extends Controller
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
        return view('admin.guru', compact('gurus'));
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
        return view('admin.kelas', compact('kelas', 'gurus'));
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
        return view('admin.mapel', compact('mapels', 'totalGurus', 'totalKelas', 'totalRelasi'));
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
        return view('admin.relasi', compact('relasis', 'gurus', 'mapels', 'kelas'));
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
        return view('admin.user', compact('users'));
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
}
