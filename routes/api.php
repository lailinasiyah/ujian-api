<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\UjianController;

// Peserta API (dummy tanpa DB)
Route::get('/peserta', [PesertaController::class, 'index']);
Route::post('/peserta', [PesertaController::class, 'store']);
Route::get('/peserta/{id}', [PesertaController::class, 'show']);
Route::put('/peserta/{id}', [PesertaController::class, 'update']);
Route::delete('/peserta/{id}', [PesertaController::class, 'destroy']);

// Ujian API
Route::get('/ujian', [UjianController::class, 'default']);
Route::post('/ujian/hitung', [UjianController::class, 'hitung']);
