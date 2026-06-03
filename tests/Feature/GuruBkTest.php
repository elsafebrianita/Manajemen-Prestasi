<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\BimbinganBk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruBkTest extends TestCase
{
    use RefreshDatabase;

    protected $bkUser;
    protected $nonBkUser;
    protected $siswa;
    protected $kelas;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a kelas
        $this->kelas = Kelas::create([
            'nama_kelas' => 'XII RPL Test',
            'wali_kelas_id' => null
        ]);

        // Create BK user
        $this->bkUser = User::create([
            'name' => 'Guru BK Test',
            'username' => 'gurubktest',
            'email' => 'bktest@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'guru',
            'jabatan' => 'guru_bk',
            'nip' => '1234567890',
            'is_verified' => true,
            'foto' => 'test.png'
        ]);

        // Create Non-BK user
        $this->nonBkUser = User::create([
            'name' => 'Guru Mapel Test',
            'username' => 'gurumapeltest',
            'email' => 'mapeltest@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'guru',
            'jabatan' => 'guru_mapel',
            'nip' => '0987654321',
            'is_verified' => true,
            'foto' => 'test.png'
        ]);

        // Create Siswa
        $this->siswa = Siswa::create([
            'nis' => '999999',
            'nama' => 'Siswa Test',
            'jenis_kelamin' => 'L',
            'kelas' => 'XII RPL Test',
            'jurusan' => 'RPL',
            'kelas_id' => $this->kelas->id,
            'walikelas_id' => null
        ]);

        // Create Penilaian
        Penilaian::create([
            'siswa_id' => $this->siswa->id,
            'c1' => 75,
            'c2' => 80,
            'c3' => 85,
            'c4' => 90,
            'kpi_score' => 82.5,
            'bakat_dominan' => 'Akademik Umum',
            'is_verified' => true
        ]);
    }

    /**
     * Test guest cannot access Guru BK routes.
     */
    public function test_guest_cannot_access_guru_bk_routes()
    {
        $response = $this->get(route('guru-bk.dashboard'));
        $response->assertRedirect('/login');
    }

    /**
     * Test non-BK user receives a 403 response on Guru BK routes.
     */
    public function test_non_bk_user_receives_403_on_guru_bk_routes()
    {
        $response = $this->actingAs($this->nonBkUser)->get(route('guru-bk.dashboard'));
        $response->assertStatus(403);
    }

    /**
     * Test BK user can view dashboard.
     */
    public function test_bk_user_can_view_dashboard()
    {
        $response = $this->actingAs($this->bkUser)->get(route('guru-bk.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Guru BK Test!');
        $response->assertSee('Jumlah Seluruh Siswa');
    }

    /**
     * Test BK user can view monitoring page.
     */
    public function test_bk_user_can_view_monitoring_page()
    {
        $response = $this->actingAs($this->bkUser)->get(route('guru-bk.monitoring'));
        $response->assertStatus(200);
        $response->assertSee('Pemantauan Nilai');
        $response->assertSee($this->siswa->nama);
    }

    /**
     * Test BK user can view detail page.
     */
    public function test_bk_user_can_view_detail_page()
    {
        $response = $this->actingAs($this->bkUser)->get(route('guru-bk.detail', $this->siswa->id));
        $response->assertStatus(200);
        $response->assertSee($this->siswa->nama);
        $response->assertSee('Indikator Capaian KPI');
        $response->assertSee('Grafik Perkembangan Nilai KPI Siswa');
    }

    /**
     * Test BK user can record counseling session (pembinaan).
     */
    public function test_bk_user_can_record_pembinaan()
    {
        $response = $this->actingAs($this->bkUser)->post(route('guru-bk.pembinaan.store'), [
            'siswa_id' => $this->siswa->id,
            'tanggal' => date('Y-m-d'),
            'jenis_pembinaan' => 'akademik',
            'catatan' => 'Siswa perlu meningkatkan kedisiplinan belajar.',
            'status' => 'proses'
        ]);

        $response->assertRedirect(route('guru-bk.riwayat'));
        
        $this->assertDatabaseHas('bimbingan_bks', [
            'siswa_id' => $this->siswa->id,
            'guru_id' => $this->bkUser->id,
            'jenis_pembinaan' => 'akademik',
            'catatan' => 'Siswa perlu meningkatkan kedisiplinan belajar.',
            'status' => 'proses'
        ]);
    }

}
