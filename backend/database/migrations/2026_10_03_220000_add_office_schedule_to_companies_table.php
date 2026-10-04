<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('companies') && !Schema::hasColumn('companies', 'office_schedule')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->json('office_schedule')->nullable()->after('allowed_work_modes');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('companies') && Schema::hasColumn('companies', 'office_schedule')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->dropColumn('office_schedule');
            });
        }
    }
};
