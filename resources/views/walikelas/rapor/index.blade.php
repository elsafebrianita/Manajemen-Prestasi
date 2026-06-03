<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Nilai Rapor Kelas - SIMPRES</title>
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
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            padding: 40px;
        }
        .container {
            max-width: 1300px;
            margin: 0 auto;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 3px double #cbd5e1;
            padding-bottom: 20px;
        }
        .header-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .header-logo i {
            font-size: 45px;
            color: var(--primary);
        }
        .header-title h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--secondary);
            text-transform: uppercase;
        }
        .header-title p {
            color: var(--text-muted);
            font-size: 13px;
            margin-top: 3px;
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
        .btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2); }
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
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-left: 5px solid #ef4444;
        }

        .card {
            background: var(--surface);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }
        
        /* Subject status grid */
        .subject-status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        .subject-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .subject-card h4 {
            font-size: 13px;
            color: var(--secondary);
            font-weight: 700;
            margin-bottom: 8px;
        }
        .subject-card .status-indicator {
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-success { background: #ecfdf5; color: #059669; }
        .badge-warning { background: #fffbeb; color: #d97706; }
        .badge-danger { background: #fef2f2; color: #ef4444; }

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
            border-bottom: 2px solid #cbd5e1;
            background: #f8fafc;
        }
        td {
            padding: 15px;
            font-size: 13px;
            border-bottom: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        tr:hover { background: #fcfdfd; }
        .font-bold { font-weight: 700; color: var(--secondary); }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Official Header -->
        <div class="header-section">
            <div class="header-logo">
                <i class="fas fa-university"></i>
                <div class="header-title">
                    <h1>REKAPITULASI & FINALISASI RAPOR AKHIR</h1>
                    <p>SMK NEGERI 1 TALAMAU | Kelas: <strong>{{ $namaKelas }}</strong> | Wali Kelas: <strong>{{ auth()->user()->name }}</strong></p>
                </div>
            </div>
            <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Monitoring Status Input Guru Mapel -->
        <div class="card">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 16px; color: var(--secondary); margin-bottom: 15px;"><i class="fas fa-tasks"></i> Status Pengisian Nilai oleh Guru Mata Pelajaran</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">Pastikan semua guru mata pelajaran telah melengkapi nilai sebelum melakukan finalisasi rapor.</p>
            
            <div class="subject-status-grid">
                @foreach($mapels as $m)
                    @php
                        $countFilled = 0;
                        foreach($siswas as $s) {
                            $studentGrades = $nilaiSiswas[$s->id] ?? collect();
                            if($studentGrades->firstWhere('mapel_id', $m->id)) {
                                $countFilled++;
                            }
                        }
                        $isComplete = $countFilled == $siswas->count() && $siswas->count() > 0;
                    @endphp
                    <div class="subject-card">
                        <h4>{{ $m->nama_mapel }}</h4>
                        <div class="status-indicator" style="color: {{ $isComplete ? 'var(--success)' : 'var(--warning)' }};">
                            @if($isComplete)
                                <i class="fas fa-check-circle"></i> Lengkap ({{ $countFilled }}/{{ $siswas->count() }})
                            @else
                                <i class="fas fa-exclamation-triangle"></i> Belum Lengkap ({{ $countFilled }}/{{ $siswas->count() }} Terisi)
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Matriks Nilai Rapor Kelas -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                <div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; color: var(--secondary);"><i class="fas fa-file-invoice"></i> Matriks Nilai Siswa</h3>
                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Tabel formal berisi perolehan nilai mata pelajaran dari masing-masing guru pengampu.</p>
                </div>
                
                @if($siswas->isNotEmpty())
                    <form action="/walikelas/rapor/finalisasi" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memproses rata-rata dan menerbitkan rapor kelas ini?');">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calculator"></i> Proses Rata-rata & Terbitkan Rapor
                        </button>
                    </form>
                @endif
            </div>

            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            @foreach($mapels as $m)
                                <th class="text-center">{{ $m->nama_mapel }}</th>
                            @endforeach
                            <th class="text-center" style="background: #eef2ff;">Rata-Rata (C1)</th>
                            <th class="text-center">Status Rapor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $s)
                            @php
                                $studentGrades = $nilaiSiswas[$s->id] ?? collect();
                                $average = $studentGrades->avg('nilai');
                                $missingCount = $mapels->count() - $studentGrades->count();
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-bold">{{ $s->nama }}</div>
                                </td>
                                <td><code>{{ $s->nis }}</code></td>
                                @foreach($mapels as $m)
                                    @php
                                        $grade = $studentGrades->firstWhere('mapel_id', $m->id);
                                    @endphp
                                    <td class="text-center" style="font-weight: 700; color: {{ $grade ? 'var(--secondary)' : 'var(--text-muted)' }};">
                                        {{ $grade ? number_format($grade->nilai, 0) : '-' }}
                                    </td>
                                @endforeach
                                <td class="text-center font-bold" style="background: #f5f8ff; color: var(--primary); font-size: 14px;">
                                    {{ $average ? number_format($average, 2) : '0.00' }}
                                </td>
                                <td class="text-center">
                                    @if($s->penilaian && $s->penilaian->is_verified)
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Terbit</span>
                                    @else
                                        @if($missingCount > 0)
                                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Draft ({{ $missingCount }} kosong)</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Draft (Lengkap)</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 5 + $mapels->count() }}" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <i class="fas fa-info-circle"></i> Tidak ada data siswa di kelas Anda.
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
