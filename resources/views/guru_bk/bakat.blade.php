@extends('layouts.app')

@section('title', 'Bakat & Prestasi Siswa - SIMPRES')
@section('page_title', 'Bakat & Prestasi Siswa')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 40px; align-items: start;">
    
    <!-- MAIN MONITORS TABLE -->
    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h3 style="font-size: 18px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-brain" style="color: #0f766e;"></i> Monitoring Bakat & Minat Siswa
                </h3>
                <p style="font-size: 12px; color: #64748b; margin-top: 4px;">Pilih kelas untuk memantau sebaran bakat dominan siswa.</p>
            </div>

            <!-- FILTER KELAS -->
            <form action="/guru-bk/bakat" method="GET" style="margin: 0;">
                <select name="kelas_id" onchange="this.form.submit()" style="padding: 10px 15px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-weight: 600; cursor: pointer; background-color: #f8fafc; color: #334155;">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                @if(request()->filled('kelas_id'))
                    <a href="/guru-bk/bakat" style="padding: 10px 15px; border-radius: 10px; border: 1px solid #fee2e2; color: #ef4444; background: #fef2f2; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; margin-left: 6px;">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>

        @if(session('success'))
            <div style="background: #ecfdf5; color: #059669; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; display: flex; align-items: center; gap: 12px; border-left: 5px solid #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9; background-color: #f8fafc;">
                        <th style="padding: 15px 12px; color: #64748b; text-transform: uppercase; font-weight: 700;">Nama Siswa</th>
                        <th style="padding: 15px 12px; color: #64748b; text-transform: uppercase; font-weight: 700; text-align: center; width: 100px;">Skor KPI</th>
                        <th style="padding: 15px 12px; color: #64748b; text-transform: uppercase; font-weight: 700; width: 250px;">Bakat Dominan (SAW)</th>
                        <th style="padding: 15px 12px; color: #64748b; text-transform: uppercase; font-weight: 700; text-align: center; width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $bakatCounts = [
                            'akademik_umum' => 0,
                            'akademik_spesifik' => 0,
                            'organisasi' => 0,
                            'seni_olahraga' => 0,
                            'belum' => 0
                        ];
                    @endphp
                    @forelse($siswas as $siswa)
                        @php
                            $bakatLower = strtolower($siswa->bakat);
                            if (str_contains($bLower = $bakatLower, 'akademik umum') || str_contains($bLower, 'intellectual')) {
                                $bakatCounts['akademik_umum']++;
                                $bakatBadge = '<span style="background: #eff6ff; color: #1d4ed8; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid #bfdbfe;"><i class="fas fa-lightbulb"></i> Akademik Umum</span>';
                            } elseif (str_contains($bLower, 'akademik spesifik')) {
                                $bakatCounts['akademik_spesifik']++;
                                $bakatBadge = '<span style="background: #ecfdf5; color: #047857; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid #a7f3d0;"><i class="fas fa-flask"></i> Akademik Spesifik</span>';
                            } elseif (str_contains($bLower, 'organisasi') || str_contains($bLower, 'social')) {
                                $bakatCounts['organisasi']++;
                                $bakatBadge = '<span style="background: #f5f3ff; color: #6d28d9; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid #ddd6fe;"><i class="fas fa-users"></i> Organisasi</span>';
                            } elseif (str_contains($bLower, 'seni') || str_contains($bLower, 'olahraga') || str_contains($bLower, 'arts')) {
                                $bakatCounts['seni_olahraga']++;
                                $bakatBadge = '<span style="background: #fffbeb; color: #b45309; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid #fde68a;"><i class="fas fa-palette"></i> Seni & Olahraga</span>';
                            } else {
                                $bakatCounts['belum']++;
                                $bakatBadge = '<span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid #cbd5e1;"><i class="fas fa-question"></i> Belum Dianalisis</span>';
                            }
                        @endphp
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                            <td style="padding: 15px 12px;">
                                <div style="font-weight: 700; color: #0f172a; font-size: 14px;">{{ $siswa->nama }}</div>
                                <div style="font-size: 11px; color: #94a3b8; font-weight: 500;">Kelas: {{ $siswa->kelasRel->nama_kelas ?? ($siswa->kelas ?? '-') }}</div>
                            </td>
                            <td style="padding: 15px 12px; text-align: center;">
                                <span style="font-weight: 800; font-size: 14px; color: #334155;">{{ $siswa->penilaian ? number_format($siswa->penilaian->kpi_score, 1) : '0' }}</span>
                            </td>
                            <td style="padding: 15px 12px;">
                                {!! $bakatBadge !!}
                            </td>
                            <td style="padding: 15px 12px; text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <a href="{{ route('guru-bk.detail', $siswa->id) }}" style="padding: 6px 12px; border-radius: 8px; background-color: #0f766e; color: white; border: none; font-size: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 2px 4px rgba(15, 118, 110, 0.15);">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8; font-size: 14px;">Tidak ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SEBARAN BAKAT (CHART & LEGEND) -->
    <div style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04); position: sticky; top: 100px;">
        <h3 style="font-size: 17px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
            <i class="fas fa-chart-pie" style="color: #0f766e;"></i> Persentase Sebaran Bakat
        </h3>
        
        @if($siswas->count() > 0 && ($bakatCounts['akademik_umum'] + $bakatCounts['akademik_spesifik'] + $bakatCounts['organisasi'] + $bakatCounts['seni_olahraga'] > 0))
            <div style="position: relative; height: 230px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px;">
                <canvas id="bakatDistributionChart" style="max-height: 100%;"></canvas>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 12px; font-size: 12px; font-weight: 600; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-circle" style="color: #3b82f6;"></i> Akademik Umum</span>
                    <span style="color: #475569;">{{ $bakatCounts['akademik_umum'] }} Siswa</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-circle" style="color: #10b981;"></i> Akademik Spesifik</span>
                    <span style="color: #475569;">{{ $bakatCounts['akademik_spesifik'] }} Siswa</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-circle" style="color: #8b5cf6;"></i> Organisasi</span>
                    <span style="color: #475569;">{{ $bakatCounts['organisasi'] }} Siswa</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-circle" style="color: #f59e0b;"></i> Seni & Olahraga</span>
                    <span style="color: #475569;">{{ $bakatCounts['seni_olahraga'] }} Siswa</span>
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 40px 10px; color: #94a3b8; font-size: 13px;">
                <i class="fas fa-chart-pie" style="font-size: 32px; color: #cbd5e1; margin-bottom: 10px;"></i>
                <p>Belum ada data bakat yang teranalisis pada kelas ini.</p>
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chartCanvas = document.getElementById('bakatDistributionChart');
        if (chartCanvas) {
            const ctx = chartCanvas.getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Akademik Umum', 'Akademik Spesifik', 'Organisasi', 'Seni & Olahraga'],
                    datasets: [{
                        data: [
                            {{ $bakatCounts['akademik_umum'] }},
                            {{ $bakatCounts['akademik_spesifik'] }},
                            {{ $bakatCounts['organisasi'] }},
                            {{ $bakatCounts['seni_olahraga'] }}
                        ],
                        backgroundColor: ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
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
        }
    });
</script>
@endpush
@endsection
