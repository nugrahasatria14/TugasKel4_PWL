<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\StokOpname;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OwnerController extends Controller
{
    public function cabang()
    {
        $cabangs = Cabang::all();

        return view('owner.cabang', compact('cabangs'));
    }

    public function createCabang()
    {
        return view('owner.cabang_form');
    }

    public function storeCabang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        Cabang::create([
            'nama' => $request->nama,
            'kota' => $request->kota,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('owner.cabang')->with('success', 'Cabang baru berhasil ditambahkan!');
    }

    public function editCabang(Cabang $cabang)
    {
        return view('owner.cabang_form', compact('cabang'));
    }

    public function updateCabang(Request $request, Cabang $cabang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        $cabang->update([
            'nama' => $request->nama,
            'kota' => $request->kota,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('owner.cabang')->with('success', 'Data cabang berhasil diperbarui!');
    }

    public function destroyCabang(Cabang $cabang)
    {
        $cabang->delete();

        return redirect()->route('owner.cabang')->with('success', 'Cabang berhasil dihapus!');
    }

    public function stok(Request $request)
    {
        $search = $request->search;

        $stoks = Stok::with(['barang', 'cabang'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->get()
            ->sortBy(function ($stok) {
                return $stok->barang->nama . '-' . $stok->cabang_id;
            });

        return view('owner.stok', compact('stoks'));
    }

    public function transaksi(Request $request)
    {
        $query = Transaksi::with(['user', 'cabang']);

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $transaksis = $query->orderBy('created_at', 'desc')->get();

        return view('owner.transaksi', compact('transaksis'));
    }

    public function laporan(Request $request)
    {
        $start_date = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::today();

        $end_date = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::today();

        $transaksis = Transaksi::with(['cabang', 'user'])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        $total_pendapatan = $transaksis->sum('total_harga');

        $opnames = StokOpname::with(['barang', 'cabang', 'user'])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        return view('owner.laporan', compact(
            'transaksis',
            'total_pendapatan',
            'opnames',
            'start_date',
            'end_date'
        ));
    }

    public function cetakPDF(Request $request)
    {
        $start_date = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::today();

        $end_date = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::today();

        $transaksis = Transaksi::with(['cabang', 'user'])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        $total_pendapatan = $transaksis->sum('total_harga');

        $opnames = StokOpname::with(['barang', 'cabang', 'user'])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        $pdf = Pdf::loadView('owner.laporan_pdf', compact(
            'transaksis',
            'total_pendapatan',
            'opnames',
            'start_date',
            'end_date'
        ));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Jayusman_Bangunan.pdf');
    }
}