<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input KPI - SMK N 1 TALAMAU</title>
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
        }

        .container { max-width: 1200px; margin: 0 auto; }

        .header-section { margin-bottom: 30px; }
        .header-section h1 { font-size: 28px; font-weight: 800; color: var(--text-dark); }
        .header-section .school-name { color: var(--primary-teal); font-weight: 800; }

        .main-layout {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 30px;
            align-items: start;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 35px;
            box-shadow: 0 20px 50px rgba(38, 129, 125, 0.08);
            border: 1px solid rgba(38, 129, 125, 0.1);
        }

        /* Sidebar Info */
        .info-card {
            background: linear-gradient(135deg, var(--primary-teal), #14b8a6);
            color: white;
            padding: 40px;
            border-radius: 35px;
            height: 100%;
        }
        .student-profile {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .avatar-large {
            width: 100px; height: 100px;
            background: rgba(255,255,255,0.2);
            border: 4px solid rgba(255,255,255,0.3);
            border-radius: 30px;
            margin: 0 auto 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 42px; font-weight: 800;
        }

        .guide-box {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 20px;
            margin-top: 20px;
        }
        .guide-box h4 { margin-bottom: 10px; font-size: 16px; display: flex; align-items: center; gap: 10px; }
        .guide-box p { font-size: 13px; line-height: 1.6; opacity: 0.9; }

        /* Form Controls */
        .form-section h3 {
            font-size: 18px; font-weight: 800; color: var(--primary-teal);
            margin-bottom: 25px; display: flex; align-items: center; gap: 12px;
        }
        .form-section h3 i { background: var(--bg-cyan); padding: 10px; border-radius: 12px; }

        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 700; margin-bottom: 10px; color: #475569; font-size: 14px; }
        
        .input-wrapper { position: relative; }
        .input-wrapper i {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: var(--primary-teal);
        }
        
        input, select {
            width: 100%; padding: 15px 15px 15px 45px;
            border: 2px solid #f1f5f9;
            border-radius: 15px; font-size: 15px;
            background: #f8fafc; transition: 0.3s;
            font-family: inherit;
        }
        input:focus, select:focus { outline: none; border-color: var(--primary-teal); background: white; box-shadow: 0 0 0 4px rgba(38, 129, 125, 0.05); }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .achievement-alert {
            background: #fffbeb; border-left: 4px solid #f59e0b;
            padding: 15px; border-radius: 12px; margin-top: 10px;
            font-size: 12px; color: #92400e;
        }

        .btn-save {
            background: var(--primary-teal); color: white;
            border: none; width: 100%; padding: 20px;
            border-radius: 20px; font-weight: 800; font-size: 16px;
            cursor: pointer; transition: 0.3s; margin-top: 10px;
            box-shadow: 0 10px 20px rgba(38, 129, 125, 0.2);
            display: flex; align-items: center; justify-content: center; gap: 12px;
        }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(38, 129, 125, 0.3); }

        .btn-back {
            display: block; text-align: center; margin-top: 25px;
            text-decoration: none; color: #94a3b8; font-weight: 700;
            font-size: 14px; transition: 0.3s;
        }
        .btn-back:hover { color: var(--primary-teal); }

        @media (max-width: 992px) {
            .main-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-section">
            <span class="school-name">SMK NEGERI 1 TALAMAU</span>
            <h1>Instrumen Input Capaian KPI</h1>
        </header>

        <div class="main-layout">
            <!-- LEFT COLUMN: INFO & GUIDE -->
            <div class="info-card">
                <div class="student-profile">
                    <div class="avatar-large">{{ substr($siswa->nama, 0, 1) }}</div>
                    <h2 style="font-size: 24px; margin-bottom: 5px;">{{ $siswa->nama }}</h2>
                    <p style="opacity: 0.8; font-weight: 600;">NIS: {{ $siswa->nis }}</p>
                    <p style="opacity: 0.8; font-weight: 600;">Kelas: {{ $siswa->kelas ?? 'Tingkat Akhir' }}</p>
                </div>

                <div class="guide-box">
                    <h4><i class="fas fa-info-circle"></i> Panduan KPI 1 (Rapor)</h4>
                    <p>Masukkan nilai rata-rata rapor semester terakhir. Skala nilai adalah 0 sampai 100.</p>
                </div>

                <div class="guide-box">
                    <h4><i class="fas fa-trophy"></i> Panduan Prestasi</h4>
                    <p>Pilih tingkat tertinggi dari prestasi yang pernah diraih siswa baik akademik maupun non-akademik.</p>
                </div>

                <div class="guide-box">
                    <h4><i class="fas fa-users-cog"></i> Panduan Organisasi</h4>
                    <p>Tentukan jabatan tertinggi siswa dalam organisasi (OSIS, Pramuka, dll) selama sekolah.</p>
                </div>
            </div>

            <!-- RIGHT COLUMN: FORM -->
            <div class="card">
                <form action="/penilaian/store" method="POST">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                    <div class="form-section">
                        <h3><i class="fas fa-edit"></i> Ringkasan Nilai KPI Otomatis</h3>

                        <div class="form-group">
                            <label>KPI 1 - Nilai Rapor (C1)</label>
                            <div class="input-wrapper">
                                <i class="fas fa-graduation-cap"></i>
                                <input type="text" value="{{ number_format($computed['c1'] ?? 0, 2) }} / 100" readonly>
                            </div>
                            <div class="achievement-alert" style="background: #eff6ff; border-left-color: #3b82f6; color: #1d4ed8;">
                                Nilai rata-rata rapor dihitung otomatis dari nilai mapel yang diinput oleh guru.
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label>KPI 2 - Prestasi Akademik</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-award"></i>
                                    <input type="text" value="{{ number_format($computed['c2'] ?? 0, 2) }} / 100" readonly>
                                </div>
                                @if($prestasi_akademik->count() > 0)
                                    <div class="achievement-alert" style="background: #f0fdf4; border-left-color: #22c55e; color: #166534;">
                                        <div style="margin-bottom: 5px; border-bottom: 1px solid rgba(22,101,52,0.1); padding-bottom: 5px;">
                                            <i class="fas fa-check-circle"></i> Data Akademik Disetujui
                                        </div>
                                        @foreach($prestasi_akademik as $p)
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                                <span>• {{ $p->nama_prestasi }} ({{ $p->tingkat }})</span>
                                                <span style="font-weight: 800;">{{ $p->poin }} Poin</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>KPI 3 - Organisasi</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-sitemap"></i>
                                    <input type="text" value="{{ number_format($computed['c3'] ?? 0, 2) }} / 100" readonly>
                                </div>
                                @if(isset($prestasi_organisasi) && $prestasi_organisasi->count() > 0)
                                    <div class="achievement-alert" style="background: #eef2ff; border-left-color: #7c3aed; color: #4f46e5;">
                                        <div style="margin-bottom: 5px; border-bottom: 1px solid rgba(79,70,229,0.1); padding-bottom: 5px;">
                                            <i class="fas fa-check-circle"></i> Data Organisasi Disetujui
                                        </div>
                                        @foreach($prestasi_organisasi as $p)
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                                <span>• {{ $p->nama_prestasi }} ({{ $p->tingkat }})</span>
                                                <span style="font-weight: 800;">{{ $p->poin }} Poin</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="achievement-alert" style="background: #fffbeb; border-left-color: #f59e0b; color: #92400e;">
                                        Data organisasi akan dihitung dari jabatan atau kategori organisasi siswa.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label>KPI 4 - Prestasi Non-Akademik</label>
                            <div class="input-wrapper">
                                <i class="fas fa-star"></i>
                                <input type="text" value="{{ number_format($computed['c4'] ?? 0, 2) }} / 100" readonly>
                            </div>
                            @if($prestasi_non->count() > 0)
                                <div class="achievement-alert" style="background: #f0fdfa; border-left-color: var(--primary-teal); color: #0f766e;">
                                    <div style="margin-bottom: 5px; border-bottom: 1px solid rgba(15,118,110,0.1); padding-bottom: 5px;">
                                        <i class="fas fa-check-circle"></i> Data Non-Akademik Disetujui
                                    </div>
                                    @foreach($prestasi_non as $p)
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                            <span>• {{ $p->nama_prestasi }} ({{ $p->tingkat }})</span>
                                            <span style="font-weight: 800;">{{ $p->poin }} Poin</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan KPI Otomatis
                    </button>
                    
                    <a href="/penilaian" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Batal dan Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
