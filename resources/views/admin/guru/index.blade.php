<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Guru - SIMPRES</title>
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
            max-width: 1400px;
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
            grid-template-columns: 3.2fr 1.8fr;
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
        
        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-guru { background: #eff6ff; color: #2563eb; }
        .badge-walas { background: #fdf2f8; color: #db2777; }
        .badge-kepsek { background: #faf5ff; color: #7c3aed; }
        .badge-wakasiswa { background: #fff7ed; color: #ea580c; }
        
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
                <h1>KELOLA DATA GURU & WALI KELAS</h1>
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
                <h3><i class="fas fa-users-cog"></i> Daftar Guru & Wali Kelas</h3>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;">No</th>
                                <th>Nama Guru</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gurus as $index => $g)
                                <tr>
                                    <td style="text-align: center; color: var(--text-muted); font-weight: 600;">{{ $index + 1 }}</td>
                                    <td>
                                        <div style="font-weight: 700; color: var(--secondary);">{{ $g->name }}</div>
                                    </td>
                                    <td><code>{{ $g->nip ?? '-' }}</code></td>
                                    <td>
                                        <div style="font-weight: 600; color: var(--text-main);">{{ $g->jabatan ?? 'Guru Mapel' }}</div>
                                    </td>
                                    <td>{{ $g->email }}</td>
                                    <td>
                                        @if($g->role == 'kepsek')
                                            <span class="badge badge-kepsek">Kepala Sekolah</span>
                                        @elseif($g->role == 'wakasiswa')
                                            <span class="badge badge-wakasiswa">Waka Kesiswaan</span>
                                        @elseif($g->role == 'walikelas')
                                            <span class="badge badge-walas">Wali Kelas</span>
                                        @else
                                            <span class="badge badge-guru">Guru Mapel</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="/admin/guru/delete/{{ $g->id }}" class="btn btn-danger" style="padding: 8px 12px; font-size: 12px;" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                        Belum ada data guru. Silakan tambahkan di form sebelah kanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Column -->
            <div style="display: flex; flex-direction: column; gap: 25px;">
                <!-- Import Card -->
                <div class="card">
                    <h3><i class="fas fa-file-excel"></i> Import Guru dari Excel</h3>
                    <form action="/admin/guru/import" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Pilih File Excel (.xlsx)</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx">
                            <small style="color: var(--text-muted); font-size: 11px; margin-top: 5px; display: block;">
                                *Jika file dikosongkan, sistem akan otomatis menyinkronkan dari file di folder Downloads.
                            </small>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background-color: #059669;">
                            <i class="fas fa-upload"></i> &nbsp; Unggah & Sinkronkan
                        </button>
                    </form>
                </div>

                <!-- Form Card -->
                <div class="card">
                    <h3><i class="fas fa-user-plus"></i> Tambah Guru Baru</h3>
                <form action="/admin/guru/store" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Lengkap & Gelar</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso, S.Pd" required>
                    </div>
                    <div class="form-group">
                        <label>Username (Untuk Login)</label>
                        <input type="text" name="username" class="form-control" placeholder="Contoh: budismk" required>
                    </div>
                    <div class="form-group">
                        <label>Email Resmi</label>
                        <input type="email" name="email" class="form-control" placeholder="Contoh: budi@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label>Peran / Jabatan</label>
                        <select name="role" class="form-control" required>
                            <option value="guru">Guru Mata Pelajaran</option>
                            <option value="walikelas">Wali Kelas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password Akun</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                        <i class="fas fa-save"></i> &nbsp; Simpan Data Guru
                    </button>
                </form>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
