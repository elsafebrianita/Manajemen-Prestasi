@extends('layouts.app')

@section('title', 'Catat Pembinaan Siswa - SIMPRES')
@section('page_title', 'Catat Pembinaan Siswa')

@section('content')
<div style="max-width: 750px; margin: 0 auto;">
    <div style="margin-bottom: 25px;">
        <a href="/guru-bk" style="padding: 10px 20px; border-radius: 12px; background: white; color: #0f766e; border: 1px solid #e2e8f0; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.02);" onmouseover="this.style.background='#f8fafc'; this.style.transform='translateX(-3px)'" onmouseout="this.style.background='white'; this.style.transform='translateX(0)'">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if($errors->any())
        <div style="background: #fef2f2; color: #b91c1c; padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; border-left: 5px solid #ef4444; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);">
            <ul style="margin: 0; padding-left: 20px; font-size: 13px; font-weight: 600;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: white; border-radius: 25px; padding: 35px; box-shadow: 0 4px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0, 0, 0, 0.04);">
        <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 30px;">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-user-shield" style="color: #0f766e; font-size: 24px;"></i> Form Pembinaan BK
            </h3>
            <p style="font-size: 13px; color: #64748b; margin-top: 5px;">Gunakan form ini untuk mencatat hasil pembinaan bimbingan konseling, disiplin, maupun arahan akademik bagi siswa.</p>
        </div>

        <form action="{{ route('guru-bk.pembinaan.store') }}" method="POST" style="margin: 0;">
            @csrf

            @if(isset($konsultasiId))
                <input type="hidden" name="konsultasi_id" value="{{ $konsultasiId }}">
                @php
                    $konsul = \App\Models\KonsultasiBk::find($konsultasiId);
                @endphp
                @if($konsul)
                    <div style="background: #f0f9ff; border: 1px solid #bae6fd; padding: 15px; border-radius: 12px; margin-bottom: 22px; font-size: 13px; color: #0369a1; line-height: 1.5;">
                        <i class="fas fa-info-circle"></i> <strong>Memproses Pengajuan Bimbingan:</strong><br>
                        <span style="font-weight: 700; color: #0f766e;">Kategori:</span> {{ str_replace('_', ' ', ucfirst($konsul->tipe_konsultasi)) }}<br>
                        <span style="font-weight: 700; color: #0f766e;">Keluhan Siswa:</span> "{{ $konsul->keluhan }}"
                    </div>
                @endif
            @endif

            <!-- NAMA SISWA -->
            <div style="margin-bottom: 22px;">
                <label for="siswa_id" style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 10px;">Nama Siswa</label>
                <select name="siswa_id" id="siswa_id" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; font-size: 14px; font-weight: 600; color: #1e293b; background-color: #f8fafc; cursor: pointer;" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}" @selected(old('siswa_id', $siswaId) == $siswa->id)>{{ $siswa->nama }} (Kelas: {{ $siswa->kelas }})</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 22px;">
                <!-- TANGGAL -->
                <div>
                    <label for="tanggal" style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 10px;">Tanggal Pembinaan</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; font-size: 14px; color: #1e293b;" required>
                </div>

                <!-- JENIS PEMBINAAN -->
                <div>
                    <label for="jenis_pembinaan" style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 10px;">Jenis Pembinaan</label>
                    <select name="jenis_pembinaan" id="jenis_pembinaan" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; font-size: 14px; font-weight: 600; color: #1e293b; background-color: #f8fafc; cursor: pointer;" required>
                        <option value="akademik" @selected(old('jenis_pembinaan') === 'akademik')>Akademik</option>
                        <option value="non_akademik" @selected(old('jenis_pembinaan') === 'non_akademik')>Non Akademik</option>
                        <option value="disiplin" @selected(old('jenis_pembinaan') === 'disiplin')>Disiplin</option>
                    </select>
                </div>
            </div>

            <!-- CATATAN PEMBINAAN -->
            <div style="margin-bottom: 22px;">
                <label for="catatan" style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 10px;">Catatan Pembinaan</label>
                <textarea name="catatan" id="catatan" placeholder="Tuliskan isi pembinaan, masalah yang dihadapi siswa, serta solusi/arahan yang diberikan oleh Guru BK..." style="width: 100%; height: 150px; padding: 15px; border-radius: 15px; border: 1px solid #cbd5e1; outline: none; font-size: 14px; font-family: inherit; resize: vertical; line-height: 1.6; transition: border-color 0.3s;" onfocus="this.style.borderColor='#0f766e'" required>{{ old('catatan') }}</textarea>
            </div>

            <!-- REKOMENDASI BK -->
            <div style="margin-bottom: 25px; background: #f8fafc; border: 1px dashed #cbd5e1; padding: 20px; border-radius: 18px;">
                <h4 style="font-size: 14px; font-weight: 700; color: #0f766e; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-lightbulb"></i> Rekomendasi Minat & Bakat (Opsional)
                </h4>
                
                <div style="margin-bottom: 15px;">
                    <label for="rekomendasi_lomba" style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px;">Rekomendasi Lomba / Ajang Prestasi</label>
                    <input type="text" name="rekomendasi_lomba" id="rekomendasi_lomba" placeholder="Misal: Lomba Karya Tulis Ilmiah Nasional, Olimpiade Matematika" value="{{ old('rekomendasi_lomba') }}" style="width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; color: #1e293b;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="rekomendasi_organisasi" style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px;">Rekomendasi Organisasi / Ekstrakurikuler</label>
                    <input type="text" name="rekomendasi_organisasi" id="rekomendasi_organisasi" placeholder="Misal: OSIS (Ketua/Sekretaris), Pramuka, Paskibra" value="{{ old('rekomendasi_organisasi') }}" style="width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; color: #1e293b;">
                </div>

                <div>
                    <label for="rekomendasi_pengembangan" style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px;">Rekomendasi Pengembangan Diri Lainnya</label>
                    <input type="text" name="rekomendasi_pengembangan" id="rekomendasi_pengembangan" placeholder="Misal: Kelas pemrograman web, pelatihan public speaking" value="{{ old('rekomendasi_pengembangan') }}" style="width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid #cbd5e1; outline: none; font-size: 13px; color: #1e293b;">
                </div>
            </div>

            <!-- STATUS -->
            <div style="margin-bottom: 35px;">
                <label for="status" style="display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 10px;">Status Perkembangan</label>
                <select name="status" id="status" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; font-size: 14px; font-weight: 600; color: #1e293b; background-color: #f8fafc; cursor: pointer;" required>
                    <option value="proses" @selected(old('status') === 'proses')>Dalam Proses (Memerlukan pemantauan lanjut)</option>
                    <option value="selesai" @selected(old('status') === 'selesai')>Selesai (Masalah teratasi/pembinaan rampung)</option>
                </select>
            </div>

            <!-- BUTTONS -->
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <a href="/guru-bk/monitoring" style="padding: 14px 25px; border-radius: 12px; border: 1px solid #cbd5e1; color: #475569; text-decoration: none; font-size: 14px; font-weight: 700; text-align: center; transition: all 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    Batal
                </a>
                <button type="submit" style="padding: 14px 30px; border-radius: 12px; background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); color: white; border: none; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(15, 118, 110, 0.2);" onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'" onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                    <i class="fas fa-save" style="margin-right: 8px;"></i> Simpan Catatan Pembinaan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
