<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tech\K3Controller;
use App\Http\Controllers\Tech\IGDController;
use App\Http\Controllers\Tech\RalanController;
use App\Http\Controllers\Tech\RanapController;
use App\Http\Controllers\Tech\DokterController;
use App\Http\Controllers\Tech\LimbahController;
use App\Http\Controllers\Tech\PasienController;
use App\Http\Controllers\Tech\PegawaiController;
use App\Http\Controllers\Tech\PerawatController;
use App\Http\Controllers\Tech\AsuransiController;
use App\Http\Controllers\Tech\DashboardController;
use App\Http\Controllers\Tech\KunjunganController;
use App\Http\Controllers\Tech\InventarisController;
use App\Http\Controllers\Tech\PemakaianAirController;
use App\Http\Controllers\Tech\SettingPenggunaController;
use App\Http\Controllers\Tech\JumlahInventarisController;
use App\Http\Controllers\Tech\PeriksaRadiologiController;
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

        Route::get('/pasien-perbahasa', [PasienController::class, 'pasien_perbahasa'])->name('pasien-perbahasa');
        Route::post('/pasien-perbahasa', [PasienController::class, 'pasien_perbahasa'])->name('pasien-perbahasa');

        Route::get('/pasien-baru', [PasienController::class, 'pasien_baru'])->name('pasien-baru');

        //informasi Kamar
        Route::get('/informasi-kamar', [KunjunganController::class, 'informasi_kamar'])->name('informasi-kamar');

        //penyakit
        Route::get('/penyakit', [KunjunganController::class, 'penyakit'])->name('penyakit');
        Route::post('/penyakit', [KunjunganController::class, 'penyakit'])->name('penyakit');

        //obat
        Route::get('/obat', [KunjunganController::class, 'obat'])->name('obat');
        Route::post('/obat', [KunjunganController::class, 'obat'])->name('obat');
        
        //rawat inap
        Route::get('/rawat-inap', [KunjunganController::class, 'rawat_inap'])->name('rawat-inap');

        Route::get('/ranap-lab', [RanapController::class, 'ranap_lab'])->name('ranap-lab');
        Route::post('/ranap-lab', [RanapController::class, 'ranap_lab'])->name('ranap-lab');

        Route::get('/ranap-hemodialisa', [RanapController::class, 'ranap_hemodialisa'])->name('ranap-hemodialisa');
        Route::post('/ranap-hemodialisa', [RanapController::class, 'ranap_hemodialisa'])->name('ranap-hemodialisa');
        
        Route::get('/ranap-rad', [RanapController::class, 'ranap_rad'])->name('ranap-rad');
        Route::post('/ranap-rad', [RanapController::class, 'ranap_rad'])->name('ranap-rad');

        Route::get('/ranap-apotek', [RanapController::class, 'ranap_apotek'])->name('ranap-apotek');
        Route::post('/ranap-apotek', [RanapController::class, 'ranap_apotek'])->name('ranap-apotek');

        Route::get('/ranap-fisioterapi', [RanapController::class, 'ranap_fisioterapi'])->name('ranap-fisioterapi');
        Route::post('/ranap-fisioterapi', [RanapController::class, 'ranap_fisioterapi'])->name('ranap-fisioterapi');

        //rawat jalan
        Route::get('/igd', [IGDController::class, 'dashboard_igd'])->name('igd');

        //rawat jalan
        Route::get('/rawat-jalan', [KunjunganController::class, 'rawat_jalan'])->name('rawat-jalan');

        Route::get('/ralan-lab', [RalanController::class, 'ralan_lab'])->name('ralan-lab');
        Route::post('/ralan-lab', [RalanController::class, 'ralan_lab'])->name('ralan-lab');
        
        Route::get('/ralan-hemodialisa', [RalanController::class, 'ralan_hemodialisa'])->name('ralan-hemodialisa');
        Route::post('/ralan-hemodialisa', [RalanController::class, 'ralan_hemodialisa'])->name('ralan-hemodialisa');

        Route::get('/jenis_perawatan_radiologi_ralan', [RalanController::class, 'jenis_perawatan_radiologi_ralan'])->name('jenis_perawatan_radiologi_ralan');
        Route::post('/jenis_perawatan_radiologi_ralan', [RalanController::class, 'jenis_perawatan_radiologi_ralan'])->name('jenis_perawatan_radiologi_ralan');

        Route::get('/ralan-apotek', [RalanController::class, 'ralan_apotek'])->name('ralan-apotek');
        Route::post('/ralan-apotek', [RalanController::class, 'ralan_apotek'])->name('ralan-apotek');

        Route::get('/ralan-fisio', [RalanController::class, 'ralan_fisio'])->name('ralan-fisio');
        Route::post('/ralan-fisio', [RalanController::class, 'ralan_fisio'])->name('ralan-fisio');

        //limbah
        Route::get('/limbah', [LimbahController::class, 'limbah'])->name('limbah');
        Route::post('/limbah', [LimbahController::class, 'limbah'])->name('limbah');

        //Asuransi Section
        Route::get('/informasi-asuransi', [AsuransiController::class, 'informasi_asuransi'])->name('informasi-asuransi');
        Route::get('/informasi-asuransi-admed', [AsuransiController::class, 'informasi_asuransi_admed'])->name('informasi-asuransi-admed');

        // Kunjungan Section
        Route::get('/dashboard', [HomeController::class, 'tech']);
        Route::post('/dashboard', [HomeController::class, 'tech']);

        
        //Pemakaian Air
        Route::get('/pemakaian-air', [PemakaianAirController::class, 'pemakaian_air'])->name('pemakaian-air');
        Route::post('/pemakaian-air', [PemakaianAirController::class, 'pemakaian_air'])->name('pemakaian-air');

        //K3
        Route::get('/k3', [K3Controller::class, 'k3'])->name('k3');
        Route::post('/k3', [K3Controller::class, 'k3'])->name('k3');
        
        Route::get('/k3-bagian-tubuh', [K3Controller::class, 'k3_bagian_tubuh'])->name('k3-bagian-tubuh');
        Route::post('/k3-bagian-tubuh', [K3Controller::class, 'k3_bagian_tubuh'])->name('k3-bagian-tubuh');

        Route::get('/k3-dampak-cidera', [K3Controller::class, 'k3_dampak_cidera'])->name('k3-dampak-cidera');
        Route::post('/k3-dampak-cidera', [K3Controller::class, 'k3_dampak_cidera'])->name('k3-dampak-cidera');
        
        Route::get('/k3-jenis-cidera', [K3Controller::class, 'k3_jenis_cidera'])->name('k3-jenis-cidera');
        Route::post('/k3-jenis-cidera', [K3Controller::class, 'k3_jenis_cidera'])->name('k3-jenis-cidera');

        Route::get('/k3-jenis-luka', [K3Controller::class, 'k3_jenis_luka'])->name('k3-jenis-luka');
        Route::post('/k3-jenis-luka', [K3Controller::class, 'k3_jenis_luka'])->name('k3-jenis-luka');

        Route::get('/k3-jenis-pekerjaan', [K3Controller::class, 'k3_jenis_pekerjaan'])->name('k3-jenis-pekerjaan');
        Route::post('/k3-jenis-pekerjaan', [K3Controller::class, 'k3_jenis_pekerjaan'])->name('k3-jenis-pekerjaan');

        Route::get('/k3-lokasi-kejadian', [K3Controller::class, 'k3_lokasi_kejadian'])->name('k3-lokasi-kejadian');
        Route::post('/k3-lokasi-kejadian', [K3Controller::class, 'k3_lokasi_kejadian'])->name('k3-lokasi-kejadian');

        Route::get('/k3-penyebab-kecelakaan', [K3Controller::class, 'k3_penyebab_kecelakaan'])->name('k3-penyebab-kecelakaan');
        Route::post('/k3-penyebab-kecelakaan', [K3Controller::class, 'k3_penyebab_kecelakaan'])->name('k3-penyebab-kecelakaan');

        //Pengajuan aset inventaris
        Route::get('/pengajuan-aset-inventaris', [InventarisController::class, 'pengajuan_aset_inventaris'])->name('pengajuan-aset-inventaris');
        Route::post('/pengajuan-aset-inventaris', [InventarisController::class, 'pengajuan_aset_inventaris'])->name('pengajuan-aset-inventaris');

        Route::get('/perbaikan-inventaris', [InventarisController::class, 'perbaikan_inventaris'])->name('perbaikan-inventaris');
        Route::post('/perbaikan-inventaris', [InventarisController::class, 'perbaikan_inventaris'])->name('perbaikan-inventaris');
        
        Route::resource('setting-pengguna', SettingPenggunaController::class);

        //jumlah inventaris
        Route::get('/jumlah_inventaris', [JumlahInventarisController::class, 'jumlah_inventaris'])->name('jumlah_inventaris');
        Route::post('/jumlah_inventaris', [JumlahInventarisController::class, 'jumlah_inventaris'])->name('jumlah_inventaris');
        
        //jumlah inventaris barang berdasarkan ruang
        Route::get('/jumlah_inventaris_barang_di_ruang', [JumlahInventarisController::class, 'jumlah_inventaris_barang_di_ruang'])->name('jumlah_inventaris_barang_di_ruang');
        Route::post('/jumlah_inventaris_barang_di_ruang', [JumlahInventarisController::class, 'jumlah_inventaris_barang_di_ruang'])->name('jumlah_inventaris_barang_di_ruang');
       
        //jumlah_inventaris_barang per-kategori
        Route::get('/jumlah_inventaris_barang_per_kategori', [JumlahInventarisController::class, 'jumlah_inventaris_barang_per_kategori'])->name('jumlah_inventaris_barang_per_kategori');
        Route::post('/jumlah_inventaris_barang_per_kategori', [JumlahInventarisController::class, 'jumlah_inventaris_barang_per_kategori'])->name('jumlah_inventaris_barang_per_kategori');
       
       //jumlah_inventaris_barang_per_merk
       Route::get('/jumlah_inventaris_barang_per_merk', [JumlahInventarisController::class, 'jumlah_inventaris_barang_per_merk'])->name('jumlah_inventaris_barang_per_merk');
       Route::post('/jumlah_inventaris_barang_per_merk', [JumlahInventarisController::class, 'jumlah_inventaris_barang_per_merk'])->name('jumlah_inventaris_barang_per_merk');
       
       //jumlah_inventaris_barang_per_jenis
       Route::get('/jumlah_inventaris_barang_per_jenis', [JumlahInventarisController::class, 'jumlah_inventaris_barang_per_jenis'])->name('jumlah_inventaris_barang_per_jenis');
       Route::post('/jumlah_inventaris_barang_per_jenis', [JumlahInventarisController::class, 'jumlah_inventaris_barang_per_jenis'])->name('jumlah_inventaris_barang_per_jenis');
       
       //jumlah_inventaris_barang_per_produsen
       Route::get('/jumlah_inventaris_barang_per_produsen', [JumlahInventarisController::class, 'jumlah_inventaris_barang_per_produsen'])->name('jumlah_inventaris_barang_per_produsen');
       Route::post('/jumlah_inventaris_barang_per_produsen', [JumlahInventarisController::class, 'jumlah_inventaris_barang_per_produsen'])->name('jumlah_inventaris_barang_per_produsen');
       
    });

      
    
Route::prefix('admin')
    ->namespace('admin')
    ->middleware('auth','admin')
    ->group( function(){
        
        //Route::get('/dashboard-admin',[Admin\DashboardController::class, 'index'])->name('dashboard-admin');
    });


Auth::routes();