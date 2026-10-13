<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\SiswaController;
use Illuminate\Support\Facades\Route;

// Public routes (Rate-limited to prevent brute-force attacks)
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('/demo-switch', [AuthController::class, 'demoSwitch']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth & Profile
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // 1. Modul Siswa
    Route::prefix('siswa')->middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard']);
        Route::post('/check-in', [SiswaController::class, 'checkIn']);
        Route::post('/check-out', [SiswaController::class, 'checkOut']);
        Route::get('/attendance-history', [SiswaController::class, 'getAttendanceHistory']);
        Route::get('/logbooks', [SiswaController::class, 'getLogbooks']);
        Route::post('/logbooks', [SiswaController::class, 'storeLogbook']);
        Route::get('/placement', [SiswaController::class, 'getPlacementInfo']);
        Route::post('/request-work-mode', [SiswaController::class, 'requestWorkMode']);
        Route::get('/work-mode-requests', [SiswaController::class, 'getWorkModeRequests']);
    });

    // 2. Modul Pembimbing Lapangan (Instansi / Perusahaan)
    Route::prefix('mentor')->middleware('role:mentor,dudi,admin')->group(function () {
        Route::get('/dashboard', [MentorController::class, 'dashboard']);
        Route::get('/students', [MentorController::class, 'getStudents']);
        Route::get('/students/{id}/logbooks', [MentorController::class, 'getStudentLogbooks']);
        Route::post('/logbooks/{id}/validate', [MentorController::class, 'validateLogbook']);
        Route::post('/logbooks/batch-validate', [MentorController::class, 'batchValidateLogbooks']);
        Route::get('/attendance-recap', [MentorController::class, 'getAttendanceRecap']);
        Route::post('/attendances/{id}/review-dispute', [MentorController::class, 'reviewAttendanceDispute']);
        Route::get('/work-mode-requests', [MentorController::class, 'getWorkModeRequests']);
        Route::post('/work-mode-requests/{id}/review', [MentorController::class, 'reviewWorkModeRequest']);
        Route::get('/students-schedules', [MentorController::class, 'getStudentsWithSchedules']);
        Route::put('/placements/{id}/schedule', [MentorController::class, 'updateStudentSchedule']);
        Route::get('/company-schedule', [MentorController::class, 'getCompanyOfficeSchedule']);
        Route::put('/company-schedule', [MentorController::class, 'updateCompanyOfficeSchedule']);
        Route::get('/evaluations', [MentorController::class, 'getEvaluations']);
        Route::post('/evaluations', [MentorController::class, 'storeEvaluation']);
    });

    // Alias prefix dudi untuk kompatibilitas frontend lama
    Route::prefix('dudi')->middleware('role:mentor,dudi,admin')->group(function () {
        Route::get('/dashboard', [MentorController::class, 'dashboard']);
        Route::get('/students', [MentorController::class, 'getStudents']);
        Route::get('/students/{id}/logbooks', [MentorController::class, 'getStudentLogbooks']);
        Route::post('/logbooks/{id}/validate', [MentorController::class, 'validateLogbook']);
        Route::post('/logbooks/batch-validate', [MentorController::class, 'batchValidateLogbooks']);
        Route::get('/attendance-recap', [MentorController::class, 'getAttendanceRecap']);
        Route::post('/attendances/{id}/review-dispute', [MentorController::class, 'reviewAttendanceDispute']);
        Route::get('/work-mode-requests', [MentorController::class, 'getWorkModeRequests']);
        Route::post('/work-mode-requests/{id}/review', [MentorController::class, 'reviewWorkModeRequest']);
        Route::get('/students-schedules', [MentorController::class, 'getStudentsWithSchedules']);
        Route::put('/placements/{id}/schedule', [MentorController::class, 'updateStudentSchedule']);
        Route::get('/company-schedule', [MentorController::class, 'getCompanyOfficeSchedule']);
        Route::put('/company-schedule', [MentorController::class, 'updateCompanyOfficeSchedule']);
        Route::get('/evaluations', [MentorController::class, 'getEvaluations']);
        Route::post('/evaluations', [MentorController::class, 'storeEvaluation']);
    });

    // 3. Modul Guru Pembimbing
    Route::prefix('guru')->middleware('role:guru,admin')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard']);
        Route::get('/students', [GuruController::class, 'getStudents']);
        Route::get('/students/{id}/monitor', [GuruController::class, 'monitorStudentLogbooks']);
        Route::post('/students/{id}/advisory-note', [GuruController::class, 'storeAdvisoryNote']);
        Route::post('/attendances/{id}/review-dispute', [GuruController::class, 'reviewAttendanceDispute']);
        Route::get('/grades', [GuruController::class, 'getGradesCompilation']);
        Route::post('/grades/{id}/school-report', [GuruController::class, 'updateSchoolReportScore']);
    });

    // 4. Modul Admin / Kaprog
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/master-data', [AdminController::class, 'getMasterData']);
        Route::post('/master-data', [AdminController::class, 'storeMasterData']);
        Route::put('/master-data/{id}', [AdminController::class, 'updateMasterData']);
        Route::delete('/master-data/{id}', [AdminController::class, 'deleteMasterData']);
        Route::post('/master-data/import', [AdminController::class, 'importMasterData']);
        Route::get('/plotting', [AdminController::class, 'getPlottingData']);
        Route::post('/plotting', [AdminController::class, 'assignPlacement']);
        Route::post('/placements/{id}/relocate', [AdminController::class, 'relocatePlacement']);
        Route::get('/reports', [AdminController::class, 'getReports']);
    });
});
