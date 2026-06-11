@extends('layouts.app')

@section('title', 'Bimbingan Konseling - SIMPRES')
@section('page_title', 'Bimbingan Konseling')

@section('content')
<style>
    .bk-container {
        padding: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 24px;
        padding: 35px 40px;
        color: white;
        margin-bottom: 35px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(15, 118, 110, 0.15);
    }
    .welcome-text {
        position: relative;
        z-index: 2;
    }
    .welcome-banner h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 28px;
        margin-bottom: 8px;
        font-weight: 700;
    }
    .welcome-banner p {
        font-size: 15px;
        opacity: 0.9;
        max-width: 650px;
        line-height: 1.6;
    }
    .welcome-icon {
        position: absolute;
        right: 40px;
        bottom: -20px;
        font-size: 150px;
        color: rgba(255,255,255,0.06);
        transform: rotate(-10deg);
        font-weight: 900;
        pointer-events: none;
    }

    .alert-box {
        padding: 18px 24px;
        border-radius: 16px;
        margin-bottom: 30px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .alert-success {
        background: #ecfdf5;
        color: #059669;
        border-left: 5px solid #10b981;
    }
    .alert-error {
        background: #fef2f2;
        color: #dc2626;
        border-left: 5px solid #ef4444;
    }

    .bk-grid {
        display: grid;
        grid-template-columns: 1fr 1.3fr;
        gap: 35px;
    }

    .bk-card {
        background: var(--surface);
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.04);
        margin-bottom: 30px;
    }
    .bk-card h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--secondary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
    }
    .form-group input, .form-group select, .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        background: #f8fafc;
        font-family: inherit;
        font-size: 14px;
        transition: var(--transition);
        outline: none;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
    }
    .form-group textarea {
        height: 120px;
        resize: none;
    }

    .btn-submit {
        background: var(--primary);
        color: white;
        border: none;
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-submit:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(15, 118, 110, 0.15);
    }

    /* Status Badges */
    .badge-status {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-pending { background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; }
    .badge-diproses { background: #fffbeb; color: #d97706; border: 1px solid #fef3c7; }
    .badge-disetujui { background: #ecfdf4; color: #16a34a; border: 1px solid #dcfce7; }
    .badge-selesai { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

    .req-item {
        padding: 20px;
        border-radius: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 15px;
        transition: var(--transition);
    }
    .req-item:hover {
        transform: translateX(4px);
        border-color: var(--primary-light);
    }
    .req-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .req-date {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
    }
    .req-keluhan {
        font-size: 13.5px;
        color: var(--text-main);
        line-height: 1.5;
    }

    @media (max-width: 991px) {
        .bk-grid { grid-template-columns: 1fr; }
        .bk-container { padding: 20px; }
    }
</style>

<div class="bk-container">
    <!-- Banner Welcome -->
    <div class="welcome-banner">
        <div class="welcome-text">
            <h2>Layanan Bimbingan Konseling (BK)</h2>
            <p>Konsultasikan masalah akademik, non-akademik, keikutsertaan organisasi, atau arahan pengembangan karir dan minat bakat Anda secara langsung dengan Guru BK kami.</p>
        </div>
        <div class="welcome-icon">
            <i class="fa-solid fa-user-shield"></i>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-box alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert-box alert-error">
            <i class="fas fa-times-circle"></i>
            <div>
                <ul style="margin: 0; padding-left: 20px; font-size: 13px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bk-grid">
        <!-- LEFT: FORM PENGAJUAN -->
        <div>
            <div class="bk-card">
                <h3><i class="fas fa-paper-plane" style="color: var(--primary);"></i> Ajukan Konsultasi Baru</h3>
                <form action="{{ route('siswa.bimbingan.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="tanggal_pengajuan">Tanggal Pilihan Konsultasi</label>
                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tipe_konsultasi">Kategori Konsultasi</label>
                        <select name="tipe_konsultasi" id="tipe_konsultasi" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="akademik">Akademik & Nilai Rapor</option>
                            <option value="non_akademik">Seni & Olahraga (Non-Akademik)</option>
                            <option value="disiplin">Sikap & Kedisiplinan</option>
                            <option value="karir">Karir, Minat, & Bakat</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="keluhan">Deskripsi Hal Yang Ingin Dikonsultasikan</label>
                        <textarea name="keluhan" id="keluhan" placeholder="Tuliskan keluhan, saran, atau bantuan yang Anda butuhkan secara jelas..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Ajukan Konsultasi Sekarang
                    </button>
                </form>
            </div>
            
            <!-- BK Staff Card -->
            <div class="bk-card" style="padding: 20px;">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--secondary); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-info-circle" style="color: var(--primary);"></i> Informasi Layanan BK
                </h4>
                <p style="font-size: 12px; color: var(--text-muted); line-height: 1.6; margin: 0;">
                    Layanan Bimbingan Konseling SIMPRES beroperasi setiap hari sekolah. Setiap pengajuan Anda akan diperiksa secara berkala oleh Guru BK. Anda juga dapat melihat hasil pembinaan dan rekomendasi resmi langsung di bawah ini setelah sesi selesai dilakukan.
                </p>
            </div>
        </div>

        <!-- RIGHT: RIWAYAT & HASIL PEMBINAAN -->
        <div>
            <!-- RIWAYAT PENGAJUAN KONSULTASI -->
            <div class="bk-card">
                <h3><i class="fas fa-history" style="color: var(--primary);"></i> Status Pengajuan Konsultasi Saya</h3>
                @forelse($pengajuans as $p)
                    <div class="req-item">
                        <div class="req-header">
                            <span class="req-date">
                                <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->translatedFormat('d F Y') }}
                            </span>
                            @php
                                $badge = 'badge-pending';
                                $icon = 'fa-clock';
                                if($p->status === 'disetujui') {
                                    $badge = 'badge-disetujui';
                                    $icon = 'fa-calendar-check';
                                } elseif($p->status === 'diproses') {
                                    $badge = 'badge-diproses';
                                    $icon = 'fa-spinner fa-spin';
                                } elseif($p->status === 'selesai') {
                                    $badge = 'badge-selesai';
                                    $icon = 'fa-check-circle';
                                }
                            @endphp
                            <span class="badge-status {{ $badge }}">
                                <i class="fas {{ $icon }}"></i> {{ ucfirst($p->status) }}
                            </span>
                        </div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary); margin-bottom: 6px; text-transform: uppercase;">
                            Kategori: {{ str_replace('_', ' ', $p->tipe_konsultasi) }}
                        </div>
                        <p class="req-keluhan">{{ $p->keluhan }}</p>
                        @if($p->status === 'disetujui' || $p->status === 'selesai')
                            @if($p->tanggal_konsultasi)
                                <div style="margin-top: 12px; padding: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; font-size: 12.5px; margin-bottom: 12px;">
                                    <div style="font-weight: 800; color: #0f766e; margin-bottom: 5px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-calendar-check"></i> Jadwal Konsultasi Disetujui:
                                    </div>
                                    <div style="display: grid; gap: 4px; color: #1e293b; font-weight: 500;">
                                        <div><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($p->tanggal_konsultasi)->translatedFormat('d F Y') }}</div>
                                        <div><strong>Waktu / Jam:</strong> {{ $p->jam_konsultasi }}</div>
                                        <div><strong>Ruangan:</strong> {{ $p->ruangan_konsultasi }}</div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if($p->status === 'selesai' && $p->bimbinganBk)
                            <div style="margin-top: 12px; padding-top: 10px; border-top: 1px dashed #e2e8f0; font-size: 11.5px; color: #0284c7; font-weight: 600;">
                                <i class="fas fa-info-circle"></i> Sesi konsultasi telah ditindaklanjuti. Hasil pembinaan dapat dilihat pada daftar di bawah.
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fas fa-comment-slash" style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
                        Belum ada riwayat pengajuan konsultasi saat ini.
                    </div>
                @endforelse
            </div>

            <!-- HASIL BIMBINGAN BK RESMI -->
            <div class="bk-card">
                <h3><i class="fas fa-user-shield" style="color: var(--primary);"></i> Hasil Bimbingan & Rekomendasi BK Resmi</h3>
                @forelse($bimbingans as $b)
                    <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-left: 6px solid #0284c7; padding: 20px; border-radius: 18px; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px dashed #bae6fd; padding-bottom: 10px;">
                            <span style="font-weight: 800; font-size: 11px; text-transform: uppercase; background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px;">
                                <i class="fas fa-tag"></i> {{ str_replace('_', ' ', $b->jenis_pembinaan) }}
                            </span>
                            <span style="font-size: 11px; font-weight: 700; color: #0369a1;">
                                <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <p style="font-size: 13.5px; color: #1e293b; line-height: 1.6; font-weight: 500; margin-bottom: 15px;">{{ $b->catatan }}</p>
                        
                        @if($b->rekomendasi_lomba || $b->rekomendasi_organisasi || $b->rekomendasi_pengembangan)
                            <div style="background: white; border-radius: 12px; padding: 12px 15px; border: 1px solid #e2e8f0; font-size: 12.5px;">
                                <div style="font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 8px;">Rekomendasi Guru BK:</div>
                                @if($b->rekomendasi_lomba)
                                    <div style="margin-bottom: 4px;"><strong style="color: var(--primary);">🏆 Lomba:</strong> {{ $b->rekomendasi_lomba }}</div>
                                @endif
                                @if($b->rekomendasi_organisasi)
                                    <div style="margin-bottom: 4px;"><strong style="color: var(--primary);">👥 Organisasi:</strong> {{ $b->rekomendasi_organisasi }}</div>
                                @endif
                                @if($b->rekomendasi_pengembangan)
                                    <div><strong style="color: var(--primary);">⚙️ Diri:</strong> {{ $b->rekomendasi_pengembangan }}</div>
                                @endif
                            </div>
                        @endif

                        <div style="margin-top: 15px; text-align: right; font-size: 11px; color: #64748b; font-weight: 600;">
                            Konselor: {{ $b->guru->name ?? 'Guru BK' }}
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fas fa-folder-open" style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
                        Belum ada catatan pembinaan/bimbingan dari Guru BK.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
