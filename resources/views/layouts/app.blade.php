<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMPRES - Manajemen Prestasi')</title>
    <!-- Google Fonts: Inter & Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0f766e; /* Teal 700 */
            --primary-light: #14b8a6; /* Teal 500 */
            --secondary: #0f172a; /* Slate 900 */
            --bg-color: #f1f5f9; /* Slate 100 */
            --surface: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
            --sidebar-width: 280px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--secondary);
            color: #fff;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(0,0,0,0.1);
            transition: var(--transition);
        }

        .sidebar-header {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background: rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-light), #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }

        .sidebar-brand span {
            display: block; font-size: 11px; font-family: 'Inter', sans-serif;
            font-weight: 500; letter-spacing: 0; color: #94a3b8;
            -webkit-text-fill-color: initial; margin-top: 4px;
        }

        .sidebar-menu { padding: 20px 15px; flex: 1; overflow-y: auto; }

        .menu-label {
            font-size: 11px; text-transform: uppercase; color: #64748b;
            font-weight: 700; letter-spacing: 1px; margin: 15px 0 10px 15px;
        }

        .menu-item {
            display: flex; align-items: center; gap: 15px;
            padding: 12px 15px; color: #cbd5e1; text-decoration: none;
            border-radius: 10px; font-weight: 500; transition: var(--transition);
            margin-bottom: 5px;
        }

        .menu-item i { width: 20px; font-size: 18px; text-align: center; }
        .menu-item:hover { background: rgba(255,255,255,0.05); color: #fff; transform: translateX(5px); }
        .menu-item.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: #fff; box-shadow: 0 4px 15px rgba(20, 184, 166, 0.3);
        }

        .sidebar-footer { padding: 20px 15px; border-top: 1px solid rgba(255,255,255,0.05); }
        .logout-btn {
            display: flex; align-items: center; gap: 15px;
            padding: 12px 15px; color: #f87171; text-decoration: none;
            border-radius: 10px; font-weight: 500; transition: var(--transition);
        }
        .logout-btn i { width: 20px; font-size: 18px; text-align: center; }
        .logout-btn:hover { background: rgba(239, 68, 68, 0.1); color: #ef4444; transform: translateX(5px); }

        /* --- MAIN CONTENT --- */
        .main-wrapper { flex: 1; margin-left: var(--sidebar-width); display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            height: 80px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px; position: sticky; top: 0; z-index: 90;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .page-title { font-family: 'Poppins', sans-serif; font-size: 22px; font-weight: 700; color: var(--secondary); }

        .user-profile { display: flex; align-items: center; gap: 15px; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--secondary); }
        .user-role { font-size: 12px; color: var(--primary-light); font-weight: 600; text-transform: uppercase; }
        .avatar {
            width: 45px; height: 45px; border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            display: flex; align-items: center; justify-content: center; color: white;
            font-weight: 700; font-size: 18px; overflow: hidden;
            position: relative; cursor: pointer; transition: var(--transition);
        }
        .avatar img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .avatar-hover {
            position: absolute; inset: 0; background: rgba(0,0,0,0.5);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: var(--transition);
        }
        .avatar-hover i { color: white; font-size: 14px; }
        .avatar:hover .avatar-hover { opacity: 1; }

        .content { flex: 1; animation: fadeIn 0.5s ease; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 1024px) { .sidebar { transform: translateX(-100%); } .main-wrapper { margin-left: 0; } }
        
        /* Dropdown Styles */
        .dropdown-menu-box.show {
            display: flex !important;
        }
        .dropdown-trigger:hover {
            background: rgba(0, 0, 0, 0.03);
        }
        .btn-signout:hover {
            background: #f9fafb !important;
            border-color: #cbd5e1 !important;
            color: #111827 !important;
        }
        .dropdown-menu-box::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            border-left: 1px solid #e2e8f0;
            transform: rotate(45deg);
        }

        @stack('styles')
    </style>
</head>
<body>

    @php
        $user = auth()->user();
        if (!$user) {
            header('Location: /login');
            exit;
        }
        $roleName = match($user->akses_role) {
            'admin' => 'Administrator',
            'guru' => 'Guru Mata Pelajaran',
            'walikelas' => 'Wali Kelas',
            'wakasiswa' => 'Wakil Kesiswaan',
            'kepsek' => 'Kepala Sekolah',
            'siswa' => 'Siswa',
            'bk' => 'Guru BK (Bimbingan Konseling)',
            'humas' => 'Humas',
            'anggota_kepsek' => 'Anggota Kepsek',
            'tu' => 'Tata Usaha (TU)',
            default => 'Pengguna'
        };
        
        $unreadNotifCount = 0;
        if ($user && $user->akses_role === 'siswa') {
            $s_id = \App\Models\Siswa::where('nis', $user->username)->value('id');
            if ($s_id) {
                $unreadNotifCount = \App\Models\Notification::where('siswa_id', $s_id)->where('is_read', false)->count();
            }
        }
    @endphp

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">SIMPRES <span>SMK Negeri 1 Talamau</span></div>
        </div>

        <div class="sidebar-menu">
            @if($user->akses_role !== 'bk')
            <div class="menu-label">Menu Utama</div>
            <a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            @endif

            @if($user->akses_role == 'admin')
                <div class="menu-label">Master Data</div>
                <a href="/siswa" class="menu-item"><i class="fa-solid fa-users"></i> Data Siswa</a>
                <a href="/admin/guru" class="menu-item"><i class="fa-solid fa-chalkboard-teacher"></i> Data Guru</a>
                <a href="/admin/kelas" class="menu-item"><i class="fa-solid fa-school"></i> Data Kelas</a>
                <a href="/admin/mapel" class="menu-item"><i class="fa-solid fa-book"></i> Data Mata Pelajaran</a>
                <a href="/admin/user" class="menu-item"><i class="fa-solid fa-user-cog"></i> Data User</a>
                <a href="/admin/relasi" class="menu-item"><i class="fa-solid fa-link"></i> Relasi Guru & Mapel</a>
                
                <div class="menu-label">Verifikasi & Bobot</div>
                <a href="/admin/verifikasi-akun" class="menu-item"><i class="fa-solid fa-user-check"></i> Verifikasi Akun</a>
                <a href="/kategori" class="menu-item"><i class="fa-solid fa-layer-group"></i> Kategori Lomba</a>
                <a href="/penilaian/settings" class="menu-item"><i class="fa-solid fa-gears"></i> Kelola Bobot KPI</a>

                <div class="menu-label">Laporan & Keputusan</div>
                <a href="/admin/publikasi" class="menu-item"><i class="fa-solid fa-stamp"></i> Publikasi Siswa Berprestasi</a>
                <a href="/laporan" class="menu-item"><i class="fa-solid fa-file-pdf"></i> Laporan Sistem</a>

            @elseif($user->akses_role == 'guru')
                <div class="menu-label">FITUR GURU MAPEL</div>
                <a href="/guru/mapel" class="menu-item {{ request()->is('guru/mapel*') || request()->is('guru/kelas*') || request()->is('guru/siswa*') || request()->is('guru/nilai*') ? 'active' : '' }}"><i class="fa-solid fa-book-open"></i> Mata Pelajaran yang Diampu</a>

            @elseif($user->akses_role == 'walikelas')
                <!-- FITUR GURU MAPEL -->
                <div class="menu-label">FITUR GURU MAPEL</div>
                <a href="/guru/mapel" class="menu-item {{ request()->is('guru/mapel*') || request()->is('guru/kelas*') || request()->is('guru/siswa*') || request()->is('guru/nilai*') ? 'active' : '' }}"><i class="fa-solid fa-book-open"></i> Mata Pelajaran yang Diampu</a>
                
                <!-- TUGAS WALI KELAS -->
                <div class="menu-label">TUGAS WALI KELAS</div>
                <a href="/walikelas/siswa" class="menu-item"><i class="fa-solid fa-users"></i> Data Siswa Kelas</a>
                <a href="/walikelas/rapor" class="menu-item"><i class="fa-solid fa-file-invoice"></i> Rekap & Proses Rapor</a>
                <a href="/walikelas/rata-nilai" class="menu-item"><i class="fa-solid fa-chart-bar"></i> Rata-rata Nilai Kelas</a>
                <a href="/walikelas/prestasi-siswa" class="menu-item"><i class="fa-solid fa-award"></i> Prestasi Siswa Kelas</a>
                <a href="/walikelas/kpi" class="menu-item"><i class="fa-solid fa-calculator"></i> Input Nilai Rapor / Validasi</a>
                <a href="/walikelas/evaluasi" class="menu-item"><i class="fa-solid fa-diagnoses"></i> Analisis Bakat (SAW)</a>
                <a href="/walikelas/grafik" class="menu-item"><i class="fa-solid fa-chart-line"></i> Grafik Kinerja Kelas</a>
                <a href="/notifikasi" class="menu-item {{ request()->is('notifikasi*') ? 'active' : '' }}"><i class="fa-solid fa-paper-plane"></i> Kirim Notifikasi & Saran</a>

            @elseif($user->akses_role == 'wakasiswa')
                <div class="menu-label">Menu Wakil Kesiswaan</div>
                <a href="/wakasiswa/validasi" class="menu-item {{ request()->is('wakasiswa/validasi') ? 'active' : '' }}"><i class="fa-solid fa-check-double"></i> Validasi Prestasi</a>
                <a href="/wakasiswa/data-prestasi" class="menu-item {{ request()->is('wakasiswa/data-prestasi') ? 'active' : '' }}"><i class="fa-solid fa-medal"></i> Data Prestasi</a>
                <a href="/wakasiswa/riwayat-validasi" class="menu-item {{ request()->is('wakasiswa/riwayat-validasi') ? 'active' : '' }}"><i class="fa-solid fa-history"></i> Riwayat Validasi</a>
                <a href="/laporan" class="menu-item"><i class="fa-solid fa-file-pdf"></i> Laporan Prestasi</a>

            @elseif($user->akses_role == 'humas')
                <div class="menu-label">Menu Humas</div>
                <a href="/humas" class="menu-item {{ request()->is('humas') && !request()->is('humas/*') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a href="/humas/usulan" class="menu-item {{ request()->is('humas/usulan*') ? 'active' : '' }}"><i class="fa-solid fa-paper-plane"></i> Usulan Publikasi</a>
                <a href="/humas/riwayat" class="menu-item {{ request()->is('humas/riwayat*') ? 'active' : '' }}"><i class="fa-solid fa-history"></i> Riwayat Publikasi</a>
                <a href="/humas/prestasi" class="menu-item {{ request()->is('humas/prestasi*') ? 'active' : '' }}"><i class="fa-solid fa-award"></i> Data Prestasi Publikasi</a>
                <a href="/humas/laporan" class="menu-item {{ request()->is('humas/laporan*') ? 'active' : '' }}"><i class="fa-solid fa-file-pdf"></i> Laporan Publikasi</a>

            @elseif($user->akses_role == 'bk')
                <div class="menu-label">Menu Guru BK</div>
                <a href="/guru-bk" class="menu-item {{ request()->is('guru-bk') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a href="/guru-bk/monitoring" class="menu-item {{ request()->is('guru-bk/monitoring*') || request()->is('guru-bk/detail*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Monitoring Siswa</a>
                <a href="/guru-bk/pembinaan" class="menu-item {{ request()->is('guru-bk/pembinaan*') ? 'active' : '' }}"><i class="fa-solid fa-user-shield"></i> Pembinaan Siswa</a>
                <a href="/guru-bk/riwayat" class="menu-item {{ request()->is('guru-bk/riwayat*') ? 'active' : '' }}"><i class="fa-solid fa-history"></i> Riwayat Pembinaan</a>
                <a href="/guru-bk/bakat" class="menu-item {{ request()->is('guru-bk/bakat*') ? 'active' : '' }}"><i class="fa-solid fa-brain"></i> Bakat & Prestasi</a>

            @elseif($user->akses_role == 'siswa')
                <div class="menu-label">Menu Siswa</div>
                <a href="/dashboard" class="menu-item"><i class="fa-solid fa-user-circle"></i> Profil Saya</a>
                <a href="/prestasi/create" class="menu-item"><i class="fa-solid fa-plus-circle"></i> Input Prestasi Baru</a>
                <a href="/prestasi/riwayat" class="menu-item"><i class="fa-solid fa-award"></i> Prestasi Saya</a>
                <a href="/nilai-rapor" class="menu-item"><i class="fa-solid fa-school"></i> Nilai Rapor</a>
                <a href="/hasil-bakat" class="menu-item {{ request()->is('hasil-bakat') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i> KPI/SPI Saya</a>
                <a href="/siswa/bimbingan" class="menu-item {{ request()->is('siswa/bimbingan*') ? 'active' : '' }}"><i class="fa-solid fa-user-shield"></i> Bimbingan Konseling</a>
                <a href="/notifikasi/siswa" class="menu-item {{ request()->is('notifikasi/siswa') ? 'active' : '' }}"><i class="fa-solid fa-bell"></i> Notifikasi & Saran
                    @if($unreadNotifCount > 0)
                        <span style="background: #ef4444; color: white; border-radius: 50%; padding: 2px 7px; font-size: 10px; margin-left: auto; font-weight: 700;">{{ $unreadNotifCount }}</span>
                    @endif
                </a>
            @endif
        </div>
        @if(auth()->user()->akses_role === 'walikelas')
        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
        @endif
    </aside>

    <main class="main-wrapper">
        <header class="topbar">
            <div class="page-title">@yield('page_title', 'Dashboard')</div>
            <div class="user-profile" style="position: relative; cursor: pointer;" onclick="toggleUserDropdown(event)">
                <div class="user-info">
                    <div class="user-name" style="display: flex; align-items: center; gap: 6px;">
                        {{ $user->name }} 
                        <i class="fas fa-caret-down" style="font-size: 12px; color: var(--text-muted); transition: transform 0.2s;"></i>
                    </div>
                    <div class="user-role">{{ $roleName }}</div>
                </div>
                <div class="avatar" onclick="event.stopPropagation(); document.getElementById('topbar-upload-foto-layout').click()" title="Klik untuk mengubah foto profil">
                    @if($user->foto)
                        <img src="{{ asset('uploads/profil/' . $user->foto) }}" alt="Foto Profil">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                    <div class="avatar-hover">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <!-- Hidden Topbar Photo Upload Form -->
                <form id="topbar-foto-form-layout" action="{{ route('update-foto-profil') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <input type="file" id="topbar-upload-foto-layout" name="foto" accept="image/*" onchange="document.getElementById('topbar-foto-form-layout').submit()">
                </form>

                <!-- Dropdown Menu Box -->
                <div class="dropdown-menu-box" id="userDropdownMenu" style="display: none; position: absolute; right: 0; top: calc(100% + 15px); background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05); width: 320px; padding: 16px; z-index: 1000; align-items: center; justify-content: space-between; cursor: default;" onclick="event.stopPropagation()">
                    <span class="dropdown-user-name" style="font-size: 14px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;">{{ $user->name }}</span>
                    <a href="{{ route('logout') }}" class="btn-signout" onclick="event.preventDefault(); document.getElementById('dropdown-logout-form-layout').submit();">
                        Sign out
                    </a>
                    <form id="dropdown-logout-form-layout" action="{{ route('logout') }}" method="GET" style="display: none;">@csrf</form>
                </div>
            </div>
        </header>

        <div class="content">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
    <script>
        function toggleUserDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('userDropdownMenu');
            menu.classList.toggle('show');
        }

        // Close dropdown when clicking anywhere outside
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('userDropdownMenu');
            if (menu && menu.classList.contains('show')) {
                const trigger = document.querySelector('.user-profile');
                if (!menu.contains(e.target) && (!trigger || !trigger.contains(e.target))) {
                    menu.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>
