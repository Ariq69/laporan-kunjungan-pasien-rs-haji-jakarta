<?php

namespace App\Http\Controllers\tech;
use App\Models\inventarisBarang;
use App\Models\InventarisProdusen;
use App\Models\InventarisMerk;
use App\Models\InventarisKategori;
use App\Models\InventarisJenis;

use Illuminate\Http\Request;
use App\Models\inventaris;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;



class JumlahInventarisController extends Controller
{
    public function jumlah_inventaris(){
        return view('pages.tech.jumlahinventaris.dashboard-jumlah-investaris');
    }
   
    public function jumlah_inventaris_barang_di_ruang(Request $request)
    {
        // Fetch the list of inventaris_ruang, assuming you want to use it in the view
        $years = DB::table('inventaris')
            ->select(DB::raw('YEAR(tgl_pengadaan) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
    
        // Get the selected inventaris_ruang from the request
        $year = $request->input('year');
        $month = $request->input('month');
    
        $data = DB::table('inventaris as i')
            ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
            ->join('inventaris_ruang as ir', 'i.id_ruang', '=', 'ir.id_ruang')
            ->select(
                'ib.nama_barang',
                'ir.nama_ruang',
                DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris')
            )
            ->whereYear('i.tgl_pengadaan', '=', $year)
            ->whereMonth('i.tgl_pengadaan', '=', $month)
            ->groupBy(
                'ib.nama_barang',
                'ir.nama_ruang'
            )
            ->limit(10)
            ->get();
    
        // Transform the result into a format suitable for the view
        $query = $data->groupBy('nama_ruang')
            ->map(function ($group) {
                return $group->sum('jumlah_inventaris');
            });
    
        // Pass the data to the view
        return view('pages.tech.jumlahinventaris.dashboard-jumlah-inventaris-barang-di-ruang', compact(
            'query',
            'years'
        ));
    }
    

public function jumlah_inventaris_barang_per_kategori(Request $request)
{
    // Fetch the list of inventaris_ruang, assuming you want to use it in the view
    $years = DB::table('inventaris')
        ->select(DB::raw('YEAR(tgl_pengadaan) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();

    // Get the selected inventaris_ruang from the request
    $year = $request->input('year');
    $month = $request->input('month');

    $data = DB::table('inventaris as i')
        ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
        ->join('inventaris_kategori as ik', 'ib.id_kategori', '=', 'ik.id_kategori')
        ->select(
            'ik.nama_kategori',
            // 'i.tgl_pengadaan',
            DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris')
        )
        ->whereYear('i.tgl_pengadaan', '=', $year)
        ->whereMonth('i.tgl_pengadaan', '=', $month)
        ->groupBy(
            'ik.nama_kategori',
            // 'i.tgl_pengadaan'
        )
        ->limit(10)
        ->get();

    // Transform the result into a format suitable for the view
    $query = $data->groupBy('nama_kategori')
        ->map(function ($group) {
            return $group->sum('jumlah_inventaris');
        });

    // Pass the data to the view
    return view('pages.tech.jumlahinventaris.dashboard-jumlah-inventaris-barang-per-kategori', compact(
        'query',
        'years'
    ));
}

    public function jumlah_inventaris_barang_per_merk(Request $request)
    {
    // Fetch the list of inventaris_ruang, assuming you want to use it in the view
    $years = DB::table('inventaris')
    ->select(DB::raw('YEAR(tgl_pengadaan) as year'))
    ->groupBy('year')
    ->orderBy('year', 'DESC')
    ->get();

    // Get the selected inventaris_ruang from the 
    $year = $request->input('year');
    $month = $request->input('month');
    
    $data= DB::table('inventaris as i')
     ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
    ->join('inventaris_merk as im', 'ib.id_merk', '=', 'im.id_merk')
    ->select(
        'ib.nama_barang',
        'im.nama_merk',
        DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris'))
    ->whereYear('i.tgl_pengadaan', '=',$year)
    ->whereMonth('i.tgl_pengadaan', '=', $month)

    ->groupBy(
        'ib.nama_barang', 
        'im.nama_merk', 
        )
    ->limit(10)
    ->get();


    
    // Transform the result into a format suitable for the view
    $query = $data->mapWithKeys(function ($item) {
        return ["{$item->nama_merk}" => $item->jumlah_inventaris];
    });

    // Pass the data to the view
    return view('pages.tech.jumlahinventaris.dashboard-jumlah-inventaris-barang-per-merk', compact(
        'query',
        'years',
    ));
    }

          
        public function jumlah_inventaris_barang_per_jenis(Request $request)
    {
    
    // Fetch the list of inventaris_ruang, assuming you want to use it in the view
    $years = DB::table('inventaris')
    ->select(DB::raw('YEAR(tgl_pengadaan) as year'))
    ->groupBy('year')
    ->orderBy('year', 'DESC')
    ->get();

    // $inventaris_barang = DB::table('inventaris_barang')
    // ->select('kode_barang', 'nama_barang')
    // // ->where('nama_barang', '!=', 'tes')
    // ->get();

    // $inventaris_produsen = DB::table('inventaris_produsen')
    //     ->select('kode_produsen', 'nama_produsen')
    //     ->get();

    // $inventaris_merk = DB::table('inventaris_merk')
    //     ->select('id_merk', 'nama_merk')
    //     // ->where('nama_merk', '!=', 'Merk')
    //     ->get();

    // $inventaris_kategori = DB::table('inventaris_kategori')
    //     ->select('id_kategori', 'nama_kategori')
    //     ->get();

    // $inventaris_jenis = DB::table('inventaris_jenis')
    //     ->select('id_jenis', 'nama_jenis')
    //     // ->where('nama_jenis', '!=', 'jenis')
    //     ->get();

    // Get the selected inventaris_ruang from the 
    $year = $request->input('year');
    $month = $request->input('month');
    // $produsen = $request->input('inventaris_produsen');
    // $barang = $request->input('inventaris_barang');
    // $merk = $request->input('inventaris_merk');
    // $kategori = $request->input('inventaris_kategori');
    // $jenis = $request->input('inventaris_jenis');

    $data= DB::table('inventaris as i')
     ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
    // ->join('inventaris_produsen as ip', 'ib.kode_produsen', '=', 'ip.kode_produsen')
    //->join('inventaris_merk as im', 'ib.id_merk', '=', 'im.id_merk')
    // ->join('inventaris_kategori as ik', 'ib.id_kategori', '=', 'ik.id_kategori')
     ->join('inventaris_jenis as ij', 'ib.id_jenis', '=', 'ij.id_jenis')
    ->select(
        // 'ib.nama_barang', 
        // 'ip.nama_produsen', 
        //'im.nama_merk', 
        // 'ik.nama_kategori', 
        'ij.nama_jenis', 
        'i.tgl_pengadaan', 
        DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris'))
    ->whereYear('i.tgl_pengadaan', '=',$year)
    ->whereMonth('i.tgl_pengadaan', '=', $month)
    // ->where('ib.nama_barang', $barang)
    // ->where('ip.nama_produsen', $produsen)
    // ->where('im.nama_merk', $merk)
    // ->where('ik.nama_kategori', $kategori)
    // ->where('ij.nama_jenis', $jenis)
    ->groupBy(
       'ib.nama_barang', 
        // 'ip.nama_produsen', 
        //'im.nama_merk', 
        //'ik.nama_kategori', 
         'ij.nama_jenis', 
        'i.tgl_pengadaan')
    ->limit(10)
    ->get();


    // $data = DB::table('inventaris_barang as ib')
    //     ->join('inventaris_produsen as ip', 'ib.kode_produsen', '=', 'ip.kode_produsen')
    //     ->join('inventaris_merk as im', 'ib.id_merk', '=', 'im.id_merk')
    //     ->join('inventaris_kategori as ik', 'ib.id_kategori', '=', 'ik.id_kategori')
    //     ->join('inventaris_jenis as ij', 'ib.id_jenis', '=', 'ij.id_jenis')
    //     ->select(
    //         'ib.nama_barang',
    //         'ib.thn_produksi',
    //         'im.nama_merk',
    //         'ik.nama_kategori',
    //         'ij.nama_jenis',
    //         'ip.nama_produsen',
    //         DB::raw('ib.jml_barang as jml_barang')
    //     )
        // ->where('ib.nama_barang', $barang)
        // // ->where('ip.nama_produsen', $produsen)
        // // ->where('im.nama_merk', $merk)
        // ->where('ik.nama_kategori', $kategori)
        // // ->where('ij.nama_jenis', $jenis)
    //     ->where('ib.nama_barang', '!=', 'tes')
    //     ->groupBy(
    //         'ip.kode_produsen',
    //         'ib.nama_barang',
    //         'ib.jml_barang',
    //         'ib.thn_produksi',
    //         'im.nama_merk',
    //         'ik.nama_kategori',
    //         'ij.nama_jenis',
    //         'ip.nama_produsen'
    //     )
    //     ->orderBy('ib.thn_produksi')
    //     ->orderBy('ib.nama_barang')
    //     ->orderBy('ip.nama_produsen')
    //     ->orderBy('im.nama_merk')
    //     ->orderBy('ik.nama_kategori')
    //     ->orderBy('ij.nama_jenis')
    //     ->get();

    // Transform the result into a format suitable for the view
    $query = $data->mapWithKeys(function ($item) {
        return ["{$item->nama_jenis}" => $item->jumlah_inventaris];
    });

    // Pass the data to the view
    return view('pages.tech.jumlahinventaris.dashboard-jumlah-inventaris-barang-per-jenis', compact(
        'query',
        'years',
        // 'inventaris_barang',
        // 'inventaris_produsen',
        // 'inventaris_merk',
        // 'inventaris_kategori',
        // 'inventaris_jenis',
    ));
    }
    
    public function jumlah_inventaris_barang_per_produsen(Request $request)
    {
        
    // Fetch the list of inventaris_ruang, assuming you want to use it in the view
    $years = DB::table('inventaris')
    ->select(DB::raw('YEAR(tgl_pengadaan) as year'))
    ->groupBy('year')
    ->orderBy('year', 'DESC')
    ->get();

    
    // Get the selected inventaris_ruang from the 
    $year = $request->input('year');
    $month = $request->input('month');
    

    $data= DB::table('inventaris as i')
    ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
    ->join('inventaris_produsen as ip', 'ib.kode_produsen', '=', 'ip.kode_produsen')
    ->select(
        'ib.nama_barang', 
        'ip.nama_produsen', 
        'i.tgl_pengadaan', 
        DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris'))
    ->whereYear('i.tgl_pengadaan', '=',$year)
    ->whereMonth('i.tgl_pengadaan', '=', $month)
    ->groupBy(
        'ib.nama_barang', 
        'ip.nama_produsen', 
        'i.tgl_pengadaan')
    ->limit(10)
    ->get();

    // Transform the result into a format suitable for the view
    $query = $data->mapWithKeys(function ($item) {
        return ["{$item->nama_produsen}" => $item->jumlah_inventaris];
    });

    // Pass the data to the view
    return view('pages.tech.jumlahinventaris.dashboard-jumlah-inventaris-barang-per-produsen', compact(
        'query',
        'years',
        
    ));
   
    }
    
}

