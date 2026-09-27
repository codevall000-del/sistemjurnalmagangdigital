<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\DudiController;
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
    });

    // 2. Modul Pembimbing Industri (DUDI)
    Route::prefix('dudi')->group(function () {
        Route::get('/dashboard', [DudiController::class, 'dashboard']);
        Route::get('/students', [DudiController::class, 'getStudents']);
        Route::get('/students/{id}/logbooks', [DudiController::class, 'getStudentLogbooks']);
        Route::post('/logbooks/{id}/validate', [DudiController::class, 'validateLogbook']);
        Route::get('/attendance-recap', [DudiController::class, 'getAttendanceRecap']);
        Route::get('/evaluations', [DudiController::class, 'getEvaluations']);
        Route::post('/evaluations', [DudiController::class, 'storeEvaluation']);
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
