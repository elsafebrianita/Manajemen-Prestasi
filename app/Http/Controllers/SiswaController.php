<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function processSiswaData($siswa)
    {
        // 1. Trim all fields to avoid leading/trailing whitespace bugs
        $siswa->nis = trim($siswa->nis);
        $siswa->nama = trim($siswa->nama);
        $siswa->jenis_kelamin = trim($siswa->jenis_kelamin);
        $siswa->kelas = trim($siswa->kelas);
        $siswa->jurusan = trim($siswa->jurusan);

        // 2. Reconstruct professional class name if it is simple "10", "11", "12" or similar
        $rawKelas = $siswa->kelas;
        $grade = 'X';
        if (str_starts_with($siswa->nis, '25')) {
            $grade = 'X';
        } elseif (str_starts_with($siswa->nis, '24')) {
            $grade = 'XI';
        } elseif (str_starts_with($siswa->nis, '23')) {
            $grade = 'XII';
        } elseif (str_contains($rawKelas, '10') || (str_starts_with($rawKelas, 'X') && !str_starts_with($rawKelas, 'XI') && !str_starts_with($rawKelas, 'XII'))) {
            $grade = 'X';
        } elseif (str_contains($rawKelas, '11') || str_starts_with($rawKelas, 'XI')) {
            $grade = 'XI';
        } elseif (str_contains($rawKelas, '12') || str_starts_with($rawKelas, 'XII')) {
            $grade = 'XII';
        }

        // Department abbreviation
        $jur = $siswa->jurusan;
        $dept = 'RPL';
        if (stripos($jur, 'Sepeda Motor') !== false) $dept = 'TSM';
        elseif (stripos($jur, 'Tanaman Perkebunan') !== false) $dept = 'ATP';
        elseif (stripos($jur, 'Ternak Unggas') !== false) $dept = 'ATU';
        elseif (stripos($jur, 'Pengolahan Hasil') !== false) $dept = 'APHP';
        elseif (stripos($jur, 'Komputer') !== false || stripos($jur, 'TKJ') !== false) $dept = 'TKJ';
        elseif (stripos($jur, 'Otomotif') !== false) $dept = 'TO';
        elseif (stripos($jur, 'Perangkat Lunak') !== false || stripos($jur, 'RPL') !== false) $dept = 'RPL';

        // Suffix / Class Number
        $suffix = '1';
        if (str_ends_with($rawKelas, '2')) {
            $suffix = '2';
        }

        // Combine into final professional class name
        $finalClass = "$grade $dept $suffix";
        $siswa->kelas = $finalClass;
        $siswa->save();

        // 3. Sync to Kelas table
        $kelasRecord = Kelas::firstOrCreate(['nama_kelas' => $finalClass]);
        
        $existingWaliId = Siswa::where('kelas_id', $kelasRecord->id)
            ->whereNotNull('walikelas_id')
            ->where('id', '!=', $siswa->id)
            ->value('walikelas_id');
            
        $updateData = ['kelas_id' => $kelasRecord->id];
        if ($existingWaliId && !$siswa->walikelas_id) {
            $updateData['walikelas_id'] = $existingWaliId;
        }
        $siswa->update($updateData);

        // 4. Ensure corresponding user account exists
        $user = User::where('username', $siswa->nis)->first();
        if (!$user) {
            User::create([
                'name' => $siswa->nama,
                'username' => $siswa->nis,
                'email' => $siswa->nis . '@example.com',
                'role' => 'siswa',
                'password' => Hash::make('password'),
                'is_verified' => true
            ]);
        } else {
            // Update name and role, but do not overwrite is_verified or email/password
            $user->update([
                'name' => $siswa->nama,
                'role' => 'siswa',
            ]);
        }
    }

    public function index()
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        
        // Sync and process all students on index view to automatically self-heal and repair all classes/user logins
        $siswas = Siswa::all();
        foreach ($siswas as $siswa) {
            $this->processSiswaData($siswa);
        }
        
        $data = Siswa::with('penilaian')->get();
        return view('admin.siswa.index', compact('data'));
    }

    public function create()
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        
        $siswa = Siswa::create($request->all());
        $this->processSiswaData($siswa);
        
        return redirect('/siswa')->with('success', 'Data berhasil disimpan dan disinkronisasikan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        $siswa = Siswa::find($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        $siswa = Siswa::find($id);
        $siswa->update($request->all());
        
        $this->processSiswaData($siswa);
        
        return redirect('/siswa')->with('success', 'Data berhasil diperbarui dan disinkronisasikan!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        $siswa = Siswa::find($id);
        
        // Delete corresponding user if exists
        if ($siswa) {
            User::where('username', $siswa->nis)->delete();
            $siswa->delete();
        }
        
        return redirect('/siswa');
    }

    public function template()
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_siswa.csv"',
        ];
        
        $content = "NIS,NAMA,JENIS_KELAMIN (L/P),KELAS,JURUSAN\n23.3022,RADITYA ELFANDRI,L,X RPL 2,Rekayasa Perangkat Lunak\n23.3023,RAHMAT AL IKHSAN,L,X RPL 1,Rekayasa Perangkat Lunak\n";
        
        return response($content, 200, $headers);
    }

    public function importForm()
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        return view('admin.siswa.import');
    }

    public function importExcel(Request $request)
    {
        if (auth()->user()->role != 'admin') return redirect('/dashboard')->with('error', 'Akses ditolak.');
        
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        
        if (($handle = fopen($file->getRealPath(), "r")) !== FALSE) {
            $isHeader = true;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // If it's semicolon separated, fgetcsv might fail. Let's handle both.
                if (count($data) == 1 && strpos($data[0], ';') !== false) {
                    $data = explode(';', $data[0]);
                }

                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }
                
                // Skip empty rows
                if (empty($data[0]) || empty($data[1])) continue;

                $siswa = Siswa::updateOrCreate(
                    ['nis' => trim($data[0])], // Acuan data utama adalah NIS
                    [
                        'nama' => trim($data[1]),
                        'jenis_kelamin' => trim($data[2] ?? 'L'),
                        'kelas' => trim($data[3] ?? 'X'),
                        'jurusan' => trim($data[4] ?? '-')
                    ]
                );

                $this->processSiswaData($siswa);
            }
            fclose($handle);
            return redirect('/siswa')->with('success', 'Data siswa berhasil diimport dari file CSV dan disinkronisasikan!');
        }

        return redirect()->back()->with('error', 'Gagal membaca file CSV.');
    }
}