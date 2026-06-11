<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonsultasiBk extends Model
{
    protected $table = 'konsultasi_bks';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'tanggal_pengajuan',
        'tanggal_konsultasi',
        'jam_konsultasi',
        'ruangan_konsultasi',
        'tipe_konsultasi',
        'keluhan',
        'status',
        'bimbingan_bk_id'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function bimbinganBk()
    {
        return $this->belongsTo(BimbinganBk::class, 'bimbingan_bk_id');
    }
}
