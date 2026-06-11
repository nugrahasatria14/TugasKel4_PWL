<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cabang;

class CabangSeeder extends Seeder
{
    public function run()
    {
        $cabangs = [
            ['nama' => 'Jayusman Bangunan - Pusat', 'kota' => 'Jakarta', 'alamat' => 'Jl. Raya Bekasi Km.18, Jakarta Timur'],
            ['nama' => 'Jayusman Bangunan - Cabang Bandung', 'kota' => 'Bandung', 'alamat' => 'Jl. Soekarno-Hatta No.45, Bandung'],
            ['nama' => 'Jayusman Bangunan - Cabang Surabaya', 'kota' => 'Surabaya', 'alamat' => 'Jl. Raya Darmo No.88, Surabaya'],
            ['nama' => 'Jayusman Bangunan - Cabang Semarang', 'kota' => 'Semarang', 'alamat' => 'Jl. Pandanaran No.22, Semarang'],
            ['nama' => 'Jayusman Bangunan - Cabang Medan', 'kota' => 'Medan', 'alamat' => 'Jl. Gatot Subroto No.10, Medan'],
        ];

        foreach ($cabangs as $cabang) {
            Cabang::create($cabang);
        }
    }
}