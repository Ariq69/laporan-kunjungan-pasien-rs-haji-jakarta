<?php

namespace App\Http\Controllers\tech;
use App\Models\inventarisBarang;
use App\Models\InventarisProdusen;
use App\Models\InventarisMerk;
use App\Models\InventarisKategori;
use App\Models\InventarisJenis;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class InventarisController extends Controller
{
    public function pengajuan_aset_inventaris(Request $request){
        $years = DB::table('pengajuan_inventaris')
        ->select(DB::raw('YEAR(tanggal) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        $aset = $request->input('aset'); 

        $query = [];

        if ($year && $month) {
            $perurgensi = DB::table('pengajuan_inventaris')
                ->select('urgensi', DB::raw('COUNT(no_pengajuan) as jumlah'), 'tanggal')
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->groupBy('urgensi', 'tanggal')
                ->get();
        
            $perstatus = DB::table('pengajuan_inventaris')
                ->select('status as nama_status', DB::raw('COUNT(no_pengajuan) as jumlah'), 'tanggal')
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->groupBy('nama_status', 'tanggal')
                ->get();
        
            $perdepartemen = DB::table('pengajuan_inventaris as p')
                ->join('pegawai as pg', 'p.nik', '=', 'pg.nik')
                ->join('departemen as d', 'pg.departemen', '=', 'd.dep_id')
                ->select('d.nama as nama_departemen', DB::raw('COUNT(*) as jumlah'), 'p.tanggal')
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->groupBy('d.nama', 'p.tanggal')
                ->get();
        
            if ($aset === 'perurgensi') {
                $query = $perurgensi->mapWithKeys(function ($item) {
                    return [$item->urgensi => $item->jumlah];
                });
            } elseif ($aset === 'perstatus') {
                $query = $perstatus->mapWithKeys(function ($item) {
                    return [$item->nama_status => $item->jumlah];
                });
            } elseif ($aset === 'perdepartemen') {
                $query = $perdepartemen->mapWithKeys(function ($item) {
                    return [$item->nama_departemen => $item->jumlah];
                });
            }
        }

        return view('pages.tech.inventaris.dashboard-pengajuan-aset-inventaris', compact('years','query'));
    }

    public function perbaikan_inventaris(Request $request){
        $years = DB::table('perbaikan_inventaris')
        ->select(DB::raw('YEAR(tanggal) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        $perbaikan = $request->input('perbaikan');

        $query = [];

        if ($year && $month) {
            $pelaksana = DB::table('perbaikan_inventaris')
                ->select('pelaksana', DB::raw('COUNT(*) AS jumlah'))
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->groupBy('pelaksana')
                ->get();

             $status = DB::table('perbaikan_inventaris')
                ->select('status', DB::raw('COUNT(*) AS jumlah'))
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->groupBy('status')
                ->get();    
        
        
            if ($perbaikan === 'pelaksana') {
                $query = $pelaksana->mapWithKeys(function ($item) {
                    return [$item->pelaksana => $item->jumlah];
                });

            } elseif ($perbaikan === 'status') {
                $query = $status->mapWithKeys(function ($item) {
                    return [$item->status => $item->jumlah];
                });
            }
        }
    
        return view('pages.tech.inventaris.dashboard-perbaikan-inventaris', compact('years','query'));
    }

    public function jumlah_aset_inventaris(Request $request){
        $years = DB::table('pengajuan_inventaris')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
        $aset = $request->input('aset'); 
    
        $query = [];
    
        if ($year && $month) {
            $peruang = DB::table('inventaris as i')
                ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
                ->join('inventaris_ruang as ir', 'i.id_ruang', '=', 'ir.id_ruang')
                ->select(
                    'ir.nama_ruang',
                    DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris')
                )
                ->whereYear('i.tgl_pengadaan', '=', $year)
                ->whereMonth('i.tgl_pengadaan', '=', $month)
                ->groupBy('ir.nama_ruang')
                ->orderby('ir.nama_ruang')
                ->limit(10)
                ->get();
    
            $perkategori = DB::table('inventaris as i')
                ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
                ->join('inventaris_kategori as ik', 'ib.id_kategori', '=', 'ik.id_kategori')
                ->select(
                    'ik.nama_kategori',
                    DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris')
                )
                ->whereYear('i.tgl_pengadaan', '=', $year)
                ->whereMonth('i.tgl_pengadaan', '=', $month)
                ->groupBy('ik.nama_kategori')
                ->orderby('ik.nama_kategori')
                ->limit(10)
                ->get();
    
            $permerk = DB::table('inventaris as i')
                ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
                ->join('inventaris_merk as im', 'ib.id_merk', '=', 'im.id_merk')
                ->select(
                    'im.nama_merk',
                    DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris')
                )
                ->whereYear('i.tgl_pengadaan', '=', $year)
                ->whereMonth('i.tgl_pengadaan', '=', $month)
                ->groupBy('im.nama_merk')
                ->orderBy('im.nama_merk')
                ->limit(10)
                ->get();
    
            $perjenis = DB::table('inventaris as i')
                ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
                ->join('inventaris_jenis as ij', 'ib.id_jenis', '=', 'ij.id_jenis')
                ->select(
                    'ij.nama_jenis',
                    DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris')
                )
                ->whereYear('i.tgl_pengadaan', '=', $year)
                ->whereMonth('i.tgl_pengadaan', '=', $month)
                ->groupBy('ij.nama_jenis')
                ->orderBy('ij.nama_jenis')
                ->limit(10)
                ->get();
    
            $perprodusen = DB::table('inventaris as i')
                ->join('inventaris_barang as ib', 'i.kode_barang', '=', 'ib.kode_barang')
                ->join('inventaris_produsen as ip', 'ib.kode_produsen', '=', 'ip.kode_produsen')
                ->select(
                    'ip.nama_produsen',
                    DB::raw('COUNT(i.no_inventaris) as jumlah_inventaris')
                )
                ->whereYear('i.tgl_pengadaan', '=', $year)
                ->whereMonth('i.tgl_pengadaan', '=', $month)
                ->groupBy('ip.nama_produsen')
                ->orderBy('ip.nama_produsen')
                ->limit(10)
                ->get();
    
            if ($aset === 'peruang') {
                $query = $peruang->pluck('jumlah_inventaris', 'nama_ruang');
            } elseif ($aset === 'perkategori') {
                $query = $perkategori->pluck('jumlah_inventaris', 'nama_kategori');
            } elseif ($aset === 'permerk') {
                $query = $permerk->pluck('jumlah_inventaris', 'nama_merk');
            } elseif ($aset === 'perjenis') {
                $query = $perjenis->pluck('jumlah_inventaris', 'nama_jenis');
            } elseif ($aset === 'perprodusen') {
                $query = $perprodusen->pluck('jumlah_inventaris', 'nama_produsen');
            }
        }
    
        return view('pages.tech.inventaris.dashboard-jumlah-aset-inventaris', compact('years','query'));
    }
    
}

