<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penilaian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WaliKelasGrafikTest extends TestCase
{
    use RefreshDatabase;

    protected $walikelas;
    protected $kelas;
    protected $siswa1;
    protected $siswa2;
    protected $penilaian1;
    protected $penilaian2;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create Wali Kelas
        $this->walikelas = User::create([
            'name' => 'Wali Kelas Test',
            'username' => 'wktest',
            'email' => 'wktest@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'guru',
            'jabatan' => 'walikelas',
            'nip' => '5555555555',
            'is_verified' => true
        ]);

        // 2. Create Kelas
        $this->kelas = Kelas::create([
            'nama_kelas' => 'XII RPL Test Class',
            'wali_kelas_id' => $this->walikelas->id
        ]);

        // 3. Create Students
        $this->siswa1 = Siswa::create([
            'nis' => '666111',
            'nama' => 'Siswa Kesatu',
            'jenis_kelamin' => 'L',
            'kelas' => 'XII RPL Test Class',
            'jurusan' => 'RPL',
            'kelas_id' => $this->kelas->id,
            'walikelas_id' => $this->walikelas->id
        ]);

        $this->siswa2 = Siswa::create([
            'nis' => '666222',
            'nama' => 'Siswa Kedua',
            'jenis_kelamin' => 'P',
            'kelas' => 'XII RPL Test Class',
            'jurusan' => 'RPL',
            'kelas_id' => $this->kelas->id,
            'walikelas_id' => $this->walikelas->id
        ]);

        // 4. Create Penilaians
        $this->penilaian1 = Penilaian::create([
            'siswa_id' => $this->siswa1->id,
            'c1' => 90.0,
            'c2' => 80.0,
            'c3' => 95.0,
            'c4' => 60.0,
            'kpi_score' => 81.2,
            'bakat_dominan' => 'Akademik Umum (Intellectual)',
            'is_verified' => true
        ]);

        $this->penilaian2 = Penilaian::create([
            'siswa_id' => $this->siswa2->id,
            'c1' => 75.0,
            'c2' => 85.0,
            'c3' => 50.0,
            'c4' => 90.0,
            'kpi_score' => 75.0,
            'bakat_dominan' => 'Seni & Olahraga (General Arts)',
            'is_verified' => true
        ]);
    }

    /**
     * Test that the Wali Kelas can view their class graphics page with correct student indicators and rankings.
     */
    public function test_walikelas_can_view_class_graphics_and_rankings()
    {
        $response = $this->actingAs($this->walikelas)->get('/walikelas/grafik');

        $response->assertStatus(200);

        // Check if page headers and title are present
        $response->assertSee('GRAFIK PRESTASI & SEBARAN KPI KELAS', false);
        $response->assertSee('Wali Kelas: Wali Kelas Test');

        // Check if indicator rankings sections are rendered
        $response->assertSee('Peringkat Siswa Per Indikator');
        $response->assertSee('Rata-rata Rapor (C1)');
        $response->assertSee('Prestasi Akademik (C2)');
        $response->assertSee('Organisasi (C3)');
        $response->assertSee('Seni & Olahraga (C4)', false);

        // Check if ranked names are visible
        $response->assertSee('Siswa Kesatu');
        $response->assertSee('Siswa Kedua');

        // Check if the talent table is rendered
        $response->assertSee('Daftar Bakat Dominan & Capaian KPI Siswa', false);
        $response->assertSee('Akademik Umum (Intellectual)');
        $response->assertSee('Seni &amp; Olahraga (General Arts)', false);
    }
}
