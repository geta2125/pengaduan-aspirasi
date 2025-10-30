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


Route::get('/', function () {
    return redirect()->route('guest.login');
});

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



Route::middleware('auth')->group(function () {

    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // -------------------------
    // Dashboard
    // -------------------------
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/edit-profile', [DashboardController::class, 'Profile'])->name('dashboard.Profile');
        Route::put('/update-profile', [DashboardController::class, 'updateProfile'])->name('dashboard.updateProfile');
        Route::put('/update-password', [DashboardController::class, 'updatePassword'])->name('dashboard.updatePassword');
        Route::put('/update-foto', [DashboardController::class, 'updateFoto'])->name('dashboard.updateFoto');
    });



    // ROUTE ADMIN
    Route::prefix('admin')->as('admin.')->group(function () {
        // Modul User
        Route::resource('user', UserController::class);

        Route::get('/kategori-pengaduan', [KategoriPengaduanController::class, 'index'])->name('kategori-pengaduan.index');
        Route::get('/kategori-pengaduan/create', [KategoriPengaduanController::class, 'create'])->name('kategori-pengaduan.create');
        Route::post('/kategori-pengaduan', [KategoriPengaduanController::class, 'store'])->name('kategori-pengaduan.store');
        Route::get('/kategori-pengaduan/{id}/edit', [KategoriPengaduanController::class, 'edit'])->name('kategori-pengaduan.edit');
        Route::put('/kategori-pengaduan/{id}', [KategoriPengaduanController::class, 'update'])->name('kategori-pengaduan.update');
        Route::delete('/kategori-pengaduan/{id}', [KategoriPengaduanController::class, 'destroy'])->name('kategori-pengaduan.destroy');
        Route::get('/kategori-pengaduan/{id}', [KategoriPengaduanController::class, 'show'])->name('kategori-pengaduan.show');
        Route::get('/pengaduan/baru', [PengaduanController::class, 'pengaduanBaru'])->name('pengaduan.baru');
        Route::get('/pengaduan/semua', [PengaduanController::class, 'semuaPengaduan'])->name('pengaduan.semua');

        Route::get('pengaduan/{id}/tindaklanjut', [PengaduanController::class, 'tindaklanjutForm'])->name('pengaduan.tindaklanjut');
        Route::post('pengaduan/{id}/tindaklanjut', [PengaduanController::class, 'tindaklanjutStore'])->name('pengaduan.tindaklanjut.store');
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

    });




    // ==========================
    // ROUTE PENILAIAN LAYANAN
    // ==========================
    Route::get('/penilaian-layanan', [PenilaianController::class, 'index'])->name('penilaian.layanan');
});
