<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected $siswa;
    protected $mentor;
    protected $guru;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->siswa = User::where('email', 'siswa@gmail.com')->first();
        $this->mentor = User::where('email', 'mentor@gmail.com')->first();
        $this->guru = User::where('email', 'guru@gmail.com')->first();
        $this->admin = User::where('email', 'admin@gmail.com')->first();
    }

    public function test_siswa_cannot_access_admin_portal(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/admin/dashboard');
        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'your_role' => 'siswa',
            ]);
    }

    public function test_siswa_cannot_access_mentor_portal(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/mentor/dashboard');
        $response->assertStatus(403);
    }

    public function test_siswa_cannot_access_guru_portal(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/guru/dashboard');
        $response->assertStatus(403);
    }

    public function test_mentor_cannot_access_admin_portal(): void
    {
        $response = $this->actingAs($this->mentor, 'sanctum')->getJson('/api/admin/master-data');
        $response->assertStatus(403);
    }

    public function test_guru_cannot_access_admin_portal(): void
    {
        $response = $this->actingAs($this->guru, 'sanctum')->getJson('/api/admin/master-data');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_portal(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')->getJson('/api/admin/dashboard');
        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
