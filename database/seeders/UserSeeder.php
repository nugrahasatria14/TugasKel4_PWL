<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
    
        User::create([
            'name' => 'Pak Jayusman',
            'email' => 'owner@jayusman.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'cabang_id' => null,
        ]);

    
        for ($i = 1; $i <= 5; $i++) {
            // Manager
            User::create([
                'name' => "Manager Cabang {$i}",
                'email' => "manager{$i}@jayusman.com",
                'password' => Hash::make('password'),
                'role' => 'manager',
                'cabang_id' => $i,
            ]);

            
            User::create([
                'name' => "Supervisor Cabang {$i}",
                'email' => "supervisor{$i}@jayusman.com",
                'password' => Hash::make('password'),
                'role' => 'supervisor',
                'cabang_id' => $i,
            ]);

            
            User::create([
                'name' => "Kasir Cabang {$i}",
                'email' => "kasir{$i}@jayusman.com",
                'password' => Hash::make('password'),
                'role' => 'kasir',
                'cabang_id' => $i,
            ]);

            
            User::create([
                'name' => "Gudang Cabang {$i}",
                'email' => "gudang{$i}@jayusman.com",
                'password' => Hash::make('password'),
                'role' => 'gudang',
                'cabang_id' => $i,
            ]);
        }
    }
}