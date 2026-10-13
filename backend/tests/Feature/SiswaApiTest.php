<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaApiTest extends TestCase
{
    use RefreshDatabase;

    protected $siswa;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->siswa = User::where('email', 'siswa@gmail.com')->first();
    }

    public function test_siswa_can_get_dashboard(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/siswa/dashboard');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'user',
                'today_work_mode',
            ]);
    }

    public function test_siswa_can_get_logbooks(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/siswa/logbooks');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'this_week',
                'all',
            ]);
    }

    public function test_siswa_can_store_logbook(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->postJson('/api/siswa/logbooks', [
            'date' => Carbon::today()->format('Y-m-d'),
            'title' => 'Mengembangkan Modul API',
            'activity_description' => 'Situation: Membuat endpoint REST API. Task: Validasi payload. Action: Menulis unit test. Result: Berhasil 100%.',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Jurnal harian berhasil disimpan dan menunggu validasi.',
            ]);
    }

    public function test_siswa_can_get_attendance_history(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/siswa/attendance-history');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'attendances',
            ]);
    }

    public function test_siswa_can_get_placement(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/siswa/placement');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }
}
