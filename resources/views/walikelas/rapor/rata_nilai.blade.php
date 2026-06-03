<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rata-rata Nilai Kelas - SIMPRES</title>
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
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #cbd5e1; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { background: #f8fafc; }

        .card {
            background: var(--surface);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: var(--surface);
            padding: 24px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #eef7f6;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .stat-info h4 { font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; }
        .stat-info div { font-size: 24px; font-weight: 800; color: var(--secondary); }

        .bar-container {
            width: 100%;
            background: #e2e8f0;
            border-radius: 8px;
            height: 10px;
            overflow: hidden;
            margin-top: 8px;
        }
        .bar-fill {
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            height: 100%;
            border-radius: 8px;
            transition: width 1s ease-in-out;
        }
        
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-title">
                <h1>RATA-RATA NILAI MATA PELAJARAN</h1>
                <p>SIMPRES | Kelas: {{ $namaKelas }} | Wali Kelas: {{ auth()->user()->name }}</p>
            </div>
            <a href="/dashboard" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        @php
            $overallSum = 0;
            $overallCount = 0;
            $highestSubject = '';
            $highestAvg = 0;
            $lowestSubject = '';
            $lowestAvg = 100;
            
            foreach($subjectAverages as $mapelId => $avg) {
                $mapelName = $mapels->firstWhere('id', $mapelId)->nama_mapel ?? 'Mapel';
                $overallSum += $avg;
                $overallCount++;
                
                if($avg > $highestAvg) {
                    $highestAvg = $avg;
                    $highestSubject = $mapelName;
                }
                if($avg < $lowestAvg && $avg > 0) {
                    $lowestAvg = $avg;
                    $lowestSubject = $mapelName;
                }
            }
            $overallAverage = $overallCount > 0 ? ($overallSum / $overallCount) : 0;
        @endphp

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calculator"></i></div>
                <div class="stat-info">
                    <h4>Rata-Rata Kelas</h4>
                    <div>{{ number_format($overallAverage, 2) }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #ecfdf5; color: #10b981;"><i class="fas fa-arrow-trend-up"></i></div>
                <div class="stat-info">
                    <h4>Rata-Rata Tertinggi</h4>
                    <div>{{ number_format($highestAvg, 2) }} <span style="font-size: 11px; color: var(--text-muted); font-weight: normal;">({{ $highestSubject ?: '-' }})</span></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fffbeb; color: #f59e0b;"><i class="fas fa-arrow-trend-down"></i></div>
                <div class="stat-info">
                    <h4>Rata-Rata Terendah</h4>
                    <div>{{ number_format($lowestAvg == 100 ? 0 : $lowestAvg, 2) }} <span style="font-size: 11px; color: var(--text-muted); font-weight: normal;">({{ $lowestSubject ?: '-' }})</span></div>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 25px;"><i class="fas fa-chart-bar"></i> Distribusi Rata-Rata Nilai per Mata Pelajaran</h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Mata Pelajaran</th>
                            <th style="width: 40%; text-align: center;">Visualisasi Capaian</th>
                            <th style="text-align: right;">Rata-Rata Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapels as $index => $m)
                            @php
                                $avgVal = $subjectAverages[$m->id] ?? 0;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="font-weight: 700; color: var(--secondary);">{{ $m->nama_mapel }}</td>
                                <td>
                                    <div class="bar-container">
                                        <div class="bar-fill" style="width: {{ $avgVal }}%;"></div>
                                    </div>
                                </td>
                                <td style="text-align: right; font-weight: 800; color: var(--primary);">
                                    {{ number_format($avgVal, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <i class="fas fa-info-circle"></i> Tidak ada data rata-rata mata pelajaran.
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
