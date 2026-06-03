<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIMPRES</title>
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

        .content { padding: 40px; flex: 1; animation: fadeIn 0.5s ease; }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--secondary) 0%, #1e293b 100%);
            border-radius: 20px; padding: 35px 40px; color: white;
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 40px; position: relative; overflow: hidden;
        }
        .welcome-banner::after {
            content: '\f091'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
            position: absolute; right: 40px; font-size: 120px; color: rgba(255,255,255,0.03); transform: rotate(-15deg);
        }
        .welcome-text h2 { font-family: 'Poppins', sans-serif; font-size: 28px; margin-bottom: 8px; }
        .welcome-text p { color: #94a3b8; font-size: 15px; max-width: 500px; line-height: 1.6; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .stat-card {
            background: var(--surface); padding: 25px; border-radius: 20px;
            display: flex; align-items: flex-start; justify-content: space-between;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: var(--transition);
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); }
        .stat-info h3 { font-size: 36px; font-weight: 800; color: var(--secondary); font-family: 'Poppins', sans-serif; }
        .stat-icon { width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .icon-blue { background: #eff6ff; color: #3b82f6; }
        .icon-green { background: #ecfdf5; color: #10b981; }
        .icon-purple { background: #f5f3ff; color: #8b5cf6; }
        .icon-orange { background: #fffbeb; color: #f59e0b; }

        .quick-actions { background: var(--surface); padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .action-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .action-card {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 15px; padding: 30px 20px; background: var(--bg-color); border-radius: 16px;
            text-decoration: none; color: var(--text-main); font-weight: 600; transition: var(--transition);
        }
        .action-card:hover { background: #fff; border: 1px solid var(--primary-light); color: var(--primary); transform: translateY(-3px); }
        .action-card i { font-size: 28px; color: var(--primary-light); }

        /* Custom styles for interactive teacher mapel tabs & quick grades input */
        .guru-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            overflow-x: auto;
            padding-bottom: 5px;
        }
        .guru-tab-btn {
            background: #e2e8f0;
            border: 1px solid #cbd5e1;
            padding: 10px 20px;
            border-radius: 12px;
            color: var(--text-main);
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .guru-tab-btn:hover {
            background: #cbd5e1;
        }
        .guru-tab-btn.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.2);
        }
        .guru-tab-content {
            display: none;
        }
        .guru-tab-content.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }
        .input-nilai-quick {
            width: 70px;
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            text-align: center;
            font-weight: 700;
            outline: none;
            transition: var(--transition);
        }
        .input-nilai-quick:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 1024px) { .sidebar { transform: translateX(-100%); } .main-wrapper { margin-left: 0; } }
    </style>
</head>
<body>

    @php
        $user = auth()->user();
        // Kepsek punya halaman sendiri
        if ($user->akses_role === 'kepsek') {
            header('Location: /kepsek');
            exit;
        }
        // BK punya halaman sendiri
        if ($user->akses_role === 'bk') {
            header('Location: /guru-bk');
            exit;
        }
        $roleName = match($user->akses_role) {
            'admin' => 'Administrator',
            'guru' => 'Guru Mata Pelajaran',
            'walikelas' => 'Wali Kelas',
            'wakasiswa' => 'Wakil Kesiswaan',
            'kepsek' => 'Kepala Sekolah',
            'siswa' => 'Siswa',
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
            <div class="menu-label">Menu Utama</div>
            <a href="/dashboard" class="menu-item active"><i class="fa-solid fa-house"></i> Dashboard</a>

            @if($user->akses_role == 'admin')
                {{-- ===== ADMIN SIDEBAR ===== --}}
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
                {{-- ===== GURU SIDEBAR ===== --}}
                <div class="menu-label">Menu Guru</div>
                <a href="/guru/mapel" class="menu-item"><i class="fa-solid fa-book-open"></i> Mata Pelajaran Saya</a>
                <a href="/guru/kelas" class="menu-item"><i class="fa-solid fa-chalkboard-teacher"></i> Kelas Yang Diajar</a>
                <a href="/guru/siswa" class="menu-item"><i class="fa-solid fa-user-graduate"></i> Daftar Siswa</a>
                <a href="/guru/nilai" class="menu-item"><i class="fa-solid fa-edit"></i> Input Nilai</a>

            @elseif($user->akses_role == 'walikelas')
                {{-- ===== WALI KELAS SIDEBAR ===== --}}
                <div class="menu-label">Menu Wali Kelas</div>
                <a href="/walikelas/siswa" class="menu-item"><i class="fa-solid fa-users"></i> Data Siswa Kelas</a>
                <a href="/walikelas/kpi" class="menu-item"><i class="fa-solid fa-calculator"></i> Analisis KPI/SPI</a>
                <a href="/walikelas/evaluasi" class="menu-item"><i class="fa-solid fa-diagnoses"></i> Hasil Evaluasi Siswa</a>
                <a href="/walikelas/grafik" class="menu-item"><i class="fa-solid fa-chart-line"></i> Grafik Prestasi</a>
                <a href="/notifikasi" class="menu-item"><i class="fa-solid fa-paper-plane"></i> Kirim Notifikasi & Saran</a>
                <a href="/laporan" class="menu-item"><i class="fa-solid fa-file-pdf"></i> Laporan</a>

            @elseif($user->akses_role == 'wakasiswa')
                {{-- ===== WAKIL KESISWAAN SIDEBAR ===== --}}
                <div class="menu-label">Menu Wakil Kesiswaan</div>
                <a href="/wakasiswa/validasi" class="menu-item"><i class="fa-solid fa-check-double"></i> Validasi Prestasi</a>
                <a href="/wakasiswa/data-prestasi" class="menu-item"><i class="fa-solid fa-medal"></i> Data Prestasi</a>
                <a href="/wakasiswa/riwayat-validasi" class="menu-item"><i class="fa-solid fa-history"></i> Riwayat Validasi</a>
                <a href="/laporan" class="menu-item"><i class="fa-solid fa-file-pdf"></i> Laporan Prestasi</a>

            @elseif($user->akses_role == 'siswa')
                <div class="menu-label">Menu Siswa</div>
                <a href="/dashboard" class="menu-item active"><i class="fa-solid fa-user-circle"></i> Profil Saya</a>
                <a href="/prestasi/create" class="menu-item"><i class="fa-solid fa-plus-circle"></i> Input Prestasi Baru</a>
                <a href="/prestasi/riwayat" class="menu-item"><i class="fa-solid fa-award"></i> Riwayat & Status</a>
                <a href="/nilai-rapor" class="menu-item"><i class="fa-solid fa-school"></i> Nilai Rapor</a>
                <a href="/hasil-bakat" class="menu-item"><i class="fa-solid fa-chart-pie"></i> Capaian & Bakat</a>
                <a href="/notifikasi/siswa" class="menu-item"><i class="fa-solid fa-bell"></i> Notifikasi & Saran
                    @if($unreadNotifCount > 0)
                        <span style="background: #ef4444; color: white; border-radius: 50%; padding: 2px 7px; font-size: 10px; margin-left: auto; font-weight: 700;">{{ $unreadNotifCount }}</span>
                    @endif
                </a>
            @endif
        </div>

        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="menu-item" style="color: #ef4444;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">@csrf</form>
        </div>
    </aside>

    <main class="main-wrapper">
        <header class="topbar">
            <div class="page-title">Dashboard</div>
            <div class="user-profile">
                <div class="user-info">
                    <div class="user-name">{{ $user->name }}</div>
                    <div class="user-role">{{ $roleName }}</div>
                </div>
                <div class="avatar" onclick="document.getElementById('topbar-upload-foto').click()" title="Klik untuk mengubah foto profil">
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
                <form id="topbar-foto-form" action="{{ route('update-foto-profil') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <input type="file" id="topbar-upload-foto" name="foto" accept="image/*" onchange="document.getElementById('topbar-foto-form').submit()">
                </form>
            </div>
        </header>

        <div class="content">
            <div class="welcome-banner">
                <div class="welcome-text">
                    <h2>Selamat Datang, {{ $user->name }}! 👋</h2>
                    <p>Sistem Informasi Manajemen Prestasi & Bakat Siswa Berbasis KPI. Kelola dan pantau capaian terbaik siswa dalam satu platform terintegrasi.</p>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #ecfdf5; color: #059669; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; display: flex; align-items: center; gap: 12px; border-left: 5px solid #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #fef2f2; color: #dc2626; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; display: flex; flex-direction: column; gap: 8px; border-left: 5px solid #ef4444; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-exclamation-circle"></i> <span>Terdapat beberapa kesalahan:</span>
                    </div>
                    <ul style="margin-left: 32px; font-weight: 500; font-size: 13px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!$user->foto)
                <div onclick="document.getElementById('quick-upload-foto').click()" style="background: #e6f7ff; border: 1px solid #91d5ff; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; gap: 15px; flex-wrap: wrap; box-shadow: 0 4px 12px rgba(24, 144, 255, 0.05); cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#d6e4ff'" onmouseout="this.style.background='#e6f7ff'" title="Klik untuk mengunggah foto profil">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: #e6f7ff; color: #1890ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; border: 1px solid #91d5ff;">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div>
                            <strong style="color: #0050b3; font-size: 14px; display: block;">Lengkapi Profil Anda</strong>
                            <span style="color: #0050b3; font-size: 12px;">Anda belum mengunggah foto profil. Silakan klik di sini untuk mengunggah foto profil Anda.</span>
                        </div>
                    </div>
                    <form id="quick-foto-form" action="{{ route('update-foto-profil') }}" method="POST" enctype="multipart/form-data" style="margin: 0;" onclick="event.stopPropagation();">
                        @csrf
                        <input type="file" id="quick-upload-foto" name="foto" accept="image/*" onchange="document.getElementById('quick-foto-form').submit()" style="display: none;">
                        <button type="button" style="background: #1890ff; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.3s; margin: 0;">
                            <i class="fas fa-upload"></i> Pilih & Unggah Foto
                        </button>
                    </form>
                </div>
            @endif

            <!-- STAFF DASHBOARD -->
            @if(in_array($user->akses_role, ['admin', 'staf', 'wakasiswa']))
                <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; margin-bottom: 30px;">
                    <!-- LEFT: NOTIFICATIONS -->
                    <div style="background: white; padding: 25px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(38, 129, 125, 0.1);">
                        <h3 style="font-size: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: var(--primary-teal);">
                            <i class="fas fa-bell"></i> Notifikasi & Aktivitas Siswa
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @forelse($recent_activities as $act)
                                <div style="display: flex; align-items: center; gap: 15px; padding: 12px; background: #f8fafc; border-radius: 15px; border-left: 4px solid {{ $act->status == 'pending' ? '#f59e0b' : '#10b981' }};">
                                    <div style="width: 40px; height: 40px; background: {{ $act->status == 'pending' ? '#fff7ed' : '#f0fdf4' }}; color: {{ $act->status == 'pending' ? '#f59e0b' : '#10b981' }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                        <i class="fas {{ $act->status == 'pending' ? 'fa-clock' : 'fa-check-circle' }}"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span style="font-weight: 700; font-size: 13px;">{{ $act->siswa->nama }}</span>
                                            <small style="color: #94a3b8; font-size: 10px;">{{ $act->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p style="font-size: 12px; color: #64748b; margin-top: 2px;">Mengajukan prestasi: <strong>{{ $act->nama_prestasi }}</strong></p>
                                    </div>
                                    @if($act->status == 'pending')
                                        <a href="/prestasi" style="font-size: 11px; font-weight: 700; color: #f59e0b; text-decoration: none;">Verifikasi</a>
                                    @endif
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: #94a3b8; font-size: 13px;">Belum ada aktivitas terbaru.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- RIGHT: PENDING VERIFICATION ALERT -->
                    <div>
                        @if($total_pending > 0)
                            <div style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 25px; border-radius: 25px; box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2);">
                                <h4 style="margin-bottom: 10px;"><i class="fas fa-exclamation-circle"></i> Butuh Verifikasi</h4>
                                <p style="font-size: 13px; opacity: 0.9; margin-bottom: 20px;">Ada <strong>{{ $total_pending }}</strong> data prestasi yang belum divalidasi oleh Anda.</p>
                                <a href="/prestasi" style="display: block; background: white; color: #f59e0b; text-align: center; padding: 12px; border-radius: 12px; text-decoration: none; font-weight: 800; font-size: 12px;">Buka Halaman Verifikasi</a>
                            </div>
                        @else
                            <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 25px; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);">
                                <h4 style="margin-bottom: 10px;"><i class="fas fa-check-circle"></i> Data Aman</h4>
                                <p style="font-size: 13px; opacity: 0.9;">Semua pengajuan prestasi siswa telah selesai diverifikasi.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $total_siswa ?? 0 }}</h3><p>Total Siswa</p></div>
                        <div class="stat-icon icon-blue"><i class="fa-solid fa-user-graduate"></i></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $total_kelas ?? 0 }}</h3><p>Total Kelas</p></div>
                        <div class="stat-icon icon-purple"><i class="fa-solid fa-school"></i></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $total_prestasi ?? 0 }}</h3><p>Prestasi</p></div>
                        <div class="stat-icon icon-green"><i class="fa-solid fa-medal"></i></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $total_pending ?? 0 }}</h3><p>Perlu Verifikasi</p></div>
                        <div class="stat-icon icon-orange"><i class="fa-solid fa-clock"></i></div>
                    </div>
                </div>

                <div class="quick-actions" style="margin-bottom: 40px;">
                    <h3 class="section-title" style="margin-bottom: 20px;"><i class="fa-solid fa-bolt"></i> Akses Cepat Pegawai</h3>
                    <div class="action-grid">
                        <a href="/prestasi" class="action-card"><i class="fa-solid fa-check-double"></i><span>Verifikasi Prestasi</span></a>
                        <a href="/penilaian" class="action-card"><i class="fa-solid fa-edit"></i><span>Input Nilai KPI</span></a>
                        <a href="/kpi" class="action-card"><i class="fa-solid fa-chart-line"></i><span>Analisis KPI</span></a>
                        <a href="/laporan" class="action-card"><i class="fa-solid fa-file-pdf"></i><span>Cetak Laporan</span></a>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 40px;">
                    <!-- Tabel Siswa -->
                    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                        <h3 style="font-size: 18px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-users" style="color: var(--primary);"></i> Daftar Siswa & Hasil KPI
                        </h3>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">NAMA SISWA</th>
                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">KPI SCORE</th>
                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">BAKAT</th>
                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-align: center;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_siswa->take(10) as $s)
                                        <tr style="border-bottom: 1px solid #f8fafc;">
                                            <td style="padding: 15px 12px;">
                                                <div style="font-weight: 700; color: #1e293b;">{{ $s->nama }}</div>
                                                <div style="font-size: 10px; color: #94a3b8;">NIS: {{ $s->nis }} | Kelas: {{ $s->kelas }}</div>
                                            </td>
                                            <td style="padding: 15px 12px;">
                                                <span style="font-weight: 800; color: var(--primary);">{{ number_format($s->penilaian->kpi_score ?? 0, 1) }}</span>
                                            </td>
                                            <td style="padding: 15px 12px;">
                                                <span style="font-size: 11px; font-weight: 700; color: #64748b;">{{ $s->penilaian->bakat_dominan ?? '-' }}</span>
                                            </td>
                                            <td style="padding: 15px 12px; text-align: center;">
                                                <a href="/penilaian/show/{{ $s->id }}" style="color: var(--primary); font-size: 14px;"><i class="fas fa-arrow-right"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Grafik Distribusi -->
                    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                        <h3 style="font-size: 18px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-chart-pie" style="color: var(--primary);"></i> Sebaran Bakat
                        </h3>
                        <div style="height: 200px; display: flex; align-items: center; justify-content: center;">
                            <canvas id="bakatPieChart"></canvas>
                        </div>
                        
                        <h3 style="font-size: 16px; margin: 30px 0 15px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-crown" style="color: #f59e0b;"></i> Top Performers
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            @foreach(\App\Models\Penilaian::with('siswa')->orderBy('kpi_score', 'desc')->take(3)->get() as $idx => $p)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px; background: #f8fafc; border-radius: 12px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 25px; height: 25px; background: {{ $idx == 0 ? '#fef3c7' : '#e2e8f0' }}; color: {{ $idx == 0 ? '#92400e' : '#64748b' }}; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 10px;">
                                            {{ $idx + 1 }}
                                        </div>
                                        <span style="font-size: 12px; font-weight: 700;">{{ $p->siswa->nama ?? 'N/A' }}</span>
                                    </div>
                                    <span style="font-size: 11px; font-weight: 800; color: var(--primary);">{{ number_format($p->kpi_score, 1) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            <!-- GURU DASHBOARD -->
            @elseif($user->akses_role == 'guru')
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $my_kelas_count }}</h3><p>Kelas Diajar</p></div>
                        <div class="stat-icon icon-blue"><i class="fa-solid fa-school"></i></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $my_mapels->count() }}</h3><p>Mata Pelajaran</p></div>
                        <div class="stat-icon icon-green"><i class="fa-solid fa-book-open"></i></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $my_siswas_count }}</h3><p>Siswa Terdaftar</p></div>
                        <div class="stat-icon icon-purple"><i class="fa-solid fa-user-graduate"></i></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $my_nilai_count }}</h3><p>Nilai Diinput</p></div>
                        <div class="stat-icon icon-orange"><i class="fa-solid fa-file-invoice"></i></div>
                    </div>
                </div>

                @if(session('success'))
                    <div style="background: #ecfdf5; color: #059669; padding: 18px 24px; border-radius: 15px; margin-bottom: 30px; font-weight: 700; display: flex; align-items: center; gap: 12px; border-left: 5px solid #10b981;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 30px; margin-bottom: 40px;">
                    <!-- LEFT: INTERACTIVE GRADING TABS -->
                    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(0, 0, 0, 0.05);">
                        <h3 style="font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fas fa-edit" style="color: var(--primary);"></i> Input Nilai Siswa Cepat</span>
                        </h3>

                        @if(empty($mapel_kelas_data))
                            <div style="text-align: center; padding: 40px; color: #64748b;">
                                <div style="font-size: 48px; margin-bottom: 15px; color: #cbd5e1;"><i class="fas fa-calendar-times"></i></div>
                                <h4 style="font-weight: 700; color: var(--secondary); margin-bottom: 8px;">Jadwal Mengajar Kosong</h4>
                                <p style="font-size: 13px; max-width: 400px; margin: 0 auto;">Anda belum memiliki jadwal mata pelajaran/kelas yang diajar. Hubungi Admin untuk menghubungkan akun Anda dengan mata pelajaran & kelas.</p>
                            </div>
                        @else
                            <!-- Tab buttons -->
                            <div class="guru-tabs">
                                @foreach($mapel_kelas_data as $idx => $mk)
                                    <button class="guru-tab-btn {{ $idx == 0 ? 'active' : '' }}" onclick="switchGuruTab('tab-{{ $mk['relation']->id }}')">
                                        <i class="fas fa-graduation-cap"></i> {{ $mk['relation']->mapel->nama_mapel }} - {{ $mk['relation']->kelas->nama_kelas }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Tab contents -->
                            @foreach($mapel_kelas_data as $idx => $mk)
                                <div id="tab-{{ $mk['relation']->id }}" class="guru-tab-content {{ $idx == 0 ? 'active' : '' }}">
                                    <form action="/guru/nilai/store" method="POST">
                                        @csrf
                                        <input type="hidden" name="mapel_id" value="{{ $mk['relation']->mapel_id }}">
                                        <input type="hidden" name="guru_id" value="{{ $user->id }}">

                                        <div style="overflow-x: auto;">
                                            <table style="width: 100%; border-collapse: collapse;">
                                                <thead>
                                                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">NAMA SISWA</th>
                                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">NIS</th>
                                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-align: center; width: 130px;">NILAI AKADEMIK</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($mk['students'] as $student)
                                                        @php
                                                            $currentGrade = $mk['grades'][$student->id] ?? '';
                                                        @endphp
                                                        <tr style="border-bottom: 1px solid #f8fafc;">
                                                            <td style="padding: 12px;">
                                                                <div style="font-weight: 700; color: #1e293b;">{{ $student->nama }}</div>
                                                            </td>
                                                            <td style="padding: 12px;">
                                                                <code style="font-size: 12px; color: #64748b;">{{ $student->nis }}</code>
                                                            </td>
                                                            <td style="padding: 12px; text-align: center;">
                                                                <input type="number" name="nilai[{{ $student->id }}]" min="0" max="100" class="input-nilai-quick" value="{{ $currentGrade }}" placeholder="0">
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada siswa terdaftar di kelas ini.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        @if($mk['students']->isNotEmpty())
                                            <div style="margin-top: 25px; text-align: right;">
                                                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 13px; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px;">
                                                    <i class="fas fa-save"></i> Simpan Semua Nilai Kelas
                                                </button>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- RIGHT: RECENT ENTRIES -->
                    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                        <h3 style="font-size: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: var(--primary);">
                            <i class="fas fa-history"></i> Riwayat Input Terbaru
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @forelse($recent_grades as $rg)
                                <div style="display: flex; align-items: center; gap: 15px; padding: 12px; background: #f8fafc; border-radius: 15px;">
                                    <div style="width: 40px; height: 40px; background: #e0f2fe; color: #0284c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                                        {{ $rg->nilai }}
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 700; font-size: 12px; color: #1e293b;">{{ $rg->siswa->nama ?? 'N/A' }}</div>
                                        <div style="font-size: 10px; color: #64748b;">Mapel: {{ $rg->mapel->nama_mapel ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: #94a3b8; font-size: 12px;">Belum ada riwayat input.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

            <!-- WALI KELAS DASHBOARD -->
            @elseif($user->akses_role == 'walikelas')
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $walikelas_siswa_count }}</h3><p>Siswa Kelas Anda</p></div>
                        <div class="stat-icon icon-blue"><i class="fa-solid fa-users"></i></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info"><h3>{{ $walikelas_kpi_calculated }}</h3><p>KPI Sudah Kalkulasi</p></div>
                        <div class="stat-icon icon-green"><i class="fa-solid fa-calculator"></i></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>
                                @php
                                    $topSiswa = $walikelas_siswa_list->sortByDesc('penilaian.skor_akhir')->first();
                                    $topScore = $topSiswa->penilaian->skor_akhir ?? 0;
                                @endphp
                                {{ number_format($topScore * 100, 1) }}
                            </h3>
                            <p>Top KPI Kelas</p>
                        </div>
                        <div class="stat-icon icon-orange"><i class="fa-solid fa-crown"></i></div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 30px; margin-bottom: 40px;">
                    <!-- LEFT: SISWA KELAS LIST & RANKS -->
                    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                        <h3 style="font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                            <span><i class="fas fa-trophy" style="color: #f59e0b;"></i> Perangkingan KPI & Bakat Kelas</span>
                            <a href="/walikelas/kpi" class="btn btn-primary" style="padding: 8px 16px; font-size: 12px;"><i class="fas fa-calculator"></i> Input Nilai Rapor</a>
                        </h3>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">RANK</th>
                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">NAMA SISWA</th>
                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-align: center;">SKOR KPI</th>
                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">BAKAT DOMINAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($walikelas_siswa_list->sortByDesc('penilaian.skor_akhir')->take(8) as $idx => $s)
                                        <tr style="border-bottom: 1px solid #f8fafc;">
                                            <td style="padding: 15px 12px;">
                                                <span style="font-weight: 800; color: {{ $idx < 3 ? '#f59e0b' : '#64748b' }}; font-size: 15px;">#{{ $idx + 1 }}</span>
                                            </td>
                                            <td style="padding: 15px 12px;">
                                                <div style="font-weight: 700; color: #1e293b;">{{ $s->nama }}</div>
                                                <div style="font-size: 10px; color: #94a3b8;">NIS: {{ $s->nis }}</div>
                                            </td>
                                            <td style="padding: 15px 12px; text-align: center;">
                                                <span style="font-weight: 800; color: var(--primary); font-size: 14px;">
                                                    {{ number_format(($s->penilaian->skor_akhir ?? 0) * 100, 1) }}
                                                </span>
                                            </td>
                                            <td style="padding: 15px 12px;">
                                                <span style="font-size: 11px; font-weight: 700; color: #475569; background: #f1f5f9; padding: 4px 8px; border-radius: 6px;">
                                                    {{ $s->penilaian->bakat_dominan ?? 'Belum Kalkulasi' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada siswa terdaftar di kelas Anda.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- RIGHT: RECENT CLASS ACTIVITIES -->
                    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                        <h3 style="font-size: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: var(--primary);">
                            <i class="fas fa-award"></i> Prestasi Terbaru Kelas
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @forelse($walikelas_recent_achievements as $wra)
                                <div style="display: flex; align-items: center; gap: 15px; padding: 12px; background: #f8fafc; border-radius: 15px; border-left: 4px solid {{ $wra->status == 'pending' ? '#f59e0b' : '#10b981' }};">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 700; font-size: 12px; color: #1e293b;">{{ $wra->siswa->nama }}</div>
                                        <div style="font-size: 10px; color: #64748b; margin-top: 2px;">{{ $wra->nama_prestasi }}</div>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: #94a3b8; font-size: 12px;">Belum ada pengajuan prestasi terbaru.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- GURU MAPEL SECTION FOR WALI KELAS -->
                @if(isset($mapel_kelas_data) && !empty($mapel_kelas_data))
                    <div class="quick-actions" style="margin: 40px 0 20px 0;">
                        <h3 class="section-title" style="margin-bottom: 20px;"><i class="fa-solid fa-book-open"></i> Mata Pelajaran yang Diampu</h3>
                    </div>

                    <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 30px; margin-bottom: 40px;">
                        <!-- LEFT: INTERACTIVE GRADING TABS -->
                        <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(0, 0, 0, 0.05);">
                            <h3 style="font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                                <span><i class="fas fa-edit" style="color: var(--primary);"></i> Input Nilai Siswa Cepat</span>
                            </h3>

                            <!-- Tab buttons -->
                            <div class="guru-tabs">
                                @foreach($mapel_kelas_data as $idx => $mk)
                                    <button class="guru-tab-btn {{ $idx == 0 ? 'active' : '' }}" onclick="switchGuruTab('tab-{{ $mk['relation']->id }}')">
                                        <i class="fas fa-graduation-cap"></i> {{ $mk['relation']->mapel->nama_mapel }} - {{ $mk['relation']->kelas->nama_kelas }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Tab contents -->
                            @foreach($mapel_kelas_data as $idx => $mk)
                                <div id="tab-{{ $mk['relation']->id }}" class="guru-tab-content {{ $idx == 0 ? 'active' : '' }}">
                                    <form action="/guru/nilai/store" method="POST">
                                        @csrf
                                        <input type="hidden" name="mapel_id" value="{{ $mk['relation']->mapel_id }}">
                                        <input type="hidden" name="guru_id" value="{{ $user->id }}">

                                        <div style="overflow-x: auto;">
                                            <table style="width: 100%; border-collapse: collapse;">
                                                <thead>
                                                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">NAMA SISWA</th>
                                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8;">NIS</th>
                                                        <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-align: center; width: 130px;">NILAI AKADEMIK</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($mk['students'] as $student)
                                                        @php
                                                            $currentGrade = $mk['grades'][$student->id] ?? '';
                                                        @endphp
                                                        <tr style="border-bottom: 1px solid #f8fafc;">
                                                            <td style="padding: 12px;">
                                                                <div style="font-weight: 700; color: #1e293b;">{{ $student->nama }}</div>
                                                            </td>
                                                            <td style="padding: 12px;">
                                                                <code style="font-size: 12px; color: #64748b;">{{ $student->nis }}</code>
                                                            </td>
                                                            <td style="padding: 12px; text-align: center;">
                                                                <input type="number" name="nilai[{{ $student->id }}]" min="0" max="100" class="input-nilai-quick" value="{{ $currentGrade }}" placeholder="0">
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada siswa terdaftar di kelas ini.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        @if($mk['students']->isNotEmpty())
                                            <div style="margin-top: 25px; text-align: right;">
                                                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 13px; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px;">
                                                    <i class="fas fa-save"></i> Simpan Semua Nilai Kelas
                                                </button>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <!-- RIGHT: RECENT ENTRIES -->
                        <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                            <h3 style="font-size: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: var(--primary);">
                                <i class="fas fa-history"></i> Riwayat Input Terbaru
                            </h3>
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                @forelse($recent_grades as $rg)
                                    <div style="display: flex; align-items: center; gap: 15px; padding: 12px; background: #f8fafc; border-radius: 15px;">
                                        <div style="width: 40px; height: 40px; background: #e0f2fe; color: #0284c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                                            {{ $rg->nilai }}
                                        </div>
                                        <div style="flex: 1;">
                                            <div style="font-weight: 700; font-size: 12px; color: #1e293b;">{{ $rg->siswa->nama ?? 'N/A' }}</div>
                                            <div style="font-size: 10px; color: #64748b;">Mapel: {{ $rg->mapel->nama_mapel ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div style="text-align: center; padding: 20px; color: #94a3b8; font-size: 12px;">Belum ada riwayat input.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('bakatPieChart');
                    if(ctx) {
                        new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Akademik', 'Spesifik', 'Kepemimpinan', 'Seni/Olahraga'],
                                datasets: [{
                                    data: [
                                        {{ \App\Models\Penilaian::where('bakat_dominan', 'like', '%Akademik Umum%')->count() }},
                                        {{ \App\Models\Penilaian::where('bakat_dominan', 'like', '%Akademik Spesifik%')->count() }},
                                        {{ \App\Models\Penilaian::where('bakat_dominan', 'like', '%Kepemimpinan%')->count() }},
                                        {{ \App\Models\Penilaian::where('bakat_dominan', 'like', '%Seni%')->count() }}
                                    ],
                                    backgroundColor: ['#14b8a6', '#3b82f6', '#f59e0b', '#ec4899'],
                                    borderWidth: 0,
                                    hoverOffset: 10
                                }]
                            },
                            options: {
                                cutout: '70%',
                                plugins: {
                                    legend: { position: 'right', labels: { usePointStyle: true, font: { size: 11, family: 'Inter' } } }
                                }
                            }
                        });
                    }
                });
            </script>

            <!-- SISWA DASHBOARD -->
            @if($user->akses_role == 'siswa')
                <div style="display: grid; grid-template-columns: 1fr 2.5fr; gap: 30px;">
                    <div style="background: white; padding: 30px; border-radius: 25px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 30px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 42px; font-weight: 800; overflow: hidden;">
                            @if($user->foto)
                                <img src="{{ asset('uploads/profil/' . $user->foto) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <h2 style="font-size: 22px;">{{ $siswa_detail->nama ?? $user->name }}</h2>
                        <p style="color: var(--text-muted);">NIS: {{ $siswa_detail->nis ?? $user->username }}</p>
                        <p style="color: var(--primary); font-weight: 700; margin-top: 10px; margin-bottom: 15px;">{{ $siswa_detail->kelas ?? 'Siswa Aktif' }}</p>

                        <!-- Ganti Foto Profil Form -->
                        <form action="{{ route('update-foto-profil') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: center; gap: 8px; margin-bottom: 10px;">
                            @csrf
                            <label for="upload-foto-siswa" style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 5px; transition: 0.3s;">
                                <i class="fas fa-camera"></i> {{ $user->foto ? 'Ganti Foto Profil' : 'Unggah Foto Profil' }}
                            </label>
                            <input type="file" id="upload-foto-siswa" name="foto" accept="image/*" onchange="this.form.submit()" style="display: none;">
                        </form>

                        <!-- Tampilan Jabatan Organisasi -->
                        <div style="margin-top: 30px; padding-top: 25px; border-top: 1px solid #f1f5f9; text-align: left;">
                            <h4 style="font-size: 13px; color: var(--secondary); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-users"></i> Jabatan Organisasi & Kepemimpinan (C3)
                            </h4>
                            @php
                                $currentRoleLabel = 'Tidak Ada / Anggota';
                                $currentScore = $my_penilaian->c3 ?? 0;
                                if ($currentScore >= 95) $currentRoleLabel = 'Ketua';
                                elseif ($currentScore >= 90) $currentRoleLabel = 'Wakil Ketua';
                                elseif ($currentScore >= 88) $currentRoleLabel = 'Bendahara';
                                elseif ($currentScore >= 85) $currentRoleLabel = 'Sekretaris';
                                elseif ($currentScore >= 75) $currentRoleLabel = 'Anggota';
                            @endphp
                            <div style="margin-bottom: 15px;">
                                <label style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Jabatan Saat Ini</label>
                                <div style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 14px; font-weight: 700; margin-top: 5px; background-color: #f8fafc; color: var(--primary);">
                                    {{ $currentRoleLabel }} (Skor: {{ number_format($currentScore, 1) }})
                                </div>
                            </div>
                            <p style="font-size: 10px; color: #94a3b8; line-height: 1.4;">
                                *Pengajuan jabatan organisasi dilakukan melalui menu input prestasi dengan memilih kategori <strong>Organisasi</strong>.
                            </p>
                        </div>
                    </div>

                    <div>
                        <!-- FEEDBACK SECTION -->
                        @if(isset($my_notifications) && $my_notifications->count() > 0)
                            <div style="background: white; padding: 30px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 30px; border-left: 10px solid #f59e0b;">
                                <h3 style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-bell" style="color: #f59e0b;"></i> Feedback & Saran Guru
                                </h3>
                                @foreach($my_notifications as $n)
                                    @php 
                                        $bg = '#fef2f2'; $border = '#fecaca'; $color = '#dc2626'; $icon = 'exclamation-circle';
                                        if($n->type == 'Pertahankan') { $bg = '#f0fdf4'; $border = '#bbf7d0'; $color = '#16a34a'; $icon = 'check-circle'; }
                                        elseif($n->type == 'Cukup Baik') { $bg = '#fffbeb'; $border = '#fef3c7'; $color = '#d97706'; $icon = 'info-circle'; }
                                        elseif($n->type == 'Binaan BK' || $n->type == 'Bimbingan BK') { $bg = '#f0f9ff'; $border = '#bae6fd'; $color = '#0284c7'; $icon = 'user-shield'; }
                                    @endphp
                                    <div style="background: {{ $bg }}; border: 1px solid {{ $border }}; padding: 20px; border-radius: 20px; margin-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                                            <span style="font-weight: 800; color: {{ $color }}; font-size: 13px; text-transform: uppercase;">
                                                <i class="fas fa-{{ $icon }}"></i> {{ $n->type }}
                                            </span>
                                            <small style="color: #94a3b8;">{{ $n->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p style="font-size: 14px; color: #1e293b; line-height: 1.6; font-weight: 500;">{{ $n->message }}</p>
                                        <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed {{ $border }}; font-size: 12px; color: #64748b;">
                                            <i class="fas fa-user-edit"></i> Dari: {{ $n->sender->name }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 30px; border-radius: 30px; margin-bottom: 30px;">
                            <h3 style="margin-bottom: 20px;"><i class="fas fa-chart-line"></i> Hasil Capaian KPI</h3>
                            @if(isset($my_penilaian) && $my_penilaian)
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <p style="font-size: 11px; color: #94a3b8;">SKOR INDEKS</p>
                                        <h1 style="font-size: 48px; color: #2dd4bf;">{{ number_format($my_penilaian->kpi_score, 1) }}</h1>
                                        <!-- Progress Bar KPI -->
                                        <div style="width: 100%; height: 8px; background: rgba(255,255,255,0.1); border-radius: 10px; margin-top: 15px; overflow: hidden;">
                                            <div style="width: {{ $my_penilaian->kpi_score }}%; height: 100%; background: #2dd4bf; border-radius: 10px; box-shadow: 0 0 10px #2dd4bf;"></div>
                                        </div>
                                        <p style="font-size: 10px; color: #94a3b8; margin-top: 5px;">Target Capaian: 100%</p>
                                    </div>
                                    <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 15px;">
                                        <p style="font-size: 11px; color: #94a3b8;">BAKAT DOMINAN</p>
                                        <h4 style="margin: 5px 0;">{{ $my_penilaian->bakat_dominan }}</h4>
                                        <p style="font-size: 12px; color: #cbd5e1; font-style: italic;">"{{ $my_penilaian->insight_kinerja }}"</p>
                                    </div>
                                </div>
                            @else
                                <p style="color: #94a3b8;">Data penilaian belum tersedia.</p>
                            @endif
                        </div>

                        <!-- BINAAN & BIMBINGAN BK -->
                        @if(isset($my_bimbingan) && $my_bimbingan->count() > 0)
                            <div style="background: white; padding: 30px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 30px; border-left: 10px solid #0f766e;">
                                <h3 style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: var(--secondary);">
                                    <i class="fas fa-user-shield" style="color: #0f766e;"></i> Hasil Bimbingan & Rekomendasi BK
                                </h3>
                                <p style="color: #64748b; margin-bottom: 20px; font-size: 13px;">Berikut adalah riwayat bimbingan, arahan pembinaan, serta rekomendasi pengembangan minat/bakat dari Guru BK Anda.</p>
                                <div style="display: grid; gap: 15px;">
                                    @foreach($my_bimbingan as $b)
                                        <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-left: 6px solid #0f766e; padding: 22px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.01); transition: all 0.2s ease;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 15px; padding-bottom: 12px; border-bottom: 1px dashed #e2e8f0;">
                                                <span style="font-weight: 800; font-size: 11px; text-transform: uppercase; background: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                                                    <i class="fas fa-tag"></i> {{ str_replace('_', ' ', $b->jenis_pembinaan) }}
                                                </span>
                                                <span style="font-size: 11px; font-weight: 800; color: {{ $b->status == 'selesai' ? '#16a34a' : '#d97706' }}; background: {{ $b->status == 'selesai' ? '#ecfdf5' : '#fffbeb' }}; padding: 6px 12px; border-radius: 8px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px;">
                                                    <i class="fas {{ $b->status == 'selesai' ? 'fa-check-circle' : 'fa-spinner fa-spin' }}"></i> {{ $b->status }}
                                                </span>
                                            </div>
                                            
                                            <!-- Catatan Pembinaan -->
                                            <div style="margin-bottom: 15px;">
                                                <p style="font-size: 14.5px; color: #1e293b; line-height: 1.6; font-weight: 500; white-space: pre-line; margin: 0;">{{ $b->catatan }}</p>
                                            </div>
                                            
                                            <!-- Rekomendasi Guru BK -->
                                            @if($b->rekomendasi_lomba || $b->rekomendasi_organisasi || $b->rekomendasi_pengembangan)
                                                <div style="margin-top: 18px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
                                                    <h5 style="font-size: 12px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; letter-spacing: 0.5px;">
                                                        <i class="fas fa-lightbulb" style="color: #d97706; font-size: 14px;"></i> Rekomendasi Tindak Lanjut Guru BK
                                                    </h5>
                                                    <div style="display: grid; gap: 8px; background: #ffffff; padding: 12px 15px; border-radius: 12px; border: 1px solid #e2e8f0;">
                                                        @if($b->rekomendasi_lomba)
                                                            <div style="display: flex; gap: 8px; font-size: 13px; color: #334155;">
                                                                <span style="color: #0f766e; font-weight: 700; min-width: 160px; display: inline-flex; align-items: center; gap: 5px;">
                                                                    <i class="fas fa-trophy" style="font-size: 11px;"></i> Rekomendasi Lomba:
                                                                </span>
                                                                <span style="font-weight: 500;">{{ $b->rekomendasi_lomba }}</span>
                                                            </div>
                                                        @endif
                                                        @if($b->rekomendasi_organisasi)
                                                            <div style="display: flex; gap: 8px; font-size: 13px; color: #334155;">
                                                                <span style="color: #0f766e; font-weight: 700; min-width: 160px; display: inline-flex; align-items: center; gap: 5px;">
                                                                    <i class="fas fa-users" style="font-size: 11px;"></i> Rekomendasi Organisasi:
                                                                </span>
                                                                <span style="font-weight: 500;">{{ $b->rekomendasi_organisasi }}</span>
                                                            </div>
                                                        @endif
                                                        @if($b->rekomendasi_pengembangan)
                                                            <div style="display: flex; gap: 8px; font-size: 13px; color: #334155;">
                                                                <span style="color: #0f766e; font-weight: 700; min-width: 160px; display: inline-flex; align-items: center; gap: 5px;">
                                                                    <i class="fas fa-user-cog" style="font-size: 11px;"></i> Pengembangan Diri:
                                                                </span>
                                                                <span style="font-weight: 500;">{{ $b->rekomendasi_pengembangan }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Footer / Info Konselor & Tanggal Resmi -->
                                            <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; font-size: 12px; color: #475569; border-top: 1px solid #cbd5e1; padding-top: 15px;">
                                                <span style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                                                    <i class="fas fa-user-tie" style="color: #0f766e; font-size: 14px;"></i>
                                                    <span>Konselor: <strong>{{ $b->guru->name ?? 'Guru BK' }}</strong> @if(isset($b->guru->nip) && $b->guru->nip) <span style="color: #94a3b8; font-weight: 500;">(NIP. {{ $b->guru->nip }})</span> @endif</span>
                                                </span>
                                                <span style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: #334155; background: #e2e8f0; padding: 4px 10px; border-radius: 6px;">
                                                    <i class="fas fa-calendar-alt" style="color: #0f766e;"></i>
                                                    <span>{{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('l, d F Y') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- NILAI RAPOR SAYA (READ-ONLY) -->
                        <div style="background: white; padding: 30px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 30px;">
                            <h3 style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; color: var(--secondary);">
                                <span><i class="fas fa-book-open" style="color: var(--primary);"></i> Nilai Rapor Akhir Semester</span>
                                @if(isset($my_penilaian) && $my_penilaian && $my_penilaian->is_published)
                                    <span style="font-size: 12px; background: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 20px; font-weight: 800;">
                                        Rata-Rata: {{ number_format($my_penilaian->c1, 2) }}
                                    </span>
                                @endif
                            </h3>
                            
                            @if(isset($my_penilaian) && $my_penilaian && $my_penilaian->is_published)
                                @if(isset($my_grades) && $my_grades->isNotEmpty())
                                    <div style="overflow-x: auto;">
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                                                    <th style="padding: 12px; font-size: 11px; color: #94a3b8;">MATA PELAJARAN</th>
                                                    <th style="padding: 12px; font-size: 11px; color: #94a3b8;">GURU PENGAMPU</th>
                                                    <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-align: center; width: 100px;">NILAI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($my_grades as $g)
                                                    <tr style="border-bottom: 1px solid #f8fafc;">
                                                        <td style="padding: 12px; font-weight: 700; color: #1e293b;">
                                                            {{ $g->mapel->nama_mapel ?? 'N/A' }}
                                                        </td>
                                                        <td style="padding: 12px; color: #64748b; font-size: 13px;">
                                                            {{ $g->guru->name ?? 'N/A' }}
                                                        </td>
                                                        <td style="padding: 12px; text-align: center;">
                                                            <span style="font-weight: 800; color: var(--primary); font-size: 15px;">
                                                                {{ $g->nilai }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p style="color: #64748b; font-size: 13px; text-align: center; padding: 20px;">
                                        Nilai mata pelajaran belum dimasukkan oleh Guru Mapel.
                                    </p>
                                @endif
                            @else
                                <div style="text-align: center; padding: 30px; color: #64748b; background: #f8fafc; border-radius: 20px; border: 1px dashed #cbd5e1;">
                                    <div style="font-size: 32px; margin-bottom: 10px; color: #cbd5e1;"><i class="fas fa-lock"></i></div>
                                    <h4 style="font-weight: 700; margin-bottom: 5px; color: var(--secondary);">Rapor Sedang Diproses</h4>
                                    <p style="font-size: 12px;">Rapor akhir Anda belum diterbitkan oleh Wali Kelas.</p>
                                </div>
                            @endif
                        </div>

                        @php
                            $recentPrestasi = $my_prestasi->take(4);
                            $totalPrestasi = $my_prestasi->count();
                            $totalPoin = $my_prestasi->where('status', 'disetujui')->sum('poin');
                            $pendingCount = $my_prestasi->where('status', 'pending')->count();
                            $approvedCount = $my_prestasi->where('status', 'disetujui')->count();
                            $rejectedCount = $my_prestasi->where('status', 'ditolak')->count();
                        @endphp
                        <div style="background: white; padding: 30px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px;">
                                <h3 style="margin: 0;"><i class="fas fa-award"></i> Ringkasan Riwayat Prestasi</h3>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <a href="/prestasi/riwayat" style="background: #0f172a; color: white; padding: 10px 16px; border-radius: 12px; text-decoration: none; font-size: 12px; font-weight: 700;">Lihat Semua Riwayat</a>
                                    <a href="/prestasi/create" style="background: var(--primary); color: white; padding: 10px 16px; border-radius: 12px; text-decoration: none; font-size: 12px; font-weight: 700;">Input Prestasi Baru</a>
                                </div>
                            </div>
                            <p style="color: #64748b; margin-bottom: 25px;">Ini adalah ringkasan terbaru prestasi Anda. Untuk melihat daftar lengkap dan status detil, buka halaman riwayat prestasi.</p>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 15px; margin-bottom: 25px;">
                                <div style="background: #f8fafc; padding: 20px; border-radius: 20px; border: 1px solid #e2e8f0;">
                                    <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Total Pengajuan</div>
                                    <div style="font-size: 28px; font-weight: 800; color: var(--secondary);">{{ $totalPrestasi }}</div>
                                </div>
                                <div style="background: #f8fafc; padding: 20px; border-radius: 20px; border: 1px solid #e2e8f0;">
                                    <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Pending</div>
                                    <div style="font-size: 28px; font-weight: 800; color: #f59e0b;">{{ $pendingCount }}</div>
                                </div>
                                <div style="background: #f8fafc; padding: 20px; border-radius: 20px; border: 1px solid #e2e8f0;">
                                    <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Disetujui</div>
                                    <div style="font-size: 28px; font-weight: 800; color: #10b981;">{{ $approvedCount }}</div>
                                </div>
                                <div style="background: #f8fafc; padding: 20px; border-radius: 20px; border: 1px solid #e2e8f0;">
                                    <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Ditolak</div>
                                    <div style="font-size: 28px; font-weight: 800; color: #ef4444;">{{ $rejectedCount }}</div>
                                </div>
                            </div>
                            <div style="display: grid; gap: 15px;">
                                @forelse($recentPrestasi as $p)
                                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; padding: 18px 20px; border-radius: 20px; background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <div>
                                            <div style="font-weight: 700; color: var(--secondary);">{{ $p->nama_prestasi }}</div>
                                            <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                                <span>{{ $p->tingkat }} • {{ $p->juara }} • {{ $p->tanggal_capaian ? \Carbon\Carbon::parse($p->tanggal_capaian)->translatedFormat('Y') : '-' }}</span>
                                                @if($p->lokasi)
                                                    <span style="margin: 0 4px; color: #cbd5e1;">•</span>
                                                    <span><i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 4px;"></i>{{ $p->lokasi }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="text-align: right; min-width: 120px;">
                                            <div style="font-size: 12px; color: #64748b; margin-bottom: 6px;">{{ strtoupper($p->status) }}</div>
                                            <div style="font-weight: 800; color: var(--primary);">{{ $p->status == 'disetujui' ? '+'.$p->poin.' Poin' : '0 Poin' }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div style="padding: 20px; border-radius: 20px; background: #f8fafc; color: #64748b; text-align: center;">Belum ada prestasi. Silakan tambah prestasi baru untuk mulai mengajukan.</div>
                                @endforelse
                            </div>
                            @if($totalPoin > 0)
                                <div style="margin-top: 20px; padding: 20px; background: #eff6ff; border-radius: 20px; display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-weight: 700; color: #475569;">Total Akumulasi Poin Dari Prestasi Disetujui</span>
                                    <span style="font-size: 22px; font-weight: 800; color: #0f766e;">{{ $totalPoin }} Poin</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <script>
        function switchGuruTab(tabId) {
            // Deactivate all tab buttons
            const buttons = document.querySelectorAll('.guru-tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));

            // Deactivate all tab contents
            const contents = document.querySelectorAll('.guru-tab-content');
            contents.forEach(content => content.classList.remove('active'));

            // Activate selected button
            if (event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            }

            // Activate selected content
            const targetContent = document.getElementById(tabId);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        }
    </script>
</body>
</html>