<?php

use App\Http\Controllers\Tech\KunjunganController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tech\DokterController;
use App\Http\Controllers\Tech\PasienController;
use App\Http\Controllers\Tech\PegawaiController;
use App\Http\Controllers\Tech\PerawatController;
use App\Http\Controllers\Tech\LimbahController;
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
    Route::post('/dashboard/tech', [HomeController::class, 'tech'])->name('dashboard-tech');
    Route::get('/dashboard/admin', [HomeController::class, 'admin'])->name('dashboard-admin');
    Route::get('/dashboard/pegawai', [HomeController::class, 'pegawai'])->name('dashboard-pegawai');

});

Route::prefix('tech')
    ->middleware('auth','tech')
    ->group( function(){
        
        // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //Dokter Section
        Route::get('/data-dokter', [DokterController::class, 'data_dokter'])->name('data-dokter');
        Route::get('/jadwal-dokter', [DokterController::class, 'jadwal_dokter'])->name('jadwal-dokter');
        
        //Perawat Section
        Route::get('/data-perawat', [PerawatController::class, 'data_perawat'])->name('data-perawat');
        Route::get('/jadwal-perawat', [PerawatController::class, 'jadwal_perawat'])->name('jadwal-perawat');
        
        //Pegawai Section
        Route::get('/data-pegawai', [PegawaiController::class, 'data_pegawai'])->name('data-pegawai');

        Route::get('/pasien', [PasienController::class, 'pasien'])->name('pasien');
        Route::post('/pasien', [PasienController::class, 'pasien'])->name('pasien');

        Route::get('/pasien-perbulan', [PasienController::class, 'pasien_perbulan'])->name('pasien-perbulan');
        Route::post('/pasien-perbulan', [PasienController::class, 'pasien_perbulan'])->name('pasien-perbulan');

        Route::get('/pasien-perpoli', [PasienController::class, 'pasien_perpoli'])->name('pasien-perpoli');
        Route::post('/pasien-perpoli', [PasienController::class, 'pasien_perpoli'])->name('pasien-perpoli');

        Route::get('/pasien-carabayar', [PasienController::class, 'pasien_carabayar'])->name('pasien-carabayar');
        Route::post('/pasien-carabayar', [PasienController::class, 'pasien_carabayar'])->name('pasien-carabayar');

        Route::get('/pasien-perdokter', [PasienController::class, 'pasien_perdokter'])->name('pasien-perdokter');
        Route::post('/pasien-perdokter', [PasienController::class, 'pasien_perdokter'])->name('pasien-perdokter');

        Route::get('/pasien-perjk', [PasienController::class, 'pasien_perjk'])->name('pasien-perjk');
        Route::post('/pasien-perjk', [PasienController::class, 'pasien_perjk'])->name('pasien-perjk');

        Route::get('/pasien-perkabupaten', [PasienController::class, 'pasien_perkabupaten'])->name('pasien-perkabupaten');
        Route::post('/pasien-perkabupaten', [PasienController::class, 'pasien_perkabupaten'])->name('pasien-perkabupaten');

        Route::get('/pasien-perkecamatan', [PasienController::class, 'pasien_perkecamatan'])->name('pasien-perkecamatan');
        Route::post('/pasien-perkecamatan', [PasienController::class, 'pasien_perkecamatan'])->name('pasien-perkecamaagama');

        Route::get('/pasien-peragama', [PasienController::class, 'pasien_peragama'])->name('pasien-peragama');
        Route::post('/pasien-peragama', [PasienController::class, 'pasien_peragama'])->name('pasien-peragama');

        Route::get('/pasien-perumur', [PasienController::class, 'pasien_perumur'])->name('pasien-perumur');
        Route::post('/pasien-perumur', [PasienController::class, 'pasien_perumur'])->name('pasien-perumur');

        Route::get('/pasien-persubang', [PasienController::class, 'pasien_persubang'])->name('pasien-persubang');
        Route::post('/pasien-persubang', [PasienController::class, 'pasien_persubang'])->name('pasien-persubang');

        Route::get('/pasien-baru', [PasienController::class, 'pasien_baru'])->name('pasien-baru');

        //informasi Kamar
        Route::get('/informasi-kamar', [KunjunganController::class, 'informasi_kamar'])->name('informasi-kamar');

        //penyakit
        Route::get('/penyakit', [KunjunganController::class, 'penyakit'])->name('penyakit');
        Route::post('/penyakit', [KunjunganController::class, 'penyakit'])->name('penyakit');
        
        //rawat inap
        Route::get('/rawat-inap', [KunjunganController::class, 'rawat_inap'])->name('rawat-inap');

        Route::get('/ranap-lab', [KunjunganController::class, 'ranap_lab'])->name('ranap-lab');
        Route::post('/ranap-lab', [KunjunganController::class, 'ranap_lab'])->name('ranap-lab');

        Route::get('/ranap-hemodialisa', [KunjunganController::class, 'ranap_hemodialisa'])->name('ranap-hemodialisa');
        Route::post('/ranap-hemodialisa', [KunjunganController::class, 'ranap_hemodialisa'])->name('ranap-hemodialisa');

        Route::get('/ranap-igd', [KunjunganController::class, 'ranap_igd'])->name('ranap-igd');
        Route::post('/ranap-igd', [KunjunganController::class, 'ranap_igd'])->name('ranap-igd');

        Route::get('/ranap-ugd', [KunjunganController::class, 'ranap_ugd'])->name('ranap-ugd');
        Route::post('/ranap-ugd', [KunjunganController::class, 'ranap_ugd'])->name('ranap-ugd');
        
        Route::get('/ranap-rad', [KunjunganController::class, 'ranap_rad'])->name('ranap-rad');
        Route::post('/ranap-rad', [KunjunganController::class, 'ranap_rad'])->name('ranap-rad');



        //rawat jalan
        Route::get('/rawat-jalan', [KunjunganController::class, 'rawat_jalan'])->name('rawat-jalan');

        Route::get('/ralan-lab', [KunjunganController::class, 'ralan_lab'])->name('ralan-lab');
        Route::post('/ralan-lab', [KunjunganController::class, 'ralan_lab'])->name('ralan-lab');

        Route::get('/ralan-igd', [KunjunganController::class, 'ralan_igd'])->name('ralan-igd');
        Route::post('/ralan-igd', [KunjunganController::class, 'ralan_igd'])->name('ralan-igd');

        Route::get('/ralan-ugd', [KunjunganController::class, 'ralan_ugd'])->name('ralan-ugd');
        Route::post('/ralan-ugd', [KunjunganController::class, 'ralan_ugd'])->name('ralan-ugd');
        
        Route::get('/ralan-hemodialisa', [KunjunganController::class, 'ralan_hemodialisa'])->name('ralan-hemodialisa');
        Route::post('/ralan-hemodialisa', [KunjunganController::class, 'ralan_hemodialisa'])->name('ralan-hemodialisa');

        //limbah
        Route::get('/limbah', [LimbahController::class, 'limbah'])->name('limbah');
        Route::post('/limbah', [LimbahController::class, 'limbah'])->name('limbah');

        //Asuransi Section
        Route::get('/informasi-asuransi', [AsuransiController::class, 'informasi_asuransi'])->name('informasi-asuransi');
        Route::get('/informasi-asuransi-admed', [AsuransiController::class, 'informasi_asuransi_admed'])->name('informasi-asuransi-admed');

        // Kunjungan Section
        Route::get('/dashboard', [HomeController::class, 'tech']);
        Route::post('/dashboard', [HomeController::class, 'tech']);







        
        Route::resource('setting-pengguna', SettingPenggunaController::class);
    });
    
Route::prefix('admin')
    ->namespace('admin')
    ->middleware('auth','admin')
    ->group( function(){
        
        //Route::get('/dashboard-admin',[Admin\DashboardController::class, 'index'])->name('dashboard-admin');
    });


Auth::routes();