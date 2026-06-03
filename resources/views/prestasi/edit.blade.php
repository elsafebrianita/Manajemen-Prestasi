<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koreksi Data Prestasi - SMK N 1 TALAMAU</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --primary-teal: #26817d;
            --bg-cyan: #e6f7f6;
            --text-dark: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-cyan);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .container {
            width: 100%;
            max-width: 650px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 50px;
        }
        .header-section .label-top {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: var(--primary-teal);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 8px;
        }
        .header-section h1 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -1px;
            margin-bottom: 5px;
        }
        .header-section .school-name {
            display: block;
            font-size: 26px;
            color: var(--primary-teal);
            font-weight: 800;
            text-transform: uppercase;
        }

        .card {
            background: white;
            padding: 45px;
            border-radius: 40px;
            box-shadow: 0 30px 60px rgba(38, 129, 125, 0.08);
            border: 1px solid rgba(38, 129, 125, 0.1);
        }
        .card h2 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 35px;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--bg-cyan);
        }
        .card h2 i { color: #3b82f6; }

        .form-group { margin-bottom: 25px; }
        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 10px;
            color: #475569;
        }
        .input-wrapper { position: relative; }
        .input-wrapper i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-teal);
            opacity: 0.6;
        }
        input, select {
            width: 100%;
            padding: 18px 20px 18px 55px;
            border: 2px solid var(--bg-cyan);
            border-radius: 20px;
            font-size: 15px;
            background: #f8fafc;
            transition: 0.3s;
            color: var(--text-dark);
        }
        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-teal);
            background: white;
            box-shadow: 0 0 0 6px rgba(38, 129, 125, 0.08);
        }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .btn-update {
            background: var(--primary-teal);
            color: white;
            border: none;
            width: 100%;
            padding: 20px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            box-shadow: 0 15px 30px rgba(38, 129, 125, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        .btn-update:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(38, 129, 125, 0.4);
        }
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            color: #64748b;
            font-weight: 700;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <span class="label-top">Koreksi Data Akademik</span>
            <h1>PERBAHARUI DATA PRESTASI</h1>
            <span class="school-name">SMK N 1 TALAMAU</span>
        </div>

        <div class="card">
            <h2><i class="fas fa-edit"></i> Ubah Rincian Capaian</h2>
            
            @if ($errors->any())
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 14px;">
                    <strong style="display: block; margin-bottom: 5px;"><i class="fas fa-exclamation-triangle"></i> Ada beberapa kesalahan pengisian:</strong>
                    <ul style="margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/prestasi/update/{{ $prestasi->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-graduate"></i>
                        @if(auth()->user()->role == 'siswa')
                            <input type="text" name="siswa_name" list="students" value="{{ $siswa ? $siswa->nama . ' (' . $siswa->nis . ')' : '' }}" placeholder="Ketik nama atau NIS Anda..." required style="padding-left: 45px;">
                            <datalist id="students">
                                @if($siswa)
                                    <option value="{{ $siswa->nama }} ({{ $siswa->nis }})"></option>
                                @endif
                            </datalist>
                        @else
                            @php
                                $selected_siswa = $siswa->firstWhere('id', $prestasi->siswa_id);
                                $selected_val = $selected_siswa ? $selected_siswa->nama . ' (' . $selected_siswa->nis . ')' : '';
                            @endphp
                            <input type="text" name="siswa_name" list="students" value="{{ $selected_val }}" placeholder="Ketik nama atau NIS siswa..." required style="padding-left: 45px;">
                            <datalist id="students">
                                @foreach($siswa as $s)
                                    <option value="{{ $s->nama }} ({{ $s->nis }})"></option>
                                @endforeach
                            </datalist>
                        @endif
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Bidang Prestasi</label>
                        <div class="input-wrapper">
                            <i class="fas fa-layer-group"></i>
                            <select id="kategori_utama" required onchange="updateSubKategori()">
                                <option value="" disabled>Pilih Bidang...</option>
                                @foreach($kategori_utama as $utama)
                                    <option value="{{ $utama->id }}" {{ ($prestasi->kategori->parent_id ?? '') == $utama->id ? 'selected' : '' }}>
                                        {{ $utama->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Detail / Sub Bidang</label>
                        <div class="input-wrapper">
                            <i class="fas fa-tags"></i>
                            <select name="kategori_id" id="kategori_sub" required>
                                <option value="" disabled>Pilih Bidang Dulu...</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Prestasi / Lomba</label>
                    <div class="input-wrapper">
                        <i class="fas fa-trophy"></i>
                        <input type="text" name="nama_prestasi" value="{{ $prestasi->nama_prestasi }}" required>
                    </div>
                </div>

                <div class="grid-2" id="normal_prestasi_fields">
                    <div class="form-group">
                        <label>Tingkat Lomba</label>
                        <div class="input-wrapper">
                            <i class="fas fa-globe"></i>
                            <select name="tingkat" id="tingkat_select" required>
                                <option value="Kecamatan" {{ $prestasi->tingkat == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                <option value="Kabupaten" {{ $prestasi->tingkat == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                <option value="Provinsi" {{ $prestasi->tingkat == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                <option value="Nasional" {{ $prestasi->tingkat == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="Internasional" {{ $prestasi->tingkat == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Hasil / Juara</label>
                        <div class="input-wrapper">
                            <i class="fas fa-award"></i>
                            <select name="juara" id="juara_select" required>
                                <option value="Juara 1" {{ $prestasi->juara == 'Juara 1' ? 'selected' : '' }}>Juara 1</option>
                                <option value="Juara 2" {{ $prestasi->juara == 'Juara 2' ? 'selected' : '' }}>Juara 2</option>
                                <option value="Juara 3" {{ $prestasi->juara == 'Juara 3' ? 'selected' : '' }}>Juara 3</option>
                                <option value="Harapan 1" {{ $prestasi->juara == 'Harapan 1' ? 'selected' : '' }}>Harapan 1</option>
                                <option value="Harapan 2" {{ $prestasi->juara == 'Harapan 2' ? 'selected' : '' }}>Harapan 2</option>
                                <option value="Harapan 3" {{ $prestasi->juara == 'Harapan 3' ? 'selected' : '' }}>Harapan 3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Field Khusus Organisasi (Jabatan) -->
                <div class="form-group" id="organisasi_fields" style="display: none;">
                    <label>Jabatan di Organisasi</label>
                    <div class="input-wrapper">
                        <i class="fas fa-users-cog"></i>
                        <select id="jabatan_organisasi_select">
                            <option value="" disabled>Pilih Jabatan...</option>
                            <option value="Ketua" {{ strtolower($prestasi->juara) == 'ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="Wakil Ketua" {{ in_array(strtolower($prestasi->juara), ['wakil ketua', 'wakil_ketua']) ? 'selected' : '' }}>Wakil Ketua</option>
                            <option value="Sekretaris" {{ strtolower($prestasi->juara) == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                            <option value="Bendahara" {{ strtolower($prestasi->juara) == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                            <option value="Anggota" {{ strtolower($prestasi->juara) == 'anggota' ? 'selected' : '' }}>Anggota</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Tanggal Capaian</label>
                        <div class="input-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" name="tanggal_capaian" value="{{ $prestasi->tanggal_capaian }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Lomba / Organisasi</label>
                        <div class="input-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="lokasi" value="{{ $prestasi->lokasi }}" placeholder="Misal: Padang, Aula Dinas Pendidikan" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Unggah Sertifikat / Bukti Baru (PDF Saja)</label>
                    <div class="input-wrapper">
                        <i class="fas fa-file-upload"></i>
                        <input type="file" name="sertifikat" accept="application/pdf">
                    </div>
                    @if($prestasi->sertifikat)
                        <small style="color: #10b981; font-size: 11px; margin-top: 5px; display: block;">
                            <i class="fas fa-check-circle"></i> File saat ini: <a href="{{ asset('uploads/sertifikat/' . $prestasi->sertifikat) }}" target="_blank" style="color: var(--primary-teal); font-weight: 700; text-decoration: underline;">{{ $prestasi->sertifikat }}</a> (Biarkan kosong jika tidak ingin mengubah)
                        </small>
                    @endif
                    <small style="color: #64748b; font-size: 11px; margin-top: 5px; display: block;">Format: PDF Saja (digabungkan dalam satu file PDF jika lembar sertifikat lebih dari satu). Maksimal 2MB.</small>
                </div>

                <button type="submit" class="btn-update">
                    <span>Perbaharui Data</span>
                    <i class="fas fa-sync-alt"></i>
                </button>
            </form>

            <a href="/prestasi" class="btn-back">← Batalkan dan Kembali</a>
        </div>
    </div>
    <script>
        const dataKategori = @json($kategori_utama);
        const selectedSubKategori = "{{ $prestasi->kategori_id }}";

        function updateSubKategori() {
            const utamaSelect = document.getElementById('kategori_utama');
            const utamaId = utamaSelect.value;
            const subSelect = document.getElementById('kategori_sub');
            
            subSelect.innerHTML = '<option value="" disabled>Pilih Bidang...</option>';
            
            if (utamaId) {
                const selectedUtama = dataKategori.find(k => k.id == utamaId);
                const selectedText = utamaSelect.options[utamaSelect.selectedIndex].text.trim().toLowerCase();

                // 1. Rapor Redirect Behavior
                if (selectedText === 'rapor') {
                    alert('Nilai Rapor diinput oleh Guru Mapel / Wali Kelas. Anda hanya dapat melihat nilai rapor di halaman Nilai Rapor.');
                    window.location.href = '/nilai-rapor';
                    return;
                }

                if (selectedUtama && selectedUtama.children && selectedUtama.children.length > 0) {
                    selectedUtama.children.forEach(child => {
                        const option = document.createElement('option');
                        option.value = child.id;
                        option.textContent = child.nama_kategori;
                        if (child.id == selectedSubKategori) {
                            option.selected = true;
                        }
                        subSelect.appendChild(option);
                    });
                    subSelect.disabled = false;
                } else {
                    subSelect.innerHTML = '<option value="" disabled>Tidak ada bidang tersedia</option>';
                    subSelect.disabled = true;
                }

                // 2. Organisasi Fields Toggle Behavior
                const normalFields = document.getElementById('normal_prestasi_fields');
                const organisasiFields = document.getElementById('organisasi_fields');
                const juaraSelect = document.getElementById('juara_select');
                const tingkatSelect = document.getElementById('tingkat_select');
                const jabatanOrganisasiSelect = document.getElementById('jabatan_organisasi_select');

                if (selectedText === 'organisasi') {
                    normalFields.style.display = 'none';
                    organisasiFields.style.display = 'block';

                    juaraSelect.required = false;
                    juaraSelect.disabled = true;
                    juaraSelect.name = 'juara_disabled';

                    // Keep tingkat enabled so it submits, but set to default Kecamatan (valid)
                    tingkatSelect.required = true;
                    if (!tingkatSelect.value) {
                        tingkatSelect.value = 'Kecamatan';
                    }

                    jabatanOrganisasiSelect.required = true;
                    jabatanOrganisasiSelect.disabled = false;
                    jabatanOrganisasiSelect.name = 'juara';
                } else {
                    normalFields.style.display = 'grid';
                    organisasiFields.style.display = 'none';

                    juaraSelect.required = true;
                    juaraSelect.disabled = false;
                    juaraSelect.name = 'juara';

                    tingkatSelect.required = true;

                    jabatanOrganisasiSelect.required = false;
                    jabatanOrganisasiSelect.disabled = true;
                    jabatanOrganisasiSelect.name = 'jabatan_organisasi_disabled';
                }
            } else {
                subSelect.innerHTML = '<option value="" disabled>Pilih Kategori Dulu...</option>';
                subSelect.disabled = true;
            }
        }

        // Initialize dropdown state on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSubKategori();
        });
    </script>
</body>
</html>