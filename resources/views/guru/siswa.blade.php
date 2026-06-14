<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa Kelas Diajar - SIMPRES</title>
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
            max-width: 1100px;
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
        
        .card {
            background: var(--surface);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 12px 15px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 2px solid #f1f5f9;
        }
        td {
            padding: 15px;
            font-size: 14px;
            border-bottom: 1px solid #f8fafc;
            vertical-align: middle;
        }
        tr:hover { background: #fcfdfd; }
        
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
                <h1>DATA SISWA</h1>
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

        <div class="card">
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $s)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: var(--secondary);">{{ $s->nama }}</div>
                                </td>
                                <td><code>{{ $s->nis }}</code></td>
                                <td>
                                    <span style="font-weight: 700; color: var(--primary);">{{ $s->kelasRel->nama_kelas ?? $s->kelas }}</span>
                                </td>
                                <td>{{ $s->jurusan }}</td>
                                <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <i class="fas fa-info-circle"></i> Tidak ada siswa di kelas yang Anda ajar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
