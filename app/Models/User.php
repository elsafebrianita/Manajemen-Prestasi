<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'is_verified',
        'password',
        'nip',
        'jabatan',
        'foto',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function guruMapels()
    {
        return $this->hasMany(GuruMapel::class, 'guru_id');
    }

    public function walikelasSiswas()
    {
        return $this->hasMany(Siswa::class, 'walikelas_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function getAksesRoleAttribute()
    {
        if ($this->role === 'siswa') return 'siswa';
        
        if ($this->role === 'guru') {
            if ($this->jabatan === 'wali_kelas') return 'walikelas';
            if ($this->jabatan === 'guru_bk' || $this->jabatan === 'bk') return 'bk';
            return 'guru';
        }
        
        if ($this->role === 'pegawai') {
            if ($this->jabatan === 'kepala_sekolah' || $this->jabatan === 'kepsek') return 'kepsek';
            if ($this->jabatan === 'wakasiswa' || $this->jabatan === 'wakil_kesiswaan') return 'wakasiswa';
            if ($this->jabatan === 'admin') return 'admin';
            if ($this->jabatan === 'humas') return 'humas';
            if ($this->jabatan === 'anggota_kepsek') return 'anggota_kepsek';
            if ($this->jabatan === 'tu') return 'tu';
            return 'pegawai';
        }
        
        return $this->role;
    }
}
