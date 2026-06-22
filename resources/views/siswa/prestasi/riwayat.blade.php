<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Prestasi Saya - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --primary: #0f766e;
            --primary-hover: #0d5a54;
            --primary-light: #14b8a6;
            --bg: #f1f5f9;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        .page { width: 100%; max-width: 1280px; margin: 0 auto; padding: 40px 24px 60px; }
        
        .page-header { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 36px; }
        .page-header h1 { font-size: 32px; font-weight: 800; letter-spacing: -0.04em; color: var(--text); }
        .page-header p { color: var(--muted); margin-top: 8px; max-width: 650px; line-height: 1.6; font-size: 15px; }
        
        .page-actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .btn { display: inline-flex; align-items: center; gap: 10px; padding: 12px 20px; font-weight: 700; border-radius: 12px; text-decoration: none; font-size: 14px; transition: all .2s ease; cursor: pointer; }
        .btn-primary { background: var(--primary); color: white; border: none; }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(15,118,110,0.15); }
        .btn-secondary { background: var(--surface); color: #475569; border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background: #f8fafc; color: var(--text); transform: translateY(-1px); }

        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 36px; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -2px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -4px rgba(0,0,0,0.05); }
        .card .label { color: var(--muted); font-size: 11px; text-transform: uppercase; letter-spacing: .08em; font-weight: 700; margin-bottom: 8px; }
        .card .value { font-size: 32px; font-weight: 800; color: var(--text); line-height: 1; }
        .card .note { color: var(--muted); font-size: 12px; margin-top: 8px; line-height: 1.5; }

        .layout { display: grid; grid-template-columns: 2fr 1fr; gap: 28px; align-items: start; }
        .panel { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 28px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -2px rgba(0,0,0,0.05); min-height: 520px; }
        .panel h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; color: var(--text); display: flex; align-items: center; gap: 10px; }
        .panel p { color: var(--muted); line-height: 1.6; font-size: 14px; }

        .filter-box { margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--border); }
        .filter-box form { display: grid; grid-template-columns: 1fr auto; gap: 14px; align-items: end; }
        .field { display: flex; flex-direction: column; gap: 8px; }
        label { font-size: 12px; font-weight: 700; color: var(--text); text-transform: uppercase; letter-spacing: 0.04em; }
        select, button { width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 14px; color: var(--text); outline: none; transition: all 0.2s; }
        select { background: white; cursor: pointer; }
        select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15); }
        .filter-submit { background: var(--primary); color: white; border-color: var(--primary); cursor: pointer; font-weight: 700; }
        .filter-submit:hover { background: var(--primary-hover); }

        .table-card { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 16px; text-align: left; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        th { font-size: 11px; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); font-weight: 700; }
        tr:hover td { background-color: #f8fafc; }
        
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 99px; font-size: 12px; font-weight: 700; }
        .badge i { font-size: 11px; }
        .badge-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .badge-approved { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .badge-rejected { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        
        .small { font-size: 12px; color: var(--muted); }
        .action-link { display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: var(--primary); text-decoration: none; font-size: 13px; transition: color 0.2s; }
        .action-link:hover { color: var(--primary-hover); text-decoration: underline; }

        .note-box { background: #f0fdfa; border-radius: 12px; padding: 16px; border: 1px solid #ccfbf1; margin-top: 24px; color: #115e59; font-size: 14px; }
        .note-box strong { color: #115e59; }

        .notification-item { border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin-bottom: 16px; background: #fafafa; transition: border-color 0.2s; }
        .notification-item:hover { border-color: #cbd5e1; }
        .notification-item h4 { margin-bottom: 6px; font-size: 14px; font-weight: 700; color: var(--text); }
        .notification-item p { color: #334155; line-height: 1.5; font-size: 13px; }
        .notification-meta { display: flex; justify-content: space-between; gap: 12px; font-size: 11px; color: var(--muted); margin-top: 10px; }

        @media (max-width: 980px) { .layout { grid-template-columns: 1fr; } }
        @media (max-width: 680px) { .page { padding: 20px 16px; } .filter-box form { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="page">
        <div class="page-header">
            <div>
                <h1>Riwayat Prestasi Saya</h1>
                <p>Ini adalah halaman khusus riwayat prestasi siswa. Gunakan filter status untuk melihat pengajuan yang sedang ditunggu, disetujui, atau ditolak.</p>
            </div>
            <div class="page-actions">
                <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-house"></i> Dashboard</a>
                <a href="/prestasi/create" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah Prestasi</a>
            </div>
        </div>

        @php
            $totalPrestasi = $my_prestasi->count();
            $pendingCount = $my_prestasi->where('status', 'pending')->count();
            $approvedCount = $my_prestasi->where('status', 'disetujui')->count();
            $rejectedCount = $my_prestasi->where('status', 'ditolak')->count();
            $totalPoints = $my_prestasi->where('status', 'disetujui')->sum('poin');
        @endphp

        <div class="summary-grid">
            <div class="card">
                <div class="label">Total Prestasi</div>
                <div class="value">{{ $totalPrestasi }}</div>
                <div class="note">Jumlah semua pengajuan prestasi Anda saat ini.</div>
            </div>
            <div class="card">
                <div class="label">Pending</div>
                <div class="value">{{ $pendingCount }}</div>
                <div class="note">Prestasi yang masih menunggu verifikasi.</div>
            </div>
            <div class="card">
                <div class="label">Disetujui</div>
                <div class="value">{{ $approvedCount }}</div>
                <div class="note">Prestasi yang sudah mendapatkan persetujuan dan poin.</div>
            </div>
            <div class="card">
                <div class="label">Ditolak</div>
                <div class="value">{{ $rejectedCount }}</div>
                <div class="note">Prestasi yang perlu diperbaiki atau diajukan ulang.</div>
            </div>
        </div>

        <div class="layout">
            <div>
                <div class="panel">
                    <div class="filter-box">
                        <form method="GET" action="/prestasi/riwayat">
                            <div class="field">
                                <label>Status</label>
                                <select name="status" onchange="this.form.submit()">
                                    <option value=""{{ $status === '' ? ' selected' : '' }}>Semua Status</option>
                                    <option value="pending"{{ $status === 'pending' ? ' selected' : '' }}>Pending</option>
                                    <option value="disetujui"{{ $status === 'disetujui' ? ' selected' : '' }}>Disetujui</option>
                                    <option value="ditolak"{{ $status === 'ditolak' ? ' selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <button type="submit" class="filter-submit">Terapkan Filter</button>
                        </form>
                    </div>

                    <div class="table-card">
                        <table>
                            <thead>
                                <tr>
                                    <th>Prestasi</th>
                                    <th>Kategori</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Poin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($my_prestasi as $p)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 700; color: {{ $p->status === 'ditolak' ? '#e11d48' : 'inherit' }}">{{ $p->nama_prestasi }}</div>
                                            <div class="small">
                                                <span>{{ $p->juara }} / {{ $p->tingkat }}</span>
                                                @if($p->lokasi)
                                                    <span style="margin: 0 6px; color: #cbd5e1;">•</span>
                                                    <span><i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 4px;"></i>{{ $p->lokasi }}</span>
                                                @endif
                                            </div>
                                            @if($p->status === 'ditolak')
                                                <div style="margin-top: 10px; padding: 12px; background: #fff5f5; border: 1px solid #fee2e2; border-left: 4px solid #ef4444; border-radius: 10px; color: #b91c1c; font-size: 12.5px; font-weight: 500; line-height: 1.5; max-width: 500px;">
                                                    <i class="fas fa-exclamation-circle" style="color: #ef4444; margin-right: 6px;"></i><strong>Catatan Penolakan:</strong> {{ $p->keterangan ?? 'Tidak ada keterangan tambahan.' }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $p->kategori->nama_kategori ?? 'Umum' }}</td>
                                        <td>{{ $p->tanggal_capaian ? \Carbon\Carbon::parse($p->tanggal_capaian)->translatedFormat('Y') : '-' }}</td>
                                        <td>
                                            @if($p->status === 'pending')
                                                <span class="badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                                            @elseif($p->status === 'disetujui')
                                                <span class="badge badge-approved"><i class="fas fa-check-circle"></i> Disetujui</span>
                                            @else
                                                <span class="badge badge-rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $p->status === 'disetujui' ? '+' . $p->poin : '0' }}</td>
                                        <td>
                                            @if(in_array($p->status, ['pending', 'ditolak']))
                                                <a href="/prestasi/edit/{{ $p->id }}" class="action-link"><i class="fas fa-pen"></i> Ubah</a>
                                            @else
                                                <span class="small">Tidak bisa diubah</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="padding: 80px 24px; text-align: center; color: var(--muted);">
                                            <div style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"><i class="fas fa-medal"></i></div>
                                            <div style="font-weight: 700; color: var(--text); font-size: 16px; margin-bottom: 6px;">Belum Ada Riwayat Prestasi</div>
                                            <p style="margin: 0; font-size: 13px;">Silakan ajukan prestasi baru Anda melalui tombol di atas atau klik <a href="/prestasi/create" style="color: var(--primary); font-weight: 700; text-decoration: underline;">di sini</a>.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($totalPoints > 0)
                        <div class="note-box">
                            <strong>Total poin dari prestasi disetujui:</strong> {{ $totalPoints }} Poin.
                        </div>
                    @endif
                </div>
            </div>

            <aside>
                <div class="panel">
                    <h2>Notifikasi Guru</h2>
                    <p>Notifikasi ini berisi pesan penting dari guru, staf, atau wali terkait status prestasi Anda.</p>

                    @forelse($my_notifications as $notification)
                        <div class="notification-item">
                            <h4>{{ $notification->type ?? 'Info Sekolah' }}</h4>
                            <p>{{ $notification->message }}</p>
                            <div class="notification-meta">
                                <span>Dari: {{ $notification->sender->name ?? 'Guru/Admin' }}</span>
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="notification-item" style="background: #fff; border-color: #d1d5db;">
                            <p style="margin: 0; color: var(--muted);">Belum ada notifikasi dari guru. Cek kembali secara berkala.</p>
                        </div>
                    @endforelse

                    <div class="note-box" style="margin-top: 26px;">
                        <strong>Tip:</strong>
                        <p style="margin-top: 10px;">Jika prestasi ditolak, perhatikan catatan guru lalu kirim ulang dengan data yang lengkap.</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
