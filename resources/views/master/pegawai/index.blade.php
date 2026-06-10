<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-users-cog text-blue-500"></i> Kelola Akun Pegawai
            </h1>
            <p class="text-sm text-gray-500 mt-1">Daftar pengguna aplikasi dan hak akses (role) di sistem.</p>
        </div>
        
        <a href="{{ route('master.pegawai.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center gap-2 text-sm font-medium whitespace-nowrap">
            <i class="fas fa-user-plus"></i> Tambah Pegawai Baru
        </a>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Peringatan!',
                    text: '{{ session('error') }}',
                });
            });
        </script>
    @endif

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-4 w-12 text-center">NO</th>
                        <th class="px-4 py-4">Nama & Email</th>
                        <th class="px-4 py-4 text-center">Hak Akses (Role)</th>
                        <th class="px-4 py-4 text-center">Penempatan Cabang</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse($pegawais as $index => $pegawai) <tr class="border-b hover:bg-gray-50 transition">
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-center font-bold text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                             <p class="font-bold text-gray-900 text-base">{{ $pegawai->name }}</p>
                             <p class="text-xs text-gray-500">{{ $pegawai->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($pegawai->role === 'owner')
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Owner</span>
                            @elseif($pegawai->role === 'manager')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Manager</span>
                            @elseif($pegawai->role === 'supervisor')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Supervisor</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold uppercase">{{ $pegawai->role }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center font-medium text-gray-600">
                            {{ $pegawai->cabang ? $pegawai->cabang->nama : 'Pusat (Semua Akses)' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('master.pegawai.edit', $pegawai->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded transition" title="Edit Akun & Reset Password">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form id="form-hapus-{{ $pegawai->id }}" action="{{ route('master.pegawai.destroy', $pegawai->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="konfirmasiHapus({{ $pegawai->id }}, '{{ $pegawai->name }}')" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded transition" title="Hapus Pegawai">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                            <i class="fas fa-users-slash text-4xl mb-3 block text-gray-300"></i>
                            Belum ada data akun pegawai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id, namaPegawai) {
            Swal.fire({
                title: 'Hapus Akun Pegawai?',
                text: "Apakah Anda yakin ingin menghapus akun " + namaPegawai + "? Tindakan ini tidak dapat dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak, Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>