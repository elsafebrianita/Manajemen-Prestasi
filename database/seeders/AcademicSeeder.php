<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruMapel;
use App\Models\Siswa;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Kelas
        $kelas1 = Kelas::firstOrCreate(['nama_kelas' => 'X RPL 1']);
        $kelas2 = Kelas::firstOrCreate(['nama_kelas' => 'X RPL 2']);
        $kelas3 = Kelas::firstOrCreate(['nama_kelas' => 'XI RPL 1']);
        $kelas4 = Kelas::firstOrCreate(['nama_kelas' => 'XI RPL 2']);

        // 2. Create Mapels
        $mapel1 = Mapel::firstOrCreate(['nama_mapel' => 'Bahasa Inggris']);
        $mapel2 = Mapel::firstOrCreate(['nama_mapel' => 'Matematika']);
        $mapel3 = Mapel::firstOrCreate(['nama_mapel' => 'Pemrograman Web']);
        $mapel4 = Mapel::firstOrCreate(['nama_mapel' => 'Basis Data']);

        // 3. Create or Update Users for Guru
        $guruBhsInggris = User::firstOrCreate(
            ['username' => 'gurubasasinggris'],
            [
                'name' => 'Dr. H. English Teacher, M.Pd',
                'email' => 'gurubasasinggris@smkn1talamau.sch.id',
                'role' => 'guru',
                'password' => bcrypt('password'),
            ]
        );

        $guruMatematika = User::firstOrCreate(
            ['username' => 'gurumatematika'],
            [
                'name' => 'Prof. Mathematics Teacher, M.Sc',
                'email' => 'gurumatematika@smkn1talamau.sch.id',
                'role' => 'guru',
                'password' => bcrypt('password'),
            ]
        );

        // 4. Create Wali Kelas Users
        $waliRpl1 = User::firstOrCreate(
            ['username' => 'walirpl1'],
            [
                'name' => 'Wali Kelas X RPL 1, S.Pd',
                'email' => 'walirpl1@smkn1talamau.sch.id',
                'role' => 'walikelas',
                'password' => bcrypt('password'),
            ]
        );

        $waliRpl2 = User::firstOrCreate(
            ['username' => 'walirpl2'],
            [
                'name' => 'Wali Kelas X RPL 2, S.Pd',
                'email' => 'walirpl2@smkn1talamau.sch.id',
                'role' => 'walikelas',
                'password' => bcrypt('password'),
            ]
        );

        // 5. Create Relasi Guru & Mapel & Kelas (guru_mapels)
        // Guru B Inggris mengajar kelas X RPL 1 dan X RPL 2
        GuruMapel::firstOrCreate([
            'guru_id' => $guruBhsInggris->id,
            'mapel_id' => $mapel1->id,
            'kelas_id' => $kelas1->id,
        ]);

        GuruMapel::firstOrCreate([
            'guru_id' => $guruBhsInggris->id,
            'mapel_id' => $mapel1->id,
            'kelas_id' => $kelas2->id,
        ]);

        // Guru Matematika mengajar kelas X RPL 1
        GuruMapel::firstOrCreate([
            'guru_id' => $guruMatematika->id,
            'mapel_id' => $mapel2->id,
            'kelas_id' => $kelas1->id,
        ]);

        // 6. Map existing students to classes and assign their Wali Kelas
        $siswas = Siswa::all();
        if ($siswas->count() > 0) {
            foreach ($siswas as $index => $s) {
                // Distribute students evenly between X RPL 1 and X RPL 2
                $chosenKelas = ($index % 2 == 0) ? $kelas1 : $kelas2;
                $chosenWali = ($index % 2 == 0) ? $waliRpl1 : $waliRpl2;

                $s->update([
                    'kelas_id' => $chosenKelas->id,
                    'kelas' => $chosenKelas->nama_kelas,
                    'walikelas_id' => $chosenWali->id
                ]);
            }
        } else {
            // Seed a few dummy students if none exist
            $dummyStudents = [
                ['nis' => '25.3218', 'nama' => 'ADNAN DAFFA MUHADZIB', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas1->id, 'kelas' => $kelas1->nama_kelas, 'jurusan' => 'Agribisnis Tanaman Perkebunan', 'walikelas_id' => $waliRpl1->id],
                ['nis' => '25.3219', 'nama' => 'AZZAM AL BAIHAQI', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas1->id, 'kelas' => $kelas1->nama_kelas, 'jurusan' => 'Agribisnis Tanaman Perkebunan', 'walikelas_id' => $waliRpl1->id],
                ['nis' => '25.3220', 'nama' => 'DIKI KURNIAWAN', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas2->id, 'kelas' => $kelas2->nama_kelas, 'jurusan' => 'Agribisnis Tanaman Perkebunan', 'walikelas_id' => $waliRpl2->id],
                ['nis' => '25.3221', 'nama' => 'FERDI RAMADANI', 'jenis_kelamin' => 'L', 'kelas_id' => $kelas2->id, 'kelas' => $kelas2->nama_kelas, 'jurusan' => 'Agribisnis Tanaman Perkebunan', 'walikelas_id' => $waliRpl2->id],
            ];
            foreach ($dummyStudents as $ds) {
                Siswa::create($ds);
            }
        }
    }
}
