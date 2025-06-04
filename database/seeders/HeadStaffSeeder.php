<?php

namespace Database\Seeders;

// database/seeders/HeadStaffSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HeadStaffSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data Head Staff
        User::create([
            'email' => 'headstaff@example.com',
            'password' => Hash::make('password123'), // pastikan password terenkripsi
            'role' => 'HEAD_STAFF', // set role ke HEAD_STAFF
        ]);
    }
}
