<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentorApiTest extends TestCase
{
    use RefreshDatabase;

    protected $mentor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->mentor = User::where('email', 'mentor@gmail.com')->first();
    }

    public function test_mentor_can_get_dashboard(): void
    {
        $response = $this->actingAs($this->mentor, 'sanctum')->getJson('/api/mentor/dashboard');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'students',
                'total_active_students',
                'total_pending_validations',
            ]);
    }

    public function test_mentor_can_get_students(): void
    {
        $response = $this->actingAs($this->mentor, 'sanctum')->getJson('/api/mentor/students');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'students',
            ]);
    }

    public function test_mentor_can_get_attendance_recap(): void
    {
        $response = $this->actingAs($this->mentor, 'sanctum')->getJson('/api/mentor/attendance-recap');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_mentor_can_get_company_schedule(): void
    {
        $response = $this->actingAs($this->mentor, 'sanctum')->getJson('/api/mentor/company-schedule');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'schedule',
            ]);
    }

    public function test_mentor_can_get_evaluations(): void
    {
        $response = $this->actingAs($this->mentor, 'sanctum')->getJson('/api/mentor/evaluations');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'evaluations',
            ]);
    }
}
