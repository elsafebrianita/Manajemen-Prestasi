@extends('layouts.app')
@section('page_title', 'Riwayat Validasi')

@section('content')
<div style="padding: 40px;">
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px; color: var(--secondary);"><i class="fa-solid fa-history"></i> Riwayat Validasi</h2>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Daftar prestasi yang sudah Anda proses (Disetujui / Ditolak).</p>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-color); text-align: left;">
                        <th style="padding: 15px; border-radius: 10px 0 0 10px;">Tanggal Proses</th>
                        <th style="padding: 15px;">Siswa</th>
                        <th style="padding: 15px;">Prestasi</th>
                        <th style="padding: 15px;">Keterangan</th>
                        <th style="padding: 15px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestasi as $p)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 15px;">{{ \Carbon\Carbon::parse($p->updated_at)->format('d M Y, H:i') }}</td>
                            <td style="padding: 15px;">
                                <strong style="color: var(--secondary);">{{ $p->siswa->nama ?? 'N/A' }}</strong><br>
                                <small style="color: var(--text-muted);">NIS: {{ $p->siswa->nis ?? '-' }}</small>
                            </td>
                            <td style="padding: 15px;">
                                <strong>{{ $p->nama_prestasi }}</strong><br>
                                <small style="color: var(--text-muted);">{{ $p->kategori->nama_kategori ?? '-' }}</small>
                                @if($p->lokasi)
                                    <br><small style="color: var(--text-muted);"><i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 4px;"></i>{{ $p->lokasi }}</small>
                                @endif
                            </td>
                            <td style="padding: 15px;">
                                <span style="font-size: 13px; color: var(--text-muted);">{{ $p->keterangan ?? '-' }}</span>
                            </td>
                            <td style="padding: 15px;">
                                @if($p->status == 'disetujui')
                                    <span style="background: #ecfdf5; color: #10b981; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;"><i class="fa-solid fa-check-circle"></i> Disetujui</span>
                                @else
                                    <span style="background: #fef2f2; color: #ef4444; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;"><i class="fa-solid fa-times-circle"></i> Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">Belum ada riwayat validasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
