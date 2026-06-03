<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    private function checkRole()
    {
        $user = auth()->user();
        $aksesRole = $user->akses_role;
        // Admin lama (role='admin') atau admin baru (role='pegawai', jabatan='admin')
        if ($aksesRole !== 'admin' && $user->role !== 'admin') {
            abort(403, 'Akses hanya untuk Admin.');
        }
    }

    // List unverified users (all roles)
    public function index()
    {
        $this->checkRole();

        $users = User::where('is_verified', false)
            ->orderByRaw("FIELD(role, 'guru', 'pegawai', 'siswa')")
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.verify_users', compact('users'));
    }

    // Verify a user
    public function verify(Request $request, $id)
    {
        $this->checkRole();

        $user = User::findOrFail($id);

        if ($user->role === 'siswa') {
            $user->update([
                'is_verified' => true,
                'role' => 'siswa',
                'jabatan' => null
            ]);
        } else {
            $request->validate([
                'jabatan' => 'required|in:guru_mapel,wali_kelas,guru_bk,wakasiswa,kepala_sekolah,admin,humas,anggota_kepsek,tu',
            ], [
                'jabatan.required' => 'Jabatan wajib diisi.',
                'jabatan.in' => 'Jabatan tidak valid.',
            ]);

            $chosen = $request->input('jabatan');

            if (in_array($chosen, ['guru_mapel', 'wali_kelas', 'guru_bk'])) {
                $role = 'guru';
                $jabatan = $chosen;
            } else {
                $role = 'pegawai';
                $jabatan = $chosen;
            }

            $user->update([
                'is_verified' => true,
                'role' => $role,
                'jabatan' => $jabatan
            ]);
        }

        $roleName = match($user->role) {
            'siswa' => 'Siswa',
            'guru' => 'Guru',
            'pegawai' => 'Pegawai',
            default => 'Pengguna'
        };

        return redirect()->back()->with('success', "Akun {$roleName} atas nama \"{$user->name}\" berhasil diverifikasi!");
    }

    // Reject / delete a user registration
    public function reject($id)
    {
        $this->checkRole();

        $user = User::findOrFail($id);
        $nama = $user->name;
        $user->delete();

        return redirect()->back()->with('warning', "Pendaftaran atas nama \"{$nama}\" telah ditolak dan dihapus.");
    }
}
