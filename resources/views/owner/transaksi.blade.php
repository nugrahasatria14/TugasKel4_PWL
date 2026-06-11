<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-receipt text-blue-500"></i> Pantau Semua Transaksi
        </h1>
        <p class="text-sm text-gray-500 mt-1">Data penjualan real-time dari seluruh cabang Jayusman Bangunan.</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Kode Struk</th>
                        <th class="px-4 py-3">Cabang</th>
                        <th class="px-4 py-3">Kasir</th>
                        <th class="px-4 py-3 text-right">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $trx->kode_transaksi }}</td>
                        <td class="px-4 py-3 text-blue-600 font-medium">
                            <i class="fas fa-store text-xs mr-1"></i> {{ $trx->cabang->nama ?? 'Pusat' }}
                        </td>
                        <td class="px-4 py-3">{{ $trx->user->name }}</td>
                        <td class="px-4 py-3 text-right font-bold text-gray-900">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada data transaksi dari cabang mana pun.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>