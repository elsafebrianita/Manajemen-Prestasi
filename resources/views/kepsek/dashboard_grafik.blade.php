<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Sekolah - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        :root {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --secondary: #0f172a;
            --bg-color: #f8fafc;
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
            --sidebar-width: 270px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--secondary);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 24px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-brand h2 {
            color: #5eead4;
            font-size: 18px;
            font-weight: 800;
            line-height: 1.2;
        }
        .sidebar-brand p {
            color: rgba(255,255,255,0.7);
            font-size: 12px;
        }
        .sidebar-menu {
            padding: 20px 16px;
            flex: 1;
        }
        .menu-label {
            font-size: 10px;
            font-weight: 800;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 14px 8px 6px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            margin-bottom: 4px;
        }
        .menu-item:hover, .menu-item.active {
            background: rgba(94, 234, 212, 0.1);
            color: #5eead4;
        }
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #f87171;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: var(--transition);
        }
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        /* MAIN CONTENT */
        .main {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-width: 0;
        }
        .topbar {
            background: white;
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .topbar h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .kepsek-badge {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(15, 118, 110, 0.2);
        }

        .content {
            padding: 35px;
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        .stat-info .num {
            font-size: 28px;
            font-weight: 800;
            color: var(--secondary);
            line-height: 1.2;
        }
        .stat-info .lbl {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* GRID ANALYTICS */
        .analytics-row {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 30px;
            margin-bottom: 35px;
        }
        @media (max-width: 1200px) {
            .analytics-row {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }
        .chart-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .chart-card-header h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .chart-container {
            position: relative;
            height: 320px;
            width: 100%;
        }

        /* HALL OF FAME CARDS */
        .champions-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .champion-item {
            background: white;
            border-radius: 16px;
            padding: 16px 20px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: var(--transition);
        }
        .champion-item:hover {
            transform: translateX(5px);
            border-color: var(--primary-light);
        }
        .champion-badge {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .champion-details {
            flex: 1;
        }
        .champion-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--secondary);
        }
        .champion-desc {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }
        .champion-score {
            font-size: 16px;
            font-weight: 800;
            color: var(--primary);
            text-align: right;
        }

        /* TABLES */
        .table-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            margin-bottom: 35px;
            overflow-x: auto;
        }
        .table-card-header {
            margin-bottom: 20px;
        }
        .table-card-header h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .table-card-header p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            padding: 14px 16px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }
        td {
            padding: 14px 16px;
            font-size: 13px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        /* GENERAL BADGES */
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            font-weight: 800;
            font-size: 11px;
        }
        .rank-1 { background: #fef3c7; color: #d97706; }
        .rank-2 { background: #f1f5f9; color: #475569; }
        .rank-3 { background: #ffedd5; color: #ea580c; }
        .rank-other { background: #f8fafc; color: #94a3b8; border: 1px solid #e2e8f0; }

        .btn-approve {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-approve:hover {
            background: #059669;
            color: white;
        }
        .btn-reject {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-reject:hover {
            background: #dc2626;
            color: white;
        }
        .student-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transition);
        }
        .student-link:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .scroll-top-btn { 
            position: fixed; 
            bottom: 30px; 
            right: 30px; 
            width: 48px; 
            height: 48px; 
            background: linear-gradient(135deg, var(--primary), var(--primary-light)); 
            color: white; 
            border: none; 
            border-radius: 50%; 
            font-size: 18px; 
            cursor: pointer; 
            display: none; 
            align-items: center; 
            justify-content: center; 
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.3);
            z-index: 50;
            transition: var(--transition);
        }
        .scroll-top-btn.show { display: flex; }
        .scroll-top-btn:hover {
            transform: translateY(-3px);
        }

        .alert-success {
            background: #ecfdf5;
            color: #047857;
            padding: 16px 20px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #a7f3d0;
        }
        .user-profile { display: flex; align-items: center; gap: 15px; }
        .user-info { display: flex; flex-direction: column; text-align: right; }
        .user-name { font-weight: 700; font-size: 14px; color: var(--secondary); }
        .user-role { font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .avatar {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            display: flex; align-items: center; justify-content: center; color: white;
            font-weight: 800; font-size: 18px; overflow: hidden;
            position: relative; cursor: pointer; transition: var(--transition);
            box-shadow: 0 4px 10px rgba(15, 118, 110, 0.2);
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
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div style="background: white; padding: 5px; border-radius: 50%; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; flex-shrink: 0;">
            <img src="{{ asset('LogoSekolah.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div>
            <h2>SIMPRES</h2>
            <p>SMK N 1 Talamau</p>
        </div>
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>
        <a href="/kepsek" class="menu-item active"><i class="fas fa-crown"></i> Dashboard Kepsek</a>
        <a href="/admin/publikasi" class="menu-item"><i class="fas fa-stamp"></i> Verifikasi Publikasi</a>
        <a href="/laporan" class="menu-item"><i class="fas fa-file-pdf"></i> Lihat Laporan</a>
    </div>
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form-ks').submit();">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
        <form id="logout-form-ks" action="{{ route('logout') }}" method="GET" style="display:none;">@csrf</form>
    </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main">
    <div class="topbar">
        <h2><i class="fas fa-chart-line" style="color: var(--primary);"></i> Dashboard Analisis Manajemen Prestasi</h2>
        <div class="user-profile">
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Kepala Sekolah</div>
            </div>
            <div class="avatar" onclick="document.getElementById('topbar-upload-foto').click()" title="Klik untuk mengubah foto profil">
                @if(auth()->user()->foto)
                    <img src="{{ asset('uploads/profil/' . auth()->user()->foto) }}" alt="Foto Profil">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
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
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
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

        @if(!auth()->user()->foto)
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

        <!-- QUICK STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <div class="num">{{ $stats['total'] }}</div>
                    <div class="lbl">Total Evaluasi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef3c7; color: #d97706;"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-info">
                    <div class="num">{{ $stats['menunggu'] }}</div>
                    <div class="lbl">Menunggu Publikasi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #dcfce7; color: #16a34a;"><i class="fas fa-arrow-trend-up"></i></div>
                <div class="stat-info">
                    <div class="num">{{ $stats['high'] }}</div>
                    <div class="lbl">KPI Unggul (≥85)</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #f0fdf4; color: #14b8a6;"><i class="fas fa-arrow-right-long"></i></div>
                <div class="stat-info">
                    <div class="num">{{ $stats['medium'] }}</div>
                    <div class="lbl">KPI Standar (70-84)</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef2f2; color: #dc2626;"><i class="fas fa-arrow-trend-down"></i></div>
                <div class="stat-info">
                    <div class="num">{{ $stats['low'] }}</div>
                    <div class="lbl">KPI Rendah (<70)</div>
                </div>
            </div>
        </div>

        <!-- ROW 1: 4 INDIKATOR & JUARA KATEGORI -->
        <div class="analytics-row">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h3><i class="fas fa-cubes" style="color: #6366f1;"></i> Rata-rata 4 Indikator Utama Sekolah</h3>
                </div>
                <div class="chart-container">
                    <canvas id="chart4Indikator"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card-header">
                    <h3><i class="fas fa-trophy" style="color: #eab308;"></i> Juara Masing-masing Bidang</h3>
                </div>
                <div class="champions-container">
                    <!-- JUARA RAPOR (C1) -->
                    <div class="champion-item">
                        <div class="champion-badge" style="background: #e0f2fe; color: #0284c7;"><i class="fas fa-book"></i></div>
                        <div class="champion-details">
                            <div class="champion-name">
                                @if($juara_rapor)
                                    <a href="/kepsek/siswa/{{ $juara_rapor->siswa->id }}" class="student-link">{{ $juara_rapor->siswa->nama }}</a>
                                @else
                                    Belum ada data
                                @endif
                            </div>
                            <div class="champion-desc">Juara Rata-rata Rapor (C1) • Kelas: {{ $juara_rapor ? ($juara_rapor->siswa->kelas ?? '-') : '-' }}</div>
                        </div>
                        <div class="champion-score">{{ $juara_rapor ? number_format($juara_rapor->c1, 1) : '0' }}</div>
                    </div>

                    <!-- JUARA PRESTASI AKADEMIK (C2) -->
                    <div class="champion-item">
                        <div class="champion-badge" style="background: #fef3c7; color: #d97706;"><i class="fas fa-graduation-cap"></i></div>
                        <div class="champion-details">
                            <div class="champion-name">
                                @if($juara_akademik)
                                    <a href="/kepsek/siswa/{{ $juara_akademik->siswa->id }}" class="student-link">{{ $juara_akademik->siswa->nama }}</a>
                                @else
                                    Belum ada data
                                @endif
                            </div>
                            <div class="champion-desc">Juara Prestasi Akademik (C2) • Kelas: {{ $juara_akademik ? ($juara_akademik->siswa->kelas ?? '-') : '-' }}</div>
                        </div>
                        <div class="champion-score">{{ $juara_akademik ? number_format($juara_akademik->c2, 1) : '0' }}</div>
                    </div>

                    <!-- JUARA ORGANISASI (C3) -->
                    <div class="champion-item">
                        <div class="champion-badge" style="background: #fae8ff; color: #a21caf;"><i class="fas fa-sitemap"></i></div>
                        <div class="champion-details">
                            <div class="champion-name">
                                @if($juara_organisasi)
                                    <a href="/kepsek/siswa/{{ $juara_organisasi->siswa->id }}" class="student-link">{{ $juara_organisasi->siswa->nama }}</a>
                                @else
                                    Belum ada data
                                @endif
                            </div>
                            <div class="champion-desc">Juara Jabatan Organisasi (C3) • Kelas: {{ $juara_organisasi ? ($juara_organisasi->siswa->kelas ?? '-') : '-' }}</div>
                        </div>
                        <div class="champion-score">{{ $juara_organisasi ? number_format($juara_organisasi->c3, 1) : '0' }}</div>
                    </div>

                    <!-- JUARA SENI/OLAHRAGA (C4) -->
                    <div class="champion-item">
                        <div class="champion-badge" style="background: #dcfce7; color: #16a34a;"><i class="fas fa-guitar"></i></div>
                        <div class="champion-details">
                            <div class="champion-name">
                                @if($juara_seni_olahraga)
                                    <a href="/kepsek/siswa/{{ $juara_seni_olahraga->siswa->id }}" class="student-link">{{ $juara_seni_olahraga->siswa->nama }}</a>
                                @else
                                    Belum ada data
                                @endif
                            </div>
                            <div class="champion-desc">Juara Seni, Budaya & Olahraga (C4) • Kelas: {{ $juara_seni_olahraga ? ($juara_seni_olahraga->siswa->kelas ?? '-') : '-' }}</div>
                        </div>
                        <div class="champion-score">{{ $juara_seni_olahraga ? number_format($juara_seni_olahraga->c4, 1) : '0' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 2: TINGKAT PRESTASI & TOP TINGKAT -->
        <div class="analytics-row">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h3><i class="fas fa-globe" style="color: #3b82f6;"></i> Distribusi Prestasi Berdasarkan Tingkat</h3>
                </div>
                <div class="chart-container">
                    <canvas id="chartTingkat"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card-header">
                    <h3><i class="fas fa-award" style="color: #ec4899;"></i> Juara di Setiap Tingkat</h3>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px; overflow-y: auto; max-height: 320px; padding-right: 5px;">
                    @foreach($tingkat_leaders as $tingkat => $prestasis)
                        <div style="padding: 10px 14px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">Tingkat {{ $tingkat }}</div>
                            @forelse($prestasis as $idx => $p)
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 6px; font-size: 12px;">
                                    <span style="font-weight: 600; color: var(--secondary);">
                                        <span class="rank-badge {{ $idx === 0 ? 'rank-1' : ($idx === 1 ? 'rank-2' : 'rank-3') }}">{{ $idx + 1 }}</span>
                                        <a href="/kepsek/siswa/{{ $p->siswa->id }}" class="student-link" style="margin-left: 5px;">{{ $p->siswa->nama ?? '-' }}</a>
                                    </span>
                                    <span style="font-size: 11px; color: var(--text-muted); max-width: 150px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;" title="{{ $p->nama_prestasi }}">
                                        {{ $p->nama_prestasi }}
                                    </span>
                                </div>
                            @empty
                                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px; font-style: italic;">Belum ada prestasi disetujui di tingkat ini.</div>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ROW 3: ANALISIS KELAS (PRESTASI TERTINGGI & TERENDAH) -->
        <div class="analytics-row">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h3><i class="fas fa-school" style="color: var(--primary);"></i> Perbandingan Rata-rata KPI Per Kelas</h3>
                </div>
                <div class="chart-container">
                    <canvas id="chartKelasKPI"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card-header">
                    <h3><i class="fas fa-circle-info" style="color: #64748b;"></i> Ringkasan Prestasi Kelas</h3>
                </div>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <h4 style="font-size: 12px; font-weight: 800; color: #16a34a; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-caret-up"></i> 5 Kelas Prestasi Tertinggi
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($kelas_tinggi as $k)
                                <div style="display: flex; justify-content: space-between; font-size: 12px; padding: 6px 10px; background: #f0fdf4; border-radius: 8px;">
                                    <span style="font-weight: 700; color: #16a34a;">{{ $k['nama_kelas'] }}</span>
                                    <span style="font-weight: 800; color: #14532d;">Rata-rata: {{ number_format($k['rata_kpi'], 1) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 style="font-size: 12px; font-weight: 800; color: #dc2626; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-caret-down"></i> 5 Kelas Prestasi Terendah
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($kelas_rendah as $k)
                                <div style="display: flex; justify-content: space-between; font-size: 12px; padding: 6px 10px; background: #fef2f2; border-radius: 8px;">
                                    <span style="font-weight: 700; color: #dc2626;">{{ $k['nama_kelas'] }}</span>
                                    <span style="font-weight: 800; color: #7f1d1d;">Rata-rata: {{ number_format($k['rata_kpi'], 1) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 4: 10 SISWA TERTINGGI & 10 SISWA TERENDAH -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 35px;">
            <!-- TOP 10 -->
            <div class="table-card" style="margin-bottom: 0;">
                <div class="table-card-header">
                    <h3><i class="fas fa-arrow-up-long" style="color: #16a34a;"></i> 10 Siswa Prestasi Tertinggi (KPI)</h3>
                    <p>Siswa dengan akumulasi nilai kriteria (C1-C4) terbaik di sekolah.</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px;">Rank</th>
                            <th>Nama Siswa</th>
                            <th>KPI Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($top_10 as $idx => $p)
                            <tr>
                                <td><span class="rank-badge {{ $idx === 0 ? 'rank-1' : ($idx === 1 ? 'rank-2' : ($idx === 2 ? 'rank-3' : 'rank-other')) }}">{{ $idx + 1 }}</span></td>
                                <td>
                                    <div style="font-weight: 700; color: var(--secondary);">
                                        <a href="/kepsek/siswa/{{ $p->siswa->id }}" class="student-link">{{ $p->siswa->nama ?? '-' }}</a>
                                    </div>
                                    <div style="font-size: 11px; color: var(--text-muted);">NIS: {{ $p->siswa->nis ?? '-' }} • Kelas: {{ $p->siswa->kelas ?? '-' }}</div>
                                </td>
                                <td><span style="font-weight: 800; color: #16a34a; font-size: 14px;">{{ number_format($p->kpi_score, 1) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- BOTTOM 10 -->
            <div class="table-card" style="margin-bottom: 0;">
                <div class="table-card-header">
                    <h3><i class="fas fa-arrow-down-long" style="color: #dc2626;"></i> 10 Siswa Prestasi Terendah</h3>
                    <p>Siswa yang memerlukan pembinaan prestasi dan monitoring nilai secara berkala.</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px;">Rank</th>
                            <th>Nama Siswa</th>
                            <th>KPI Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bottom_10 as $idx => $p)
                            <tr>
                                <td><span class="rank-badge rank-other" style="background: #fef2f2; color: #dc2626; border-color: #fecaca;">{{ $idx + 1 }}</span></td>
                                <td>
                                    <div style="font-weight: 700; color: var(--secondary);">
                                        <a href="/kepsek/siswa/{{ $p->siswa->id }}" class="student-link">{{ $p->siswa->nama ?? '-' }}</a>
                                    </div>
                                    <div style="font-size: 11px; color: var(--text-muted);">NIS: {{ $p->siswa->nis ?? '-' }} • Kelas: {{ $p->siswa->kelas ?? '-' }}</div>
                                </td>
                                <td><span style="font-weight: 800; color: #dc2626; font-size: 14px;">{{ number_format($p->kpi_score, 1) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BAGIAN ACC PUBLIKASI -->
        <div class="table-card">
            <div class="table-card-header">
                <h3><i class="fas fa-stamp" style="color: #3b82f6;"></i> Keputusan Publikasi Siswa Berprestasi</h3>
                <p>Setujui kelayakan siswa untuk dipublikasikan beritanya oleh Admin ke Halaman Utama.</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Siswa</th>
                        <th>KPI Score</th>
                        <th>Status Kepsek</th>
                        <th>Aksi Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposed_penilaians as $idx => $p)
                        <tr>
                            <td style="color: var(--text-muted); font-weight: 700;">{{ $idx + 1 }}</td>
                            <td>
                                <div style="font-weight: 700; color: var(--secondary);">
                                    <a href="/kepsek/siswa/{{ $p->siswa->id }}" class="student-link"><i class="fas fa-user" style="margin-right: 5px;"></i>{{ $p->siswa->nama ?? '-' }}</a>
                                </div>
                                <div style="font-size: 11px; color: var(--text-muted);">NIS: {{ $p->siswa->nis ?? '-' }} | Kelas: {{ $p->siswa->kelasRel->nama_kelas ?? $p->siswa->kelas }}</div>
                            </td>
                            <td><span style="font-weight: 800; color: {{ $p->kpi_score >= 85 ? '#16a34a' : ($p->kpi_score >= 70 ? '#f59e0b' : '#dc2626') }}; font-size: 14px;">{{ number_format($p->kpi_score, 1) }}</span></td>
                            <td>
                                @if($p->kepsek_status === 'layak')
                                    <span style="background: #f0fdf4; color: #16a34a; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; border: 1px solid #bbf7d0;">✓ Layak Publikasi</span>
                                @elseif($p->kepsek_status === 'tidak_layak')
                                    <span style="background: #fef2f2; color: #dc2626; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; border: 1px solid #fecaca;">✗ Tidak Layak</span>
                                @else
                                    <span style="background: #f8fafc; color: #64748b; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; border: 1px solid #e2e8f0;">⏳ Menunggu Keputusan</span>
                                @endif
                            </td>
                            <td>
                                @if($p->kepsek_status === 'menunggu')
                                    <button class="btn-approve" onclick="openModal({{ $p->id }}, '{{ $p->siswa->nama }}', 'layak')">✓ Setujui</button>
                                    <button class="btn-reject" onclick="openModal({{ $p->id }}, '{{ $p->siswa->nama }}', 'tidak_layak')">✗ Tolak</button>
                                @else
                                    <a href="/kepsek/siswa/{{ $p->siswa->id }}" class="student-link" style="font-size: 11px; font-weight: 700;"><i class="fas fa-search" style="margin-right: 4px;"></i> Lihat Rincian</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada data evaluasi siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- MODAL INTERAKTIF -->
<div id="modalOverlay" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 24px; padding: 35px; width: 480px; max-width: 90vw; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);">
        <div id="modalIcon" style="font-size: 40px; text-align: center; margin-bottom: 15px;"></div>
        <h3 id="modalTitle" style="font-size: 18px; font-weight: 800; text-align: center; color: var(--secondary);"></h3>
        <p id="modalSubtitle" style="font-size: 13px; color: var(--text-muted); text-align: center; margin-top: 6px;"></p>

        <form method="POST" id="keputusanForm">
            @csrf
            <input type="hidden" name="kepsek_status" id="modalStatus">
            <label style="font-size: 12px; font-weight: 700; color: var(--secondary); display: block; margin-top: 20px;">Tuliskan Catatan atau Evaluasi Kepsek (Opsional)</label>
            <textarea name="kepsek_catatan" placeholder="Catatan ini dapat dibaca oleh Admin dan Wali Kelas untuk perbaikan atau tindak lanjut publikasi..." style="width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 13px; height: 100px; resize: none; outline: none; margin-top: 8px; transition: var(--transition);" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#cbd5e1'"></textarea>
            <div style="display: flex; gap: 12px; margin-top: 25px;">
                <button type="button" style="background: #f1f5f9; color: #475569; flex: 1; padding: 12px; border-radius: 12px; border: none; font-size: 13px; font-weight: 700; cursor: pointer; transition: var(--transition);" onclick="closeModal()">Batal</button>
                <button type="submit" id="confirmBtn" style="flex: 1; padding: 12px; border-radius: 12px; border: none; font-size: 13px; font-weight: 800; color: white; cursor: pointer; transition: var(--transition);"></button>
            </div>
        </form>
    </div>
</div>

<!-- SCROLL TO TOP BUTTON -->
<button class="scroll-top-btn" id="scrollTopBtn" onclick="scrollToTop()"><i class="fas fa-arrow-up"></i></button>

<script>
    // 1. INisialisasi GRAFIK 4 INDIKATOR UTAMA
    const ctx4 = document.getElementById('chart4Indikator').getContext('2d');
    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($indicators_avg)) !!},
            datasets: [{
                label: 'Rata-rata Skor Sekolah',
                data: {!! json_encode(array_values($indicators_avg)) !!},
                backgroundColor: [
                    'rgba(2, 132, 199, 0.85)',   // Biru untuk C1
                    'rgba(217, 119, 6, 0.85)',   // Amber untuk C2
                    'rgba(162, 28, 175, 0.85)',  // Ungu untuk C3
                    'rgba(22, 163, 74, 0.85)'    // Hijau untuk C4
                ],
                borderColor: [
                    '#0284c7', '#d97706', '#a21caf', '#16a34a'
                ],
                borderWidth: 1.5,
                borderRadius: 8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Plus Jakarta Sans', weight: '600' }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        color: '#475569',
                        font: { family: 'Plus Jakarta Sans', weight: '700', size: 10 }
                    },
                    grid: { display: false }
                }
            }
        }
    });

    // 2. INisialisasi GRAFIK DISTRIBUSI TINGKAT
    const ctxTingkat = document.getElementById('chartTingkat').getContext('2d');
    new Chart(ctxTingkat, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($tingkat_data)) !!},
            datasets: [{
                data: {!! json_encode(array_values($tingkat_data)) !!},
                backgroundColor: [
                    '#ec4899', // Internasional
                    '#3b82f6', // Nasional
                    '#10b981', // Provinsi
                    '#f59e0b', // Kabupaten
                    '#6366f1'  // Kecamatan
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: { family: 'Plus Jakarta Sans', weight: '700', size: 11 },
                        color: '#475569'
                    }
                }
            },
            cutout: '65%'
        }
    });

    // 3. INisialisasi GRAFIK PERBANDINGAN KELAS
    const ctxKelas = document.getElementById('chartKelasKPI').getContext('2d');
    
    // Ambil data dari kelas_tinggi dan kelas_rendah untuk digabungkan menjadi list unik kelas
    const kelasList = {!! json_encode(collect($kelas_tinggi)->merge($kelas_rendah)->unique('nama_kelas')->values()) !!};
    const labelsKelas = kelasList.map(k => k.nama_kelas);
    const dataKelas = kelasList.map(k => parseFloat(k.rata_kpi).toFixed(1));

    new Chart(ctxKelas, {
        type: 'bar',
        data: {
            labels: labelsKelas,
            datasets: [{
                label: 'Rata-rata KPI',
                data: dataKelas,
                backgroundColor: 'rgba(20, 184, 166, 0.8)',
                borderColor: '#14b8a6',
                borderWidth: 1.5,
                borderRadius: 6,
                barPercentage: 0.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Plus Jakarta Sans', weight: '600' }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        color: '#475569',
                        font: { family: 'Plus Jakarta Sans', weight: '700', size: 11 }
                    },
                    grid: { display: false }
                }
            }
        }
    });

    // MODAL ACTIONS
    function openModal(id, nama, status) {
        const isLayak = status === 'layak';
        document.getElementById('modalIcon').innerHTML = isLayak ? '<i class="fas fa-circle-check" style="color: #10b981;"></i>' : '<i class="fas fa-triangle-exclamation" style="color: #ef4444;"></i>';
        document.getElementById('modalTitle').textContent = isLayak ? 'Setujui Kelayakan Publikasi' : 'Tolak Kelayakan Publikasi';
        document.getElementById('modalSubtitle').textContent = `Siswa: ${nama}`;
        document.getElementById('modalStatus').value = status;
        document.getElementById('keputusanForm').action = `/kepsek/keputusan/${id}`;

        const btn = document.getElementById('confirmBtn');
        btn.textContent = isLayak ? 'Setujui Layak' : 'Tolak Kelayakan';
        btn.style.background = isLayak ? '#10b981' : '#ef4444';

        document.getElementById('modalOverlay').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalOverlay').style.display = 'none';
    }

    document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // SCROLL TO TOP BUTTON
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add('show');
        } else {
            scrollTopBtn.classList.remove('show');
        }
    });

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
</body>
</html>
