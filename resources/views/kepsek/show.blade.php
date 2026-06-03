<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Akademik & Kinerja Siswa - SIMPRES</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        :root {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --secondary: #0f172a;
            --bg-color: #f0fdfa;
            --surface: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            padding: 40px;
        }
        .container {
            max-width: 1050px;
            margin: 0 auto;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            border-bottom: 2px solid #cbd5e1;
            padding-bottom: 20px;
        }
        .header-title h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: var(--secondary);
        }
        .header-title p {
            color: var(--text-muted);
            font-size: 13px;
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
        .btn-primary:hover { background: var(--primary-light); }
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background: #f8fafc; }

        .grid-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .card {
            background: var(--surface);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border: 1px solid #cbd5e1;
            margin-bottom: 30px;
        }
        .card-full {
            grid-column: 1 / -1;
        }
        .card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 12px;
        }

        .profile-table {
            width: 100%;
            font-size: 14px;
        }
        .profile-table td {
            padding: 8px 0;
            border: none;
        }
        .profile-table td.label {
            font-weight: 600;
            color: var(--text-muted);
            width: 140px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table th {
            text-align: left;
            padding: 12px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 2px solid #cbd5e1;
            background: #f8fafc;
        }
        table.data-table td {
            padding: 12px;
            font-size: 13px;
            border-bottom: 1px solid #cbd5e1;
        }
        .font-bold { font-weight: 700; }
        .text-center { text-align: center; }

        .score-pill {
            background: #f0fdf4;
            color: #16a34a;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 14px;
        }

        .kpi-indicator-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .kpi-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
        }
        .kpi-card .value {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 5px;
        }
        .kpi-card .lbl {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header-section">
            <div class="header-title">
                <h1>Analisis Akademik & Capaian Prestasi Siswa</h1>
                <p>Monitoring Detail Kepala Sekolah - SIMPRES SMK Negeri 1 Talamau</p>
            </div>
            <a href="/kepsek" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        <div class="grid-layout">
            
            <!-- 1. Profil Siswa -->
            <div class="card">
                <div class="card-title"><i class="fas fa-user-circle"></i> Profil Siswa</div>
                <table class="profile-table">
                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td>: <strong style="color: var(--secondary);">{{ $siswa->nama }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">NIS</td>
                        <td>: <code>{{ $siswa->nis }}</code></td>
                    </tr>
                    <tr>
                        <td class="label">Kelas</td>
                        <td>: {{ $siswa->kelasRel->nama_kelas ?? $siswa->kelas }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jurusan</td>
                        <td>: {{ $siswa->jurusan }}</td>
                    </tr>
                    <tr>
                        <td class="label">Wali Kelas</td>
                        <td>: {{ $siswa->walikelas->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status Publikasi</td>
                        <td>: 
                            @if($siswa->penilaian)
                                @if($siswa->penilaian->kepsek_status === 'layak')
                                    <span style="color: #16a34a; font-weight: 700;">✓ Disetujui Layak</span>
                                @elseif($siswa->penilaian->kepsek_status === 'tidak_layak')
                                    <span style="color: #dc2626; font-weight: 700;">✗ Tidak Layak</span>
                                @else
                                    <span style="color: #64748b; font-weight: 700;">⏳ Menunggu Evaluasi</span>
                                  @endif
                            @else
                                <span style="color: #dc2626; font-weight: 700;">Belum diproses Wali Kelas</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 2. KPI / SPI Score Card -->
            <div class="card">
                <div class="card-title"><i class="fas fa-chart-line"></i> Capaian Nilai KPI/SPI</div>
                @if($siswa->penilaian)
                    <div style="text-align: center; margin-bottom: 20px;">
                        <span class="value" style="font-size: 42px; font-weight: 800; color: var(--primary);">
                            {{ number_format($siswa->penilaian->kpi_score, 1) }}
                        </span>
                        <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">SKOR TOTAL KPI (SAW)</div>
                    </div>
                    <div class="kpi-indicator-grid">
                        <div class="kpi-card">
                            <div class="value">{{ number_format($siswa->penilaian->c1, 1) }}</div>
                            <div class="lbl">Akademik (C1)</div>
                        </div>
                        <div class="kpi-card">
                            <div class="value">{{ number_format($siswa->penilaian->c2, 1) }}</div>
                            <div class="lbl">Organisasi (C2)</div>
                        </div>
                        <div class="kpi-card">
                            <div class="value">{{ number_format($siswa->penilaian->c3, 1) }}</div>
                            <div class="lbl">Prestasi (C3)</div>
                        </div>
                        <div class="kpi-card">
                            <div class="value">{{ number_format($siswa->penilaian->c4, 1) }}</div>
                            <div class="lbl">Seni & Minat (C4)</div>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fas fa-exclamation-circle"></i> Wali kelas belum mengkalkulasi skor KPI siswa ini.
                    </div>
                @endif
            </div>

            <!-- 3. Detail Nilai dari Guru Mata Pelajaran -->
            <div class="card card-full">
                <div class="card-title"><i class="fas fa-book-open"></i> Detail Nilai Akademik Transparan (Dari Guru Mapel)</div>
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">Berikut adalah nilai aktual yang diinput langsung oleh masing-masing guru mata pelajaran ke dalam sistem.</p>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru Pengampu</th>
                            <th class="text-center" style="width: 120px;">Nilai KKM</th>
                            <th class="text-center" style="width: 150px;">Nilai Akhir</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapels as $index => $m)
                            @php
                                $grade = $nilaiSiswas->get($m->id);
                                $nilaiVal = $grade ? $grade->nilai : 0;
                                $predikat = $nilaiVal >= 90 ? 'A (Sangat Baik)' : ($nilaiVal >= 80 ? 'B (Baik)' : ($nilaiVal >= 75 ? 'C (Cukup)' : 'D (Kurang)'));
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-bold">{{ $m->nama_mapel }}</td>
                                <td>
                                    @if($grade && $grade->guru)
                                        {{ $grade->guru->name }}
                                    @else
                                        <span style="color: var(--danger); font-style: italic;">Belum diinput</span>
                                    @endif
                                </td>
                                <td class="text-center">75</td>
                                <td class="text-center font-bold" style="font-size: 15px; color: {{ $grade ? 'var(--secondary)' : 'var(--text-muted)' }};">
                                    {{ $grade ? number_format($grade->nilai, 0) : '-' }}
                                </td>
                                <td>
                                    @if($grade)
                                        {{ $predikat }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 25px; color: var(--text-muted);">
                                    Tidak ada mata pelajaran yang dipetakan untuk kelas siswa ini.
                                </td>
                            </tr>
                        @endforelse
                        
                        @if($siswa->penilaian)
                            <tr style="background: #f0fdfa;">
                                <td colspan="4" class="font-bold" style="text-align: right;">RATA-RATA NILAI AKADEMIK RAPOR (C1):</td>
                                <td class="text-center font-bold" style="font-size: 16px; color: var(--primary);">
                                    {{ number_format($siswa->penilaian->c1, 2) }}
                                </td>
                                <td>Poin Rapor Akhir</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- 4. Riwayat Prestasi Non-Akademik -->
            <div class="card card-full">
                <div class="card-title"><i class="fas fa-trophy"></i> Riwayat Prestasi Terdaftar</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Prestasi</th>
                            <th>Kategori</th>
                            <th>Tingkat</th>
                            <th>Juara</th>
                            <th class="text-center">Poin Indikator</th>
                            <th>Status Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa->prestasis as $idx => $p)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <div class="font-bold">{{ $p->nama_prestasi }}</div>
                                    @if($p->lokasi)
                                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                                            <i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 4px;"></i>{{ $p->lokasi }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $p->tingkat }}</td>
                                <td>{{ $p->juara }}</td>
                                <td class="text-center font-bold" style="color: var(--primary);">{{ $p->poin }}</td>
                                <td>
                                    @if($p->status === 'disetujui')
                                        <span style="color: #16a34a; font-weight: 700;"><i class="fas fa-check-circle"></i> Disetujui</span>
                                    @elseif($p->status === 'ditolak')
                                        <span style="color: #dc2626; font-weight: 700;"><i class="fas fa-times-circle"></i> Ditolak</span>
                                    @else
                                        <span style="color: #f59e0b; font-weight: 700;"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                    Belum ada data prestasi yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 5. Keputusan Layak Publikasi Kepala Sekolah -->
            @if($siswa->penilaian)
                <div class="card card-full">
                    <div class="card-title"><i class="fas fa-gavel"></i> Keputusan Kelayakan Publikasi Siswa Berprestasi</div>
                    <form action="/kepsek/keputusan/{{ $siswa->penilaian->id }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 700; display: block; margin-bottom: 8px;">Pilih Status Kelayakan:</label>
                            <div style="display: flex; gap: 15px;">
                                <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
                                    <input type="radio" name="kepsek_status" value="layak" {{ $siswa->penilaian->kepsek_status === 'layak' ? 'checked' : '' }} required>
                                    <span style="color: #16a34a;"><i class="fas fa-check"></i> Layak Publikasi</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
                                    <input type="radio" name="kepsek_status" value="tidak_layak" {{ $siswa->penilaian->kepsek_status === 'tidak_layak' ? 'checked' : '' }}>
                                    <span style="color: #dc2626;"><i class="fas fa-times"></i> Tidak Layak Publikasi</span>
                                </label>
                            </div>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="font-weight: 700; display: block; margin-bottom: 8px;">Catatan atau Alasan Keputusan:</label>
                            <textarea name="kepsek_catatan" placeholder="Tuliskan catatan atau masukan Anda..." style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 14px; height: 100px; resize: none; outline: none;">{{ $siswa->penilaian->kepsek_catatan }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan & Kirim Keputusan</button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</body>
</html>
