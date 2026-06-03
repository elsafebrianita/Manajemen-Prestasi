<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis KPI - SIMPRES</title>
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

        .card {
            background: var(--surface);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }
        
        /* Weights display styling */
        .weights-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .weight-card {
            background: #f8fafc;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #cbd5e1;
            text-align: center;
        }
        .weight-card h4 {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .weight-card div {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-title">
                <h1>ANALISIS KPI SISWA KELAS</h1>
                <p>SIMPRES | Hitung KPI & Bakat Dominan berdasarkan 4 indikator nilai siswa.</p>
            </div>
            <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Bobot Kriteria Card -->
        <div class="card">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                <span><i class="fas fa-balance-scale"></i> Bobot Kriteria Penilaian KPI</span>
                <form action="/walikelas/kpi/kalkulasi" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sync-alt"></i> &nbsp; Kalkulasi Ulang KPI
                    </button>
                </form>
            </h3>
            
            <div class="weights-grid">
                <div class="weight-card">
                    <h4>C1 - Nilai Akademik (Rata-Rata)</h4>
                    <div>{{ $wA * 100 }}%</div>
                </div>
                <div class="weight-card">
                    <h4>C2 - Prestasi Akademik</h4>
                    <div>{{ $wB * 100 }}%</div>
                </div>
                <div class="weight-card">
                    <h4>C3 - Jabatan Organisasi</h4>
                    <div>{{ $wC * 100 }}%</div>
                </div>
                <div class="weight-card">
                    <h4>C4 - Prestasi Non-Akademik</h4>
                    <div>{{ $wD * 100 }}%</div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fas fa-trophy"></i> Hasil Perankingan & Indikator KPI Siswa</span>
                <span style="font-size: 12px; color: var(--text-muted); font-weight: normal;">*Indikator Rapor, Akademik, Organisasi, dan Non-Akademik diambil secara real-time dari data tervalidasi.</span>
            </h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 70px;">Rank</th>
                            <th>Nama Siswa</th>
                            <th style="text-align: center;">Akademik (C2)</th>
                            <th style="text-align: center;">Organisasi (C3)</th>
                            <th style="text-align: center;">Non Akademik (C4)</th>
                            <th style="text-align: center;">Rapor (C1)</th>
                            <th style="text-align: center;">Skor KPI</th>
                            <th>Bakat Dominan</th>
                            <th style="text-align: center; width: 180px;">Rekomendasi Publikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas->sortByDesc('penilaian.skor_akhir') as $index => $s)
                            @php
                                $live = $s->live_indicators;
                                $penilaian = $s->penilaian;
                            @endphp
                            <tr style="{{ $penilaian && $penilaian->is_recommended ? 'background: rgba(16, 185, 129, 0.03);' : '' }}">
                                <td>
                                    <div style="font-weight: 800; color: {{ $index < 3 ? '#f59e0b' : '#64748b' }}; font-size: 16px;">
                                        #{{ $penilaian->ranking ?? ($index + 1) }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--secondary);">{{ $s->nama }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">NIS: {{ $s->nis }}</div>
                                </td>
                                <td style="text-align: center;">
                                    <span style="font-weight: 600; color: {{ $live['c2'] > 0 ? 'var(--primary)' : 'var(--text-muted)' }}">{{ number_format($live['c2'], 1) }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span style="font-weight: 600; color: {{ $live['c3'] > 0 ? 'var(--primary)' : 'var(--text-muted)' }}">{{ number_format($live['c3'], 1) }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span style="font-weight: 600; color: {{ $live['c4'] > 0 ? 'var(--primary)' : 'var(--text-muted)' }}">{{ number_format($live['c4'], 1) }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span style="font-weight: 600; color: {{ $live['c1'] > 0 ? 'var(--primary)' : 'var(--text-muted)' }}">{{ number_format($live['c1'], 1) }}</span>
                                </td>
                                <td style="text-align: center;">
                                    @if($penilaian)
                                        <span style="font-weight: 800; color: var(--primary); font-size: 15px;">
                                            {{ number_format($penilaian->kpi_score, 1) }}
                                        </span>
                                    @else
                                        <span style="font-size: 11px; color: #ef4444; font-weight: 700;">Belum Dihitung</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-weight: 700; color: #475569; font-size: 12px; background: #e2e8f0; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                                        {{ $penilaian->bakat_dominan ?? 'Belum Kalkulasi' }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    @if($penilaian)
                                        <form action="/walikelas/kpi/rekomendasi/{{ $penilaian->id }}" method="POST" style="display: inline;">
                                            @csrf
                                            @if($penilaian->is_recommended)
                                                <button type="submit" class="btn" style="background: #10b981; color: white; padding: 8px 12px; font-size: 11px; border-radius: 8px; box-shadow: 0 2px 5px rgba(16,185,129,0.2);">
                                                    <i class="fas fa-check-circle"></i> Direkomendasikan
                                                </button>
                                            @else
                                                <button type="submit" class="btn" style="background: white; border: 1px solid #10b981; color: #10b981; padding: 8px 12px; font-size: 11px; border-radius: 8px;">
                                                    <i class="far fa-circle"></i> Rekomendasikan
                                                </button>
                                            @endif
                                        </form>

                                        @if($penilaian->is_proposed)
                                            <div style="margin-top: 5px;">
                                                @if($penilaian->kepsek_status === 'layak')
                                                    <span style="font-size: 10px; color: #10b981; font-weight: 700;"><i class="fas fa-award"></i> Disetujui Kepsek (Layak)</span>
                                                @elseif($penilaian->kepsek_status === 'tidak_layak')
                                                    <span style="font-size: 10px; color: #ef4444; font-weight: 700;"><i class="fas fa-times-circle"></i> Ditolak Kepsek</span>
                                                @else
                                                    <span style="font-size: 10px; color: #f59e0b; font-weight: 700;"><i class="fas fa-hourglass-half"></i> Proses Usulan</span>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <button class="btn" style="background: #cbd5e1; color: #94a3b8; padding: 8px 12px; font-size: 11px; border-radius: 8px; cursor: not-allowed;" disabled>
                                            Hitung KPI Dulu
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <i class="fas fa-info-circle"></i> Tidak ada data siswa atau hasil kalkulasi.
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
