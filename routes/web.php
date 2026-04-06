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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/call-admin', function () {
    return view('auth.call-admin');
})->name('call-admin');

Route::middleware('auth')->group(function () {

    // =====================
    // DASHBOARD & AUTH
    // =====================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // =====================
    // GURU
    // =====================
    Route::get('/manual', fn() => view('guru.absen-manual'))->name('guru.manual');
    Route::get('/qr', [AttendanceController::class, 'index'])->name('guru.qr');
    Route::get('/donwload', fn() => view('guru.donwload-absen'))->name('guru.donwload');

    // =====================
    // ADMIN
    // =====================
    Route::middleware(['checkRole:admin'])->group(function () {

        // Dashboard
        Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

        // =====================
        // ABSEN QR (SCANNER)
        // =====================
        Route::get('/admin/absen-scanner', [AttendanceController::class, 'index'])->name('admin.absen.index');
        Route::post('/admin/absen-scanner/store', [AttendanceController::class, 'store'])->name('admin.absen.store');

        // =====================
        // DATA SISWA
        // =====================
        Route::get('/admin/data-siswa', [SiswaController::class, 'index'])->name('admin.data-siswa');
        Route::post('/admin/data-siswa', [SiswaController::class, 'store'])->name('admin.siswa.store'); 
        Route::post('/admin/data-siswa/import', [SiswaController::class, 'import'])->name('admin.siswa.import');
        Route::put('/admin/data-siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
        Route::delete('/admin/data-siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.delete');

        // 🔥 INI YANG TADI KURANG (FIX ERROR)
        Route::get('/admin/data-siswa/{id}/qr', [SiswaController::class, 'downloadQR'])
            ->name('admin.siswa.qr');

        Route::get('/admin/data-siswa/filter', [SiswaController::class, 'filter'])->name('admin.siswa.filter');

        // =====================
        // QR GENERATOR (OPSIONAL)
        // =====================
        Route::get('/admin/generate-qr', function (Request $request) {
            return response(
                \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($request->token)
            )->header('Content-Type', 'image/svg+xml');
        });

        Route::get('/admin/download-qr', function (Request $request) {
            $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->size(300)
                ->generate($request->token);

            return response($qr)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="qr-absen-'.$request->token.'.png"');
        });

        // =====================
        // DATA GURU
        // =====================
        Route::get('/admin/data-guru', [GuruController::class, 'index'])->name('admin.data-guru');
        Route::post('/admin/data-guru', [GuruController::class, 'store'])->name('admin.guru.store');
        Route::put('/admin/data-guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
        Route::delete('/admin/data-guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.delete');
    });

    // =====================
    // GURU ROLE
    // =====================
    Route::middleware(['checkRole:guru'])->group(function () {
        Route::get('/guru/dashboard', fn() => view('guru.dashboard'))->name('guru.dashboard');
    });
});