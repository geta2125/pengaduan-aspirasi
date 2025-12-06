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


// ====================================================================
// REDIRECT HALAMAN AWAL KE LOGIN
// ====================================================================
Route::get('/', function () {
    return redirect()->route('login');
});


// ====================================================================
// LOGIN & REGISTER (GUEST)
// ====================================================================
Route::middleware('guest')->group(function () {

    // Login Admin
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');

    // // Login Guest
    // Route::get('/guest/login', [LoginController::class, 'guestLogin'])->name('guest.login');
    // Route::post('/guest/login', [LoginController::class, 'guestAuthenticate'])->name('guest.login.process');

    // // Register Guest
    // Route::get('/guest/register', [RegisterController::class, 'guestRegister'])->name('guest.register');
    // Route::post('/guest/register', [RegisterController::class, 'guestStore'])->name('guest.register.store');
});


// ====================================================================
// AREA SETELAH LOGIN (AUTH)
// ====================================================================
Route::middleware('auth')->group(function () {

    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


    // ====================================================================
    // DASHBOARD
    // ====================================================================
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/edit-profile', [DashboardController::class, 'Profile'])->name('dashboard.profile');
        Route::put('/update-profile', [DashboardController::class, 'updateProfile'])->name('dashboard.updateProfile');
        Route::put('/update-password', [DashboardController::class, 'updatePassword'])->name('dashboard.updatePassword');
        Route::put('/update-foto', [DashboardController::class, 'updateFoto'])->name('dashboard.updateFoto');
    });


    // ====================================================================
    // ADMIN AREA
    // ====================================================================
    Route::prefix('admin')->as('admin.')->group(function () {

        // ---------------------------
        // WARGA
        // ---------------------------
        Route::prefix('warga')->as('warga.')->group(function () {

            // Index & Form
            Route::get('/', [WargaController::class, 'index'])->name('index');
            Route::get('/create', [WargaController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [WargaController::class, 'edit'])->name('edit');

            // Step 1 & Step 2 Store
            Route::post('/store-account', [WargaController::class, 'storeAccount'])->name('storeAccount');
            Route::post('/store', [WargaController::class, 'store'])->name('store');

            // Update & Delete
            Route::put('/{id}', [WargaController::class, 'update'])->name('update');
            Route::delete('/{id}', [WargaController::class, 'destroy'])->name('destroy');

            // Detail (LETakkan PALING AKHIR supaya tidak tabrakan dengan route lain!)
            Route::get('/{id}', [WargaController::class, 'show'])->name('show');
        });


        // ---------------------------
        // KATEGORI PENGADUAN
        // ---------------------------
        Route::prefix('kategori-pengaduan')->as('kategori-pengaduan.')->group(function () {
            Route::get('/', [KategoriPengaduanController::class, 'index'])->name('index');
            Route::get('/create', [KategoriPengaduanController::class, 'create'])->name('create');
            Route::post('/', [KategoriPengaduanController::class, 'store'])->name('store');
            Route::get('/{id}', [KategoriPengaduanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [KategoriPengaduanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KategoriPengaduanController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriPengaduanController::class, 'destroy'])->name('destroy');
        });


        // ---------------------------
        // PENGADUAN ADMIN
        // ---------------------------
        Route::prefix('pengaduan')->as('pengaduan.')->group(function () {
            Route::get('/', [PengaduanController::class, 'index'])->name('index');
            Route::get('/create', [PengaduanController::class, 'create'])->name('create');
            Route::post('/', [PengaduanController::class, 'store'])->name('store');
            Route::get('/{id}', [PengaduanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PengaduanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PengaduanController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengaduanController::class, 'destroy'])->name('destroy');

            // extra untuk memisahkan view semua pengaduan
            Route::get('/semua', [PengaduanController::class, 'pengaduanSemua'])->name('semua');
        });


        // ---------------------------
        // TINDAK LANJUT
        // ---------------------------
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


    // ====================================================================
    // PENILAIAN LAYANAN
    // ====================================================================
    Route::prefix('penilaian')->as('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/pengaduan', [PenilaianController::class, 'pengaduan'])->name('pengaduan');
        Route::get('/create/{pengaduan_id}', [PenilaianController::class, 'create'])->name('create');
        Route::post('/store', [PenilaianController::class, 'store'])->name('store');
        Route::get('/layanan', [PenilaianController::class, 'layanan'])->name('layanan');
    });


    // ====================================================================
    // AREA WARGA (GUEST)
    // ====================================================================
    Route::prefix('guest')->as('guest.')->group(function () {

        // Pengaduan
        Route::get('/pengaduan/ajukan', [PengaduanController::class, 'ajukan'])->name('pengaduan.ajukan');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
        Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'ajukan'])->name('pengaduan.edit');
        Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
        Route::get('/pengaduan/riwayat', [PengaduanController::class, 'riwayat'])->name('pengaduan.riwayat');
        Route::get('/pengaduan/show/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');

        // Penilaian
        Route::get('/penilaian/pengaduan', [PenilaianController::class, 'pengaduan'])->name('penilaian.pengaduan');
        Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('penilaian/create/{pengaduan_id}', [PenilaianController::class, 'create'])->name('penilaian.create');
        Route::post('penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');

        // Penilaian Layanan
        Route::get('/penilaian-layanan', [PenilaianController::class, 'index'])->name('penilaian.layanan');
    });
});
