<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/call-admin', function () {
    return view('auth.call-admin');
})->name('call-admin');

// Harus Login
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Ubah ke POST agar aman

    // Fitur Umum (Bisa diakses Admin & Guru)
    Route::get('/manual', function () { return view('guru.absen-manual'); })->name('guru.manual');
    Route::get('/qr', function (){ return view('guru.absen-qr'); })->name('guru.qr');
    Route::get('/donwload', function () { return view('guru.donwload-absen'); })->name('guru.donwload');

   Route::middleware(['checkRole:admin'])->group(function () {
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');

    // CRUD Siswa
    Route::get('/admin/data-siswa', [SiswaController::class, 'index'])->name('admin.data-siswa');
    Route::post('/admin/data-siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::put('/admin/data-siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/data-siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.delete');

    // --- PERBAIKAN CRUD GURU (Ganti baris yang lama dengan ini) ---
    Route::get('/admin/data-guru', [GuruController::class, 'index'])->name('admin.data-guru');
    Route::post('/admin/data-guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::put('/admin/data-guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/admin/data-guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.delete');
});

    // --- KHUSUS ROLE: GURU ---
    Route::middleware(['checkRole:guru'])->group(function () {
        Route::get('/guru/dashboard', function () {
            return view('guru.dashboard');
        })->name('guru.dashboard');    
    });
});