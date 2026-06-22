<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Notification;

class PrestasiController extends Controller
{
    //menampilkan daftar prestasi, jika siswa hanya menampilkan prestasi miliknya sendiri, jika admin/wakil kesiswaan menampilkan semua prestasi
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'siswa') {
            $siswa = \App\Models\Siswa::where('nis', $user->username)->first();
            if ($siswa) {
                $prestasi = Prestasi::with(['kategori'])->where('siswa_id', $siswa->id)->latest()->get();
            } else {
                $prestasi = collect(); // Empty collection
            }
        } else {
            $prestasi = Prestasi::with(['siswa', 'kategori'])->latest()->get();
        }
        
        return view('siswa.prestasi.index', compact('prestasi'));
    }
//menampilkan form tambah prestasi
    public function create()
    {
        $user = auth()->user();
        if ($user->role == 'siswa') {
            $siswa = \App\Models\Siswa::where('nis', $user->username)->first();
        } else {
            $siswa = \App\Models\Siswa::all();
        }
        $kategori_utama = \App\Models\KategoriPrestasi::whereNull('parent_id')->with('children')->get();
        return view('siswa.prestasi.create', compact('siswa', 'kategori_utama'));
    }
//menyimpan prestasi baru, request artinya wajib diisi, jika tidak akan error, lalu request->validate untuk validasi data yang masuk, jika tidak sesuai dengan rules yang ditentukan maka akan error, lalu jika validasi berhasil maka data akan disimpan ke database
    public function store(Request $request) 
    {
        if (auth()->user()->role == 'siswa') {
            $siswa_obj = \App\Models\Siswa::where('nis', auth()->user()->username)->first();
            if ($siswa_obj) {
                $request->merge(['siswa_id' => $siswa_obj->id]);
            }
        } else {
            if ($request->has('siswa_name')) {
                if (preg_match('/\(([^)]+)\)/', $request->siswa_name, $matches)) {
                    $nis = $matches[1];
                    $siswa_obj = \App\Models\Siswa::where('nis', $nis)->first();
                    if ($siswa_obj) {
                        $request->merge(['siswa_id' => $siswa_obj->id]);
                    }
                }
            }
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_prestasi' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_prestasi,id',
            'tingkat' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'juara' => 'required|string',
            'tanggal_capaian' => 'required|date',
            'sertifikat' => 'nullable|file|mimes:pdf|max:2048',
        ], [
            'sertifikat.mimes' => 'Bukti sertifikat harus berformat PDF saja.',
            'sertifikat.max' => 'Ukuran file sertifikat maksimal 2MB.',
        ]);

        $data = $request->all();
        
        // Handle Upload Sertifikat
        if ($request->hasFile('sertifikat')) {
            $file = $request->file('sertifikat');
            $filename = time() . '_' . $file->getClientOriginalName(); //rename file dengan timestamp agar unik
            $file->move(public_path('uploads/sertifikat'), $filename);
            $data['sertifikat'] = $filename;
        }

        // Set Status
        if (auth()->user()->role == 'siswa') {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'disetujui';
        }

        Prestasi::create($data); // Simpan data prestasi ke database

        if ($request->action == 'add_more') {
            return redirect('/prestasi/create')->with('success', 'Data berhasil disimpan! Silakan masukkan prestasi berikutnya.');
        }

        return redirect('/prestasi')->with('success', 'Capaian prestasi berhasil diajukan! Menunggu verifikasi sekolah.');
    }

    public function riwayat(Request $request) // Menampilkan riwayat prestasi milik siswa yang sedang login
    {
        $user = auth()->user();
        if ($user->role !== 'siswa') {
            return redirect('/prestasi')->with('error', 'Hanya siswa yang dapat melihat halaman riwayat prestasi.');
        }

        $siswa = \App\Models\Siswa::where('nis', $user->username)->first();
        if (! $siswa) {
            return redirect('/dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        $status = $request->query('status');
        $prestasiQuery = Prestasi::with('kategori')->where('siswa_id', $siswa->id)->latest();

        if (in_array($status, ['pending', 'disetujui', 'ditolak'])) {
            $prestasiQuery->where('status', $status);
        } else {
            $status = '';
        }

        $my_prestasi = $prestasiQuery->get(); // Ambil data prestasi sesuai filter status
        $my_notifications = Notification::where('siswa_id', $siswa->id)->with('sender')->latest()->take(5)->get();

        return view('siswa.prestasi.riwayat', compact('my_prestasi', 'my_notifications', 'status', 'siswa'));
    }
//verifikasi prestasi oleh wakil kesiswaan atau admin, request->status adalah status yang dipilih (disetujui/ditolak), request->keterangan adalah keterangan tambahan dari wakil kesiswaan atau admin, lalu data prestasi akan diupdate sesuai dengan id yang dipilih
    public function verifikasi(Request $request, $id)
    {
        if (!in_array(auth()->user()->akses_role, ['admin', 'wakasiswa'])) {
            return redirect()->back()->with('error', 'Hanya Wakil Kesiswaan atau Admin yang dapat memvalidasi prestasi.');
        }

        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update([
            'status' => $request->status, // disetujui / ditolak
            'keterangan' => $request->keterangan
        ]);

        // Auto-recalculate KPI for the student
        \App\Models\Penilaian::kalkulasiKpiSiswa($prestasi->siswa_id);

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

    public function edit($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        
        // Proteksi: Siswa tidak boleh edit jika sudah disetujui
        if (auth()->user()->role == 'siswa' && $prestasi->status == 'disetujui') {
            return redirect('/prestasi')->with('error', 'Data yang sudah disetujui tidak dapat diubah.');
        }

        if (auth()->user()->role == 'siswa') {
            $siswa = \App\Models\Siswa::where('nis', auth()->user()->username)->first();
        } else {
            $siswa = \App\Models\Siswa::all();
        }
        $kategori_utama = \App\Models\KategoriPrestasi::whereNull('parent_id')->with('children')->get();
        
        return view('siswa.prestasi.edit', compact('prestasi', 'siswa', 'kategori_utama'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role == 'siswa') {
            $siswa_obj = \App\Models\Siswa::where('nis', auth()->user()->username)->first();
            if ($siswa_obj) {
                $request->merge(['siswa_id' => $siswa_obj->id]);
            }
        } else {
            if ($request->has('siswa_name')) {
                if (preg_match('/\(([^)]+)\)/', $request->siswa_name, $matches)) {
                    $nis = $matches[1];
                    $siswa_obj = \App\Models\Siswa::where('nis', $nis)->first();
                    if ($siswa_obj) {
                        $request->merge(['siswa_id' => $siswa_obj->id]);
                    }
                }
            }
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_prestasi' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_prestasi,id',
            'tingkat' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'juara' => 'required|string',
            'tanggal_capaian' => 'required|date',
            'sertifikat' => 'nullable|file|mimes:pdf|max:2048',
        ], [
            'sertifikat.mimes' => 'Bukti sertifikat harus berformat PDF saja.',
            'sertifikat.max' => 'Ukuran file sertifikat maksimal 2MB.',
        ]);

        $prestasi = Prestasi::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('sertifikat')) {
            $file = $request->file('sertifikat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/sertifikat'), $filename);
            $data['sertifikat'] = $filename;
        }

        // Reset ke pending jika siswa yang edit (setelah ditolak)
        if (auth()->user()->role == 'siswa') {
            $data['status'] = 'pending';
        }

        $prestasi->update($data);

        // Auto-recalculate KPI
        \App\Models\Penilaian::kalkulasiKpiSiswa($prestasi->siswa_id);

        return redirect('/prestasi')->with('success', 'Data prestasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $siswaId = $prestasi->siswa_id;
        $prestasi->delete();
        
        // Auto-recalculate KPI
        \App\Models\Penilaian::kalkulasiKpiSiswa($siswaId);
        
        return redirect('/prestasi')->with('success', 'Data prestasi telah dihapus.');
    }

    public function showDetailSiswa($id)
    {
        $prestasi = Prestasi::findOrFail($id);
    return view('siswa.prestasi.detail', compact('prestasi'));
    }
    
}