@extends('layouts.app')

@section('title', 'Monitoring KPI Siswa - SIMPRES')
@section('page_title', 'Monitoring KPI Siswa')

@section('content')
<div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04); margin-bottom: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
        <h3 style="font-size: 18px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-desktop" style="color: #0f766e;"></i> Pemantauan Nilai & Status KPI Siswa
        </h3>
        
        <!-- FILTER FORM -->
        <form action="/guru-bk/monitoring" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; margin: 0;">
            <select name="kelas_id" onchange="this.form.submit()" style="padding: 10px 15px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-weight: 600; cursor: pointer; background-color: #f8fafc; color: #334155;">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" style="padding: 10px 15px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-weight: 600; cursor: pointer; background-color: #f8fafc; color: #334155;">
                <option value="">-- Semua Status KPI --</option>
                <option value="tinggi" @selected(request('status') === 'tinggi')>Tinggi (KPI &gt;= 80)</option>
                <option value="sedang" @selected(request('status') === 'sedang')>Sedang (KPI 70-79)</option>
                <option value="rendah" @selected(request('status') === 'rendah')>Rendah (KPI &lt; 70)</option>
            </select>
            
            @if(request()->filled('kelas_id') || request()->filled('status'))
                <a href="/guru-bk/monitoring" style="padding: 10px 15px; border-radius: 10px; border: 1px solid #fee2e2; color: #ef4444; background: #fef2f2; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-times"></i> Reset Filter
                </a>
            @endif
        </form>
    </div>

    <!-- TABLE -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f1f5f9; background-color: #f8fafc;">
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; width: 60px; text-align: center;">Rank</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700;">Nama Siswa</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; text-align: center; width: 100px;">Nilai KPI</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; text-align: center; width: 180px;">Status Perkembangan</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; width: 220px;">Bakat Dominan</th>
                    <th style="padding: 15px 12px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; text-align: center; width: 150px;">Aksi Pembinaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                        <td style="padding: 15px 12px; text-align: center;">
                            <div style="font-weight: 800; font-size: 15px; color: #475569; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; background: {{ $siswa->ranking == 1 ? '#fef3c7' : ($siswa->ranking == 2 ? '#e2e8f0' : ($siswa->ranking == 3 ? '#ffedd5' : '#f1f5f9')) }}; color: {{ $siswa->ranking == 1 ? '#d97706' : ($siswa->ranking == 2 ? '#475569' : ($siswa->ranking == 3 ? '#ea580c' : '#64748b')) }};">
                                {{ $siswa->ranking }}
                            </div>
                        </td>
                        <td style="padding: 15px 12px;">
                            <div style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $siswa->nama }}</div>
                            <div style="font-size: 11px; color: #94a3b8; font-weight: 500;">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelasRel->nama_kelas ?? $siswa->kelas }}</div>
                        </td>
                        <td style="padding: 15px 12px; text-align: center;">
                            <span style="font-weight: 800; font-size: 16px; color: {{ $siswa->penilaian && $siswa->penilaian->kpi_score >= 80 ? '#10b981' : ($siswa->penilaian && $siswa->penilaian->kpi_score >= 70 ? '#3b82f6' : '#ef4444') }};">
                                {{ $siswa->penilaian ? number_format($siswa->penilaian->kpi_score, 1) : '0' }}
                            </span>
                        </td>
                        <td style="padding: 15px 12px; text-align: center;">
                            @if($siswa->kpi_status === 'Sangat Baik')
                                <span style="background: #ecfdf5; color: #059669; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #a7f3d0; display: inline-block;">✨ Sangat Baik</span>
                            @elseif($siswa->kpi_status === 'Baik')
                                <span style="background: #eff6ff; color: #1d4ed8; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #bfdbfe; display: inline-block;">👍 Baik</span>
                            @elseif($siswa->kpi_status === 'Cukup')
                                <span style="background: #fffbeb; color: #b45309; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fde68a; display: inline-block;">⚖️ Cukup</span>
                            @else
                                <span style="background: #fef2f2; color: #b91c1c; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid #fecaca; display: inline-block;">🛡️ Perlu Pembinaan</span>
                            @endif
                        </td>
                        <td style="padding: 15px 12px;">
                            <span style="font-size: 12px; font-weight: 600; color: #475569; display: flex; align-items: center; gap: 6px;">
                                @php
                                    $bakat = $siswa->penilaian ? $siswa->penilaian->bakat_dominan : '';
                                @endphp
                                @if(str_contains(strtolower($bakat), 'akademik umum') || str_contains(strtolower($bakat), 'intellectual'))
                                    💡 
                                @elseif(str_contains(strtolower($bakat), 'akademik spesifik'))
                                    🔬 
                                @elseif(str_contains(strtolower($bakat), 'organisasi') || str_contains(strtolower($bakat), 'social'))
                                    🗣️ 
                                @elseif(str_contains(strtolower($bakat), 'seni') || str_contains(strtolower($bakat), 'arts'))
                                    🎨 
                                @else
                                    ❓
                                @endif
                                {{ $siswa->penilaian ? $siswa->penilaian->bakat_dominan : 'Belum Teranalisis' }}
                            </span>
                        </td>
                        <td style="padding: 15px 12px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="/guru-bk/detail/{{ $siswa->id }}" style="padding: 6px 12px; border-radius: 8px; background-color: #0f766e; color: white; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 5px rgba(15, 118, 110, 0.2);">
                                    <i class="fas fa-chart-line"></i> Detail
                                </a>
                                <a href="/guru-bk/pembinaan?siswa_id={{ $siswa->id }}" style="padding: 6px 12px; border-radius: 8px; background-color: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-user-shield"></i> Bina
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8; font-size: 14px;">Tidak ada data siswa ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
