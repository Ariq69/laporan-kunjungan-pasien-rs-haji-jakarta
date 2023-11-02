<?php

namespace App\Http\Controllers\Tech;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DokterController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth',['tech']);
        }

        public function data_dokter(Request $request){

            $data_dokter = DB::table('poliklinik as p')
            ->select('p.nm_poli', DB::raw('COUNT(*) as jumlah_dokter'))
            ->join(DB::raw('(SELECT kd_dokter, kd_poli FROM jadwal GROUP BY kd_dokter, kd_poli) as j'), function ($join) {
                $join->on('p.kd_poli', '=', 'j.kd_poli');
            })
            ->groupBy('p.nm_poli')
            ->get();

            $queryDokter = $data_dokter->mapWithKeys(function ($item){
                return [$item->nm_poli => $item->jumlah_dokter];
            });

            return view('pages.tech.dokter.dashboard-data-dokter', compact(
                'queryDokter',
            ));
        }
        
        public function jadwal_dokter(){

        $jadwaldokter = DB::table('jadwal as j')
            ->join('dokter as d', 'j.kd_dokter', '=', 'd.kd_dokter')
            ->join('poliklinik as p', 'j.kd_poli', '=', 'p.kd_poli')
            ->select('d.nm_dokter as nm_dokter', 'j.hari_kerja', 'j.jam_mulai', 'j.jam_selesai', 'p.nm_poli as nm_poli')
            ->whereIn('j.hari_kerja', ["SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU", "AKHAD"])
            ->get()
            ->groupBy('nm_dokter');

        return view('pages.tech.dokter.dashboard-jadwal-dokter', compact('jadwaldokter'));

    }
}
