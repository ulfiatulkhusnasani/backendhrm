<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\CutiController;

// Rute Publik
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('absensi', AbsensiController::class);

// Rute yang Memerlukan Autentikasi Menggunakan Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    
    // Rute untuk AbsensiController
    Route::get('/absensi/created', [AbsensiController::class, 'index']);
    Route::post('/absensi', [AbsensiController::class, 'store']);
    Route::get('/absensi/{id}', [AbsensiController::class, 'show']);
    Route::put('/absensi/{id}', [AbsensiController::class, 'update']);
    Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy']);
    
    // Rute untuk KaryawanController
    Route::post('/karyawan/created', [KaryawanController::class, 'store']);
    Route::get('/karyawan', [KaryawanController::class, 'index']); 
    Route::get('/karyawan/{id}', [KaryawanController::class, 'show']);
    Route::put('/karyawan/{id}', [KaryawanController::class, 'update']);
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);

    // Rute untuk LemburController
    Route::post('/lembur', [LemburController::class, 'store']);
    Route::get('/lembur', [LemburController::class, 'index']);
    Route::get('/lembur/{id}', [LemburController::class, 'show']);
    Route::put('/lembur/{id}', [LemburController::class, 'update']);
    Route::delete('/lembur/{id}', [LemburController::class, 'destroy']);

    // Rute untuk CutiController
    Route::post('/cuti', [CutiController::class, 'store']);
    Route::get('/cuti', [CutiController::class, 'index']);
    Route::get('/cuti/{id}', [CutiController::class, 'show']);
    Route::put('/cuti/{id}', [CutiController::class, 'update']);
    Route::delete('/cuti/{id}', [CutiController::class, 'destroy']);
});
