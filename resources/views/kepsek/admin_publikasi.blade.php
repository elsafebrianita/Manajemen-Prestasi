<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikasi Siswa Berprestasi - SIMPRES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        :root { --teal: #26817d; --bg: #e6f7f6; --dark: #0f172a; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); min-height: 100vh; padding: 40px 20px; }
        .container { max-width: 1100px; margin: 0 auto; }
        
        /* Modern Header Centered Layout */
        .page-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            padding: 30px 20px;
            background: linear-gradient(135deg, rgba(255,255,255,0.7) 0%, rgba(255,255,255,0.4) 100%);
            border-radius: 24px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 10px 30px rgba(38, 129, 125, 0.04);
        }
        .page-header h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--dark);
            margin-top: 6px;
        }
        .btn-back {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            color: var(--teal);
            padding: 10px 22px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            border: 2px solid var(--teal);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 10px rgba(38,129,125,0.06);
        }
        .btn-back:hover {
            background: var(--teal);
            color: white;
            transform: translateY(-50%) translateY(-2px);
            box-shadow: 0 6px 15px rgba(38,129,125,0.18);
        }

        .alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 18px 22px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; }
        .alert-success { background: #ecfdf5; color: #059669; padding: 16px 22px; border-radius: 14px; font-weight: 700; margin-bottom: 20px; }

        .card { background: white; border-radius: 25px; padding: 30px; box-shadow: 0 10px 40px rgba(38,129,125,0.06); border: 1px solid rgba(0,0,0,0.02); }
        .card-title { font-size: 18px; font-weight: 800; color: var(--dark); margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }

        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 14px 16px; font-size: 11px; color: #94a3b8; text-align: left; border-bottom: 2px solid #f1f5f9; text-transform: uppercase; }
        tbody td { padding: 16px; font-size: 13px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }

        .badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 8px; }
        .badge-layak { background: #f0fdf4; color: #16a34a; }
        .badge-tidak { background: #fef2f2; color: #dc2626; }
        .badge-published { background: #7c3aed; color: white; }

        .btn-publish { background: linear-gradient(135deg, #7c3aed, #6d28d9); color: white; border: none; padding: 9px 18px; border-radius: 10px; font-size: 12px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s ease; }
        .btn-publish:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-unpublish { background: #f1f5f9; color: #64748b; border: none; padding: 9px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; }
        .btn-unpublish:hover { background: #e2e8f0; }

        .section-divider { display: flex; align-items: center; gap: 15px; margin: 30px 0 20px; }
        .section-divider span { font-size: 13px; font-weight: 800; color: #94a3b8; white-space: nowrap; }
        .section-divider hr { flex: 1; border: none; border-top: 2px solid #f1f5f9; }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .page-header {
                padding: 50px 20px 20px 20px;
            }
            .btn-back {
                position: static;
                transform: none;
                margin-top: 15px;
                display: inline-block;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <a href="/dashboard" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        <p style="color:var(--teal); font-weight:800; font-size:13px; text-transform: uppercase; letter-spacing: 2px;">SIMPRES</p>
        <h1><i class="fas fa-stamp"></i> Publikasi Siswa Berprestasi</h1>
        <p style="color:#64748b; font-size:14px; margin-top:4px;">Eksekusi keputusan dari Kepala Sekolah</p>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background:#fef2f2; color:#dc2626; padding:16px 22px; border-radius:14px; font-weight:700; margin-bottom:20px;">
            <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($pending > 0)
        <div class="alert-warning">
            <i class="fas fa-clock"></i> Masih ada <strong>{{ $pending }} siswa</strong> yang belum mendapatkan keputusan dari Kepala Sekolah. Hubungi Kepala Sekolah untuk segera memberikan keputusan.
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 10px 30px rgba(38,129,125,0.04); border: 1px solid rgba(38,129,125,0.08);">
            <div class="stat-icon" style="background: rgba(38,129,125,0.1); color: var(--teal); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="fas fa-graduation-cap"></i></div>
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Evaluasi</div>
                <div style="font-size: 22px; font-weight: 800; color: var(--dark);">{{ $penilaians->count() }}</div>
            </div>
        </div>
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 10px 30px rgba(38,129,125,0.04); border: 1px solid rgba(38,129,125,0.08);">
            <div class="stat-icon" style="background: rgba(217,119,6,0.1); color: #d97706; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Menunggu Review</div>
                <div style="font-size: 22px; font-weight: 800; color: #d97706;">{{ $penilaians->where('kepsek_status', 'menunggu')->where('is_published', false)->count() }}</div>
            </div>
        </div>
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 10px 30px rgba(38,129,125,0.04); border: 1px solid rgba(38,129,125,0.08);">
            <div class="stat-icon" style="background: rgba(22,163,74,0.1); color: #16a34a; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="fas fa-check-double"></i></div>
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Disetujui Layak</div>
                <div style="font-size: 22px; font-weight: 800; color: #16a34a;">{{ $penilaians->where('kepsek_status', 'layak')->count() }}</div>
            </div>
        </div>
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 10px 30px rgba(38,129,125,0.04); border: 1px solid rgba(38,129,125,0.08);">
            <div class="stat-icon" style="background: rgba(124,58,237,0.1); color: #7c3aed; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="fas fa-globe"></i></div>
            <div>
                <div style="font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Telah Terbit</div>
                <div style="font-size: 22px; font-weight: 800; color: #7c3aed;">{{ $penilaians->filter(fn($p) => $p->is_published || $p->status_publikasi === 'published')->count() }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title"><i class="fas fa-list-check" style="color:var(--teal);"></i> Daftar Keputusan Kepala Sekolah</div>

        {{-- MENUNGGU KEPUTUSAN --}}
        @if($penilaians->where('kepsek_status','menunggu')->where('is_published', false)->count() > 0)
        <div class="section-divider"><span>⏳ MENUNGGU KEPUTUSAN ({{ $penilaians->where('kepsek_status','menunggu')->where('is_published', false)->count() }} siswa)</span><hr></div>
        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>KPI Score</th>
                    <th>Bakat Dominan</th>
                    <th>Catatan</th>
                    <th>Aksi Kepsek</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penilaians->where('kepsek_status','menunggu')->where('is_published', false) as $p)
                    <tr>
                        <td>
                            <div style="font-weight:800;">{{ $p->siswa->nama ?? '-' }}</div>
                            <div style="font-size:11px; color:#94a3b8;">NIS: {{ $p->siswa->nis ?? '-' }}</div>
                        </td>
                        <td><span style="font-size:18px; font-weight:800; color: {{ $p->kpi_score >= 85 ? '#16a34a' : ($p->kpi_score >= 70 ? '#d97706' : '#dc2626') }};">{{ number_format($p->kpi_score,1) }}</span></td>
                        <td style="font-size:12px; color:#64748b;">{{ $p->bakat_dominan ?? '-' }}</td>
                        <td style="font-size:12px; color:#64748b; max-width:150px;">{{ $p->kepsek_catatan ?? '-' }}</td>
                        <td>
                            @if(auth()->user()->akses_role === 'kepsek')
                                <div style="display: flex; gap: 6px;">
                                    <button onclick="openModal({{ $p->id }}, '{{ $p->siswa->nama }}', 'layak')" style="background: #f0fdf4; color: #16a34a; border: none; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;">✅ Layak</button>
                                    <button onclick="openModal({{ $p->id }}, '{{ $p->siswa->nama }}', 'tidak_layak')" style="background: #fef2f2; color: #dc2626; border: none; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;">❌ Tolak</button>
                                </div>
                            @else
                                <span style="background: #f8fafc; color: #64748b; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; border: 1px solid #e2e8f0; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-hourglass-half"></i> Menunggu Keputusan Kepsek</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        {{-- LAYAK PUBLIKASI --}}
        <div class="section-divider"><span>✅ LAYAK PUBLIKASI (BELUM TERBIT) ({{ $penilaians->where('kepsek_status','layak')->where('is_published', false)->count() }} siswa)</span><hr></div>
        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>KPI Score</th>
                    <th>Keputusan Kepsek</th>
                    <th>Catatan Kepsek</th>
                    <th>Status Publikasi</th>
                    <th>Aksi Publikasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penilaians->where('kepsek_status','layak')->where('is_published', false) as $p)
                    <tr>
                        <td>
                            <div style="font-weight:800;">{{ $p->siswa->nama ?? '-' }}</div>
                            <div style="font-size:11px; color:#94a3b8;">NIS: {{ $p->siswa->nis ?? '-' }}</div>
                        </td>
                        <td><span style="font-size:18px; font-weight:800; color:var(--teal);">{{ number_format($p->kpi_score,1) }}</span></td>
                        <td><span class="badge badge-layak">✅ Layak</span></td>
                        <td style="font-size:12px; color:#64748b; max-width:200px;">{{ $p->kepsek_catatan ?? '-' }}</td>
                        <td>
                            <span class="badge" style="background:#f1f5f9; color:#64748b;">Belum Dipublikasi</span>
                        </td>
                        <td>
                            @if(auth()->user()->akses_role === 'admin' || auth()->user()->akses_role === 'kepsek')
                                <a href="/kepsek/edit-berita/{{ $p->id }}" class="btn-publish" style="text-decoration: none; display: inline-flex;"><i class="fas fa-pen-to-square"></i> Tambah Berita</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center; padding:30px; color:#94a3b8;">Belum ada keputusan layak dari Kepala Sekolah.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- TELAH DIPUBLIKASIKAN (RIWAYAT) --}}
        @php
            $publishedList = $penilaians->filter(function($p) {
                return $p->is_published || $p->status_publikasi === 'published';
            });
        @endphp
        <div class="section-divider" style="margin-top:40px;"><span>🌐 TELAH DIPUBLIKASIKAN / RIWAYAT ({{ $publishedList->count() }} siswa)</span><hr></div>
        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>KPI Score</th>
                    <th>Keputusan Kepsek</th>
                    <th>Status Publikasi</th>
                    <th>Catatan & Berita</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publishedList as $p)
                    <tr>
                        <td>
                            <div style="font-weight:800;">{{ $p->siswa->nama ?? '-' }}</div>
                            <div style="font-size:11px; color:#94a3b8;">NIS: {{ $p->siswa->nis ?? '-' }}</div>
                        </td>
                        <td><span style="font-size:18px; font-weight:800; color:var(--teal);">{{ number_format($p->kpi_score,1) }}</span></td>
                        <td>
                            @if($p->kepsek_status === 'layak')
                                <span class="badge badge-layak">✅ Layak</span>
                            @elseif($p->kepsek_status === 'tidak_layak')
                                <span class="badge badge-tidak">❌ Tidak Layak</span>
                            @else
                                <span class="badge" style="background:#f1f5f9; color:#64748b;">Menunggu</span>
                            @endif
                        </td>
                        <td><span class="badge badge-published">🌐 Dipublikasikan</span></td>
                        <td style="font-size:12px; color:#64748b; max-width:250px;">
                            @if(!empty($p->berita_publikasi))
                                <div style="font-weight:700; color:var(--dark);">Berita:</div>
                                <div style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; line-height: 1.4;">{{ $p->berita_publikasi }}</div>
                            @else
                                <span style="font-style:italic; color:#94a3b8;">Belum ada berita tertulis</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="/kepsek/publish/{{ $p->id }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-unpublish"><i class="fas fa-eye-slash"></i> Batalkan</button>
                            </form>
                            @if(auth()->user()->akses_role === 'admin' && $p->kepsek_status === 'layak')
                                <a href="/kepsek/edit-berita/{{ $p->id }}" class="btn-publish" style="text-decoration: none; display: inline-flex; margin-left: 5px; background: linear-gradient(135deg, var(--teal), #14b8a6);"><i class="fas fa-edit"></i> Edit Berita</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center; padding:30px; color:#94a3b8;">Belum ada siswa yang dipublikasikan.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- TIDAK LAYAK --}}
        @if($penilaians->where('kepsek_status','tidak_layak')->where('is_published', false)->count() > 0)
        <div class="section-divider" style="margin-top:40px;"><span>❌ TIDAK LAYAK PUBLIKASI</span><hr></div>
        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>KPI Score</th>
                    <th>Keputusan Kepsek</th>
                    <th>Catatan Kepsek</th>
                    <th>Direview Pada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penilaians->where('kepsek_status','tidak_layak')->where('is_published', false) as $p)
                    <tr>
                        <td><strong>{{ $p->siswa->nama ?? '-' }}</strong></td>
                        <td><span style="font-size:16px; font-weight:800; color:#dc2626;">{{ number_format($p->kpi_score,1) }}</span></td>
                        <td><span class="badge badge-tidak">❌ Tidak Layak</span></td>
                        <td style="font-size:12px; color:#64748b;">{{ $p->kepsek_catatan ?? '-' }}</td>
                        <td style="font-size:12px; color:#94a3b8;">{{ $p->kepsek_reviewed_at ? \Carbon\Carbon::parse($p->kepsek_reviewed_at)->format('d M Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<!-- MODAL KEPUTUSAN -->
<div id="modalOverlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 25px; padding: 35px; width: 500px; max-width: 95vw;">
        <div id="modalIcon" style="font-size: 36px; margin-bottom: 12px;"></div>
        <h3 id="modalTitle" style="font-size: 20px; font-weight: 800; color: #1c1917;"></h3>
        <p id="modalSubtitle" style="font-size: 13px; color: #64748b; margin-top: 4px;"></p>
        
        <form method="POST" id="keputusanForm">
            @csrf
            <input type="hidden" name="kepsek_status" id="modalStatus">
            <label style="font-size: 13px; font-weight: 700; color: #475569; display: block; margin-top: 15px;">Catatan / Alasan (opsional)</label>
            <textarea name="kepsek_catatan" placeholder="Tuliskan catatan atau alasan keputusan Anda..." style="width: 100%; padding: 14px; border-radius: 14px; border: 2px solid #f1f5f9; font-family: inherit; font-size: 14px; height: 110px; resize: none; outline: none; margin-top: 10px;"></textarea>
            
            <div style="display: flex; gap: 12px; margin-top: 20px;">
                <button type="button" onclick="closeModal()" style="flex: 1; padding: 14px; border-radius: 14px; border: none; font-size: 14px; font-weight: 700; cursor: pointer; background: #f1f5f9; color: #64748b;">Batal</button>
                <button type="submit" id="confirmBtn" style="flex: 1; padding: 14px; border-radius: 14px; border: none; font-size: 14px; font-weight: 800; cursor: pointer; color: white;"></button>
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
        
        document.getElementById('modalOverlay').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalOverlay').style.display = 'none';
    }

    document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
</body>
</html>
