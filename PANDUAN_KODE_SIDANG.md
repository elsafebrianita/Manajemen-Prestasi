# 🗺️ PANDUAN STRUKTUR KODE PROGRAM (UNTUK DEMO SIDANG)

Dokumen ini adalah **peta penunjuk jalan** Anda saat demo aplikasi di depan Dosen Penguji. Jika penguji meminta Anda menunjukkan kode untuk fitur tertentu, Anda tinggal membuka panduan ini di VS Code dan melihat letak file Route, Controller, Model, dan View-nya.

---

## 🏛️ Arsitektur MVC Aplikasi
Aplikasi ini menggunakan pola **MVC (Model-View-Controller)** dengan framework **Laravel**:
1. **Model** (`app/Models/`): Mengatur data dan relasi tabel database.
2. **View** (`resources/views/`): Mengatur tampilan antarmuka (UI) menggunakan Blade engine. Sekarang sudah dikelompokkan dengan sangat rapi berdasarkan **Peran (Role)** dan folder-folder kosong yang berisi 1 file saja sudah diratakan agar nama filenya jelas di tab editor VS Code Anda.
3. **Controller** (`app/Http/Controllers/`): Mengatur logika bisnis dan alur aplikasi. Sekarang sudah terbagi rapi untuk masing-masing peran!
4. **Route** (`routes/web.php`): Mengatur URL alamat halaman aplikasi.

---

## 👥 Pemetaan Kode Berdasarkan Peran (User Role)

### 1. 🛡️ ADMINISTRATOR (ADMIN)
Digunakan untuk mengelola master data sekolah, akun pengguna, dan bobot penilaian.

| Fitur | Alamat URL (Route) | Controller & Method | Model Terkait | Letak File View (Tampilan) |
| :--- | :--- | :--- | :--- | :--- |
| **Kelola Data Guru** | `/admin/guru` | `AdminController@adminGuru` | `User.php` | `admin/guru.blade.php` |
| **Kelola Data Kelas** | `/admin/kelas` | `AdminController@adminKelas` | `Kelas.php` | `admin/kelas.blade.php` |
| **Kelola Data Mapel** | `/admin/mapel` | `AdminController@adminMapel` | `Mapel.php` | `admin/mapel.blade.php` |
| **Kelola Relasi Guru & Mapel** | `/admin/relasi` | `AdminController@adminRelasi` | `GuruMapel.php` | `admin/relasi.blade.php` |
| **Kelola Akun User** | `/admin/user` | `AdminController@adminUser` | `User.php` | `admin/user.blade.php` |
| **Verifikasi Pendaftaran Akun** | `/admin/verifikasi-akun` | `UserVerificationController` | `User.php` | `admin/verify_users.blade.php` |
| **Kelola Data Siswa** | `/siswa` | `SiswaController` | `Siswa.php` | `admin/siswa/` (index, create, edit, import) |
| **Kelola Kategori Prestasi** | `/kategori` | `KategoriPrestasiController` | `KategoriPrestasi.php` | `admin/kategori/` (index, create, show) |
| **Pengaturan Bobot KPI** | `/penilaian/settings` | `PenilaianController@settings` | `KpiSetting.php` | `admin/penilaian_settings.blade.php` |
| **Kirim Notifikasi Massal** | `/notifikasi` | `NotifikasiController@create` | `Notification.php` | `admin/notifikasi/create.blade.php` |
| **Riwayat Notifikasi Keluar** | `/notifikasi/riwayat` | `NotifikasiController@riwayat` | `Notification.php` | `admin/notifikasi/riwayat.blade.php` |
| **Cetak Rekap Laporan Akhir** | `/laporan` | `LaporanController@index` | `Penilaian.php` | `admin/laporan.blade.php` |

---

### 2. 🎓 SISWA
Halaman antarmuka untuk siswa mengajukan prestasi dan melihat hasil rapor/bakat mereka.

| Fitur | Alamat URL (Route) | Controller & Method | Model Terkait | Letak File View (Tampilan) |
| :--- | :--- | :--- | :--- | :--- |
| **Dashboard Siswa** | `/dashboard` | `DashboardController@index` | `Siswa.php` | `dashboard.blade.php` |
| **Input & Riwayat Prestasi** | `/prestasi` & `/prestasi/riwayat` | `PrestasiController` | `Prestasi.php` | `siswa/prestasi/` (index, create, riwayat, edit) |
| **Lihat Nilai Rapor** | `/nilai-rapor` | `PenilaianController@rapor` | `NilaiSiswa.php` | `siswa/rapor.blade.php` |
| **Lihat Dominasi Bakat** | `/hasil-bakat` | `PenilaianController@hasilBakat` | `Penilaian.php` | `walikelas/penilaian/bakat.blade.php` |
| **Kotak Masuk Notifikasi** | `/notifikasi/siswa` | `NotifikasiController@siswaIndex` | `Notification.php` | `siswa/notifikasi.blade.php` |
| **Pengajuan Bimbingan BK** | `/siswa/bimbingan` | `NotifikasiController@siswaBimbingan` | `KonsultasiBk.php` | `siswa/bimbingan.blade.php` |

---

### 3. 📝 GURU MATA PELAJARAN
Guru yang mengajar mata pelajaran tertentu di kelas dan menginput nilai siswa.

| Fitur | Alamat URL (Route) | Controller & Method | Model Terkait | Letak File View (Tampilan) |
| :--- | :--- | :--- | :--- | :--- |
| **Lihat Mapel Saya** | `/guru/mapel` | `GuruController@guruMapelSaya` | `GuruMapel.php` | `guru/mapel.blade.php` |
| **Lihat Kelas Diajar** | `/guru/kelas` | `GuruController@guruKelasDiajar` | `GuruMapel.php` | `guru/kelas.blade.php` |
| **Lihat Daftar Siswa** | `/guru/siswa` | `GuruController@guruSiswa` | `Siswa.php` | `guru/siswa.blade.php` |
| **Input Nilai Rapor Siswa** | `/guru/nilai` | `GuruController@guruInputNilai` | `NilaiSiswa.php` | `guru/nilai.blade.php` |

---

### 4. 🗂️ WALI KELAS
Mengelola data kelas perwaliannya, menghitung skor KPI prestasi, serta melakukan finalisasi rapor.

| Fitur | Alamat URL (Route) | Controller & Method | Model Terkait | Letak File View (Tampilan) |
| :--- | :--- | :--- | :--- | :--- |
| **Lihat Siswa Binaan** | `/walikelas/siswa` | `WaliKelasController@walikelasSiswa` | `Siswa.php` | `walikelas/siswa/index.blade.php` |
| **Lihat Ranking KPI Kelas**| `/walikelas/kpi` | `WaliKelasController@walikelasKpi` | `Penilaian.php` | `walikelas/kpi.blade.php` |
| **Kalkulasi Skor KPI AHP/SAW**| `/penilaian` | `PenilaianController@index` | `Penilaian.php` | `walikelas/penilaian/index.blade.php` |
| **Form Penilaian KPI Siswa** | `/penilaian/create/{id}` | `PenilaianController@create` | `Penilaian.php` | `walikelas/penilaian/create.blade.php` |
| **Detail Nilai KPI Siswa** | `/penilaian/show/{id}` | `PenilaianController@show` | `Penilaian.php` | `walikelas/penilaian/show.blade.php` |
| **Perhitungan Matematika KPI**| `/kpi` | `PenilaianController@perhitungan` | `Penilaian.php` | `walikelas/penilaian/perhitungan.blade.php` |
| **Evaluasi Hasil Bakat** | `/walikelas/evaluasi` | `WaliKelasController@walikelasEvaluasi` | `Penilaian.php` | `walikelas/evaluasi.blade.php` |
| **Lihat Grafik Perkembangan** | `/walikelas/grafik` | `WaliKelasController@walikelasGrafik` | `Penilaian.php` | `walikelas/grafik.blade.php` |
| **Kelola Rapor Kelas** | `/walikelas/rapor` | `WaliKelasController@walikelasRapor` | `NilaiSiswa.php` | `walikelas/rapor/index.blade.php` |

---

### 5. 🩺 GURU BIMBINGAN KONSELING (BK)
Guru BK memantau perkembangan kerawanan siswa, melakukan pembinaan, dan mengidentifikasi minat bakat.

| Fitur | Alamat URL (Route) | Controller & Method | Model Terkait | Letak File View (Tampilan) |
| :--- | :--- | :--- | :--- | :--- |
| **Dashboard Guru BK** | `/guru-bk` | `GuruBkController@index` | `Penilaian.php` | `guru_bk/dashboard.blade.php` |
| **Monitoring Kondisi Siswa** | `/guru-bk/monitoring` | `GuruBkController@monitoring` | `Siswa.php` | `guru_bk/monitoring.blade.php` |
| **Kelola Pembinaan/Konsultasi**| `/guru-bk/pembinaan` | `GuruBkController@pembinaan` | `BimbinganBk.php` | `guru_bk/pembinaan.blade.php` |
| **Riwayat Pembinaan BK** | `/guru-bk/riwayat` | `GuruBkController@riwayat` | `BimbinganBk.php` | `guru_bk/riwayat.blade.php` |
| **Pemetaan Bakat Siswa** | `/guru-bk/bakat` | `GuruBkController@bakat` | `Penilaian.php` | `guru_bk/bakat.blade.php` |

---

### 6. 🎖️ WAKIL KESISWAAN (WAKASISWA)
Melakukan validasi (verifikasi) pengajuan sertifikat prestasi yang dimasukkan oleh siswa.

| Fitur | Alamat URL (Route) | Controller & Method | Model Terkait | Letak File View (Tampilan) |
| :--- | :--- | :--- | :--- | :--- |
| **Validasi Prestasi Baru** | `/wakasiswa/validasi` | `WakasiswaController@validasi` | `Prestasi.php` | `wakasiswa/validasi.blade.php` |
| **Rekap Semua Data Prestasi**| `/wakasiswa/data-prestasi` | `WakasiswaController@dataPrestasi` | `Prestasi.php` | `wakasiswa/data_prestasi.blade.php` |
| **Riwayat Validasi** | `/wakasiswa/riwayat-validasi` | `WakasiswaController@riwayatValidasi` | `Prestasi.php` | `wakasiswa/riwayat_validasi.blade.php` |

---

### 7. 📢 HUMAS
Mengajukan berita prestasi siswa yang terverifikasi agar dapat dipublikasikan di Landing Page utama.

| Fitur | Alamat URL (Route) | Controller & Method | Model Terkait | Letak File View (Tampilan) |
| :--- | :--- | :--- | :--- | :--- |
| **Dashboard Humas** | `/humas` | `HumasController@index` | `Penilaian.php` | `humas/dashboard.blade.php` |
| **Usulan Berita Prestasi** | `/humas/usulan` | `HumasController@usulan` | `Prestasi.php` | `humas/usulan.blade.php` |
| **Riwayat Publikasi Humas** | `/humas/riwayat` | `HumasController@riwayat` | `Prestasi.php` | `humas/riwayat.blade.php` |
| **Galeri Prestasi** | `/humas/prestasi` | `HumasController@prestasi` | `Prestasi.php` | `humas/prestasi.blade.php` |
| **Laporan Statistik Humas** | `/humas/laporan` | `HumasController@laporan` | `Penilaian.php` | `humas/laporan.blade.php` |

---

### 8. 👑 KEPALA SEKOLAH (KEPSEK)
Menerima dan memberikan persetujuan (ACC) atas rekomendasi program bakat siswa yang dikirimkan oleh Wali Kelas.

| Fitur | Alamat URL (Route) | Controller & Method | Model Terkait | Letak Letak File View (Tampilan) |
| :--- | :--- | :--- | :--- | :--- |
| **Dashboard Kepsek (ACC)** | `/kepsek` | `KepsekController@index` | `Penilaian.php` | `kepsek/dashboard_grafik.blade.php` |
| **Detail Nilai & Prestasi** | `/kepsek/siswa/{id}` | `KepsekController@show` | `Siswa.php` | `kepsek/show.blade.php` |
| **Kelola Publikasi Berita** | `/admin/publikasi` | `KepsekController@adminPublikasi` | `Penilaian.php` | `kepsek/admin_publikasi.blade.php` |

---

> 💡 **TIPS SIDANG**: 
> - Gunakan tombol pencarian file di VS Code (`Ctrl + P` di Windows) lalu ketikkan nama file view di atas untuk membukanya dengan cepat di depan dosen penguji!
