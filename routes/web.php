<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'index'])->name('dashboard');
    Route::post('/lomba', [OperatorController::class, 'storeLomba'])->name('lomba.store');
    Route::get('/lomba/{id}', [OperatorController::class, 'show'])->name('lomba.show');
    Route::post('/lomba/{id}/tim', [OperatorController::class, 'storeTim'])->name('tim.store');
    
    // Panel Kontrol & Fitur Nilai
    Route::get('/lomba/{id}/panel', [OperatorController::class, 'panel'])->name('lomba.panel');
    Route::post('/lomba/{id}/skor/{timId}', [OperatorController::class, 'updateSkor'])->name('lomba.updateSkor');
    Route::post('/lomba/{id}/skor/{timId}/set', [OperatorController::class, 'setSkor'])->name('lomba.setSkor');
    Route::post('/lomba/{id}/reset-skor', [OperatorController::class, 'resetSkor'])->name('lomba.resetSkor');
});

// Rute publik untuk Smart Board
Route::get('/lomba/{id}/display', [OperatorController::class, 'display'])->name('lomba.display');

require __DIR__.'/auth.php';