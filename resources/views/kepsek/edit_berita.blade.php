<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita Publikasi - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        :root { --teal: #26817d; --bg: #e6f7f6; --dark: #0f172a; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); min-height: 100vh; padding: 40px 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .page-header h1 { font-size: 26px; font-weight: 800; color: var(--dark); }
        .btn-back { background: white; color: var(--teal); padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 13px; border: 2px solid var(--teal); }

        .card { background: white; border-radius: 25px; padding: 35px; box-shadow: 0 10px 40px rgba(38,129,125,0.06); }
        
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-size: 13px; font-weight: 800; color: #1c1917; margin-bottom: 10px; }
        .form-group input[type="text"],
        .form-group textarea { 
            width: 100%; 
            padding: 14px; 
            border: 2px solid #f1f5f9; 
            border-radius: 14px; 
            font-family: inherit; 
            font-size: 14px; 
            outline: none; 
            transition: 0.2s;
        }
        .form-group input[type="text"]:focus,
        .form-group textarea:focus { 
            border-color: var(--teal); 
            background: #f0fdfa;
        }
        .form-group textarea { resize: vertical; min-height: 150px; }

        .student-info { background: #f0fdfa; border-left: 4px solid var(--teal); padding: 16px; border-radius: 12px; margin-bottom: 25px; }
        .student-info h4 { font-size: 14px; font-weight: 800; color: var(--teal); margin-bottom: 8px; }
        .student-info div { font-size: 13px; color: #64748b; margin-bottom: 4px; }

        .btn-group { display: flex; gap: 12px; }
        .btn { padding: 14px 28px; border-radius: 14px; border: none; font-size: 14px; font-weight: 800; cursor: pointer; transition: 0.2s; }
        .btn-cancel { background: #f1f5f9; color: #64748b; flex: 1; }
        .btn-cancel:hover { background: #e2e8f0; }
        .btn-submit { background: linear-gradient(135deg, var(--teal), #1f5654); color: white; flex: 1; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(38,129,125,0.3); }

        .help-text { font-size: 12px; color: #94a3b8; margin-top: 6px; font-style: italic; }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <div>
            <p style="color: var(--teal); font-weight: 800; font-size: 13px;">ADMIN SIMPRES</p>
            <h1><i class="fas fa-pen-to-square"></i> Edit Berita Publikasi</h1>
        </div>
        <a href="/admin/publikasi" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="card">
        <!-- Info Siswa -->
        <div class="student-info">
            <h4><i class="fas fa-user-check"></i> Informasi Siswa</h4>
            <div><strong>Nama:</strong> {{ $penilaian->siswa->nama }}</div>
            <div><strong>NIS:</strong> {{ $penilaian->siswa->nis }}</div>
            <div><strong>KPI Score:</strong> <span style="font-weight: 800; color: var(--teal);">{{ number_format($penilaian->kpi_score, 1) }}</span></div>
            <div><strong>Bakat Dominan:</strong> {{ $penilaian->bakat_dominan ?? '-' }}</div>
            <div><strong>Status Kepsek:</strong> <span style="background: #f0fdf4; color: #16a34a; padding: 3px 8px; border-radius: 6px; font-weight: 700;">✓ Layak</span></div>
        </div>

        <!-- Form -->
        <form method="POST" action="/kepsek/simpan-berita/{{ $penilaian->id }}">
            @csrf

            <!-- Berita Publikasi -->
            <div class="form-group">
                <label for="berita_publikasi">
                    <i class="fas fa-newspaper"></i> Berita / Deskripsi Publikasi *
                </label>
                <textarea 
                    id="berita_publikasi" 
                    name="berita_publikasi" 
                    placeholder="Tuliskan berita dan deskripsi singkat tentang prestasi siswa ini yang akan dipublikasikan di halaman utama..."
                    required
                    maxlength="1000"
                >{{ $penilaian->berita_publikasi ?? '' }}</textarea>
                <div class="help-text">Maksimal 1000 karakter. Jelaskan secara singkat prestasinya.</div>
                @error('berita_publikasi')
                    <div style="color: #dc2626; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Catatan Admin -->
            <div class="form-group">
                <label for="admin_catatan">
                    <i class="fas fa-comment"></i> Catatan Admin (Opsional)
                </label>
                <textarea 
                    id="admin_catatan" 
                    name="admin_catatan" 
                    placeholder="Tambahkan catatan atau keterangan khusus dari pihak admin..."
                    maxlength="500"
                >{{ $penilaian->admin_catatan ?? '' }}</textarea>
                <div class="help-text">Maksimal 500 karakter. Hanya untuk pencatatan internal.</div>
                @error('admin_catatan')
                    <div style="color: #dc2626; font-size: 12px; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="btn-group">
                <a href="/admin/publikasi" class="btn btn-cancel"><i class="fas fa-times"></i> Batal</a>
                <button type="submit" class="btn btn-submit"><i class="fas fa-check"></i> Publikasikan Sekarang</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
