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
// LOGIN
// ====================================================================
// Login Admin
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');

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
        // Rute utama (View)
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Rute AJAX untuk mengambil data yang difilter
        Route::get('/data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');

        // Rute Profil
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

            // Perhatikan urutan. Route spesifik harus di atas route generik
            Route::get('/semua', [PengaduanController::class, 'pengaduanSemua'])->name('semua');

            Route::get('/{id}/edit', [PengaduanController::class, 'edit'])->name('edit');
            Route::get('/{id}', [PengaduanController::class, 'show'])->name('show'); // Pastikan ini di akhir
            Route::put('/{id}', [PengaduanController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengaduanController::class, 'destroy'])->name('destroy');

            // Route untuk Update Status
            // Jika Anda ingin route update status terpisah, bisa ditambahkan di sini, misal:
            // Route::put('/{id}/status', [PengaduanController::class, 'updateStatus'])->name('update.status');
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

        Route::prefix('/penilaian')->name('penilaian.')->group(function () {

            // LIST + FILTER (yang sekarang dipakai di index.blade.php)
            Route::get('/', [PenilaianController::class, 'index'])->name('index');

            // CREATE (simpan penilaian baru)
            Route::post('/', [PenilaianController::class, 'store'])->name('store');

            // SHOW (opsional, kalau mau lihat detail satu penilaian)
            Route::get('/{penilaian}', [PenilaianController::class, 'show'])->name('show');

            // UPDATE (edit penilaian yang sudah ada)
            Route::put('/{penilaian}', [PenilaianController::class, 'update'])->name('update');

            // DELETE (hapus penilaian)
            Route::delete('/{penilaian}', [PenilaianController::class, 'destroy'])->name('destroy');
        });
    });
});
