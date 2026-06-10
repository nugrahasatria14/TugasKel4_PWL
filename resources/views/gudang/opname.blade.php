<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-clipboard-list text-blue-500"></i> Modul Gudang: Stok Opname (Audit)
        </h1>
        <p class="text-sm text-gray-500 mt-1">Lakukan perhitungan fisik untuk mendeteksi kehilangan barang.</p>
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

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Form Input Stok Fisik</h3>
            <form action="{{ route('stok.opname.store') }}" method="POST">
                @csrf
                <div class="overflow-x-auto mb-4">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-3 py-3">Nama Barang</th>
                                <th class="px-3 py-3 text-center">Stok Sistem</th>
                                <th class="px-3 py-3 w-32">Stok Nyata (Fisik)</th>
                                <th class="px-3 py-3">Catatan / Alasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stoks as $stok)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-3 py-3 font-medium text-gray-900">
                                    {{ $stok->barang->nama }}
                                    <input type="hidden" name="barang_id[]" value="{{ $stok->barang_id }}">
                                </td>
                                <td class="px-3 py-3 text-center font-bold text-blue-600">
                                    {{ $stok->quantity }}
                                    <input type="hidden" name="stok_sistem[]" value="{{ $stok->quantity }}">
                                </td>
                                <td class="px-3 py-2">
                                    <input type="number" name="stok_fisik[]" value="{{ $stok->quantity }}" min="0" required class="w-full border-gray-300 rounded focus:ring-blue-500 text-sm p-1.5 text-center">
                                </td>
                                <td class="px-3 py-2">
                                    <input type="text" name="keterangan[]" placeholder="Isi jika ada selisih" class="w-full border-gray-300 rounded focus:ring-blue-500 text-sm p-1.5">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Hasil Opname
                </button>
            </form>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-red-600 mb-4 border-b pb-2"><i class="fas fa-exclamation-triangle"></i> Laporan Temuan Selisih (Audit)</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-3 py-3">Tanggal</th>
                            <th class="px-3 py-3">Barang</th>
                            <th class="px-3 py-3 text-center">Sistem</th>
                            <th class="px-3 py-3 text-center">Fisik</th>
                            <th class="px-3 py-3 text-center">Selisih</th>
                            <th class="px-3 py-3">Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-3 py-3">{{ $r->created_at->format('d/m/Y') }}</td>
                            <td class="px-3 py-3 font-medium text-gray-900">{{ $r->barang->nama }}</td>
                            <td class="px-3 py-3 text-center">{{ $r->stok_sistem }}</td>
                            <td class="px-3 py-3 text-center font-bold">{{ $r->stok_fisik }}</td>
                            <td class="px-3 py-3 text-center">
                                @if($r->selisih < 0)
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">{{ $r->selisih }} (Hilang)</span>
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">+{{ $r->selisih }} (Lebih)</span>
                                @endif
                            </td>
                            <td class="px-3 py-3">{{ $r->user->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada temuan selisih. Stok aman!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>