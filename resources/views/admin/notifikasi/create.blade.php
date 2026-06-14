<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Notifikasi - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        :root { --teal: #26817d; --bg: #e6f7f6; --dark: #0f172a; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); min-height: 100vh; padding: 40px 20px; }
        .container { max-width: 1100px; margin: 0 auto; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .page-header h1 { font-size: 26px; font-weight: 800; color: var(--dark); }
        .page-header p { color: #64748b; font-size: 14px; margin-top: 4px; }
        .btn-back { background: white; color: var(--teal); padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 13px; border: 2px solid var(--teal); display: flex; align-items: center; gap: 8px; }

        .grid-2 { display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px; }
        .card { background: white; border-radius: 25px; padding: 30px; box-shadow: 0 10px 40px rgba(38,129,125,0.06); border: 1px solid rgba(38,129,125,0.1); }
        
        h3.section-title { font-size: 17px; font-weight: 800; color: var(--teal); margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px; }
        .form-group select, .form-group textarea {
            width: 100%; padding: 14px 16px; border-radius: 14px; border: 2px solid #f1f5f9;
            background: #f8fafc; font-family: inherit; font-size: 14px; transition: 0.3s; outline: none;
        }
        .form-group select:focus, .form-group textarea:focus { border-color: var(--teal); background: white; }
        .form-group textarea { height: 130px; resize: none; }

        .type-cards { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
        .type-card { padding: 14px 16px; border-radius: 14px; border: 2px solid #e2e8f0; cursor: pointer; transition: 0.3s; }
        .type-card:hover { border-color: var(--teal); }
        .type-card.selected-red { border-color: #ef4444; background: #fff5f5; }
        .type-card.selected-yellow { border-color: #f59e0b; background: #fffbeb; }
        .type-card.selected-green { border-color: #22c55e; background: #f0fdf4; }
        .type-card input[type="radio"] { display: none; }
        .type-card-label { display: flex; align-items: center; gap: 12px; cursor: pointer; }
        .type-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }

        .btn-send { background: var(--teal); color: white; border: none; width: 100%; padding: 18px; border-radius: 15px; font-size: 15px; font-weight: 800; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-send:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(38,129,125,0.25); }

        .siswa-preview { display: none; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 15px; padding: 15px; margin-bottom: 20px; }
        .siswa-preview.active { display: block; }
        .kpi-bar { height: 8px; background: #e2e8f0; border-radius: 10px; margin-top: 8px; overflow: hidden; }
        .kpi-fill { height: 100%; background: var(--teal); border-radius: 10px; transition: width 0.5s; }

        .alert-success { background: #ecfdf5; color: #059669; padding: 18px 22px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .alert-error { background: #fef2f2; color: #dc2626; padding: 18px 22px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; display: flex; align-items: center; gap: 10px; }

        /* Recent Sent */
        .notif-feed { display: flex; flex-direction: column; gap: 14px; }
        .notif-card { padding: 16px; border-radius: 16px; border-left: 5px solid; }
        .notif-card.pertahankan { background: #f0fdf4; border-color: #22c55e; }
        .notif-card.cukup { background: #fffbeb; border-color: #f59e0b; }
        .notif-card.tingkatkan { background: #fff5f5; border-color: #ef4444; }
        .notif-card .type-badge { font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 3px 8px; border-radius: 6px; margin-bottom: 6px; display: inline-block; }
        .notif-card .msg { font-size: 13px; color: #334155; line-height: 1.6; margin-bottom: 8px; }
        .notif-card .meta { font-size: 11px; color: #94a3b8; display: flex; justify-content: space-between; }

        /* Diagnostik Section styles */
        .diagnostik-section {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(38,129,125,0.06);
            border: 1px solid rgba(38,129,125,0.1);
            margin-bottom: 30px;
        }
        .diagnostik-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--teal);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .diagnostik-subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 25px;
        }
        
        .indicator-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .indicator-card {
            background: #f8fafc;
            border-radius: 18px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .indicator-card:hover {
            transform: translateY(-2px);
            border-color: var(--teal);
            box-shadow: 0 8px 20px rgba(38,129,125,0.05);
        }
        .indicator-card .title {
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .indicator-card .value {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 10px;
            display: flex;
            align-items: baseline;
            gap: 4px;
        }
        .indicator-card .value span {
            font-size: 13px;
            font-weight: 600;
            color: #94a3b8;
        }
        .indicator-bar {
            height: 6px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }
        .indicator-fill {
            height: 100%;
            border-radius: 10px;
        }
        
        .diagnostik-grid-2 {
            display: grid;
            grid-template-columns: 1.2fr 1.8fr;
            gap: 30px;
        }
        .sub-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #e2e8f0;
        }
        .sub-card h4 {
            font-size: 15px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Table of lowest students */
        .table-lowest {
            width: 100%;
            border-collapse: collapse;
        }
        .table-lowest th {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 800;
            text-transform: uppercase;
            text-align: left;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        .table-lowest td {
            padding: 12px 0;
            font-size: 13px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        .table-lowest tr:last-child td {
            border-bottom: none;
        }
        
        .btn-action-small {
            background: var(--teal);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }
        .btn-action-small:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        /* Push gaps cards */
        .push-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            max-height: 380px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .push-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s ease;
        }
        .push-card:hover {
            border-color: var(--teal);
            box-shadow: 0 4px 12px rgba(38,129,125,0.04);
        }
        .push-card .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .push-card .name {
            font-weight: 700;
            font-size: 13px;
            color: var(--dark);
        }
        .push-card .kpi {
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
        }
        .push-gaps {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 12px;
        }
        .gap-badge {
            background: #fff5f5;
            color: #ef4444;
            border: 1px solid #fecaca;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: 0.2s;
        }
        .gap-badge:hover {
            background: var(--teal);
            color: white;
            border-color: var(--teal);
        }
        
        @media (max-width: 1024px) {
            .indicator-grid { grid-template-columns: repeat(2, 1fr); }
            .diagnostik-grid-2 { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <div>
            <p style="color: var(--teal); font-weight: 800; font-size: 13px;">GURU SIMPRES</p>
            <h1><i class="fas fa-paper-plane"></i> Kirim Notifikasi ke Siswa</h1>
            <p>Berikan feedback dan motivasi langsung ke dashboard siswa</p>
        </div>
        <a href="/dashboard" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
    @endif

    @if($classAnalysis)
    <div class="diagnostik-section">
        <h3 class="diagnostik-title"><i class="fas fa-chart-line"></i> Diagnostik Capaian Kelas & Rekomendasi</h3>
        <p class="diagnostik-subtitle">Berikut analisis otomatis pencapaian seluruh siswa di kelas Anda. Klik tombol "Push/Motivasi" untuk langsung mengisi form pengiriman notifikasi bantuan.</p>

        <!-- KPI Averages Grid -->
        <div class="indicator-grid">
            <!-- C1: Rapor -->
            @php
                $c1 = $classAnalysis['c1_avg'];
                $c1_color = $c1 >= 80 ? '#22c55e' : ($c1 >= 70 ? '#f59e0b' : '#ef4444');
            @endphp
            <div class="indicator-card">
                <div class="title">Rata-rata Rapor (C1)</div>
                <div class="value">{{ number_format($c1, 1) }} <span>/ 100</span></div>
                <div class="indicator-bar"><div class="indicator-fill" style="width: {{ $c1 }}%; background: {{ $c1_color }}"></div></div>
                <div style="font-size:11px; margin-top:8px; font-weight:700; color: {{ $c1_color }}">
                    @if($c1 >= 80) Sangat Memuaskan @elseif($c1 >= 70) Cukup Baik @else Perlu Pembinaan @endif
                </div>
            </div>

            <!-- C2: Akademik -->
            @php
                $c2 = $classAnalysis['c2_avg'];
                $c2_color = $c2 >= 60 ? '#22c55e' : ($c2 >= 30 ? '#f59e0b' : '#ef4444');
            @endphp
            <div class="indicator-card">
                <div class="title">Prestasi Akademik (C2)</div>
                <div class="value">{{ number_format($c2, 1) }} <span>/ 100</span></div>
                <div class="indicator-bar"><div class="indicator-fill" style="width: {{ $c2 }}%; background: {{ $c2_color }}"></div></div>
                <div style="font-size:11px; margin-top:8px; font-weight:700; color: {{ $c2_color }}">
                    @if($c2 >= 60) Sangat Baik @elseif($c2 >= 30) Rata-rata @else Sangat Rendah @endif
                </div>
            </div>

            <!-- C3: Organisasi -->
            @php
                $c3 = $classAnalysis['c3_avg'];
                $c3_color = $c3 >= 60 ? '#22c55e' : ($c3 >= 30 ? '#f59e0b' : '#ef4444');
            @endphp
            <div class="indicator-card">
                <div class="title">Organisasi (C3)</div>
                <div class="value">{{ number_format($c3, 1) }} <span>/ 100</span></div>
                <div class="indicator-bar"><div class="indicator-fill" style="width: {{ $c3 }}%; background: {{ $c3_color }}"></div></div>
                <div style="font-size:11px; margin-top:8px; font-weight:700; color: {{ $c3_color }}">
                    @if($c3 >= 60) Sangat Aktif @elseif($c3 >= 30) Sedang @else Kurang Aktif @endif
                </div>
            </div>

            <!-- C4: Seni/Olahraga -->
            @php
                $c4 = $classAnalysis['c4_avg'];
                $c4_color = $c4 >= 60 ? '#22c55e' : ($c4 >= 30 ? '#f59e0b' : '#ef4444');
            @endphp
            <div class="indicator-card">
                <div class="title">Seni & Olahraga (C4)</div>
                <div class="value">{{ number_format($c4, 1) }} <span>/ 100</span></div>
                <div class="indicator-bar"><div class="indicator-fill" style="width: {{ $c4 }}%; background: {{ $c4_color }}"></div></div>
                <div style="font-size:11px; margin-top:8px; font-weight:700; color: {{ $c4_color }}">
                    @if($c4 >= 60) Sangat Baik @elseif($c4 >= 30) Rata-rata @else Sangat Rendah @endif
                </div>
            </div>
        </div>

        <div class="diagnostik-grid-2">
            <!-- Table of lowest students -->
            <div class="sub-card">
                <h4><i class="fas fa-triangle-exclamation" style="color:#ef4444;"></i> Siswa dengan KPI Terendah</h4>
                <div style="overflow-x:auto;">
                    <table class="table-lowest">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>KPI</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classAnalysis['lowest_students'] as $lp)
                                <tr>
                                    <td>
                                        <div style="font-weight:700; color:var(--dark);">{{ $lp->siswa->nama }}</div>
                                        <div style="font-size:11px; color:#94a3b8;">NIS: {{ $lp->siswa->nis }}</div>
                                    </td>
                                    <td>
                                        <span style="font-weight:800; color:#ef4444;">{{ number_format($lp->kpi_score, 1) }}</span>
                                    </td>
                                    <td>
                                        <button class="btn-action-small" onclick="preparePush({{ $lp->siswa_id }}, 'Perlu Ditingkatkan', 'Halo {{ $lp->siswa->nama }}, kami melihat skor KPI keseluruhan prestasi kamu masih rendah ({{ number_format($lp->kpi_score, 1) }}). Mari tingkatkan partisipasi belajar di rapor dan cobalah aktif mengikuti kepanitiaan kelas, OSIS, atau kompetisi minat bakat agar nilaimu optimal!')">
                                            <i class="fas fa-paper-plane"></i> Motivasi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="text-align:center; color:#94a3b8; padding: 20px;">Semua siswa memiliki capaian optimal.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Gaps / Push List -->
            <div class="sub-card">
                <h4><i class="fas fa-bullseye" style="color:var(--teal);"></i> Deteksi Celah Prestasi (Push Siswa)</h4>
                <div class="push-grid">
                    @forelse($classAnalysis['push_list'] as $ps)
                        <div class="push-card">
                            <div class="header">
                                <span class="name">{{ $ps['nama'] }}</span>
                                <span class="kpi">KPI: {{ number_format($ps['kpi_score'], 1) }}</span>
                            </div>
                            <div class="push-gaps">
                                @foreach($ps['gaps'] as $gap)
                                    <span class="gap-badge" onclick="preparePush({{ $ps['siswa_id'] }}, '{{ $gap['type'] }}', '{{ addslashes($gap['message']) }}')" title="Klik untuk push ke siswa">
                                        <i class="fas {{ $gap['icon'] }}"></i> {{ $gap['label'] }}
                                    </span>
                                @endforeach
                            </div>
                            <div style="text-align: right;">
                                <span style="font-size: 9px; color:#94a3b8; font-style:italic;">*Klik label merah untuk push</span>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: span 2; text-align:center; color:#94a3b8; padding:40px;">
                            <i class="fas fa-check-circle" style="font-size:32px; color:#22c55e; margin-bottom:10px; display:block;"></i>
                            Seluruh siswa kelas Anda telah memiliki keikutsertaan lengkap di semua bidang!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="grid-2">
        <!-- FORM KIRIM -->
        <div class="card">
            <h3 class="section-title"><i class="fas fa-paper-plane"></i> Form Kirim Notifikasi</h3>

            <form action="/penilaian/notification/store" method="POST" id="notifForm">
                @csrf

                <div class="form-group">
                    <label>Pilih Siswa</label>
                    <select name="siswa_id" id="siswaSelect" required onchange="updatePreview()">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswas as $s)
                            <option value="{{ $s->id }}" data-kpi="{{ $s->penilaian->kpi_score ?? 0 }}" data-nama="{{ $s->nama }}" data-bakat="{{ $s->penilaian->bakat_dominan ?? '-' }}">
                                {{ $s->nama }} (NIS: {{ $s->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="siswa-preview" id="siswaPreview">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <p style="font-weight:800; font-size:14px;" id="previewNama"></p>
                            <p style="font-size:12px; color:#64748b;" id="previewBakat"></p>
                        </div>
                        <div style="text-align:right;">
                            <p style="font-size:11px; color:#94a3b8;">KPI SCORE</p>
                            <p style="font-size:22px; font-weight:800; color:var(--teal);" id="previewKpi">0</p>
                        </div>
                    </div>
                    <div class="kpi-bar"><div class="kpi-fill" id="kpiBar" style="width:0%"></div></div>
                    <p style="font-size:11px; color:#94a3b8; margin-top:5px;" id="previewSaran"></p>
                </div>

                <div class="form-group">
                    <label>Jenis Notifikasi</label>
                    <div class="type-cards">
                        <div class="type-card" id="card-green" onclick="selectType('Pertahankan', this)">
                            <label class="type-card-label">
                                <input type="radio" name="type" value="Pertahankan">
                                <div class="type-icon" style="background:#f0fdf4; color:#16a34a;"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <p style="font-weight:800; font-size:14px; color:#16a34a;">🟢 Pertahankan</p>
                                    <p style="font-size:11px; color:#64748b;">Untuk siswa dengan KPI > 85</p>
                                </div>
                            </label>
                        </div>
                        <div class="type-card" id="card-yellow" onclick="selectType('Cukup Baik', this)">
                            <label class="type-card-label">
                                <input type="radio" name="type" value="Cukup Baik">
                                <div class="type-icon" style="background:#fffbeb; color:#d97706;"><i class="fas fa-info-circle"></i></div>
                                <div>
                                    <p style="font-weight:800; font-size:14px; color:#d97706;">🟡 Cukup Baik</p>
                                    <p style="font-size:11px; color:#64748b;">Untuk siswa dengan KPI 70–85</p>
                                </div>
                            </label>
                        </div>
                        <div class="type-card" id="card-red" onclick="selectType('Perlu Ditingkatkan', this)">
                            <label class="type-card-label">
                                <input type="radio" name="type" value="Perlu Ditingkatkan">
                                <div class="type-icon" style="background:#fff5f5; color:#dc2626;"><i class="fas fa-exclamation-circle"></i></div>
                                <div>
                                    <p style="font-weight:800; font-size:14px; color:#dc2626;">🔴 Perlu Ditingkatkan</p>
                                    <p style="font-size:11px; color:#64748b;">Untuk siswa dengan KPI &lt; 70</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Isi Pesan / Saran</label>
                    <textarea name="message" id="messageBox" placeholder="Tuliskan pesan untuk siswa..." required></textarea>
                </div>

                <button type="submit" class="btn-send"><i class="fas fa-paper-plane"></i> Kirim Notifikasi Sekarang</button>
            </form>
        </div>

        <!-- RIWAYAT TERAKHIR -->
        <div class="card">
            <h3 class="section-title"><i class="fas fa-history"></i> Notifikasi Terakhir Dikirim</h3>
            <div class="notif-feed">
                @forelse($recent as $n)
                    @php
                        $cls = 'tingkatkan'; $badge = '#dc2626'; $badgebg = '#fef2f2';
                        if($n->type == 'Pertahankan') { $cls = 'pertahankan'; $badge = '#16a34a'; $badgebg = '#f0fdf4'; }
                        elseif($n->type == 'Cukup Baik') { $cls = 'cukup'; $badge = '#d97706'; $badgebg = '#fffbeb'; }
                    @endphp
                    <div class="notif-card {{ $cls }}">
                        <span class="type-badge" style="color:{{ $badge }}; background:{{ $badgebg }};">{{ $n->type }}</span>
                        <p style="font-weight:700; font-size:13px; margin-bottom:4px; color:#1e293b;">→ {{ $n->siswa->nama }}</p>
                        <p class="msg">{{ $n->message }}</p>
                        <div class="meta">
                            <span>Dari: {{ $n->sender->name }}</span>
                            <span>{{ $n->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding:40px; color:#94a3b8;">
                        <i class="fas fa-inbox" style="font-size:32px; margin-bottom:10px; display:block;"></i>
                        Belum ada notifikasi yang dikirim.
                    </div>
                @endforelse
            </div>
            @if($recent->count() > 0)
                <a href="/notifikasi/riwayat" style="display:block; text-align:center; margin-top:20px; font-size:12px; font-weight:700; color:var(--teal); text-decoration:none;">
                    Lihat Semua Riwayat <i class="fas fa-arrow-right"></i>
                </a>
            @endif
        </div>
    </div>
</div>

<script>
    function preparePush(siswaId, type, message) {
        // 1. Select student in the dropdown
        const select = document.getElementById('siswaSelect');
        select.value = siswaId;
        
        // 2. Trigger change event to update the student preview
        updatePreview();
        
        // 3. Select type card
        let cardId = 'card-red'; // default
        if (type === 'Pertahankan') cardId = 'card-green';
        else if (type === 'Cukup Baik') cardId = 'card-yellow';
        
        selectType(type, document.getElementById(cardId));
        
        // 4. Put message into text box
        document.getElementById('messageBox').value = message;
        
        // 5. Scroll smoothly to the form
        document.getElementById('notifForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // 6. Flash the form container to indicate it's filled
        const formCard = document.querySelector('.card');
        formCard.style.boxShadow = '0 0 25px rgba(38,129,125,0.4)';
        formCard.style.borderColor = 'var(--teal)';
        setTimeout(() => {
            formCard.style.boxShadow = '0 10px 40px rgba(38,129,125,0.06)';
            formCard.style.borderColor = 'rgba(38,129,125,0.1)';
        }, 1500);
    }

    const templates = {
        'Pertahankan': 'Prestasi yang dicapai sudah sangat baik, harap dipertahankan dan ditingkatkan.',
        'Cukup Baik': 'Kemampuan sudah baik, namun masih perlu konsistensi dalam mengikuti kegiatan.',
        'Perlu Ditingkatkan': 'Prestasi akademik perlu ditingkatkan melalui latihan dan bimbingan tambahan.'
    };

    let selectedCard = null;

    function selectType(type, cardEl) {
        if (selectedCard) {
            selectedCard.classList.remove('selected-red', 'selected-yellow', 'selected-green');
        }
        selectedCard = cardEl;
        if (type === 'Pertahankan') cardEl.classList.add('selected-green');
        else if (type === 'Cukup Baik') cardEl.classList.add('selected-yellow');
        else cardEl.classList.add('selected-red');

        cardEl.querySelector('input[type=radio]').checked = true;
        document.getElementById('messageBox').value = templates[type];
    }

    function updatePreview() {
        const sel = document.getElementById('siswaSelect');
        const opt = sel.options[sel.selectedIndex];
        if (!opt.value) { document.getElementById('siswaPreview').classList.remove('active'); return; }

        const kpi = parseFloat(opt.dataset.kpi) || 0;
        document.getElementById('previewNama').textContent = opt.dataset.nama;
        document.getElementById('previewBakat').textContent = 'Bakat: ' + opt.dataset.bakat;
        document.getElementById('previewKpi').textContent = kpi.toFixed(1);
        document.getElementById('kpiBar').style.width = kpi + '%';
        document.getElementById('siswaPreview').classList.add('active');

        // Auto suggest type
        let saran = '';
        if (kpi > 85) {
            selectType('Pertahankan', document.getElementById('card-green'));
            saran = '✅ Sistem merekomendasikan: Pertahankan';
        } else if (kpi >= 70) {
            selectType('Cukup Baik', document.getElementById('card-yellow'));
            saran = '🔔 Sistem merekomendasikan: Cukup Baik';
        } else {
            selectType('Perlu Ditingkatkan', document.getElementById('card-red'));
            saran = '⚠️ Sistem merekomendasikan: Perlu Ditingkatkan';
        }
        document.getElementById('previewSaran').textContent = saran;
    }
</script>
</body>
</html>
