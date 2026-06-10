<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-box text-blue-500"></i> Kelola Data Barang
            </h1>
            <p class="text-sm text-gray-500 mt-1">Daftar seluruh barang (Master Data) di Jayusman Bangunan.</p>
        </div>
        
        <a href="{{ route('master.barang.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center gap-2 text-sm font-medium whitespace-nowrap">
            <i class="fas fa-plus"></i> Tambah Barang Baru
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
                        <th class="px-4 py-4">Kode Barang</th>
                        <th class="px-4 py-4">Nama Barang</th>
                        <th class="px-4 py-4 text-right">Harga Dasar</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-center font-bold text-gray-900">{{ $barang->id }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $barang->kode_barang }}</td>
                        <td class="px-4 py-3 font-medium text-blue-600 text-base">
                            {{ $barang->nama }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-gray-900">
                            Rp {{ number_format($barang->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                
                                <a href="{{ route('master.barang.edit', $barang->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded transition" title="Edit/Update Harga Barang">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form id="form-hapus-{{ $barang->id }}" action="{{ route('master.barang.destroy', $barang->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="konfirmasiHapus({{ $barang->id }}, '{{ $barang->nama }}')" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded transition" title="Hapus Barang">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                            <i class="fas fa-box-open text-4xl mb-3 block text-gray-300"></i>
                            Belum ada data barang (Master Data) yang dimasukkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id, namaBarang) {
            Swal.fire({
                title: 'Hapus Barang?',
                text: "Apakah Anda yakin ingin menghapus " + namaBarang + " dari Master Data? Tindakan ini tidak dapat dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak, Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika klik "Ya", submit form hapus berdasarkan ID
                    document.getElementById('form-hapus-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>