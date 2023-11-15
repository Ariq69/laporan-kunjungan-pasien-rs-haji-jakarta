<?php

namespace App\Http\Controllers\tech;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KeslingPemakaianAirPdam;

class K3Controller extends Controller
{
    public function k3(Request $request){
        $years = DB::table('k3rs_peristiwa')
        ->select(DB::raw('YEAR(tgl_insiden) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');
        
        $hasil = DB::table('k3rs_peristiwa')
        ->select('tgl_insiden', DB::raw('COUNT(*) as jumlah_kejadian'))
        ->whereYear('tgl_insiden', $year)
        ->whereMonth('tgl_insiden', $month)
        ->groupBy('tgl_insiden')
        ->get();

        $query = $hasil->mapWithKeys(function ($item) {
            return [$item->tgl_insiden => $item->jumlah_kejadian];
        });

        return view('pages.tech.k3.dashboard-k3', compact('years','query'));
    }

    public function k3_bagian_tubuh(){
        $hasil = DB::table('k3rs_bagian_tubuh')
            ->leftJoin('k3rs_peristiwa', 'k3rs_bagian_tubuh.kode_bagian', '=', 'k3rs_peristiwa.kode_bagian')
            ->select('k3rs_bagian_tubuh.bagian_tubuh', DB::raw('COUNT(k3rs_peristiwa.no_k3rs) AS jumlah_insiden'))
            ->groupBy('k3rs_bagian_tubuh.kode_bagian', 'k3rs_bagian_tubuh.bagian_tubuh')
            ->get();
    
        $query = $hasil->mapWithKeys(function ($item){
            return [$item->bagian_tubuh => $item->jumlah_insiden];
        });
    
        return view('pages.tech.k3.dashboard-k3-bagian-tubuh', compact('query'));
    }

    public function k3_dampak_cidera(){
        $hasil = DB::table('k3rs_dampak_cidera')
            ->leftJoin('k3rs_peristiwa', 'k3rs_dampak_cidera.kode_dampak', '=', 'k3rs_peristiwa.kode_dampak')
            ->select('k3rs_dampak_cidera.dampak_cidera', DB::raw('COUNT(k3rs_peristiwa.no_k3rs) AS jumlah_insiden'))
            ->groupBy('k3rs_dampak_cidera.kode_dampak', 'k3rs_dampak_cidera.dampak_cidera')
            ->get();
    
        $query = $hasil->mapWithKeys(function ($item){
            return [$item->dampak_cidera => $item->jumlah_insiden];
        });
    
        return view('pages.tech.k3.dashboard-k3-dampak-cidera', compact('query'));
    }
    
    public function k3_jenis_cidera(){
        $hasil = DB::table('k3rs_jenis_cidera')
            ->leftJoin('k3rs_peristiwa', 'k3rs_jenis_cidera.kode_cidera', '=', 'k3rs_peristiwa.kode_cidera')
            ->select('k3rs_jenis_cidera.jenis_cidera', DB::raw('COUNT(k3rs_peristiwa.no_k3rs) AS jumlah_insiden'))
            ->groupBy('k3rs_jenis_cidera.kode_cidera', 'k3rs_jenis_cidera.jenis_cidera')
            ->get();
    
        $query = $hasil->mapWithKeys(function ($item){
            return [$item->jenis_cidera => $item->jumlah_insiden];
        });
    
        return view('pages.tech.k3.dashboard-k3-jenis-cidera', compact('query'));
    }

    public function k3_jenis_luka(){
        $hasil = DB::table('k3rs_jenis_luka')
            ->leftJoin('k3rs_peristiwa', 'k3rs_jenis_luka.kode_luka', '=', 'k3rs_peristiwa.kode_luka')
            ->select('k3rs_jenis_luka.jenis_luka', DB::raw('COUNT(k3rs_peristiwa.no_k3rs) AS jumlah_insiden'))
            ->groupBy('k3rs_jenis_luka.kode_luka', 'k3rs_jenis_luka.jenis_luka')
            ->get();
    
        $query = $hasil->mapWithKeys(function ($item){
            return [$item->jenis_luka => $item->jumlah_insiden];
        });
    
        return view('pages.tech.k3.dashboard-k3-jenis-luka', compact('query'));
    }

    public function k3_jenis_pekerjaan(){
        $hasil = DB::table('k3rs_jenis_pekerjaan')
            ->leftJoin('k3rs_peristiwa', 'k3rs_jenis_pekerjaan.kode_pekerjaan', '=', 'k3rs_peristiwa.kode_pekerjaan')
            ->select('k3rs_jenis_pekerjaan.jenis_pekerjaan', DB::raw('COUNT(k3rs_peristiwa.no_k3rs) AS jumlah_insiden'))
            ->groupBy('k3rs_jenis_pekerjaan.kode_pekerjaan', 'k3rs_jenis_pekerjaan.jenis_pekerjaan')
            ->get();
    
        $query = $hasil->mapWithKeys(function ($item){
            return [$item->jenis_pekerjaan => $item->jumlah_insiden];
        });
    
        return view('pages.tech.k3.dashboard-k3-jenis-pekerjaan', compact('query'));
    }

    public function k3_lokasi_kejadian(Request $request){
        $hasil = DB::table('k3rs_lokasi_kejadian')
        ->leftJoin('k3rs_peristiwa', 'k3rs_lokasi_kejadian.kode_lokasi', '=', 'k3rs_peristiwa.kode_lokasi')
        ->select('k3rs_lokasi_kejadian.lokasi_kejadian', DB::raw('COUNT(k3rs_peristiwa.no_k3rs) AS jumlah_insiden'))
        ->groupBy('k3rs_lokasi_kejadian.kode_lokasi', 'k3rs_lokasi_kejadian.lokasi_kejadian')
        ->get();

        $query = $hasil->mapWithKeys(function ($item) {
            return [$item->lokasi_kejadian => $item->jumlah_insiden];
        });
    
        return view('pages.tech.k3.dashboard-k3-lokasi-kejadian', compact('query'));
    }

    public function k3_penyebab_kecelakaan(Request $request){
            
        $hasil = DB::table('k3rs_penyebab')
        ->leftJoin('k3rs_peristiwa', 'k3rs_penyebab.kode_penyebab', '=', 'k3rs_peristiwa.kode_penyebab')
        ->select('k3rs_penyebab.penyebab_kecelakaan', DB::raw('COUNT(k3rs_peristiwa.no_k3rs) AS jumlah_insiden'))
        ->groupBy('k3rs_penyebab.kode_penyebab', 'k3rs_penyebab.penyebab_kecelakaan')
        ->get();

        $query = $hasil->mapWithKeys(function ($item) {
            return [$item->penyebab_kecelakaan => $item->jumlah_insiden];
        });
    
        return view('pages.tech.k3.dashboard-k3-penyebab-kecelakaan', compact('query'));
    }

}

