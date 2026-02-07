<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/call-admin', function () {
    return view('auth.call-admin');
})->name('call-admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/absen', [AbsenController::class, 'index']);
    Route::post('/absen-hadir', [AbsenController::class, 'store']);
    Route::get('/siswa', [SiswaController::class, 'index']);
    
    
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});



Route::get('/dashboard-absensi', function () {
    return view('dashboard');
});

require __DIR__.'/auth.php';
