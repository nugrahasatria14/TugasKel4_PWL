<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Stok</h2>
                <a href="{{ route('stok.mutasi.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">+ Mutasi Stok</a>
            </div>
            <p>Cabang: <strong>{{ $cabang->nama }}</strong></p>
            <div class="bg-white rounded shadow mt-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Stok Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($stoks as $stok)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stok->barang->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm {{ $stok->quantity < 10 ? 'text-red-600 font-bold' : 'text-gray-900' }}">{{ $stok->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>