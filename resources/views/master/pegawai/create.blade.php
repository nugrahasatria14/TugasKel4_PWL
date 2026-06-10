<x-app-layout>
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-user-plus text-blue-500"></i> Tambah Akun Pegawai
            </h1>
            <p class="text-sm text-gray-500 mt-1">Daftarkan pengguna baru dan atur hak aksesnya.</p>
        </div>
        
        <a href="{{ route('master.pegawai') }}" class="bg-gray-100 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-2xl">
        <form action="{{ route('master.pegawai.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: pegawai@jayusman.com" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required placeholder="Ketik ulang password" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hak Akses (Role) <span class="text-red-500">*</span></label>
                <select name="role" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>-- Pilih Hak Akses --</option>
                    
                    @if(auth()->user()->role === 'owner')
                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner (Pemilik)</option>
                    @endif
                    
                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="gudang" {{ old('role') == 'gudang' ? 'selected' : '' }}>Gudang</option>
                </select>
                @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Penempatan Cabang <span class="text-red-500">*</span></label>
                
                <select name="cabang_id" {{ auth()->user()->role !== 'owner' ? 'required' : '' }} class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    
                    @if(auth()->user()->role === 'owner')
                        <option value="">Pusat (Bisa mengakses semua cabang jika Owner)</option>
                    @else
                        <option value="" disabled selected>-- Pilih Penempatan Cabang --</option>
                    @endif

                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}" {{ old('cabang_id') == $cabang->id ? 'selected' : '' }}>
                            {{ $cabang->nama }} - {{ $cabang->kota }}
                        </option>
                    @endforeach
                </select>
                
                @if(auth()->user()->role === 'owner')
                    <p class="text-xs text-gray-500 mt-1">Kosongkan (Pusat) jika akun ini adalah Owner.</p>
                @else
                    <p class="text-xs text-orange-500 mt-1">Anda wajib menempatkan pegawai baru di salah satu cabang.</p>
                @endif
                
                @error('cabang_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-3 border-t border-gray-100 pt-5">
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Akun Pegawai
                </button>
            </div>
        </form>
    </div>
</x-app-layout>