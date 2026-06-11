<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-building text-blue-500"></i> Kelola Semua Cabang
            </h1>
            <p class="text-sm text-gray-500 mt-1">Daftar seluruh cabang Jayusman Bangunan yang terdaftar di sistem.</p>
        </div>
        
        <a href="{{ route('owner.cabang.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center gap-2 text-sm font-medium">
            <i class="fas fa-plus"></i> Tambah Cabang Baru
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

    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-4 w-16 text-center">ID</th>
                        <th class="px-4 py-4">Nama Cabang</th>
                        <th class="px-4 py-4">Kota</th> <th class="px-4 py-4">Alamat Lengkap</th>
                        <th class="px-4 py-4">Nomor Telepon</th>
                        <th class="px-4 py-4 text-center">Status</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cabangs as $cabang)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-center font-bold text-gray-900">{{ $cabang->id }}</td>
                        <td class="px-4 py-3 font-medium text-blue-600 text-base">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-store text-gray-400"></i> {{ $cabang->nama }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-900 font-medium">{{ $cabang->kota }}</td> <td class="px-4 py-3 text-gray-600">{{ $cabang->alamat ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $cabang->telepon ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">Aktif</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                <a href="{{ route('owner.cabang.edit', $cabang->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded transition" title="Edit Cabang">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form id="form-hapus-{{ $cabang->id }}" action="{{ route('owner.cabang.destroy', $cabang->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="konfirmasiHapus({{ $cabang->id }})" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded transition" title="Hapus Cabang">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                            <i class="fas fa-building text-4xl mb-3 block text-gray-300"></i>
                            Belum ada data cabang yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data cabang ini akan dihapus. Jika dibatalkan, data Anda tetap aman.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika klik "Ya, Hapus!", form akan dijalankan
                    document.getElementById('form-hapus-' + id).submit();
                }
                // Jika klik "Batal", pop-up otomatis tertutup dan tidak terjadi apa-apa
            })
        }
    </script>
</x-app-layout>