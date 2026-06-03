<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Sekolah - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        :root { --gold: #14b8a6; --gold-bg: #f0fdfa; --teal: #0d9488; --bg: #f0fdfa; --dark: #0f766e; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); display: flex; min-height: 100vh; }

        /* BAGIAN MENU SAMPING (SIDEBAR) */
        .sidebar { width: 270px; min-height: 100vh; background: var(--dark); position: fixed; top: 0; left: 0; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 28px 24px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 12px; }
        .sidebar-brand h2 { color: #5eead4; font-size: 20px; font-weight: 800; line-height: 1.2; }
        .sidebar-brand p { color: rgba(255,255,255,0.9); font-size: 13px; margin-top: 4px; font-weight: 500; }
        .sidebar-menu { padding: 20px 16px; flex: 1; }
        .menu-label { font-size: 10px; font-weight: 800; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 1.5px; padding: 14px 8px 6px; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; color: #ffffff; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s ease; margin-bottom: 4px; border: 1px solid transparent; }
        .menu-item:hover, .menu-item.active { background: rgba(94, 234, 212, 0.15); color: #5eead4; border-color: rgba(94, 234, 212, 0.2); }
        .menu-item:active { transform: scale(0.98); }
        .sidebar-footer { padding: 16px; border-top: 1px solid rgba(255,255,255,0.08); }
        .logout-btn { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; color: #f87171; font-weight: 600; font-size: 14px; text-decoration: none; }

        /* BAGIAN KONTEN UTAMA (MAIN CONTENT) */
        .main { margin-left: 270px; flex: 1; }
        .topbar { background: white; padding: 18px 35px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; }
        .topbar h2 { font-size: 20px; font-weight: 800; color: var(--dark); }
        .kepsek-badge { background: linear-gradient(135deg, var(--teal), #14b8a6); color: white; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(20, 184, 166, 0.2); }

        .content { padding: 35px; }

        /* BAGIAN KOTAK STATISTIK (ANGKA-ANGKA) */
        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; margin-bottom: 35px; }
        .stat-card { background: white; border-radius: 20px; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #f1f5f9; }
        .stat-card .num { font-size: 32px; font-weight: 800; margin-bottom: 4px; }
        .stat-card .lbl { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }

        /* BAGIAN TOMBOL FILTER / TABULASI */
        .filter-tabs { display: flex; gap: 10px; margin-bottom: 25px; }
        .tab { padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer; border: 2px solid #e2e8f0; background: white; color: #64748b; transition: 0.2s; }
        .tab.active, .tab:hover { border-color: var(--teal); color: var(--teal); background: #f0fdf4; }

        /* BAGIAN DESAIN TABEL DATA SISWA */
        .table-card { background: white; border-radius: 25px; padding: 30px; box-shadow: 0 4px 25px rgba(0,0,0,0.04); }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 14px 16px; font-size: 11px; color: #94a3b8; text-align: left; border-bottom: 2px solid #f1f5f9; text-transform: uppercase; }
        tbody td { padding: 18px 16px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }

        .kpi-badge { font-size: 18px; font-weight: 800; }
        .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; }
        .status-menunggu { background: #f1f5f9; color: #64748b; }
        .status-layak { background: #f0fdf4; color: #16a34a; }
        .status-tidak { background: #fef2f2; color: #dc2626; }

        .btn-detail { background: #f1f5f9; color: #475569; padding: 8px 14px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
        .btn-approve { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; padding: 8px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
        .btn-reject { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 8px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }

        /* BAGIAN POP-UP KONFIRMASI (MODAL) */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center; }
        .modal-overlay.show { display: flex; }
        .modal-box { background: white; border-radius: 25px; padding: 35px; width: 500px; max-width: 95vw; }
        .modal-box h3 { font-size: 20px; font-weight: 800; margin-bottom: 5px; }
        .modal-box textarea { width: 100%; padding: 14px; border-radius: 14px; border: 2px solid #f1f5f9; font-family: inherit; font-size: 14px; height: 110px; resize: none; outline: none; margin-top: 15px; }
        .modal-box textarea:focus { border-color: var(--teal); }
        .modal-btn-row { display: flex; gap: 12px; margin-top: 20px; }
        .btn-confirm { flex: 1; padding: 14px; border-radius: 14px; border: none; font-size: 14px; font-weight: 800; cursor: pointer; }
        .btn-cancel { background: #f1f5f9; color: #64748b; flex: 1; padding: 14px; border-radius: 14px; border: none; font-size: 14px; font-weight: 700; cursor: pointer; }
        .alert-success { background: #ecfdf5; color: #059669; padding: 16px 22px; border-radius: 14px; font-weight: 700; margin-bottom: 25px; }
    </style>
</head>
<body>

<!-- === AWAL MENU SAMPING === -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div style="background: white; padding: 6px; border-radius: 50%; display: flex; align-items: center; justify-content: center; width: 52px; height: 52px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); flex-shrink: 0;">
            <img src="{{ asset('LogoSekolah.png') }}" alt="Logo SMK N 1 Talamau" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div>
            <h2>SIMPRES</h2>
            <p>SMK N 1 Talamau</p>
        </div>
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>
        <a href="/kepsek" class="menu-item active"><i class="fas fa-crown"></i> Dashboard Kepsek</a>

        <div class="menu-label">Evaluasi Siswa</div>
    <a href="/penilaian" class="menu-item"><i class="fas fa-list-check"></i> Daftar Penilaian KPI</a>
    <a href="/kpi" class="menu-item"><i class="fas fa-chart-bar"></i> Analisis KPI</a>
    <a href="/hasil-bakat" class="menu-item"><i class="fas fa-chart-pie"></i> Hasil Bakat</a>

    <div class="menu-label">Keputusan</div>
    <a href="/admin/publikasi" class="menu-item"><i class="fas fa-stamp"></i> Verifikasi Publikasi</a>
        <a href="/laporan" class="menu-item"><i class="fas fa-file-pdf"></i> Lihat Laporan</a>
    </div>
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form-ks').submit();">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
        <form id="logout-form-ks" action="{{ route('logout') }}" method="GET" style="display:none;">@csrf</form>
    </div>
</aside>

<!-- === AWAL KONTEN UTAMA === -->
<main class="main">
    <div class="topbar">
        <h2><i class="fas fa-crown" style="color: var(--teal);"></i> Dashboard Kepala Sekolah</h2>
        <div class="kepsek-badge"><i class="fas fa-user-tie"></i> {{ auth()->user()->name }}</div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <!-- === KOTAK STATISTIK (ANGKA TOTAL) === -->
        <div class="stats-grid">
            <div class="stat-card" style="background: linear-gradient(135deg, #26817d 0%, #1a5e5b 100%); color: white;">
                <div class="num">{{ $stats['total'] }}</div>
                <div class="lbl">Total Siswa Dinilai</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
                <div class="num">{{ $stats['menunggu'] }}</div>
                <div class="lbl">⏳ Menunggu Keputusan</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white;">
                <div class="num">{{ $stats['high'] }}</div>
                <div class="lbl">🚀 KPI ≥ 85</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white;">
                <div class="num">{{ $stats['medium'] }}</div>
                <div class="lbl">⭐ KPI 70–84</div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white;">
                <div class="num">{{ $stats['low'] }}</div>
                <div class="lbl">📋 KPI &lt; 70</div>
            </div>
        </div>

        <!-- === TOMBOL AKSI CEPAT (PINTASAN KE MENU LAIN) === -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 15px; margin-bottom: 30px;">
            <a href="/penilaian" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 20px; border-radius: 15px; text-decoration: none; text-align: center; font-weight: 700; font-size: 13px; display: flex; flex-direction: column; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-list-check" style="font-size: 24px;"></i> Daftar Penilaian
            </a>
            <a href="/kpi" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; padding: 20px; border-radius: 15px; text-decoration: none; text-align: center; font-weight: 700; font-size: 13px; display: flex; flex-direction: column; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-chart-bar" style="font-size: 24px;"></i> Analisis KPI
            </a>
            <a href="/admin/publikasi" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white; padding: 20px; border-radius: 15px; text-decoration: none; text-align: center; font-weight: 700; font-size: 13px; display: flex; flex-direction: column; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-stamp" style="font-size: 24px;"></i> Verifikasi Publikasi
            </a>
            <a href="/hasil-bakat" style="background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); color: white; padding: 20px; border-radius: 15px; text-decoration: none; text-align: center; font-weight: 700; font-size: 13px; display: flex; flex-direction: column; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-chart-pie" style="font-size: 24px;"></i> Bakat Siswa
            </a>
        </div>

        <!-- === PERINGKAT TERATAS PRESTASI & INFORMASI SISTEM === -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px;">
            <div class="table-card">
                <h3 style="font-size: 16px; font-weight: 800; color: #1c1917; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-trophy" style="color: #f59e0b;"></i> Top 3 Prestasi
                </h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @forelse($penilaians->take(3) as $idx => $p)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 12px; border-left: 4px solid {{ $idx == 0 ? '#fbbf24' : ($idx == 1 ? '#d1d5db' : '#cd7f32') }};">
                            <div>
                                <div style="font-weight: 700; color: #1c1917; font-size: 13px;">{{ $idx + 1 }}. {{ $p->siswa->nama ?? 'N/A' }}</div>
                                <div style="font-size: 11px; color: #94a3b8;">{{ $p->bakat_dominan ?? '-' }}</div>
                            </div>
                            <span style="font-size: 16px; font-weight: 800; color: #1e40af;">{{ number_format($p->kpi_score, 1) }}</span>
                        </div>
                    @empty
                        <div style="color: #94a3b8; text-align: center; padding: 20px;">Belum ada data</div>
                    @endforelse
                </div>
            </div>

            <div class="table-card">
                <h3 style="font-size: 16px; font-weight: 800; color: #1c1917; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-info-circle" style="color: #3b82f6;"></i> Informasi Penting
                </h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="padding: 14px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <div style="font-size: 12px; font-weight: 700; color: #1e40af; margin-bottom: 4px;">📊 Status Dashboard</div>
                        <div style="font-size: 13px; color: #1e40af;">{{ $stats['total'] }} siswa terdaftar dalam sistem KPI</div>
                    </div>
                    <div style="padding: 14px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px; border-left: 4px solid #f59e0b;">
                        <div style="font-size: 12px; font-weight: 700; color: #92400e; margin-bottom: 4px;">⏳ Dalam Proses</div>
                        <div style="font-size: 13px; color: #92400e;">{{ $stats['menunggu'] }} siswa menunggu keputusan Anda</div>
                    </div>
                    <div style="padding: 14px; background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%); border-radius: 12px; border-left: 4px solid #06b6d4;">
                        <div style="font-size: 12px; font-weight: 700; color: #0369a1; margin-bottom: 4px;">💡 Catatan</div>
                        <div style="font-size: 13px; color: #0369a1;">Periksa laporan KPI secara berkala untuk evaluasi menyeluruh</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- === TABEL DAFTAR LENGKAP SISWA DAN NILAI KPI === -->
        <div class="table-card" style="margin-top: 30px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
                <div>
                    <h3 style="font-size:18px; font-weight:800; color:#1c1917; display:flex; align-items:center; gap:10px;">
                        <i class="fas fa-table" style="color:#3b82f6;"></i> Daftar Lengkap Siswa
                    </h3>
                    <p style="margin-top:8px; color:#64748b; font-size:13px; max-width:680px;">
                        Total <strong>{{ $stats['total'] }}</strong> siswa dengan ringkasan skor KPI dan bakat dominan
                    </p>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>KPI Score</th>
                        <th>Bakat Dominan</th>
                        <th>Ranking</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penilaians as $i => $p)
                        <tr>
                            <td style="color:#94a3b8; font-weight:700;">{{ $i+1 }}</td>
                            <td>
                                <div style="font-weight:800; color:#1c1917;">{{ $p->siswa->nama ?? '-' }}</div>
                                <div style="font-size:11px; color:#94a3b8;">NIS: {{ $p->siswa->nis ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="kpi-badge" style="color: {{ $p->kpi_score >= 85 ? '#16a34a' : ($p->kpi_score >= 70 ? '#d97706' : '#dc2626') }}">
                                    {{ number_format($p->kpi_score, 1) }}
                                </span>
                            </td>
                            <td style="font-size:12px; color:#64748b; font-weight:600;">{{ $p->bakat_dominan ?? '-' }}</td>
                            <td style="font-size:12px; color:#475569; font-weight:700;">{{ $p->ranking ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- === POP-UP KONFIRMASI KEPUTUSAN KEPSEK === -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <div id="modalIcon" style="font-size:36px; margin-bottom:12px;"></div>
        <h3 id="modalTitle"></h3>
        <p id="modalSubtitle" style="font-size:13px; color:#64748b; margin-top:4px;"></p>

        <form method="POST" id="keputusanForm">
            @csrf
            <input type="hidden" name="kepsek_status" id="modalStatus">
            <label style="font-size:13px; font-weight:700; color:#475569; display:block; margin-top:15px;">Catatan / Alasan (opsional)</label>
            <textarea name="kepsek_catatan" placeholder="Tuliskan catatan atau alasan keputusan Anda..."></textarea>
            <div class="modal-btn-row">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-confirm" id="confirmBtn"></button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id, nama, status) {
        const isLayak = status === 'layak';
        document.getElementById('modalIcon').textContent = isLayak ? '✅' : '❌';
        document.getElementById('modalTitle').textContent = isLayak ? 'Nyatakan Layak Publikasi' : 'Tolak Publikasi';
        document.getElementById('modalSubtitle').textContent = `Siswa: ${nama}`;
        document.getElementById('modalStatus').value = status;
        document.getElementById('keputusanForm').action = `/kepsek/keputusan/${id}`;
        
        const btn = document.getElementById('confirmBtn');
        btn.textContent = isLayak ? '✅ Konfirmasi Layak' : '❌ Konfirmasi Tolak';
        btn.style.background = isLayak ? '#16a34a' : '#dc2626';
        btn.style.color = 'white';
        
        document.getElementById('modalOverlay').classList.add('show');
    }

    function closeModal() {
        document.getElementById('modalOverlay').classList.remove('show');
    }

    document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
</body>
</html>
