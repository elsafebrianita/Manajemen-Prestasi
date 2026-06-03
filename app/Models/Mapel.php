<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mapel extends Model
{
    protected $table = 'mapels';
    protected $fillable = ['nama_mapel'];

    public function guruMapels(): HasMany
    {
        return $this->hasMany(GuruMapel::class, 'mapel_id');
    }

    public function nilaiSiswas(): HasMany
    {
        return $this->hasMany(NilaiSiswa::class, 'mapel_id');
    }
}
