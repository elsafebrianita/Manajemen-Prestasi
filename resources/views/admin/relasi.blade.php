<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relasi Guru & Mapel - SIMPRES</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --secondary: #0f172a;
            --bg-color: #f1f5f9;
            --surface: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-color); color: var(--text-main); padding: 40px; }
        .container { max-width: 1400px; margin: 0 auto; }

        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header-title h1 { font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 800; color: var(--secondary); }
        .header-title p { color: var(--text-muted); font-size: 13px; margin-top: 4px; }
        .btn { padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; transition: 0.25s; }
        .btn-secondary { background: white; color: var(--secondary); border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background: #f8fafc; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-light); }

        /* Alerts */
        .alert { padding: 16px 22px; border-radius: 14px; margin-bottom: 25px; font-weight: 700; display: flex; align-items: center; gap: 12px; }
        .alert-success { background: #ecfdf5; color: #059669; border-left: 5px solid #10b981; }
        .alert-danger  { background: #fef2f2; color: #b91c1c;  border-left: 5px solid #ef4444; }

        /* Stats */
        .stats-bar { display: grid; grid-template-columns: repeat(4,1fr); gap: 18px; margin-bottom: 28px; }
        .stat-card { background: white; border-radius: 16px; padding: 18px 22px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .si-teal   { background: #ccfbf1; color: #0f766e; }
        .si-blue   { background: #dbeafe; color: #2563eb; }
        .si-pink   { background: #fce7f3; color: #db2777; }
        .si-orange { background: #ffedd5; color: #ea580c; }
        .stat-num { font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 800; color: var(--secondary); }
        .stat-lbl { font-size: 12px; color: var(--text-muted); font-weight: 600; }

        /* Main grid */
        .main-grid { display: grid; grid-template-columns: 1fr 340px; gap: 28px; }

        /* Teacher cards */
        .card { background: white; border-radius: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.03); }
        .card-header { background: #f8fafc; padding: 16px 22px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .teacher-info { display: flex; align-items: center; gap: 14px; }
        .teacher-avatar { width: 42px; height: 42px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 16px; }
        .teacher-name { font-weight: 700; color: var(--secondary); font-size: 15px; }
        .teacher-jabatan { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
        .badge-role { padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .r-guru      { background: #eff6ff; color: #2563eb; }
        .r-walikelas { background: #fdf2f8; color: #db2777; }
        .r-wakasiswa { background: #fff7ed; color: #ea580c; }

        /* Mapel chips inside card */
        .card-body { padding: 16px 22px; }
        .mapel-grid { display: flex; flex-wrap: wrap; gap: 8px; }
        .mapel-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: #f1f5f9; border-radius: 10px; padding: 6px 12px;
            font-size: 12px; font-weight: 600; color: var(--text-main);
            border: 1px solid #e2e8f0;
            transition: 0.2s;
        }
        .mapel-chip:hover { background: #e0f2fe; border-color: #7dd3fc; }
        .mapel-chip .kelas-tag { background: var(--primary); color: white; border-radius: 6px; padding: 2px 7px; font-size: 10px; font-weight: 700; }
        .del-btn { background: #fef2f2; color: #ef4444; border: none; border-radius: 6px; padding: 2px 6px; cursor: pointer; font-size: 10px; margin-left: 4px; transition: 0.2s; }
        .del-btn:hover { background: #ef4444; color: white; }

        /* Search bar */
        .search-bar { display: flex; gap: 12px; margin-bottom: 22px; }
        .search-bar input, .search-bar select { flex: 1; padding: 11px 16px; border-radius: 12px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; font-family: 'Inter', sans-serif; }
        .search-bar input:focus, .search-bar select:focus { border-color: var(--primary-light); }

        /* Form card */
        .form-card { background: white; border-radius: 20px; border: 1px solid #e2e8f0; padding: 26px; position: sticky; top: 30px; }
        .form-card h3 { font-family: 'Poppins', sans-serif; font-size: 17px; font-weight: 800; color: var(--secondary); margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 7px; }
        .form-control { width: 100%; padding: 11px 14px; border-radius: 11px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; transition: 0.25s; font-family: 'Inter', sans-serif; }
        .form-control:focus { border-color: var(--primary-light); box-shadow: 0 0 0 3px rgba(20,184,166,0.1); }
        .btn-full { width: 100%; justify-content: center; padding: 13px; margin-top: 4px; }

        /* Empty state */
        .empty-state { text-align: center; padding: 50px 20px; color: var(--text-muted); }
        .empty-state i { font-size: 48px; opacity: 0.25; display: block; margin-bottom: 12px; }
    </style>
</head>
<body>
<div class="container">

    <div class="header-section">
        <div class="header-title">
            <h1><i class="fas fa-sitemap" style="color:var(--primary);"></i> RELASI GURU, MAPEL &amp; KELAS</h1>
            <p>SIMPRES | SMK Negeri 1 Talamau — Pembagian Jam Mengajar</p>
        </div>
        <a href="/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</div>
    @endif

    {{-- Stats --}}
    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-icon si-teal"><i class="fas fa-link"></i></div>
            <div><div class="stat-num">{{ $relasis->count() }}</div><div class="stat-lbl">Total Relasi</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="fas fa-chalkboard-teacher"></i></div>
            <div><div class="stat-num">{{ $relasis->pluck('guru_id')->unique()->count() }}</div><div class="stat-lbl">Guru Mengajar</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-pink"><i class="fas fa-book"></i></div>
            <div><div class="stat-num">{{ $mapels->count() }}</div><div class="stat-lbl">Mata Pelajaran</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-orange"><i class="fas fa-door-open"></i></div>
            <div><div class="stat-num">{{ $kelas->count() }}</div><div class="stat-lbl">Kelas</div></div>
        </div>
    </div>

    <div class="main-grid">
        {{-- Left: Grouped Teacher Cards --}}
        <div>
            <div class="search-bar">
                <input type="text" id="searchGuru" placeholder="🔍 Cari nama guru..." oninput="filterCards()">
                <select id="filterMapel" onchange="filterCards()">
                    <option value="">-- Semua Mapel --</option>
                    @foreach($mapels as $m)
                        <option value="{{ strtolower($m->nama_mapel) }}">{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            @php
                $grouped = $relasis->groupBy('guru_id');
            @endphp

            @forelse($grouped as $guruId => $items)
                @php $guru = $items->first()->guru; @endphp
                <div class="card guru-card" data-name="{{ strtolower($guru->name ?? '') }}" data-mapels="{{ strtolower($items->map(fn($i) => $i->mapel?->nama_mapel ?? '')->implode(' ')) }}">
                    <div class="card-header">
                        <div class="teacher-info">
                            <div class="teacher-avatar">{{ substr($guru->name ?? 'G', 0, 1) }}</div>
                            <div>
                                <div class="teacher-name">{{ $guru->name ?? 'N/A' }}</div>
                                <div class="teacher-jabatan">{{ $guru->jabatan ?? 'Guru Mapel' }} &nbsp;|&nbsp; NIP: {{ $guru->nip ?? '-' }}</div>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span class="badge-role {{ $guru->role == 'walikelas' ? 'r-walikelas' : ($guru->role == 'wakasiswa' ? 'r-wakasiswa' : 'r-guru') }}">
                                {{ $guru->role == 'walikelas' ? 'Wali Kelas' : ($guru->role == 'wakasiswa' ? 'Waka Kesiswaan' : 'Guru Mapel') }}
                            </span>
                            <span style="font-size:11px; color:var(--text-muted); font-weight:700;">{{ $items->count() }} Relasi</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mapel-grid">
                            @foreach($items as $r)
                                <div class="mapel-chip">
                                    <i class="fas fa-book" style="color:var(--primary);font-size:11px;"></i>
                                    <span>{{ $r->mapel->nama_mapel ?? 'N/A' }}</span>
                                    <span class="kelas-tag">{{ $r->kelas->nama_kelas ?? 'N/A' }}</span>
                                    <form action="/admin/relasi/delete/{{ $r->id }}" method="GET" style="display:inline;" onsubmit="return confirm('Hapus relasi ini?')">
                                        <button type="submit" class="del-btn" title="Hapus"><i class="fas fa-times"></i></button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-unlink"></i>
                    <p>Belum ada relasi. Tambahkan menggunakan form di sebelah kanan.</p>
                </div>
            @endforelse

            <div id="emptySearch" style="display:none;" class="empty-state">
                <i class="fas fa-search"></i>
                <p>Tidak ada hasil yang cocok dengan pencarian.</p>
            </div>
        </div>

        {{-- Right: Form --}}
        <div>
            <div class="form-card">
                <h3><i class="fas fa-plus-circle" style="color:var(--primary);"></i> Tambah Relasi Baru</h3>
                <form action="/admin/relasi/store" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Pilih Guru</label>
                        <select name="guru_id" class="form-control" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pilih Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapels as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pilih Kelas</label>
                        <select name="kelas_id" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-link"></i> &nbsp; Hubungkan Guru &amp; Mapel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function filterCards() {
        const q = document.getElementById('searchGuru').value.toLowerCase();
        const mapelF = document.getElementById('filterMapel').value.toLowerCase();
        const cards = document.querySelectorAll('.guru-card');
        let visible = 0;
        cards.forEach(card => {
            const name = card.dataset.name || '';
            const mapels = card.dataset.mapels || '';
            const matchName = name.includes(q);
            const matchMapel = mapelF === '' || mapels.includes(mapelF);
            if (matchName && matchMapel) { card.style.display = ''; visible++; }
            else { card.style.display = 'none'; }
        });
        document.getElementById('emptySearch').style.display = visible === 0 ? 'block' : 'none';
    }
</script>
</body>
</html>
