<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Dashboard Supervisor</h2>
            <p>Cabang: <strong>{{ $cabang->nama }}</strong></p>
            <div class="grid grid-cols-2 gap-4 my-4">
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Total Transaksi Hari Ini</div>
                    <div class="text-2xl font-bold">{{ $transaksiHariIni->count() }}</div>
                </div>
                <div class="bg-white p-4 rounded shadow text-center">
                    <div class="text-sm text-gray-500">Omzet Hari Ini</div>
                    <div class="text-2xl font-bold">Rp {{ number_format($totalOmzet,0,',','.') }}</div>
                </div>
            </div>
            <div class="bg-white rounded shadow">
                <div class="px-4 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium">Daftar Transaksi Hari Ini</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr><th>Kode</th><th>Kasir</th><th>Total</th><th>Waktu</th><th>Detail</th></tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiHariIni as $trx)
                            <tr>
                                <td class="px-4 py-2">{{ $trx->kode_transaksi }}</td>
                                <td class="px-4 py-2">{{ $trx->user->name }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                                <td class="px-4 py-2">{{ $trx->created_at->format('H:i:s') }}</td>
                                <td class="px-4 py-2"><a href="{{ route('transaksi.struk', $trx) }}" target="_blank" class="text-emerald-600">Lihat</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>