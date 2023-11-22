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
        
        $status = DB::table('reg_periksa')
            ->select('stts_daftar')
            ->groupBy('stts_daftar')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');
        $stts = $request->input('status');


        $jumlahData = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select('stts_daftar', DB::raw('DATE(reg_periksa.tgl_registrasi) AS tanggal'), DB::raw('COUNT(*) as jumlah_data'))
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->whereMonth('reg_periksa.tgl_registrasi', $month)
            ->where('poliklinik.nm_poli', $poli)
            ->where('stts_daftar', $stts)
            ->groupBy('stts_daftar', 'poliklinik.nm_poli', 'tanggal')
            ->get();
            // dd($jumlahData);
        
            $three_months = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 3) + 1 AS periode'),
                DB::raw("CASE 
                    WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 3 THEN 'Januari - Maret'
                    WHEN MONTH(tgl_registrasi) BETWEEN 4 AND 6 THEN 'April - Juni'
                    WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 9 THEN 'Juli - September'
                    WHEN MONTH(tgl_registrasi) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
                    ELSE 'Tidak Valid'
                END AS keterangan_periode"),
                'stts_daftar',
                DB::raw('COUNT(*) as jumlah_data')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('stts_daftar', $stts)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('poliklinik.nm_poli', 'keterangan_periode', 'tahun', 'stts_daftar', 'periode')
            ->get();                       
            // dd($three_months);

            $six_months = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 6) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 6 THEN 'Januari - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 12 THEN 'Juli - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                'stts_daftar',
                DB::raw('COUNT(stts_daftar) as jumlah_data')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->where('stts_daftar', $stts)
            ->groupBy('poliklinik.nm_poli', 'keterangan_periode', 'tahun', 'stts_daftar', 'periode')
            ->get(); 
            // dd($six_months);

            $one_years = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 12) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 12 THEN 'Januari - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                'stts_daftar',
                DB::raw('COUNT(stts_daftar) as jumlah_data')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('stts_daftar', $stts)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('poliklinik.nm_poli', 'keterangan_periode', 'tahun', 'stts_daftar', 'periode')
            ->get();
            // dd($one_years);

        $query = [];

        if ($request->input('triwulan') ) {
            $query = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_data];
            });
        } elseif ($request->input('semester') ) {
            $query = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_data];
            });
        } elseif ($request->input('tahunan') ) {
            $query = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_data];
            });
        } elseif ($request->input('month') ) {
            $query = $jumlahData->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->jumlah_data];
            });
        }

        return view('pages.tech.pasien.dashboard-pasien-perbulan', compact('years','poliklinik','query','status'));

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
        
        $poliklinik = DB::table('poliklinik')
            ->select('kd_poli', 'nm_poli')
            ->get();
        // dd($poliklinik);

        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');

        $bar = DB::table('poliklinik as p')
            ->leftJoin('reg_periksa as r', 'p.kd_poli', '=', 'r.kd_poli')
            ->select('p.nm_poli', DB::raw('DATE(r.tgl_registrasi) AS tahun'), DB::raw('COUNT(r.kd_poli) as jumlah_poli'))
            ->whereYear('r.tgl_registrasi', $year)
            ->whereMonth('r.tgl_registrasi', $month)
            ->where('p.nm_poli', $poli)
            ->groupBy('p.nm_poli', 'tahun')
            ->get();
            // dd($bar);
            

            $three_months = DB::table('poliklinik')
            ->leftJoin('reg_periksa', 'poliklinik.kd_poli', '=', 'reg_periksa.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 3) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 3 THEN 'Januari - Maret'
                WHEN MONTH(tgl_registrasi) BETWEEN 4 AND 6 THEN 'April - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 9 THEN 'Juli - September'
                WHEN MONTH(tgl_registrasi) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                'poliklinik.nm_poli',
                DB::raw('COUNT(reg_periksa.kd_poli) AS jumlah_poli')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli')
            ->get();        
            // dd($three_months);

            $six_months = DB::table('poliklinik')
            ->leftJoin('reg_periksa', 'poliklinik.kd_poli', '=', 'reg_periksa.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 6) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 6 THEN 'Januari - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 12 THEN 'Juli - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(reg_periksa.kd_poli) AS jumlah_poli')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode')
            ->get();
            // dd($six_months);

            $one_years = DB::table('poliklinik')
            ->leftJoin('reg_periksa', 'poliklinik.kd_poli', '=', 'reg_periksa.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 12) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 12 THEN 'Januari - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(reg_periksa.kd_poli) AS jumlah_poli')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode')
            ->get();
            // dd($one_years);

        $query = [];

            if ($request->input('triwulan') ) {
                $query = $three_months->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_poli];
                });
            } elseif ($request->input('semester') ) {
                $query = $six_months->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_poli];
                });
            } elseif ($request->input('tahunan') ) {
                $query = $one_years->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_poli];
                });
            } elseif ($request->input('month') ) {
                $query = $bar->mapWithKeys(function ($item) {
                    return [$item->tahun => $item->jumlah_poli];
                });
            }

        return view('pages.tech.pasien.dashboard-pasien-perpoli', compact('years','query','poliklinik'));
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
        
        $d = DB::table('dokter')
            ->select('kd_dokter', 'nm_dokter')
            ->groupBy('kd_dokter','nm_dokter')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');
        $dok = $request->input('dokter');

        $perdokter = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select('poliklinik.nm_poli', 'dokter.nm_dokter', DB::raw('DATE(reg_periksa.tgl_registrasi) AS tahun'), DB::raw('COUNT(*) as jumlah_pasien'))
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->whereMonth('reg_periksa.tgl_registrasi', $month)
            ->where('poliklinik.nm_poli', $poli)
            ->where('dokter.nm_dokter', $dok)
            ->groupBy('poliklinik.nm_poli', 'dokter.nm_dokter', 'tahun')
            ->get();
            // dd($perdokter);
        
            $three_months = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 3) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 3 THEN 'Januari - Maret'
                WHEN MONTH(tgl_registrasi) BETWEEN 4 AND 6 THEN 'April - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 9 THEN 'Juli - September'
                WHEN MONTH(tgl_registrasi) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('dokter.nm_dokter', $dok)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'dokter.nm_dokter')
            ->get();
            // dd($three_months);

            $six_months = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 6) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 6 THEN 'Januari - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 12 THEN 'Juli - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->where('dokter.nm_dokter', $dok)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'dokter.nm_dokter')
            ->get();
            // dd($six_months);

            $one_years = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 12) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 12 THEN 'Januari - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->where('dokter.nm_dokter', $dok)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'dokter.nm_dokter')
            ->get();
            // dd($one_years);



            $queryDokter = [];

            if ($request->input('triwulan')) {
                $queryDokter = $three_months->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_pasien];
                });
            } elseif ($request->input('semester')) {
                $queryDokter = $six_months->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_pasien];
                });
            } elseif ($request->input('tahunan')) {
                $queryDokter = $one_years->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_pasien];
                });
            } elseif ($request->input('month')) {
                $queryDokter = $perdokter->mapWithKeys(function ($item) {
                    return [$item->tahun => $item->jumlah_pasien];
                });
            }
        // Menambahkan total ke dalam array data untuk bar chart

        return view('pages.tech.pasien.dashboard-pasien-perdokter', compact(
            'years',
            'queryDokter',
            'poliklinik',
            'd',
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

        $jk = DB::table('pasien')
            ->select('jk')
            ->groupBy('jk')
            ->get();
            
        // dd($jk);
        
        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');
        $jenisKelamin = $request->input('jk');

        $perjk = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->select('poliklinik.nm_poli', 'pasien.jk', DB::raw('DATE(reg_periksa.tgl_registrasi) AS tanggal'), DB::raw('COUNT(*) as jumlah_pasien'))
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->whereMonth('reg_periksa.tgl_registrasi', $month)
            ->where('poliklinik.nm_poli', $poli)
            ->where('pasien.jk', $jenisKelamin)
            ->groupBy('poliklinik.nm_poli', 'pasien.jk', 'tanggal')
            ->get();
            // dd($perjk);

            $three_months = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 3) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 3 THEN 'Januari - Maret'
                WHEN MONTH(tgl_registrasi) BETWEEN 4 AND 6 THEN 'April - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 9 THEN 'Juli - September'
                WHEN MONTH(tgl_registrasi) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('pasien.jk', $jenisKelamin)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'pasien.jk')
            ->get();
            // dd($three_months);

            $six_months = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 6) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 6 THEN 'Januari - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 12 THEN 'Juli - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('pasien.jk', $jenisKelamin)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'pasien.jk')
            ->get();
            // dd($six_months);

            $one_years = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 12) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 12 THEN 'Januari - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('pasien.jk', $jenisKelamin)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'pasien.jk')
            ->get();
            // dd($one_years);

            $queryjk = [];

            if ($request->input('triwulan')) {
                $queryjk = $three_months->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_pasien];
                });
            } elseif ($request->input('semester')) {
                $queryjk = $six_months->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_pasien];
                });
            } elseif ($request->input('tahunan')) {
                $queryjk = $one_years->mapWithKeys(function ($item) {
                    return [$item->keterangan_periode => $item->jumlah_pasien];
                });
            } elseif ($request->input('month')) {
                $queryjk = $perjk->mapWithKeys(function ($item) {
                    return [$item->tanggal => $item->jumlah_pasien];
                });
            }
        // Menambahkan total ke dalam array data untuk bar chart

        return view('pages.tech.pasien.dashboard-pasien-perjk', compact(
            'years',
            'queryjk',
            'poliklinik',
            'jk',
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

        $kabupaten = DB::table('kabupaten')
            ->select('kd_kab', 'nm_kab')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');
        $kab = $request->input('kabupaten');

        $perkabupaten = DB::table('reg_periksa')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('kabupaten', 'pasien.kd_kab', '=', 'kabupaten.kd_kab')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->whereMonth('reg_periksa.tgl_registrasi', $month)
            ->where('poliklinik.nm_poli', $poli)
            ->where('kabupaten.nm_kab', $kab)
            ->select('kabupaten.nm_kab', DB::raw('DATE(tgl_registrasi) as tanggal'), DB::raw('COUNT(*) as jumlah_pasien'))
            ->groupBy('kabupaten.nm_kab', 'tanggal')
            ->get();
            // dd($perkabupaten);

            $three_months = DB::table('reg_periksa')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('kabupaten', 'pasien.kd_kab', '=', 'kabupaten.kd_kab')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 3) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 3 THEN 'Januari - Maret'
                WHEN MONTH(tgl_registrasi) BETWEEN 4 AND 6 THEN 'April - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 9 THEN 'Juli - September'
                WHEN MONTH(tgl_registrasi) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('kabupaten.nm_kab', $kab)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'kabupaten.nm_kab')
            ->get();
            // dd($three_months);

            $six_months = DB::table('reg_periksa')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('kabupaten', 'pasien.kd_kab', '=', 'kabupaten.kd_kab')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 6) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 6 THEN 'Januari - Juni'
                WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 12 THEN 'Juli - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('kabupaten.nm_kab', $kab)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'kabupaten.nm_kab')
            ->get();
            // dd($six_months);

            $one_years = DB::table('reg_periksa')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('kabupaten', 'pasien.kd_kab', '=', 'kabupaten.kd_kab')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 12) + 1 AS periode'),
                DB::raw("CASE 
                WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 12 THEN 'Januari - Desember'
                ELSE 'Tidak Valid'
            END AS keterangan_periode"),
                DB::raw('COUNT(*) AS jumlah_pasien')
            ])
            ->where('poliklinik.nm_poli', $poli)
            ->where('kabupaten.nm_kab', $kab)
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode','poliklinik.nm_poli', 'kabupaten.nm_kab')
            ->get();
            // dd($one_years);

        $querykabupaten = [];

        if ($request->input('triwulan')) {
            $querykabupaten = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_pasien];
            });
        } elseif ($request->input('semester')) {
            $querykabupaten = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_pasien];
            });
        } elseif ($request->input('tahunan')) {
            $querykabupaten = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_pasien];
            });
        } elseif ($request->input('month')) {
            $querykabupaten = $perkabupaten->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->jumlah_pasien];
            });
        }

        return view('pages.tech.pasien.dashboard-pasien-perkabupaten', compact(
            'years',
            'querykabupaten',
            'poliklinik',
            'kabupaten',
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

    public function pasien_persubang(Request $request){
        $hasil = DB::table('pasien as p')
        ->leftJoin('reg_periksa as r', 'p.no_rkm_medis', '=', 'r.no_rkm_medis')
        ->leftJoin('suku_bangsa as sb', 'p.suku_bangsa', '=', 'sb.id')
        ->select('sb.nama_suku_bangsa', DB::raw('COUNT(r.no_rkm_medis) AS jumlah_pasien'))
        ->groupBy('sb.nama_suku_bangsa')
        ->get();
        
        
            $query = $hasil->mapWithKeys(function ($item){
                return [$item->nama_suku_bangsa => $item->jumlah_pasien];
            
            });

        // Kirim data ke tampilan
        return view('pages.tech.pasien.dashboard-pasien-persubang', compact('query'));
    }

    public function pasien_perbahasa(Request $request){
        // $years = DB::table('pasien')
        //     ->select(DB::raw('YEAR(tgl_daftar) as year'))
        //     ->groupBy('year')
        //     ->orderBy('year', 'DESC')
        //     ->get();

        // $year = $request->input('year');
        // $month = $request->input('month');

        $result = DB::table('pasien')
            ->join('bahasa_pasien as bp', 'pasien.bahasa_pasien', '=', 'bp.id')
            ->select(
                // DB::raw('DATE(pasien.tgl_daftar) as tanggal_daftar'),
                DB::raw('COUNT(pasien.no_rkm_medis) as jumlah_pasien'),
                'bp.nama_bahasa as nama_bahasa'
            )
            // ->whereYear('pasien.tgl_daftar', $year)
            // ->whereMonth('pasien.tgl_daftar', $month)
            ->groupBy(
                // 'tanggal_daftar', 
                'nama_bahasa')
            ->get();

            
            $query = $result->mapWithKeys(function ($item){
                return [$item->nama_bahasa => $item->jumlah_pasien];
            
            });

        // Kirim data ke tampilan
        return view('pages.tech.pasien.dashboard-pasien-perbahasa', compact('query'));
    }
    

    public function pasien_baru(){
            
            if (request()->ajax()) {
            $data_pasien = RegistrasiPasien::with('penjab','reg_dokter','poli','namapasien')->where('stts_daftar', 'Baru');

            return Datatables::of($data_pasien)->make(true);
        }

        return view('pages.tech.pasien.dashboard-pasien-baru');
    }
        
}



