<?php

namespace App\Http\Controllers\tech;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PemakaianAirController extends Controller
{
    
    public function air_pdam(Request $request)
    {
        $years = DB::table('kesling_pemakaian_air_pdam')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $query = DB::table('kesling_pemakaian_air_pdam')
            ->select('tanggal', 'jumlahharian');

        // Menambahkan filter hanya jika tahun tersedia
        if ($year) {
            $query->whereYear('tanggal', $year);

            // Menambahkan filter bulan jika bulan tersedia
            if ($month) {
                $query->whereMonth('tanggal', $month);
            }
        }

        $data = $query->get();

        $query = $data->mapWithKeys(function ($item) {
            return [$item->tanggal => $item->jumlahharian];
        });

        return view('pages.tech.pemakaian-air.dashboard-air-pdam', compact('years', 'query'));
    }

    public function air_tanah(Request $request)
    {
        $years = DB::table('kesling_pemakaian_air_tanah')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $query = DB::table('kesling_pemakaian_air_tanah')
            ->select('tanggal', 'jumlahharian');

        // Menambahkan filter hanya jika tahun tersedia
        if ($year) {
            $query->whereYear('tanggal', $year);

            // Menambahkan filter bulan jika bulan tersedia
            if ($month) {
                $query->whereMonth('tanggal', $month);
            }
        }

        $data = $query->get();

        $query = $data->mapWithKeys(function ($item) {
            return [$item->tanggal => $item->jumlahharian];
        });

        return view('pages.tech.pemakaian-air.dashboard-air-tanah', compact('years', 'query'));
    }

}
