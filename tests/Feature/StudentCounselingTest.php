<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\BimbinganBk;
use App\Models\KonsultasiBk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCounselingTest extends TestCase
{
    use RefreshDatabase;

    protected $siswaUser;
    protected $bkUser;
    protected $siswa;
    protected $kelas;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a kelas
        $this->kelas = Kelas::create([
            'nama_kelas' => 'XII RPL 1',
            'wali_kelas_id' => null
        ]);

        // Create BK user
        $this->bkUser = User::create([
            'name' => 'Guru BK',
            'username' => 'gurubk',
            'email' => 'bk@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'guru',
            'jabatan' => 'guru_bk',
            'nip' => '1111111111',
            'is_verified' => true
        ]);

        // Create Siswa User
        $this->siswaUser = User::create([
            'name' => 'Budi',
            'username' => '123456',
            'email' => 'budi@sekolah.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'siswa',
            'is_verified' => true
        ]);

        // Create Siswa profile
        $this->siswa = Siswa::create([
            'nis' => '123456',
            'nama' => 'Budi',
            'jenis_kelamin' => 'L',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'RPL',
            'kelas_id' => $this->kelas->id,
            'walikelas_id' => null
        ]);

        // Create Penilaian
        Penilaian::create([
            'siswa_id' => $this->siswa->id,
            'c1' => 70,
            'c2' => 60,
            'c3' => 50,
            'c4' => 60,
            'kpi_score' => 60.0,
            'bakat_dominan' => 'Akademik Umum',
            'is_verified' => true
        ]);
    }

    /**
     * Test student can view bimbingan page.
     */
    public function test_student_can_view_bimbingan_page()
    {
        $response = $this->actingAs($this->siswaUser)->get('/siswa/bimbingan');
        $response->assertStatus(200);
        $response->assertSee('Layanan Bimbingan Konseling (BK)');
        $response->assertSee('Ajukan Konsultasi Baru');
    }

    /**
     * Test student can submit a consultation request.
     */
    public function test_student_can_submit_consultation_request()
    {
        $response = $this->actingAs($this->siswaUser)->post('/siswa/bimbingan/store', [
            'tanggal_pengajuan' => date('Y-m-d'),
            'tipe_konsultasi' => 'akademik',
            'keluhan' => 'Saya ingin berkonsultasi mengenai nilai Matematika saya.'
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('konsultasi_bks', [
            'siswa_id' => $this->siswa->id,
            'tipe_konsultasi' => 'akademik',
            'keluhan' => 'Saya ingin berkonsultasi mengenai nilai Matematika saya.',
            'status' => 'pending'
        ]);
    }

    /**
     * Test BK teacher can see the student request on their dashboard.
     */
    public function test_bk_teacher_can_see_request_on_dashboard()
    {
        $konsultasi = KonsultasiBk::create([
            'siswa_id' => $this->siswa->id,
            'tanggal_pengajuan' => date('Y-m-d'),
            'tipe_konsultasi' => 'akademik',
            'keluhan' => 'Butuh bimbingan akademik',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->bkUser)->get(route('guru-bk.dashboard'));
        $response->assertStatus(200);
        $response->assertSee($this->siswa->nama);
        $response->assertSee('Butuh bimbingan akademik');
    }

    /**
     * Test BK teacher processing consultation request transitions its status to 'diproses'.
     */
    public function test_bk_teacher_processing_request_transitions_status()
    {
        $konsultasi = KonsultasiBk::create([
            'siswa_id' => $this->siswa->id,
            'tanggal_pengajuan' => date('Y-m-d'),
            'tipe_konsultasi' => 'akademik',
            'keluhan' => 'Butuh bimbingan akademik',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->bkUser)->get(route('guru-bk.pembinaan', [
            'siswa_id' => $this->siswa->id,
            'konsultasi_id' => $konsultasi->id
        ]));

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('konsultasi_bks', [
            'id' => $konsultasi->id,
            'status' => 'diproses'
        ]);
    }

    /**
     * Test BK teacher store pembinaan resolves consultation request.
     */
    public function test_bk_teacher_store_pembinaan_resolves_request()
    {
        $konsultasi = KonsultasiBk::create([
            'siswa_id' => $this->siswa->id,
            'tanggal_pengajuan' => date('Y-m-d'),
            'tipe_konsultasi' => 'akademik',
            'keluhan' => 'Butuh bimbingan akademik',
            'status' => 'diproses'
        ]);

        $response = $this->actingAs($this->bkUser)->post(route('guru-bk.pembinaan.store'), [
            'siswa_id' => $this->siswa->id,
            'tanggal' => date('Y-m-d'),
            'jenis_pembinaan' => 'akademik',
            'catatan' => 'Siswa telah diberikan arahan untuk belajar kelompok.',
            'status' => 'selesai',
            'konsultasi_id' => $konsultasi->id
        ]);

        $response->assertRedirect(route('guru-bk.riwayat'));

        $this->assertDatabaseHas('konsultasi_bks', [
            'id' => $konsultasi->id,
            'status' => 'selesai',
            'guru_id' => $this->bkUser->id
        ]);

        $bimbingan = BimbinganBk::where('siswa_id', $this->siswa->id)->first();
        $this->assertNotNull($bimbingan);
        $this->assertEquals($bimbingan->id, KonsultasiBk::find($konsultasi->id)->bimbingan_bk_id);
    }

    /**
     * Test BK teacher can approve and schedule a consultation request.
     */
    public function test_bk_teacher_can_approve_and_schedule_request()
    {
        $konsultasi = KonsultasiBk::create([
            'siswa_id' => $this->siswa->id,
            'tanggal_pengajuan' => date('Y-m-d'),
            'tipe_konsultasi' => 'akademik',
            'keluhan' => 'Butuh bimbingan akademik',
            'status' => 'pending'
        ]);

        $scheduleDate = date('Y-m-d', strtotime('+1 day'));
        $response = $this->actingAs($this->bkUser)->post(route('guru-bk.konsultasi.acc', ['id' => $konsultasi->id]), [
            'tanggal_konsultasi' => $scheduleDate,
            'jam_konsultasi' => '10:00 - 11:00 WIB',
            'ruangan_konsultasi' => 'Ruang BK Utama'
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('konsultasi_bks', [
            'id' => $konsultasi->id,
            'status' => 'disetujui',
            'guru_id' => $this->bkUser->id,
            'tanggal_konsultasi' => $scheduleDate,
            'jam_konsultasi' => '10:00 - 11:00 WIB',
            'ruangan_konsultasi' => 'Ruang BK Utama'
        ]);

        // Assert notification was created
        $this->assertDatabaseHas('notifications', [
            'siswa_id' => $this->siswa->id,
            'from_user_id' => $this->bkUser->id,
            'type' => 'Bimbingan BK'
        ]);
    }

    /**
     * Test student can view scheduling details on the bimbingan page.
     */
    public function test_student_can_view_scheduling_details()
    {
        $scheduleDate = date('Y-m-d', strtotime('+1 day'));
        $konsultasi = KonsultasiBk::create([
            'siswa_id' => $this->siswa->id,
            'tanggal_pengajuan' => date('Y-m-d'),
            'tipe_konsultasi' => 'akademik',
            'keluhan' => 'Butuh bimbingan akademik',
            'status' => 'disetujui',
            'guru_id' => $this->bkUser->id,
            'tanggal_konsultasi' => $scheduleDate,
            'jam_konsultasi' => '10:00 - 11:00 WIB',
            'ruangan_konsultasi' => 'Ruang BK Utama'
        ]);

        $response = $this->actingAs($this->siswaUser)->get('/siswa/bimbingan');
        $response->assertStatus(200);
        $response->assertSee('Disetujui');
        $response->assertSee('Jadwal Konsultasi Disetujui:');
        $response->assertSee('Ruang BK Utama');
        $response->assertSee('10:00 - 11:00 WIB');
    }
}
