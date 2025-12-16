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
Route::get('/', fn() => redirect()->route('login'));

// =====================================================
// Login (public)
// =====================================================
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');

// =====================================================
// Area setelah login
// =====================================================
Route::middleware(['checkislogin'])->group(function () {

    // logout (semua yang login)
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // =====================================================
    // Dashboard (super admin, admin, petugas)
    // =====================================================
    Route::prefix('dashboard')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware(['role:super admin,admin,petugas']);

        Route::get('/data', [DashboardController::class, 'getDashboardData'])
            ->name('dashboard.data')
            ->middleware(['role:super admin,admin,petugas']);
    });

    Route::middleware(['auth'])->group(function () {
        // Route untuk menampilkan halaman profil
        Route::get('/profile', [DashboardController::class, 'Profile'])->name('profile');

        // Route untuk update nama, username, email
        Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('update.profile');

        // Route untuk update password
        Route::put('/profile/password', [DashboardController::class, 'updatePassword'])->name('update.password');

        // Route untuk update foto profil
        Route::put('/profile/foto', [DashboardController::class, 'updateFoto'])->name('update.foto');
    });

    // =====================================================
    // ADMIN PREFIX
    // =====================================================

    // USER (static dulu)
    Route::get('user', [UserController::class, 'index'])->name('user.index')->middleware(['role:admin,super admin']);
    Route::get('user/create', [UserController::class, 'create'])->name('user.create')->middleware(['role:admin']);
    Route::post('user', [UserController::class, 'store'])->name('user.store')->middleware(['role:admin']);

    Route::get('user/{user}', [UserController::class, 'show'])->name('user.show')->middleware(['role:admin,super admin']);
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware(['role:admin']);
    Route::put('user/{user}', [UserController::class, 'update'])->name('user.update')->middleware(['role:admin']);
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy')->middleware(['role:admin']);


    // =================================================
    // WARGA
    // super admin: index & show saja
    // admin: full
    // petugas: tidak boleh akses
    // =================================================
    Route::prefix('warga')->as('warga.')->group(function () {

        // static routes dulu
        Route::get('/', [WargaController::class, 'index'])
            ->name('index')
            ->middleware(['role:admin,super admin']);

        Route::get('/create', [WargaController::class, 'create'])
            ->name('create')
            ->middleware(['role:admin']);

        Route::post('/store-account', [WargaController::class, 'storeAccount'])
            ->name('storeAccount')
            ->middleware(['role:admin']);

        Route::post('/store', [WargaController::class, 'store'])
            ->name('store')
            ->middleware(['role:admin']);

        // dynamic routes belakangan
        Route::get('/{id}', [WargaController::class, 'show'])
            ->name('show')
            ->middleware(['role:admin,super admin']);

        Route::get('/{id}/edit', [WargaController::class, 'edit'])
            ->name('edit')
            ->middleware(['role:admin']);

        Route::put('/{id}', [WargaController::class, 'update'])
            ->name('update')
            ->middleware(['role:admin']);

        Route::delete('/{id}', [WargaController::class, 'destroy'])
            ->name('destroy')
            ->middleware(['role:admin']);
    });


    // =================================================
    // KATEGORI PENGADUAN
    // super admin: index & show saja
    // admin: full
    // petugas: tidak boleh akses
    // =================================================
    Route::prefix('kategori-pengaduan')->as('kategori-pengaduan.')->group(function () {

        // static routes dulu
        Route::get('/', [KategoriPengaduanController::class, 'index'])
            ->name('index')
            ->middleware(['role:admin,super admin']);

        Route::get('/create', [KategoriPengaduanController::class, 'create'])
            ->name('create')
            ->middleware(['role:admin']);

        Route::post('/', [KategoriPengaduanController::class, 'store'])
            ->name('store')
            ->middleware(['role:admin']);

        // dynamic routes belakangan
        Route::get('/{id}', [KategoriPengaduanController::class, 'show'])
            ->name('show')
            ->middleware(['role:admin,super admin']);

        Route::get('/{id}/edit', [KategoriPengaduanController::class, 'edit'])
            ->name('edit')
            ->middleware(['role:admin']);

        Route::put('/{id}', [KategoriPengaduanController::class, 'update'])
            ->name('update')
            ->middleware(['role:admin']);

        Route::delete('/{id}', [KategoriPengaduanController::class, 'destroy'])
            ->name('destroy')
            ->middleware(['role:admin']);
    });


    // =================================================
    // PENGADUAN
    // super admin: index/show/semua (read-only)
    // admin: full
    // petugas: index/show/semua + edit/update
    // =================================================
    Route::prefix('pengaduan')->as('pengaduan.')->group(function () {

        // static routes dulu
        Route::get('/', [PengaduanController::class, 'index'])
            ->name('index');

        Route::get('/semua', [PengaduanController::class, 'pengaduanSemua'])
            ->name('semua');

        Route::get('/create', [PengaduanController::class, 'create'])
            ->name('create');

        Route::post('/', [PengaduanController::class, 'store'])
            ->name('store');

        // dynamic routes belakangan
        Route::get('/{id}', [PengaduanController::class, 'show'])
            ->name('show');

        Route::get('/{id}/edit', [PengaduanController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [PengaduanController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [PengaduanController::class, 'destroy'])
            ->name('destroy');
    });


    // =================================================
    // TINDAK LANJUT
    // super admin: index/show (read-only)
    // admin: full
    // petugas: index/show + edit/update
    // =================================================
    Route::prefix('tindaklanjut')->as('tindaklanjut.')->group(function () {

        // static routes dulu
        Route::get('/', [TindakLanjutController::class, 'index'])
            ->name('index')
            ->middleware(['role:admin,super admin,petugas']);

        // CATATAN: show kamu pakai /{id}/show -> itu static "show" di belakang, aman
        Route::get('/{id}/show', [TindakLanjutController::class, 'show'])
            ->name('show')
            ->middleware(['role:admin,super admin,petugas']);

        // create/store menggunakan pengaduan_id (dynamic) tapi route-nya spesifik, aman
        Route::get('/{pengaduan_id}/create', [TindakLanjutController::class, 'create'])
            ->name('create')
            ->middleware(['role:admin']);

        Route::post('/{pengaduan_id}', [TindakLanjutController::class, 'store'])
            ->name('store')
            ->middleware(['role:admin']);

        // edit/update/delete untuk tindak lanjut
        Route::get('/{id}/edit', [TindakLanjutController::class, 'edit'])
            ->name('edit')
            ->middleware(['role:admin,petugas']);

        Route::put('/{id}', [TindakLanjutController::class, 'update'])
            ->name('update')
            ->middleware(['role:admin,petugas']);

        Route::delete('/{id}', [TindakLanjutController::class, 'destroy'])
            ->name('destroy')
            ->middleware(['role:admin']);
    });


    // =================================================
    // PENILAIAN
    // super admin: index/show saja
    // admin: full
    // petugas: index/show (sesuai yang kamu tulis)
    // =================================================
    Route::prefix('penilaian')->as('penilaian.')->group(function () {

        // static routes dulu
        Route::get('/', [PenilaianController::class, 'index'])
            ->name('index')
            ->middleware(['role:admin,super admin, guest']);

        Route::post('/', [PenilaianController::class, 'store'])
            ->name('store')
            ->middleware(['role:admin,super admin, guest']);

        // dynamic belakangan
        Route::get('/{penilaian}', [PenilaianController::class, 'show'])
            ->name('show')
            ->middleware(['role:admin,super admin, guest']);

        Route::put('/{penilaian}', [PenilaianController::class, 'update'])
            ->name('update')
            ->middleware(['role:admin,super admin, guest']);

        Route::delete('/{penilaian}', [PenilaianController::class, 'destroy'])
            ->name('destroy')
            ->middleware(['role:admin,super admin, guest']);
    });
    Route::view('/developer', 'admin.developer.index')->name('developer.index');
    Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
    Route::view('/terms-of-use', 'terms-of-use')->name('terms.use');
});

// 1. super admin : bisa liat dashboard hanya bisa melihat semua table (index dan show) tidak bisa edit,tidak bisa hapus
// 2. admin : bisa semua
// 3. petugas : bisa lihat dashboard,lihat pengaduan dan tindak lanjut bisa edit
// 4. guest = hanya bisa mengisi form tambah warga dan form,show -> pengaduan
