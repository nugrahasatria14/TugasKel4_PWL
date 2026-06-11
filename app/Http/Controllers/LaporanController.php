<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\StokOpname;
use App\Models\Stok;
use App\Models\Cabang; // <-- Tambahan untuk memanggil model Cabang
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // 1. Halaman Cetak Laporan Manajer
    public function index(Request $request)
    {
        $cabang_id = Auth::user()->cabang_id;
        
        $start_date = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::today();
        $end_date = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::today();

        $transaksis = Transaksi::with(['user'])
                        ->where('cabang_id', $cabang_id)
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        $total_pendapatan = $transaksis->sum('total_harga');

        $opnames = StokOpname::with(['barang', 'user'])
                        ->where('cabang_id', $cabang_id)
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('laporan.manager', compact('transaksis', 'total_pendapatan', 'opnames', 'start_date', 'end_date'));
    }

    // 2. Halaman Pantau Stok Toko
    public function stokToko()
    {
        $cabang_id = Auth::user()->cabang_id;
        
        // Ambil data stok di cabang Manajer ini
        $stoks = Stok::with('barang')
                     ->where('cabang_id', $cabang_id)
                     ->get();

        return view('laporan.stok', compact('stoks'));
    }

   
}