<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruApiTest extends TestCase
{
    use RefreshDatabase;

    protected $guru;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->guru = User::where('email', 'guru@gmail.com')->first();
    }

    public function test_guru_can_get_dashboard(): void
    {
        $response = $this->actingAs($this->guru, 'sanctum')->getJson('/api/guru/dashboard');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'students',
                'companies_grouped',
                'system_alerts',
                'chart_data',
            ]);
    }

    public function test_guru_can_get_students(): void
    {
        $response = $this->actingAs($this->guru, 'sanctum')->getJson('/api/guru/students');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'students',
            ]);
    }

    public function test_guru_can_get_grades(): void
    {
        $response = $this->actingAs($this->guru, 'sanctum')->getJson('/api/guru/grades');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'compilation',
            ]);
    }
}
