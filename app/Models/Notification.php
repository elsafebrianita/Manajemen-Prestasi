<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'from_user_id',
        'type',
        'message',
        'is_read'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
