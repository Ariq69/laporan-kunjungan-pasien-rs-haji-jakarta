<?php

namespace App\Http\Controllers\Tech;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RegistrasiPasien;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

      public function penyakit(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');
        
        $topPenyakit = DB::table('diagnosa_pasien as dp')
            ->join('penyakit as p', 'dp.kd_penyakit', '=', 'p.kd_penyakit')
            ->join('reg_periksa as rp', 'dp.no_rawat', '=', 'rp.no_rawat')
            ->select('p.nm_penyakit', DB::raw('COUNT(dp.kd_penyakit) as jumlah_pasien'))
            ->whereYear('rp.tgl_registrasi', $year)
            ->whereMonth('rp.tgl_registrasi', $month)
            ->groupBy('p.nm_penyakit')
            ->orderBy('jumlah_pasien', 'desc')
            ->limit(11) // Mengambil hanya 1 penyakit dengan jumlah pasien terbanyak
            ->get();
            

        $query = $topPenyakit->mapWithKeys(function ($item){
            return [$item->nm_penyakit => $item->jumlah_pasien];
        });

        return view('pages.tech.kunjungan.dashboard-penyakit', compact('years','query'));
        
    }

      public function informasi_kamar(){

        $infoKamar = DB::table('kamar')
        ->join('bangsal', 'kamar.kd_bangsal', '=', 'bangsal.kd_bangsal')
        ->select('bangsal.nm_bangsal', 'kamar.kd_bangsal')
        ->selectRaw('SUM(CASE WHEN kelas = ? THEN 1 ELSE 0 END) AS Jumlah_Kelas1', ['Kelas 1'])
        ->selectRaw('SUM(CASE WHEN kelas = ? THEN 1 ELSE 0 END) AS Jumlah_Kelas2', ['Kelas 2'])
        ->selectRaw('SUM(CASE WHEN kelas = ? THEN 1 ELSE 0 END) AS Jumlah_Kelas3', ['Kelas 3'])
        ->selectRaw('SUM(CASE WHEN kelas = ? THEN 1 ELSE 0 END) AS Jumlah_KelasUtama', ['Kelas Utama'])
        ->selectRaw('SUM(CASE WHEN kelas = ? THEN 1 ELSE 0 END) AS Jumlah_KelasVIP', ['Kelas VIP'])
        ->selectRaw('SUM(CASE WHEN kelas = ? THEN 1 ELSE 0 END) AS Jumlah_KelasVVIP', ['Kelas VVIP'])
        ->groupBy('bangsal.nm_bangsal', 'kamar.kd_bangsal')
        ->get();

        // dd($infoKamar);

        $infoBed = DB::table('kamar')
        ->join('bangsal', 'kamar.kd_bangsal', '=', 'bangsal.kd_bangsal')
        ->select('bangsal.nm_bangsal', 'kamar.kelas')
        ->selectRaw('COUNT(CASE WHEN kamar.status = "ISI" THEN 1 ELSE NULL END) AS Jumlah_ISI')
        ->selectRaw('COUNT(CASE WHEN kamar.status = "KOSONG" THEN 1 ELSE NULL END) AS Jumlah_KOSONG')
        ->selectRaw('COUNT(CASE WHEN kamar.status = "DIBERSIHKAN" THEN 1 ELSE NULL END) AS Jumlah_DIBERSIHKAN')
        ->selectRaw('COUNT(CASE WHEN kamar.status = "DIBOOKING" THEN 1 ELSE NULL END) AS Jumlah_DIBOOKING')
        ->groupBy('bangsal.nm_bangsal', 'kamar.kelas')
        ->get();

        $urutanKelas = [
            'VVIP',
            'VIP',
            'Kelas Utama',
            'Kelas 1',
            'Kelas 2',
            'Kelas 3',
        ];

        $infoBed = $infoBed->sortBy(function ($kelas) use ($urutanKelas) {
            return array_search($kelas->kelas, $urutanKelas);
        });

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar', compact(
            'infoKamar',
            'infoBed',
        ));
    }
    
    public function rawat_inap(){
        return view('pages.tech.kunjungan.dashboard-rawat-inap');
        
    }

    public function rawat_jalan(){
        return view('pages.tech.kunjungan.dashboard-rawat-jalan');
        
    }

    public function ralan_hemodialisa(Request $request){
        
        $years = DB::table('reg_periksa')
            ->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        

        $results = DB::table('hemodialisa as h')
        ->join('reg_periksa as r', 'h.no_rawat', '=', 'r.no_rawat')
        ->where('r.status_lanjut', 'Ralan')
        ->select(DB::raw('DATE(h.tanggal) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(h.tanggal)'))
        ->orderBy('tanggal')
        ->get();    
        
        $query = $results->mapWithKeys(function ($item){
            return [$item->tanggal => $item->jumlah_kunjungan];
        });

        return view('pages.tech.kunjungan.dashboard-ralan-hemodialisa',compact('years','query'));

    }

}
