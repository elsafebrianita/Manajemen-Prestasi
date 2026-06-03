@extends('layouts.app')
@section('page_title', 'Laporan Publikasi Prestasi')

@section('content')
<div style="padding: 40px; background: var(--bg-color); min-height: 100vh;">
    <!-- Print Button Header -->
    <div style="background: white; padding: 25px 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;" class="no-print">
        <div>
            <h2 style="color: var(--secondary); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 22px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-file-pdf" style="color: var(--primary);"></i> Laporan Publikasi Prestasi Siswa
            </h2>
            <p style="color: var(--text-muted); margin-top: 5px; font-size: 14px;">Rekapitulasi statistik publikasi siswa berprestasi berdasarkan kelas dan perolehan KPI.</p>
        </div>
        <button onclick="window.print()" style="background: var(--primary); color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: bold; cursor: pointer; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(15,118,110,0.25);">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>
    </div>

    <!-- Printable Area Wrapper -->
    <div id="printable-area" style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <!-- Report Header (Visible in print) -->
        <div style="text-align: center; margin-bottom: 40px; border-bottom: 3px double #e2e8f0; padding-bottom: 20px;">
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 800; color: var(--secondary); margin: 0;">LAPORAN REKAPITULASI PUBLIKASI PRESTASI SISWA</h1>
            <h3 style="font-size: 16px; color: var(--primary); margin: 6px 0 0; text-transform: uppercase; letter-spacing: 1px;">SMK Negeri 1 Talamau</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin: 8px 0 0;">Laporan dicetak pada: {{ date('d F Y, H:i') }} | Petugas Humas: {{ auth()->user()->name }}</p>
        </div>

        <!-- Section 1: Stats by Class -->
        <div style="margin-bottom: 40px;">
            <h3 style="color: var(--secondary); font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 15px; border-left: 4px solid var(--primary); padding-left: 10px;">
                I. Rekapitulasi Prestasi & Publikasi Per Kelas
            </h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700;">Nama Kelas</th>
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700; text-align: center;">Total Prestasi Valid</th>
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700; text-align: center;">Diusulkan Publikasi (Humas)</th>
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700; text-align: center;">Disetujui Publikasi (Kepsek)</th>
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700; text-align: center;">Sudah Terbit Berita (Admin)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelasStats as $ks)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 12px 15px; font-weight: bold; color: var(--secondary); font-size: 14px;">{{ $ks['nama_kelas'] }}</td>
                            <td style="padding: 12px 15px; text-align: center; font-weight: 600; color: var(--secondary);">{{ $ks['total_prestasi'] }}</td>
                            <td style="padding: 12px 15px; text-align: center; font-weight: 600; color: #b45309;">{{ $ks['total_proposed'] }}</td>
                            <td style="padding: 12px 15px; text-align: center; font-weight: 600; color: #047857;">{{ $ks['total_layak'] }}</td>
                            <td style="padding: 12px 15px; text-align: center; font-weight: 600; color: #6b21a8;">{{ $ks['total_published'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Tidak ada data statistik kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Section 2: Top Students Leaderboard -->
        <div>
            <h3 style="color: var(--secondary); font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 15px; border-left: 4px solid var(--primary); padding-left: 10px;">
                II. Siswa Dengan Pencapaian KPI Tertinggi Sekolah
            </h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700; width: 80px; text-align: center;">Ranking</th>
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700; text-align: center;">KPI Score</th>
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700;">Bakat Dominan</th>
                        <th style="padding: 12px 15px; font-size: 13px; color: var(--text-muted); font-weight: 700;">Status Terbit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topStudents as $index => $ts)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 12px 15px; text-align: center; font-weight: bold; color: var(--primary); font-size: 15px;">#{{ $index + 1 }}</td>
                            <td style="padding: 12px 15px;">
                                <div style="font-weight: bold; color: var(--secondary);">{{ $ts->siswa->nama ?? '-' }}</div>
                                <small style="color: var(--text-muted);">NIS: {{ $ts->siswa->nis ?? '-' }} | Kelas: {{ $ts->siswa->kelas ?? '-' }}</small>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; font-size: 16px; font-weight: 800; color: var(--secondary);">{{ number_format($ts->kpi_score, 1) }}</td>
                            <td style="padding: 12px 15px; font-size: 13px; color: var(--text-muted);">{{ $ts->bakat_dominan }}</td>
                            <td style="padding: 12px 15px;">
                                @if($ts->is_published)
                                    <span style="color: #10b981; font-weight: bold; font-size: 13px;">Sudah Terbit</span>
                                @elseif($ts->is_proposed)
                                    <span style="color: #f59e0b; font-weight: bold; font-size: 13px;">Menunggu Kepsek</span>
                                @else
                                    <span style="color: #64748b; font-weight: bold; font-size: 13px;">Belum Diusulkan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Tidak ada data siswa berprestasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Signature section (Visible in print) -->
        <div style="margin-top: 60px; display: flex; justify-content: flex-end;" class="print-only">
            <div style="text-align: center; width: 250px;">
                <p style="margin: 0; font-size: 14px;">Mendukung & Mengetahui,</p>
                <p style="margin: 5px 0 60px 0; font-weight: bold; font-size: 14px;">Petugas Humas</p>
                <p style="margin: 0; font-weight: bold; text-decoration: underline; font-size: 14px;">{{ auth()->user()->name }}</p>
                <p style="margin: 3px 0 0 0; font-size: 12px; color: var(--text-muted);">NIP. {{ auth()->user()->nip ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body {
            background: white !important;
            color: black !important;
        }
        .sidebar, .topbar, .no-print {
            display: none !important;
        }
        .main-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        #printable-area {
            box-shadow: none !important;
            padding: 0 !important;
            border-radius: 0 !important;
        }
        .print-only {
            display: block !important;
        }
    }
    
    .print-only {
        display: none;
    }
</style>
@endsection
