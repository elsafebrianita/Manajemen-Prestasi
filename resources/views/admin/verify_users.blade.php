@extends('layouts.app')

@section('title', 'Verifikasi Akun Pengguna - SIMPRES')
@section('page_title', 'Verifikasi Akun Baru')

@section('content')
<div style="padding: 30px;">

    @if(session('success'))
        <div style="background:#d1fae5; border-left:4px solid #10b981; padding:15px 20px; border-radius:10px; margin-bottom:20px; color:#065f46; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div style="background:#fef3c7; border-left:4px solid #f59e0b; padding:15px 20px; border-radius:10px; margin-bottom:20px; color:#92400e; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
        </div>
    @endif

    <div style="background:white; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,0.05); overflow:hidden;">
        <div style="padding:25px 30px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h3 style="margin:0; font-size:18px; font-weight:700; color:#0f172a;">Daftar Pendaftaran Menunggu Verifikasi</h3>
                <p style="margin:4px 0 0; font-size:13px; color:#64748b;">Semua pengguna yang mendaftar via form register akan muncul di sini sebelum bisa login.</p>
            </div>
            <span style="background:#fef3c7; color:#92400e; font-size:12px; font-weight:700; padding:6px 14px; border-radius:20px;">
                {{ $users->count() }} Menunggu
            </span>
        </div>

        @if($users->isEmpty())
            <div style="padding:60px; text-align:center; color:#94a3b8;">
                <i class="fas fa-check-circle" style="font-size:48px; margin-bottom:15px; color:#10b981;"></i>
                <h4 style="margin:0 0 8px; color:#475569;">Semua Bersih!</h4>
                <p style="margin:0; font-size:14px;">Tidak ada akun yang menunggu verifikasi saat ini.</p>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8fafc; text-align:left;">
                            <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700; letter-spacing:0.5px;">Nama Lengkap</th>
                            <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700;">Username</th>
                            <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700;">Jenis Pengguna</th>
                            <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700;">Status</th>
                            <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700;">Role / Jabatan</th>
                            <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700;">NIP / NISN</th>
                            <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700;">Mendaftar</th>
                            <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            <tr style="border-bottom:1px solid #f8fafc;">
                                <td style="padding:16px 20px;">
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        @if($u->foto)
                                            <img src="{{ asset('uploads/profil/' . $u->foto) }}" style="width:38px;height:38px;border-radius:10px;object-fit:cover;">
                                        @else
                                            <div style="width:38px;height:38px;background:linear-gradient(135deg,#14b8a6,#0f766e);border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:15px;">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight:700; color:#0f172a; font-size:14px;">{{ $u->name }}</div>
                                            <div style="font-size:11px; color:#94a3b8;">{{ $u->email ?? 'Tidak ada email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding:16px 20px; font-family:monospace; font-size:13px; color:#475569;">{{ $u->username }}</td>
                                <td style="padding:16px 20px;">
                                    <span style="background:{{ $u->role === 'siswa' ? '#eff6ff' : '#f0fdf4' }}; color:{{ $u->role === 'siswa' ? '#2563eb' : '#16a34a' }}; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px;">
                                        {{ $u->role === 'siswa' ? 'Siswa' : 'Pegawai / Guru' }}
                                    </span>
                                </td>
                                <td style="padding:16px 20px;">
                                    <span style="background:#fee2e2; color:#ef4444; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px;">
                                        Pending
                                    </span>
                                </td>
                                <td style="padding:16px 20px;">
                                    @if($u->role === 'siswa')
                                        <span style="font-size:13px; color:#475569; font-weight:600;">Siswa</span>
                                    @else
                                        <select name="jabatan" id="select-jabatan-{{ $u->id }}" form="verify-form-{{ $u->id }}" style="padding:8px 12px; border:2px solid #D0F0ED; border-radius:8px; font-size:13px; font-family:inherit; background:#F0F9F8; color:#0F7860; font-weight:600; cursor:pointer;" required>
                                            <option value="">-- Pilih Jabatan --</option>
                                            <option value="guru_mapel">Guru Mapel</option>
                                            <option value="wali_kelas">Wali Kelas</option>
                                            <option value="guru_bk">Guru BK</option>
                                            <option value="wakasiswa">Wakasiswa</option>
                                            <option value="humas">Humas</option>
                                            <option value="kepala_sekolah">Kepala Sekolah</option>
                                            <option value="anggota_kepsek">Anggota Kepsek</option>
                                            <option value="tu">Tata Usaha (TU)</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    @endif
                                </td>
                                <td style="padding:16px 20px; font-size:13px; color:#475569; font-family:monospace;">
                                    {{ $u->role === 'siswa' ? $u->username : ($u->nip ?? '-') }}
                                </td>
                                <td style="padding:16px 20px; font-size:12px; color:#94a3b8;">{{ $u->created_at->diffForHumans() }}</td>
                                <td style="padding:16px 20px; text-align:center;">
                                    <div style="display:flex; gap:8px; justify-content:center;">
                                        <form action="/admin/verifikasi-akun/{{ $u->id }}" method="POST" id="verify-form-{{ $u->id }}" style="display:inline">
                                            @csrf
                                            <button type="submit" style="background:#10b981; color:white; border:none; padding:8px 16px; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;" onclick="return confirmVerification({{ $u->id }}, '{{ $u->name }}', '{{ $u->role }}')">
                                                <i class="fas fa-check"></i> Verifikasi
                                            </button>
                                        </form>
                                        <form action="/admin/verifikasi-akun/{{ $u->id }}/tolak" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:#fee2e2; color:#ef4444; border:none; padding:8px 16px; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;" onclick="return confirm('Tolak & hapus pendaftaran {{ $u->name }}? Aksi ini tidak bisa dibatalkan.')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
    function confirmVerification(userId, name, role) {
        if (role !== 'siswa') {
            const selectEl = document.getElementById('select-jabatan-' + userId);
            if (!selectEl || !selectEl.value) {
                alert('Silakan pilih jabatan untuk ' + name + ' terlebih dahulu sebelum verifikasi!');
                return false;
            }
        }
        return confirm('Verifikasi akun ' + name + '?');
    }
</script>
@endsection
