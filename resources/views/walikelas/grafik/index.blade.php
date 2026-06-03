<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Prestasi & KPI - SIMPRES</title>
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
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background: #f8fafc; }
        
        .card {
            background: var(--surface);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        /* Ranks grid and card styling */
        .ranks-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        .rank-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.01);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .rank-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        }
        .rank-card-header {
            padding: 16px 20px;
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .c1-card .rank-card-header { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .c2-card .rank-card-header { background: linear-gradient(135deg, #0f766e, #115e59); }
        .c3-card .rank-card-header { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .c4-card .rank-card-header { background: linear-gradient(135deg, #ec4899, #be185d); }
        
        .rank-card-header i { font-size: 20px; }
        .rank-card-header h4 { font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700; margin: 0; line-height: 1.2; }
        .rank-card-header p { font-size: 11px; opacity: 0.8; margin-top: 2px; }
        
        .rank-list { padding: 15px; display: flex; flex-direction: column; gap: 10px; }
        .rank-item { display: flex; align-items: center; justify-content: space-between; font-size: 12px; padding: 8px 10px; border-radius: 10px; background: #f8fafc; }
        .rank-item .student-name { font-weight: 700; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px; }
        .rank-item .score-val { font-weight: 800; color: var(--secondary); }
        
        .badge-rank {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
            color: white;
        }
        .rank-1 { background: #eab308; } /* Gold */
        .rank-2 { background: #cbd5e1; color: #475569; } /* Silver */
        .rank-3 { background: #b45309; } /* Bronze */
        .rank-4, .rank-5 { background: #94a3b8; }
        
        .empty-list { font-size: 11px; color: var(--text-muted); text-align: center; padding: 15px; }

        /* Table styles */
        .bakat-table { width: 100%; border-collapse: collapse; }
        .bakat-table th { padding: 12px 16px; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; text-align: left; }
        .bakat-table td { padding: 14px 16px; font-size: 13px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .bakat-table tr:last-child td { border-bottom: none; }
        
        .bakat-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 8px;
        }
        .status-verified { color: #16a34a; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; }
        .status-pending { color: #f59e0b; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; }
        
        @media (max-width: 1024px) {
            .ranks-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .ranks-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-title">
                <h1>GRAFIK PRESTASI & SEBARAN KPI KELAS</h1>
                <p>SIMPRES | Wali Kelas: {{ auth()->user()->name }}</p>
            </div>
            <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <!-- Chart 1 -->
            <div class="card" style="margin-bottom: 0;">
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 25px;"><i class="fas fa-chart-bar"></i> Distribusi Nilai KPI Siswa</h3>
                <div style="height: 350px;">
                    <canvas id="kpiBarChart"></canvas>
                </div>
            </div>

            <!-- Chart 2 -->
            <div class="card" style="margin-bottom: 0;">
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 25px;"><i class="fas fa-chart-pie"></i> Diagnostik Sebaran Bakat</h3>
                <div style="height: 350px;">
                    <canvas id="bakatPieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 4 Indicators Rank Section -->
        <h2 style="font-family: 'Poppins', sans-serif; font-size: 22px; font-weight: 800; color: var(--secondary); margin: 40px 0 20px;"><i class="fas fa-medal"></i> Peringkat Siswa Per Indikator</h2>
        
        <div class="ranks-grid">
            <!-- C1 Card -->
            <div class="rank-card c1-card">
                <div class="rank-card-header">
                    <i class="fas fa-graduation-cap"></i>
                    <div>
                        <h4>Rata-rata Rapor (C1)</h4>
                        <p>Nilai akademis rapor</p>
                    </div>
                </div>
                <div class="rank-list">
                    @forelse($penilaians->sortByDesc('c1')->take(5) as $idx => $p)
                        <div class="rank-item">
                            <span class="badge-rank rank-{{ $idx + 1 }}">{{ $idx + 1 }}</span>
                            <span class="student-name" title="{{ $p->siswa->nama }}">{{ $p->siswa->nama }}</span>
                            <span class="score-val">{{ number_format($p->c1, 1) }}</span>
                        </div>
                    @empty
                        <div class="empty-list">Belum ada data nilai rapor</div>
                    @endforelse
                </div>
            </div>

            <!-- C2 Card -->
            <div class="rank-card c2-card">
                <div class="rank-card-header">
                    <i class="fas fa-award"></i>
                    <div>
                        <h4>Prestasi Akademik (C2)</h4>
                        <p>Olimpiade & lomba sains</p>
                    </div>
                </div>
                <div class="rank-list">
                    @forelse($penilaians->sortByDesc('c2')->take(5) as $idx => $p)
                        <div class="rank-item">
                            <span class="badge-rank rank-{{ $idx + 1 }}">{{ $idx + 1 }}</span>
                            <span class="student-name" title="{{ $p->siswa->nama }}">{{ $p->siswa->nama }}</span>
                            <span class="score-val">{{ number_format($p->c2, 1) }}</span>
                        </div>
                    @empty
                        <div class="empty-list">Belum ada data prestasi akademik</div>
                    @endforelse
                </div>
            </div>

            <!-- C3 Card -->
            <div class="rank-card c3-card">
                <div class="rank-card-header">
                    <i class="fas fa-users"></i>
                    <div>
                        <h4>Organisasi (C3)</h4>
                        <p>Kepemimpinan & organisasi</p>
                    </div>
                </div>
                <div class="rank-list">
                    @forelse($penilaians->sortByDesc('c3')->take(5) as $idx => $p)
                        <div class="rank-item">
                            <span class="badge-rank rank-{{ $idx + 1 }}">{{ $idx + 1 }}</span>
                            <span class="student-name" title="{{ $p->siswa->nama }}">{{ $p->siswa->nama }}</span>
                            <span class="score-val">{{ number_format($p->c3, 1) }}</span>
                        </div>
                    @empty
                        <div class="empty-list">Belum ada data organisasi</div>
                    @endforelse
                </div>
            </div>

            <!-- C4 Card -->
            <div class="rank-card c4-card">
                <div class="rank-card-header">
                    <i class="fas fa-running"></i>
                    <div>
                        <h4>Seni & Olahraga (C4)</h4>
                        <p>Seni, budaya & olahraga</p>
                    </div>
                </div>
                <div class="rank-list">
                    @forelse($penilaians->sortByDesc('c4')->take(5) as $idx => $p)
                        <div class="rank-item">
                            <span class="badge-rank rank-{{ $idx + 1 }}">{{ $idx + 1 }}</span>
                            <span class="student-name" title="{{ $p->siswa->nama }}">{{ $p->siswa->nama }}</span>
                            <span class="score-val">{{ number_format($p->c4, 1) }}</span>
                        </div>
                    @empty
                        <div class="empty-list">Belum ada data prestasi non-akademik</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bakat Siswa Table -->
        <div class="card">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 20px;"><i class="fas fa-id-card"></i> Daftar Bakat Dominan & Capaian KPI Siswa</h3>
            <div style="overflow-x: auto;">
                <table class="bakat-table">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>KPI Score</th>
                            <th>Bakat Dominan</th>
                            <th>Status Penilaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penilaians->sortByDesc('kpi_score') as $p)
                            <tr>
                                <td><strong>{{ $p->siswa->nama }}</strong></td>
                                <td>{{ $p->siswa->nis }}</td>
                                <td><span style="font-weight: 800; color: var(--primary); font-size: 14px;">{{ number_format($p->kpi_score, 1) }}</span></td>
                                <td>
                                    @php
                                        $badgeColor = '#ec4899'; $badgeBg = '#fdf2f8'; $icon = 'fa-running';
                                        if (str_contains($p->bakat_dominan, 'Akademik Umum')) {
                                            $badgeColor = '#0f766e'; $badgeBg = '#f0fdfa'; $icon = 'fa-graduation-cap';
                                        } elseif (str_contains($p->bakat_dominan, 'Akademik Spesifik') || str_contains($p->bakat_dominan, 'Prestasi Akademik')) {
                                            $badgeColor = '#3b82f6'; $badgeBg = '#eff6ff'; $icon = 'fa-award';
                                        } elseif (str_contains($p->bakat_dominan, 'Kepemimpinan') || str_contains($p->bakat_dominan, 'Organisasi')) {
                                            $badgeColor = '#f59e0b'; $badgeBg = '#fffbeb'; $icon = 'fa-users';
                                        }
                                    @endphp
                                    <span class="bakat-badge" style="color: {{ $badgeColor }}; background: {{ $badgeBg }}; border: 1px solid {{ $badgeColor }}30;">
                                        <i class="fas {{ $icon }}"></i> {{ $p->bakat_dominan }}
                                    </span>
                                </td>
                                <td>
                                    @if($p->is_verified)
                                        <span class="status-verified"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                                    @else
                                        <span class="status-pending"><i class="fas fa-clock"></i> Draft</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada data penilaian siswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data lists from php variables
            const names = {!! json_encode($penilaians->sortByDesc('kpi_score')->take(8)->pluck('siswa.nama')) !!};
            const scores = {!! json_encode($penilaians->sortByDesc('kpi_score')->take(8)->pluck('kpi_score')) !!};

            // Bar Chart
            new Chart(document.getElementById('kpiBarChart'), {
                type: 'bar',
                data: {
                    labels: names.map((name, index) => {
                        const label = `${index + 1}. ${name}`;
                        return label.length > 18 ? label.substring(0, 18) + '...' : label;
                    }),
                    datasets: [{
                        label: 'Skor KPI Siswa',
                        data: scores,
                        backgroundColor: '#14b8a6',
                        borderRadius: 8,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            // Pie Chart
            new Chart(document.getElementById('bakatPieChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Akademik Umum', 'Akademik Spesifik', 'Kepemimpinan', 'Seni/Olahraga'],
                    datasets: [{
                        data: [
                            {{ $penilaians->filter(fn($p) => str_contains($p->bakat_dominan, 'Akademik Umum'))->count() }},
                            {{ $penilaians->filter(fn($p) => str_contains($p->bakat_dominan, 'Akademik Spesifik') || str_contains($p->bakat_dominan, 'Prestasi Akademik'))->count() }},
                            {{ $penilaians->filter(fn($p) => str_contains($p->bakat_dominan, 'Kepemimpinan') || str_contains($p->bakat_dominan, 'Organisasi'))->count() }},
                            {{ $penilaians->filter(fn($p) => str_contains($p->bakat_dominan, 'Seni'))->count() }}
                        ],
                        backgroundColor: ['#0f766e', '#3b82f6', '#f59e0b', '#ec4899'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
