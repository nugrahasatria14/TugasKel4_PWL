<x-app-layout>
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-plus-circle text-blue-500"></i> Tambah Master Barang
            </h1>
            <p class="text-sm text-gray-500 mt-1">Masukkan data barang baru untuk Jayusman Bangunan.</p>
        </div>
        
        <a href="{{ route('master.barang') }}" class="bg-gray-100 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-2xl">
        <form action="{{ route('master.barang.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang <span class="text-red-500">*</span></label>
                <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" required placeholder="Contoh: BRG-001" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('kode_barang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Semen Gresik 40kg" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Dasar (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" value="{{ old('harga') }}" required min="0" placeholder="Contoh: 55000" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-gray-500 mt-1">Hanya masukkan angka tanpa titik/koma.</p>
                @error('harga') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-3 border-t border-gray-100 pt-5">
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Data Barang
                </button>
            </div>
        </form>
    </div>
</x-app-layout>