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
        // 1. Logbooks: Auto-approval flag & Catatan Pembimbing Sekolah (Guru)
        if (Schema::hasTable('logbooks')) {
            Schema::table('logbooks', function (Blueprint $table) {
                if (! Schema::hasColumn('logbooks', 'is_auto_approved')) {
                    $table->boolean('is_auto_approved')->default(false)->after('status');
                }
                if (! Schema::hasColumn('logbooks', 'teacher_note')) {
                    $table->text('teacher_note')->nullable()->after('feedback_note');
                }
                if (! Schema::hasColumn('logbooks', 'teacher_noted_at')) {
                    $table->timestamp('teacher_noted_at')->nullable()->after('teacher_note');
                }
            });
        }

        // 2. Attendances: Sanggahan / Presensi Darurat GPS Drift
        if (Schema::hasTable('attendances')) {
            Schema::table('attendances', function (Blueprint $table) {
                if (! Schema::hasColumn('attendances', 'is_dispute')) {
                    $table->boolean('is_dispute')->default(false)->after('is_within_radius');
                }
                if (! Schema::hasColumn('attendances', 'dispute_reason')) {
                    $table->text('dispute_reason')->nullable()->after('is_dispute');
                }
                if (! Schema::hasColumn('attendances', 'dispute_status')) {
                    $table->string('dispute_status')->default('none')->after('dispute_reason'); // none, pending, approved, rejected
                }
                if (! Schema::hasColumn('attendances', 'dispute_resolved_by')) {
                    $table->foreignId('dispute_resolved_by')->nullable()->constrained('users')->onDelete('set null')->after('dispute_status');
                }
                if (! Schema::hasColumn('attendances', 'dispute_resolved_at')) {
                    $table->timestamp('dispute_resolved_at')->nullable()->after('dispute_resolved_by');
                }
            });
        }

        // 3. Placements: Relokasi & Riwayat Penempatan
        if (Schema::hasTable('placements')) {
            Schema::table('placements', function (Blueprint $table) {
                if (! Schema::hasColumn('placements', 'relocation_reason')) {
                    $table->text('relocation_reason')->nullable()->after('status');
                }
                if (! Schema::hasColumn('placements', 'previous_placement_id')) {
                    $table->foreignId('previous_placement_id')->nullable()->constrained('placements')->onDelete('set null')->after('relocation_reason');
                }
            });
        }

        // 4. Grades: Rubrik Penilaian Sekolah Kurikulum Merdeka (Laporan, Sidang, Portofolio Kejuruan)
        if (Schema::hasTable('grades')) {
            Schema::table('grades', function (Blueprint $table) {
                if (! Schema::hasColumn('grades', 'school_score_report')) {
                    $table->decimal('school_score_report', 5, 2)->nullable()->after('dudi_notes');
                }
                if (! Schema::hasColumn('grades', 'school_score_presentation')) {
                    $table->decimal('school_score_presentation', 5, 2)->nullable()->after('school_score_report');
                }
                if (! Schema::hasColumn('grades', 'school_score_competence')) {
                    $table->decimal('school_score_competence', 5, 2)->nullable()->after('school_score_presentation');
                }
                if (! Schema::hasColumn('grades', 'school_notes')) {
                    $table->text('school_notes')->nullable()->after('school_score_competence');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('grades')) {
            Schema::table('grades', function (Blueprint $table) {
                $table->dropColumn(['school_score_report', 'school_score_presentation', 'school_score_competence', 'school_notes']);
            });
        }

        if (Schema::hasTable('placements')) {
            Schema::table('placements', function (Blueprint $table) {
                $table->dropForeign(['previous_placement_id']);
                $table->dropColumn(['relocation_reason', 'previous_placement_id']);
            });
        }

        if (Schema::hasTable('attendances')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->dropForeign(['dispute_resolved_by']);
                $table->dropColumn(['is_dispute', 'dispute_reason', 'dispute_status', 'dispute_resolved_by', 'dispute_resolved_at']);
            });
        }

        if (Schema::hasTable('logbooks')) {
            Schema::table('logbooks', function (Blueprint $table) {
                $table->dropColumn(['is_auto_approved', 'teacher_note', 'teacher_noted_at']);
            });
        }
    }
};
