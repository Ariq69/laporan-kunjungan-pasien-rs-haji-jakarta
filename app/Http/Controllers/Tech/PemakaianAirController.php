<?php

namespace App\Http\Controllers\tech;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PemakaianAirController extends Controller
{
    
    public function pemakaian_air(Request $request)
{
    $years = DB::table('kesling_pemakaian_air_pdam')
        ->select(DB::raw('YEAR(tanggal) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();

    $year = $request->input('year');
    $month = $request->input('month');
    $airType = $request->input('airtype');

    $pdam = DB::table('kesling_pemakaian_air_pdam')
        ->select('tanggal', 'jumlahharian as total_pemakaianairpdam')
        ->whereYear('tanggal', $year)
        ->whereMonth('tanggal', $month)
        ->orderBy('tanggal')
        ->get();
        //dd($pdam);
    $tanah = DB::table('kesling_pemakaian_air_tanah')
        ->select('tanggal', 'jumlahharian as total_pemakaianairtanah')
        ->whereYear('tanggal', $year)
        ->whereMonth('tanggal', $month)
        ->orderBy('tanggal')
        ->get();
    
    $query = [];

    if ($airType == 'pdam') {
        $query = $pdam->mapWithKeys(function ($item) {
            return [$item->tanggal => $item->total_pemakaianairpdam];
        });
    } elseif ($airType == 'tanah') {
        $query = $tanah->mapWithKeys(function ($item) {
            return [$item->tanggal => $item->total_pemakaianairtanah];
        });
    }
    //dd($query);
    return view('pages.tech.pemakaian-air.dashboard-pemakaian-air', compact('years', 'query'));
}


}
