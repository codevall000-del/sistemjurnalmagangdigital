<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\AdminController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/demo-switch', [AuthController::class, 'demoSwitch']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth & Profile
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // 1. Modul Siswa
    Route::prefix('siswa')->group(function () {
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
    Route::prefix('mentor')->group(function () {
        Route::get('/dashboard', [MentorController::class, 'dashboard']);
        Route::get('/students', [MentorController::class, 'getStudents']);
        Route::get('/students/{id}/logbooks', [MentorController::class, 'getStudentLogbooks']);
        Route::post('/logbooks/{id}/validate', [MentorController::class, 'validateLogbook']);
        Route::get('/attendance-recap', [MentorController::class, 'getAttendanceRecap']);
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
    Route::prefix('dudi')->group(function () {
        Route::get('/dashboard', [MentorController::class, 'dashboard']);
        Route::get('/students', [MentorController::class, 'getStudents']);
        Route::get('/students/{id}/logbooks', [MentorController::class, 'getStudentLogbooks']);
        Route::post('/logbooks/{id}/validate', [MentorController::class, 'validateLogbook']);
        Route::get('/attendance-recap', [MentorController::class, 'getAttendanceRecap']);
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
    Route::prefix('guru')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard']);
        Route::get('/students', [GuruController::class, 'getStudents']);
        Route::get('/students/{id}/monitor', [GuruController::class, 'monitorStudentLogbooks']);
        Route::get('/grades', [GuruController::class, 'getGradesCompilation']);
        Route::post('/grades/{id}/school-report', [GuruController::class, 'updateSchoolReportScore']);
    });

    // 4. Modul Admin / Kaprog
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/master-data', [AdminController::class, 'getMasterData']);
        Route::post('/master-data', [AdminController::class, 'storeMasterData']);
        Route::put('/master-data/{id}', [AdminController::class, 'updateMasterData']);
        Route::delete('/master-data/{id}', [AdminController::class, 'deleteMasterData']);
        Route::post('/master-data/import', [AdminController::class, 'importMasterData']);
        Route::get('/plotting', [AdminController::class, 'getPlottingData']);
        Route::post('/plotting', [AdminController::class, 'assignPlacement']);
        Route::get('/reports', [AdminController::class, 'getReports']);
    });
});
