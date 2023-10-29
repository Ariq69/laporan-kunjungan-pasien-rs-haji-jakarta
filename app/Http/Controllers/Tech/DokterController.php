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

            $data_dokter = DB::table('dokter as d')
                ->join('spesialis as s', 'd.kd_sps', '=', 's.kd_sps')
                ->select('s.nm_sps', DB::raw('COUNT(*) as jumlah_dokter'))
                ->groupBy('s.nm_sps')
                ->get();

            $queryDokter = $data_dokter->mapWithKeys(function ($item){
                return [$item->nm_sps => $item->jumlah_dokter];
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
            ->whereIn('j.hari_kerja', ["SENIN", "SELASA", "RABU", "KAMIS", "JUMAT"])
            ->get()
            ->groupBy('nm_dokter');

        return view('pages.tech.dokter.dashboard-jadwal-dokter', compact('jadwaldokter'));

    }
}
