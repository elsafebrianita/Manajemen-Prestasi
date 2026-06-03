<!DOCTYPE html>
<html>
<head>
    <title>Import Data Siswa</title>

    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #dbeafe, #93c5fd); /* biru soft */
            padding: 20px;
        }

        .card {
            background: white;
            max-width: 600px;
            margin: auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
        }

        .info-box {
            background: #e0f2fe;
            border-left: 4px solid #0ea5e9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            color: #0369a1;
            font-size: 14px;
            line-height: 1.5;
        }

        .info-box a {
            color: #0284c7;
            font-weight: bold;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            color: #1e3a8a;
            display: block;
            margin-bottom: 5px;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #10b981; /* hijau */
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn:hover {
            background: #059669;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #555;
            text-decoration: none;
        }
        
        .back:hover {
            color: #333;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>Import Data Siswa</h2>

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="info-box">
        <strong>PENTING:</strong><br>
        Agar data bisa masuk, mohon ikuti langkah ini:
        <ol style="margin-top: 10px; padding-left: 20px;">
            <li>Download <a href="/siswa/template">Template CSV di sini</a>.</li>
            <li>Buka file tersebut, lalu Copy-Paste data <strong>NIS, NAMA, JENIS KELAMIN (L/P), KELAS, JURUSAN</strong> ke dalam file template.</li>
            <li>Simpan (Save) file template tersebut (pastikan tetap dalam format CSV).</li>
            <li>Upload file yang sudah diisi ke bawah ini.</li>
        </ol>
    </div>

    <form action="/siswa/import" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Pilih File CSV Template Anda:</label>
        <input type="file" name="file" accept=".csv" required>

        <button class="btn" type="submit">Import Sekarang</button>
    </form>

    <a class="back" href="/siswa">← Kembali ke Data Siswa</a>
</div>

</body>
</html>
