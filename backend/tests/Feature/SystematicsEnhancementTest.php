<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\Logbook;
use App\Models\Placement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SystematicsEnhancementTest extends TestCase
{
    use RefreshDatabase;

    protected $siswa;

    protected $mentor;

    protected $guru;

    protected $admin;

    protected $company;

    protected $placement;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->siswa = User::where('email', 'siswa@gmail.com')->first();
        $this->mentor = User::where('email', 'mentor@gmail.com')->first();
        $this->guru = User::where('email', 'guru@gmail.com')->first();
        $this->admin = User::where('email', 'admin@gmail.com')->first();
        $this->company = Company::first();
        $this->placement = Placement::where('student_id', $this->siswa->id)->first();
    }

    public function test_mentor_can_batch_validate_logbooks(): void
    {
        $log1 = Logbook::create([
            'student_id' => $this->siswa->id,
            'date' => Carbon::yesterday()->format('Y-m-d'),
            'title' => 'Jurnal Batch 1',
            'activity_description' => 'Test Batch 1',
            'status' => 'menunggu',
        ]);

        $log2 = Logbook::create([
            'student_id' => $this->siswa->id,
            'date' => Carbon::today()->format('Y-m-d'),
            'title' => 'Jurnal Batch 2',
            'activity_description' => 'Test Batch 2',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->mentor, 'sanctum')->postJson('/api/mentor/logbooks/batch-validate', [
            'logbook_ids' => [$log1->id, $log2->id],
            'status' => 'diacc',
            'feedback_note' => 'Disetujui kolektif mingguan',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'updated_count' => 2,
            ]);

        $this->assertEquals('diacc', $log1->fresh()->status);
        $this->assertEquals('diacc', $log2->fresh()->status);
    }

    public function test_old_pending_logbook_auto_approved_after_sla(): void
    {
        $oldDate = Carbon::today()->subDays(8)->format('Y-m-d');
        $oldLog = Logbook::create([
            'student_id' => $this->siswa->id,
            'date' => $oldDate,
            'title' => 'Jurnal Terlantar 8 Hari Lalu',
            'activity_description' => 'Menunggu mentor lama sekali',
            'status' => 'menunggu',
        ]);

        // Access student logbooks endpoint should trigger SLA auto-approve
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/siswa/logbooks');
        $response->assertStatus(200);

        $freshLog = $oldLog->fresh();
        $this->assertEquals('diacc', $freshLog->status);
        $this->assertTrue($freshLog->is_auto_approved);
    }

    public function test_siswa_can_submit_attendance_with_gps_dispute(): void
    {
        // Delete any existing attendance for today
        DB::table('attendances')
            ->where('student_id', $this->siswa->id)
            ->whereDate('date', Carbon::today()->toDateString())
            ->delete();

        // Office coordinate is -6.2301, 106.8228. Submit far away coordinate (-6.3500, 106.8500) with dispute
        $response = $this->actingAs($this->siswa, 'sanctum')->postJson('/api/siswa/check-in', [
            'work_mode' => 'wfo',
            'latitude' => -6.3500,
            'longitude' => 106.8500,
            'is_dispute' => true,
            'dispute_reason' => 'Sinyal GPS drift berada di dalam basement server room',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $todayDate = Carbon::today()->toDateString();
        $att = Attendance::where('student_id', $this->siswa->id)->whereDate('date', $todayDate)->first();
        $this->assertNotNull($att);
        $this->assertTrue($att->is_dispute);
        $this->assertEquals('pending', $att->dispute_status);

        // Mentor can approve this dispute
        $reviewRes = $this->actingAs($this->mentor, 'sanctum')->postJson("/api/mentor/attendances/{$att->id}/review-dispute", [
            'status' => 'approved',
            'notes' => 'Terkonfirmasi siswa ada di ruangan',
        ]);

        $reviewRes->assertStatus(200);
        $this->assertEquals('approved', $att->fresh()->dispute_status);
        $this->assertTrue($att->fresh()->is_within_radius);
    }

    public function test_admin_can_relocate_placement_preserving_history(): void
    {
        $newCompany = Company::create([
            'name' => 'PT Mitra Baru Edu',
            'sector' => 'IT & Software',
            'address' => 'Jl. Baru No. 12',
            'latitude' => -6.2200,
            'longitude' => 106.8100,
            'radius_meters' => 150,
        ]);

        $response = $this->actingAs($this->admin, 'sanctum')->postJson("/api/admin/placements/{$this->placement->id}/relocate", [
            'new_company_id' => $newCompany->id,
            'relocation_reason' => 'Relokasi resmi karena restrukturisasi divisi perusahaan mitra pertama',
            'effective_date' => Carbon::today()->format('Y-m-d'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $old = $this->placement->fresh();
        $this->assertEquals('relocated', $old->status);

        $new = Placement::where('student_id', $this->siswa->id)->where('status', 'active')->first();
        $this->assertNotNull($new);
        $this->assertEquals($newCompany->id, $new->company_id);
        $this->assertEquals($old->id, $new->previous_placement_id);
    }

    public function test_guru_can_assess_rubric_with_multiple_curriculum_scores(): void
    {
        $response = $this->actingAs($this->guru, 'sanctum')->postJson("/api/guru/grades/{$this->siswa->id}/school-report", [
            'school_score_report' => 88,
            'school_score_presentation' => 92,
            'school_score_competence' => 90,
            'school_notes' => 'Portofolio koding dan presentasi sangat terstruktur.',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $grade = $this->siswa->grade->fresh();
        $this->assertEquals(88, $grade->school_score_report);
        $this->assertEquals(92, $grade->school_score_presentation);
        $this->assertEquals(90, $grade->school_score_competence);
        $this->assertNotNull($grade->final_score);
    }
}
