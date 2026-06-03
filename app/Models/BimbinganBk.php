<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BimbinganBk extends Model
{
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'tanggal',
        'jenis_pembinaan',
        'catatan',
        'status',
        'rekomendasi_lomba',
        'rekomendasi_organisasi',
        'rekomendasi_pengembangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
