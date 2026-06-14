<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Prestasi - SMK N 1 TALAMAU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

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
            padding: 60px 20px;
            color: var(--text-dark);
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header-section {
            text-align: center;
            margin-bottom: 50px;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #64748b;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 30px;
            background: white;
            padding: 12px 25px;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(38, 129, 125, 0.05);
            transition: 0.3s;
        }
        .back-btn:hover { color: var(--primary-teal); transform: translateX(-8px); }

        .header-section .label-top {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: var(--primary-teal);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 12px;
        }
        .header-section h1 {
            font-size: 42px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -1.5px;
            line-height: 1;
        }
        .header-section .school-name {
            display: block;
            font-size: 32px;
            color: var(--primary-teal);
            font-weight: 800;
            margin-top: 5px;
        }

        .prestasi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .p-card {
            background: white;
            padding: 35px;
            border-radius: 35px;
            border: 1px solid rgba(38, 129, 125, 0.05);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 15px 35px rgba(38, 129, 125, 0.05);
        }
        .p-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px rgba(38, 129, 125, 0.1);
            border-color: var(--primary-teal);
        }

        .p-rank-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #f59e0b;
            color: white;
            padding: 10px 25px;
            border-bottom-left-radius: 25px;
            font-size: 13px;
            font-weight: 800;
        }

        .p-year {
            font-size: 14px;
            font-weight: 800;
            color: #94a3b8;
            margin-bottom: 15px;
        }

        .p-body h3 {
            margin: 0 0 20px;
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .p-info-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
            font-size: 15px;
            color: #475569;
        }
        .p-info-row i {
            width: 35px;
            height: 35px;
            background: var(--bg-cyan);
            color: var(--primary-teal);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
        .student-name { font-weight: 700; color: var(--text-dark); }

        @media (max-width: 600px) {
            .header-section h1 { font-size: 30px; }
            .prestasi-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-section">
            <a href="/kategori/show/{{ $kategori->parent_id }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali Bidang</span>
            </a>
            <span class="label-top">Rekapitulasi Siswa</span>
            <h1>{{ $kategori->nama_kategori }}</h1>
            <span class="school-name">SMK N 1 TALAMAU</span>
        </header>

        <div class="prestasi-grid">
            @forelse($prestasi as $p)
                <div class="p-card">
                    <div class="p-rank-badge">{{ $p->juara }}</div>
                    <div class="p-year"><i class="far fa-calendar-alt"></i> TA {{ $p->tanggal_capaian ? \Carbon\Carbon::parse($p->tanggal_capaian)->format('Y') : '-' }}</div>
                    <div class="p-body">
                        <h3>{{ $p->nama_prestasi }}</h3>
                        
                        <div class="p-info-row">
                            <i class="fas fa-user-graduate"></i>
                            <span class="student-name">{{ $p->siswa->nama ?? 'Siswa' }}</span>
                        </div>
                        
                        <div class="p-info-row">
                            <i class="fas fa-award"></i>
                            <span>Tingkat {{ $p->tingkat }}</span>
                        </div>

                        @if($p->lokasi)
                            <div class="p-info-row">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $p->lokasi }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 100px; color: #94a3b8;">Belum ada data prestasi.</div>
            @endforelse
        </div>
    </div>
</body>
</html>
