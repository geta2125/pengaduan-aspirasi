<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\Admin\KategoriPengaduanController;

// =====================================================
// Redirect awal
// =====================================================
Route::redirect('/', '/login');

// =====================================================
// Login (public)
// =====================================================
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');

// =====================================================
// Area setelah login
// =====================================================
Route::middleware(['checkislogin', 'auth'])->group(function () {

    // logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // =====================================================
    // Dashboard (super admin, admin, petugas)
    // =====================================================
    Route::prefix('dashboard')
        ->middleware('role:super admin,admin,petugas')
        ->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');
        });

    // =====================================================
    // Profile (semua yang login)
    // =====================================================
    Route::get('/profile', [DashboardController::class, 'Profile'])->name('profile');
    Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('update.profile');
    Route::put('/profile/password', [DashboardController::class, 'updatePassword'])->name('update.password');
    Route::put('/profile/foto', [DashboardController::class, 'updateFoto'])->name('update.foto');

    // =====================================================
    // USER
    // super admin: index & show
    // admin: full
    // =====================================================
    Route::middleware('role:admin,super admin')->group(function () {
        Route::resource('user', UserController::class)->only(['index', 'show']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('user', UserController::class)->except(['index', 'show']);
    });

    // =====================================================
    // WARGA
    // super admin: index & show
    // admin: full (+storeAccount)
    // =====================================================
    Route::middleware('role:admin,super admin')->group(function () {
        Route::resource('warga', WargaController::class)
            ->only(['index', 'show'])
            ->parameters(['warga' => 'id']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::post('warga/store-account', [WargaController::class, 'storeAccount'])->name('warga.storeAccount');

        Route::resource('warga', WargaController::class)
            ->except(['index', 'show'])
            ->parameters(['warga' => 'id']);
    });

    // =====================================================
    // KATEGORI PENGADUAN
    // super admin: index & show
    // admin: full
    // =====================================================
    Route::middleware('role:admin,super admin')->group(function () {
        Route::resource('kategori-pengaduan', KategoriPengaduanController::class)
            ->only(['index', 'show'])
            ->parameters(['kategori-pengaduan' => 'id']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('kategori-pengaduan', KategoriPengaduanController::class)
            ->except(['index', 'show'])
            ->parameters(['kategori-pengaduan' => 'id']);
    });

    // =====================================================
    // PENGADUAN
    // super admin: read-only
    // admin: full
    // petugas: read + edit/update
    // guest: create/store + show (sesuai catatan kamu)
    // =====================================================

    // IMPORTANT: taruh route static dulu biar nggak ketangkep {id}
    Route::middleware('role:super admin,admin,petugas,guest')->group(function () {
        Route::get('pengaduan/semua', [PengaduanController::class, 'pengaduanSemua'])->name('pengaduan.semua');

        Route::resource('pengaduan', PengaduanController::class)
            ->only(['index', 'show'])
            ->parameters(['pengaduan' => 'id']);
    });

    Route::middleware('role:admin,guest')->group(function () {
        Route::resource('pengaduan', PengaduanController::class)
            ->only(['create', 'store'])
            ->parameters(['pengaduan' => 'id']);
    });

    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('pengaduan', PengaduanController::class)
            ->only(['edit', 'update'])
            ->parameters(['pengaduan' => 'id']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('pengaduan', PengaduanController::class)
            ->only(['destroy'])
            ->parameters(['pengaduan' => 'id']);
    });

    // =====================================================
    // TINDAK LANJUT
    // (tetap manual karena path-nya custom: /{id}/show dan create/store pakai pengaduan_id)
    // =====================================================
    Route::prefix('tindaklanjut')->as('tindaklanjut.')->group(function () {

        Route::middleware('role:admin,super admin,petugas')->group(function () {
            Route::get('/', [TindakLanjutController::class, 'index'])->name('index');
            Route::get('/{id}/show', [TindakLanjutController::class, 'show'])->name('show');
        });

        Route::middleware('role:admin')->group(function () {
            Route::get('/{pengaduan_id}/create', [TindakLanjutController::class, 'create'])->name('create');
            Route::post('/{pengaduan_id}', [TindakLanjutController::class, 'store'])->name('store');
            Route::delete('/{id}', [TindakLanjutController::class, 'destroy'])->name('destroy');
        });

        Route::middleware('role:admin,petugas')->group(function () {
            Route::get('/{id}/edit', [TindakLanjutController::class, 'edit'])->name('edit');
            Route::put('/{id}', [TindakLanjutController::class, 'update'])->name('update');
        });
    });

    // =====================================================
    // PENILAIAN (admin, super admin, guest)
    // =====================================================
    Route::middleware('role:admin,super admin,guest')->group(function () {
        Route::resource('penilaian', PenilaianController::class)
            ->only(['index', 'store', 'show', 'update', 'destroy']);
    });

    // =====================================================
    // Static pages
    // =====================================================
    Route::view('/developer', 'admin.developer.index')->name('developer.index');
    Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
    Route::view('/terms-of-use', 'terms-of-use')->name('terms.use');
});

// 1. super admin : bisa liat dashboard hanya bisa melihat semua table (index dan show) tidak bisa edit,tidak bisa hapus
// 2. admin : bisa semua
// 3. petugas : bisa lihat dashboard,lihat pengaduan dan tindak lanjut bisa edit
// 4. guest = hanya bisa mengisi form tambah warga dan form,show -> pengaduan
