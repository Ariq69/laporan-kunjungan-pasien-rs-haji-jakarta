<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tech\DokterController;
use App\Http\Controllers\Tech\PasienController;
use App\Http\Controllers\Tech\PegawaiController;
use App\Http\Controllers\Tech\PerawatController;
use App\Http\Controllers\Tech\AsuransiController;
use App\Http\Controllers\Tech\DashboardController;
use App\Http\Controllers\Tech\SettingPenggunaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/login', 301);

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard/tech', [HomeController::class, 'tech'])->name('dashboard-tech');
    Route::get('/dashboard/admin', [HomeController::class, 'admin'])->name('dashboard-admin');
    Route::get('/dashboard/pegawai', [HomeController::class, 'pegawai'])->name('dashboard-pegawai');

});

Route::prefix('tech')
    ->middleware('auth','tech')
    ->group( function(){
        
        //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //Dokter Section
        Route::get('/data-dokter', [DokterController::class, 'data_dokter'])->name('data-dokter');
        Route::get('/jadwal-dokter', [DokterController::class, 'jadwal_dokter'])->name('jadwal-dokter');
        
        //Perawat Section
        Route::get('/data-perawat', [PerawatController::class, 'data_perawat'])->name('data-perawat');
        Route::get('/jadwal-perawat', [PerawatController::class, 'jadwal_perawat'])->name('jadwal-perawat');
        
        //Pegawai Section
        Route::get('/data-pegawai', [PegawaiController::class, 'data_pegawai'])->name('data-pegawai');

        Route::get('/pasien', [PasienController::class, 'pasien'])->name('pasien');
        Route::get('/pasien-lama', [PasienController::class, 'pasien_lama'])->name('pasien-lama');
        Route::get('/pasien-baru', [PasienController::class, 'pasien_baru'])->name('pasien-baru');

        //informasi Kamar
        Route::get('/informasi-kamar', [PasienController::class, 'informasi_kamar'])->name('informasi-kamar');
        Route::get('/informasi-kamar-afiah', [PasienController::class, 'informasi_kamar_afiah'])->name('informasi-kamar-afiah');
        Route::get('/informasi-kamar-afiso', [PasienController::class, 'informasi_kamar_afiso'])->name('informasi-kamar-afiso');
        Route::get('/informasi-kamar-ama', [PasienController::class, 'informasi_kamar_ama'])->name('informasi-kamar-ama');
        Route::get('/informasi-kamar-amab', [PasienController::class, 'informasi_kamar_amab'])->name('informasi-kamar-amab');
        Route::get('/informasi-kamar-has1', [PasienController::class, 'informasi_kamar_has1'])->name('informasi-kamar-has1');
        Route::get('/informasi-kamar-has06', [PasienController::class, 'informasi_kamar_has06'])->name('informasi-kamar-has06');
        Route::get('/informasi-kamar-has07', [PasienController::class, 'informasi_kamar_has07'])->name('informasi-kamar-has07');
        Route::get('/informasi-kamar-has08', [PasienController::class, 'informasi_kamar_has08'])->name('informasi-kamar-has08');
        Route::get('/informasi-kamar-syi', [PasienController::class, 'informasi_kamar_syi'])->name('informasi-kamar-syi');
        Route::get('/informasi-kamar-syiso', [PasienController::class, 'informasi_kamar_syiso'])->name('informasi-kamar-syiso');
        Route::get('/informasi-kamar-sak', [PasienController::class, 'informasi_kamar_sak'])->name('informasi-kamar-sak');
        Route::get('/informasi-kamar-mul', [PasienController::class, 'informasi_kamar_mul'])->name('informasi-kamar-mul');
        Route::get('/informasi-kamar-neo', [PasienController::class, 'informasi_kamar_neo'])->name('informasi-kamar-neo');
        Route::get('/informasi-kamar-icu', [PasienController::class, 'informasi_kamar_icu'])->name('informasi-kamar-icu');
        Route::get('/informasi-kamar-iccu', [PasienController::class, 'informasi_kamar_iccu'])->name('informasi-kamar-iccu');
        Route::get('/informasi-kamar-nicu', [PasienController::class, 'informasi_kamar_nicu'])->name('informasi-kamar-nicu');
        Route::get('/informasi-kamar-ist', [PasienController::class, 'informasi_kamar_ist'])->name('informasi-kamar-ist');
        Route::get('/informasi-kamar-ist01', [PasienController::class, 'informasi_kamar_ist01'])->name('informasi-kamar-ist01');
        Route::get('/informasi-kamar-ist02', [PasienController::class, 'informasi_kamar_ist02'])->name('informasi-kamar-ist02');
        
        //Asuransi Section
        Route::get('/informasi-asuransi', [AsuransiController::class, 'informasi_asuransi'])->name('informasi-asuransi');
        
        Route::resource('setting-pengguna', SettingPenggunaController::class);
    });
    

Route::prefix('admin')
    ->namespace('admin')
    ->middleware('auth','admin')
    ->group( function(){
        
        //Route::get('/dashboard-admin',[Admin\DashboardController::class, 'index'])->name('dashboard-admin');
    });


Auth::routes();