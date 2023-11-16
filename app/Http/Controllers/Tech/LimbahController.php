<?php

namespace App\Http\Controllers\tech;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class LimbahController extends Controller{

public function limbah(Request $request) {
    $dataMutuAirLimbah = []; // Inisialisasi variabel

    if ($request->ajax()) {
        $dataMutuAirLimbah = DB::table('kesling_mutu_air_limbah')
        ->select(
            'tanggal as tanggal',
            'meteran as meteran',
            'jumlahharian as jumlahharian',
            'ph as ph',
            'suhu as suhu',
            'tds as tds',
            'ec as ec',
            'salt as salt'
        )->get();
        return datatables()->of($dataMutuAirLimbah)->make(true);
    }

    $years = DB::table('kesling_limbah_b3medis')
        ->select(DB::raw('YEAR(tanggal) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();

    $year = $request->input('year');
    $month = $request->input('month');
    $tipelimbah = $request->input('tipe_limbah');

    $limbahB3 = DB::table('kesling_limbah_b3medis')
    ->select('tanggal', 'jmllimbah')
    ->whereYear('tanggal', $year)
    ->whereMonth('tanggal', $month)
    ->orderBy('tanggal')
    ->get();

    $limbahdomestik = DB::table('kesling_limbah_domestik')
    ->select('tanggal', 'jumlahlimbah')
    ->whereYear('tanggal', $year)
    ->whereMonth('tanggal', $month)
    ->orderBy('tanggal')
    ->get();

    $limbahB3cair = DB::table('kesling_limbah_b3medis')
    ->select('tanggal', 'jmllimbah')
    ->whereYear('tanggal', $year)
    ->whereMonth('tanggal', $month)
    ->orderBy('tanggal')
    ->get();

    $query = [];
    
    if ($tipelimbah === 'B3') {
        $query = $limbahB3->mapWithKeys(function ($item) {
            return [$item->tanggal => $item->jmllimbah];
        });
    } elseif ($tipelimbah === 'B3Cair') {
        $query = $limbahB3cair->mapWithKeys(function ($item) {
            return [$item->tanggal => $item->jmllimbah];
        });
    } elseif ($tipelimbah === 'Domestik') {
        $query = $limbahdomestik->mapWithKeys(function ($item) {
            return [$item->tanggal => $item->jumlahlimbah];
        });
    }

    return view('pages.tech.limbah.dashboard-limbah', compact('years', 'query', 'dataMutuAirLimbah'));
}

}
