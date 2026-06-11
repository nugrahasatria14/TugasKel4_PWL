<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Dashboard Manajer</h2>
            <p class="mb-6">Cabang: <strong>{{ $cabang->nama }}</strong> ({{ $cabang->kota }})</p>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-5 rounded shadow">
                    <div class="text-sm text-gray-500">Transaksi Hari Ini</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ $transaksiHariIni }}</div>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <div class="text-sm text-gray-500">Pendapatan Hari Ini</div>
                    <div class="text-2xl font-bold text-emerald-600">Rp {{ number_format($pendapatanHariIni,0,',','.') }}</div>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <div class="text-sm text-gray-500">Total Stok Barang</div>
                    <div class="text-2xl font-bold text-emerald-600">{{ number_format($totalBarang) }}</div>
                </div>
            </div>

            <!-- Stok Menipis -->
            <div class="bg-white rounded shadow mb-8">
                <div class="px-4 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium">⚠️ Stok Menipis</h3>
                </div>
                <div class="p-6">
                    @if($stokMenipis->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr><th class="px-4 py-2 text-left">Barang</th><th class="px-4 py-2 text-left">Stok</th></tr>
                            </thead>
                            <tbody>
                                @foreach($stokMenipis as $stok)
                                <tr><td class="px-4 py-2">{{ $stok->barang->nama }}</td><td class="px-4 py-2 text-red-600 font-bold">{{ $stok->quantity }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-green-600">Semua stok aman.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>