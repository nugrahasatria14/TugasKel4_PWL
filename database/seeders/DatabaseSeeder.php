<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CabangSeeder::class,
            BarangSeeder::class,
            UserSeeder::class,
            StokSeeder::class,
        ]);
    }
}