<?php

namespace App\Http\Controllers\Tech;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RegistrasiPasien;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\JnsPerawatabRadiologi;
use App\Models\PeriksaRadiologi;
use App\Models\Spesialis;

class RalanController extends Controller
{
    public function ralan_hemodialisa(Request $request){
        
        $years = DB::table('hemodialisa')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        

        $results = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->where('periksa.status_lanjut', 'Ralan')
        ->whereYear('tanggal', $year)
        ->whereMonth('tanggal', $month)
        ->select(DB::raw('DATE(hemo.tanggal) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(tanggal)'))
        ->get();
        //dd($results); 
        
        $three_months = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->select([
            DB::raw('YEAR(hemo.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(hemo.tanggal) - 1) / 3) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(hemo.tanggal) BETWEEN 1 AND 3 THEN 'Januari - Maret'
            WHEN MONTH(hemo.tanggal) BETWEEN 4 AND 6 THEN 'April - Juni'
            WHEN MONTH(hemo.tanggal) BETWEEN 7 AND 9 THEN 'Juli - September'
            WHEN MONTH(hemo.tanggal) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_kunjungan')
        ])
        ->where('periksa.status_lanjut', 'Ralan')
        ->whereYear('hemo.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();        
        // dd($three_months);

        $six_months = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->select([
            DB::raw('YEAR(hemo.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(hemo.tanggal) - 1) / 6) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(hemo.tanggal) BETWEEN 1 AND 6 THEN 'Januari - Juni'
            WHEN MONTH(hemo.tanggal) BETWEEN 7 AND 12 THEN 'Juli - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_kunjungan')
        ])
        ->where('periksa.status_lanjut', 'Ralan')
        ->whereYear('hemo.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get(); 
        // dd($six_months);

        $one_years = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->select([
            DB::raw('YEAR(hemo.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(hemo.tanggal) - 1) / 12) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(hemo.tanggal) BETWEEN 1 AND 12 THEN 'Januari - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_kunjungan')
        ])
        ->where('periksa.status_lanjut', 'Ralan')
        ->whereYear('hemo.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get(); 
        // dd($one_years);
        
        $query = [];

        if ($request->input('triwulan') ) {
            $query = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_kunjungan];
            });
        } elseif ($request->input('semester') ) {
            $query = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_kunjungan];
            });
        } elseif ($request->input('tahunan') ) {
            $query = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_kunjungan];
            });
        } elseif ($request->input('month') ) {
            $query = $results->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->jumlah_kunjungan];
            });
        }

        return view('pages.tech.kunjungan.dashboard-ralan-hemodialisa',compact('years','query'));

    }

    public function ralan_lab(Request $request) {
        $years = DB::table('permintaan_lab')
            ->select(DB::raw('YEAR(tgl_permintaan) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
        $labType = $request->input('lab_type'); // Get the selected lab type from the form
        
        $permintaan = DB::table('permintaan_lab')
            ->select(DB::raw('DATE(tgl_permintaan) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
            ->whereYear('tgl_permintaan', $year)
            ->whereMonth('tgl_permintaan', $month)
            ->where('status', 'ralan')
            ->groupBy(DB::raw('CAST(tgl_permintaan AS DATE)'))
            ->orderBy('tanggal')
            ->get();
        
        $pemeriksaan = DB::table('periksa_lab')
            ->select(DB::raw('DATE(tgl_periksa) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
            ->whereYear('tgl_periksa', $year)
            ->whereMonth('tgl_periksa', $month)
            ->where('status', 'ralan')
            ->groupBy(DB::raw('CAST(tgl_periksa AS DATE)'))
            ->orderBy('tanggal')
            ->get();

        $query = [];
    
        if ($labType === 'permintaan') {
            $query = $permintaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        } elseif ($labType === 'pemeriksaan') {
            $query = $pemeriksaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        }
        //dd($query);
        return view('pages.tech.kunjungan.dashboard-ralan-lab', compact('years', 'query'));
    }

  
        
}
