<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Mata Pelajaran - SIMPRES</title>
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
            max-width: 1000px;
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
        
        .form-group { margin-bottom: 20px; }
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        .input-nilai {
            width: 80px;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-weight: 700;
            text-align: center;
            outline: none;
        }
        .input-nilai:focus {
            border-color: var(--primary-light);
        }
        
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
                <h1>INPUT NILAI</h1>
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

        @if(session('success'))
            <div class="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Filter Mapel & Kelas -->
        <div class="card">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 20px;"><i class="fas fa-filter"></i> Pilih Kelas & Mata Pelajaran</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Mata Pelajaran & Kelas</label>
                    <select id="mapelKelasSelector" class="form-control" onchange="showStudentsForMapelKelas()">
                        <option value="">-- Pilih --</option>
                        @foreach($guruMapels as $gm)
                            <option value="{{ $gm->kelas_id }}-{{ $gm->mapel_id }}" data-kelas="{{ $gm->kelas_id }}" data-mapel="{{ $gm->mapel_id }}">
                                {{ $gm->mapel->nama_mapel }} - {{ $gm->kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Students Grading Cards (Shown via JavaScript based on selection) -->
        @foreach($guruMapels as $gm)
            <div id="grading-card-{{ $gm->kelas_id }}-{{ $gm->mapel_id }}" class="card grading-card" style="display: none;">
                <form action="/guru/nilai/store" method="POST">
                    @csrf
                    <input type="hidden" name="mapel_id" value="{{ $gm->mapel_id }}">
                    <input type="hidden" name="guru_id" value="{{ auth()->user()->id }}">
                    
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                        <span><i class="fas fa-edit"></i> Input Nilai: {{ $gm->mapel->nama_mapel }} ({{ $gm->kelas->nama_kelas }})</span>
                        <span style="font-size: 12px; color: var(--primary-light);">{{ $gm->kelas->nama_kelas }}</span>
                    </h3>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">Masukkan nilai akademik harian/akhir semester untuk siswa di kelas ini (Rentang 0 - 100).</p>

                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th style="text-align: center; width: 150px;">Nilai Akademik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $className = $gm->kelas->nama_kelas ?? '';
                                    $targetNorm = str_replace('TKJT', 'TKJ', strtoupper(str_replace(' ', '', $className)));
                                    $classStudents = $siswas->filter(function($student) use ($gm, $targetNorm) {
                                        if ($student->kelas_id == $gm->kelas_id) return true;
                                        $sNorm = str_replace('TKJT', 'TKJ', strtoupper(str_replace(' ', '', $student->kelas)));
                                        return !empty($targetNorm) && ($sNorm === $targetNorm || str_starts_with($sNorm, $targetNorm));
                                    })->sortBy('nama');
                                @endphp
                                @forelse($classStudents as $student)
                                    @php
                                        $key = $student->id . '-' . $gm->mapel_id;
                                        $currentNilai = $nilaiSiswas->get($key)->nilai ?? '';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div style="font-weight: 700; color: var(--secondary);">{{ $student->nama }}</div>
                                        </td>
                                        <td><code>{{ $student->nis }}</code></td>
                                        <td style="text-align: center;">
                                            <input type="number" name="nilai[{{ $student->id }}]" min="0" max="100" class="input-nilai" value="{{ $currentNilai }}" placeholder="0">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                            Tidak ada siswa di kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($classStudents->isNotEmpty())
                        <div style="margin-top: 30px; text-align: right;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> &nbsp; Simpan Semua Nilai Kelas
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        @endforeach
    </div>

    <script>
        function showStudentsForMapelKelas() {
            // Hide all grading cards
            const cards = document.querySelectorAll('.grading-card');
            cards.forEach(card => card.style.display = 'none');

            // Get selected value
            const selector = document.getElementById('mapelKelasSelector');
            const selectedVal = selector.value;

            if (selectedVal) {
                const targetCard = document.getElementById('grading-card-' + selectedVal);
                if (targetCard) {
                    targetCard.style.display = 'block';
                }
            }
        }
    </script>
</body>
</html>
