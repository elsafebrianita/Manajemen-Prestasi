<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penilaian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationDiagnosticsTest extends TestCase
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

        // 1. Create a Wali Kelas
        $this->walikelas = User::create([
            'name' => 'Wali Kelas 12A',
            'username' => 'walikelas12a',
            'email' => 'walikelas12a@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'guru',
            'jabatan' => 'walikelas',
            'nip' => '1212121212',
            'is_verified' => true
        ]);

        // 2. Create a Kelas assigned to the Wali Kelas
        $this->kelas = Kelas::create([
            'nama_kelas' => 'XII RPL 1',
            'wali_kelas_id' => $this->walikelas->id
        ]);

        // 3. Create two students in the class
        $this->siswa1 = Siswa::create([
            'nis' => '777111',
            'nama' => 'Siswa Pintar',
            'jenis_kelamin' => 'L',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'RPL',
            'kelas_id' => $this->kelas->id,
            'walikelas_id' => $this->walikelas->id
        ]);

        $this->siswa2 = Siswa::create([
            'nis' => '777222',
            'nama' => 'Siswa Kurang Aktif',
            'jenis_kelamin' => 'P',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'RPL',
            'kelas_id' => $this->kelas->id,
            'walikelas_id' => $this->walikelas->id
        ]);

        // 4. Create Penilaian records for them
        // Siswa 1: High score, all categories filled
        $this->penilaian1 = Penilaian::create([
            'siswa_id' => $this->siswa1->id,
            'c1' => 88.0,
            'c2' => 90.0,
            'c3' => 85.0,
            'c4' => 80.0,
            'kpi_score' => 86.0,
            'bakat_dominan' => 'Akademik Umum',
            'is_verified' => true
        ]);

        // Siswa 2: Low score, C3 (Organization) is 0, C4 is 0, C1 is low
        $this->penilaian2 = Penilaian::create([
            'siswa_id' => $this->siswa2->id,
            'c1' => 70.0,
            'c2' => 50.0,
            'c3' => 0.0,
            'c4' => 0.0,
            'kpi_score' => 45.0,
            'bakat_dominan' => 'Akademik Umum',
            'is_verified' => true
        ]);
    }

    /**
     * Test that the Wali Kelas sees the class diagnostics analysis panel on the send notification page.
     */
    public function test_walikelas_sees_class_diagnostics_analysis()
    {
        $response = $this->actingAs($this->walikelas)->get('/notifikasi');

        $response->assertStatus(200);

        // Check if average scores are displayed
        // Average C1 = (88 + 70)/2 = 79.0
        // Average C2 = (90 + 50)/2 = 70.0
        // Average C3 = (85 + 0)/2 = 42.5
        // Average C4 = (80 + 0)/2 = 40.0
        $response->assertSee('79.0');
        $response->assertSee('70.0');
        $response->assertSee('42.5');
        $response->assertSee('40.0');

        // Check if the struggling/lowest students section lists the lowest student
        $response->assertSee('Siswa dengan KPI Terendah');
        $response->assertSee('Siswa Kurang Aktif');
        $response->assertSee('45.0');

        // Check if the gap push section lists the organization gap (C3 = 0) and C4 gap (C4 = 0)
        $response->assertSee('Deteksi Celah Prestasi');
        $response->assertSee('Organisasi Kosong');
        $response->assertSee('Minat/Bakat Kosong');
    }
}
