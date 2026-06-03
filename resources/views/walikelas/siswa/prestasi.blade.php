<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi Siswa Kelas - SIMPRES</title>
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
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #cbd5e1; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { background: #f8fafc; }

        .card {
            background: var(--surface);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-success { background: #ecfdf5; color: #059669; }
        .badge-warning { background: #fffbeb; color: #d97706; }
        .badge-danger { background: #fef2f2; color: #b91c1c; }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 15px;
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
        .font-bold { font-weight: 700; color: var(--secondary); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-title">
                <h1>MONITORING PRESTASI SISWA KELAS</h1>
                <p>SIMPRES | Wali Kelas: {{ auth()->user()->name }}</p>
            </div>
            <a href="/dashboard" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        <div class="card">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 25px;"><i class="fas fa-medal"></i> Riwayat Prestasi Binaan Kelas</h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Siswa</th>
                            <th>Nama Prestasi</th>
                            <th>Kategori</th>
                            <th>Tingkat</th>
                            <th>Poin KPI</th>
                            <th>Status Validasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasis as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-bold">{{ $p->siswa->nama }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">NIS: {{ $p->siswa->nis }}</div>
                                </td>
                                <td>
                                    <div class="font-bold" style="color: var(--primary);">{{ $p->nama_prestasi }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">
                                        Tanggal: {{ $p->tanggal_capaian ? \Carbon\Carbon::parse($p->tanggal_capaian)->translatedFormat('d M Y') : '-' }}
                                        @if($p->lokasi)
                                            • Lokasi: {{ $p->lokasi }}
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $p->kategori->nama_kategori ?? 'Umum' }}</td>
                                <td>{{ $p->tingkat }}</td>
                                <td class="font-bold">{{ $p->poin }}</td>
                                <td>
                                    @if($p->status == 'disetujui')
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Disetujui</span>
                                    @elseif($p->status == 'ditolak')
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Ditolak</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Validasi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <i class="fas fa-info-circle"></i> Belum ada data prestasi yang diajukan oleh siswa kelas Anda.
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
