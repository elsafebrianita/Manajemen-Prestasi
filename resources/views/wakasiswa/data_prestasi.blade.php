@extends('layouts.app')
@section('page_title', 'Data Prestasi')

@section('content')
<div style="padding: 40px;">
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h2 style="color: var(--secondary);"><i class="fa-solid fa-medal"></i> Semua Data Prestasi</h2>
                <p style="color: var(--text-muted); margin-top: 5px;">Seluruh data pengajuan prestasi siswa yang ada di sistem.</p>
            </div>
            <div>
                <form action="/wakasiswa/data-prestasi" method="GET" style="display: flex; gap: 10px;">
                    <select name="status" style="padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 14px;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Validasi</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <select name="kategori_id" style="padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 14px;">
                        <option value="">Semua Bidang</option>
                        <option value="1" {{ request('kategori_id') == '1' ? 'selected' : '' }}>Rapor</option>
                        <option value="2" {{ request('kategori_id') == '2' ? 'selected' : '' }}>Akademik</option>
                        <option value="3" {{ request('kategori_id') == '3' ? 'selected' : '' }}>Organisasi</option>
                        <option value="4" {{ request('kategori_id') == '4' ? 'selected' : '' }}>Seni, Budaya, Bahasa & Olahraga</option>
                    </select>
                    <button type="submit" style="background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold;">Filter</button>
                </form>
            </div>
        </div>

        @if(request('status') || request('kategori_id'))
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 14px; flex-wrap: wrap;">
                <span style="color: var(--text-muted); font-weight: 500;"><i class="fa-solid fa-filter" style="color: var(--primary);"></i> Filter Aktif:</span>
                @if(request('status'))
                    <span style="background: #e2e8f0; color: var(--secondary); padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                        Status: <span style="color: var(--primary);">{{ request('status') == 'pending' ? 'Menunggu Validasi' : (request('status') == 'disetujui' ? 'Disetujui' : 'Ditolak') }}</span>
                    </span>
                @endif
                @if(request('kategori_id'))
                    <span style="background: #e2e8f0; color: var(--secondary); padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                        Bidang: <span style="color: var(--primary);">{{ request('kategori_id') == '1' ? 'Rapor' : (request('kategori_id') == '2' ? 'Akademik' : (request('kategori_id') == '3' ? 'Organisasi' : 'Seni, Budaya, Bahasa & Olahraga')) }}</span>
                    </span>
                @endif
                <span style="color: var(--text-muted); font-size: 13px; margin-left: 10px;">
                    (Ditemukan <strong>{{ $prestasi->count() }}</strong> data)
                </span>
                <a href="/wakasiswa/data-prestasi" style="color: var(--danger); text-decoration: none; margin-left: auto; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            </div>
        @else
            <div style="margin-bottom: 15px; font-size: 14px; color: var(--text-muted);">
                Menampilkan semua data prestasi (Total: <strong>{{ $prestasi->count() }}</strong> data).
            </div>
        @endif

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-color); text-align: left;">
                        <th style="padding: 15px; border-radius: 10px 0 0 10px;">Tanggal</th>
                        <th style="padding: 15px;">Siswa</th>
                        <th style="padding: 15px;">Prestasi</th>
                        <th style="padding: 15px;">Tingkat & Juara</th>
                        <th style="padding: 15px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestasi as $p)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 15px;">{{ \Carbon\Carbon::parse($p->tanggal_capaian)->format('d M Y') }}</td>
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
                                <span style="background: #e0f2fe; color: #0284c7; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: bold;">{{ $p->tingkat }}</span>
                                <span style="background: #fef3c7; color: #d97706; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: bold;">{{ $p->juara }}</span>
                            </td>
                            <td style="padding: 15px;">
                                @if($p->status == 'pending')
                                    <span style="background: #fffbeb; color: #f59e0b; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;"><i class="fa-solid fa-clock"></i> Pending</span>
                                @elseif($p->status == 'disetujui')
                                    <span style="background: #ecfdf5; color: #10b981; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;"><i class="fa-solid fa-check-circle"></i> Disetujui</span>
                                @else
                                    <span style="background: #fef2f2; color: #ef4444; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;"><i class="fa-solid fa-times-circle"></i> Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">Belum ada data prestasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
