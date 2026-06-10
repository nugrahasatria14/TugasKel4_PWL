<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MutasiStokController;
use App\Http\Controllers\StokOpnameController; 
use App\Http\Controllers\SupervisiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard Utama
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Group middleware auth untuk route yang butuh login
Route::middleware(['auth'])->group(function () {

    // Profile routes (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   
   

    // RUTE ORANG 1 (SATRIA) - MASTER DATA & OWNER
    // 1. Master Barang
    Route::get('/master/barang', [BarangController::class, 'index'])->name('master.barang');
    Route::get('/master/barang/create', [BarangController::class, 'create'])->name('master.barang.create');
    Route::post('/master/barang', [BarangController::class, 'store'])->name('master.barang.store');
    Route::get('/master/barang/{barang}/edit', [BarangController::class, 'edit'])->name('master.barang.edit');
    Route::put('/master/barang/{barang}', [BarangController::class, 'update'])->name('master.barang.update');
    Route::delete('/master/barang/{barang}', [BarangController::class, 'destroy'])->name('master.barang.destroy');

    // 2. Master Pegawai 
    Route::get('/master/pegawai', [PegawaiController::class, 'index'])->name('master.pegawai');
    Route::get('/master/pegawai/create', [PegawaiController::class, 'create'])->name('master.pegawai.create');
    Route::post('/master/pegawai', [PegawaiController::class, 'store'])->name('master.pegawai.store');
    Route::get('/master/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('master.pegawai.edit');
    Route::put('/master/pegawai/{id}', [PegawaiController::class, 'update'])->name('master.pegawai.update');
    Route::delete('/master/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('master.pegawai.destroy');

    // 3. Tampilan Utama Daftar Cabang (Owner)
    Route::get('/owner/cabang', [OwnerController::class, 'cabang'])->name('owner.cabang');
    
    // 4. Proses CRUD Cabang
    Route::get('/owner/cabang/create', [OwnerController::class, 'createCabang'])->name('owner.cabang.create');
    Route::post('/owner/cabang', [OwnerController::class, 'storeCabang'])->name('owner.cabang.store');
    Route::get('/owner/cabang/{cabang}/edit', [OwnerController::class, 'editCabang'])->name('owner.cabang.edit');
    Route::put('/owner/cabang/{cabang}', [OwnerController::class, 'updateCabang'])->name('owner.cabang.update');
    Route::delete('/owner/cabang/{cabang}', [OwnerController::class, 'destroyCabang'])->name('owner.cabang.destroy');

    // 5. Menu Pemantauan Lainnya (Owner)
    Route::get('/owner/stok', [OwnerController::class, 'stok'])->name('owner.stok');
    Route::get('/owner/transaksi', [OwnerController::class, 'transaksi'])->name('owner.transaksi');
    Route::get('/owner/laporan', [OwnerController::class, 'laporan'])->name('owner.laporan');
    Route::get('/owner/laporan/pdf', [OwnerController::class, 'cetakPDF'])->name('owner.laporan.pdf');

});


if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}