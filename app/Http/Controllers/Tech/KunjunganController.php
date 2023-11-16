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
            ->limit(11) // Mengambil hanya 11 penyakit dengan jumlah pasien terbanyak
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

    public function ralan_igd(Request $request){

        $years = DB::table('reg_periksa')
            ->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $results = DB::table('reg_periksa as r')
        ->join('poliklinik as p', 'r.kd_poli', '=', 'p.kd_poli')
        ->where('r.status_lanjut', 'Ralan')
        ->where('p.nm_poli', 'Instalasi Gawat Darurat')
        ->whereYear('tgl_registrasi', $year)
        ->whereMonth('tgl_registrasi', $month)
        ->select(DB::raw('DATE(r.tgl_registrasi) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(r.tgl_registrasi)'))
        ->get();

        $query = $results->mapWithKeys(function ($item){
            return [$item->tanggal => $item->jumlah_kunjungan];
        });
        
        return view('pages.tech.kunjungan.dashboard-ralan-igd',compact('years','query'));
        
    }

    public function ralan_ugd(Request $request){

        $years = DB::table('reg_periksa')
            ->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $results = DB::table('reg_periksa as r')
        ->join('poliklinik as p', 'r.kd_poli', '=', 'p.kd_poli')
        ->where('r.status_lanjut', 'Ralan')
        ->where('p.nm_poli', 'Unit IGD')
        ->whereYear('tgl_registrasi', $year)
        ->whereMonth('tgl_registrasi', $month)
        ->select(DB::raw('DATE(r.tgl_registrasi) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(r.tgl_registrasi)'))
        ->get();

        $query = $results->mapWithKeys(function ($item){
            return [$item->tanggal => $item->jumlah_kunjungan];
        });
        
        return view('pages.tech.kunjungan.dashboard-ralan-ugd',compact('years','query'));
        
    }
    
    public function ralan_hemodialisa(Request $request){
        
        $years = DB::table('hemodialisa')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        

        $results = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->where('periksa.status_lanjut', 'Ralan')
        ->whereYear('tanggal', $year)
        ->whereMonth('tanggal', $month)
        ->select(DB::raw('DATE(hemo.tanggal) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(tanggal)'))
        ->get();
        //dd($results);  
        
        $query = $results->mapWithKeys(function ($item){
            return [$item->tanggal => $item->jumlah_kunjungan];
        });

        return view('pages.tech.kunjungan.dashboard-ralan-hemodialisa',compact('years','query'));

    }
    
    public function ralan_lab(Request $request) {
        $years = DB::table('permintaan_lab')
            ->select(DB::raw('YEAR(tgl_permintaan) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
        $labType = $request->input('lab_type'); // Get the selected lab type from the form
        
        $permintaan = DB::table('permintaan_lab')
            ->select(DB::raw('DATE(tgl_permintaan) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
            ->whereYear('tgl_permintaan', $year)
            ->whereMonth('tgl_permintaan', $month)
            ->where('status', 'ralan')
            ->groupBy(DB::raw('CAST(tgl_permintaan AS DATE)'))
            ->orderBy('tanggal')
            ->get();
        
        $pemeriksaan = DB::table('periksa_lab')
            ->select(DB::raw('DATE(tgl_periksa) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
            ->whereYear('tgl_periksa', $year)
            ->whereMonth('tgl_periksa', $month)
            ->where('status', 'ralan')
            ->groupBy(DB::raw('CAST(tgl_periksa AS DATE)'))
            ->orderBy('tanggal')
            ->get();

        $query = [];
    
        if ($labType === 'permintaan') {
            $query = $permintaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        } elseif ($labType === 'pemeriksaan') {
            $query = $pemeriksaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        }
        //dd($query);
        return view('pages.tech.kunjungan.dashboard-ralan-lab', compact('years', 'query'));
    }
    
    public function ranap_lab(Request $request) {
        $years = DB::table('permintaan_lab')
            ->select(DB::raw('YEAR(tgl_permintaan) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
        $labType = $request->input('lab_type'); // Get the selected lab type from the form
        
        $permintaan = DB::table('permintaan_lab')
            ->select(DB::raw('DATE(tgl_permintaan) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
            ->whereYear('tgl_permintaan', $year)
            ->whereMonth('tgl_permintaan', $month)
            ->where('status', 'ranap')
            ->groupBy(DB::raw('CAST(tgl_permintaan AS DATE)'))
            ->orderBy('tanggal')
            ->get();
        
        $pemeriksaan = DB::table('periksa_lab')
            ->select(DB::raw('DATE(tgl_periksa) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
            ->whereYear('tgl_periksa', $year)
            ->whereMonth('tgl_periksa', $month)
            ->where('status', 'ranap')
            ->groupBy(DB::raw('CAST(tgl_periksa AS DATE)'))
            ->orderBy('tanggal')
            ->get();

        $query = [];
    
        if ($labType === 'permintaan') {
            $query = $permintaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        } elseif ($labType === 'pemeriksaan') {
            $query = $pemeriksaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        }
        //dd($query);
        return view('pages.tech.kunjungan.dashboard-ranap-lab', compact('years', 'query'));
    }
     
    public function ranap_hemodialisa(Request $request){
        
        $years = DB::table('hemodialisa')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        

        $results = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->where('periksa.status_lanjut', 'Ralan')
        ->whereYear('tanggal', $year)
        ->whereMonth('tanggal', $month)
        ->select(DB::raw('DATE(hemo.tanggal) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(tanggal)'))
        ->get();
        //dd($results);  
        
        $query = $results->mapWithKeys(function ($item){
            return [$item->tanggal => $item->jumlah_kunjungan];
        });

        return view('pages.tech.kunjungan.dashboard-ranap-hemodialisa',compact('years','query'));

    }

    public function ranap_igd(Request $request){
        
        $years = DB::table('reg_periksa')
            ->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $results = DB::table('reg_periksa as r')
        ->join('poliklinik as p', 'r.kd_poli', '=', 'p.kd_poli')
        ->where('r.status_lanjut', 'Ranap')
        ->where('p.nm_poli', 'Instalasi Gawat Darurat')
        ->whereYear('tgl_registrasi', $year)
        ->whereMonth('tgl_registrasi', $month)
        ->select(DB::raw('DATE(r.tgl_registrasi) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(r.tgl_registrasi)'))
        ->get();

        $query = $results->mapWithKeys(function ($item){
            return [$item->tanggal => $item->jumlah_kunjungan];
        });

        return view('pages.tech.kunjungan.dashboard-ranap-igd',compact('years','query'));
    }
    
    public function ranap_ugd(Request $request){
        
        $years = DB::table('reg_periksa')
            ->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $results = DB::table('reg_periksa as r')
        ->join('poliklinik as p', 'r.kd_poli', '=', 'p.kd_poli')
        ->where('r.status_lanjut', 'Ranap')
        ->where('p.nm_poli', 'Unit IGD')
        ->whereYear('tgl_registrasi', $year)
        ->whereMonth('tgl_registrasi', $month)
        ->select(DB::raw('DATE(r.tgl_registrasi) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(r.tgl_registrasi)'))
        ->get();

        $query = $results->mapWithKeys(function ($item){
            return [$item->tanggal => $item->jumlah_kunjungan];
        });

        return view('pages.tech.kunjungan.dashboard-ranap-ugd',compact('years','query'));
    }

    
    public function ranap_rad(Request $request) {
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
        // ->where('jpr.nm_perawatan', 'THORAX AP/PA') 
        ->whereYear('pr.tgl_periksa', '=',$year)
        ->whereMonth('pr.tgl_periksa', '=', $month)
        ->where('jpr.nm_perawatan', $rad) 
        ->where('pr.status', 'ranap')
        ->groupBy('pr.tgl_periksa', 'jpr.nm_perawatan')
        ->orderBy('pr.tgl_periksa')
        ->orderBy('jpr.nm_perawatan')
        ->get();
        // dd($bar);

        $query = $bar->mapWithKeys(function ($item) {
            return [$item->tgl_periksa => $item-> jumlah_no_perawat];
        });

        return view('pages.tech.kunjungan.dashboard-ranap-rad', compact(
            'query',
            'years',
            'jns_perawatan_radiologi'
        ));
    }




    
    public function obat(Request $request){

        $years = DB::table('penjualan')
            ->select(DB::raw('YEAR(tgl_jual) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $topBarang = DB::table('detailjual as dj')
            ->join('penjualan as rp', 'dj.nota_jual', '=', 'rp.nota_jual')
            ->join('databarang as db', 'dj.kode_brng', '=', 'db.kode_brng')
            ->select('db.nama_brng as nama_barang', 'dj.jumlah')
            ->whereYear('rp.tgl_jual', $year)
            ->whereMonth('rp.tgl_jual', $month)
            ->orderByDesc('dj.jumlah')
            ->limit(10)
            ->get();

        $query = $topBarang->mapWithKeys(function ($item) {
            return [$item->nama_barang => $item->jumlah];
        });
 
        return view('pages.tech.kunjungan.dashboard-obat', compact('years','query'));
        
    }
}