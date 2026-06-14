<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriPrestasiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\WakasiswaController;
use App\Http\Controllers\GuruBkController;

// HALAMAN AWAL
// =====================
Route::get('/', [LandingController::class, 'index']);

// =====================
// AUTH
// =====================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// =====================
// LOGIN REQUIRED
// =====================
Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/update-foto-profil', [DashboardController::class, 'updateFotoProfil'])->name('update-foto-profil');

    // =====================
    // KATEGORI (FIX - HANYA VIEW + DETAIL)
    // =====================
    Route::get('/kategori', [KategoriPrestasiController::class, 'index']);
    Route::get('/kategori/create', [KategoriPrestasiController::class, 'create']);
    Route::post('/kategori/store', [KategoriPrestasiController::class, 'store']);
    Route::get('/kategori/show/{id}', [KategoriPrestasiController::class, 'show']);

    // =====================
    // PRESTASI
    // =====================
    Route::get('/prestasi', [PrestasiController::class, 'index']);
    Route::get('/prestasi/riwayat', [PrestasiController::class, 'riwayat']);
    Route::get('/prestasi/create', [PrestasiController::class, 'create']);
    Route::post('/prestasi/store', [PrestasiController::class, 'store']);
    Route::get('/prestasi/edit/{id}', [PrestasiController::class, 'edit']);
    Route::post('/prestasi/update/{id}', [PrestasiController::class, 'update']);
    Route::get('/prestasi/delete/{id}', [PrestasiController::class, 'destroy']);
    Route::post('/prestasi/verifikasi/{id}', [PrestasiController::class, 'verifikasi']);

    // =====================
    // SISWA
    // =====================
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::get('/siswa/create', [SiswaController::class, 'create']);
    Route::post('/siswa/store', [SiswaController::class, 'store']);
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit']);
    Route::post('/siswa/update/{id}', [SiswaController::class, 'update']);
    Route::get('/siswa/delete/{id}', [SiswaController::class, 'destroy']);
    Route::get('/siswa/template', [SiswaController::class, 'template']);
    Route::get('/siswa/import', [SiswaController::class, 'importForm']);
    Route::post('/siswa/import', [SiswaController::class, 'importExcel']);

    // =====================
    // PENILAIAN (KPI)
    // =====================
    Route::get('/penilaian', [PenilaianController::class, 'index']);
    Route::get('/penilaian/create/{siswa_id}', [PenilaianController::class, 'create']);
    Route::post('/penilaian/store', [PenilaianController::class, 'store']);
    Route::get('/penilaian/show/{id}', [PenilaianController::class, 'show']);
    Route::post('/penilaian/acc/{id}', [PenilaianController::class, 'acc']);
    Route::post('/penilaian/siswa-store', [PenilaianController::class, 'siswaStore']);
    Route::get('/penilaian/proses-kpi', [PenilaianController::class, 'prosesKpi']);
    Route::get('/penilaian/settings', [PenilaianController::class, 'settings']);
    Route::post('/penilaian/settings/update', [PenilaianController::class, 'updateSettings']);
    Route::post('/penilaian/notification/store', [PenilaianController::class, 'storeNotification']);
    Route::get('/kpi', [PenilaianController::class, 'perhitungan']);
    Route::get('/nilai-rapor', [PenilaianController::class, 'rapor']);
    Route::get('/hasil-bakat', [PenilaianController::class, 'hasilBakat']);
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/penilaian/delete/{id}', [PenilaianController::class, 'destroy']);

    // =====================
    // NOTIFIKASI
    // =====================
    Route::get('/notifikasi', [NotifikasiController::class, 'create']);
    Route::post('/notifikasi/store', [NotifikasiController::class, 'store']);
    Route::get('/notifikasi/riwayat', [NotifikasiController::class, 'riwayat']);
    Route::get('/notifikasi/siswa', [NotifikasiController::class, 'siswaIndex']);
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead']);
    Route::get('/siswa/bimbingan', [NotifikasiController::class, 'siswaBimbingan'])->name('siswa.bimbingan');
    Route::post('/siswa/bimbingan/store', [NotifikasiController::class, 'siswaBimbinganStore'])->name('siswa.bimbingan.store');
    // =====================
    // KEPSEK
    // =====================
    Route::get('/kepsek', [KepsekController::class, 'index']);
    Route::get('/kepsek/siswa/{id}', [KepsekController::class, 'show']);
    Route::post('/kepsek/keputusan/{id}', [KepsekController::class, 'keputusan']);
    Route::post('/kepsek/publish/{id}', [KepsekController::class, 'publish']);
    Route::get('/admin/publikasi', [KepsekController::class, 'adminPublikasi']);
    Route::get('/kepsek/edit-berita/{id}', [KepsekController::class, 'editBerita']);
    Route::post('/kepsek/simpan-berita/{id}', [KepsekController::class, 'simpanBerita']);

    // =====================
    // VERIFIKASI AKUN
    // =====================
    Route::get('/admin/verifikasi-akun', [UserVerificationController::class, 'index']);
    Route::post('/admin/verifikasi-akun/{id}', [UserVerificationController::class, 'verify']);
    Route::delete('/admin/verifikasi-akun/{id}/tolak', [UserVerificationController::class, 'reject']);

    // ==========================================
    // NEW ACADEMIC / ROLE ROUTING
    // ==========================================
    
    // Admin - Manage Guru
    Route::get('/admin/guru', [AdminController::class, 'adminGuru']);
    Route::post('/admin/guru/store', [AdminController::class, 'storeGuru']);
    Route::post('/admin/guru/import', [AdminController::class, 'importGuru']);
    Route::post('/admin/guru/update/{id}', [AdminController::class, 'updateGuru']);
    Route::get('/admin/guru/delete/{id}', [AdminController::class, 'destroyGuru']);

    // Admin - Manage Kelas
    Route::get('/admin/kelas', [AdminController::class, 'adminKelas']);
    Route::post('/admin/kelas/store', [AdminController::class, 'storeKelas']);
    Route::post('/admin/kelas/update/{id}', [AdminController::class, 'updateKelas']);
    Route::post('/admin/kelas/assign-walikelas/{id}', [AdminController::class, 'assignWaliKelas']);
    Route::get('/admin/kelas/delete/{id}', [AdminController::class, 'destroyKelas']);

    // Admin - Manage Mapel
    Route::get('/admin/mapel', [AdminController::class, 'adminMapel']);
    Route::post('/admin/mapel/store', [AdminController::class, 'storeMapel']);
    Route::post('/admin/mapel/update/{id}', [AdminController::class, 'updateMapel']);
    Route::get('/admin/mapel/delete/{id}', [AdminController::class, 'destroyMapel']);

    // Admin - Manage Relasi Guru & Mapel
    Route::get('/admin/relasi', [AdminController::class, 'adminRelasi']);
    Route::post('/admin/relasi/store', [AdminController::class, 'storeRelasi']);
    Route::get('/admin/relasi/delete/{id}', [AdminController::class, 'destroyRelasi']);

    // Admin - Manage Users
    Route::get('/admin/user', [AdminController::class, 'adminUser']);
    Route::post('/admin/user/store', [AdminController::class, 'storeUser']);
    Route::post('/admin/user/update/{id}', [AdminController::class, 'updateUser']);
    Route::get('/admin/user/delete/{id}', [AdminController::class, 'destroyUser']);

    // GURU MATA PELAJARAN
    Route::get('/guru/mapel', [GuruController::class, 'guruMapelSaya']);
    Route::get('/guru/kelas', [GuruController::class, 'guruKelasDiajar']);
    Route::get('/guru/siswa', [GuruController::class, 'guruSiswa']);
    Route::get('/guru/nilai', [GuruController::class, 'guruInputNilai']);
    Route::post('/guru/nilai/store', [GuruController::class, 'guruStoreNilai']);

    // WALI KELAS
    Route::get('/walikelas/siswa', [WaliKelasController::class, 'walikelasSiswa']);
    Route::get('/walikelas/kpi', [WaliKelasController::class, 'walikelasKpi']);
    Route::post('/walikelas/kpi/kalkulasi', [WaliKelasController::class, 'walikelasKalkulasiKpi']);
    Route::post('/walikelas/kpi/rekomendasi/{id}', [WaliKelasController::class, 'walikelasRekomendasiKpi']);
    Route::get('/walikelas/evaluasi', [WaliKelasController::class, 'walikelasEvaluasi']);
    Route::get('/walikelas/grafik', [WaliKelasController::class, 'walikelasGrafik']);
    Route::get('/walikelas/rapor', [WaliKelasController::class, 'walikelasRapor']);
    Route::post('/walikelas/rapor/finalisasi', [WaliKelasController::class, 'walikelasFinalisasiRapor']);
    Route::get('/walikelas/rata-nilai', [WaliKelasController::class, 'walikelasRataNilai']);
    Route::get('/walikelas/prestasi-siswa', [WaliKelasController::class, 'walikelasPrestasiSiswa']);
    Route::get('/walikelas/siswa/{siswa_id}/rapor', [WaliKelasController::class, 'walikelasSiswaRapor']);
    Route::get('/walikelas/siswa/{siswa_id}/nilai/edit', [WaliKelasController::class, 'walikelasEditNilai']);
    Route::post('/walikelas/siswa/{siswa_id}/nilai/update', [WaliKelasController::class, 'walikelasUpdateNilai']);
    Route::post('/walikelas/siswa/{siswa_id}/nilai/delete', [WaliKelasController::class, 'walikelasDeleteNilai']);

    // WAKIL KESISWAAN
    Route::get('/wakasiswa/validasi', [WakasiswaController::class, 'validasi']);
    Route::get('/wakasiswa/data-prestasi', [WakasiswaController::class, 'dataPrestasi']);
    Route::get('/wakasiswa/riwayat-validasi', [WakasiswaController::class, 'riwayatValidasi']);
    Route::post('/wakasiswa/verifikasi/{id}', [WakasiswaController::class, 'verifikasi']);

    // HUMAS
    Route::get('/humas', [\App\Http\Controllers\HumasController::class, 'index']);
    Route::get('/humas/usulan', [\App\Http\Controllers\HumasController::class, 'usulan']);
    Route::post('/humas/usulan/propose/{id}', [\App\Http\Controllers\HumasController::class, 'propose']);
    Route::get('/humas/riwayat', [\App\Http\Controllers\HumasController::class, 'riwayat']);
    Route::get('/humas/prestasi', [\App\Http\Controllers\HumasController::class, 'prestasi']);
    Route::get('/humas/laporan', [\App\Http\Controllers\HumasController::class, 'laporan']);

    // GURU BIMBINGAN KONSELING (BK)
    Route::prefix('guru-bk')->group(function () {
        Route::get('/', [GuruBkController::class, 'index'])->name('guru-bk.dashboard');
        Route::get('/monitoring', [GuruBkController::class, 'monitoring'])->name('guru-bk.monitoring');
        Route::get('/detail/{siswa_id}', [GuruBkController::class, 'detail'])->name('guru-bk.detail');
        Route::get('/pembinaan', [GuruBkController::class, 'pembinaan'])->name('guru-bk.pembinaan');
        Route::post('/pembinaan/store', [GuruBkController::class, 'storePembinaan'])->name('guru-bk.pembinaan.store');
        Route::get('/riwayat', [GuruBkController::class, 'riwayat'])->name('guru-bk.riwayat');
        Route::get('/bakat', [GuruBkController::class, 'bakat'])->name('guru-bk.bakat');
        Route::post('/konsultasi/acc/{id}', [GuruBkController::class, 'accKonsultasi'])->name('guru-bk.konsultasi.acc');
    });

});
