<?php

namespace App\Http\Controllers\tech;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KeslingPemakaianAirPdam;

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

}

