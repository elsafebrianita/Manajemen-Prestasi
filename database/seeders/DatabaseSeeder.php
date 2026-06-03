<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Guru Pembimbing',
                'username' => 'guru',
                'role' => 'guru',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Wakil Kepala Siswa',
                'username' => 'wakasiswa',
                'role' => 'wakasiswa',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Kepala Sekolah',
                'username' => 'kepsek',
                'role' => 'kepsek',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Siswa Teladan',
                'username' => '1234567890', // NISN
                'role' => 'siswa',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $kategoris = [
            ['nama_kategori' => 'Akademik'],
            ['nama_kategori' => 'Non Akademik'],
            ['nama_kategori' => 'Olahraga'],
            ['nama_kategori' => 'Seni'],
        ];

        foreach ($kategoris as $kategori) {
            \App\Models\KategoriPrestasi::create($kategori);
        }
    }
}
