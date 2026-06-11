<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-boxes text-blue-500"></i> Modul Gudang: Mutasi Stok
        </h1>
        <p class="text-sm text-gray-500 mt-1">Cabang: <span class="font-semibold text-gray-700">{{ auth()->user()->cabang->nama ?? 'Pusat' }}</span></p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Catat Mutasi Baru</h3>
            <form action="{{ route('stok.mutasi.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Barang</label>
                    <select name="barang_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Mutasi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center text-sm">
                            <input type="radio" name="jenis" value="masuk" checked class="text-blue-600 focus:ring-blue-500 mr-2"> Masuk (Tambah)
                        </label>
                        <label class="flex items-center text-sm text-red-600">
                            <input type="radio" name="jenis" value="keluar" class="text-red-600 focus:ring-red-500 mr-2"> Keluar (Kurang)
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Qty)</label>
                    <input type="number" name="qty" min="1" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Alasan</label>
                    <textarea name="keterangan" rows="2" required placeholder="Contoh: Barang datang, Barang rusak" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">
                    Simpan Mutasi
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Pergerakan Barang (Ledger)</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Barang</th>
                            <th class="px-4 py-3">Jenis</th>
                            <th class="px-4 py-3">Qty</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3">Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat_mutasi as $rm)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $rm->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $rm->barang->nama }}</td>
                            <td class="px-4 py-3">
                                @if($rm->jenis == 'masuk')
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded">MASUK</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-0.5 rounded">KELUAR</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-bold">{{ $rm->qty }}</td>
                            <td class="px-4 py-3">{{ $rm->keterangan }}</td>
                            <td class="px-4 py-3">{{ $rm->user->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada riwayat mutasi stok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>