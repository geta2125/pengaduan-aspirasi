<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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
// LOGIN (TANPA AUTH / CHECKROLE)
// ====================================================================
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');


// ====================================================================
// AREA SETELAH LOGIN (AUTH)
// ====================================================================
Route::middleware(['checkislogin'])->group(function () {

    // ----------------------------------------------------------------
    // LOGOUT (boleh semua role yang sudah login)
    // ----------------------------------------------------------------
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // ----------------------------------------------------------------
    // DASHBOARD (hanya admin)
    // ----------------------------------------------------------------
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware('checkrole:admin');

        Route::get('/data', [DashboardController::class, 'getDashboardData'])
            ->name('dashboard.data')
            ->middleware('checkrole:admin');

        Route::get('/edit-profile', [DashboardController::class, 'Profile'])
            ->name('dashboard.profile')
            ->middleware('checkrole:admin');

        Route::put('/update-profile', [DashboardController::class, 'updateProfile'])
            ->name('dashboard.updateProfile')
            ->middleware('checkrole:admin');

        Route::put('/update-password', [DashboardController::class, 'updatePassword'])
            ->name('dashboard.updatePassword')
            ->middleware('checkrole:admin');

        Route::put('/update-foto', [DashboardController::class, 'updateFoto'])
            ->name('dashboard.updateFoto')
            ->middleware('checkrole:admin');
    });

    // ----------------------------------------------------------------
    // ADMIN AREA (PREFIX: admin, NAME: admin.*)
    // ----------------------------------------------------------------
    Route::prefix('admin')->as('admin.')->group(function () {

        // ---------------------------
        // USER (RESOURCE)
        // ---------------------------
        Route::resource('user', UserController::class)->middleware([
            // index, create, store, edit, update, destroy -> hanya admin
            'checkrole:admin'
        ]);

        // show juga sekarang cuma admin
        Route::get('user/{user}', [UserController::class, 'show'])
            ->name('user.show')
            ->middleware('checkrole:admin');


        // ---------------------------
        // WARGA
        // ---------------------------
        Route::prefix('warga')->as('warga.')->group(function () {

            Route::get('/', [WargaController::class, 'index'])
                ->name('index')
                ->middleware('checkrole:admin');

            Route::get('/create', [WargaController::class, 'create'])
                ->name('create')
                ->middleware('checkrole:admin');

            Route::get('/{id}/edit', [WargaController::class, 'edit'])
                ->name('edit')
                ->middleware('checkrole:admin');

            Route::post('/store-account', [WargaController::class, 'storeAccount'])
                ->name('storeAccount')
                ->middleware('checkrole:admin');

            Route::post('/store', [WargaController::class, 'store'])
                ->name('store')
                ->middleware('checkrole:admin');

            Route::put('/{id}', [WargaController::class, 'update'])
                ->name('update')
                ->middleware('checkrole:admin');

            Route::delete('/{id}', [WargaController::class, 'destroy'])
                ->name('destroy')
                ->middleware('checkrole:admin');

            // Detail → sekarang hanya admin
            Route::get('/{id}', [WargaController::class, 'show'])
                ->name('show')
                ->middleware('checkrole:admin');
        });


        // ---------------------------
        // KATEGORI PENGADUAN
        // ---------------------------
        Route::prefix('kategori-pengaduan')->as('kategori-pengaduan.')->group(function () {
            Route::get('/', [KategoriPengaduanController::class, 'index'])
                ->name('index')
                ->middleware('checkrole:admin');

            Route::get('/create', [KategoriPengaduanController::class, 'create'])
                ->name('create')
                ->middleware('checkrole:admin');

            Route::post('/', [KategoriPengaduanController::class, 'store'])
                ->name('store')
                ->middleware('checkrole:admin');

            // show → sekarang hanya admin
            Route::get('/{id}', [KategoriPengaduanController::class, 'show'])
                ->name('show')
                ->middleware('checkrole:admin');

            Route::get('/{id}/edit', [KategoriPengaduanController::class, 'edit'])
                ->name('edit')
                ->middleware('checkrole:admin');

            Route::put('/{id}', [KategoriPengaduanController::class, 'update'])
                ->name('update')
                ->middleware('checkrole:admin');

            Route::delete('/{id}', [KategoriPengaduanController::class, 'destroy'])
                ->name('destroy')
                ->middleware('checkrole:admin');
        });


        // ---------------------------
        // PENGADUAN ADMIN
        // ---------------------------
        Route::prefix('pengaduan')->as('pengaduan.')->group(function () {
            Route::get('/', [PengaduanController::class, 'index'])
                ->name('index')
                ->middleware('checkrole:admin');

            Route::get('/create', [PengaduanController::class, 'create'])
                ->name('create')
                ->middleware('checkrole:admin');

            Route::post('/', [PengaduanController::class, 'store'])
                ->name('store')
                ->middleware('checkrole:admin');

            Route::get('/semua', [PengaduanController::class, 'pengaduanSemua'])
                ->name('semua')
                ->middleware('checkrole:admin');

            Route::get('/{id}/edit', [PengaduanController::class, 'edit'])
                ->name('edit')
                ->middleware('checkrole:admin');

            // show → sekarang hanya admin
            Route::get('/{id}', [PengaduanController::class, 'show'])
                ->name('show')
                ->middleware('checkrole:admin');

            Route::put('/{id}', [PengaduanController::class, 'update'])
                ->name('update')
                ->middleware('checkrole:admin');

            Route::delete('/{id}', [PengaduanController::class, 'destroy'])
                ->name('destroy')
                ->middleware('checkrole:admin');
        });


        // ---------------------------
        // TINDAK LANJUT
        // ---------------------------
        Route::prefix('tindaklanjut')->as('tindaklanjut.')->group(function () {
            Route::get('/', [TindakLanjutController::class, 'index'])
                ->name('index')
                ->middleware('checkrole:admin');

            Route::get('/{pengaduan_id}/create', [TindakLanjutController::class, 'create'])
                ->name('create')
                ->middleware('checkrole:admin');

            Route::post('/{pengaduan_id}', [TindakLanjutController::class, 'store'])
                ->name('store')
                ->middleware('checkrole:admin');

            // show → sekarang hanya admin
            Route::get('/{id}/show', [TindakLanjutController::class, 'show'])
                ->name('show')
                ->middleware('checkrole:admin');

            Route::get('/{id}/edit', [TindakLanjutController::class, 'edit'])
                ->name('edit')
                ->middleware('checkrole:admin');

            Route::put('/{id}', [TindakLanjutController::class, 'update'])
                ->name('update')
                ->middleware('checkrole:admin');

            Route::delete('/{id}', [TindakLanjutController::class, 'destroy'])
                ->name('destroy')
                ->middleware('checkrole:admin');
        });


        // ---------------------------
        // PENILAIAN
        // ---------------------------
        Route::prefix('penilaian')->name('penilaian.')->group(function () {
            Route::get('/', [PenilaianController::class, 'index'])
                ->name('index')
                ->middleware('checkrole:admin');

            Route::post('/', [PenilaianController::class, 'store'])
                ->name('store')
                ->middleware('checkrole:admin');

            // show → sekarang hanya admin
            Route::get('/{penilaian}', [PenilaianController::class, 'show'])
                ->name('show')
                ->middleware('checkrole:admin');

            Route::put('/{penilaian}', [PenilaianController::class, 'update'])
                ->name('update')
                ->middleware('checkrole:admin');

            Route::delete('/{penilaian}', [PenilaianController::class, 'destroy'])
                ->name('destroy')
                ->middleware('checkrole:admin');
        });
    });
});
