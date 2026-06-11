<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-chart-pie text-blue-500"></i> Laporan Gabungan Seluruh Cabang
        </h1>
        <p class="text-sm text-gray-500 mt-1">Ringkasan finansial dan audit stok dari semua cabang.</p>
    </div>

    <!-- Filter Tanggal & Tombol Aksi -->
    <form action="{{ route('owner.laporan') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $start_date->format('Y-m-d') }}" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $end_date->format('Y-m-d') }}" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="flex items-center gap-2">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-medium text-sm transition shadow-sm">
                Tampilkan
            </button>
            
            <!-- TOMBOL CETAK PDF -->
            <a href="{{ route('owner.laporan.pdf', ['start_date' => request('start_date', $start_date->format('Y-m-d')), 'end_date' => request('end_date', $end_date->format('Y-m-d'))]) }}" 
               class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-medium text-sm flex items-center gap-2 transition shadow-sm">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
        </div>
    </form>

    <!-- Kartu Pendapatan Total -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-indigo-600 p-6 rounded-xl text-white shadow-lg">
            <p class="text-indigo-100 text-sm">Total Pendapatan Seluruh Cabang</p>
            <h2 class="text-3xl font-bold mt-1">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
        </div>
    </div>

    <!-- Tabel Transaksi Gabungan -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="font-bold text-gray-900 mb-4">Rekap Transaksi</h3>
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs bg-gray-50 uppercase border-b">
                <tr>
                    <th class="px-4 py-3">Cabang</th>
                    <th class="px-4 py-3">Kasir</th>
                    <th class="px-4 py-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $trx->cabang->nama ?? 'Pusat' }}</td>
                    <td class="px-4 py-3">{{ $trx->user->name }}</td>
                    <td class="px-4 py-3 text-right font-medium text-gray-900">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-6 text-center text-gray-400">Tidak ada transaksi pada rentang tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tabel Opname Gabungan -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-900 mb-4">Rekap Stok Opname (Audit)</h3>
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs bg-gray-50 uppercase border-b">
                <tr>
                    <th class="px-4 py-3">Cabang</th>
                    <th class="px-4 py-3">Barang</th>
                    <th class="px-4 py-3">Status Audit</th>
                    <th class="px-4 py-3">Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($opnames as $op)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $op->cabang->nama ?? 'Pusat' }}</td>
                    <td class="px-4 py-3">{{ $op->barang->nama }}</td>
                    <td class="px-4 py-3">
                        @if($op->keterangan == 'Normal' || $op->keterangan == null)
                            <span class="text-green-600 font-medium">Normal</span>
                        @else
                            <span class="text-red-600 font-medium">{{ $op->keterangan }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $op->user->name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">Tidak ada riwayat opname pada rentang tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>