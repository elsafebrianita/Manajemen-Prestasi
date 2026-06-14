<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Mata Pelajaran - SIMPRES</title>
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
        .container { max-width: 1400px; margin: 0 auto; }
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
        .header-title p { color: var(--text-muted); font-size: 14px; margin-top: 5px; }
        .btn {
            padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            border: none; cursor: pointer; transition: 0.3s;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-light); transform: translateY(-2px); }
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background: #f8fafc; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 7px 14px; font-size: 12px; border-radius: 8px; }

        .alert {
            padding: 18px 24px; border-radius: 15px; margin-bottom: 30px; font-weight: 700;
            display: flex; align-items: center; gap: 12px;
        }
        .alert-success { background: #ecfdf5; color: #059669; border-left: 5px solid #10b981; }
        .alert-danger  { background: #fef2f2; color: #b91c1c;  border-left: 5px solid #ef4444; }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 18px;
            padding: 20px 25px;
            border: 1px solid #e2e8f0;
            display: flex; align-items: center; gap: 18px;
        }
        .stat-icon {
            width: 50px; height: 50px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center; font-size: 22px;
        }
        .stat-icon.teal { background: #ccfbf1; color: #0f766e; }
        .stat-icon.blue { background: #dbeafe; color: #2563eb; }
        .stat-icon.orange { background: #ffedd5; color: #ea580c; }
        .stat-num { font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 800; color: var(--secondary); }
        .stat-lbl { font-size: 13px; color: var(--text-muted); font-weight: 600; }

        .grid-layout {
            display: grid;
            grid-template-columns: 3fr 1.5fr;
            gap: 30px;
        }
        .card {
            background: var(--surface); border-radius: 24px; padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;
        }
        .card h3 {
            font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 20px;
            color: var(--secondary); display: flex; align-items: center; gap: 10px;
        }

        /* Table Styles */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left; padding: 12px 15px; font-size: 11px; font-weight: 800;
            text-transform: uppercase; color: var(--text-muted); border-bottom: 2px solid #f1f5f9;
        }
        td { padding: 12px 15px; font-size: 14px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
        tr:hover { background: #f8fafc; }

        .badge-count {
            display: inline-flex; align-items: center; gap: 5px;
            background: #e0f2fe; color: #0284c7;
            padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;
        }
        .badge-count.active { background: #dcfce7; color: #15803d; }

        /* Form Styles */
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; font-size: 12px; font-weight: 700;
            text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px;
        }
        .form-control {
            width: 100%; padding: 12px 16px; border-radius: 12px;
            border: 1px solid #cbd5e1; font-size: 14px; outline: none; transition: 0.3s;
            font-family: 'Inter', sans-serif;
        }
        .form-control:focus {
            border-color: var(--primary-light); box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }

        /* Search */
        .search-bar {
            display: flex; gap: 12px; margin-bottom: 20px;
        }
        .search-bar input {
            flex: 1; padding: 11px 16px; border-radius: 12px; border: 1px solid #cbd5e1;
            font-size: 14px; outline: none; font-family: 'Inter', sans-serif;
        }
        .search-bar input:focus { border-color: var(--primary-light); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-title">
                <h1><i class="fas fa-book-open" style="color: var(--primary);"></i> KELOLA DATA MATA PELAJARAN</h1>
                <p>SIMPRES | SMK Negeri 1 Talamau &mdash; Total {{ $mapels->count() }} Mata Pelajaran</p>
            </div>
            <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</div>
        @endif

        {{-- Stats Bar --}}
        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-icon teal"><i class="fas fa-book"></i></div>
                <div>
                    <div class="stat-num">{{ $mapels->count() }}</div>
                    <div class="stat-lbl">Total Mata Pelajaran</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-num">{{ $totalGurus }}</div>
                    <div class="stat-lbl">Guru Mengajar</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-door-open"></i></div>
                <div>
                    <div class="stat-num">{{ $totalKelas }}</div>
                    <div class="stat-lbl">Total Kelas</div>
                </div>
            </div>
        </div>

        <div class="grid-layout">
            {{-- Table Card --}}
            <div class="card">
                <h3><i class="fas fa-table"></i> Daftar Mata Pelajaran</h3>
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Cari nama mata pelajaran..." oninput="filterTable()">
                </div>
                <div style="overflow-x: auto;">
                    <table id="mapelTable">
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;">No</th>
                                <th>Nama Mata Pelajaran</th>
                                <th style="text-align: center;">Guru Mengajar</th>
                                <th style="text-align: center;">Kelas Terhubung</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mapels as $index => $m)
                                <tr>
                                    <td style="text-align: center; color: var(--text-muted); font-weight: 600;">{{ $index + 1 }}</td>
                                    <td>
                                        <div style="font-weight: 700; color: var(--secondary); font-size: 15px;">{{ $m->nama_mapel }}</div>
                                    </td>
                                    <td style="text-align: center;">
                                        @php $guruCount = $m->guruMapels->pluck('guru_id')->unique()->count(); @endphp
                                        <span class="badge-count {{ $guruCount > 0 ? 'active' : '' }}">
                                            <i class="fas fa-user-tie"></i> {{ $guruCount }} Guru
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        @php $kelasCount = $m->guruMapels->pluck('kelas_id')->unique()->count(); @endphp
                                        <span class="badge-count">
                                            <i class="fas fa-door-open"></i> {{ $kelasCount }} Kelas
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="/admin/mapel/delete/{{ $m->id }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus mapel {{ $m->nama_mapel }}?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                        <i class="fas fa-book" style="font-size: 36px; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
                                        Belum ada data mata pelajaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Form Card --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                <div class="card">
                    <h3><i class="fas fa-plus-circle"></i> Tambah Mata Pelajaran</h3>
                    <form action="/admin/mapel/store" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Mata Pelajaran</label>
                            <input type="text" name="nama_mapel" class="form-control" placeholder="Contoh: Bahasa Inggris" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                            <i class="fas fa-save"></i> &nbsp; Simpan Data Mapel
                        </button>
                    </form>
                </div>

                <div class="card" style="background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%); color: white; border: none;">
                    <h3 style="color: white;"><i class="fas fa-info-circle"></i> Info Import</h3>
                    <p style="font-size: 13px; color: rgba(255,255,255,0.85); line-height: 1.7;">
                        Data mata pelajaran ini telah <strong>disinkronkan otomatis</strong> dari file Excel Pembagian Jam Mengajar SMKN 1 Talamau Semester Genap TP 2025/2026.
                    </p>
                    <div style="margin-top: 15px; background: rgba(255,255,255,0.15); border-radius: 12px; padding: 12px; font-size: 12px;">
                        <div><i class="fas fa-check-circle" style="color: #86efac;"></i> &nbsp; <strong>{{ $mapels->count() }}</strong> Mapel tersinkronisasi</div>
                        <div style="margin-top: 6px;"><i class="fas fa-check-circle" style="color: #86efac;"></i> &nbsp; <strong>{{ $totalRelasi }}</strong> Relasi Guru-Mapel-Kelas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#mapelTable tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
