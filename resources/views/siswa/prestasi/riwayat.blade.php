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
            --primary: #43e6d0;
            --primary-light: #14b8a6;
            --bg: #f4f5f7;
            --surface: #b3d9d5ef;
            --text: #0f172a;
            --muted: #121314;
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        .page { width: 100%; max-width: 1280px; margin: 0 auto; padding: 30px 24px 60px; }
        .page-header { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 20px; margin-bottom: 30px; }
        .page-header h1 { font-size: 32px; font-weight: 800; letter-spacing: -0.04em; }
        .page-header p { color: var(--muted); margin-top: 12px; max-width: 650px; line-height: 1.7; }
        .page-actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .btn { display: inline-flex; align-items: center; gap: 10px; padding: 13px 18px; font-weight: 700; border-radius: 14px; text-decoration: none; transition: transform .2s ease, box-shadow .2s ease; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-secondary { background: #eef2ff; color: #3730a3; }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 12px 30px rgba(15,118,110,0.16); }

        .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 18px; margin-bottom: 30px; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 24px; padding: 24px; box-shadow: 0 18px 36px rgba(15, 118, 110, 0.05); }
        .card .label { color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: .12em; margin-bottom: 10px; }
        .card .value { font-size: 32px; font-weight: 800; color: var(--text); }
        .card .note { color: var(--muted); font-size: 13px; margin-top: 8px; line-height: 1.6; }

        .layout { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
        .panel { background: var(--surface); border: 1px solid var(--border); border-radius: 28px; padding: 28px; }
        .panel h2 { font-size: 20px; margin-bottom: 20px; }
        .panel p { color: var(--muted); line-height: 1.7; }

        .filter-box { margin-bottom: 24px; }
        .filter-box form { display: grid; grid-template-columns: 1fr auto; gap: 14px; align-items: end; }
        .field { display: flex; flex-direction: column; gap: 10px; }
        label { font-size: 13px; font-weight: 700; color: var(--text); }
        select, button { width: 100%; padding: 14px 16px; border-radius: 16px; border: 1px solid var(--border); font-size: 14px; color: var(--text); }
        select { background: white; }
        .filter-submit { background: var(--primary); color: white; border-color: var(--primary); cursor: pointer; }

        .table-card { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 18px 16px; text-align: left; border-bottom: 1px solid #f1f5f9; }
        th { font-size: 12px; text-transform: uppercase; letter-spacing: .12em; color: var(--muted); }
        tr:last-child td { border-bottom: none; }
        .badge { display: inline-flex; align-items: center; gap: 8px; padding: 7px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .badge-pending { background: #fef3c7; color: #b45309; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .small { font-size: 13px; color: var(--muted); }
        .action-link { display: inline-flex; align-items: center; gap: 8px; font-weight: 700; color: var(--primary); text-decoration: none; }

        .note-box { background: #eefaf6; border-radius: 22px; padding: 20px; border: 1px solid #dbe7e4; margin-top: 24px; }
        .note-box strong { color: var(--text); }

        .notification-item { border: 1px solid #e2e8f0; border-radius: 20px; padding: 18px; margin-bottom: 16px; background: #f8fafc; }
        .notification-item h4 { margin-bottom: 8px; font-size: 15px; }
        .notification-item p { color: var(--text); line-height: 1.65; }
        .notification-meta { display: flex; justify-content: space-between; gap: 12px; font-size: 13px; color: var(--muted); margin-top: 12px; }

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
                                <select name="status">
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
                                                    <div style="margin-top: 8px;">
                                                        <a href="/prestasi/edit/{{ $p->id }}" style="color: #b91c1c; font-weight: 800; text-decoration: underline; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-wrench"></i> Perbaiki & Ajukan Kembali</a>
                                                    </div>
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
                                        <td colspan="6" style="padding: 24px; text-align: center; color: var(--muted);">Belum ada riwayat prestasi. Silakan ajukan prestasi baru.</td>
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
