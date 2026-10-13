<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_admin_can_get_dashboard(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')->getJson('/api/admin/dashboard');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'stats',
                'distribution',
                'cloud_status',
            ]);
    }

    public function test_admin_can_get_master_data(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')->getJson('/api/admin/master-data?role=siswa');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'users',
            ]);
    }

    public function test_admin_can_get_plotting_data(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')->getJson('/api/admin/plotting');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'students',
                'companies',
                'teachers',
                'mentors',
            ]);
    }

    public function test_admin_can_assign_placement(): void
    {
        $siswa = User::where('role', 'siswa')->first();
        $company = Company::first();
        $guru = User::where('role', 'guru')->first();
        $mentor = User::where('role', 'mentor')->first();

        $response = $this->actingAs($this->admin, 'sanctum')->postJson('/api/admin/plotting', [
            'student_id' => $siswa->id,
            'company_id' => $company->id,
            'teacher_mentor_id' => $guru->id,
            'dudi_mentor_id' => $mentor->id,
            'start_date' => Carbon::today()->format('Y-m-d'),
            'end_date' => Carbon::today()->addMonths(6)->format('Y-m-d'),
            'academic_year' => '2025/2026',
            'batch' => 'Angkatan 32',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Penempatan tempat magang berhasil ditetapkan.',
            ]);
    }

    public function test_admin_can_get_reports(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')->getJson('/api/admin/reports');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'report_rows',
                'filters',
            ]);
    }
}
