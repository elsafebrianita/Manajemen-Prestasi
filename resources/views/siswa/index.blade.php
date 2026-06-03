<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - SMK N 1 TALAMAU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

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
            padding: 40px 20px;
        }

        .container { max-width: 1000px; margin: 0 auto; }

        .header-section { text-align: center; margin-bottom: 40px; }
        .header-section h1 { font-size: 32px; font-weight: 800; color: var(--text-dark); }
        .school-name { color: var(--primary-teal); font-weight: 800; }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-tambah { background: var(--primary-teal); color: white; box-shadow: 0 10px 20px rgba(38, 129, 125, 0.2); }
        .btn-dashboard { background: white; color: var(--primary-teal); border: 2px solid var(--primary-teal); }

        .btn:hover { transform: translateY(-3px); opacity: 0.9; }

        .table-card {
            background: white;
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 20px 50px rgba(38, 129, 125, 0.05);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left; padding: 20px;
            background: #f8fafc; color: #64748b;
            font-size: 12px; font-weight: 800; text-transform: uppercase;
            letter-spacing: 1px;
        }
        td { padding: 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: var(--text-dark); }

        .badge-kelas {
            background: var(--bg-cyan); color: var(--primary-teal);
            padding: 4px 12px; border-radius: 8px; font-weight: 700; font-size: 12px;
        }

        .btn-action {
            width: 35px; height: 35px; border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            text-decoration: none; transition: 0.3s;
        }
        .btn-edit { background: #eff6ff; color: #3b82f6; }
        .btn-hapus { background: #fef2f2; color: #ef4444; }
        .btn-action:hover { transform: scale(1.1); }

    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h1>Data Siswa</h1>
            <p class="school-name">SMK N 1 TALAMAU</p>
        </div>

        <div class="action-bar">
            <a href="/dashboard" class="btn btn-dashboard">
                <i class="fas fa-house"></i> Kembali
            </a>
            <div style="display: flex; gap: 10px;">
                <a href="/siswa/import" class="btn btn-tambah" style="background: #10b981; color: white;">
                    <i class="fas fa-file-csv"></i> Import Data
                </a>
                <a href="/siswa/create" class="btn btn-tambah">
                    <i class="fas fa-user-plus"></i> Tambah Baru
                </a>
            </div>
        </div>

        @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
        @endif

        <div class="table-card" style="padding: 20px;">
            <table id="tabelSiswa" class="display" style="width:100%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>L/P</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $no => $s)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td style="font-weight: 700;">{{ $s->nis }}</td>
                        <td><strong>{{ $s->nama }}</strong></td>
                        <td>{{ $s->jenis_kelamin }}</td>
                        <td><span class="badge-kelas">{{ $s->kelas }}</span></td>
                        <td>{{ $s->jurusan }}</td>
                        <td style="text-align: right;">
                            <a href="/siswa/edit/{{ $s->id }}" class="btn-action btn-edit" title="Edit Data"><i class="fas fa-edit"></i></a>
                            <a href="/siswa/delete/{{ $s->id }}" class="btn-action btn-hapus" title="Hapus Data" onclick="return confirm('Yakin hapus data siswa ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelSiswa').DataTable({
                "language": {
                    "search": "Pencarian (Nama/Kelas/Jurusan):",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
                    "infoEmpty": "Tidak ada data siswa",
                    "zeroRecords": "Data tidak ditemukan",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>
</body>
</html>