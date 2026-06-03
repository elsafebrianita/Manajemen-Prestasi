<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Siswa - SMK N 1 TALAMAU</title>
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
            padding: 40px 20px;
            color: var(--text-dark);
        }

        .container { max-width: 1300px; margin: 0 auto; }

        .header-section { margin-bottom: 40px; }
        .header-section h1 { font-size: 32px; font-weight: 800; letter-spacing: -1px; }
        .school-badge { color: var(--primary-teal); font-weight: 800; font-size: 18px; }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(38, 129, 125, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid rgba(255,255,255,0.5);
        }
        .stat-icon {
            width: 55px; height: 55px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
        }
        .blue { background: #eff6ff; color: #3b82f6; }
        .green { background: #ecfdf5; color: #10b981; }
        .orange { background: #fffbeb; color: #f59e0b; }

        .stat-info h3 { font-size: 24px; font-weight: 800; line-height: 1; }
        .stat-info p { font-size: 13px; color: #64748b; font-weight: 600; margin-top: 5px; }

        /* Main Table Card */
        .table-card {
            background: white;
            border-radius: 35px;
            padding: 35px;
            box-shadow: 0 20px 50px rgba(38, 129, 125, 0.08);
            border: 1px solid rgba(38, 129, 125, 0.1);
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .action-bar h2 { font-size: 20px; font-weight: 800; }

        .btn-proses {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white; padding: 12px 25px; border-radius: 15px;
            text-decoration: none; font-weight: 800; font-size: 14px;
            display: inline-flex; align-items: center; gap: 10px;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2);
        }
        .btn-proses:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(245, 158, 11, 0.3); }

        .btn-dash {
            background: white; color: var(--primary-teal);
            padding: 12px 25px; border-radius: 15px;
            text-decoration: none; font-weight: 800; font-size: 14px;
            border: 2px solid var(--primary-teal);
            transition: 0.3s;
        }
        .btn-dash:hover { background: var(--bg-cyan); }

        /* Table Design */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left; padding: 15px 20px;
            font-size: 12px; text-transform: uppercase; letter-spacing: 1px;
            color: #94a3b8; font-weight: 800; border-bottom: 2px solid #f1f5f9;
        }
        td { padding: 20px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
        tr:hover { background-color: #fcfdfd; }

        .student-info { display: flex; align-items: center; gap: 15px; }
        .avatar {
            width: 45px; height: 45px;
            background: var(--primary-teal);
            color: white; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 18px;
        }

        .status-badge {
            padding: 6px 12px; border-radius: 10px; font-size: 11px; font-weight: 800;
        }
        .status-ok { background: #ecfdf5; color: #059669; }
        .status-no { background: #fff1f2; color: #e11d48; }

        .btn-nilai {
            background: #f1f5f9; color: #475569;
            padding: 8px 16px; border-radius: 10px;
            text-decoration: none; font-weight: 700; font-size: 13px;
            transition: 0.3s;
        }
        .btn-nilai:hover { background: var(--primary-teal); color: white; }

        .alert {
            background: #ecfdf5; color: #059669;
            padding: 20px; border-radius: 20px; margin-bottom: 30px;
            font-weight: 700; display: flex; align-items: center; gap: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-section">
            <span class="school-badge">SMK NEGERI 1 TALAMAU</span>
            <h1>Pusat Evaluasi & Portofolio Siswa</h1>
        </header>

        @if(session('success'))
            <div class="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- KARTU STATISTIK (Mengisi ruang kosong) -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3>{{ $siswas->count() }}</h3>
                    <p>Total Siswa</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
                <div class="stat-info">
                    <h3>{{ $siswas->whereNotNull('penilaian')->count() }}</h3>
                    <p>Sudah Dinilai</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-user-clock"></i></div>
                <div class="stat-info">
                    <h3>{{ $siswas->whereNull('penilaian')->count() }}</h3>
                    <p>Belum Dinilai</p>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="action-bar">
                <h2>Manajemen Capaian & Portofolio KPI</h2>
                <div style="display: flex; gap: 12px; align-items: center;">
                    @if(in_array(auth()->user()->akses_role, ['admin', 'wakasiswa', 'walikelas', 'guru', 'tu']))
                        <a href="/penilaian/proses-kpi" class="btn-proses" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 12px 25px; border-radius: 15px; text-decoration: none; font-weight: 800; font-size: 14px; display: inline-flex; align-items: center; gap: 10px; transition: 0.3s; box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2);">
                            <i class="fas fa-sync-alt"></i> Kalkulasi & Proses KPI
                        </a>
                    @endif
                    <a href="/dashboard" class="btn-dash">Kembali</a>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>KPI Score</th>
                        <th>Status</th>
                        <th>Verifikasi</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswas as $s)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 35px; height: 35px; background: var(--primary-teal); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                                        {{ substr($s->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--text-dark);">{{ $s->nama }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->kelas ?? '-' }}</td>
                            <td>{{ $s->jurusan ?? '-' }}</td>
                            <td style="font-weight: 800;">{{ optional($s->penilaian)->kpi_score ? number_format($s->penilaian->kpi_score, 1) : '-' }}</td>
                            <td>
                                @if($s->penilaian && $s->penilaian->skor_akhir)
                                    <span style="background: #f0fdf4; color: #16a34a; padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 800;">SIAP</span>
                                @else
                                    <span style="background: #fff1f2; color: #e11d48; padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 800;">BELUM</span>
                                @endif
                            </td>
                            <td>
                                @if($s->penilaian && $s->penilaian->is_verified)
                                    <span style="color: #059669; font-weight: 800; font-size: 11px;"><i class="fas fa-check-double"></i> TER-ACC</span>
                                @else
                                    <span style="color: #94a3b8; font-weight: 800; font-size: 11px;">PENDING</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;">
                                    <a href="/penilaian/show/{{ $s->id }}" style="background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="/penilaian/create/{{ $s->id }}" style="background: var(--bg-cyan); color: var(--primary-teal); padding: 8px 15px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-edit"></i> Nilai KPI
                                    </a>
                                    @if($s->penilaian && in_array(auth()->user()->akses_role, ['admin', 'wakasiswa']))
                                        <form action="/penilaian/acc/{{ $s->penilaian->id }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" style="background: var(--primary-teal); color: white; border: none; padding: 8px 15px; border-radius: 10px; cursor: pointer; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                                <i class="fas fa-check-double"></i> ACC
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
