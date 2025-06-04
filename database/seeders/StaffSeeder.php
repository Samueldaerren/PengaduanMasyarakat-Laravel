<?php

// database/seeders/StaffSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data Staff
        User::create([
            'email' => 'staff1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'STAFF', // set role ke STAFF
        ]);

        // Bisa menambahkan lebih banyak staff jika diperlukan
        User::create([
            'email' => 'staff2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'STAFF', // set role ke STAFF
        ]);
    }
}

