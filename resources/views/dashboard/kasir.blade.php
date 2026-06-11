<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Dashboard Kasir</h2>
                <a href="{{ route('transaksi.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">+ Transaksi Baru</a>
            </div>
            <p class="mb-4">Cabang: <strong>{{ $cabang->nama }}</strong></p>

            <!-- Riwayat transaksi kasir hari ini -->
            <div class="bg-white rounded shadow">
                <div class="px-4 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium">Transaksi Hari Ini</h3>
                </div>
                <div class="p-6">
                    @if($transaksiSaya->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr><th class="px-4 py-2 text-left">Kode</th><th class="px-4 py-2 text-left">Total</th><th class="px-4 py-2 text-left">Jam</th><th class="px-4 py-2 text-left">Aksi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiSaya as $trx)
                                <tr>
                                    <td class="px-4 py-2">{{ $trx->kode_transaksi }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                                    <td class="px-4 py-2">{{ $trx->created_at->format('H:i:s') }}</td>
                                    <td class="px-4 py-2"><a href="{{ route('transaksi.struk', $trx) }}" target="_blank" class="text-emerald-600 hover:underline">Cetak Struk</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">Belum ada transaksi hari ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>