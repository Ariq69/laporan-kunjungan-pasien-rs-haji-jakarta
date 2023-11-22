<?php

namespace App\Http\Controllers\Tech;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IGDController extends Controller
{
    public function dashboard_igd(){

        return view('pages.tech.kunjungan.igd.dashboard-igd');
    }

    public function igd_lab(Request $request){
        $years = DB::table('reg_periksa')
            ->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

         $lab = DB::table('periksa_lab as p')
            ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
            ->select(DB::raw('DATE(tgl_periksa) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabigd'))
            ->whereYear('p.tgl_periksa', $year)
            ->whereMonth('p.tgl_periksa', $month)
            ->whereIn('r.kd_poli', ['IGD01','IGDK'])
            ->groupBy(DB::raw('CAST(p.tgl_periksa AS DATE)'))
            ->orderBy('tanggal')
            ->get();


        $three_months = DB::table('periksa_lab as p')
            ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
            ->select([
                DB::raw('YEAR(p.tgl_periksa) AS tahun'),
                DB::raw('FLOOR((MONTH(p.tgl_periksa) - 1) / 3) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(p.tgl_periksa) BETWEEN 1 AND 3 THEN 'Januari - Maret'
                WHEN MONTH(p.tgl_periksa) BETWEEN 4 AND 6 THEN 'April - Juni'
                WHEN MONTH(p.tgl_periksa) BETWEEN 7 AND 9 THEN 'Juli - September'
                WHEN MONTH(p.tgl_periksa) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS total_kunjunganlabranap')
            ])
            ->whereYear('p.tgl_periksa', $year)
            ->whereIn('r.kd_poli', ['IGD01','IGDK'])
            ->groupBy('tahun', 'periode', 'keterangan_periode')
            ->get();
        
        // dd($three_months);

        $six_months = DB::table('periksa_lab as p')
            ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
            ->select([
                DB::raw('YEAR(p.tgl_periksa) AS tahun'),
                DB::raw('FLOOR((MONTH(p.tgl_periksa) - 1) / 6) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(p.tgl_periksa) BETWEEN 1 AND 6 THEN 'Januari - Juni'
                WHEN MONTH(p.tgl_periksa) BETWEEN 7 AND 12 THEN 'Juli - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS total_kunjunganlabranap')
            ])
            ->whereYear('p.tgl_periksa', $year)
            ->whereIn('r.kd_poli', ['IGD01','IGDK'])
            ->groupBy('tahun', 'periode', 'keterangan_periode')
            ->get();
            // dd($six_months);

        $one_years = DB::table('periksa_lab as p')
            ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
            ->select([
                DB::raw('YEAR(p.tgl_periksa) AS tahun'),
                DB::raw('FLOOR((MONTH(p.tgl_periksa) - 1) / 12) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(p.tgl_periksa) BETWEEN 1 AND 12 THEN 'Januari - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS total_kunjunganlabranap')
            ])
            ->whereYear('p.tgl_periksa', $year)
            ->whereIn('r.kd_poli', ['IGD01','IGDK'])
            ->groupBy('tahun', 'periode', 'keterangan_periode')
            ->get();
            // dd($one_years);
        $query = [];

        if ($request->input('triwulan') ) {
            $query = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjunganlabranap];
            });
        } elseif ($request->input('semester') ) {
            $query = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjunganlabranap];
            });
        } elseif ($request->input('tahunan') ) {
            $query = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjunganlabranap];
            });
        } elseif ($request->input('month') ) {
            $query = $lab->mapWithKeys(function ($item){
            return [$item->tanggal => $item->total_kunjunganlabigd];
            });
        };

        return view('pages.tech.kunjungan.igd.igd-lab', compact('years','query'));
    }

    public function igd_hemo(Request $request){
        
        $years = DB::table('hemodialisa')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        

        $results = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->whereIn('periksa.kd_poli', ['IGD01','IGDK'])
        ->whereYear('hemo.tanggal', $year)
        ->whereMonth('hemo.tanggal', $month)
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
        ->whereIn('periksa.kd_poli', ['IGD01','IGDK'])
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
        ->whereIn('periksa.kd_poli', ['IGD01','IGDK'])
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
        ->whereIn('periksa.kd_poli', ['IGD01','IGDK'])
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


        return view('pages.tech.kunjungan.igd.igd-hemo',compact('years','query'));

    }

}
