<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategori->nama_kategori }} - SMK N 1 TALAMAU</title>
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
            max-width: 850px;
            margin: 0 auto;
        }

        .header-section {
            text-align: center;
            margin-bottom: 60px;
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

        .list-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .item-card {
            background: white;
            padding: 30px 40px;
            border-radius: 30px;
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            gap: 25px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(38, 129, 125, 0.05);
            box-shadow: 0 10px 30px rgba(38, 129, 125, 0.03);
        }
        .item-card:hover {
            transform: scale(1.02) translateX(15px);
            box-shadow: 0 20px 45px rgba(38, 129, 125, 0.1);
            border-color: var(--primary-teal);
        }

        .icon-circle {
            font-size: 26px;
            background: var(--bg-cyan);
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 22px;
            color: var(--primary-teal);
        }
        .item-card:hover .icon-circle {
            background: var(--primary-teal);
            color: white;
        }

        .item-content h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
        }
        .item-arrow {
            margin-left: auto;
            font-weight: 800;
            color: #cbd5e1;
            transition: 0.3s;
        }
        .item-card:hover .item-arrow { color: var(--primary-teal); transform: translateX(5px); }

        @media (max-width: 600px) {
            .header-section h1 { font-size: 30px; }
            .header-section .school-name { font-size: 24px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-section">
            <a href="/kategori" class="back-btn">
                <i class="fas fa-chevron-left"></i>
                <span>Kembali Utama</span>
            </a>
            <span class="label-top">Informasi Bidang</span>
            <h1>{{ $kategori->nama_kategori }}</h1>
            <span class="school-name">SMK N 1 TALAMAU</span>
        </header>

        <div class="list-grid">
            @forelse($jenis_prestasi as $jenis)
                <a href="/kategori/show/{{ $jenis->id }}" class="item-card">
                    <div class="icon-circle"><i class="fas fa-folder-open"></i></div>
                    <div class="item-content">
                        <h3>{{ $jenis->nama_kategori }}</h3>
                    </div>
                    <div class="item-arrow"><i class="fas fa-arrow-right"></i></div>
                </a>
            @empty
                <div style="text-align: center; padding: 60px; color: #94a3b8;">Belum ada data bidang.</div>
            @endforelse
        </div>
    </div>
</body>
</html>