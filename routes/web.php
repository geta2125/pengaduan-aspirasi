<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriPengaduanController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\TindakLanjutController;


// ==========================
// REDIRECT KE LOGIN
// ==========================
Route::get('/', function () {
    return redirect()->route('login');
});


// ==========================
// LOGIN & REGISTER (GUEST)
// ==========================

Route::middleware('guest')->group(function () {
    // Login Admin
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');

    // Login Guest
    Route::get('/guest/login', [LoginController::class, 'guestLogin'])->name('guest.login');
    Route::post('/guest/login', [LoginController::class, 'guestAuthenticate'])->name('guest.login.process');

    // Register Guest
    Route::get('/guest/register', [RegisterController::class, 'guestRegister'])->name('guest.register');
    Route::post('/guest/register', [RegisterController::class, 'guestStore'])->name('guest.register.store');
});


// ==========================
// AREA LOGIN (AUTH)
// ==========================
Route::middleware('auth')->group(function () {

    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // ==========================
    // DASHBOARD
    // ==========================
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/edit-profile', [DashboardController::class, 'Profile'])->name('dashboard.profile');
        Route::put('/update-profile', [DashboardController::class, 'updateProfile'])->name('dashboard.updateProfile');
        Route::put('/update-password', [DashboardController::class, 'updatePassword'])->name('dashboard.updatePassword');
        Route::put('/update-foto', [DashboardController::class, 'updateFoto'])->name('dashboard.updateFoto');
    });


    // ==========================
    // ADMIN AREA
    // ==========================
    Route::prefix('admin')->as('admin.')->group(function () {

        // ---- Modul User ----
        Route::resource('user', UserController::class);

        // ---- Modul Kategori Pengaduan ----
        Route::prefix('kategori-pengaduan')->as('kategori-pengaduan.')->group(function () {
            Route::get('/', [KategoriPengaduanController::class, 'index'])->name('index');
            Route::get('/create', [KategoriPengaduanController::class, 'create'])->name('create');
            Route::post('/', [KategoriPengaduanController::class, 'store'])->name('store');
            Route::get('/{id}', [KategoriPengaduanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [KategoriPengaduanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KategoriPengaduanController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriPengaduanController::class, 'destroy'])->name('destroy');
        });

        // ---- Pengaduan Admin ----
        Route::prefix('pengaduan')->as('pengaduan.')->group(function () {
            Route::get('/baru', [PengaduanController::class, 'pengaduanBaru'])->name('baru');
        });

        // ---- Tindak Lanjut ----
        Route::prefix('tindaklanjut')->as('tindaklanjut.')->group(function () {
            Route::get('/', [TindakLanjutController::class, 'index'])->name('index');
            Route::get('/{pengaduan_id}/create', [TindakLanjutController::class, 'create'])->name('create');
            Route::post('/{pengaduan_id}', [TindakLanjutController::class, 'store'])->name('store');
            Route::get('/{id}/show', [TindakLanjutController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [TindakLanjutController::class, 'edit'])->name('edit');
            Route::put('/{id}', [TindakLanjutController::class, 'update'])->name('update');
            Route::delete('/{id}', [TindakLanjutController::class, 'destroy'])->name('destroy');
        });
    });

    // ==========================
    // PENILAIAN
    // ==========================
    Route::prefix('penilaian')->as('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/pengaduan', [PenilaianController::class, 'pengaduan'])->name('pengaduan');
        Route::get('/create/{pengaduan_id}', [PenilaianController::class, 'create'])->name('create');
        Route::post('/store', [PenilaianController::class, 'store'])->name('store');
        Route::get('/layanan', [PenilaianController::class, 'layanan'])->name('layanan');
    });


    // -------------------------
    // WARGA
    // -------------------------
    Route::prefix('guest')->as('guest.')->group(function () {
        Route::get('/warga', [WargaController::class, 'create'])->name('warga.create');
        Route::put('/warga/update', [WargaController::class, 'update'])->name('warga.update');

        // ==========================
        // ROUTE PENGADUAN
        // ==========================
        Route::get('/pengaduan/ajukan', [PengaduanController::class, 'ajukan'])->name('pengaduan.ajukan');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
        Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'ajukan'])->name('pengaduan.edit'); // pakai view sama
        Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
        Route::get('/pengaduan/riwayat', [PengaduanController::class, 'riwayat'])->name('pengaduan.riwayat');
        Route::get('/pengaduan/show/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');

        Route::get('/penilaian/pengaduan', [PenilaianController::class, 'pengaduan'])->name('penilaian.pengaduan');
        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('penilaian/create/{pengaduan_id}', [PenilaianController::class, 'create'])
            ->name('penilaian.create');
        Route::post('penilaian/store', [PenilaianController::class, 'store'])
            ->name('penilaian.store');


    // ==========================
    // ROUTE PENILAIAN LAYANAN
    // ==========================
    Route::get('/penilaian-layanan', [PenilaianController::class, 'index'])->name('penilaian.layanan');
    });




});
