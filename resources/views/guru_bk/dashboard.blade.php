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

@if($errors->any())
    <div style="background: #fef2f2; color: #dc2626; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; border-left: 5px solid #ef4444; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
            <i class="fas fa-times-circle"></i> Terjadi kesalahan input:
        </div>
        <ul style="margin: 0; padding-left: 25px; font-size: 13px; font-weight: 500;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
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
    <!-- LEFT COLUMN -->
    <div>
        <!-- DAFTAR PENGAJUAN KONSULTASI DARI SISWA -->
        <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04); margin-bottom: 30px;">
            <h3 style="font-size: 18px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
                <span><i class="fas fa-comments" style="color: #0f766e;"></i> Pengajuan Konsultasi Masuk</span>
                <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-weight: 800;">{{ $pengajuanKonsultasi->count() }} Pengajuan</span>
            </h3>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                            <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Siswa / Kelas</th>
                            <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Tgl Pengajuan</th>
                            <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Kategori</th>
                            <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Keluhan/Alasan</th>
                            <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; text-align: center;">Status</th>
                            <th style="padding: 12px; font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 700; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuanKonsultasi as $pk)
                            <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.2s;">
                                <td style="padding: 15px 12px;">
                                    <div style="font-weight: 700; color: #1e293b; font-size: 14px;">{{ $pk->siswa->nama }}</div>
                                    <div style="font-size: 11px; color: #64748b;">Kelas: {{ $pk->siswa->kelasRel->nama_kelas ?? $pk->siswa->kelas }}</div>
                                </td>
                                <td style="padding: 15px 12px; font-size: 13px; color: #334155; font-weight: 500; white-space: nowrap;">
                                    {{ \Carbon\Carbon::parse($pk->tanggal_pengajuan)->translatedFormat('d M Y') }}
                                </td>
                                <td style="padding: 15px 12px;">
                                    <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #0f766e; background: #e6f4f1; padding: 4px 8px; border-radius: 6px;">
                                        {{ str_replace('_', ' ', $pk->tipe_konsultasi) }}
                                    </span>
                                </td>
                                <td style="padding: 15px 12px; font-size: 13px; color: #475569; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $pk->keluhan }}">
                                    {{ $pk->keluhan }}
                                </td>
                                <td style="padding: 15px 12px; text-align: center;">
                                    @if($pk->status === 'pending')
                                        <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #cbd5e1;">Pending</span>
                                    @elseif($pk->status === 'diproses')
                                        <span style="background: #fffbeb; color: #d97706; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fef3c7;">Diproses</span>
                                    @elseif($pk->status === 'disetujui')
                                        <span style="background: #ecfdf5; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #dcfce7;">Disetujui</span>
                                    @endif
                                </td>
                                <td style="padding: 15px 12px; text-align: center;">
                                    @if($pk->status === 'pending' || $pk->status === 'diproses')
                                        <button type="button" class="btn-action-small" 
                                                onclick="showAccModal({{ $pk->id }}, '{{ $pk->siswa->nama }}', '{{ $pk->siswa->kelasRel->nama_kelas ?? $pk->siswa->kelas }}')"
                                                style="background: #0f766e; border: none; text-decoration: none; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; color: white; cursor: pointer;" 
                                                title="Setujui & Jadwalkan">
                                            <i class="fas fa-calendar-check"></i> Setujui
                                        </button>
                                    @elseif($pk->status === 'disetujui')
                                        <a href="/guru-bk/pembinaan?siswa_id={{ $pk->siswa_id }}&konsultasi_id={{ $pk->id }}" class="btn-action-small" style="background: #10b981; text-decoration: none; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; color: white;" title="Bina & Selesaikan">
                                            <i class="fas fa-check-double"></i> Bina
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #94a3b8; font-size: 13px;">Belum ada pengajuan konsultasi masuk saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

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
    function showAccModal(id, namaSiswa, kelasSiswa) {
        document.getElementById('accModal').style.display = 'flex';
        document.getElementById('formAccKonsultasi').action = '/guru-bk/konsultasi/acc/' + id;
        document.getElementById('siswa_info_text').innerText = namaSiswa + ' (' + kelasSiswa + ')';
    }

    function closeAccModal() {
        document.getElementById('accModal').style.display = 'none';
    }
</script>
@endpush

<!-- Modal Persetujuan & Penjadwalan Konsultasi -->
<div id="accModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); z-index: 1000; justify-content: center; align-items: center; transition: all 0.3s ease;">
    <div style="background: white; padding: 35px; border-radius: 24px; max-width: 550px; width: 90%; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.8); position: relative; animation: modalFadeIn 0.3s ease-out;">
        <button onclick="closeAccModal()" style="position: absolute; top: 20px; right: 20px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 18px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">&times;</button>
        
        <h3 style="margin-bottom: 8px; font-size: 20px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-calendar-check" style="color: #0f766e;"></i> Setujui & Jadwalkan Konsultasi
        </h3>
        <p style="color: #64748b; font-size: 13.5px; margin-bottom: 25px;">Tentukan jadwal bimbingan resmi untuk siswa: <strong id="siswa_info_text" style="color: #0f172a;">-</strong></p>
        
        <form id="formAccKonsultasi" method="POST" action="">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">Tanggal Konsultasi</label>
                <input type="date" name="tanggal_konsultasi" id="tanggal_konsultasi" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required
                       style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid #e2e8f0; background: #f8fafc; font-family: inherit; font-size: 14px; outline: none; transition: border-color 0.2s, background-color 0.2s;"
                       onfocus="this.style.borderColor='#0f766e'; this.style.backgroundColor='white';"
                       onblur="this.style.borderColor='#e2e8f0'; this.style.backgroundColor='#f8fafc';">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">Waktu / Jam</label>
                <input type="text" name="jam_konsultasi" id="jam_konsultasi" placeholder="Contoh: 09:00 - 10:00 WIB" required
                       style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid #e2e8f0; background: #f8fafc; font-family: inherit; font-size: 14px; outline: none; transition: border-color 0.2s, background-color 0.2s;"
                       onfocus="this.style.borderColor='#0f766e'; this.style.backgroundColor='white';"
                       onblur="this.style.borderColor='#e2e8f0'; this.style.backgroundColor='#f8fafc';">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">Ruangan</label>
                <input type="text" name="ruangan_konsultasi" id="ruangan_konsultasi" placeholder="Contoh: Ruang Bimbingan Konseling Utama" required
                       style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid #e2e8f0; background: #f8fafc; font-family: inherit; font-size: 14px; outline: none; transition: border-color 0.2s, background-color 0.2s;"
                       onfocus="this.style.borderColor='#0f766e'; this.style.backgroundColor='white';"
                       onblur="this.style.borderColor='#e2e8f0'; this.style.backgroundColor='#f8fafc';">
            </div>

            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button type="button" onclick="closeAccModal()" 
                        style="background: #f1f5f9; color: #475569; border: none; padding: 12px 24px; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 14px; transition: background 0.2s;"
                        onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">Batal</button>
                <button type="submit" 
                        style="background: #0f766e; color: white; border: none; padding: 12px 24px; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s;"
                        onmouseover="this.style.background='#115e59'" onmouseout="this.style.background='#0f766e'">
                    <i class="fas fa-paper-plane"></i> Simpan & Jadwalkan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
