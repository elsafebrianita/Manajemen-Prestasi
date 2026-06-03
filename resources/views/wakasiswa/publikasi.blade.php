@extends('layouts.app')
@section('page_title', 'Publikasi Prestasi')

@section('content')
<div style="padding: 40px;">
    <!-- Welcome Header Card -->
    <div style="background: linear-gradient(135deg, var(--secondary) 0%, #1e293b 100%); border-radius: 20px; padding: 30px; color: white; margin-bottom: 30px; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
        <div style="position: relative; z-index: 2;">
            <h2 style="font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-stamp" style="color: var(--primary-light);"></i> Usulkan Publikasi Prestasi Siswa
            </h2>
            <p style="color: #94a3b8; font-size: 14px; max-width: 700px; line-height: 1.6;">
                Monitor hasil perhitungan KPI siswa dan usulkan siswa berprestasi agar disetujui Kepala Sekolah untuk dipublikasikan ke landing page sekolah.
            </p>
        </div>
        <div style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%); font-size: 80px; color: rgba(255,255,255,0.03); font-weight: 900;">
            <i class="fa-solid fa-bullhorn"></i>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 18px 24px; border-radius: 15px; margin-bottom: 30px; font-weight: 700; display: flex; align-items: center; gap: 12px; border-left: 5px solid #10b981;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Tabs Navigation -->
    @php
        $isAll = request()->has('filter') && request()->filter === 'all';
    @endphp
    <div style="display: flex; gap: 15px; margin-bottom: 25px; border-bottom: 1px solid #cbd5e1; padding-bottom: 10px;">
        <a href="/wakasiswa/publikasi" style="text-decoration: none; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; transition: all 0.3s; display: flex; align-items: center; gap: 8px; {{ !$isAll ? 'background: var(--primary); color: white;' : 'background: transparent; color: var(--text-muted);' }}">
            <i class="fas fa-star"></i> Rekomendasi Wali Kelas
        </a>
        <a href="/wakasiswa/publikasi?filter=all" style="text-decoration: none; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; transition: all 0.3s; display: flex; align-items: center; gap: 8px; {{ $isAll ? 'background: var(--primary); color: white;' : 'background: transparent; color: var(--text-muted);' }}">
            <i class="fas fa-users"></i> Semua Evaluasi KPI Siswa
        </a>
    </div>

    <!-- Main List Card -->
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; color: var(--secondary); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-list-check" style="color: var(--primary);"></i> 
            Daftar Siswa {{ !$isAll ? 'Rekomendasi Walikelas' : 'Keseluruhan' }}
        </h3>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-color); text-align: left;">
                        <th style="padding: 15px; border-radius: 10px 0 0 10px; width: 80px; text-align: center;">KPI Rank</th>
                        <th style="padding: 15px;">Siswa</th>
                        <th style="padding: 15px; text-align: center;">Akademik</th>
                        <th style="padding: 15px; text-align: center;">Organisasi</th>
                        <th style="padding: 15px; text-align: center;">Non Akademik</th>
                        <th style="padding: 15px; text-align: center;">Rapor</th>
                        <th style="padding: 15px; text-align: center;">Skor Akhir (KPI)</th>
                        <th style="padding: 15px;">Bakat Dominan</th>
                        <th style="padding: 15px; text-align: center; border-radius: 0 10px 10px 0; width: 220px;">Aksi Usulan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penilaians as $p)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.3s; @if($p->is_proposed) background: #f8fafc; @endif">
                            <td style="padding: 15px; text-align: center;">
                                <div style="font-weight: 800; color: {{ $p->ranking <= 3 ? '#f59e0b' : '#64748b' }}; font-size: 16px;">
                                    #{{ $p->ranking ?? '-' }}
                                </div>
                            </td>
                            <td style="padding: 15px;">
                                <strong style="color: var(--secondary); font-size: 14px;">{{ $p->siswa->nama ?? 'N/A' }}</strong><br>
                                <small style="color: var(--text-muted); font-size: 11px;">NIS: {{ $p->siswa->nis ?? '-' }} | Kelas: {{ $p->siswa->kelas ?? '-' }}</small>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="font-weight: 600; color: {{ $p->c2 > 0 ? 'var(--primary)' : 'var(--text-muted)' }}">{{ number_format($p->c2, 1) }}</span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="font-weight: 600; color: {{ $p->c3 > 0 ? 'var(--primary)' : 'var(--text-muted)' }}">{{ number_format($p->c3, 1) }}</span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="font-weight: 600; color: {{ $p->c4 > 0 ? 'var(--primary)' : 'var(--text-muted)' }}">{{ number_format($p->c4, 1) }}</span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="font-weight: 600; color: {{ $p->c1 > 0 ? 'var(--primary)' : 'var(--text-muted)' }}">{{ number_format($p->c1, 1) }}</span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="font-weight: 800; color: var(--primary); font-size: 15px;">{{ number_format($p->kpi_score, 1) }}</span>
                            </td>
                            <td style="padding: 15px;">
                                <span style="font-weight: 700; color: #475569; font-size: 11px; background: #e2e8f0; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                                    {{ $p->bakat_dominan ?? 'Belum Kalkulasi' }}
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                @if(!$p->is_proposed)
                                    <form action="/wakasiswa/publikasi/propose/{{ $p->id }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn" style="background: var(--primary); color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: bold; width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 4px 10px rgba(15,118,110,0.15);">
                                            <i class="fa-solid fa-paper-plane"></i> Usulkan Publikasi
                                        </button>
                                    </form>
                                @else
                                    <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
                                        @if($p->kepsek_status === 'layak')
                                            <span style="background: #d1fae5; color: #065f46; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px; width: 100%; justify-content: center;">
                                                <i class="fa-solid fa-circle-check"></i> Disetujui Kepsek
                                            </span>
                                            @if($p->status_publikasi === 'published')
                                                <span style="font-size: 10px; color: #8b5cf6; font-weight: bold; margin-top: 3px;"><i class="fa-solid fa-bullhorn"></i> Sudah Diposting</span>
                                            @else
                                                <span style="font-size: 10px; color: #64748b; font-weight: bold; margin-top: 3px;"><i class="fa-solid fa-clock"></i> Antrean Posting Admin</span>
                                            @endif
                                        @elseif($p->kepsek_status === 'tidak_layak')
                                            <span style="background: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px; width: 100%; justify-content: center;">
                                                <i class="fa-solid fa-circle-xmark"></i> Ditolak Kepsek
                                            </span>
                                            <form action="/wakasiswa/publikasi/propose/{{ $p->id }}" method="POST" style="display: inline; margin-top: 5px; width: 100%;">
                                                @csrf
                                                <button type="submit" class="btn" style="background: white; border: 1px solid #cbd5e1; color: var(--text-main); padding: 4px 8px; border-radius: 6px; cursor: pointer; font-size: 10px; font-weight: bold; width: 100%;">
                                                    Usulkan Ulang
                                                </button>
                                            </form>
                                        @else
                                            <span style="background: #fffbeb; color: #92400e; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px; width: 100%; justify-content: center;">
                                                <i class="fa-solid fa-hourglass-half"></i> Menunggu Kepsek
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 10px; display: block;"></i> 
                                @if(!$isAll)
                                    Belum ada rekomendasi dari Wali Kelas.
                                @else
                                    Belum ada data evaluasi KPI yang diproses.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
