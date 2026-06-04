<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan username (NIP/NISN), nama lengkap, atau email
        $user = \App\Models\User::where('username', $request->username)
            ->orWhere('name', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Username atau Password salah.',
            ])->onlyInput('username');
        }

        // Cek apakah user sudah terdaftar tapi belum diverifikasi admin
        if (Schema::hasColumn('users', 'is_verified') && !$user->is_verified) {
            return back()->withErrors([
                'username' => 'Terima kasih telah melakukan registrasi! Akun Anda akan diverifikasi terlebih dahulu. Tunggu dalam 1 × 24 jam / 1 hari kerja.',
            ])->onlyInput('username');
        }

        // Coba login menggunakan username (NIP/NISN) di database dan password input
        $credentials = [
            'username' => $user->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Simpan data login terakhir ke user
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            // Catat ke tabel login_logs
            \Illuminate\Support\Facades\DB::table('login_logs')->insert([
                'user_id'    => $user->id,
                'username'   => $user->username,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'login_at'   => now(),
            ]);

            return match($user->akses_role) {
                'bk'        => redirect()->route('guru-bk.dashboard'),
                'kepsek'    => redirect('/kepsek'),
                'siswa'     => redirect('/dashboard'),
                default     => redirect('/dashboard'),
            };
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->onlyInput('username');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Merge username and nip based on role category
        $username = '';
        $nip = null;
        if ($request->role_category === 'siswa') {
            $username = $request->nisn;
        } elseif ($request->role_category === 'pegawai') {
            $username = $request->nip;
            $nip = $request->nip;
        }

        $request->merge([
            'username' => $username,
            'nip' => $nip,
        ]);

        // Find existing user to claim/update (to prevent duplicate accounts)
        $existingUser = \App\Models\User::where('username', $username)->first();
        
        if (!$existingUser && $nip) {
            $existingUser = \App\Models\User::where('username', $nip)
                ->orWhere('nip', $nip)
                ->first();
        }
        
        if (!$existingUser) {
            // Check by lowercase name match (imported name without spaces)
            $importedUsernameCheck = strtolower(str_replace(' ', '', $request->nama));
            $existingUser = \App\Models\User::where('username', $importedUsernameCheck)->first();
        }

        if ($existingUser) {
            // Check if password is the default 'password'
            if (!\Illuminate\Support\Facades\Hash::check('password', $existingUser->password)) {
                // If not 'password', someone else already registered this account
                return back()->withErrors([
                    'username' => $request->role_category === 'siswa' ? 'NISN sudah terdaftar' : 'NIP sudah terdaftar'
                ])->withInput();
            }
        }

        $rules = [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . ($existingUser ? $existingUser->id : 'NULL'),
            'email' => 'nullable|email|unique:users,email,' . ($existingUser ? $existingUser->id : 'NULL'),
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'role_category' => 'required|in:siswa,pegawai',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($request->role_category === 'siswa') {
            $rules['nisn'] = 'required|string|max:50';
            $rules['kelas'] = 'required|string|max:50';
        } elseif ($request->role_category === 'pegawai') {
            $rules['nip'] = 'required|string|max:50';
        }

        $messages = [
            'nama.required' => 'Nama lengkap wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok',
            'role_category.required' => 'Jenis pengguna wajib dipilih',
            'username.unique' => $request->role_category === 'siswa' ? 'NISN sudah terdaftar' : 'NIP sudah terdaftar',
            'nisn.required' => 'NISN wajib diisi',
            'kelas.required' => 'Kelas wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'foto.required' => 'Foto profil wajib diunggah',
        ];

        $validated = $request->validate($rules, $messages);

        // Process upload foto
        $fotoName = $existingUser ? $existingUser->foto : null;
        if ($request->hasFile('foto')) {
            $fotoName = time().'_'.$request->foto->getClientOriginalName();
            $request->foto->move(public_path('uploads/profil'), $fotoName);
        }

        if ($existingUser) {
            // Update existing user
            $existingUser->update([
                'name' => $validated['nama'],
                'email' => $validated['email'] ?? $existingUser->email,
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'role' => $validated['role_category'],
                'jabatan' => null, // Reset and let Admin assign it upon verification
                'nip' => $request->nip ?? $existingUser->nip,
                'foto' => $fotoName,
                'is_verified' => false, // Set to false to trigger admin verification
            ]);
            $user = $existingUser;
        } else {
            // Create User
            $user = \App\Models\User::create([
                'name' => $validated['nama'],
                'username' => $validated['username'],
                'email' => $validated['email'] ?? null,
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'role' => $validated['role_category'],
                'jabatan' => null, // Let Admin assign it upon verification
                'nip' => $request->nip,
                'foto' => $fotoName,
                'is_verified' => false,  // Semua role harus diverifikasi admin
            ]);
        }

        // Jika register sebagai siswa
        if ($validated['role_category'] === 'siswa') {
            $existingSiswa = \App\Models\Siswa::where('nis', $validated['username'])->first();
            if ($existingSiswa) {
                $existingSiswa->update([
                    'nama' => $validated['nama'],
                    'kelas' => $request->kelas ?? $existingSiswa->kelas,
                ]);
            } else {
                \App\Models\Siswa::create([
                    'nis' => $validated['username'],
                    'nama' => $validated['nama'],
                    'kelas' => $request->kelas ?? 'Belum Diisi',
                    'jurusan' => 'Belum Diisi',
                ]);
            }
        }

        return redirect()->route('login')->with('success', 'Terimakasih telah mendaftar. Akun Anda saat ini masih dalam proses verifikasi oleh admin. Silakan coba login kembali dalam 24 jam atau 1 hari kerja.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('logout_success', 'Anda telah berhasil keluar dari sistem.');
    }
}
