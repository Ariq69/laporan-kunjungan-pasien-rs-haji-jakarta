<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use illuminate\Support\Facades\DB;
use Termwind\Components\Raw;
use App\Models\RegistrasiPasien;

class KunjunganController extends Controller
{
      public function totalKunjungan(Request $request){
        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $bar = DB::table('reg_periksa')
        ->select(DB::raw('DATE(tgl_periksa) as tanggal'), DB::raw('COUNT(*) as total_kunjungan'))
        ->whereYear('tgl_registrasi', $year)
        ->whereMonth('tgl_registrasi', $month)
        ->groupBy(DB::raw('CAST(tgl_registrasi AS DATE)'))
        ->orderBy('tanggal')
        ->get();

        $query = $bar->mapWithKeys(function ($item){
            return [$item->tanggal => $item->total_kunjungan];
        });

        return view('tech.dashboard', compact(
            'years',
            'query',
        ));
      }

}
