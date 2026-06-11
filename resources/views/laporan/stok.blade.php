<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-box-open text-blue-500"></i> Pantau Stok Toko
        </h1>
        <p class="text-sm text-gray-500 mt-1">Cabang: <span class="font-semibold text-gray-700">{{ auth()->user()->cabang->nama ?? 'Pusat' }}</span></p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3">Kode Barang</th>
                        <th class="px-4 py-3">Nama Barang</th>
                        <th class="px-4 py-3 text-center">Stok Tersedia</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stoks as $stok)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $stok->barang->kode_barang }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $stok->barang->nama }}</td>
                        <td class="px-4 py-3 text-center font-bold text-lg {{ $stok->quantity <= 10 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $stok->quantity }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($stok->quantity == 0)
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">HABIS</span>
                            @elseif($stok->quantity <= 10)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">MENIPIS</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">AMAN</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada data stok di cabang ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>