<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Prestasi - SMK N 1 TALAMAU</title>
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
            padding: 80px 20px;
            color: var(--text-dark);
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .main-header {
            text-align: center;
            margin-bottom: 80px;
        }
        .main-header .title-label {
            display: block;
            font-size: 16px;
            font-weight: 800;
            color: var(--primary-teal);
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 15px;
        }
        .main-header h1 {
            font-size: 52px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -2px;
            line-height: 1;
        }
        .main-header .school-name {
            display: block;
            font-size: 42px;
            color: var(--primary-teal);
            font-weight: 800;
            margin-top: 5px;
        }
        .main-header .line-decor {
            width: 120px;
            height: 6px;
            background: var(--primary-teal);
            margin: 35px auto;
            border-radius: 50px;
        }
        .main-header p {
            color: #475569;
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 40px;
        }

        .card-link { text-decoration: none; color: inherit; }

        .category-card {
            background: white;
            padding: 80px 40px;
            border-radius: 45px;
            border: 1px solid rgba(38, 129, 125, 0.1);
            transition: all 0.4s;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 15px 40px rgba(38, 129, 125, 0.05);
        }
        .category-card:hover { transform: translateY(-15px); border-color: var(--primary-teal); }

        .icon-box {
            font-size: 85px;
            margin-bottom: 40px;
            background: var(--bg-cyan);
            width: 160px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 55px;
            color: var(--primary-teal);
        }

        .category-card h2 {
            font-size: 34px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .card-footer {
            font-weight: 700;
            color: var(--primary-teal);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-nav { text-align: center; margin-top: 100px; }
        .btn-create {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            background: var(--primary-teal);
            color: white;
            padding: 20px 50px;
            border-radius: 24px;
            text-decoration: none;
            font-weight: 800;
            font-size: 18px;
            transition: 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="main-header">
            <span class="title-label">Dokumentasi Capaian</span>
            <h1>ARSIP PRESTASI SISWA</h1>
            <span class="school-name">SMK N 1 TALAMAU</span>
            <div class="line-decor"></div>
            <p>Pusat informasi rekapitulasi prestasi dan bakat akademik maupun non-akademik siswa SMK Negeri 1 Talamau.</p>
        </header>

        <div class="card-grid">
            @foreach($kategoris as $kategori)
                <a href="/kategori/show/{{ $kategori->id }}" class="card-link">
                    <div class="category-card">
                        <div class="icon-box">{{ str_contains(strtolower($kategori->nama_kategori), 'non') ? '🏆' : '📘' }}</div>
                        <h2>{{ $kategori->nama_kategori }}</h2>
                        <div class="card-footer">Buka Arsip Bidang <i class="fas fa-arrow-right"></i></div>
                    </div>
                </a>
            @endforeach
        </div>

        @if(auth()->user()->role == 'admin')
            <div class="admin-nav" style="display: flex; justify-content: center; gap: 20px;">
                <a href="/dashboard" class="btn-create" style="background: white; color: var(--primary-teal); border: 2px solid var(--primary-teal);">
                    <i class="fas fa-house"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
                <a href="/kategori/create" class="btn-create">
                    <i class="fas fa-folder-plus"></i>
                    <span>Tambah Bidang Kategori</span>
                </a>
            </div>
        @else
            <div class="admin-nav">
                <a href="/dashboard" class="btn-create" style="background: white; color: var(--primary-teal); border: 2px solid var(--primary-teal);">
                    <i class="fas fa-house"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        @endif
    </div>
</body>
</html>