@extends('layouts.app')
@section('page_title', 'Dashboard Humas')

@section('content')
<div style="padding: 40px; background: var(--bg-color); min-height: 100vh;">
    <!-- Welcome Header -->
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div>
            <h2 style="color: var(--secondary); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 24px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-bullhorn" style="color: var(--primary);"></i> Selamat Datang, {{ auth()->user()->name }}!
            </h2>
            <p style="color: var(--text-muted); margin-top: 5px;">Halaman dashboard khusus Hubungan Masyarakat (Humas) untuk mengelola publikasi prestasi siswa.</p>
        </div>
        <div style="background: #e6f7f6; color: var(--primary); padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-calendar"></i> {{ date('d F Y') }}
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 40px;">
        <!-- Card 1: Direkomendasikan Walikelas -->
        <div style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); padding: 25px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="color: #0369a1; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Rekomendasi Walikelas</span>
                <h3 style="color: #0c4a6e; font-size: 32px; font-weight: 800; margin-top: 8px; font-family: 'Poppins', sans-serif;">{{ $totalRecommended }}</h3>
            </div>
            <div style="background: rgba(255,255,255,0.5); color: #0284c7; width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa-solid fa-thumbs-up"></i>
            </div>
        </div>

        <!-- Card 2: Diajukan ke Kepsek -->
        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 25px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="color: #b45309; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Diajukan ke Kepsek</span>
                <h3 style="color: #78350f; font-size: 32px; font-weight: 800; margin-top: 8px; font-family: 'Poppins', sans-serif;">{{ $totalProposed }}</h3>
            </div>
            <div style="background: rgba(255,255,255,0.5); color: #d97706; width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
        </div>

        <!-- Card 3: Disetujui Layak -->
        <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 25px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="color: #047857; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Disetujui Kepsek</span>
                <h3 style="color: #064e3b; font-size: 32px; font-weight: 800; margin-top: 8px; font-family: 'Poppins', sans-serif;">{{ $totalApproved }}</h3>
            </div>
            <div style="background: rgba(255,255,255,0.5); color: #059669; width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>

        <!-- Card 4: Telah Terbit -->
        <div style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); padding: 25px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <span style="color: #6b21a8; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Telah Diposting</span>
                <h3 style="color: #581c87; font-size: 32px; font-weight: 800; margin-top: 8px; font-family: 'Poppins', sans-serif;">{{ $totalPublished }}</h3>
            </div>
            <div style="background: rgba(255,255,255,0.5); color: #7c3aed; width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fa-solid fa-globe"></i>
            </div>
        </div>
    </div>

    <!-- Main Lists -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; flex-wrap: wrap;">
        <!-- Left: Need Review -->
        <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
                <h3 style="color: var(--secondary); font-family: 'Poppins', sans-serif; font-size: 18px;"><i class="fa-solid fa-bell" style="color: #ef4444; margin-right: 8px;"></i> Perlu Review Humas</h3>
                <a href="/humas/usulan" style="color: var(--primary); text-decoration: none; font-weight: 700; font-size: 13px;">Lihat Semua <i class="fa-solid fa-angle-right"></i></a>
            </div>
            @forelse($recentRecommended as $r)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #f8fafc;">
                    <div>
                        <strong style="color: var(--secondary); font-size: 14px;">{{ $r->siswa->nama ?? 'Siswa' }}</strong>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">KPI Score: <strong style="color: var(--primary);">{{ number_format($r->kpi_score, 1) }}</strong> | Bakat: {{ $r->bakat_dominan }}</div>
                    </div>
                    <form action="/humas/usulan/propose/{{ $r->id }}" method="POST">
                        @csrf
                        <button type="submit" style="background: var(--primary); color: white; border: none; padding: 8px 16px; border-radius: 10px; font-size: 12px; font-weight: bold; cursor: pointer; transition: var(--transition);">Usulkan</button>
                    </form>
                </div>
            @empty
                <div style="padding: 30px; text-align: center; color: var(--text-muted); font-size: 14px;">
                    <i class="fa-solid fa-check-circle" style="font-size: 32px; color: var(--success); margin-bottom: 10px; display: block;"></i>
                    Tidak ada usulan baru dari Wali Kelas saat ini.
                </div>
            @endforelse
        </div>

        <!-- Right: Recent Decisions -->
        <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
                <h3 style="color: var(--secondary); font-family: 'Poppins', sans-serif; font-size: 18px;"><i class="fa-solid fa-clock-rotate-left" style="color: var(--primary); margin-right: 8px;"></i> Keputusan Terbaru Kepsek</h3>
                <a href="/humas/riwayat" style="color: var(--primary); text-decoration: none; font-weight: 700; font-size: 13px;">Lihat Riwayat <i class="fa-solid fa-angle-right"></i></a>
            </div>
            @forelse($recentDecisions as $rd)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #f8fafc;">
                    <div>
                        <strong style="color: var(--secondary); font-size: 14px;">{{ $rd->siswa->nama ?? 'Siswa' }}</strong>
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Direview: {{ $rd->kepsek_reviewed_at ? \Carbon\Carbon::parse($rd->kepsek_reviewed_at)->diffForHumans() : '-' }}</div>
                    </div>
                    <div>
                        @if($rd->kepsek_status === 'layak')
                            <span style="background: #ecfdf5; color: #10b981; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: bold;"><i class="fa-solid fa-check"></i> Layak</span>
                        @else
                            <span style="background: #fef2f2; color: #ef4444; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: bold;"><i class="fa-solid fa-times"></i> Ditolak</span>
                        @endif
                    </div>
                </div>
            @empty
                <div style="padding: 30px; text-align: center; color: var(--text-muted); font-size: 14px;">
                    Belum ada riwayat keputusan terbaru dari Kepala Sekolah.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
