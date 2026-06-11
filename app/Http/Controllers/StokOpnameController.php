<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\StokOpname;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokOpnameController extends Controller
{
    // Menampilkan halaman stok opname
    public function index()
    {
        $cabang_id = Auth::user()->cabang_id;
        
        // Ambil data stok saat ini di cabang tersebut
        $stoks = Stok::with('barang')
                     ->where('cabang_id', $cabang_id)
                     ->get();

        // Ambil riwayat audit opname yang pernah dilakukan
        $riwayat = StokOpname::with(['barang', 'user'])
                             ->where('cabang_id', $cabang_id)
                             ->orderBy('created_at', 'desc')
                             ->get();

        return view('gudang.opname', compact('stoks', 'riwayat'));
    }

    // Memproses data hasil hitung fisik
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array',
            'stok_sistem' => 'required|array',
            'stok_fisik' => 'required|array',
            'keterangan' => 'array'
        ]);

        $cabang_id = Auth::user()->cabang_id;
        $user_id = Auth::id();

        DB::beginTransaction();
        try {
            // Looping semua barang yang di-input
            foreach ($request->barang_id as $key => $b_id) {
                $sistem = $request->stok_sistem[$key];
                $fisik = $request->stok_fisik[$key];
                $ket = $request->keterangan[$key] ?? null;

                // Hitung selisihnya
                $selisih = $fisik - $sistem;

                // JIKA ADA SELISIH (Tidak sama dengan nol), catat sebagai temuan audit!
                if ($selisih != 0) {
                    StokOpname::create([
                        'cabang_id' => $cabang_id,
                        'barang_id' => $b_id,
                        'user_id' => $user_id,
                        'stok_sistem' => $sistem,
                        'stok_fisik' => $fisik,
                        'selisih' => $selisih,
                        'keterangan' => $ket
                    ]);

                    // Update data stok utama menjadi sesuai dengan fisik di lapangan
                    $stok_utama = Stok::where('cabang_id', $cabang_id)->where('barang_id', $b_id)->first();
                    $stok_utama->quantity = $fisik;
                    $stok_utama->save();
                }
            }

            DB::commit();
            return back()->with('success', 'Proses Stok Opname selesai! Selisih telah dicatat dan stok berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}