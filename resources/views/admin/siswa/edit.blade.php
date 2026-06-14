<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Siswa</title>

    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #bfdbfe, #60a5fa);
            padding: 20px;
        }

        .card {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #1e3a8a;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #2563eb;
            border: none;
            color: white;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #555;
        }

        .back:hover {
            color: black;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>Edit Data Siswa</h2>

    <form action="/siswa/update/{{ $siswa->id }}" method="POST">
        @csrf

        <label>NIS</label>
        <input type="text" name="nis" value="{{ $siswa->nis }}">

        <label>Nama</label>
        <input type="text" name="nama" value="{{ $siswa->nama }}">

        <label>Jenis Kelamin (L/P)</label>
        <select name="jenis_kelamin" style="width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #cbd5e1;">
            <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
            <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
        </select>

        <label>Kelas</label>
        <input type="text" name="kelas" value="{{ $siswa->kelas }}">

        <label>Jurusan</label>
        <input type="text" name="jurusan" value="{{ $siswa->jurusan }}">

        <button type="submit">Update</button>
    </form>

    <a class="back" href="/siswa">← Kembali</a>
</div>

</body>
</html>