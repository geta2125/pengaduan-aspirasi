<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KategoriPengaduanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\PenilaianController;

/*
|--------------------------------------------------------------------------
| Redirect Awal
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Login (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
Route::put('/profile/password', [DashboardController::class, 'updatePassword'])->name('profile.password');
Route::put('/profile/foto', [DashboardController::class, 'updateFoto'])->name('profile.foto');

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/
Route::resource('user', UserController::class);

/*
|--------------------------------------------------------------------------
| WARGA
|--------------------------------------------------------------------------
*/
Route::post('warga/store-account', [WargaController::class, 'storeAccount'])
    ->name('warga.storeAccount');

Route::resource('warga', WargaController::class)
    ->parameters(['warga' => 'id']);

/*
|--------------------------------------------------------------------------
| KATEGORI PENGADUAN
|--------------------------------------------------------------------------
*/
Route::resource('kategori-pengaduan', KategoriPengaduanController::class)
    ->parameters(['kategori-pengaduan' => 'id']);

/*
|--------------------------------------------------------------------------
| PENGADUAN
|--------------------------------------------------------------------------
*/
Route::get('pengaduan/semua', [PengaduanController::class, 'pengaduanSemua'])
    ->name('pengaduan.semua');

Route::resource('pengaduan', PengaduanController::class)
    ->parameters(['pengaduan' => 'id']);

/*
|--------------------------------------------------------------------------
| TINDAK LANJUT
|--------------------------------------------------------------------------
*/
Route::prefix('tindaklanjut')
    ->name('tindaklanjut.')
    ->controller(TindakLanjutController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('{id}/show', 'show')->name('show');

        Route::get('{pengaduan_id}/create', 'create')->name('create');
        Route::post('{pengaduan_id}', 'store')->name('store');

        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');

        Route::delete('{id}', 'destroy')->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| PENILAIAN
|--------------------------------------------------------------------------
*/
Route::resource('penilaian', PenilaianController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);

/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
*/
Route::view('/developer', 'admin.developer.index')->name('developer.index');
Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/terms-of-use', 'terms-of-use')->name('terms.use');
