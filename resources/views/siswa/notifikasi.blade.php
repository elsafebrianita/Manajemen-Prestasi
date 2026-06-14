@extends('layouts.app')

@section('title', 'Notifikasi & Saran - SIMPRES')

@section('content')
<style>
    .notif-container {
        padding: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .header-box {
        margin-bottom: 35px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .header-box h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 28px;
        font-weight: 800;
        color: var(--secondary);
    }
    .header-box p {
        color: var(--text-muted);
        font-size: 14px;
        margin-top: 4px;
    }
    .btn-read-all {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        text-decoration: none;
    }
    .btn-read-all:hover {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 15px rgba(20, 184, 166, 0.2);
    }

    /* Stats Cards */
    .notif-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    .stat-card-custom {
        background: var(--surface);
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: var(--transition);
    }
    .stat-card-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    }
    .stat-info-custom h3 {
        font-size: 28px;
        font-weight: 800;
        color: var(--secondary);
        font-family: 'Poppins', sans-serif;
    }
    .stat-info-custom p {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 500;
        margin-top: 2px;
    }
    .stat-icon-custom {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .icon-teal { background: #e6f7f6; color: var(--primary-light); }
    .icon-red { background: #fef2f2; color: var(--danger); }
    .icon-gold { background: #fffbeb; color: var(--warning); }

    /* Layout Grid */
    .notif-grid {
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        gap: 35px;
    }
    .feed-card-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Notification Cards */
    .notif-item {
        background: var(--surface);
        border-radius: 22px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.04);
        border-left: 8px solid;
        transition: var(--transition);
        position: relative;
    }
    .notif-item:hover {
        transform: translateX(4px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    }
    .notif-item.pertahankan { border-left-color: var(--success); }
    .notif-item.cukup { border-left-color: var(--warning); }
    .notif-item.tingkatkan { border-left-color: var(--danger); }
    .notif-item.binaan { border-left-color: #0284c7; }

    .notif-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .notif-badge {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-success { background: #ecfdf5; color: var(--success); }
    .badge-warning { background: #fffbeb; color: var(--warning); }
    .badge-danger { background: #fef2f2; color: var(--danger); }
    .badge-binaan { background: #f0f9ff; color: #0284c7; }

    .notif-time {
        font-size: 12px;
        color: var(--text-muted);
    }
    .notif-message {
        font-size: 15px;
        color: var(--text-main);
        line-height: 1.6;
        margin-bottom: 18px;
        font-weight: 500;
    }
    .notif-sender {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 15px;
        border-top: 1px dashed #f1f5f9;
    }
    .sender-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: 800;
    }
    .sender-info h5 {
        font-size: 13px;
        font-weight: 700;
        color: var(--secondary);
    }
    .sender-info p {
        font-size: 11px;
        color: var(--text-muted);
    }

    /* Right Sidebar Cards */
    .side-card {
        background: var(--surface);
        border-radius: 22px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.04);
        margin-bottom: 25px;
    }
    .side-card h4 {
        font-size: 15px;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .walas-profile {
        text-align: center;
        padding: 15px 0;
    }
    .walas-avatar {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--secondary) 0%, #1e293b 100%);
        color: white;
        font-size: 28px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }
    .walas-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--secondary);
    }
    .walas-nip {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 3px;
    }

    /* Alert Banner */
    .cta-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        padding: 22px;
        border-radius: 18px;
        margin-top: 15px;
        text-align: center;
    }
    .cta-banner h5 { font-size: 14px; margin-bottom: 5px; }
    .cta-banner p { font-size: 11px; opacity: 0.9; margin-bottom: 15px; }
    .cta-banner .btn-cta {
        display: inline-block;
        background: white;
        color: var(--primary);
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        transition: 0.3s;
    }
    .cta-banner .btn-cta:hover {
        transform: scale(1.05);
    }

    @media (max-width: 991px) {
        .notif-grid { grid-template-columns: 1fr; }
        .notif-container { padding: 20px; }
    }
</style>

<div class="notif-container">
    <div class="header-box">
        <div>
            <h1><i class="fas fa-bell"></i> Notifikasi & Saran</h1>
            <p>Saran peningkatan kinerja akademik dan prestasi dari Wali Kelas Anda</p>
        </div>
        @php
            $hasUnread = $notifications->where('is_read', false)->count() > 0;
        @endphp
        @if($hasUnread)
            <form action="/notifikasi/read-all" method="POST">
                @csrf
                <button type="submit" class="btn-read-all">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    <!-- Stats Bar -->
    <div class="notif-stats">
        <div class="stat-card-custom">
            <div class="stat-info-custom">
                <h3>{{ $notifications->count() }}</h3>
                <p>Total Notifikasi</p>
            </div>
            <div class="stat-icon-custom icon-teal">
                <i class="fas fa-envelope-open-text"></i>
            </div>
        </div>
        <div class="stat-card-custom">
            <div class="stat-info-custom">
                <h3>{{ $notifications->where('is_read', false)->count() }}</h3>
                <p>Belum Dibaca</p>
            </div>
            <div class="stat-icon-custom icon-red">
                <i class="fas fa-bell"></i>
            </div>
        </div>
        <div class="stat-card-custom">
            <div class="stat-info-custom">
                <h3 style="font-size: 14px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; max-width: 180px;">
                    @php
                        $latestNotif = $notifications->first();
                        $latestType = $latestNotif ? $latestNotif->type : 'Belum Ada';
                    @endphp
                    {{ $latestType }}
                </h3>
                <p>Status Terkini</p>
            </div>
            <div class="stat-icon-custom icon-gold">
                <i class="fas fa-star"></i>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="notif-grid">
        <!-- Notification Feed -->
        <div class="feed-card-list">
            @forelse($notifications as $notif)
                @php
                    $cls = 'tingkatkan';
                    $badgeCls = 'badge-danger';
                    $icon = 'exclamation-circle';
                    
                    if($notif->type === 'Pertahankan') {
                        $cls = 'pertahankan';
                        $badgeCls = 'badge-success';
                        $icon = 'check-circle';
                    } elseif($notif->type === 'Cukup Baik') {
                        $cls = 'cukup';
                        $badgeCls = 'badge-warning';
                        $icon = 'info-circle';
                    } elseif($notif->type === 'Binaan BK' || $notif->type === 'Bimbingan BK') {
                        $cls = 'binaan';
                        $badgeCls = 'badge-binaan';
                        $icon = 'user-shield';
                    }
                @endphp
                <div class="notif-item {{ $cls }}">
                    <div class="notif-header">
                        <span class="notif-badge {{ $badgeCls }}">
                            <i class="fas fa-{{ $icon }}"></i> {{ $notif->type }}
                        </span>
                        <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notif-message">{{ $notif->message }}</p>
                    @if(str_contains(strtolower($notif->message), 'bk') || str_contains(strtolower($notif->message), 'konsultasi') || $notif->type === 'Bimbingan BK' || $notif->type === 'Binaan BK')
                        <div style="margin-bottom: 15px; margin-top: -5px;">
                            <a href="/siswa/bimbingan" class="btn-read-all" style="font-size: 11px; padding: 6px 12px; background: var(--primary); color: white; border-color: var(--primary); height: auto; min-height: 0;">
                                <i class="fas fa-comments"></i> Ajukan Konsultasi ke BK
                            </a>
                        </div>
                    @endif
                    <div class="notif-sender">
                        <div class="sender-avatar">
                            {{ strtoupper(substr($notif->sender->name ?? 'W', 0, 1)) }}
                        </div>
                        <div class="sender-info">
                            <h5>{{ $notif->sender->name ?? 'Wali Kelas' }}</h5>
                            <p>NIP. {{ $notif->sender->nip ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div style="background: white; border-radius: 22px; padding: 60px 20px; text-align: center; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    <div style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 style="font-weight: 800; color: var(--secondary); margin-bottom: 8px;">Inbox Anda Kosong</h3>
                    <p style="color: var(--text-muted); font-size: 14px; max-width: 400px; margin: 0 auto;">Belum ada saran atau notifikasi khusus dari Wali Kelas Anda saat ini. Terus belajar dan raih prestasi!</p>
                </div>
            @endforelse
        </div>

        <!-- Right Column Sidebar -->
        <div>
            <!-- Wali Kelas Profile Card -->
            <div class="side-card">
                <h4><i class="fas fa-user-tie" style="color: var(--primary);"></i> Wali Kelas Anda</h4>
                <div class="walas-profile">
                    @php
                        $walas = $siswa->walikelas;
                    @endphp
                    @if($walas)
                        <div class="walas-avatar">
                            {{ strtoupper(substr($walas->name, 0, 1)) }}
                        </div>
                        <div class="walas-name">{{ $walas->name }}</div>
                        <div class="walas-nip">NIP. {{ $walas->nip ?? '-' }}</div>
                        <div style="margin-top: 15px; font-size: 11px; color: #94a3b8; background: #f8fafc; padding: 8px 12px; border-radius: 8px;">
                            <i class="fas fa-envelope"></i> {{ $walas->email ?? '-' }}
                        </div>
                    @else
                        <div class="walas-avatar">
                            ?
                        </div>
                        <div class="walas-name" style="color: var(--text-muted);">Belum Ditugaskan</div>
                    @endif
                </div>
            </div>

            <!-- Achievement reporting banner -->
            <div class="side-card" style="padding: 10px;">
                <div class="cta-banner">
                    <h5>Ada Prestasi Baru? 🏆</h5>
                    <p>Laporkan setiap prestasi lomba akademis atau non-akademis Anda di sini agar diverifikasi sistem!</p>
                    <a href="/prestasi/create" class="btn-cta">Laporkan Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
