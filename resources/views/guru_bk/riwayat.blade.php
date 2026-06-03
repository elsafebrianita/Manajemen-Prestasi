@extends('layouts.app')

@section('title', 'Riwayat Pembinaan BK - SIMPRES')
@section('page_title', 'Riwayat Pembinaan Siswa')

@section('content')
<div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04); margin-bottom: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
        <div>
            <h3 style="font-size: 18px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-history" style="color: #0f766e;"></i> Histori & Log Pembinaan Guru BK
            </h3>
            <p style="font-size: 12px; color: #64748b; margin-top: 5px;">Kumpulan seluruh data bimbingan konseling dan pembinaan siswa.</p>
        </div>
        
        <div style="display: flex; gap: 12px;">
            <input type="text" id="searchInput" placeholder="Cari nama siswa..." style="padding: 10px 15px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-weight: 500; width: 220px;" onkeyup="filterTable()">
            
            <select id="typeFilter" onchange="filterTable()" style="padding: 10px 15px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-weight: 600; cursor: pointer; background-color: #f8fafc; color: #334155;">
                <option value="">-- Semua Jenis --</option>
                <option value="akademik">Akademik</option>
                <option value="non_akademik">Non Akademik</option>
                <option value="disiplin">Disiplin</option>
            </select>

            <select id="statusFilter" onchange="filterTable()" style="padding: 10px 15px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-weight: 600; cursor: pointer; background-color: #f8fafc; color: #334155;">
                <option value="">-- Semua Status --</option>
                <option value="proses">Dalam Proses</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; display: flex; align-items: center; gap: 12px; border-left: 5px solid #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table id="riwayatTable" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f1f5f9; background-color: #f8fafc;">
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; width: 120px;">Tanggal</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; width: 200px;">Nama Siswa</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; width: 150px;">Jenis Bimbingan</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700;">Catatan Guru BK</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; text-align: center; width: 120px;">Status</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; text-align: center; width: 100px;">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayats as $rw)
                    <tr class="table-row" data-name="{{ strtolower($rw->siswa->nama ?? '') }}" data-type="{{ $rw->jenis_pembinaan }}" data-status="{{ $rw->status }}" style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                        <td style="padding: 15px 12px;">
                            <div style="font-weight: 700; color: #475569; font-size: 13px;">{{ date('d M Y', strtotime($rw->tanggal)) }}</div>
                        </td>
                        <td style="padding: 15px 12px;">
                            <div style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $rw->siswa->nama ?? 'Siswa Terhapus' }}</div>
                            <div style="font-size: 11px; color: #94a3b8; font-weight: 500;">Kelas: {{ $rw->siswa->kelasRel->nama_kelas ?? ($rw->siswa->kelas ?? '-') }}</div>
                        </td>
                        <td style="padding: 15px 12px;">
                            @if($rw->jenis_pembinaan === 'disiplin')
                                <span style="background: #fef2f2; color: #ef4444; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid #fee2e2; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-triangle-exclamation"></i> Disiplin</span>
                            @elseif($rw->jenis_pembinaan === 'akademik')
                                <span style="background: #eff6ff; color: #3b82f6; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid #bfdbfe; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-book"></i> Akademik</span>
                            @else
                                <span style="background: #f0fdf4; color: #10b981; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-basketball"></i> Non-Akad</span>
                            @endif
                        </td>
                        <td style="padding: 15px 12px;">
                            <p style="font-size: 13px; color: #334155; line-height: 1.5; font-weight: 500; margin: 0;">{{ $rw->catatan }}</p>
                            <small style="color: #94a3b8; font-size: 11px; font-weight: 600; display: block; margin-top: 4px;">Oleh BK: {{ $rw->guru->name ?? '-' }}</small>
                        </td>
                        <td style="padding: 15px 12px; text-align: center;">
                            @if($rw->status === 'selesai')
                                <span style="background: #ecfdf5; color: #059669; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #a7f3d0; display: inline-block; width: 90px; text-align: center;">Selesai</span>
                            @else
                                <span style="background: #fffbeb; color: #d97706; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fde68a; display: inline-block; width: 90px; text-align: center;">Proses</span>
                            @endif
                        </td>
                        <td style="padding: 15px 12px; text-align: center;">
                            @if($rw->siswa_id)
                                <a href="/guru-bk/detail/{{ $rw->siswa_id }}" style="color: #0f766e; background: #e6f4f1; width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-size: 14px; transition: all 0.3s;" title="Lihat Profil & Perkembangan" onmouseover="this.style.background='#0f766e'; this.style.color='white'" onmouseout="this.style.background='#e6f4f1'; this.style.color='#0f766e'">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8; font-size: 14px;">Belum ada riwayat pembinaan bimbingan konseling di sistem.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterTable() {
        const searchVal = document.getElementById('searchInput').value.toLowerCase();
        const typeVal = document.getElementById('typeFilter').value;
        const statusVal = document.getElementById('statusFilter').value;
        
        const rows = document.querySelectorAll('.table-row');
        
        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const type = row.getAttribute('data-type');
            const status = row.getAttribute('data-status');
            
            const matchSearch = name.includes(searchVal);
            const matchType = typeVal === "" || type === typeVal;
            const matchStatus = statusVal === "" || status === statusVal;
            
            if (matchSearch && matchType && matchStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>
@endsection
