<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Siswa extends Model
{
    //$fillable itu artinya:Field yang boleh diisi saat simpan data
    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'kelas',
        'jurusan',
        'kelas_id',
        'walikelas_id'
    ];

    public function kelasRel()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function walikelas()
    {
        return $this->belongsTo(User::class, 'walikelas_id');
    }

    public function nilaiSiswas()
    {
        return $this->hasMany(NilaiSiswa::class, 'siswa_id');
    }

    public function penilaian()
    {
        return $this->hasOne(Penilaian::class);
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}