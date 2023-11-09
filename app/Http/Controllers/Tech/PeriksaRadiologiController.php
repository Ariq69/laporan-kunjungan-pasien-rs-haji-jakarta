<?php


namespace App\Http\Controllers\Tech;

use App\Models\Pasien;
use App\Models\JnsPerawatabRadiologi;

use Illuminate\Http\Request;
use App\Models\PeriksaRadiologi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;


class PeriksaRadiologiController extends Controller
{
    public function jenis_perawatan_radiologi_ralan(Request $request)
{
    $years = DB::table('periksa_radiologi')
        ->select(DB::raw('YEAR(tgl_periksa) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();
    $jns_perawatan_radiologi = DB::table('jns_perawatan_radiologi')
        ->select('kd_jenis_prw', 'nm_perawatan')
        ->where('kd_jenis_prw', 'like', 'RADU%')
        ->get();

    $year = $request->input('year');
    $month = $request->input('month');
    $rad = $request->input('jns_perawatan_radiologi');

    $bar = DB::table('periksa_radiologi as pr')
    ->join('jns_perawatan_radiologi as jpr', 'pr.kd_jenis_prw', '=', 'jpr.kd_jenis_prw')
    ->select('pr.tgl_periksa', 'jpr.nm_perawatan', DB::raw('COUNT(pr.no_rawat) AS jumlah_no_perawat'))
    ->where('jpr.kd_jenis_prw', 'like', 'RADU%')
    // ->whereYear('pr.tgl_periksa', '=', 2023)
    // ->whereMonth('pr.tgl_periksa', '=', 8)
    // ->where('jpr.nm_perawatan', 'Panoramic') 
    ->whereYear('pr.tgl_periksa', '=',$year)
    ->whereMonth('pr.tgl_periksa', '=', $month)
    ->where('jpr.nm_perawatan', $rad) 
    ->where('pr.status', 'ralan')
    ->groupBy('pr.tgl_periksa', 'jpr.nm_perawatan')
    ->orderBy('pr.tgl_periksa')
    ->orderBy('jpr.nm_perawatan')
    ->get();

    
   

    $query = $bar->mapWithKeys(function ($item) {
        return [$item->tgl_periksa => $item-> jumlah_no_perawat];
    });

    return view('pages.tech.kunjungan.dashboard-pemeriksaan-radiologi-ralan', compact(
        'query',
        'years',
        'jns_perawatan_radiologi'
    ));
}

    public function jenis_perawatan_radiologi_ranap(Request $request)
    {
        $years = DB::table('periksa_radiologi')
            ->select(DB::raw('YEAR(tgl_periksa) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
    
        $bar = DB::table('jns_perawatan_radiologi as p')
            ->leftJoin('periksa_radiologi as r', 'p.kd_jenis_prw', '=', 'r.kd_jenis_prw')
            ->select('p.nm_perawatan', DB::raw('COUNT(r.kd_jenis_prw) as jumlah_jenis_prw'))
            ->whereYear('r.tgl_periksa', $year)
            ->whereMonth('r.tgl_periksa', $month)
            ->where('r.status', 'ranap') // Menambahkan filter status ralan di sini
            ->groupBy('p.nm_perawatan')
            ->get();
    
        $query = $bar->mapWithKeys(function ($item) {
            return [$item->nm_perawatan => $item->jumlah_jenis_prw];
        });
    
        return view('pages.tech.kunjungan.dashboard-pemeriksaan-radiologi-ranap', compact('years', 'query'));
    }
    
}
