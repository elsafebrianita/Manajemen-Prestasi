<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Notifikasi - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        :root { --teal: #26817d; --bg: #e6f7f6; --dark: #0f172a; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); min-height: 100vh; padding: 40px 20px; }
        .container { max-width: 960px; margin: 0 auto; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .page-header h1 { font-size: 26px; font-weight: 800; color: var(--dark); }
        .btn-back { background: white; color: var(--teal); padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 13px; border: 2px solid var(--teal); display: flex; align-items: center; gap: 8px; }
        .btn-kirim { background: var(--teal); color: white; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .card { background: white; border-radius: 25px; padding: 30px; box-shadow: 0 10px 40px rgba(38,129,125,0.06); }

        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-box { background: white; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 5px 20px rgba(38,129,125,0.05); }
        .stat-box .num { font-size: 32px; font-weight: 800; }
        .stat-box .lbl { font-size: 12px; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-top: 4px; }

        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 14px 16px; text-align: left; font-size: 11px; color: #94a3b8; border-bottom: 2px solid #f1f5f9; text-transform: uppercase; }
        tbody td { padding: 16px; font-size: 13px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
        .badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px; }
        .badge-green { background: #f0fdf4; color: #16a34a; }
        .badge-yellow { background: #fffbeb; color: #d97706; }
        .badge-red { background: #fef2f2; color: #dc2626; }

        .empty-state { text-align: center; padding: 60px; color: #94a3b8; }
        .empty-state i { font-size: 48px; display: block; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <div>
            <p style="color: var(--teal); font-weight: 800; font-size: 13px;">GURU SIMPRES</p>
            <h1><i class="fas fa-history"></i> Riwayat Notifikasi</h1>
            <p style="color:#64748b; font-size:14px; margin-top:4px;">Semua notifikasi yang telah dikirim ke siswa</p>
        </div>
        <div style="display:flex; gap:12px;">
            <a href="/notifikasi" class="btn-kirim"><i class="fas fa-plus"></i> Kirim Baru</a>
            <a href="/dashboard" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-box">
            <div class="num" style="color: var(--teal);">{{ $total }}</div>
            <div class="lbl">Total Notifikasi</div>
        </div>
        <div class="stat-box">
            <div class="num" style="color: #16a34a;">{{ $totalPertahankan }}</div>
            <div class="lbl">🟢 Pertahankan</div>
        </div>
        <div class="stat-box">
            <div class="num" style="color: #dc2626;">{{ $totalTingkatkan }}</div>
            <div class="lbl">🔴 Perlu Ditingkatkan</div>
        </div>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>Jenis Notifikasi</th>
                    <th>Pesan</th>
                    <th>Dikirim Oleh</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $i => $n)
                    @php
                        $badgeCls = 'badge-red';
                        if($n->type == 'Pertahankan') $badgeCls = 'badge-green';
                        elseif($n->type == 'Cukup Baik') $badgeCls = 'badge-yellow';
                    @endphp
                    <tr>
                        <td style="color:#94a3b8; font-weight:700;">{{ $i + 1 }}</td>
                        <td>
                            <div style="font-weight:800; color:#1e293b;">{{ $n->siswa->nama ?? '-' }}</div>
                            <div style="font-size:11px; color:#94a3b8;">NIS: {{ $n->siswa->nis ?? '-' }}</div>
                        </td>
                        <td><span class="badge {{ $badgeCls }}">{{ $n->type }}</span></td>
                        <td style="max-width:280px; color:#475569;">{{ Str::limit($n->message, 80) }}</td>
                        <td style="font-weight:700; color:#1e293b;">{{ $n->sender->name ?? '-' }}</td>
                        <td style="color:#94a3b8; white-space:nowrap;">{{ $n->created_at->format('d M Y') }}<br><small>{{ $n->created_at->format('H:i') }}</small></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                Belum ada notifikasi yang dikirim.<br>
                                <a href="/notifikasi" style="color:var(--teal); font-weight:700; text-decoration:none; margin-top:15px; display:inline-block;">Kirim Notifikasi Pertama →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
