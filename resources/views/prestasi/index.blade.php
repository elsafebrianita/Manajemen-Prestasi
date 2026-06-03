<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Prestasi Siswa - SMK N 1 TALAMAU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --primary-teal: #26817d;
            --bg-cyan: #e6f7f6;
            --text-dark: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-cyan);
            min-height: 100vh;
            padding: 60px 20px;
            color: var(--text-dark);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Formal Academic Header */
        .header-section {
            text-align: center;
            margin-bottom: 60px;
        }
        .header-section .label-top {
            display: block;
            font-size: 16px;
            font-weight: 800;
            color: var(--primary-teal);
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 15px;
        }
        .header-section h1 {
            font-size: 46px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -2px;
            line-height: 1;
        }
        .header-section .school-name {
            display: block;
            font-size: 38px;
            color: var(--primary-teal);
            font-weight: 800;
            margin-top: 5px;
        }
        .header-section .line-decor {
            width: 100px;
            height: 6px;
            background: var(--primary-teal);
            margin: 25px auto;
            border-radius: 50px;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .action-bar h2 { font-size: 22px; font-weight: 800; color: var(--text-dark); }
        
        .btn-add {
            background: var(--primary-teal);
            color: white;
            padding: 15px 30px;
            border-radius: 18px;
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(38, 129, 125, 0.2);
        }
        .btn-add:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(38, 129, 125, 0.3);
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 40px;
            padding: 30px;
            border: 1px solid rgba(38, 129, 125, 0.1);
            box-shadow: 0 20px 50px rgba(38, 129, 125, 0.05);
            overflow-x: auto;
        }

        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th {
            text-align: left;
            padding: 20px;
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-bottom: 2px solid var(--bg-cyan);
        }
        td { padding: 25px 20px; border-bottom: 1px solid var(--bg-cyan); }
        tr:last-child td { border-bottom: none; }

        .student-box { display: flex; flex-direction: column; }
        .s-name { font-weight: 800; color: var(--text-dark); font-size: 16px; }
        .s-nis { font-size: 12px; color: #94a3b8; font-weight: 600; }

        .badge-kategori {
            background: var(--bg-cyan);
            color: var(--primary-teal);
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 800;
        }
        .badge-juara {
            background: #fffbeb;
            color: #f59e0b;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .btn-action {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }
        .btn-edit { background: var(--bg-cyan); color: var(--primary-teal); margin-right: 8px; }
        .btn-delete { background: #fff1f2; color: #e11d48; }

        @media (max-width: 768px) {
            .header-section h1 { font-size: 32px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-section">
            <span class="label-top">Arsip Digital</span>
            <h1>REKAPITULASI PRESTASI SISWA</h1>
            <span class="school-name">SMK N 1 TALAMAU</span>
            <div class="line-decor"></div>
        </header>

        <div class="action-bar">
            <h2>Daftar Capaian Akademik & Bakat</h2>
            <div style="display: flex; gap: 15px;">
                <a href="/dashboard" class="btn-add" style="background: white; color: var(--primary-teal); border: 2px solid var(--primary-teal); box-shadow: none;">
                    <i class="fas fa-house"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/prestasi/create" class="btn-add">
                    <i class="fas fa-plus-circle"></i>
                    <span>Pendataan Prestasi Baru</span>
                </a>
            </div>
        </div>

        <div class="table-card" style="background: transparent; box-shadow: none; padding: 0;">
            @php $groupedPrestasi = $prestasi->groupBy('siswa_id'); @endphp
            
            @forelse($groupedPrestasi as $siswaId => $items)
                @php $siswa = $items->first()->siswa; $totalSiswaPoin = 0; @endphp
                <div style="background: white; border-radius: 25px; margin-bottom: 30px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                    <!-- Student Header -->
                    <div style="background: #f8fafc; padding: 20px 30px; border-bottom: 2px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 45px; height: 45px; background: var(--primary-teal); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px;">
                                {{ substr($siswa->nama ?? 'N', 0, 1) }}
                            </div>
                            <div>
                                <h3 style="font-size: 18px; margin: 0; color: var(--text-dark);">{{ $siswa->nama ?? 'N/A' }}</h3>
                                <p style="font-size: 12px; color: #94a3b8; margin: 0;">NIS: {{ $siswa->nis ?? '-' }} | Kelas: {{ $siswa->kelas ?? '-' }}</p>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Jumlah Pengajuan</span>
                            <div style="font-size: 20px; font-weight: 800; color: var(--primary-teal);">{{ $items->count() }} Prestasi</div>
                        </div>
                    </div>

                    <!-- Achievements List -->
                    <div style="padding: 10px 30px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="text-align: left; border-bottom: 1px solid #f1f5f9;">
                                    <th style="padding: 15px 10px; font-size: 11px; color: #94a3b8;">NAMA PRESTASI</th>
                                    <th style="padding: 15px 10px; font-size: 11px; color: #94a3b8;">TINGKAT & JUARA</th>
                                    <th style="padding: 15px 10px; font-size: 11px; color: #94a3b8; text-align: center;">POIN SISTEM</th>
                                    <th style="padding: 15px 10px; font-size: 11px; color: #94a3b8;">STATUS</th>
                                    <th style="padding: 15px 10px; font-size: 11px; color: #94a3b8; text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $p)
                                    @php if($p->status == 'disetujui') $totalSiswaPoin += $p->poin; @endphp
                                    <tr style="border-bottom: 1px solid #f8fafc;">
                                        <td style="padding: 15px 10px;">
                                            <div style="font-weight: 700; color: var(--text-dark);">{{ $p->nama_prestasi }}</div>
                                            @if($p->lokasi)
                                                <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                                    <i class="fas fa-map-marker-alt" style="color: var(--primary-teal); margin-right: 4px;"></i>{{ $p->lokasi }}
                                                </div>
                                            @endif
                                            @if($p->sertifikat)
                                                <a href="{{ asset('uploads/sertifikat/'.$p->sertifikat) }}" target="_blank" style="font-size: 10px; color: #3b82f6; text-decoration: none; font-weight: 700; display: inline-block; margin-top: 4px;">
                                                    <i class="fas fa-file-invoice"></i> Lihat Sertifikat
                                                </a>
                                            @endif
                                        </td>
                                        <td style="padding: 15px 10px;">
                                            <div style="font-size: 13px; font-weight: 600;">{{ $p->tingkat }}</div>
                                            <div style="font-size: 11px; color: #f59e0b; font-weight: 700;">{{ $p->juara }}</div>
                                        </td>
                                        <td style="padding: 15px 10px; text-align: center;">
                                            <span style="background: #f0fdf4; color: #16a34a; padding: 5px 10px; border-radius: 8px; font-weight: 800; font-size: 12px;">
                                                +{{ $p->poin }}
                                            </span>
                                        </td>
                                        <td style="padding: 15px 10px;">
                                            @if($p->status == 'pending')
                                                <span style="color: #f59e0b; font-size: 10px; font-weight: 800;"><i class="fas fa-clock"></i> PENDING</span>
                                            @elseif($p->status == 'disetujui')
                                                <span style="color: #10b981; font-size: 10px; font-weight: 800;"><i class="fas fa-check-circle"></i> DISETUJUI</span>
                                            @else
                                                <span style="color: #ef4444; font-size: 10px; font-weight: 800;"><i class="fas fa-times-circle"></i> DITOLAK</span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px 10px;">
                                            <div style="display: flex; gap: 5px; justify-content: center;">
                                                @if(in_array(auth()->user()->akses_role, ['admin', 'wakasiswa']) && $p->status == 'pending')
                                                    <form action="/prestasi/verifikasi/{{ $p->id }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="submit" style="background: #10b981; color: white; border: none; padding: 5px 10px; border-radius: 8px; cursor: pointer; font-size: 10px; font-weight: 700;" title="ACC"><i class="fas fa-check"></i></button>
                                                    </form>
                                                    <form action="/prestasi/verifikasi/{{ $p->id }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" style="background: #ef4444; color: white; border: none; padding: 5px 10px; border-radius: 8px; cursor: pointer; font-size: 10px; font-weight: 700;" title="Tolak"><i class="fas fa-times"></i></button>
                                                    </form>
                                                @endif
                                                <a href="/prestasi/edit/{{ $p->id }}" style="background: #f1f5f9; color: #475569; padding: 5px 10px; border-radius: 8px; text-decoration: none; font-size: 10px;"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Student Footer Summary -->
                    <div style="background: #fcfdfe; padding: 15px 30px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 13px; font-weight: 700; color: #64748b;">Akumulasi Skor KPI (Yang Disetujui):</span>
                        <span style="font-size: 18px; font-weight: 800; color: #16a34a;">{{ $totalSiswaPoin }} Poin</span>
                    </div>
                </div>
            @empty
                <div style="background: white; padding: 60px; border-radius: 30px; text-align: center; color: #94a3b8;">
                    <i class="fas fa-folder-open" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                    <p>Belum ada pengajuan prestasi dari siswa.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>