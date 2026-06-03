<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';

    protected $fillable = [
        'siswa_id',
        'nama_prestasi',
        'kategori_id',
        'tingkat',
        'lokasi',
        'juara',
        'tanggal_capaian',
        'status',
        'sertifikat',
        'keterangan'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPrestasi::class, 'kategori_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function getPoinAttribute()
    {
        if ($this->kategori && ($this->kategori->id == 3 || $this->kategori->parent_id == 3)) {
            return match(strtolower(str_replace('_', ' ', $this->juara))) {
                'ketua' => 95,
                'wakil ketua' => 90,
                'bendahara' => 88,
                'sekretaris' => 85,
                'anggota' => 75,
                default => 75
            };
        }

        $poin_dasar = match($this->tingkat) {
            'Internasional' => 100,
            'Nasional' => 80,
            'Provinsi' => 60,
            'Kabupaten' => 40,
            default => 20
        };

        $bonus_juara = 0;
        if (str_contains($this->juara, '1')) $bonus_juara = 20;
        elseif (str_contains($this->juara, '2')) $bonus_juara = 15;
        elseif (str_contains($this->juara, '3')) $bonus_juara = 10;
        else $bonus_juara = 5;

        return $poin_dasar + $bonus_juara;
    }
}