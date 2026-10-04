<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Companies (Tempat Magang / Instansi)
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sector')->nullable(); // e.g. Software & IoT
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->integer('quota')->default(5);
            $table->decimal('latitude', 10, 7)->default(-6.2301000);
            $table->decimal('longitude', 10, 7)->default(106.8228000);
            $table->integer('radius_meters')->default(150);
            $table->string('allowed_work_modes')->default('wfo,wfh,wfa'); // wfo, wfh, wfa
            $table->timestamps();
        });

        // Placements (Plotting Magang)
        Schema::create('placements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('dudi_mentor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('teacher_mentor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('academic_year')->default('2025/2026');
            $table->string('batch')->default('Angkatan 32');
            $table->string('default_work_mode')->default('wfo'); // wfo, wfh, wfa
            $table->string('status')->default('active'); // active, completed, cancelled
            $table->timestamps();
        });

        // Attendances (Presensi Siswa)
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->string('check_in')->nullable(); // 07:45:00
            $table->string('check_out')->nullable(); // 17:00:00
            $table->string('status')->default('hadir'); // hadir, terlambat, izin, sakit, alpha
            $table->string('work_mode')->default('wfo'); // wfo, wfh, wfa
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('distance_meters')->nullable();
            $table->boolean('is_within_radius')->default(true);
            $table->string('notes')->nullable();
            $table->string('location_in')->nullable();
            $table->string('location_out')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'date']);
        });

        // Logbooks (Jurnal Harian)
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->string('title')->nullable();
            $table->longText('activity_description');
            $table->longText('photo_url')->nullable(); // base64 or url
            $table->string('status')->default('menunggu'); // menunggu, diacc, revisi
            $table->text('feedback_note')->nullable();
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
        });

        // Grades (Evaluasi & Penilaian)
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->unique()->constrained('users')->onDelete('cascade');
            $table->integer('dudi_score_discipline')->default(0);
            $table->integer('dudi_score_technical')->default(0);
            $table->integer('dudi_score_teamwork')->default(0);
            $table->integer('dudi_score_initiative')->default(0);
            $table->decimal('dudi_score_average', 5, 2)->default(0);
            $table->text('dudi_notes')->nullable();
            $table->decimal('school_report_score', 5, 2)->nullable();
            $table->decimal('final_score', 5, 2)->nullable();
            $table->string('qr_code_hash')->nullable();
            $table->boolean('is_finalized')->default(false);
            $table->timestamp('finalized_at')->nullable();
            $table->timestamps();
        });

        // Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, warning, success, danger
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('logbooks');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('placements');
        Schema::dropIfExists('companies');
    }
};
