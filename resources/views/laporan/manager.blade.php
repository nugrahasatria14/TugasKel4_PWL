<x-app-layout>
    <div class="mb-6 flex justify-between items-center print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-500"></i> Laporan Cabang
            </h1>
            <p class="text-sm text-gray-500 mt-1">Cabang: <span class="font-semibold text-gray-700">{{ auth()->user()->cabang->nama ?? 'Pusat' }}</span></p>
        </div>
        <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition shadow-sm flex items-center gap-2">
            <i class="fas fa-print"></i> Cetak Dokumen
        </button>
    </div>

    <!-- Filter Tanggal (Disembunyikan saat dicetak) -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-6 print:hidden">
        <form action="{{ route('laporan.manager') }}" method="GET" class="flex items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $start_date->format('Y-m-d') }}" class="border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $end_date->format('Y-m-d') }}" class="border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Bagian Kertas Cetak Laporan -->
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 print:shadow-none print:border-none print:p-0">
        
        <!-- Kop Surat Laporan -->
        <div class="text-center border-b-2 border-gray-800 pb-4 mb-6">
            <h2 class="text-2xl font-bold uppercase tracking-wider">Jayusman Bangunan</h2>
            <p class="text-gray-600">Laporan Operasional Cabang: {{ auth()->user()->cabang->nama ?? 'Pusat' }}</p>
            <p class="text-sm text-gray-500 mt-1">Periode: {{ $start_date->format('d M Y') }} - {{ $end_date->format('d M Y') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Summary Pendapatan -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <h4 class="text-sm font-bold text-blue-800 uppercase mb-1">Total Pendapatan</h4>
                <p class="text-3xl font-black text-blue-600">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</p>
                <p class="text-xs text-blue-500 mt-2">Dari {{ $transaksis->count() }} Transaksi</p>
            </div>
        </div>

        <!-- Tabel 1: Penjualan -->
        <h3 class="font-bold text-gray-800 mb-3 text-lg border-b pb-2">Rincian Transaksi Penjualan</h3>
        <table class="w-full text-sm text-left text-gray-600 mb-8">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-y border-gray-200">
                <tr>
                    <th class="px-2 py-3">Tanggal</th>
                    <th class="px-2 py-3">Kode Struk</th>
                    <th class="px-2 py-3">Kasir</th>
                    <th class="px-2 py-3 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                <tr class="border-b border-gray-100">
                    <td class="px-2 py-2">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-2 py-2 font-medium">{{ $trx->kode_transaksi }}</td>
                    <td class="px-2 py-2">{{ $trx->user->name }}</td>
                    <td class="px-2 py-2 text-right font-bold text-gray-900">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-2 py-4 text-center text-gray-400">Tidak ada transaksi di periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- Tabel 2: Stok Opname (Temuan Selisih) -->
        <h3 class="font-bold text-gray-800 mb-3 text-lg border-b pb-2">Laporan Audit Stok (Selisih Barang)</h3>
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-y border-gray-200">
                <tr>
                    <th class="px-2 py-3">Tanggal Audit</th>
                    <th class="px-2 py-3">Barang</th>
                    <th class="px-2 py-3 text-center">Selisih</th>
                    <th class="px-2 py-3">Keterangan</th>
                    <th class="px-2 py-3">Auditor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($opnames as $op)
                <tr class="border-b border-gray-100">
                    <td class="px-2 py-2">{{ $op->created_at->format('d/m/Y') }}</td>
                    <td class="px-2 py-2 font-medium">{{ $op->barang->nama }}</td>
                    <td class="px-2 py-2 text-center font-bold {{ $op->selisih < 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $op->selisih }}
                    </td>
                    <td class="px-2 py-2">{{ $op->keterangan ?? '-' }}</td>
                    <td class="px-2 py-2">{{ $op->user->name }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-2 py-4 text-center text-gray-400">Tidak ada temuan selisih stok di periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-12 text-right print:block hidden">
            <p class="mb-16">Manajer Cabang</p>
            <p class="font-bold border-b border-gray-400 inline-block w-48">{{ auth()->user()->name }}</p>
        </div>
    </div>
    
    <!-- CSS Tambahan untuk Print Layout -->
    <style>
        @media print {
            body { background-color: white !important; }
            #sidebar, header { display: none !important; }
            main { padding: 0 !important; overflow: visible !important; }
        }
    </style>
</x-app-layout>