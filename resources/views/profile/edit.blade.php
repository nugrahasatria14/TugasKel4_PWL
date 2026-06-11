<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="far fa-user text-blue-500"></i> Pengaturan Akun
        </h1>
    </div>

    <div class="space-y-6">
        <!-- Form Update Nama & Email (Bisa diakses semua) -->
        <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- JIKA YANG LOGIN ADALAH OWNER ATAU MANAGER -->
        @if(in_array(auth()->user()->role, ['owner', 'manager']))
            
            <!-- Form Ganti Password -->
            <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Bagian History Perubahan Password -->
            <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 rounded-xl">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Riwayat Ganti Password</h2>
                    @php
                        // Ambil data riwayat khusus user ini
                        $histories = \App\Models\RiwayatPassword::where('user_id', auth()->id())
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                    @endphp
                    
                    @if($histories->count() > 0)
                        <ul class="space-y-3">
                            @foreach($histories as $history)
                                <li class="text-sm text-gray-700 flex items-center gap-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                    <i class="fas fa-history text-blue-500 text-lg"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Password Diubah</p>
                                        <p class="text-xs text-gray-500">{{ $history->created_at->format('d M Y - H:i:s') }} WIB</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 bg-gray-50 p-3 rounded-lg text-center">Belum ada riwayat perubahan password.</p>
                    @endif
                </div>
            </div>

            <!-- Form Hapus Akun -->
            <div class="p-4 sm:p-8 bg-red-50 border border-red-100 rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        @else
            <div class="p-5 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 rounded-r-xl shadow-sm">
                <h3 class="font-bold mb-2 flex items-center gap-2"><i class="fas fa-lock"></i> Akses Keamanan Dibatasi</h3>
                <p class="text-sm">Untuk mencegah tindak kecurangan, fitur perubahan password dan penghapusan akun <b>dinonaktifkan</b> untuk peran Anda.</p>
                <p class="text-sm mt-1 text-yellow-600"><i>Jika Anda lupa password atau ingin menggantinya, silakan hubungi Manajer Cabang atau Pemilik Toko.</i></p>
            </div>
        @endif
    </div>
</x-app-layout>