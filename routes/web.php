<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AttendanceController; 
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// =====================
// AUTH
// =====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/call-admin', fn() => view('auth.call-admin'))->name('call-admin');

// =====================
// ROUTE AUTH TERPROTEKSI
// =====================
Route::middleware('auth')->group(function () {

    // ---------------------
    // DASHBOARD UMUM
    // ---------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ---------------------
    // GURU
    // ---------------------
    Route::get('/manual', fn() => view('guru.absen-manual'))->name('guru.manual');
    Route::get('/qr', [AttendanceController::class, 'index'])->name('guru.qr');
    Route::get('/download', fn() => view('guru.download-absen'))->name('guru.download');

    Route::middleware(['checkRole:guru'])->group(function () {
        Route::get('/guru/dashboard', fn() => view('guru.dashboard'))->name('guru.dashboard');
    });

    // ---------------------
    // ADMIN
    // ---------------------
    Route::middleware(['checkRole:admin'])->group(function () {

        // Dashboard
        Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

        // Absen QR Scanner
        Route::get('/admin/absen-scanner', [AttendanceController::class, 'index'])->name('admin.absen.index');
        Route::post('/admin/absen-scanner/store', [AttendanceController::class, 'store'])->name('admin.absen.store');

        // DATA SISWA
        Route::prefix('admin/data-siswa')->group(function () {
            Route::get('/', [SiswaController::class, 'index'])->name('admin.data-siswa');
            Route::post('/', [SiswaController::class, 'store'])->name('admin.siswa.store');
            Route::post('/import', [SiswaController::class, 'import'])->name('admin.siswa.import');
            Route::put('/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
            Route::delete('/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.delete');
            Route::get('/{id}/qr', [SiswaController::class, 'downloadQR'])->name('admin.siswa.qr');
            Route::get('/filter', [SiswaController::class, 'filter'])->name('admin.siswa.filter');
        });

        // QR GENERATOR (opsional)
        Route::get('/admin/generate-qr', fn(Request $request) => response(
            \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($request->token)
        )->header('Content-Type', 'image/svg+xml'));

        Route::get('/admin/download-qr', fn(Request $request) => response(
            \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->size(300)
                ->generate($request->token)
        )
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'attachment; filename="qr-absen-'.$request->token.'.png"'));

        // DATA GURU
        Route::prefix('admin/data-guru')->group(function () {
            Route::get('/', [GuruController::class, 'index'])->name('admin.data-guru');
            Route::post('/', [GuruController::class, 'store'])->name('admin.guru.store');
            Route::put('/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
            Route::delete('/{id}', [GuruController::class, 'destroy'])->name('admin.guru.delete');
        });
    });
});