<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-building text-blue-500"></i> {{ isset($cabang) ? 'Edit Cabang' : 'Tambah Cabang Baru' }}
        </h1>
        <p class="text-sm text-gray-500 mt-1">Silakan isi detail informasi cabang Jayusman Bangunan di bawah ini.</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-2xl">
        <form action="{{ isset($cabang) ? route('owner.cabang.update', $cabang->id) : route('owner.cabang.store') }}" method="POST">
            @csrf
            @if(isset($cabang))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Cabang <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $cabang->nama ?? '') }}" required placeholder="Contoh: Jayusman Bangunan - Cabang Bekasi" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kota / Kabupaten <span class="text-red-500">*</span></label>
                <input type="text" name="kota" value="{{ old('kota', $cabang->kota ?? '') }}" required placeholder="Contoh: Cianjur" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $cabang->telepon ?? '') }}" placeholder="Contoh: 081234567890" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap cabang..." class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $cabang->alamat ?? '') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('owner.cabang') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</x-app-layout>