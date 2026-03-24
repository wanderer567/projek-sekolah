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

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/manual', fn() => view('guru.absen-manual'))->name('guru.manual');
    Route::get('/qr', fn() => view('guru.absen-qr'))->name('guru.qr');
    Route::get('/donwload', fn() => view('guru.donwload-absen'))->name('guru.donwload');

    Route::middleware(['checkRole:admin'])->group(function () {

        Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

        // halaman data siswa level
        Route::get('/admin/data-siswa', [SiswaController::class, 'index'])->name('admin.data-siswa'); // tampil halaman

        Route::post('/admin/data-siswa', [SiswaController::class, 'store'])->name('admin.siswa.store'); // tambah manual

        Route::post('/admin/data-siswa/import', [SiswaController::class, 'import'])->name('admin.siswa.import'); // import excel

        Route::put('/admin/data-siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update'); // edit

        Route::delete('/admin/data-siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.delete'); // hapus

        Route::get('/admin/data-siswa/filter', [SiswaController::class, 'filter'])
    ->name('admin.siswa.filter');
        // Route::get('/admin/data-siswa/filter', [SiswaController::class, 'filter'])->name('admin.siswa.filter');
        // ------------

        //  halaman data gutu level 
        Route::get('/admin/data-guru', [GuruController::class, 'index'])->name('admin.data-guru');

        Route::post('/admin/data-guru', [GuruController::class, 'store'])->name('admin.guru.store');

        Route::put('/admin/data-guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');

        Route::delete('/admin/data-guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.delete');
        // ------------
    });

    Route::middleware(['checkRole:guru'])->group(function () {
        Route::get('/guru/dashboard', fn() => view('guru.dashboard'))->name('guru.dashboard');
    });
});