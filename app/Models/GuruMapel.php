<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuruMapel extends Model
{
    protected $table = 'guru_mapels';
    protected $fillable = ['guru_id', 'mapel_id', 'kelas_id'];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
