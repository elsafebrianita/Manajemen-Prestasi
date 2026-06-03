@extends('layouts.app')

@section('title', 'Detail Perkembangan Siswa - SIMPRES')
@section('page_title', 'Detail Perkembangan Siswa')

@section('content')
<div style="margin-bottom: 25px;">
    <a href="/guru-bk/monitoring" style="padding: 10px 20px; border-radius: 12px; background: white; color: #0f766e; border: 1px solid #e2e8f0; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.02);" onmouseover="this.style.background='#f8fafc'; this.style.transform='translateX(-3px)'" onmouseout="this.style.background='white'; this.style.transform='translateX(0)'">
        <i class="fas fa-arrow-left"></i> Kembali ke Monitoring
    </a>
</div>

@if(session('success'))
    <div style="background: #ecfdf5; color: #059669; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; font-weight: 700; display: flex; align-items: center; gap: 12px; border-left: 5px solid #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08);">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; align-items: start;">
    
    <!-- COLUMN LEFT: PROFILE & SUMMARY -->
    <div style="display: flex; flex-direction: column; gap: 30px;">
        
        <!-- CARD PROFILE -->
        <div style="background: white; border-radius: 25px; padding: 30px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 80px; background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);"></div>
            
            <div style="display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2; margin-top: 20px; margin-bottom: 25px;">
                <div style="width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, #14b8a6, #0f766e); display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 800; border: 4px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-bottom: 15px;">
                    {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                </div>
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 700; color: #0f172a; text-align: center;">{{ $siswa->nama }}</h3>
                <p style="font-size: 12px; color: #64748b; font-weight: 500; margin-top: 2px;">NIS: {{ $siswa->nis }}</p>
                
                @if($siswa->penilaian)
                    <div style="margin-top: 15px; background: #ecfdf5; color: #065f46; font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 20px; border: 1px solid #a7f3d0;">
                        ★ Rank {{ $siswa->penilaian->ranking ?? '-' }} Kelas
                    </div>
                @endif
            </div>

            <div style="border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                    <tr style="height: 35px;">
                        <td style="color: #64748b; font-weight: 500; width: 100px;">Kelas</td>
                        <td style="font-weight: 700; color: #1e293b;">: {{ $siswa->kelasRel->nama_kelas ?? $siswa->kelas }}</td>
                    </tr>
                    <tr style="height: 35px;">
                        <td style="color: #64748b; font-weight: 500;">Jurusan</td>
                        <td style="font-weight: 700; color: #1e293b;">: {{ $siswa->jurusan }}</td>
                    </tr>
                    <tr style="height: 35px;">
                        <td style="color: #64748b; font-weight: 500;">Jenis Kelamin</td>
                        <td style="font-weight: 700; color: #1e293b;">: {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr style="height: 35px;">
                        <td style="color: #64748b; font-weight: 500;">Wali Kelas</td>
                        <td style="font-weight: 700; color: #1e293b;">: {{ $siswa->walikelas->name ?? '-' }}</td>
                    </tr>
                    <tr style="height: 35px;">
                        <td style="color: #64748b; font-weight: 500;">Bakat Dominan</td>
                        <td style="font-weight: 700; color: #0f766e;">: {{ $siswa->penilaian->bakat_dominan ?? 'Belum Teranalisis' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- SCORE CARD (KPI / SPI indicators) -->
        <div style="background: white; border-radius: 25px; padding: 30px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
            <h4 style="font-size: 15px; font-weight: 700; font-family: 'Poppins', sans-serif; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-chart-bar" style="color: #0f766e;"></i> Indikator Capaian KPI
            </h4>
            
            @if($siswa->penilaian)
                <div style="text-align: center; margin-bottom: 25px; padding: 15px; background: #f0fdfa; border-radius: 20px; border: 1px solid #ccfbf1;">
                    <div style="font-size: 40px; font-weight: 800; color: #0f766e;">{{ number_format($siswa->penilaian->kpi_score, 1) }}</div>
                    <div style="font-size: 11px; font-weight: 700; color: #115e59; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 5px;">Skor Akhir KPI (SAW)</div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 15px; text-align: center;">
                        <div style="font-size: 18px; font-weight: 800; color: #0f766e;">{{ number_format($siswa->penilaian->c1, 1) }}</div>
                        <div style="font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 2px;">Akademik (C1)</div>
                    </div>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 15px; text-align: center;">
                        <div style="font-size: 18px; font-weight: 800; color: #0f766e;">{{ number_format($siswa->penilaian->c2, 1) }}</div>
                        <div style="font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 2px;">Prestasi Akad. (C2)</div>
                    </div>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 15px; text-align: center;">
                        <div style="font-size: 18px; font-weight: 800; color: #0f766e;">{{ number_format($siswa->penilaian->c3, 1) }}</div>
                        <div style="font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 2px;">Organisasi (C3)</div>
                    </div>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 15px; text-align: center;">
                        <div style="font-size: 18px; font-weight: 800; color: #0f766e;">{{ number_format($siswa->penilaian->c4, 1) }}</div>
                        <div style="font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 2px;">Prestasi Non-Akad. (C4)</div>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 30px 10px; color: #94a3b8; font-size: 13px;">
                    <i class="fas fa-calculator" style="font-size: 28px; margin-bottom: 10px; color: #cbd5e1;"></i>
                    <p>KPI siswa belum dikalkulasi oleh Wali Kelas.</p>
                </div>
            @endif
        </div>

    </div>

    <!-- COLUMN RIGHT: CHARTS, ACADEMICS, & INTERACTION -->
    <div style="display: flex; flex-direction: column; gap: 30px;">
        
        <!-- LINE CHART SEMESTER PROGRESSION -->
        <div style="background: white; border-radius: 25px; padding: 30px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
            <h3 style="font-size: 16px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
                <i class="fas fa-chart-line" style="color: #0f766e;"></i> Grafik Perkembangan Nilai KPI Siswa
            </h3>
            <div style="position: relative; height: 260px;">
                <canvas id="kpiProgressChart"></canvas>
            </div>
        </div>

        <!-- ACADEMIC & GRADES -->
        <div style="background: white; border-radius: 25px; padding: 30px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
            <h3 style="font-size: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
                <i class="fas fa-graduation-cap" style="color: #0f766e;"></i> Detail Nilai Rapor Siswa
            </h3>
            
            @php
                $nilaiSiswas = $siswa->nilaiSiswas()->with('mapel')->get();
            @endphp

            @if($nilaiSiswas->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 2px solid #f1f5f9; background: #f8fafc;">
                                <th style="padding: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 10px;">Mata Pelajaran</th>
                                <th style="padding: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 10px; text-align: center; width: 100px;">Nilai Rapor</th>
                                <th style="padding: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 10px; width: 150px;">Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilaiSiswas as $ns)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 12px; font-weight: 600; color: #334155;">{{ $ns->mapel->nama_mapel ?? '-' }}</td>
                                    <td style="padding: 12px; text-align: center; font-weight: 800; font-size: 14px; color: {{ $ns->nilai >= 80 ? '#10b981' : ($ns->nilai >= 70 ? '#3b82f6' : '#ef4444') }}">{{ $ns->nilai }}</td>
                                    <td style="padding: 12px;">
                                        @if($ns->nilai >= 85)
                                            <span style="color: #047857; font-weight: 700;">Sangat Baik (A)</span>
                                        @elseif($ns->nilai >= 75)
                                            <span style="color: #1d4ed8; font-weight: 700;">Baik (B)</span>
                                        @elseif($ns->nilai >= 60)
                                            <span style="color: #b45309; font-weight: 700;">Cukup (C)</span>
                                        @else
                                            <span style="color: #b91c1c; font-weight: 700;">Kurang (D)</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 25px; color: #94a3b8; font-size: 13px; background: #f8fafc; border-radius: 15px; border: 1px dashed #cbd5e1;">
                    Belum ada data nilai rapor untuk siswa ini.
                </div>
            @endif
        </div>

        <!-- LIST PRESTASI & ORGANISASI -->
        <div style="background: white; border-radius: 25px; padding: 30px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
            <h3 style="font-size: 16px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
                <i class="fas fa-medal" style="color: #0f766e;"></i> Catatan Prestasi & Organisasi Siswa
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- Akademik -->
                <div>
                    <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        🏆 Akademik Spesifik (C2)
                    </h4>
                    @forelse($prestasiAkademik as $pa)
                        <div style="background: #f8fafc; padding: 12px 15px; border-radius: 12px; margin-bottom: 8px; border-left: 4px solid #3b82f6; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 700; font-size: 13px; color: #1e293b;">{{ $pa->nama_prestasi }}</div>
                                <small style="color: #64748b;">
                                    Kategori: {{ $pa->kategori->nama_kategori }} | Tingkat: {{ $pa->tingkat }}
                                    @if($pa->lokasi)
                                        • Lokasi: {{ $pa->lokasi }}
                                    @endif
                                </small>
                            </div>
                            <span style="background: #eff6ff; color: #1d4ed8; padding: 3px 8px; border-radius: 8px; font-size: 11px; font-weight: 700;">{{ $pa->poin }} Poin</span>
                        </div>
                    @empty
                        <div style="font-size: 12px; color: #94a3b8; font-style: italic;">Tidak ada riwayat prestasi akademik.</div>
                    @endforelse
                </div>

                <!-- Organisasi -->
                <div style="margin-top: 10px;">
                    <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        🗣️ Kegiatan Organisasi & Kepengurusan (C3)
                    </h4>
                    @forelse($prestasiOrganisasi as $po)
                        <div style="background: #f8fafc; padding: 12px 15px; border-radius: 12px; margin-bottom: 8px; border-left: 4px solid #10b981; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 700; font-size: 13px; color: #1e293b;">{{ $po->nama_prestasi }}</div>
                                <small style="color: #64748b;">
                                    Kategori: {{ $po->kategori->nama_kategori }} | Jabatan: {{ $po->tingkat }}
                                    @if($po->lokasi)
                                        • Lokasi: {{ $po->lokasi }}
                                    @endif
                                </small>
                            </div>
                            <span style="background: #ecfdf5; color: #065f46; padding: 3px 8px; border-radius: 8px; font-size: 11px; font-weight: 700;">{{ $po->poin }} Poin</span>
                        </div>
                    @empty
                        <div style="font-size: 12px; color: #94a3b8; font-style: italic;">Tidak ada riwayat keikutsertaan organisasi.</div>
                    @endforelse
                </div>

                <!-- Non Akademik -->
                <div style="margin-top: 10px;">
                    <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                        🎨 Seni & Olahraga / Non-Akademik (C4)
                    </h4>
                    @forelse($prestasiNonAkademik as $pna)
                        <div style="background: #f8fafc; padding: 12px 15px; border-radius: 12px; margin-bottom: 8px; border-left: 4px solid #f59e0b; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 700; font-size: 13px; color: #1e293b;">{{ $pna->nama_prestasi }}</div>
                                <small style="color: #64748b;">
                                    Kategori: {{ $pna->kategori->nama_kategori }} | Tingkat: {{ $pna->tingkat }}
                                    @if($pna->lokasi)
                                        • Lokasi: {{ $pna->lokasi }}
                                    @endif
                                </small>
                            </div>
                            <span style="background: #fffbeb; color: #b45309; padding: 3px 8px; border-radius: 8px; font-size: 11px; font-weight: 700;">{{ $pna->poin }} Poin</span>
                        </div>
                    @empty
                        <div style="font-size: 12px; color: #94a3b8; font-style: italic;">Tidak ada riwayat prestasi non-akademik/bakat.</div>
                    @endforelse
                </div>

            </div>
        </div>


        <!-- FORM QUICK PEMBINAAN -->
        <div style="background: white; border-radius: 25px; padding: 30px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
            <h3 style="font-size: 16px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
                <i class="fas fa-user-shield" style="color: #0f766e;"></i> Catat Pembinaan Konseling Baru
            </h3>

            <form action="{{ route('guru-bk.pembinaan.store') }}" method="POST" style="margin: 0;">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 18px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px;">Tanggal Pembinaan</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px;" required>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px;">Jenis Pembinaan</label>
                        <select name="jenis_pembinaan" style="width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-weight: 600;" required>
                            <option value="akademik">Akademik</option>
                            <option value="non_akademik">Non Akademik</option>
                            <option value="disiplin">Disiplin / Perilaku</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px;">Catatan Pembinaan</label>
                    <textarea name="catatan" placeholder="Detail hasil sesi bimbingan / arahan pembinaan..." style="width: 100%; height: 95px; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-family: inherit; resize: none; transition: border 0.3s;" onfocus="this.style.borderColor='#0f766e'" required></textarea>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 8px;">Status Perkembangan</label>
                    <select name="status" style="width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; font-weight: 600;" required>
                        <option value="proses">Dalam Proses Pembinaan</option>
                        <option value="selesai">Selesai (Sudah Teratasi)</option>
                    </select>
                </div>

                <button type="submit" style="width: 100%; padding: 14px; background: #0f766e; color: white; border: none; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(15, 118, 110, 0.2);" onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'" onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                    <i class="fas fa-check-circle"></i> Simpan Catatan Pembinaan
                </button>
            </form>
        </div>

        <!-- RIWAYAT TIMELINE -->
        <div style="background: white; border-radius: 25px; padding: 30px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
            <h3 style="font-size: 16px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a;">
                <i class="fas fa-history" style="color: #0f766e;"></i> Histori Pembinaan BK Siswa
            </h3>

            <div style="display: flex; flex-direction: column; gap: 20px; position: relative; padding-left: 20px; border-left: 2px solid #e2e8f0; margin-left: 10px;">
                @forelse($riwayatBimbingan as $rw)
                    <div style="position: relative;">
                        <!-- Timeline bullet -->
                        <div style="position: absolute; left: -27px; top: 4px; width: 12px; height: 12px; border-radius: 50%; background: {{ $rw->jenis_pembinaan === 'disiplin' ? '#ef4444' : ($rw->jenis_pembinaan === 'akademik' ? '#3b82f6' : '#10b981') }}; border: 3px solid white; box-shadow: 0 0 0 2px #e2e8f0;"></div>
                        
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 600;">{{ date('d M Y', strtotime($rw->tanggal)) }}</div>
                        <div style="display: flex; align-items: center; gap: 8px; margin: 3px 0;">
                            <span style="font-size: 12px; font-weight: 800; color: #1e293b;">Pembinaan {{ ucfirst($rw->jenis_pembinaan) }}</span>
                            <span style="font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 12px; background: {{ $rw->status === 'selesai' ? '#f0fdf4' : '#fffbeb' }}; color: {{ $rw->status === 'selesai' ? '#16a34a' : '#d97706' }};">
                                {{ ucfirst($rw->status) }}
                            </span>
                        </div>
                        <p style="font-size: 13px; color: #475569; line-height: 1.5; margin-top: 5px;">{{ $rw->catatan }}</p>
                        <small style="display:block; color: #94a3b8; font-size: 11px; margin-top: 5px;">Dibimbing oleh: {{ $rw->guru->name ?? '-' }}</small>
                    </div>
                @empty
                    <div style="text-align: center; padding: 10px; color: #94a3b8; font-size: 13px; margin-left: -20px; border-left: none;">
                        Belum ada riwayat pembinaan sebelumnya.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const progressCtx = document.getElementById('kpiProgressChart').getContext('2d');
        
        // Data dari Controller
        const labels = {!! json_encode($chartData['labels']) !!};
        const dataValues = {!! json_encode($chartData['data']) !!};

        new Chart(progressCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor KPI Siswa',
                    data: dataValues,
                    borderColor: '#0f766e',
                    backgroundColor: 'rgba(15, 118, 110, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#0f766e',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
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
                scales: {
                    y: {
                        min: 0,
                        max: 100,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11
                            },
                            color: '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11,
                                weight: 600
                            },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
