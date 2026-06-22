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
    Route::delete('/lomba/{id}', [OperatorController::class, 'destroy'])->name('lomba.destroy');
    Route::get('/lomba/{id}', [OperatorController::class, 'show'])->name('lomba.show');
    Route::post('/lomba/{id}/tim', [OperatorController::class, 'storeTim'])->name('tim.store');
    
    // Panel Kontrol & Fitur Nilai
    Route::get('/lomba/{id}/panel', [OperatorController::class, 'panel'])->name('lomba.panel');
    Route::post('/lomba/{id}/skor/{timId}', [OperatorController::class, 'updateSkor'])->name('lomba.updateSkor');
    Route::post('/lomba/{id}/skor/{timId}/set', [OperatorController::class, 'setSkor'])->name('lomba.setSkor');
    Route::post('/lomba/{id}/reset-skor', [OperatorController::class, 'resetSkor'])->name('lomba.resetSkor');

    // Fitur Khusus Lomba Dakwah
    Route::get('/lomba/{id}/dakwah-panel', [OperatorController::class, 'dakwahPanel'])->name('lomba.dakwahPanel');
    Route::post('/lomba/{id}/dakwah-sync', [OperatorController::class, 'dakwahSync'])->name('lomba.dakwahSync');
    Route::get('/lomba/{id}/dakwah-display', [OperatorController::class, 'dakwahDisplay'])->name('lomba.dakwahDisplay');

    // Fitur Khusus Lomba Mudzakarah
    Route::get('/lomba/{id}/mudzakarah-panel', [OperatorController::class, 'mudzakarahPanel'])->name('lomba.mudzakarahPanel');
    Route::post('/lomba/{id}/mudzakarah-sync', [OperatorController::class, 'mudzakarahSync'])->name('lomba.mudzakarahSync');
    Route::get('/lomba/{id}/mudzakarah-display', [OperatorController::class, 'mudzakarahDisplay'])->name('lomba.mudzakarahDisplay');

    // Fitur Kontrol Video Bumper Global
    Route::post('/bumper-sync', [OperatorController::class, 'bumperSync'])->name('bumper.sync');
});

// Rute publik untuk Smart Board
Route::get('/lomba/{id}/display', [OperatorController::class, 'display'])->name('lomba.display');

require __DIR__.'/auth.php';