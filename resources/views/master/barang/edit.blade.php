<x-app-layout>
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-edit text-indigo-500"></i> Edit Master Barang
            </h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui detail atau harga untuk barang: <span class="font-bold">{{ $barang->nama }}</span></p>
        </div>
        
        <a href="{{ route('master.barang') }}" class="bg-gray-100 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-2xl">
        <form action="{{ route('master.barang.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang <span class="text-red-500">*</span></label>
                <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('kode_barang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $barang->nama) }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                <input type="text" name="satuan" value="{{ old('satuan', $barang->satuan) }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('satuan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Update Harga Dasar (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" value="{{ old('harga', $barang->harga) }}" required min="0" class="w-full border border-indigo-300 rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500 bg-indigo-50">
                <p class="text-xs text-indigo-500 mt-1"><i class="fas fa-info-circle"></i> Perubahan harga akan dicatat atas nama Anda ({{ Auth::user()->name }}).</p>
                @error('harga') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-3 border-t border-gray-100 pt-5">
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>