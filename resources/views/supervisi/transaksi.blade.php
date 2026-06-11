<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-eye text-blue-500"></i> Pantau Transaksi Kasir (Live)
        </h1>
        <p class="text-sm text-gray-500 mt-1">Cabang: <span class="font-semibold text-gray-700">{{ auth()->user()->cabang->nama ?? 'Pusat' }}</span></p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Daftar Transaksi Terbaru</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3">Waktu Transaksi</th>
                        <th class="px-4 py-3">Kode Struk</th>
                        <th class="px-4 py-3">Kasir</th>
                        <th class="px-4 py-3">Detail Barang Dibeli</th>
                        <th class="px-4 py-3 text-right">Total Pembayaran</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 font-medium text-blue-600">{{ $trx->kode_transaksi }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $trx->user->name }}</td>
                        <td class="px-4 py-3">
                            <ul class="list-disc list-inside text-xs">
                                @foreach($trx->details as $detail)
                                    <li>{{ $detail->barang->nama }} (x{{ $detail->qty }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-gray-900">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('transaksi.struk', $trx->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded text-xs font-semibold transition">
                                <i class="fas fa-print"></i> Struk
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            <i class="fas fa-receipt text-3xl mb-2 block"></i>
                            Belum ada transaksi di cabang ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>