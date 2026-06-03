@extends('layouts.app')
@section('page_title', 'Validasi Prestasi')

@section('content')
<div style="padding: 40px;">
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px; color: var(--secondary);"><i class="fa-solid fa-check-double"></i> Validasi Prestasi Siswa</h2>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Daftar prestasi siswa yang menunggu persetujuan (Validasi). Silakan periksa kelengkapan dan bukti sertifikat sebelum menyetujui.</p>

        @if(session('success'))
            <div style="background: #10b981; color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: #ef4444; color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-color); text-align: left;">
                        <th style="padding: 15px; border-radius: 10px 0 0 10px;">Tanggal</th>
                        <th style="padding: 15px;">Siswa</th>
                        <th style="padding: 15px;">Prestasi</th>
                        <th style="padding: 15px;">Tingkat & Juara</th>
                        <th style="padding: 15px;">Sertifikat</th>
                        <th style="padding: 15px; text-align: center; border-radius: 0 10px 10px 0;">Aksi Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestasi as $p)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 15px;">{{ \Carbon\Carbon::parse($p->tanggal_capaian)->format('d M Y') }}</td>
                            <td style="padding: 15px;">
                                <strong style="color: var(--secondary);">{{ $p->siswa->nama ?? 'N/A' }}</strong><br>
                                <small style="color: var(--text-muted);">NIS: {{ $p->siswa->nis ?? '-' }}</small>
                            </td>
                            <td style="padding: 15px;">
                                <strong>{{ $p->nama_prestasi }}</strong><br>
                                <small style="color: var(--text-muted);">{{ $p->kategori->nama_kategori ?? '-' }}</small>
                                @if($p->lokasi)
                                    <br><small style="color: var(--text-muted);"><i class="fas fa-map-marker-alt" style="color: var(--primary); margin-right: 4px;"></i>{{ $p->lokasi }}</small>
                                @endif
                            </td>
                            <td style="padding: 15px;">
                                <span style="background: #e0f2fe; color: #0284c7; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: bold;">{{ $p->tingkat }}</span>
                                <span style="background: #fef3c7; color: #d97706; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: bold;">{{ $p->juara }}</span>
                            </td>
                            <td style="padding: 15px;">
                                @if($p->sertifikat)
                                    <button type="button" onclick="showSertifikat('{{ asset('uploads/sertifikat/' . $p->sertifikat) }}')" style="background: var(--primary); color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: bold;">
                                        <i class="fa-solid fa-file-image"></i> Lihat Sertifikat
                                    </button>
                                @else
                                    <span style="color: #ef4444; font-size: 12px; font-style: italic;">Tidak Ada</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 10px; justify-content: center;">
                                    <button type="button" onclick="showValidasiModal({{ $p->id }}, 'disetujui')" style="background: #10b981; color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: bold;">
                                        <i class="fa-solid fa-check"></i> Setujui
                                    </button>
                                    <button type="button" onclick="showValidasiModal({{ $p->id }}, 'ditolak')" style="background: #ef4444; color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: bold;">
                                        <i class="fa-solid fa-xmark"></i> Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">Tidak ada data prestasi yang menunggu validasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Lihat Sertifikat -->
<div id="sertifikatModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 20px; border-radius: 15px; max-width: 800px; width: 90%; max-height: 90vh; overflow-y: auto; position: relative;">
        <button onclick="closeSertifikat()" style="position: absolute; top: 15px; right: 15px; background: transparent; border: none; font-size: 24px; color: #64748b; cursor: pointer;">&times;</button>
        <h3 style="margin-bottom: 20px; font-size: 18px;">Dokumen Sertifikat</h3>
        <div id="sertifikatContainer" style="text-align: center;">
            <img id="sertifikatImg" src="" alt="Sertifikat" style="max-width: 100%; height: auto; border-radius: 10px; display: none;">
            <iframe id="sertifikatPdf" src="" style="width: 100%; height: 60vh; border: none; display: none;"></iframe>
        </div>
    </div>
</div>

<!-- Modal Form Validasi -->
<div id="validasiModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 15px; max-width: 500px; width: 90%;">
        <h3 id="modalTitle" style="margin-bottom: 20px; font-size: 18px;">Form Validasi</h3>
        <form id="formValidasi" method="POST" action="">
            @csrf
            <input type="hidden" name="status" id="inputStatus">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; color: var(--text-muted); margin-bottom: 8px;">Keterangan / Alasan (Opsional)</label>
                <textarea name="keterangan" rows="4" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-family: inherit; font-size: 14px;" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button type="button" onclick="closeValidasiModal()" style="background: #f1f5f9; color: var(--text-main); border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold;">Batal</button>
                <button type="submit" id="btnSubmitValidasi" style="background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showSertifikat(url) {
        document.getElementById('sertifikatModal').style.display = 'flex';
        let img = document.getElementById('sertifikatImg');
        let pdf = document.getElementById('sertifikatPdf');
        
        if (url.endsWith('.pdf')) {
            img.style.display = 'none';
            pdf.style.display = 'block';
            pdf.src = url;
        } else {
            pdf.style.display = 'none';
            img.style.display = 'block';
            img.src = url;
        }
    }

    function closeSertifikat() {
        document.getElementById('sertifikatModal').style.display = 'none';
        document.getElementById('sertifikatPdf').src = '';
    }

    function showValidasiModal(id, status) {
        document.getElementById('validasiModal').style.display = 'flex';
        document.getElementById('formValidasi').action = '/wakasiswa/verifikasi/' + id;
        document.getElementById('inputStatus').value = status;
        
        let title = document.getElementById('modalTitle');
        let btn = document.getElementById('btnSubmitValidasi');
        
        if (status === 'disetujui') {
            title.innerHTML = '<i class="fa-solid fa-check" style="color: #10b981;"></i> Konfirmasi Penyetujuan';
            btn.style.background = '#10b981';
            btn.innerHTML = 'Setujui Prestasi';
        } else {
            title.innerHTML = '<i class="fa-solid fa-xmark" style="color: #ef4444;"></i> Konfirmasi Penolakan';
            btn.style.background = '#ef4444';
            btn.innerHTML = 'Tolak Prestasi';
        }
    }

    function closeValidasiModal() {
        document.getElementById('validasiModal').style.display = 'none';
    }
</script>
</div>
@endsection
