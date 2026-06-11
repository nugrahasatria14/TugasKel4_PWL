<x-app-layout>
    <div>
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                Halo, Owner! 👋
            </h1>
            <p class="text-gray-500 text-sm mt-1">Ringkasan performa seluruh cabang Jayusman Bangunan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Total Cabang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $cabangs->count() ?? 5 }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500">
                    <i class="fas fa-building text-lg"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ isset($totalTransaksi) ? number_format($totalTransaksi) : '0' }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-sky-50 flex items-center justify-center text-sky-500">
                    <i class="fas fa-shopping-cart text-lg"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ isset($totalPendapatan) ? number_format($totalPendapatan, 0, ',', '.') : '0' }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                    <i class="fas fa-money-bill-wave text-lg"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Total Barang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ isset($totalBarang) ? number_format($totalBarang) : '12' }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                    <i class="fas fa-chart-line text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                    <h3 class="text-sm font-semibold text-gray-800">Stok Menipis (Seluruh Cabang)</h3>
                </div>
                <span class="text-[11px] bg-red-50 text-red-500 px-3 py-1 rounded-full font-semibold">{{ isset($stokMenipis) ? $stokMenipis->count() : '5' }} Item</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-6 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider w-1/3">Cabang</th>
                            <th class="px-6 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider w-1/2">Barang</th>
                            <th class="px-6 py-3 text-center text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($stokMenipis ?? [1,2,3,4,5] as $stok)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Jayusman Bangunan - Pusat</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Pasir Bangka (1 pickup)</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center justify-center px-2 py-0.5 rounded bg-red-50 text-red-500 text-xs font-semibold min-w-[24px]">8</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">Semua stok dalam kondisi aman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-4">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <i class="far fa-building text-gray-600"></i>
                <h3 class="text-sm font-semibold text-gray-800">Daftar Cabang</h3>
            </div>
            <div class="flex flex-col">
                @forelse($cabangs ?? [1,2,3] as $cabang)
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 hover:bg-gray-50 transition cursor-pointer last:border-0 group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-500 flex-shrink-0">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600 transition">Jayusman Bangunan - Pusat</h4>
                            <p class="text-[13px] text-gray-500 mt-0.5">Jl. Raya Bekasi Km.18, Jakarta Timur</p>
                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-medium">ID: 1</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-indigo-400"></i>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-sm text-gray-500">
                    Belum ada cabang terdaftar.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>