@extends('layouts.app')
@section('page_title', 'Riwayat Usulan Publikasi')

@section('content')
<div style="padding: 40px; background: var(--bg-color); min-height: 100vh;">
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div>
                <h2 style="color: var(--secondary); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 22px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-history" style="color: var(--primary);"></i> Riwayat Usulan Publikasi
                </h2>
                <p style="color: var(--text-muted); margin-top: 5px; font-size: 14px;">Daftar seluruh pengajuan usulan publikasi yang telah Anda sampaikan ke Kepala Sekolah beserta status perkembangannya.</p>
            </div>
            <span style="background: #e6f7f6; color: var(--primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 20px;">
                {{ $riwayats->count() }} Total Usulan
            </span>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-color); text-align: left;">
                        <th style="padding: 15px; border-radius: 10px 0 0 10px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Siswa</th>
                        <th style="padding: 15px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">KPI Score</th>
                        <th style="padding: 15px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Status Kepsek</th>
                        <th style="padding: 15px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Catatan Kepsek</th>
                        <th style="padding: 15px; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Status Terbit</th>
                        <th style="padding: 15px; border-radius: 0 10px 10px 0; font-size: 12px; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Tanggal Usul</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayats as $r)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.2s;">
                            <td style="padding: 15px;">
                                <div style="font-weight: bold; color: var(--secondary); font-size: 15px;">{{ $r->siswa->nama ?? 'N/A' }}</div>
                                <small style="color: var(--text-muted);">NIS: {{ $r->siswa->nis ?? '-' }} | Kelas: {{ $r->siswa->kelas ?? '-' }}</small>
                            </td>
                            <td style="padding: 15px;">
                                <strong style="font-size: 16px; color: var(--primary);">{{ number_format($r->kpi_score, 1) }}</strong>
                            </td>
                            <td style="padding: 15px;">
                                @if($r->kepsek_status === 'menunggu')
                                    <span style="background: #fffbeb; color: #d97706; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-clock"></i> Menunggu
                                    </span>
                                @elseif($r->kepsek_status === 'layak')
                                    <span style="background: #ecfdf5; color: #10b981; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-check-circle"></i> Layak
                                    </span>
                                @elseif($r->kepsek_status === 'tidak_layak')
                                    <span style="background: #fef2f2; color: #ef4444; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-times-circle"></i> Tidak Layak
                                    </span>
                                @else
                                    <span style="background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                        {{ $r->kepsek_status ?? 'N/A' }}
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 15px; font-size: 13px; color: var(--text-muted); max-width: 250px;">
                                {{ $r->kepsek_catatan ?? '-' }}
                            </td>
                            <td style="padding: 15px;">
                                @if($r->is_published || $r->status_publikasi === 'published')
                                    <span style="background: #f3e8ff; color: #7c3aed; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-globe"></i> Diposting
                                    </span>
                                @else
                                    <span style="background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-eye-slash"></i> Belum Terbit
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 15px; font-size: 12px; color: var(--text-muted);">
                                {{ $r->updated_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fa-solid fa-folder-open" style="font-size: 36px; margin-bottom: 12px; color: var(--text-muted);"></i>
                                <div style="font-weight: 600;">Belum Ada Riwayat Usulan</div>
                                <div style="font-size: 13px; margin-top: 4px;">Riwayat akan muncul setelah Anda mengusulkan rekomendasi ke Kepala Sekolah.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
