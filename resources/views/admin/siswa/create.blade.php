<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa</title>

    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #dbeafe, #93c5fd); /* biru soft */
            padding: 20px;
        }

        .card {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
        }

        label {
            font-weight: bold;
            color: #1e3a8a;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }

        input:focus {
            border-color: #3b82f6;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #3b82f6;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background: #2563eb;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>Tambah Data Siswa</h2>

    <form action="/siswa/store" method="POST">
        @csrf

        <label>NIS</label>
        <input type="text" name="nis">

        <label>Nama</label>
        <input type="text" name="nama">

        <label>Jenis Kelamin (L/P)</label>
        <select name="jenis_kelamin" style="width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #cbd5e1;">
            <option value="L">Laki-laki (L)</option>
            <option value="P">Perempuan (P)</option>
        </select>

        <label>Kelas</label>
        <input type="text" name="kelas">

        <label>Jurusan</label>
        <input type="text" name="jurusan">

        <button class="btn" type="submit">Simpan</button>
    </form>

    <a class="back" href="/siswa">← Kembali</a>
</div>

</body>
</html>