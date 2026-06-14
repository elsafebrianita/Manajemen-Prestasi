<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Capaian Siswa - SMK N 1 TALAMAU</title>
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

        .header-section { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .header-section h1 { font-size: 28px; font-weight: 800; color: var(--text-dark); }
        .btn-back { background: white; color: var(--primary-teal); padding: 12px 20px; border-radius: 15px; text-decoration: none; font-weight: 700; border: 2px solid var(--primary-teal); transition: 0.3s; }
        .btn-back:hover { background: var(--bg-cyan); }

        .main-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 30px; }

        .card { background: white; border-radius: 30px; padding: 30px; box-shadow: 0 15px 40px rgba(38, 129, 125, 0.05); border: 1px solid rgba(38, 129, 125, 0.1); margin-bottom: 30px; }

        .profile-section { text-align: center; }
        .avatar { width: 100px; height: 100px; background: var(--primary-teal); color: white; border-radius: 30px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 42px; font-weight: 800; }
        
        .kpi-score-badge { background: var(--text-dark); color: white; padding: 20px; border-radius: 20px; margin-top: 20px; }
        .kpi-score-badge h2 { font-size: 48px; color: #2dd4bf; margin: 10px 0; }

        .section-title { font-size: 18px; font-weight: 800; color: var(--primary-teal); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        
        .indicator-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .indicator-item { background: #f8fafc; padding: 15px; border-radius: 15px; border: 1px solid #e2e8f0; }
        .indicator-item label { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 5px; }
        .indicator-item .value { font-size: 20px; font-weight: 800; color: var(--text-dark); }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; font-size: 12px; color: #94a3b8; border-bottom: 2px solid #f1f5f9; }
        td { padding: 15px 12px; border-bottom: 1px solid #f8fafc; font-size: 14px; }

        .feedback-form select, .feedback-form textarea { width: 100%; padding: 15px; border-radius: 15px; border: 2px solid #f1f5f9; background: #f8fafc; font-family: inherit; margin-bottom: 15px; outline: none; }
        .feedback-form textarea { height: 120px; resize: none; }
        .btn-send { background: var(--primary-teal); color: white; border: none; padding: 18px; border-radius: 15px; font-weight: 800; cursor: pointer; width: 100%; transition: 0.3s; }
        .btn-send:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(38, 129, 125, 0.2); }

        .notif-item { padding: 15px; border-radius: 15px; margin-bottom: 15px; border-left: 4px solid #cbd5e1; background: #f8fafc; }
        .notif-type { font-size: 11px; font-weight: 800; padding: 4px 8px; border-radius: 5px; margin-bottom: 8px; display: inline-block; }
        .type-pertahankan { background: #f0fdf4; color: #16a34a; }
        .type-cukup { background: #fffbeb; color: #d97706; }
        .type-tingkatkan { background: #fef2f2; color: #dc2626; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-section">
            <div>
                <p style="color: var(--primary-teal); font-weight: 800; font-size: 14px; margin-bottom: 5px;">DETAIL CAPAIAN KPI</p>
                <h1>{{ $siswa->nama }}</h1>
            </div>
            <a href="/penilaian" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
        </header>

        @if(session('success'))
            <div style="background: #ecfdf5; color: #059669; padding: 20px; border-radius: 20px; margin-bottom: 30px; font-weight: 700;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="main-grid">
            <!-- LEFT COLUMN -->
            <div class="sidebar">
                <div class="card profile-section">
                    <div class="avatar">{{ substr($siswa->nama, 0, 1) }}</div>
                    <h3 style="font-size: 20px;">{{ $siswa->nama }}</h3>
                    <p style="color: #64748b; font-weight: 600;">NIS: {{ $siswa->nis }}</p>
                    <p style="color: #64748b; font-weight: 600;">Kelas: {{ $siswa->kelas }}</p>

                    <div class="kpi-score-badge">
                        <p style="font-size: 11px; color: #94a3b8; text-transform: uppercase;">Skor Akhir KPI</p>
                        <h2>{{ number_format($siswa->penilaian->kpi_score ?? 0, 1) }}</h2>
                        <p style="font-size: 12px; color: #2dd4bf; font-weight: 700;">{{ $siswa->penilaian->bakat_dominan ?? 'Menunggu Analisis' }}</p>
                    </div>
                </div>

                <div class="card">
                    <h3 class="section-title"><i class="fas fa-paper-plane"></i> Kirim Feedback</h3>
                    @php 
                        $kpi = $siswa->penilaian->kpi_score ?? 0;
                        $suggestedType = 'Perlu Ditingkatkan';
                        $suggestedMsg = 'Prestasi akademik perlu ditingkatkan melalui latihan dan bimbingan tambahan.';
                        
                        if($kpi > 85) {
                            $suggestedType = 'Pertahankan';
                            $suggestedMsg = 'Prestasi yang dicapai sudah sangat baik, harap dipertahankan dan ditingkatkan.';
                        } elseif($kpi >= 70) {
                            $suggestedType = 'Cukup Baik';
                            $suggestedMsg = 'Kemampuan sudah baik, namun masih perlu konsistensi dalam mengikuti kegiatan.';
                        }
                    @endphp
                    
                    <div style="background: #f8fafc; padding: 15px; border-radius: 15px; margin-bottom: 20px; border: 1px dashed var(--primary-teal);">
                        <p style="font-size: 12px; color: #64748b; font-weight: 700;"><i class="fas fa-robot"></i> REKOMENDASI SISTEM:</p>
                        <p style="font-size: 13px; color: var(--text-dark); font-weight: 600; margin-top: 5px;">
                            Berdasarkan KPI ({{ number_format($kpi, 1) }}), siswa ini masuk kategori <strong style="color: var(--primary-teal);">{{ $suggestedType }}</strong>.
                        </p>
                    </div>

                    <form action="/penilaian/notification/store" method="POST" class="feedback-form" id="feedbackForm">
                        @csrf
                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                        
                        <label style="font-size: 13px; font-weight: 700; color: #475569; display: block; margin-bottom: 8px;">Jenis Rekomendasi</label>
                        <select name="type" id="typeSelect" required>
                            <option value="Pertahankan" {{ $suggestedType == 'Pertahankan' ? 'selected' : '' }}>🟢 Pertahankan (KPI > 85)</option>
                            <option value="Cukup Baik" {{ $suggestedType == 'Cukup Baik' ? 'selected' : '' }}>🟡 Cukup Baik (KPI 70-85)</option>
                            <option value="Perlu Ditingkatkan" {{ $suggestedType == 'Perlu Ditingkatkan' ? 'selected' : '' }}>🔴 Perlu Ditingkatkan (KPI < 70)</option>
                        </select>

                        <label style="font-size: 13px; font-weight: 700; color: #475569; display: block; margin-bottom: 8px;">Isi Pesan / Saran</label>
                        <textarea name="message" id="messageBox" placeholder="Tuliskan saran peningkatan atau apresiasi untuk siswa..." required>{{ $suggestedMsg }}</textarea>

                        <button type="submit" class="btn-send">
                            <i class="fas fa-send"></i> Kirim Notifikasi ke Siswa
                        </button>
                    </form>
                </div>

                <script>
                    const templates = {
                        'Pertahankan': 'Prestasi yang dicapai sudah sangat baik, harap dipertahankan dan ditingkatkan.',
                        'Cukup Baik': 'Kemampuan sudah baik, namun masih perlu konsistensi dalam mengikuti kegiatan.',
                        'Perlu Ditingkatkan': 'Prestasi akademik perlu ditingkatkan melalui latihan dan bimbingan tambahan.'
                    };

                    document.getElementById('typeSelect').addEventListener('change', function() {
                        const val = this.value;
                        if(templates[val]) {
                            document.getElementById('messageBox').value = templates[val];
                        }
                    });
                </script>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="content">
                <div class="card">
                    <h3 class="section-title"><i class="fas fa-chart-bar"></i> Capaian Indikator (A, B, C, D)</h3>
                    <div class="indicator-grid">
                        <div class="indicator-item">
                            <label>A - Akademik (Rapor)</label>
                            <div class="value">{{ $siswa->penilaian->c1 ?? '0' }}</div>
                        </div>
                        <div class="indicator-item">
                            <label>B - Prestasi Akademik</label>
                            <div class="value">{{ $siswa->penilaian->c2 ?? '0' }}</div>
                        </div>
                        <div class="indicator-item">
                            <label>C - Organisasi</label>
                            <div class="value">{{ $siswa->penilaian->c3 ?? '0' }}</div>
                        </div>
                        <div class="indicator-item">
                            <label>D - Non-Akademik</label>
                            <div class="value">{{ $siswa->penilaian->c4 ?? '0' }}</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3 class="section-title"><i class="fas fa-certificate"></i> Portofolio Sertifikat & Prestasi</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Prestasi</th>
                                <th>Kategori</th>
                                <th>Tingkat</th>
                                <th style="text-align: center;">Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->prestasis as $p)
                                <tr>
                                    <td>
                                        <strong>{{ $p->nama_prestasi }}</strong>
                                        <br>
                                        <small style="color: #94a3b8;">
                                            {{ $p->tanggal_capaian ? \Carbon\Carbon::parse($p->tanggal_capaian)->translatedFormat('d M Y') : '-' }}
                                            @if($p->lokasi)
                                                · {{ $p->lokasi }}
                                            @endif
                                        </small>
                                    </td>
                                    <td>{{ $p->kategori->nama_kategori }}</td>
                                    <td>{{ $p->tingkat }}</td>
                                    <td style="text-align: center;">
                                        @if($p->sertifikat)
                                            <a href="{{ asset('uploads/sertifikat/'.$p->sertifikat) }}" target="_blank" style="color: var(--primary-teal); font-size: 18px;"><i class="fas fa-file-pdf"></i></a>
                                        @else
                                            <span style="color: #cbd5e1;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada data prestasi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <h3 class="section-title"><i class="fas fa-history"></i> Riwayat Feedback Guru</h3>
                    @forelse($siswa->notifications as $n)
                        <div class="notif-item">
                            @php 
                                $class = 'type-tingkatkan';
                                if($n->type == 'Pertahankan') $class = 'type-pertahankan';
                                elseif($n->type == 'Cukup Baik') $class = 'type-cukup';
                            @endphp
                            <span class="notif-type {{ $class }}">{{ $n->type }}</span>
                            <p style="font-size: 14px; margin-bottom: 10px;">{{ $n->message }}</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <small style="color: #94a3b8;"><i class="fas fa-user-edit"></i> Oleh: {{ $n->sender->name }}</small>
                                <small style="color: #94a3b8;">{{ $n->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada feedback yang dikirim.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>
</html>
