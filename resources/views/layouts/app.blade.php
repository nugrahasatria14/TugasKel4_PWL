<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jayusman Bangunan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom scrollbar tipis */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#f9fafb] text-gray-800 antialiased flex h-screen overflow-hidden">

    <aside id="sidebar" class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0 z-20 transition-all duration-300 ease-in-out relative">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <i class="fas fa-store text-gray-700 text-xl mr-3"></i>
            <div>
                <h1 class="font-bold text-gray-900 leading-tight">Jayusman</h1>
                <p class="text-[10px] text-gray-500">Manajemen Bangunan</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            
            <a href="{{ route('dashboard') ?? '#' }}" class="flex items-center gap-3 px-3 py-2.5 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium transition">
                <i class="fas fa-home w-5 text-center"></i> 
                <span>Dashboard</span>
            </a>

            @if(auth()->check() && in_array(auth()->user()->role, ['owner', 'manager']))
                <div class="px-3 py-3 mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Master Data</div>
                
                <a href="{{ route('master.barang') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-box w-5 text-center"></i> 
                    <span>Kelola Data Barang</span>
                </a>
                
               <a href="{{ route('master.pegawai') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-users-cog w-5 text-center"></i> 
                    <span>Kelola Akun Pegawai</span>
                </a>
            @endif
            @if(auth()->check() && auth()->user()->role === 'owner')
                <div class="px-3 py-3 mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akses Pemilik</div>
                
                <a href="{{ route('owner.cabang') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-building w-5 text-center"></i> 
                    <span>Kelola Semua Cabang</span>
                </a>
                <a href="{{ route('owner.stok') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-boxes w-5 text-center"></i> 
                    <span>Pantau Semua Stok</span>
                </a>
                <a href="{{ route('owner.transaksi') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-receipt w-5 text-center"></i> 
                    <span>Pantau Semua Transaksi</span>
                </a>
                <a href="{{ route('owner.laporan') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-chart-pie w-5 text-center"></i> 
                    <span>Laporan Gabungan</span>
                </a>
            @endif

            @if(auth()->check() && auth()->user()->role === 'manager')
                <div class="px-3 py-3 mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akses Manajer</div>

                <a href="{{ route('manager.stok') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-box-open w-5 text-center"></i> 
                    <span>Lihat Stok Toko</span>
                </a>
                <a href="{{ route('supervisi.transaksi') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-shopping-cart w-5 text-center"></i> 
                    <span>Lihat Transaksi Toko</span>
                </a>
                <a href="{{ route('laporan.manager') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-calendar-alt w-5 text-center"></i> 
                    <span>Cetak Laporan</span>
                </a>
            @endif

            @if(auth()->check() && auth()->user()->role === 'supervisor')
                <div class="px-3 py-3 mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akses Supervisor</div>

                <a href="{{ route('supervisi.transaksi') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-eye w-5 text-center"></i> 
                    <span>Pantau Transaksi (Live)</span>
                </a>
            @endif

            @if(auth()->check() && auth()->user()->role === 'kasir')
                <div class="px-3 py-3 mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akses Kasir</div>

                <a href="{{ route('transaksi.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-desktop w-5 text-center"></i> 
                    <span>Input Penjualan</span>
                </a>
            @endif

            @if(auth()->check() && auth()->user()->role === 'gudang')
                <div class="px-3 py-3 mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akses Gudang</div>

                <a href="{{ route('stok.mutasi.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-truck-loading w-5 text-center"></i> 
                    <span>Barang Masuk / Keluar</span>
                </a>
                <a href="{{ route('stok.opname.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    <i class="fas fa-clipboard-list w-5 text-center"></i> 
                    <span>Stok Opname</span>
                </a>
            @endif
            
            <div class="pt-4 mt-4 border-t border-gray-100"></div>

            <a href="{{ route('profile.edit') ?? '#' }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                <i class="far fa-user w-5 text-center"></i> 
                <span>Profil Saya</span>
            </a>

            <form id="form-logout" method="POST" action="{{ route('logout') ?? '#' }}">
                @csrf
                <button type="button" onclick="konfirmasiLogout()" class="flex items-center gap-3 px-3 py-2.5 w-full text-red-500 hover:bg-red-50 rounded-lg text-sm font-medium transition text-left mt-2">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i> 
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#f8f9fa]">
        
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0 z-10">
            <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition focus:outline-none">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <div class="flex items-center p-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 overflow-hidden shadow-sm" title="Anda login sebagai: {{ auth()->check() ? auth()->user()->role : 'Guest' }}">
                    <i class="fas fa-user text-sm"></i>
                </div>
            </div>
        </header>

        <main class="flex-1 p-8 overflow-y-auto">
            {{ $slot }}
            
            <footer class="mt-12 text-center text-[11px] text-gray-400 pb-4">
                © 2026 Jayusman Bangunan. All rights reserved.
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Script Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-ml-64');
        });

        // Script Konfirmasi Logout dengan SweetAlert
        function konfirmasiLogout() {
            Swal.fire({
                title: 'Apakah Anda yakin ingin keluar?',
                text: "Anda akan diarahkan kembali ke halaman login.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-logout').submit();
                }
            });
        }
    </script>
</body>
</html>