<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penilaian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $humasUser;
    protected $wakasiswaUser;
    protected $kepsekUser;
    protected $adminUser;
    protected $siswa;
    protected $kelas;
    protected $penilaian;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kelas = Kelas::create([
            'nama_kelas' => 'XII RPL Test',
            'wali_kelas_id' => null
        ]);

        $this->humasUser = User::create([
            'name' => 'Humas User',
            'username' => 'humasuser',
            'email' => 'humas@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'pegawai',
            'jabatan' => 'humas',
            'nip' => '1111111111',
            'is_verified' => true
        ]);

        $this->wakasiswaUser = User::create([
            'name' => 'Wakasiswa User',
            'username' => 'wakasiswauser',
            'email' => 'wakasiswa@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'pegawai',
            'jabatan' => 'wakasiswa',
            'nip' => '2222222222',
            'is_verified' => true
        ]);

        $this->kepsekUser = User::create([
            'name' => 'Kepsek User',
            'username' => 'kepsekuser',
            'email' => 'kepsek@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'pegawai',
            'jabatan' => 'kepala_sekolah',
            'nip' => '3333333333',
            'is_verified' => true
        ]);

        $this->adminUser = User::create([
            'name' => 'Admin User',
            'username' => 'adminuser',
            'email' => 'admin@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'jabatan' => 'admin',
            'nip' => '4444444444',
            'is_verified' => true
        ]);

        $this->siswa = Siswa::create([
            'nis' => '888888',
            'nama' => 'Siswa Test Publikasi',
            'jenis_kelamin' => 'L',
            'kelas' => 'XII RPL Test',
            'jurusan' => 'RPL',
            'kelas_id' => $this->kelas->id,
            'walikelas_id' => null
        ]);

        // Create a pre-published Penilaian record to simulate a previously published record being proposed again
        $this->penilaian = Penilaian::create([
            'siswa_id' => $this->siswa->id,
            'c1' => 80,
            'c2' => 85,
            'c3' => 90,
            'c4' => 75,
            'kpi_score' => 82.5,
            'bakat_dominan' => 'Akademik Umum',
            'is_verified' => true,
            'is_recommended' => true,
            'is_proposed' => true,
            'kepsek_status' => 'layak',
            'is_published' => true,
            'status_publikasi' => 'published',
            'berita_publikasi' => 'Berita prestasi siswa test.',
            'admin_catatan' => 'Catatan admin.',
            'admin_published_by' => $this->adminUser->id,
            'admin_published_at' => now(),
            'kepsek_catatan' => 'Catatan kepsek.',
            'kepsek_reviewed_at' => now(),
        ]);
    }

    /**
     * Test proposing from Humas resets the publication and Kepsek fields.
     */
    public function test_humas_propose_resets_publication_fields()
    {
        $response = $this->actingAs($this->humasUser)->post("/humas/usulan/propose/{$this->penilaian->id}");

        $response->assertStatus(302);
        
        $this->penilaian->refresh();

        $this->assertTrue((bool)$this->penilaian->is_proposed);
        $this->assertEquals('menunggu', $this->penilaian->kepsek_status);
        $this->assertFalse((bool)$this->penilaian->is_published);
        $this->assertEquals('draft', $this->penilaian->status_publikasi);
        $this->assertNull($this->penilaian->berita_publikasi);
        $this->assertNull($this->penilaian->admin_catatan);
        $this->assertNull($this->penilaian->admin_published_by);
        $this->assertNull($this->penilaian->admin_published_at);
        $this->assertNull($this->penilaian->kepsek_catatan);
        $this->assertNull($this->penilaian->kepsek_reviewed_at);
    }



    /**
     * Test Kepsek/Admin toggling the publication status.
     */
    public function test_kepsek_publish_syncs_status_publikasi()
    {
        // First set the penilaian to layak but unpublished
        $this->penilaian->update([
            'kepsek_status' => 'layak',
            'is_published' => false,
            'status_publikasi' => 'draft'
        ]);

        // Publish it (toggle to true)
        $response = $this->actingAs($this->adminUser)->post("/kepsek/publish/{$this->penilaian->id}");
        $response->assertStatus(302);
        
        $this->penilaian->refresh();
        $this->assertTrue((bool)$this->penilaian->is_published);
        $this->assertEquals('published', $this->penilaian->status_publikasi);

        // Unpublish it (toggle to false)
        $response = $this->actingAs($this->adminUser)->post("/kepsek/publish/{$this->penilaian->id}");
        $response->assertStatus(302);

        $this->penilaian->refresh();
        $this->assertFalse((bool)$this->penilaian->is_published);
        $this->assertEquals('draft', $this->penilaian->status_publikasi);
    }
}
