@extends('layouts.app')
@section('page_title', 'Usulan Publikasi')

@section('content')
<div style="padding: 40px; background: var(--bg-color); min-height: 100vh;">
    <!-- Notifications/Messages -->
    @if(session('success'))
        <div style="background:#d1fae5; border-left:4px solid #10b981; padding:15px 20px; border-radius:10px; margin-bottom:20px; color:#065f46; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div>
                <h2 style="color: var(--secondary); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 22px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-thumbs-up" style="color: var(--primary);"></i> Rekomendasi Publikasi Siswa
                </h2>
                <p style="color: var(--text-muted); margin-top: 5px; font-size: 14px;">Daftar siswa berprestasi tinggi yang direkomendasikan oleh Wali Kelas untuk dipublikasikan.</p>
            </div>
            <span style="background: #e6f7f6; color: var(--primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 20px;">
                {{ $usulans->count() }} Direkomendasikan
            </span>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-color); text-align: left;">
                        <th style="padding: 15px; border-radius: 10px 0 0 10px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Siswa</th>
                        <th style="padding: 15px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">KPI Score</th>
                        <th style="padding: 15px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Bakat Dominan</th>
                        <th style="padding: 15px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Rekomendasi Dari</th>
                        <th style="padding: 15px; border-radius: 0 10px 10px 0; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usulans as $u)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.2s;">
                            <td style="padding: 15px;">
                                <div style="font-weight: bold; color: var(--secondary); font-size: 15px;">{{ $u->siswa->nama ?? 'N/A' }}</div>
                                <small style="color: var(--text-muted);">NIS: {{ $u->siswa->nis ?? '-' }}</small>
                            </td>
                            <td style="padding: 15px;">
                                <span style="font-size: 18px; font-weight: 800; color: {{ $u->kpi_score >= 85 ? '#10b981' : ($u->kpi_score >= 70 ? '#f59e0b' : '#ef4444') }}">{{ number_format($u->kpi_score, 1) }}</span>
                            </td>
                            <td style="padding: 15px;">
                                <span style="background: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: bold;">
                                    {{ $u->bakat_dominan }}
                                </span>
                            </td>
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; color: var(--secondary); font-size: 13px;">{{ $u->siswa->walikelas->name ?? 'Wali Kelas' }}</div>
                                <small style="color: var(--text-muted);">Wali Kelas {{ $u->siswa->kelas ?? '' }}</small>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <form action="/humas/usulan/propose/{{ $u->id }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin mengusulkan {{ $u->siswa->nama }} untuk publikasi ke Kepala Sekolah?')">
                                    @csrf
                                    <button type="submit" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: bold; cursor: pointer; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(15,118,110,0.2); transition: all 0.2s;">
                                        <i class="fa-solid fa-paper-plane"></i> Usulkan Ke Kepsek
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fa-solid fa-circle-info" style="font-size: 36px; margin-bottom: 12px; color: var(--primary);"></i>
                                <div style="font-weight: 600;">Belum Ada Rekomendasi Baru</div>
                                <div style="font-size: 13px; margin-top: 4px;">Belum ada siswa yang direkomendasikan Wali Kelas untuk diusulkan.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
