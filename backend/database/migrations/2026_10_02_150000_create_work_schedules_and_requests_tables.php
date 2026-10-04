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
        // Add work_schedule to placements if not exists
        if (Schema::hasTable('placements') && !Schema::hasColumn('placements', 'work_schedule')) {
            Schema::table('placements', function (Blueprint $table) {
                $table->json('work_schedule')->nullable()->after('default_work_mode');
            });
        }

        // Create work_mode_requests table
        if (!Schema::hasTable('work_mode_requests')) {
            Schema::create('work_mode_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('placement_id')->constrained('placements')->onDelete('cascade');
                $table->date('date');
                $table->string('requested_mode'); // wfo, wfh, wfa
                $table->text('reason');
                $table->string('status')->default('pending'); // pending, approved, rejected
                $table->text('dudi_notes')->nullable();
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamp('reviewed_at')->nullable();
                $table->timestamps();

                $table->index(['student_id', 'date']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_mode_requests');

        if (Schema::hasTable('placements') && Schema::hasColumn('placements', 'work_schedule')) {
            Schema::table('placements', function (Blueprint $table) {
                $table->dropColumn('work_schedule');
            });
        }
    }
};
