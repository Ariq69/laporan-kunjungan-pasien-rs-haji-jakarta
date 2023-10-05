<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tech\SettingPenggunaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tech\DokterController;
use App\Http\Controllers\Tech\PerawatController;
use App\Http\Controllers\Tech\DashboardController;

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
        
        Route::resource('setting-pengguna', SettingPenggunaController::class);
    });
    

Route::prefix('admin')
    ->namespace('admin')
    ->middleware('auth','admin')
    ->group( function(){
        
        //Route::get('/dashboard-admin',[Admin\DashboardController::class, 'index'])->name('dashboard-admin');
    });


Auth::routes();