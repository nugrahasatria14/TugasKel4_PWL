<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-desktop text-indigo-500"></i> Mesin Kasir
        </h1>
        <p class="text-sm text-gray-500 mt-1">Cabang: <span class="font-semibold text-gray-700">{{ auth()->user()->cabang->nama ?? 'Pusat' }}</span></p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
            <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-800 mb-4 border-b pb-2">Pilih Barang</h3>
            
            <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                @foreach($stoks as $stok)
                    <div class="border rounded-lg p-3 hover:bg-gray-50 flex justify-between items-center transition">
                        <div>
                            <p class="font-medium text-sm text-gray-800">{{ $stok->barang->nama }}</p>
                            <p class="text-xs text-gray-500">Sisa Stok: <span class="font-bold {{ $stok->quantity < 10 ? 'text-red-500' : 'text-green-500' }}">{{ $stok->quantity }}</span></p>
                            <p class="text-sm font-bold text-indigo-600 mt-1">Rp {{ number_format($stok->barang->harga, 0, ',', '.') }}</p>
                        </div>
                        <button type="button" 
                                onclick="tambahKeKeranjang({{ $stok->barang->id }}, `{{ $stok->barang->nama }}`, {{ $stok->barang->harga ?? 0 }}, {{ $stok->quantity }})"
                                class="bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-100 transition">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex flex-col">
            <h3 class="font-semibold text-gray-800 mb-4 border-b pb-2">Daftar Pesanan</h3>
            
            <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi" class="flex flex-col flex-1">
                @csrf
                <div class="flex-1 max-h-[300px] overflow-y-auto mb-4 border border-gray-100 rounded-lg p-2 bg-gray-50/50" id="keranjangArea">
                    <div id="keranjangKosong" class="text-center text-gray-400 py-10 text-sm">
                        Belum ada barang dipilih.
                    </div>
                    <table class="w-full hidden" id="tabelKeranjang">
                        <thead class="text-xs text-gray-500 text-left border-b">
                            <tr>
                                <th class="pb-2">Barang</th>
                                <th class="pb-2 w-24">Qty</th>
                                <th class="pb-2 text-right">Subtotal</th>
                                <th class="pb-2 text-center w-10">#</th>
                            </tr>
                        </thead>
                        <tbody id="isiKeranjang">
                            </tbody>
                    </table>
                </div>

                <div class="mt-auto border-t pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500 font-medium text-lg">Total Pembayaran</span>
                        <span class="text-3xl font-bold text-gray-900" id="tampilanTotal">Rp 0</span>
                        <input type="hidden" name="total_harga" id="inputTotalHarga" value="0">
                    </div>
                    <button type="submit" id="btnSimpan" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Simpan Transaksi & Cetak Struk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let keranjang = [];

        function tambahKeKeranjang(id, nama, harga, stokMax) {
            let item = keranjang.find(b => b.id === id);
            
            if (item) {
                if (item.qty < stokMax) {
                    item.qty++;
                } else {
                    alert('Melebihi stok yang ada di cabang ini!');
                }
            } else {
                keranjang.push({ id: id, nama: nama, harga: harga, qty: 1, stokMax: stokMax });
            }
            renderKeranjang();
        }

        function ubahQty(id, aksi) {
            let item = keranjang.find(b => b.id === id);
            if (item) {
                if (aksi === 'plus' && item.qty < item.stokMax) {
                    item.qty++;
                } else if (aksi === 'minus' && item.qty > 1) {
                    item.qty--;
                }
            }
            renderKeranjang();
        }

        function hapusItem(id) {
            keranjang = keranjang.filter(b => b.id !== id);
            renderKeranjang();
        }

        function renderKeranjang() {
            const tbody = document.getElementById('isiKeranjang');
            const keranjangKosong = document.getElementById('keranjangKosong');
            const tabelKeranjang = document.getElementById('tabelKeranjang');
            const btnSimpan = document.getElementById('btnSimpan');
            const tampilanTotal = document.getElementById('tampilanTotal');
            const inputTotalHarga = document.getElementById('inputTotalHarga');

            tbody.innerHTML = '';
            let total = 0;

            if (keranjang.length === 0) {
                keranjangKosong.classList.remove('hidden');
                tabelKeranjang.classList.add('hidden');
                btnSimpan.disabled = true;
            } else {
                keranjangKosong.classList.add('hidden');
                tabelKeranjang.classList.remove('hidden');
                btnSimpan.disabled = false;

                keranjang.forEach(item => {
                    let subtotal = item.qty * item.harga;
                    total += subtotal;

                    tbody.innerHTML += `
                        <tr class="border-b last:border-0 border-gray-100">
                            <td class="py-3 text-sm font-medium text-gray-800">
                                ${item.nama}
                                <input type="hidden" name="barang_id[]" value="${item.id}">
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="ubahQty(${item.id}, 'minus')" class="w-6 h-6 rounded bg-gray-100 text-gray-600 hover:bg-gray-200">-</button>
                                    <input type="number" readonly name="qty[]" value="${item.qty}" class="w-10 text-center text-sm border-none bg-transparent p-0">
                                    <button type="button" onclick="ubahQty(${item.id}, 'plus')" class="w-6 h-6 rounded bg-gray-100 text-gray-600 hover:bg-gray-200">+</button>
                                </div>
                            </td>
                            <td class="py-3 text-right text-sm font-semibold text-gray-700">Rp ${subtotal.toLocaleString('id-ID')}</td>
                            <td class="py-3 text-center">
                                <button type="button" onclick="hapusItem(${item.id})" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }

            tampilanTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
            inputTotalHarga.value = total;
        }
    </script>
</x-app-layout>