<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function create()
    {
        $cabang_id = Auth::user()->cabang_id;

        $stoks = Stok::with('barang')
                     ->where('cabang_id', $cabang_id)
                     ->where('quantity', '>', 0)
                     ->get();

        return view('kasir.create', compact('stoks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array',
            'qty' => 'required|array',
            'total_harga' => 'required|numeric'
        ]);

        $cabang_id = Auth::user()->cabang_id;

        DB::beginTransaction();

        try {
            $kode_transaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kode_transaksi,
                'user_id' => Auth::id(),
                'cabang_id' => $cabang_id,
                'total_harga' => $request->total_harga,
                'tanggal' => now(),
            ]);

            foreach ($request->barang_id as $key => $b_id) {
                $qty_beli = $request->qty[$key];

                $barang = Barang::findOrFail($b_id);

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $b_id,
                    'qty' => $qty_beli,
                    'harga_saat_transaksi' => $barang->harga,
                ]);

                $stok_cabang = Stok::where('cabang_id', $cabang_id)
                                   ->where('barang_id', $b_id)
                                   ->first();

                $stok_cabang->quantity -= $qty_beli;
                $stok_cabang->save();
            }

            DB::commit();

            return redirect()->route('transaksi.struk', $transaksi->id);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function cetakStruk($id)
    {
        $transaksi = Transaksi::with(['details.barang', 'user', 'cabang'])->findOrFail($id);

        return view('kasir.struk', compact('transaksi'));
    }

    public function cetakPDF($id)
    {
        $transaksi = Transaksi::with(['details.barang', 'user', 'cabang'])->findOrFail($id);

        $is_pdf = true;

        $pdf = Pdf::loadView('kasir.struk', compact('transaksi', 'is_pdf'));

        $pdf->setPaper([0, 0, 226.77, 500], 'portrait');

        return $pdf->download('Struk_' . $transaksi->kode_transaksi . '.pdf');
    }
}
