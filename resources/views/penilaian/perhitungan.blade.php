<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Perhitungan KPI - SMK N 1 TALAMAU</title>
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

        .container { max-width: 1100px; margin: 0 auto; }

        .header-section { text-align: center; margin-bottom: 50px; }
        .header-section h1 { font-size: 36px; font-weight: 800; }
        .school-name { color: var(--primary-teal); font-weight: 800; font-size: 24px; }

        .step-card {
            background: white;
            padding: 40px;
            border-radius: 35px;
            margin-bottom: 40px;
            box-shadow: 0 15px 40px rgba(38, 129, 125, 0.05);
            border: 1px solid rgba(38, 129, 125, 0.1);
        }

        .step-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--bg-cyan);
        }
        .step-number {
            background: var(--primary-teal);
            color: white;
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px; font-weight: 800;
        }
        .step-title h2 { font-size: 22px; font-weight: 800; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th {
            text-align: left; padding: 15px;
            background: var(--bg-cyan); color: var(--primary-teal);
            font-size: 13px; font-weight: 800; text-transform: uppercase;
        }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }

        .formula-box {
            background: #f8fafc;
            padding: 15px 25px;
            border-radius: 15px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 700;
            color: #475569;
            margin-bottom: 20px;
            display: inline-block;
        }

        /* Progress Bar Styles Dynamic */
        .progress-container {
            width: 100%;
            background-color: #f1f5f9;
            border-radius: 10px;
            height: 8px;
            margin-top: 5px;
        }
        .progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: 0.5s;
        }
        .bg-low { background: #ef4444; } /* Red */
        .bg-mid { background: #f59e0b; } /* Yellow */
        .bg-good { background: #26817d; } /* Teal */
        .bg-high { background: #10b981; } /* Green */

        /* Formula Card */
        .formula-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 30px;
            border-radius: 25px;
            margin-bottom: 40px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .formula-card h3 { color: #2dd4bf; margin-bottom: 15px; font-size: 20px; }
        .formula-main { font-size: 28px; font-weight: 800; font-family: 'Courier New', Courier, monospace; margin-bottom: 15px; }
        .formula-desc { font-size: 14px; color: #94a3b8; line-height: 1.6; }

        /* Badge Styles */
        .badge-bakat {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .badge-gi { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-sa { background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8; }
        .badge-gs { background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
        .badge-ga { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

        .insight-text {
            font-size: 12px;
            color: #64748b;
            font-style: italic;
            margin-top: 5px;
            display: block;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            background: var(--primary-teal);
            padding: 15px 30px;
            border-radius: 15px;
            font-weight: 800;
            transition: 0.3s;
        }
        .btn-back:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(38, 129, 125, 0.2); }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-section">
            <h1>Transparansi Perhitungan KPI</h1>
            <p class="school-name">SMK N 1 TALAMAU</p>
        </header>

        <!-- FORMULA SECTION -->
        <div class="formula-card">
            <h3><i class="fas fa-microchip"></i> Rumus Inti Metode KPI</h3>
            <div class="formula-main">KPI = (A &times; {{ $wA }}) + (B &times; {{ $wB }}) + (C &times; {{ $wC }}) + (D &times; {{ $wD }})</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="formula-desc">
                    <strong>Keterangan Variabel:</strong><br>
                    • <b>A (Akademik)</b>: Nilai Rapor Semester Terakhir.<br>
                    • <b>B (Prestasi Akad)</b>: Sertifikat Lomba Akademik.<br>
                    • <b>C (Organisasi)</b>: Kepemimpinan & Organisasi.<br>
                    • <b>D (Non-Akademik)</b>: Seni & Olahraga.
                </div>
                <div class="formula-desc">
                    <strong>Standar Pembobotan (FIX FINAL):</strong><br>
                    • Bobot A: {{ $wA * 100 }}%<br>
                    • Bobot B: {{ $wB * 100 }}%<br>
                    • Bobot C: {{ $wC * 100 }}%<br>
                    • Bobot D: {{ $wD * 100 }}%
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <p style="color: #64748b; font-weight: 600;">Langkah-langkah sistematis perhitungan kinerja siswa sesuai standar Akademik Sekolah.</p>
            <a href="/penilaian/proses-kpi" class="btn-back" style="background: #f59e0b;">
                <i class="fas fa-sync-alt"></i>
                <span>Proses Ulang KPI</span>
            </a>
        </div>

        <!-- STEP 1: MATRIKS KINERJA -->
        <div class="step-card">
            <div class="step-title">
                <div class="step-number">1</div>
                <h2>Matriks Kinerja Aktual & Capaian Indikator</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>KPI A (Akademik)</th>
                        <th>KPI B (Prestasi Akad)</th>
                        <th>KPI C (Organisasi)</th>
                        <th>KPI D (Non-Akad)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataKpi as $data)
                        <tr>
                            <td><strong>{{ $data['nama'] }}</strong></td>
                            @php $caps = [$data['nA'], $data['nB'], $data['nC'], $data['nD']]; @endphp
                            @foreach($caps as $c)
                            <td>
                                <span style="font-weight: 700;">{{ number_format($c*100, 1) }}%</span>
                                <div class="progress-container">
                                    <div class="progress-bar @if($c < 0.4) bg-low @elseif($c < 0.6) bg-mid @elseif($c < 0.8) bg-good @else bg-high @endif" 
                                         style="width: {{ $c*100 }}%"></div>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- STEP 2: PERHITUNGAN MATEMATIKA -->
        <div class="step-card">
            <div class="step-title">
                <div class="step-number">2</div>
                <h2>Transparansi Matematika KPI</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Indikator & Perhitungan</th>
                        <th style="background: #f1f5f9; text-align: center;">Skor Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataKpi as $data)
                        <tr>
                            <td><strong>{{ $data['nama'] }}</strong></td>
                            <td>
                                <div style="font-size: 13px; line-height: 1.8;">
                                    (A: {{ number_format($data['nA']*100, 1) }}% &times; {{ $wA }}) + 
                                    (B: {{ number_format($data['nB']*100, 1) }}% &times; {{ $wB }}) + 
                                    (C: {{ number_format($data['nC']*100, 1) }}% &times; {{ $wC }}) + 
                                    (D: {{ number_format($data['nD']*100, 1) }}% &times; {{ $wD }})
                                </div>
                            </td>
                            <td style="background: #f8fafc; font-size: 18px; font-weight: 800; color: var(--primary-teal); text-align: center;">
                                {{ number_format($data['total']*100, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- STEP 3: HASIL & INTERPRETASI -->
        <div class="step-card">
            <div class="step-title">
                <div class="step-number">3</div>
                <h2>Interpretasi Hasil & Dominasi Bakat</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">Rank</th>
                        <th>Identitas Siswa</th>
                        <th>Kategori Kinerja</th>
                        <th>Bakat Dominan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataKpi as $index => $data)
                        <tr>
                            <td style="text-align: center;">
                                <div style="font-size: 24px; font-weight: 800; color: #cbd5e1;">#{{ $index + 1 }}</div>
                            </td>
                            <td>
                                <strong style="font-size: 16px;">{{ $data['nama'] }}</strong><br>
                                <small class="insight-text">Skor Indeks: {{ number_format($data['total']*100, 2) }}</small>
                            </td>
                            <td>
                                @php
                                    $t = $data['total'];
                                    $label = 'Kurang'; $color = '#ef4444';
                                    if($t >= 0.8) { $label = 'Sangat Baik'; $color = '#10b981'; }
                                    elseif($t >= 0.6) { $label = 'Baik'; $color = '#26817d'; }
                                    elseif($t >= 0.4) { $label = 'Cukup'; $color = '#f59e0b'; }
                                @endphp
                                <span style="background: {{ $color }}; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 800;">
                                    {{ $label }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $bakatRaw = $data['p']->bakat_dominan ?? '';
                                    $badgeClass = 'badge-gi';
                                    if(str_contains($bakatRaw, 'Spesifik')) $badgeClass = 'badge-sa';
                                    if(str_contains($bakatRaw, 'Kepemimpinan')) $badgeClass = 'badge-gs';
                                    if(str_contains($bakatRaw, 'Seni')) $badgeClass = 'badge-ga';
                                @endphp
                                <span class="badge-bakat {{ $badgeClass }}">
                                    {{ $data['p']->bakat_dominan ?? 'Analisis Pending' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="text-align: center; margin-bottom: 100px; display: flex; justify-content: center; gap: 20px;">
            <a href="/penilaian" class="btn-back" style="background: #64748b;">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <a href="/dashboard" class="btn-back">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
</body>
</html>
    </div>
</body>
</html>
