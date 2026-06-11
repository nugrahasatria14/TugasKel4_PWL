<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stok;

class StokSeeder extends Seeder
{
    public function run()
    {
        for ($cabangId = 1; $cabangId <= 5; $cabangId++) {
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 1, 'quantity' => 40]);   
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 2, 'quantity' => 8]);    
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 3, 'quantity' => 150]);  
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 4, 'quantity' => 15]);   
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 5, 'quantity' => 25]);   
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 6, 'quantity' => 30]);   
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 7, 'quantity' => 50]);   
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 8, 'quantity' => 12]);   
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 9, 'quantity' => 20]);   
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 10, 'quantity' => 35]); 
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 11, 'quantity' => 18]);  
            Stok::create(['cabang_id' => $cabangId, 'barang_id' => 12, 'quantity' => 22]);  
        }
    }
}