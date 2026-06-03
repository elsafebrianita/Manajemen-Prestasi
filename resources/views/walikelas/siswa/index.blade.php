<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Nilai Rapor Siswa - SIMPRES</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }
        .header-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 45px;
            border-bottom: 3px double #cbd5e1;
            padding-bottom: 25px;
            position: relative;
        }
        .header-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        .header-title h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header-title p {
            color: var(--text-muted);
            font-size: 13px;
            margin-top: 5px;
        }
        .class-badge {
            background: var(--primary);
            color: white;
            padding: 3px 10px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 12px;
            margin: 0 5px;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(15, 118, 110, 0.25);
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
            transition: all 0.3s ease;
        }
        .btn-primary { 
            background: var(--primary); 
            color: white;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
        }
        .btn-primary:hover { 
            background: var(--primary-light); 
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(20, 184, 166, 0.3);
        }
        .btn-secondary { 
            background: white; 
            color: var(--secondary); 
            border: 1px solid #cbd5e1; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .btn-secondary:hover { 
            background: #f8fafc;
            transform: translateY(-1px);
        }
        
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
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.05);
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
            border: 1px solid #cbd5e1;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 16px 12px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 2px solid #cbd5e1;
            background: #f8fafc;
        }
        td {
            padding: 16px 12px;
            font-size: 13px;
            border-bottom: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        tr:hover { background: #fcfdfd; }
        .font-bold { font-weight: 700; color: var(--secondary); }
        .text-center { text-align: center; }
        
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header-section">
            <div style="position: absolute; left: 0; top: 15px;">
                <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
            </div>
            <div class="header-logo">
                <img src="{{ asset('logo_asli_smk.png') }}" alt="Logo SMK" style="height: 90px; width: auto; object-fit: contain; margin-bottom: 8px;">
                <div class="header-title">
                    <h1>REKAPITULASI & TRANSPARANSI NILAI SISWA</h1>
                    <p>SMK NEGERI 1 TALAMAU | Kelas: <span class="class-badge">{{ $namaKelas }}</span> | Wali Kelas: <strong>{{ auth()->user()->name }}</strong></p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Transparansi Nilai Guru Mapel & Finalisasi -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                <div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; color: var(--secondary);"><i class="fas fa-list-ol"></i> Daftar Nilai Transparansi Siswa</h3>
                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Wali kelas memantau perolehan masing-masing nilai dari guru mapel terlebih dahulu sebelum menghitung rata-rata akhir.</p>
                </div>
                
                @if($siswas->isNotEmpty())
                    <form action="/walikelas/rapor/finalisasi" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghitung rata-rata akhir dan menerbitkan rapor kelas ini?');">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Hitung Rata-rata & Terbitkan Rapor
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
                                <th class="text-center" style="background: #f8fafc;">{{ $m->nama_mapel }}</th>
                            @endforeach
                            <th class="text-center" style="background: #eef2ff;">Rata-Rata (C1)</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
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
                                
                                <!-- Loop Mapel untuk Nilai Guru Mapel -->
                                @foreach($mapels as $m)
                                    @php
                                        $grade = $studentGrades->firstWhere('mapel_id', $m->id);
                                    @endphp
                                    <td class="text-center font-bold" style="color: {{ $grade ? 'var(--secondary)' : '#a0aec0' }};">
                                        {{ $grade ? number_format($grade->nilai, 0) : '-' }}
                                    </td>
                                @endforeach
                                
                                <!-- Rata-rata (C1) -->
                                <td class="text-center font-bold" style="background: #f5f8ff; color: var(--primary); font-size: 14px;">
                                    {{ $average ? number_format($average, 2) : '0.00' }}
                                </td>
                                
                                <!-- Status Rapor -->
                                <td class="text-center">
                                    @if($s->penilaian && $s->penilaian->is_verified)
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Terbit</span>
                                    @else
                                        @if($missingCount > 0)
                                            <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Draft ({{ $missingCount }} kosong)</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Draft (Lengkap)</span>
                                        @endif
                                    @endif
                                </td>
                                
                                <!-- Aksi -->
                                <td class="text-center" style="display: flex; justify-content: center; gap: 6px; flex-wrap: wrap;">
                                    <a href="/walikelas/siswa/{{ $s->id }}/nilai/edit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; border-radius: 8px; font-weight: 700; background: #2563eb; color: white; border: none;">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <form action="/walikelas/siswa/{{ $s->id }}/nilai/delete" method="POST" onsubmit="return confirm('Hapus semua nilai siswa ini?');" style="display: inline-block; margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; border-radius: 8px; font-weight: 700; background: #dc2626; color: white; border: none;">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                    <a href="/walikelas/siswa/{{ $s->id }}/rapor" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; border-radius: 8px; font-weight: 700; background: var(--primary); color: white; border: none;">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 7 + $mapels->count() }}" style="text-align: center; padding: 40px; color: var(--text-muted);">
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
