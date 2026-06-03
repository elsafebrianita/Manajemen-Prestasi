<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Kelas - SIMPRES</title>
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
            max-width: 1200px;
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
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-light); transform: translateY(-2px); }
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background: #f8fafc; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        
        .alert {
            background: #ecfdf5;
            color: #059669;
            padding: 18px 24px;
            border-radius: 15px;
            margin-bottom: 30px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 5px solid #10b981;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }
        .card {
            background: var(--surface);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
        }
        .card h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Table Styles */
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
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-title">
                <h1>KELOLA DATA KELAS</h1>
                <p>SIMPRES | SMK Negeri 1 Talamau</p>
            </div>
            <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid-layout">
            <!-- Table Card -->
            <div class="card">
                <h3><i class="fas fa-school"></i> Daftar Kelas</h3>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Kelas</th>
                                <th>Nama Kelas</th>
                                <th>Jumlah Siswa</th>
                                <th>Wali Kelas</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelas as $k)
                                <tr>
                                    <td><code>#{{ $k->id }}</code></td>
                                    <td>
                                        <div style="font-weight: 700; color: var(--secondary);">{{ $k->nama_kelas }}</div>
                                    </td>
                                    <td>
                                        <span style="font-weight: 700; color: var(--primary);">{{ $k->siswas()->count() }} Siswa</span>
                                    </td>
                                    <td>
                                        <form action="/admin/kelas/assign-walikelas/{{ $k->id }}" method="POST" style="display: flex; gap: 8px; align-items: center; margin: 0;">
                                            @csrf
                                            @php
                                                $currentWaliId = $k->siswas()->whereNotNull('walikelas_id')->first()->walikelas_id ?? null;
                                            @endphp
                                            <select name="walikelas_id" class="form-control" style="padding: 6px 10px; font-size: 13px; width: 200px; margin-bottom: 0;" onchange="this.form.submit()">
                                                <option value="">-- Belum Ditugaskan --</option>
                                                @foreach($gurus as $g)
                                                    <option value="{{ $g->id }}" {{ $currentWaliId == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="/admin/kelas/delete/{{ $k->id }}" class="btn btn-danger" style="padding: 8px 12px; font-size: 12px;" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                        Belum ada data kelas. Silakan tambahkan di form sebelah kanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card">
                <h3><i class="fas fa-plus-circle"></i> Tambah Kelas Baru</h3>
                <form action="/admin/kelas/store" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: X RPL 1" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                        <i class="fas fa-save"></i> &nbsp; Simpan Data Kelas
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
