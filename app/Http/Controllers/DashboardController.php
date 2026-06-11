<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Transaksi;
use App\Models\Stok;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ← penting!

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // ← menggunakan Auth::user() bukan auth()->user()
        
        // Keamanan tambahan (sebenarnya middleware auth sudah menjamin login)
        if (!$user) {
            return redirect()->route('login');
        }
        
        $role = $user->role;

        if ($role == 'owner') {
            $cabangs = Cabang::all();
            $totalTransaksi = Transaksi::count();
            $totalPendapatan = Transaksi::sum('total_harga');
            $totalBarang = Barang::count();
            $stokMenipis = Stok::with('barang', 'cabang')
                ->where('quantity', '<', 10)
                ->get();

            return view('dashboard.owner', compact('cabangs', 'totalTransaksi', 'totalPendapatan', 'totalBarang', 'stokMenipis'));
        } 
        elseif ($role == 'manager') {
            $cabang = $user->cabang;
            $transaksiHariIni = Transaksi::where('cabang_id', $cabang->id)
                                ->whereDate('tanggal', today())
                                ->count();
            $pendapatanHariIni = Transaksi::where('cabang_id', $cabang->id)
                                ->whereDate('tanggal', today())
                                ->sum('total_harga');
            $stokMenipis = Stok::with('barang')
                            ->where('cabang_id', $cabang->id)
                            ->where('quantity', '<', 10)
                            ->get();
            $totalBarang = Stok::where('cabang_id', $cabang->id)->sum('quantity');

            return view('dashboard.manager', compact('cabang', 'transaksiHariIni', 'pendapatanHariIni', 'stokMenipis', 'totalBarang'));
        }
        elseif ($role == 'kasir') {
            $cabang = $user->cabang;
            $transaksiSaya = Transaksi::where('user_id', $user->id)
                            ->whereDate('tanggal', today())
                            ->orderBy('created_at', 'desc')
                            ->get();

            return view('dashboard.kasir', compact('cabang', 'transaksiSaya'));
        }
        elseif ($role == 'gudang') {
            $cabang = $user->cabang;
            $stoks = Stok::with('barang')->where('cabang_id', $cabang->id)->get();

            return view('dashboard.gudang', compact('cabang', 'stoks'));
        }
        elseif ($role == 'supervisor') {
            $cabang = $user->cabang;
            $transaksiHariIni = Transaksi::with('user', 'details.barang')
                                ->where('cabang_id', $cabang->id)
                                ->whereDate('tanggal', today())
                                ->get();
            $totalOmzet = $transaksiHariIni->sum('total_harga');

            return view('dashboard.supervisor', compact('cabang', 'transaksiHariIni', 'totalOmzet'));
        }

        abort(403, 'Role tidak dikenali');
    }
}