<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPrestasi extends Model
{
    protected $table = 'kategori_prestasi';

    protected $fillable = ['nama_kategori', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(KategoriPrestasi::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(KategoriPrestasi::class, 'parent_id');
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class, 'kategori_id');
    }
}