<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rapor Siswa - SIMPRES</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d9488;
            --primary-light: #ccfbf1;
            --primary-dark: #0f766e;
            --secondary: #0f172a;
            --bg-color: #f8fafc;
            --surface: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            
            /* Grade Colors */
            --color-a: #10b981;
            --color-a-light: #ecfdf5;
            --color-b: #3b82f6;
            --color-b-light: #eff6ff;
            --color-c: #f59e0b;
            --color-c-light: #fffbeb;
            --color-d: #ef4444;
            --color-d-light: #fef2f2;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            padding: 30px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ------------------------------------------------------------- */
        /* SCREEN ONLY STYLES (MODERN DASHBOARD)                         */
        /* ------------------------------------------------------------- */
        
        .screen-only {
            display: block;
        }

        /* Dashboard Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .back-link {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary-dark);
            transform: translateX(-3px);
        }

        .btn-print {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15);
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(13, 148, 136, 0.25);
        }

        /* Modern Status Banners */
        .modern-banner {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 30px;
            border-width: 1px;
            border-style: solid;
        }

        .banner-success {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        .banner-warning {
            background: #fffbeb;
            border-color: #fef3c7;
            color: #92400e;
        }

        .banner-icon {
            font-size: 22px;
            margin-top: 2px;
        }

        .banner-text h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .banner-text p {
            font-size: 13px;
            opacity: 0.9;
            line-height: 1.5;
        }

        /* Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        @media (min-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 350px 1fr;
            }
        }

        /* Cards styling */
        .dashboard-card {
            background: var(--surface);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            margin-bottom: 25px;
        }

        /* Sidebar Profile Card */
        .profile-card {
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            font-size: 28px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.25);
        }

        .student-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 6px;
        }

        .student-nis {
            font-size: 13px;
            color: var(--text-muted);
            font-family: monospace;
            background: #f1f5f9;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .info-divider {
            height: 1px;
            background: var(--border-color);
            margin: 20px 0;
        }

        .student-meta-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .student-meta-item:last-child {
            margin-bottom: 0;
        }

        .meta-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .meta-value {
            color: var(--secondary);
            font-weight: 700;
            text-align: right;
            max-width: 60%;
        }

        /* Sidebar Performance Card */
        .performance-card {
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--secondary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .kpi-score-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .kpi-score-circle {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 8px solid var(--primary-light);
            border-top-color: var(--primary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transform: rotate(-45deg);
            animation: spinCircle 1s ease-out forwards;
        }

        .kpi-score-num {
            font-size: 26px;
            font-weight: 800;
            color: var(--secondary);
            transform: rotate(45deg);
        }

        .kpi-score-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-muted);
            transform: rotate(45deg);
            margin-top: 2px;
        }

        @keyframes spinCircle {
            to { transform: rotate(0deg); }
        }

        .stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .stat-box i {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .text-gold { color: #d97706; }
        .text-purple { color: #8b5cf6; }

        .stat-val {
            font-size: 15px;
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 2px;
        }

        .stat-lbl {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .insight-box {
            background: #eff6ff;
            border-left: 4px solid var(--color-b);
            border-radius: 0 12px 12px 0;
            padding: 15px;
            font-size: 12px;
        }

        .insight-title {
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .insight-desc {
            color: #1e3a8a;
            line-height: 1.5;
        }

        /* Summary Header Card */
        .summary-card {
            background: linear-gradient(135deg, var(--secondary), #1e293b);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
        }

        .summary-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            display: block;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 38px;
            font-weight: 800;
            color: white;
            line-height: 1;
        }

        .summary-spelled {
            font-size: 13px;
            color: #cbd5e1;
            margin-top: 6px;
            font-style: italic;
        }

        .academic-badge-lg {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 32px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        /* Subject rows styling */
        .subjects-card {
            padding-bottom: 10px;
        }

        .subjects-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .subject-row {
            display: grid;
            grid-template-columns: 1.5fr 1.2fr 80px;
            align-items: center;
            gap: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .subject-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .subject-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .subject-num {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f1f5f9;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .subject-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 2px;
        }

        .subject-kkm {
            font-size: 11px;
            color: var(--text-muted);
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .subject-progress-container {
            display: flex;
            align-items: center;
        }

        .progress-bar-bg {
            width: 100%;
            height: 8px;
            background: #f1f5f9;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Grade Pill Styling */
        .subject-grade-val {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .score-number {
            font-size: 16px;
            font-weight: 800;
            color: var(--secondary);
        }

        .score-number.empty {
            color: #cbd5e1;
        }

        .score-badge {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
        }

        .score-badge.empty {
            background: #f1f5f9;
            color: #cbd5e1;
        }

        /* Grade Colors mapping */
        .grade-a { background: var(--color-a-light); color: var(--color-a); }
        .grade-b { background: var(--color-b-light); color: var(--color-b); }
        .grade-c { background: var(--color-c-light); color: var(--color-c); }
        .grade-d { background: var(--color-d-light); color: var(--color-d); }

        .progress-bar-fill.grade-a { background: var(--color-a); }
        .progress-bar-fill.grade-b { background: var(--color-b); }
        .progress-bar-fill.grade-c { background: var(--color-c); }
        .progress-bar-fill.grade-d { background: var(--color-d); }


        /* ------------------------------------------------------------- */
        /* PRINT ONLY STYLES (TRADITIONAL FORMAL REPORT)                 */
        /* ------------------------------------------------------------- */
        
        .print-only {
            display: none;
        }

        /* Print Layout Rules */
        @media print {
            .screen-only {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            body {
                background: white !important;
                color: #000 !important;
                padding: 0 !important;
                font-family: 'Inter', sans-serif !important;
            }
            
            /* Official Report Card Style */
            .rapor-paper {
                background: white !important;
                padding: 30px 10px;
                border: none !important;
                color: #000 !important;
            }
            
            /* Kop Surat Resmi */
            .kop-surat {
                text-align: center;
                border-bottom: 4px double #000 !important;
                padding-bottom: 12px;
                margin-bottom: 25px;
            }
            .kop-surat h2 { font-size: 16px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
            .kop-surat h1 { font-size: 20px; font-weight: 800; text-transform: uppercase; margin: 3px 0; }
            .kop-surat p { font-size: 10px; font-style: italic; color: #475569; }

            .rapor-title {
                text-align: center;
                text-transform: uppercase;
                font-weight: 800;
                font-size: 14px;
                text-decoration: underline;
                margin-bottom: 25px;
            }

            /* Profile Block */
            .rapor-profile-table {
                width: 100%;
                margin-bottom: 20px;
                font-size: 12px;
                border-collapse: collapse;
            }
            .rapor-profile-table td {
                border: none !important;
                padding: 3px 6px !important;
            }
            .rapor-profile-table td:nth-child(1),
            .rapor-profile-table td:nth-child(4) {
                font-weight: 600;
                width: 140px;
            }
            .rapor-profile-table td:nth-child(2),
            .rapor-profile-table td:nth-child(5) {
                width: 10px;
            }

            /* Grades Table */
            .table-grades {
                width: 100%;
                border-collapse: collapse !important;
                margin-bottom: 30px;
            }
            .table-grades th {
                border: 2px solid #000 !important;
                background: #f1f5f9 !important;
                color: #000 !important;
                font-weight: 700;
                padding: 8px;
                font-size: 11px;
                text-align: center;
                text-transform: uppercase;
            }
            .table-grades td {
                border: 1px solid #000 !important;
                padding: 8px;
                font-size: 11px;
                color: #000 !important;
                background: transparent !important;
            }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .font-bold { font-weight: 700; }

            /* KPI block */
            .kpi-info-box {
                border: 1px solid #000 !important;
                padding: 12px;
                margin-bottom: 30px;
                font-size: 11px;
            }
            .kpi-info-box h4 {
                text-transform: uppercase;
                font-weight: 700;
                margin-bottom: 6px;
                border-bottom: 1px solid #000;
                padding-bottom: 3px;
            }
            .kpi-info-box table td {
                border: none !important;
                padding: 3px 0 !important;
            }

            /* Signatures */
            .signatures-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
                margin-top: 35px;
                font-size: 11px;
                text-align: center;
            }
            .signature-box {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        @php
            // Spelling function for grades helper
            if (!function_exists('terbilangDetail')) {
                function terbilangDetail($angka) {
                    $angka = abs((int)$angka);
                    $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                    $terbilang = "";
                    if ($angka < 12) {
                        $terbilang = " " . $baca[$angka];
                    } else if ($angka < 20) {
                        $terbilang = terbilangDetail($angka - 10) . " Belas";
                    } else if ($angka < 100) {
                        $terbilang = terbilangDetail(floor($angka / 10)) . " Puluh" . terbilangDetail($angka % 10);
                    }
                    return trim($terbilang);
                }
            }

            // Calculate Averages
            $gradesCount = $nilaiSiswas->count();
            $gradesSum = 0;
            foreach($mapels as $m) {
                $grade = $nilaiSiswas->get($m->id);
                if($grade) {
                    $gradesSum += $grade->nilai;
                }
            }
            $calculatedAverage = $gradesCount > 0 ? ($gradesSum / $gradesCount) : 0;
            $displayAverage = ($penilaian && $penilaian->is_published) ? $penilaian->c1 : $calculatedAverage;

            // Get Kepsek User
            $kepsek = \App\Models\User::where(function($q) {
                $q->where('jabatan', 'kepala_sekolah')
                  ->orWhere('jabatan', 'kepsek');
            })->first();
            $kepsekName = $kepsek ? $kepsek->name : 'Susi Erawati S.Pd';
            $kepsekNip = $kepsek ? $kepsek->nip : '197606212006042010';
        @endphp

        <!-- =================================================================== -->
        <!-- SCREEN VIEW: PREMIUM ACADEMIC DASHBOARD                             -->
        <!-- =================================================================== -->
        <div class="screen-only">
            
            <!-- Dashboard Header Navigation -->
            <div class="dashboard-header">
                <a href="/walikelas/siswa" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
                </a>
                <button onclick="window.print()" class="btn-print">
                    <i class="fas fa-print"></i> Cetak Rapor (PDF)
                </button>
            </div>

            <!-- Status Rapor Banner -->
            @if($penilaian && $penilaian->is_published)
                <div class="modern-banner banner-success">
                    <div class="banner-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="banner-text">
                        <h3>Rapor Resmi Telah Terbit</h3>
                        <p>Rapor kelas siswa ini telah dikalkulasi secara final dan diterbitkan. Siswa dapat melihat transparansi nilai mapel dan kinerja bakat ini langsung di portal mereka.</p>
                    </div>
                </div>
            @else
                <div class="modern-banner banner-warning">
                    <div class="banner-icon"><i class="fas fa-exclamation-circle"></i></div>
                    <div class="banner-text">
                        <h3>Rapor Masih Berstatus Draft</h3>
                        <p>Rapor ini masih berstatus draf. Nilai rata-rata akademik dan bakat dominan belum dirilis ke akun siswa. Untuk mempublikasikan nilai ini, lakukan finalisasi rapor melalui tombol "Hitung Rata-rata & Terbitkan Rapor" di halaman depan.</p>
                    </div>
                </div>
            @endif

            <!-- Main Dashboard Grid -->
            <div class="dashboard-grid">
                
                <!-- Left Column: Student Profile & KPI Details -->
                <div class="dashboard-sidebar">
                    
                    <!-- Profile Card -->
                    <div class="dashboard-card profile-card">
                        <div class="profile-avatar">
                            @php
                                $words = explode(' ', $siswa->nama);
                                $initials = '';
                                foreach (array_slice($words, 0, 2) as $w) {
                                    $initials .= strtoupper(substr($w, 0, 1));
                                }
                            @endphp
                            {{ $initials }}
                        </div>
                        <h2 class="student-name">{{ $siswa->nama }}</h2>
                        <span class="student-nis">NIS: {{ $siswa->nis }}</span>
                        
                        <div class="info-divider"></div>
                        
                        <div class="student-meta-item">
                            <span class="meta-label">Kelas</span>
                            <span class="meta-value">{{ $siswa->kelasRel->nama_kelas ?? $siswa->kelas }}</span>
                        </div>
                        <div class="student-meta-item">
                            <span class="meta-label">Kompetensi Keahlian</span>
                            <span class="meta-value">{{ $siswa->jurusan }}</span>
                        </div>
                        <div class="student-meta-item">
                            <span class="meta-label">Wali Kelas</span>
                            <span class="meta-value">{{ $siswa->walikelas->name ?? 'Belum Ditentukan' }}</span>
                        </div>
                    </div>

                    <!-- Kinerja SAW KPI & Bakat Card -->
                    <div class="dashboard-card performance-card">
                        <h3 class="card-title"><i class="fas fa-chart-line text-primary"></i> Evaluasi Kinerja & Bakat</h3>
                        
                        <div class="kpi-score-wrapper">
                            <div class="kpi-score-circle">
                                <span class="kpi-score-num">{{ $penilaian ? number_format($penilaian->kpi_score, 1) : '0.0' }}</span>
                                <span class="kpi-score-label">Skor KPI</span>
                            </div>
                        </div>

                        <div class="stats-row">
                            <div class="stat-box">
                                <i class="fas fa-trophy text-gold"></i>
                                <span class="stat-val">#{{ $penilaian->ranking ?? '-' }}</span>
                                <span class="stat-lbl">Peringkat</span>
                            </div>
                            <div class="stat-box">
                                <i class="fas fa-lightbulb text-purple"></i>
                                <span class="stat-val" style="font-size: 11px; font-weight: 800;">
                                    @php
                                        $bakatName = $penilaian->bakat_dominan ?? 'Belum Ditentukan';
                                        if (strpos($bakatName, '(') !== false) {
                                            $bakatName = explode(' (', $bakatName)[0];
                                        }
                                    @endphp
                                    {{ $bakatName }}
                                </span>
                                <span class="stat-lbl">Bakat Dominan</span>
                            </div>
                        </div>

                        <div class="insight-box">
                            <div class="insight-title"><i class="fas fa-brain text-primary"></i> Rekomendasi Karir</div>
                            <p class="insight-desc">{{ $penilaian->insight_kinerja ?? 'Belum ada rekomendasi' }}</p>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Academic Summary & Grades -->
                <div class="dashboard-main">
                    
                    <!-- Summary Card (Rata-rata) -->
                    <div class="dashboard-card summary-card">
                        <div>
                            <span class="summary-label">Rata-Rata Akademik (C1)</span>
                            <h1 class="summary-value">{{ number_format($displayAverage, 2) }}</h1>
                            <p class="summary-spelled">{{ terbilangDetail($displayAverage) }} Poin</p>
                        </div>
                        <div class="academic-badge-lg">
                            @php
                                $avgGrade = $displayAverage >= 90 ? 'A' : ($displayAverage >= 80 ? 'B' : ($displayAverage >= 75 ? 'C' : 'D'));
                            @endphp
                            {{ $avgGrade }}
                        </div>
                    </div>

                    <!-- Grades Card -->
                    <div class="dashboard-card subjects-card">
                        <h3 class="card-title"><i class="fas fa-list-check text-primary"></i> Transparansi Nilai Guru Mapel</h3>
                        
                        <div class="subjects-list">
                            @forelse($mapels as $index => $m)
                                @php
                                    $grade = $nilaiSiswas->get($m->id);
                                    $nilaiVal = $grade ? $grade->nilai : 0;
                                    $predikatLetter = $nilaiVal >= 90 ? 'A' : ($nilaiVal >= 80 ? 'B' : ($nilaiVal >= 75 ? 'C' : 'D'));
                                    $themeClass = $grade ? ($nilaiVal >= 90 ? 'grade-a' : ($nilaiVal >= 80 ? 'grade-b' : ($nilaiVal >= 75 ? 'grade-c' : 'grade-d'))) : 'empty';
                                    $themeFill = $nilaiVal >= 90 ? 'grade-a' : ($nilaiVal >= 80 ? 'grade-b' : ($nilaiVal >= 75 ? 'grade-c' : 'grade-d'));
                                @endphp
                                <div class="subject-row">
                                    <div class="subject-info">
                                        <div class="subject-num">{{ $index + 1 }}</div>
                                        <div>
                                            <h4 class="subject-name">{{ $m->nama_mapel }}</h4>
                                            <span class="subject-kkm">KKM: 75</span>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="subject-progress-container">
                                        <div class="progress-bar-bg">
                                            <div class="progress-bar-fill {{ $themeFill }}" style="width: {{ $grade ? $nilaiVal : 0 }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Value -->
                                    <div class="subject-grade-val">
                                        @if($grade)
                                            <span class="score-number">{{ number_format($nilaiVal, 0) }}</span>
                                            <span class="score-badge {{ $themeClass }}">{{ $predikatLetter }}</span>
                                        @else
                                            <span class="score-number empty">-</span>
                                            <span class="score-badge empty">-</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 30px; color: var(--text-muted);">
                                    <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                                    Mata pelajaran kelas ini belum ditambahkan atau belum disinkronisasikan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- =================================================================== -->
        <!-- PRINT VIEW: OFFICIAL PRINTABLE REPORT SHEET                         -->
        <!-- =================================================================== -->
        <div class="print-only">
            <div class="rapor-paper">
                <!-- Kop Surat Sekolah Resmi -->
                <div class="kop-surat">
                    <h2>Pemerintah Provinsi Sumatera Barat</h2>
                    <h2>Dinas Pendidikan</h2>
                    <h1>SMK Negeri 1 Talamau</h1>
                    <p>Alamat: Jl. Raya Talu - Simpang Empat, Talamau, Pasaman Barat, Sumatera Barat</p>
                </div>

                <div class="rapor-title">
                    Laporan Capaian Hasil Belajar Siswa (Rapor)
                </div>

                <!-- Info Profil Siswa -->
                <table class="rapor-profile-table">
                    <tr>
                        <td>Nama Peserta Didik</td>
                        <td>:</td>
                        <td class="font-bold">{{ $siswa->nama }}</td>
                        <td>Kelas / Semester</td>
                        <td>:</td>
                        <td>{{ $siswa->kelasRel->nama_kelas ?? $siswa->kelas }} / Genap</td>
                    </tr>
                    <tr>
                        <td>Nomor Induk / NISN</td>
                        <td>:</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>Tahun Pelajaran</td>
                        <td>:</td>
                        <td>2025/2026</td>
                    </tr>
                    <tr>
                        <td>Kompetensi Keahlian</td>
                        <td>:</td>
                        <td>{{ $siswa->jurusan }}</td>
                        <td>Wali Kelas</td>
                        <td>:</td>
                        <td>{{ $siswa->walikelas->name ?? 'Belum Ditentukan' }}</td>
                    </tr>
                </table>

                <!-- Tabel Nilai Rapor Formal -->
                <table class="table-grades">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Mata Pelajaran</th>
                            <th style="width: 80px;">KKM</th>
                            <th style="width: 100px;">Nilai Akhir</th>
                            <th>Terbilang (Predikat)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $gradesCount = $nilaiSiswas->count();
                            $gradesSum = 0;
                        @endphp
                        @foreach($mapels as $index => $m)
                            @php
                                $grade = $nilaiSiswas->get($m->id);
                                $nilaiVal = $grade ? $grade->nilai : 0;
                                if($grade) $gradesSum += $nilaiVal;
                                $predikat = $nilaiVal >= 90 ? 'A (Sangat Baik)' : ($nilaiVal >= 80 ? 'B (Baik)' : ($nilaiVal >= 75 ? 'C (Cukup)' : 'D (Kurang)'));
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="font-bold">{{ $m->nama_mapel }}</td>
                                <td class="text-center">75</td>
                                <td class="text-center font-bold" style="font-size: 13px;">
                                    {{ $grade ? number_format($grade->nilai, 0) : '-' }}
                                </td>
                                <td>
                                    @if($grade)
                                        {{ terbilangDetail($grade->nilai) }} | <strong>{{ $predikat }}</strong>
                                    @else
                                        -
                                        @php $gradesCount = max(0, $gradesCount - 1); @endphp
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        
                        <!-- Rata-rata row -->
                        @php
                            $calculatedAverage = $gradesCount > 0 ? ($gradesSum / $gradesCount) : 0;
                            $displayAverage = ($penilaian && $penilaian->is_published) ? $penilaian->c1 : $calculatedAverage;
                        @endphp
                        <tr style="background: #f8fafc;">
                            <td colspan="3" class="text-right font-bold" style="border: 2px solid #000;">NILAI RATA-RATA RAPOR AKADEMIK (C1)</td>
                            <td class="text-center font-bold" style="border: 2px solid #000; font-size: 14px; background: #eef2ff;">
                                {{ number_format($displayAverage, 2) }}
                            </td>
                            <td class="font-bold" style="border: 2px solid #000;">
                                {{ terbilangDetail($displayAverage) }} Poin
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- KPI & SAW Detail -->
                <div class="kpi-info-box">
                    <h4>Informasi Kinerja Pendukung (SAW KPI & Bakat)</h4>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 180px; font-weight: bold;">Bakat Dominan Terdeteksi</td>
                            <td>: {{ $penilaian->bakat_dominan ?? 'Belum Ditentukan' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Skor Evaluasi KPI Akhir</td>
                            <td>: {{ $penilaian ? number_format($penilaian->kpi_score, 1) : '0.0' }} (Peringkat ke-{{ $penilaian->ranking ?? '-' }})</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Rekomendasi Karir/Bakat</td>
                            <td>: {{ $penilaian->insight_kinerja ?? 'Belum ada rekomendasi' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Tanda Tangan Resmi -->
                <div class="signatures-grid">
                    <div class="signature-box">
                        <div>Mengetahui,<br>Orang Tua / Wali Siswa</div>
                        <div style="font-weight: 700; margin-top: 50px;">( .................................... )</div>
                    </div>
                    <div class="signature-box">
                        <div><br>Kepala Sekolah</div>
                        <div style="font-weight: 700; text-decoration: underline; margin-top: 35px;">{{ $kepsekName }}</div>
                        <div style="font-size: 10px; margin-top: -10px;">NIP. {{ $kepsekNip }}</div>
                    </div>
                    <div class="signature-box">
                        <div>Talamau, 20 Mei 2026<br>Wali Kelas</div>
                        <div style="font-weight: 700; text-decoration: underline; margin-top: 35px;">{{ $siswa->walikelas->name ?? 'Wali Kelas' }}</div>
                        <div style="font-size: 10px; margin-top: -10px;">NIP. {{ $siswa->walikelas->nip ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
