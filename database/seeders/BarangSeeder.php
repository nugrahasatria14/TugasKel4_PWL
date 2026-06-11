<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $barangs = [
            ['kode_barang' => 'SMN001', 'nama' => 'Semen Tiga Roda 50kg', 'harga' => 65000],
            ['kode_barang' => 'PSR001', 'nama' => 'Pasir Bangka (1 pickup)', 'harga' => 350000],
            ['kode_barang' => 'BTA001', 'nama' => 'Bata Merah (100 pcs)', 'harga' => 75000],
            ['kode_barang' => 'CAT001', 'nama' => 'Cat Tembok Dulux 5kg', 'harga' => 185000],
            ['kode_barang' => 'PIP001', 'nama' => 'Pipa PVC 1/2" (4m)', 'harga' => 25000],
            ['kode_barang' => 'KAY001', 'nama' => 'Kayu Balok 5x7 (4m)', 'harga' => 45000],
            ['kode_barang' => 'PKU001', 'nama' => 'Paku 5cm (1kg)', 'harga' => 18000],
            ['kode_barang' => 'KRM001', 'nama' => 'Keramik 40x40 (1 dus)', 'harga' => 85000],
            ['kode_barang' => 'GIP001', 'nama' => 'Gipsum 120x240cm', 'harga' => 55000],
            ['kode_barang' => 'KRN001', 'nama' => 'Kran Air', 'harga' => 32000],
            ['kode_barang' => 'PLY001', 'nama' => 'Triplek 9mm (122x244cm)', 'harga' => 125000],
            ['kode_barang' => 'BJT001', 'nama' => 'Besi Beton 10mm (1 batang)', 'harga' => 70000],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}