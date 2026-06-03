@extends('layouts.app')
@section('page_title', 'Edit Nilai Siswa')

@section('content')
<div style="padding: 40px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <!-- Back Link -->
        <a href="/walikelas/siswa" style="text-decoration: none; color: var(--text-muted); font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 25px; transition: color 0.2s;">
            <i class="fas fa-arrow-left"></i> Kembali ke Rekap Nilai
        </a>

        <!-- Main Form Card -->
        <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
            <h2 style="font-family: 'Poppins', sans-serif; font-size: 22px; font-weight: 700; color: var(--secondary); margin-bottom: 8px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-pen-to-square" style="color: var(--primary);"></i> Edit Transparansi Nilai Siswa
            </h2>
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 35px;">
                Siswa: <strong>{{ $siswa->nama }}</strong> (NIS: {{ $siswa->nis }}) | Kelas: <strong>{{ $siswa->kelasRel->nama_kelas ?? $siswa->kelas }}</strong>
            </p>

            @if($errors->any())
                <div style="background: #fef2f2; color: #b91c1c; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 14px;">
                    <ul style="margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/walikelas/siswa/{{ $siswa->id }}/nilai/update" method="POST">
                @csrf
                
                <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 35px;">
                    @forelse($mapels as $index => $m)
                        @php
                            $grade = $nilaiSiswas->get($m->id);
                            $nilaiVal = $grade ? $grade->nilai : '';
                        @endphp
                        <div style="display: grid; grid-template-columns: 2fr 1fr; align-items: center; gap: 25px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;">
                            <div>
                                <label style="display: block; font-weight: 700; color: var(--secondary); font-size: 14px; margin-bottom: 4px;">
                                    {{ $index + 1 }}. {{ $m->nama_mapel }}
                                </label>
                                <span style="font-size: 12px; color: var(--text-muted);">
                                    KKM: 75 | Pengampu: {{ $grade->guru->name ?? 'Wali Kelas / Belum Ditentukan' }}
                                </span>
                            </div>
                            <div>
                                <div style="position: relative; display: flex; align-items: center;">
                                    <input type="number" 
                                           name="nilai[{{ $m->id }}]" 
                                           value="{{ old('nilai.'.$m->id, $nilaiVal) }}" 
                                           min="0" 
                                           max="100" 
                                           step="0.01"
                                           placeholder="Belum ada nilai"
                                           style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 14px; font-weight: 700; color: var(--secondary); text-align: center; outline: none; transition: border-color 0.2s;"
                                           onfocus="this.style.borderColor='var(--primary)'"
                                           onblur="this.style.borderColor='#cbd5e1'">
                                    <span style="position: absolute; right: 15px; font-size: 12px; color: var(--text-muted); font-weight: 600;">/ 100</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <i class="fas fa-info-circle" style="font-size: 28px; margin-bottom: 12px; display: block;"></i>
                            Mata pelajaran kelas ini belum ditambahkan atau belum disinkronisasikan.
                        </div>
                    @endforelse
                </div>

                <div style="display: flex; gap: 15px; justify-content: flex-end;">
                    <a href="/walikelas/siswa" style="text-decoration: none; background: #cbd5e1; color: var(--secondary); padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; transition: background 0.2s;">
                        Batal
                    </a>
                    <button type="submit" style="background: var(--primary); color: white; border: none; padding: 12px 28px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 10px rgba(15,118,110,0.15);">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
