<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Analisis Bakat Saya - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --secondary: #0f172a;
            --bg-gradient: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            padding: 40px 20px;
            color: var(--secondary);
        }

        .report-container {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(15, 23, 42, 0.1);
            border: 1px solid rgba(255,255,255,0.2);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header Laporan */
        .report-header {
            background: var(--secondary);
            color: white;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }
        .report-header::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 5px;
            background: linear-gradient(90deg, var(--primary-light), var(--primary));
        }
        .header-title h1 { font-size: 28px; font-weight: 800; letter-spacing: -1px; }
        .header-title p { color: #94a3b8; font-size: 14px; margin-top: 5px; }

        /* Content Layout */
        .report-body {
            display: grid;
            grid-template-columns: 350px 1fr;
            min-height: 600px;
        }

        /* Sidebar Info */
        .report-sidebar {
            background: #f8fafc;
            padding: 40px;
            border-right: 1px solid #e2e8f0;
        }
        .profile-card { text-align: center; margin-bottom: 40px; }
        .profile-avatar {
            width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 30px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;
            color: white; font-size: 42px; font-weight: 800; box-shadow: 0 10px 20px rgba(20, 184, 166, 0.2);
        }
        .profile-name { font-size: 22px; font-weight: 800; margin-bottom: 5px; }
        .profile-nis { color: #64748b; font-size: 14px; font-weight: 600; }

        .score-box {
            background: white; padding: 20px; border-radius: 20px; margin-top: 30px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;
        }
        .score-val { font-size: 32px; font-weight: 800; color: var(--primary); display: block; }
        .score-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }

        /* Main Analysis */
        .report-main { padding: 50px; }
        .section-title {
            font-size: 14px; font-weight: 800; color: var(--primary);
            text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px;
            display: flex; align-items: center; gap: 10px;
        }
        .section-title::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }

        .talent-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 30px; border-radius: 25px; color: white; margin-bottom: 40px;
            position: relative; overflow: hidden;
        }
        .talent-banner i { position: absolute; right: -20px; bottom: -20px; font-size: 100px; opacity: 0.1; }

        .analysis-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 40px;
        }

        .chart-container { background: #fcfdfe; padding: 20px; border-radius: 25px; border: 1px solid #f1f5f9; }

        .recommendation-list { list-style: none; }
        .rec-item {
            display: flex; gap: 15px; margin-bottom: 20px; padding: 15px;
            background: #f8fafc; border-radius: 15px; transition: 0.3s;
        }
        .rec-item:hover { background: #f1f5f9; transform: translateX(5px); }
        .rec-icon { width: 40px; height: 40px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0; box-shadow: 0 5px 10px rgba(0,0,0,0.05); }

        .footer-actions {
            padding: 30px 50px; background: #f8fafc; border-top: 1px solid #e2e8f0;
            display: flex; justify-content: space-between; align-items: center;
        }
        .btn {
            padding: 12px 25px; border-radius: 15px; font-weight: 700; text-decoration: none;
            display: inline-flex; align-items: center; gap: 10px; transition: 0.3s;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #e2e8f0; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        @media (max-width: 900px) {
            .report-body { grid-template-columns: 1fr; }
            .report-sidebar { border-right: none; border-bottom: 1px solid #e2e8f0; }
            .analysis-grid { grid-template-columns: 1fr; }
        }

        /* Directory Styles */
        .directory-container {
            max-width: 1100px;
            margin: 0 auto;
            animation: slideUp 0.8s ease-out;
        }
        .directory-header {
            text-align: center;
            margin-bottom: 40px;
            background: var(--secondary);
            padding: 40px;
            border-radius: 30px;
            color: white;
            box-shadow: 0 20px 50px rgba(15,23,42,0.08);
            position: relative;
            overflow: hidden;
        }
        .directory-header h1 {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }
        .directory-header p {
            color: #94a3b8;
            font-size: 14px;
        }
        .directory-header::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 5px;
            background: linear-gradient(90deg, var(--primary-light), var(--primary));
        }
        .search-filter-box {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15,23,42,0.02);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
        }
        .search-input-wrapper {
            position: relative;
            flex: 1;
        }
        .search-input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .search-input-wrapper input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }
        .search-input-wrapper input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }
        .filter-select {
            padding: 12px 20px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: var(--secondary);
            outline: none;
            cursor: pointer;
            background: white;
            transition: 0.3s;
        }
        .filter-select:focus {
            border-color: var(--primary);
        }
        .directory-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }
        .student-talent-card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 35px rgba(0,0,0,0.01);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .student-talent-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(15,23,42,0.05);
            border-color: var(--primary-light);
        }
        .card-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .card-avatar {
            width: 50px; height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; font-weight: 800; font-size: 20px;
            border-radius: 15px; display: flex; align-items: center; justify-content: center;
        }
        .card-name { font-weight: 800; font-size: 16px; color: var(--secondary); }
        .card-nis { color: #64748b; font-size: 12px; font-weight: 600; }
        .badge-talent {
            display: inline-flex;
            padding: 5px 12px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .badge-talent-gi { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-talent-sa { background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8; }
        .badge-talent-gs { background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
        .badge-talent-ga { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    </style>
</head>
<body>

    @if(count($hasilBakat) > 0)
        @if($isSingle)
            @foreach($hasilBakat as $h)
            <div class="report-container">
                <!-- HEADER -->
                <header class="report-header">
                    <div class="header-title">
                        <h1>LAPORAN HASIL ANALISIS POTENSI</h1>
                        <p>Instrumen Evaluasi Kinerja Siswa Berbasis Key Performance Indicator (KPI)</p>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-weight: 800; font-size: 20px; color: var(--primary-light);">SIMPRES</span>
                        <p style="font-size: 11px; color: #94a3b8;">SMK NEGERI 1 TALAMAU</p>
                    </div>
                </header>

                <div class="report-body">
                    <!-- SIDEBAR -->
                    <aside class="report-sidebar">
                        <div class="profile-card">
                            <div class="profile-avatar">{{ strtoupper(substr($h['siswa']->nama, 0, 1)) }}</div>
                            <h2 class="profile-name">{{ $h['siswa']->nama }}</h2>
                            <p class="profile-nis">NIS: {{ $h['siswa']->nis }}</p>
                            <p style="margin-top: 5px; color: var(--primary); font-weight: 700;">KELAS {{ $h['siswa']->kelas ?? '-' }}</p>
                        </div>

                        <div class="score-box">
                            <span class="score-label">KPI Performance Score</span>
                            <span class="score-val">{{ number_format($h['penilaian']->kpi_score, 1) }}</span>
                            <div style="width: 100%; height: 6px; background: #f1f5f9; border-radius: 10px; margin-top: 10px; overflow: hidden;">
                                <div style="width: {{ $h['penilaian']->kpi_score }}%; height: 100%; background: var(--primary-light);"></div>
                            </div>
                        </div>

                        <div style="margin-top: 40px;">
                            <h4 style="font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 15px;">Informasi Tambahan</h4>
                            <div style="font-size: 13px; color: #475569; line-height: 1.8;">
                                <p><strong>Jurusan:</strong> {{ $h['siswa']->jurusan ?? '-' }}</p>
                                <p><strong>Periode:</strong> {{ date('Y') }} / Genap</p>
                                <p><strong>Verifikator:</strong> Sistem AI (Auth)</p>
                            </div>
                        </div>
                    </aside>

                    <!-- MAIN -->
                    <main class="report-main">
                        <div class="section-title">Hasil Identifikasi Bakat</div>
                        <div class="talent-banner">
                            <i class="fas {{ match($h['kriteria']) { 'GI' => 'fa-brain', 'SA' => 'fa-book-open', 'GS' => 'fa-users', 'GA' => 'fa-palette' } }}"></i>
                            <p style="font-size: 12px; color: var(--primary-light); font-weight: 800; text-transform: uppercase;">Potensi Dominan Terdeteksi:</p>
                            <h2 style="font-size: 28px; margin: 10px 0;">{{ $h['bakat'] }}</h2>
                            <p style="font-size: 14px; opacity: 0.9; font-style: italic;">"{{ $h['deskripsi'] }}"</p>
                        </div>

                        <div class="analysis-grid">
                            <!-- CHART -->
                            <div>
                                <div class="section-title">Visualisasi KPI</div>
                                <div class="chart-container">
                                    <canvas id="radarChart"></canvas>
                                </div>
                            </div>

                            <!-- RECOMMENDATIONS -->
                            <div>
                                <div class="section-title">Rekomendasi Strategis</div>
                                <div class="recommendation-list">
                                    <div class="rec-item">
                                        <div class="rec-icon"><i class="fas fa-rocket"></i></div>
                                        <div>
                                            <h5 style="font-size: 14px; font-weight: 800;">Pengembangan Karir</h5>
                                            <p style="font-size: 12px; color: #64748b;">Cocok diarahkan pada bidang yang membutuhkan {{ strtolower(explode('(', $h['bakat'])[0]) }}.</p>
                                        </div>
                                    </div>
                                    <div class="rec-item">
                                        <div class="rec-icon"><i class="fas fa-lightbulb"></i></div>
                                        <div>
                                            <h5 style="font-size: 14px; font-weight: 800;">Saran Mentor</h5>
                                            <p style="font-size: 12px; color: #64748b;">Perluas portofolio prestasi pada tingkat yang lebih tinggi.</p>
                                        </div>
                                    </div>
                                    <div class="rec-item" style="background: #eff6ff; border: 1px solid #dbeafe;">
                                        <div class="rec-icon" style="color: #3b82f6;"><i class="fas fa-info-circle"></i></div>
                                        <div>
                                            <h5 style="font-size: 14px; font-weight: 800; color: #1e40af;">Insight Sistem</h5>
                                            <p style="font-size: 11px; color: #1e40af;">Skor KPI Anda berada di atas rata-rata sekolah.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

                <!-- FOOTER -->
                <footer class="footer-actions">
                    @if(auth()->user()->role == 'siswa')
                        <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    @else
                        <a href="/hasil-bakat" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Direktori</a>
                    @endif
                    <div>
                        <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Laporan</button>
                    </div>
                </footer>
            </div>

            <script>
                const ctx = document.getElementById('radarChart');
                new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: ['KPI 1 (Akademik)', 'KPI 2 (Prestasi)', 'KPI 3 (Bakat S)', 'KPI 4 (Bakat O)'],
                        datasets: [{
                            label: 'Capaian Skor',
                            data: [{{ $h['penilaian']->c1 }}, {{ $h['penilaian']->c2 * 20 }}, {{ $h['penilaian']->c3 * 25 }}, {{ $h['penilaian']->c4 * 20 }}],
                            fill: true,
                            backgroundColor: 'rgba(20, 184, 166, 0.2)',
                            borderColor: '#14b8a6',
                            pointBackgroundColor: '#0f766e',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#14b8a6'
                        }]
                    },
                    options: {
                        scales: {
                            r: {
                                angleLines: { display: true },
                                suggestedMin: 0,
                                suggestedMax: 100
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            </script>
            @endforeach
        @else
            {{-- Directory/Grid View for Admin/Guru --}}
            <div class="directory-container">
                <div class="directory-header">
                    <h1>DIREKTORI POTENSI & BAKAT SISWA</h1>
                    <p>SMK Negeri 1 Talamau | Hasil Analisis Evaluasi Kinerja (KPI)</p>
                </div>

                <div class="search-filter-box">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari nama atau NIS siswa..." onkeyup="filterDirectory()">
                    </div>
                    <select id="filterTalent" class="filter-select" onchange="filterDirectory()">
                        <option value="">Semua Bakat / Potensi</option>
                        <option value="General Intelligence">Intellectual (General Intelligence)</option>
                        <option value="Specific Academic">Akademik (Specific Academic)</option>
                        <option value="General Social">Kepemimpinan (General Social)</option>
                        <option value="General Arts">Seni & Olahraga (General Arts)</option>
                    </select>
                </div>

                <div class="directory-grid" id="directoryGrid">
                    @foreach($hasilBakat as $h)
                    <div class="student-talent-card" data-name="{{ strtolower($h['siswa']->nama) }} {{ $h['siswa']->nis }}" data-bakat="{{ $h['bakat'] }}">
                        <div>
                            <div class="card-top">
                                <div class="card-avatar">{{ strtoupper(substr($h['siswa']->nama, 0, 1)) }}</div>
                                <div>
                                    <div class="card-name">{{ $h['siswa']->nama }}</div>
                                    <div class="card-nis">NIS: {{ $h['siswa']->nis }} | KELAS: {{ $h['siswa']->kelas ?? '-' }}</div>
                                </div>
                            </div>
                            
                            <span class="badge-talent {{ match($h['kriteria']) { 'GI' => 'badge-talent-gi', 'SA' => 'badge-talent-sa', 'GS' => 'badge-talent-gs', 'GA' => 'badge-talent-ga' } }}">
                                {{ $h['bakat'] }}
                            </span>
                            
                            <p style="font-size: 13px; color: #475569; line-height: 1.6; margin-bottom: 20px; font-style: italic;">
                                "{{ \Illuminate\Support\Str::limit($h['deskripsi'], 110) }}"
                            </p>
                        </div>
                        
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 15px; margin-bottom: 20px;">
                                <span style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Skor KPI</span>
                                <span style="font-size: 16px; font-weight: 800; color: var(--primary);">{{ number_format($h['penilaian']->kpi_score, 1) }}</span>
                            </div>
                            
                            <a href="/hasil-bakat?siswa_id={{ $h['siswa']->id }}" class="btn btn-primary" style="width: 100%; justify-content: center; font-size: 13px; padding: 10px;">
                                <i class="fas fa-eye"></i> &nbsp; Lihat Detail Potensi
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div style="text-align: center; margin-top: 40px;">
                    <a href="/dashboard" class="btn btn-secondary" style="background: white; border: 1px solid #cbd5e1; font-weight: 700;">
                        <i class="fas fa-home"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
            
            <script>
                function filterDirectory() {
                    const searchVal = document.getElementById('searchInput').value.toLowerCase();
                    const talentVal = document.getElementById('filterTalent').value;
                    const cards = document.querySelectorAll('.student-talent-card');
                    
                    cards.forEach(card => {
                        const nameAndNis = card.getAttribute('data-name');
                        const bakat = card.getAttribute('data-bakat');
                        
                        const matchesSearch = nameAndNis.includes(searchVal);
                        const matchesTalent = talentVal === "" || bakat.includes(talentVal);
                        
                        if (matchesSearch && matchesTalent) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
            </script>
        @endif
    @else
        <div class="empty-container" style="max-width: 600px; margin: 80px auto; background: white; border-radius: 30px; padding: 50px 30px; text-align: center; box-shadow: 0 40px 100px rgba(15, 23, 42, 0.08); border: 1px solid rgba(255,255,255,0.2); animation: slideUp 0.8s ease-out;">
            <div class="empty-icon" style="width: 120px; height: 120px; background: #e6f7f6; border-radius: 40px; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center; color: var(--primary-light); font-size: 52px;">
                <i class="fas fa-chart-line"></i>
            </div>
            <h2 style="font-size: 24px; font-weight: 800; color: var(--secondary); margin-bottom: 15px;">Hasil Analisis Belum Tersedia</h2>
            <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 30px;">
                @if(auth()->user()->role == 'siswa')
                    Sistem belum mendeteksi hasil analisis bakat dan KPI Anda. Hal ini biasanya dikarenakan Admin / Guru belum memproses perhitungan penilaian prestasi. Silakan hubungi wali kelas atau admin untuk informasi lebih lanjut.
                @else
                    Belum ada data penilaian siswa yang telah diproses untuk kalkulasi KPI. Silakan lakukan kalkulasi skor KPI siswa terlebih dahulu di menu Penilaian.
                @endif
            </p>
            <a href="/dashboard" class="btn btn-secondary" style="display: inline-flex; justify-content: center; align-items: center; padding: 14px 30px; border-radius: 15px; font-weight: 700; background: var(--primary); color: white; border: none; font-size: 15px;">
                <i class="fas fa-arrow-left"></i> &nbsp; Kembali ke Dashboard
            </a>
        </div>
    @endif

</body>
</html>

