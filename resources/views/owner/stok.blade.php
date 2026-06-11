<x-app-layout>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-boxes text-blue-500"></i> Pantau Semua Stok (Global)
            </h1>
            <p class="text-sm text-gray-500 mt-1">Pantau ketersediaan barang di seluruh cabang Jayusman Bangunan secara real-time.</p>
        </div>

        <!-- Kolom Pencarian -->
        <form action="{{ route('owner.stok') }}" method="GET" class="w-full sm:w-auto flex items-center gap-2">
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 shadow-sm">
            </div>
            <button type="submit" class="p-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('owner.stok') }}" class="p-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition shadow-sm" title="Reset Pencarian">
                    <i class="fas fa-undo"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Peringatan jika pencarian tidak ditemukan -->
    @if(request('search') && $stoks->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
            <p class="text-sm text-yellow-700">
                Barang dengan kata kunci <b>"{{ request('search') }}"</b> tidak ditemukan di cabang manapun.
            </p>
        </div>
    @endif

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3">Lokasi Cabang</th>
                        <th class="px-4 py-3">Kode Barang</th>
                        <th class="px-4 py-3">Nama Barang</th>
                        <th class="px-4 py-3 text-center">Stok Tersedia</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stoks as $stok)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-blue-600">
                            <i class="fas fa-store text-gray-400 text-xs mr-1"></i> {{ $stok->cabang->nama ?? 'Pusat' }}
                        </td>
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
                    @if(!request('search'))
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                <i class="fas fa-box-open text-3xl mb-2 block"></i>
                                Belum ada data stok di seluruh cabang.
                            </td>
                        </tr>
                    @endif
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>