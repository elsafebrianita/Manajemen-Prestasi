<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Pelajaran Saya - SIMPRES</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --secondary: #0f172a;
            --bg-color: #f1f5f9;
            --surface: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            padding: 40px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        .header-title h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--secondary);
        }
        .header-title p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 5px;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background: #f8fafc; }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        .card {
            background: var(--surface);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .info h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--secondary);
        }
        .info p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }
        
        /* --- SUB NAVIGATION TABS --- */
        .sub-nav {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 1px;
            flex-wrap: wrap;
        }
        .sub-nav-item {
            text-decoration: none;
            padding: 12px 20px;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 3px solid transparent;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .sub-nav-item:hover {
            color: var(--primary);
            border-bottom-color: #cbd5e1;
        }
        .sub-nav-item.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-title">
                <h1>MATA PELAJARAN YANG DIAMPU</h1>
                <p>SIMPRES | Guru: {{ auth()->user()->name }}</p>
            </div>
            <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        <!-- Sub Navigation Tabs -->
        <div class="sub-nav">
            <a href="/guru/mapel" class="sub-nav-item {{ request()->is('guru/mapel*') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i> Mata Pelajaran yang Diampu
            </a>
            <a href="/guru/kelas" class="sub-nav-item {{ request()->is('guru/kelas*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i> Kelas yang Diajar
            </a>
            <a href="/guru/siswa" class="sub-nav-item {{ request()->is('guru/siswa*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Data Siswa
            </a>
            <a href="/guru/nilai" class="sub-nav-item {{ request()->is('guru/nilai*') ? 'active' : '' }}">
                <i class="fas fa-edit"></i> Input Nilai
            </a>
        </div>

        <div class="grid">
            @forelse($mapels as $m)
                <div class="card">
                    <div class="icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="info">
                        <h3>{{ $m->mapel->nama_mapel ?? 'N/A' }}</h3>
                        <p>Kelas Diajar: <strong>{{ $m->kelas->nama_kelas ?? 'N/A' }}</strong></p>
                    </div>
                </div>
            @empty
                <div class="card" style="grid-column: 1/-1; justify-content: center; padding: 40px; color: var(--text-muted);">
                    <i class="fas fa-info-circle"></i> Belum ada mata pelajaran yang diampu. Silakan hubungi admin sistem.
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>
