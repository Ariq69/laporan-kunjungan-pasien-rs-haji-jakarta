<?php

namespace App\Http\Controllers\Tech;

use App\Models\Pasien;
use App\Models\KamarPasien;

use Illuminate\Http\Request;
use App\Models\RegistrasiPasien;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PasienController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth',['tech']);
        }

    public function pasien(){

        return view('pages.tech.pasien.dashboard-pasien');
    }

    public function pasien_perbulan(Request $request){
                $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $poliklinik = DB::table('poliklinik')
            ->select('kd_poli', 'nm_poli')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');


        $jumlahData = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select('reg_periksa.stts_daftar', DB::raw('COUNT(*) as jumlah_data'))
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->whereMonth('reg_periksa.tgl_registrasi', $month)
            ->where('poliklinik.nm_poli', $poli)
            ->groupBy('reg_periksa.stts_daftar')
            ->get();

        $query = $jumlahData->mapWithKeys(function ($item){
            return [$item->stts_daftar => $item->jumlah_data];
        });

        return view('pages.tech.pasien.dashboard-pasien-perbulan', compact('years','poliklinik','query'));

    }

    public function pasien_carabayar(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');

        $barchart = $result = DB::table('reg_periksa')
            ->join('penjab as p', 'reg_periksa.kd_pj', '=', 'p.kd_pj')
            ->groupBy('p.kd_kel_pj')
            ->select('p.kd_kel_pj', DB::raw('COUNT(p.kd_pj) as jumlah_kd_pj'))
            ->orderBy('p.kd_kel_pj', 'asc')
            ->get();
        
        $details = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->join('kel_penjab', 'penjab.kd_kel_pj', '=', 'kel_penjab.kd_kel_pj')
            ->select('poliklinik.nm_poli', 'kel_penjab.kd_kel_pj', DB::raw('COUNT(*) AS jumlah_pasien'))
            ->whereIn('kel_penjab.kd_kel_pj', ["UMUM", "BPJ", "ADM", "PER"])
            ->groupBy('poliklinik.nm_poli', 'kel_penjab.kd_kel_pj')
            ->get()
            ->groupBy('nm_poli');
        // Menghitung total jumlah_kd_pj
        $totalJumlahKdPj = $result->sum('jumlah_kd_pj');

        $barQuery = $result->mapWithKeys(function ($item){
            return [$item->kd_kel_pj => $item->jumlah_kd_pj];
        });

        // Menambahkan total ke dalam array data untuk bar chart
        $barQuery['Total'] = $totalJumlahKdPj;

        return view('pages.tech.pasien.dashboard-pasien-percarabayar', compact(
            'years',
            'barQuery',
            'details'
        ));
    }

    public function pasien_perpoli(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');

        $bar = DB::table('poliklinik as p')
            ->leftJoin('reg_periksa as r', 'p.kd_poli', '=', 'r.kd_poli')
            ->select('p.nm_poli', DB::raw('COUNT(r.kd_poli) as jumlah_poli'))
            ->whereYear('r.tgl_registrasi', $year)
            ->whereMonth('r.tgl_registrasi', $month)
            ->groupBy('p.nm_poli')
            ->get();



        $query = $bar->mapWithKeys(function ($item){
            return [$item->nm_poli => $item->jumlah_poli];
        
        });

        return view('pages.tech.pasien.dashboard-pasien-perpoli', compact('years','query'));
    }

    public function pasien_peragama(Request $request){
       
        $totalPasienPerAgama = DB::table('pasien')
            ->select('agama', DB::raw('COUNT(*) as total_pasien'))
            ->join('reg_periksa', 'pasien.no_rkm_medis', '=', 'reg_periksa.no_rkm_medis')
            ->groupBy('agama')
            ->get();

        $query = $totalPasienPerAgama->mapWithKeys(function ($item){
            return [$item->agama => $item->total_pasien];
        
        });

        return view('pages.tech.pasien.dashboard-pasien-peragama', compact('query'));
    }

    public function pasien_perumur(Request $request) {
        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
    
        $totalPasienPerUmur = DB::table('reg_periksa')
            ->select(DB::raw("
                CASE
                    WHEN umurdaftar BETWEEN 0 AND 9 THEN '0-9'
                    WHEN umurdaftar BETWEEN 10 AND 19 THEN '10-19'
                    WHEN umurdaftar BETWEEN 20 AND 29 THEN '20-29'
                    WHEN umurdaftar BETWEEN 30 AND 39 THEN '30-39'
                    WHEN umurdaftar BETWEEN 40 AND 49 THEN '40-49'
                    WHEN umurdaftar BETWEEN 50 AND 59 THEN '50-59'
                    WHEN umurdaftar BETWEEN 60 AND 69 THEN '60-69'
                    ELSE '70+'
                END AS kelompok_umur,
                COUNT(*) AS jumlah_pasien
            "))
            ->when($year, function ($query, $year) {
                return $query->whereYear('tgl_registrasi', $year);
            })
            ->when($month, function ($query, $month) {
                return $query->whereMonth('tgl_registrasi', $month);
            })
            ->groupBy('kelompok_umur')
            ->orderBy('kelompok_umur')
            ->get();
    
        $query = $totalPasienPerUmur->mapWithKeys(function ($item) {
            return [$item->kelompok_umur => $item->jumlah_pasien];
        });
    
        return view('pages.tech.pasien.dashboard-pasien-perumur', compact('query', 'years'));
    }
    

    public function pasien_perdokter(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $poliklinik = DB::table('poliklinik')
            ->select('kd_poli', 'nm_poli')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');

        $perdokter = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select('poliklinik.nm_poli', 'dokter.nm_dokter', DB::raw('COUNT(*) as jumlah_pasien'))
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->whereMonth('reg_periksa.tgl_registrasi', $month)
            ->where('poliklinik.nm_poli', $poli)
            ->groupBy('poliklinik.nm_poli', 'dokter.nm_dokter')
            ->get();



        $queryDokter = $perdokter->mapWithKeys(function ($item){
            return [$item->nm_dokter => $item->jumlah_pasien];
        });
        // Menambahkan total ke dalam array data untuk bar chart

        return view('pages.tech.pasien.dashboard-pasien-perdokter', compact(
            'years',
            'queryDokter',
            'poliklinik',
        ));
    }

    public function pasien_perjk(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $poliklinik = DB::table('poliklinik')
            ->select('kd_poli', 'nm_poli')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');

        $perjk = DB::table('reg_periksa as pa')
            ->join('poliklinik as p', 'pa.kd_poli', '=', 'p.kd_poli')
            ->join('pasien as ps', 'pa.no_rkm_medis', '=', 'ps.no_rkm_medis')
            ->select('p.nm_poli', 'ps.jk', DB::raw('COUNT(*) as jumlah_pasien'))
            ->whereYear('pa.tgl_registrasi', $year)
            ->whereMonth('pa.tgl_registrasi', $month)
            ->where('p.nm_poli', $poli)
            ->groupBy('p.nm_poli', 'ps.jk')
            ->get();

        $queryjk = $perjk->mapWithKeys(function ($item){
            return [$item->jk => $item->jumlah_pasien];
        });
        // Menambahkan total ke dalam array data untuk bar chart

        return view('pages.tech.pasien.dashboard-pasien-perjk', compact(
            'years',
            'queryjk',
            'poliklinik',
        ));
    }

    public function pasien_perkabupaten(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $poliklinik = DB::table('poliklinik')
            ->select('kd_poli', 'nm_poli')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');

        $perkabupaten = DB::table('reg_periksa as r')
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->join('kabupaten as k', 'p.kd_kab', '=', 'k.kd_kab')
            ->join('poliklinik as pl', 'r.kd_poli', '=', 'pl.kd_poli')
            ->whereYear('r.tgl_registrasi', $year)
            ->whereMonth('r.tgl_registrasi', $month)
            ->where('pl.nm_poli', $poli)
            ->select('k.nm_kab', DB::raw('COUNT(*) as jumlah_pasien'))
            ->groupBy('k.nm_kab')
            ->get();

        $querykabupaten = $perkabupaten->mapWithKeys(function ($item){
            return [$item->nm_kab => $item->jumlah_pasien];
        });
        // Menambahkan total ke dalam array data untuk bar chart

        return view('pages.tech.pasien.dashboard-pasien-perkabupaten', compact(
            'years',
            'querykabupaten',
            'poliklinik',
        ));
    }

    public function pasien_perkecamatan(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $poliklinik = DB::table('poliklinik')
            ->select('kd_poli', 'nm_poli')
            ->get();
        
        $kabupaten = DB::table('kabupaten')
            ->select('kd_kab', 'nm_kab')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');
        $kab = $request->input('kabupaten');

        $perkecamatan = DB::table('reg_periksa as r')
            ->select('k.nm_kab', 'kec.nm_kec', DB::raw('COUNT(*) as jumlah_pasien'))
            ->join('pasien as p', 'r.no_rkm_medis', '=', 'p.no_rkm_medis')
            ->join('kecamatan as kec', 'p.kd_kec', '=', 'kec.kd_kec')
            ->join('kabupaten as k', 'p.kd_kab', '=', 'k.kd_kab')
            ->join('poliklinik as pl', 'r.kd_poli', '=', 'pl.kd_poli')
            ->whereYear('r.tgl_registrasi', $year)
            ->whereMonth('r.tgl_registrasi', $month)
            ->where('pl.nm_poli', $poli)
            ->where('k.nm_kab', $kab)
            ->groupBy('k.kd_kab', 'k.nm_kab', 'kec.kd_kec', 'kec.nm_kec')
            ->get();


        $querykecamatan = $perkecamatan->mapWithKeys(function ($item){
            return [$item->nm_kec => $item->jumlah_pasien];
        });
        // Menambahkan total ke dalam array data untuk bar chart

        return view('pages.tech.pasien.dashboard-pasien-perkecamatan', compact(
            'years',
            'querykecamatan',
            'poliklinik',
            'kabupaten',
        ));
    }


    public function pasien_baru(){
            
            if (request()->ajax()) {
            $data_pasien = RegistrasiPasien::with('penjab','reg_dokter','poli','namapasien')->where('stts_daftar', 'Baru');

            return Datatables::of($data_pasien)->make(true);
        }

        return view('pages.tech.pasien.dashboard-pasien-baru');
    }
        
}



