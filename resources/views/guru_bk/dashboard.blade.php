@extends('layouts.app')

@section('title', 'Dashboard Guru BK - SIMPRES')
@section('page_title', 'Dashboard Guru BK')

@section('content')
<div class="welcome-banner" style="background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); border-radius: 20px; padding: 35px 40px; color: white; margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(15, 118, 110, 0.15);">
    <div class="welcome-text" style="position: relative; z-index: 2;">
        <h2 style="font-family: 'Poppins', sans-serif; font-size: 28px; margin-bottom: 8px; font-weight: 700;">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p style="font-size: 15px; opacity: 0.9; max-width: 600px; line-height: 1.6;">Halaman ini menampilkan ringkasan data pemantauan dan pembinaan siswa. Gunakan menu di sebelah kiri untuk mengakses fitur monitoring, pembinaan, dan riwayat bimbingan konseling.</p>
    </div>
    <div style="position: absolute; right: 40px; bottom: -20px; font-size: 150px; color: rgba(255,255,255,0.05); transform: rotate(-10deg); font-weight: 900; pointer-events: none;">
        <i class="fa-solid fa-user-shield"></i>
    </div>
</div>

@if(session('success'))
    <div style="background: #ecfdf5; color: #059669; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; display: flex; align-items: center; gap: 12px; border-left: 5px solid #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<!-- STATS GRID -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; margin-bottom: 40px;">
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px; display: flex; align-items: flex-start; justify-content: space-between; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04); transition: transform 0.3s ease;">
        <div class="stat-info">
            <h3 style="font-size: 36px; font-weight: 800; color: #0f172a; font-family: 'Poppins', sans-serif; margin-bottom: 5px;">{{ $totalSiswa }}</h3>
            <p style="font-size: 13px; color: #64748b; font-weight: 500;">Jumlah Seluruh Siswa</p>
        </div>
        <div class="stat-icon" style="width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px; background: #e0f2fe; color: #0284c7;"><i class="fa-solid fa-user-graduate"></i></div>
    </div>
    
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px; display: flex; align-items: flex-start; justify-content: space-between; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04); transition: transform 0.3s ease;">
        <div class="stat-info">
            <h3 style="font-size: 36px; font-weight: 800; color: #10b981; font-family: 'Poppins', sans-serif; margin-bottom: 5px;">{{ $kpiTinggi }}</h3>
            <p style="font-size: 13px; color: #64748b; font-weight: 500;">Siswa Berprestasi Tinggi</p>
        </div>
        <div class="stat-icon" style="width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px; background: #ecfdf5; color: #10b981;"><i class="fa-solid fa-crown"></i></div>
    </div>

    <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px; display: flex; align-items: flex-start; justify-content: space-between; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04); transition: transform 0.3s ease;">
        <div class="stat-info">
            <h3 style="font-size: 36px; font-weight: 800; color: #ef4444; font-family: 'Poppins', sans-serif; margin-bottom: 5px;">{{ $kpiRendah }}</h3>
            <p style="font-size: 13px; color: #64748b; font-weight: 500;">Siswa KPI Rendah</p>
        </div>
        <div class="stat-icon" style="width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px; background: #fef2f2; color: #ef4444;"><i class="fa-solid fa-triangle-exclamation"></i></div>
    </div>

    <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px; display: flex; align-items: flex-start; justify-content: space-between; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.04); transition: transform 0.3s ease;">
        <div class="stat-info">
            <h3 style="font-size: 36px; font-weight: 800; color: #f59e0b; font-family: 'Poppins', sans-serif; margin-bottom: 5px;">{{ $butuhPembinaanCount }}</h3>
            <p style="font-size: 13px; color: #64748b; font-weight: 500;">Siswa Perlu Pembinaan</p>
        </div>
        <div class="stat-icon" style="width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px; background: #fffbeb; color: #f59e0b;"><i class="fa-solid fa-user-shield"></i></div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 30px; margin-bottom: 40px;">
    <!-- DAFTAR SISWA MEMBUTUHKAN PEMBINAAN -->
    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
        <h3 style="font-size: 18px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
            <i class="fas fa-clipboard-list" style="color: #ef4444;"></i> Daftar Siswa yang Memerlukan Pembinaan
        </h3>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                        <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Nama Siswa</th>
                        <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; text-align: center;">Skor KPI</th>
                        <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; text-align: center;">Status BK</th>
                        <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarButuhPembinaan as $siswa)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.2s;">
                            <td style="padding: 15px 12px;">
                                <div style="font-weight: 700; color: #1e293b; font-size: 14px;">{{ $siswa->nama }}</div>
                                <div style="font-size: 11px; color: #64748b;">Kelas: {{ $siswa->kelas }} | Wali: {{ $siswa->walikelas->name ?? 'Belum Diisi' }}</div>
                            </td>
                            <td style="padding: 15px 12px; text-align: center;">
                                <span style="font-weight: 800; color: #ef4444; font-size: 15px;">{{ number_format($siswa->kpi_score, 1) }}</span>
                            </td>
                            <td style="padding: 15px 12px; text-align: center;">
                                @if($siswa->status_bimbingan === 'proses')
                                    <span style="background: #fffbeb; color: #d97706; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fef3c7;">Sedang Dibina</span>
                                @elseif($siswa->status_bimbingan === 'selesai')
                                    <span style="background: #f0fdf4; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #dcfce7;">Selesai Dibina</span>
                                @else
                                    <span style="background: #fef2f2; color: #dc2626; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fee2e2;">Perlu Pembinaan</span>
                                @endif
                            </td>
                            <td style="padding: 15px 12px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="/guru-bk/detail/{{ $siswa->id }}" class="btn-detail" style="color: #0f766e; background: #e6f4f1; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px;" title="Detail Perkembangan"><i class="fas fa-eye"></i></a>
                                    <a href="/guru-bk/pembinaan?siswa_id={{ $siswa->id }}" style="color: #ef4444; background: #fef2f2; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px;" title="Beri Catatan Pembinaan"><i class="fas fa-user-shield"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8; font-size: 14px;">Semua siswa memiliki KPI yang aman. Mantap!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SEBARAN KPI CHART / GRAFIK PERKEMBANGAN -->
    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
        <h3 style="font-size: 18px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
            <i class="fas fa-chart-pie" style="color: #0f766e;"></i> Distribusi Kondisi KPI Siswa
        </h3>
        <div style="position: relative; height: 230px; display: flex; align-items: center; justify-content: center;">
            <canvas id="kpiOverviewChart" style="max-height: 100%;"></canvas>
        </div>
        <div style="margin-top: 25px; display: flex; justify-content: space-around; font-size: 12px; font-weight: 600;">
            <span style="display: flex; align-items: center; gap: 6px;"><i class="fas fa-circle" style="color: #10b981;"></i> Tinggi (&gt;=80)</span>
            <span style="display: flex; align-items: center; gap: 6px;"><i class="fas fa-circle" style="color: #3b82f6;"></i> Sedang (70-79)</span>
            <span style="display: flex; align-items: center; gap: 6px;"><i class="fas fa-circle" style="color: #ef4444;"></i> Rendah (&lt;70)</span>
        </div>
    </div>
</div>

<!-- RIWAYAT KONSELING TERBARU -->
<div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04); margin-bottom: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="font-size: 18px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
            <i class="fas fa-history" style="color: #0f766e;"></i> Riwayat Bimbingan Terkini
        </h3>
        <a href="/guru-bk/riwayat" style="color: #0f766e; text-decoration: none; font-size: 13px; font-weight: 700;">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>

    <div style="display: flex; flex-direction: column; gap: 15px;">
        @forelse($riwayatTerbaru as $rw)
            <div style="display: flex; align-items: center; gap: 20px; padding: 15px 20px; background: #f8fafc; border-radius: 16px; border-left: 5px solid {{ $rw->jenis_pembinaan === 'disiplin' ? '#ef4444' : ($rw->jenis_pembinaan === 'akademik' ? '#3b82f6' : '#10b981') }};">
                <div style="width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    @if($rw->jenis_pembinaan === 'disiplin')
                        ⚠️
                    @elseif($rw->jenis_pembinaan === 'akademik')
                        📚
                    @else
                        ⚽
                    @endif
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $rw->siswa->nama }}</span>
                        <small style="color: #94a3b8; font-size: 11px; font-weight: 500;">{{ date('d M Y', strtotime($rw->tanggal)) }}</small>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; margin: 4px 0;">
                        <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: {{ $rw->jenis_pembinaan === 'disiplin' ? '#ef4444' : ($rw->jenis_pembinaan === 'akademik' ? '#3b82f6' : '#10b981') }};">Pembinaan {{ ucfirst($rw->jenis_pembinaan) }}</span>
                        <span style="color: #cbd5e1;">•</span>
                        <small style="color: #64748b; font-weight: 500;">Oleh: {{ $rw->guru->name }}</small>
                    </div>
                    <p style="font-size: 13px; color: #1e293b; line-height: 1.5; margin-top: 6px;">{{ $rw->catatan }}</p>
                </div>
                <div>
                    @if($rw->status === 'selesai')
                        <span style="background: #f0fdf4; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; border: 1px solid #dcfce7;">Selesai</span>
                    @else
                        <span style="background: #fffbeb; color: #d97706; padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; border: 1px solid #fef3c7;">Proses</span>
                    @endif
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 30px; color: #94a3b8; font-size: 14px;">Belum ada riwayat konseling.</div>
        @endforelse
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('kpiOverviewChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Tinggi', 'Sedang', 'Rendah'],
                datasets: [{
                    data: [{{ $kpiTinggi }}, {{ max(0, $totalSiswa - $kpiTinggi - $kpiRendah) }}, {{ $kpiRendah }}],
                    backgroundColor: ['#10b981', '#3b82f6', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush
@endsection
