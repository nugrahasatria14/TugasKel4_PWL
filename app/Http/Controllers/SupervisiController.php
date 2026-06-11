<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class SupervisiController extends Controller
{
    public function index()
    {
        // Ambil ID Cabang dari Supervisor yang sedang login
        $cabang_id = Auth::user()->cabang_id;

        // Ambil semua transaksi di cabang tersebut, urutkan dari yang terbaru
        // Kita gunakan 'with' untuk memuat data Kasir (user) dan Detail Barang sekaligus
        $transaksis = Transaksi::with(['user', 'details.barang'])
                        ->where('cabang_id', $cabang_id)
                        // Jika ingin hanya melihat hari ini, bisa pakai: ->whereDate('created_at', today())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('supervisi.transaksi', compact('transaksis'));
    }
}