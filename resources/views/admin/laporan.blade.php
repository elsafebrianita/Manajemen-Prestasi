<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Prestasi & Bakat Siswa - SMK N 1 TALAMAU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            padding: 50px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .report-paper {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            min-height: 1000px;
            position: relative;
        }

        /* Kop Surat Style */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 4px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .kop-logo {
            width: 100px;
            height: 100px;
            background: #eee; /* Placeholder for Logo */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #ccc;
            border-radius: 10px;
        }

        .kop-text {
            flex: 1;
            text-align: center;
        }

        .kop-text h2 { font-size: 18px; text-transform: uppercase; margin: 0; }
        .kop-text h1 { font-size: 22px; text-transform: uppercase; margin: 5px 0; font-weight: 800; }
        .kop-text p { font-size: 12px; margin: 0; color: #475569; }

        .report-title {
            text-align: center;
            margin-bottom: 40px;
        }
        .report-title h3 {
            font-size: 16px;
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 50px;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 12px 15px;
            font-size: 13px;
        }

        th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-weight: 700;
        }

        .text-center { text-align: center; }

        .ttd-area {
            display: flex;
            justify-content: flex-end;
            margin-top: 50px;
        }

        .ttd-box {
            text-align: center;
            width: 250px;
        }

        .ttd-box p { margin: 0; font-size: 14px; }
        .ttd-box .space { height: 80px; }
        .ttd-box .name { font-weight: 700; text-decoration: underline; }

        .no-print-area {
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-print {
            background: #0f766e;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-print:hover { background: #0d9488; transform: translateY(-2px); }

        @media print {
            body { background: white; padding: 0; }
            .report-paper { box-shadow: none; padding: 0; }
            .no-print-area { display: none; }
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="no-print-area">
            <div style="background: white; padding: 25px; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                <h4 style="margin-bottom: 15px; color: var(--primary-teal);"><i class="fas fa-filter"></i> Pengaturan Laporan</h4>
                <div style="display: flex; gap: 20px; align-items: flex-end;">
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 5px;">Semester</label>
                        <select id="select-semester" onchange="updateHeader()" style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd;">
                            <option value="Ganjil">Semester Ganjil</option>
                            <option value="Genap">Semester Genap</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 5px;">Tahun Ajaran</label>
                        <select id="select-tahun" onchange="updateHeader()" style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd;">
                            <option value="{{ date('Y') }}/{{ date('Y')+1 }}">{{ date('Y') }}/{{ date('Y')+1 }}</option>
                            <option value="{{ date('Y')-1 }}/{{ date('Y') }}">{{ date('Y')-1 }}/{{ date('Y') }}</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button onclick="window.print()" class="btn-print">
                            <i class="fas fa-print"></i> Cetak PDF
                        </button>
                        <button onclick="exportToExcel()" class="btn-print" style="background: #16a34a;">
                            <i class="fas fa-file-excel"></i> Ekspor Excel
                        </button>
                    </div>
                </div>
            </div>
            <a href="/dashboard" style="display: block; text-decoration: none; color: #64748b; font-weight: 600;">← Kembali ke Dashboard</a>
        </div>

        <div class="report-paper">
            <div class="kop-surat">
                <div class="kop-logo" style="background: transparent;">
                    <img src="/logo_asli_smk.png" alt="Logo SMK" style="width: 100%; height: auto;">
                </div>
                <div class="kop-text">
                    <h2>PEMERINTAH PROVINSI SUMATERA BARAT</h2>
                    <h2>DINAS PENDIDIKAN</h2>
                    <h1>SMK NEGERI 1 TALAMAU</h1>
                    <p>Alamat: Jl. Raya Talamau, Pasaman Barat, Sumatera Barat</p>
                    <p>Email: smkn1talamau@gmail.com | Website: www.smkn1talamau.sch.id</p>
                </div>
            </div>

            <div class="report-title">
                <h3>LAPORAN HASIL REKAPITULASI PRESTASI & BAKAT SISWA</h3>
                <p style="font-size: 14px; font-weight: 700;">
                    Semester <span id="display-semester">Ganjil</span> | Tahun Ajaran <span id="display-tahun">{{ date('Y') }}/{{ date('Y')+1 }}</span>
                </p>
            </div>

            <table id="table-laporan">
                <thead>
                    <tr>
                        <th style="width: 50px;">Rank</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Skor SAW</th>
                        <th>Hasil Bakat Utama</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $r)
                        <tr>
                            <td class="text-center">{{ $r['rank'] }}</td>
                            <td class="text-center">{{ $r['nis'] }}</td>
                            <td>{{ $r['nama'] }}</td>
                            <td class="text-center">{{ number_format($r['skor'], 4) }}</td>
                            <td class="text-center" style="font-weight: 600;">{{ $r['bakat'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #64748b; font-weight: 600;">
                                <i class="fas fa-exclamation-circle" style="font-size: 20px; color: #f59e0b; margin-bottom: 10px; display: block;"></i>
                                Belum ada data penilaian yang diproses. Silakan lakukan penilaian & perhitungan KPI terlebih dahulu di menu Penilaian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="ttd-area">
                <div class="ttd-box">
                    <p>Talamau, {{ date('d F Y') }}</p>
                    <p>Mengetahui,</p>
                    <p>Kepala Sekolah SMK N 1 Talamau</p>
                    <div class="space"></div>
                    <p class="name">Susi Erawati S.Pd</p>
                    <p>NIP. 197606212006042010</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        function updateHeader() {
            document.getElementById('display-semester').innerText = document.getElementById('select-semester').value;
            document.getElementById('display-tahun').innerText = document.getElementById('select-tahun').value;
        }

        function exportToExcel() {
            let table = document.getElementById("table-laporan");
            let html = table.outerHTML;
            let url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            let link = document.createElement("a");
            link.download = "Laporan_Prestasi_Bakat.xls";
            link.href = url;
            link.click();
        }
    </script>

</body>
</html>
