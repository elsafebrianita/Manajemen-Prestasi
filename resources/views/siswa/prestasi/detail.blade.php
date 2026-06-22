<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Prestasi - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --primary: #43e6d0;
            --primary-light: #14b8a6;
            --bg: #f4f5f7;
            --surface: #ffffff; /* Menggunakan putih murni agar kontras */
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        .page { width: 100%; max-width: 800px; margin: 0 auto; padding: 40px 24px; }
        
        .btn-back { display: inline-flex; align-items: center; gap: 8px; color: var(--muted); text-decoration: none; font-weight: 600; font-size: 14px; margin-bottom: 24px; transition: color 0.2s; }
        .btn-back:hover { color: var(--text); }

        .detail-card { background: var(--surface); border: 1px solid var(--border); border-radius: 28px; padding: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.04); }
        
        .header-section { border-bottom: 1px solid var(--border); padding-bottom: 24px; margin-bottom: 28px; }
        .prestasi-title { font-size: 26px; font-weight: 800; line-height: 1.3; margin-bottom: 12px; }
        
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 99px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .badge-approved { background: #dcfce7; color: #15803d; }
        .badge-rejected { background: #fee2e2; color: #b91c1c; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
        @media (max-width: 500px) { .info-grid { grid-template-columns: 1fr; } }
        
        .info-item { display: flex; flex-direction: column; gap: 6px; }
        .info-label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; }
        .info-value { font-size: 15px; font-weight: 600; }

        .note-box { border-radius: 20px; padding: 20px; line-height: 1.6; margin-top: 24px; }
        .note-box-danger { background: #fef2f2; border: 1px solid #fee2e2; color: #991b1b; }
        .note-box-success { background: #f0fdf4; border: 1px solid #dcfce7; color: #166534; }

        .sertifikat-section { margin-top: 32px; border-top: 1px solid var(--border); padding-top: 28px; }
        .btn-view-pdf { display: inline-flex; align-items: center; gap: 10px; background: var(--text); color: white; padding: 14px 24px; border-radius: 16px; text-decoration: none; font-weight: 700; transition: background 0.2s; }
        .btn-view-pdf:hover { background: #334155; }
    </style>
</head>
<body>
    <div class="page">
        <!-- Tombol Kembali -->
        <a href="/prestasi/riwayat" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
        </a>

        <div class="detail-card">
            <!-- Header Prestasi -->
            <div class="header-section">
                <h1 class="prestasi-title">{{ $prestasi->nama_prestasi }}</h1>
                
                <!-- Status Badge -->
                @if($prestasi->status === 'pending')
                    <span class="badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                @elseif($prestasi->status === 'disetujui')
                    <span class="badge badge-approved"><i class="fas fa-check-circle"></i> Disetujui</span>
                @else
                    <span class="badge badge-rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                @endif
            </div>

            <!-- Grid Informasi -->
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Kategori</span>
                    <span class="info-value">{{ $prestasi->kategori->nama_kategori ?? 'Umum' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tingkat Lomba</span>
                    <span class="info-value">{{ $prestasi->tingkat }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pencapaian (Juara)</span>
                    <span class="info-value">{{ $prestasi->juara }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Capaian</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($prestasi->tanggal_capaian)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Lokasi</span>
                    <span class="info-value">{{ $prestasi->lokasi }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Poin Prestasi</span>
                    <span class="info-value" style="color: var(--primary-light); font-weight: 800; font-size: 18px;">
                        {{ $prestasi->status === 'disetujui' ? '+' . $prestasi->poin : '0' }} Poin
                    </span>
                </div>
            </div>

            <!-- Catatan Penolakan / Catatan Tambahan -->
            @if($prestasi->status === 'ditolak')
                <div class="note-box note-box-danger">
                    <h4 style="margin-bottom: 6px;"><i class="fas fa-exclamation-circle"></i> Catatan Penolakan Sekolah:</h4>
                    <p>{{ $prestasi->keterangan ?? 'Tidak ada catatan tambahan.' }}</p>
                    <p style="margin-top: 12px; font-weight: 700;">
                        <a href="/prestasi/edit/{{ $prestasi->id }}" style="color: #b91c1c; text-decoration: underline;">Klik di sini untuk mengedit dan memperbaiki data Anda.</a>
                    </p>
                </div>
            @elseif($prestasi->status === 'disetujui' && $prestasi->keterangan)
                <div class="note-box note-box-success">
                    <h4 style="margin-bottom: 6px;"><i class="fas fa-check-circle"></i> Catatan Guru:</h4>
                    <p>{{ $prestasi->keterangan }}</p>
                </div>
            @endif

            <!-- Lampiran Sertifikat PDF -->
            @if($prestasi->sertifikat)
                <div class="sertifikat-section">
                    <h3 style="font-size: 16px; margin-bottom: 16px;"><i class="fas fa-file-pdf" style="color: #ef4444; margin-right: 8px;"></i>Dokumen Sertifikat</h3>
                    <a href="{{ asset('uploads/sertifikat/' . $prestasi->sertifikat) }}" target="_blank" class="btn-view-pdf">
                        <i class="fas fa-external-link-alt"></i> Lihat Sertifikat (PDF)
                    </a>
                </div>
            @else
                <div class="sertifikat-section">
                    <p style="color: var(--muted); font-size: 14px; font-style: italic;">Tidak ada lampiran sertifikat yang diunggah.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>