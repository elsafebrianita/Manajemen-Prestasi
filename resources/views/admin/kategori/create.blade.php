<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori Prestasi</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #7dd3fc, #5f9ea0);
            text-align: center;
        }
        .container {
            margin-top: 80px;
        }
        .form-box {
            display: inline-block;
            width: 400px;
            padding: 30px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-box">
        <h1>Tambah Kategori Prestasi</h1>
        <form action="/kategori/store" method="POST">
            @csrf
            <input type="text" name="nama_kategori" placeholder="Nama Kategori" required>
            <button type="submit">Simpan</button>
        </form>
        <a href="/kategori" class="back-link">Kembali ke Daftar Kategori</a>
    </div>
</div>
</body>
</html>