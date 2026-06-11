<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\MutasiStok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MutasiStokController extends Controller
{
    // 1. Menampilkan halaman mutasi stok
    public function create()
    {
        $cabang_id = Auth::user()->cabang_id;
        $barangs = Barang::all(); 
        
        // Ambil riwayat mutasi di cabang kasir/gudang yang sedang login
        $riwayat_mutasi = MutasiStok::with(['barang', 'user'])
                            ->where('cabang_id', $cabang_id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('gudang.mutasi', compact('barangs', 'riwayat_mutasi'));
    }

    // 2. Memproses data masuk/keluar
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jenis' => 'required|in:masuk,keluar',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255'
        ]);

        $cabang_id = Auth::user()->cabang_id;

        DB::beginTransaction();
        try {
            // A. Catat ke buku riwayat mutasi
            MutasiStok::create([
                'cabang_id' => $cabang_id,
                'barang_id' => $request->barang_id,
                'user_id' => Auth::id(),
                'jenis' => $request->jenis,
                'qty' => $request->qty,
                'keterangan' => $request->keterangan
            ]);

            // B. Update atau Buat data di tabel Stok utama
            $stok = Stok::where('cabang_id', $cabang_id)
                        ->where('barang_id', $request->barang_id)
                        ->first();

            if ($request->jenis == 'masuk') {
                if ($stok) {
                    $stok->quantity += $request->qty;
                    $stok->save();
                } else {
                    Stok::create([
                        'cabang_id' => $cabang_id,
                        'barang_id' => $request->barang_id,
                        'quantity' => $request->qty
                    ]);
                }
            } else { // Jika Keluar
                if (!$stok || $stok->quantity < $request->qty) {
                    throw new \Exception('Stok tidak mencukupi untuk dikeluarkan!');
                }
                $stok->quantity -= $request->qty;
                $stok->save();
            }

            DB::commit();
            return back()->with('success', 'Mutasi stok berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}