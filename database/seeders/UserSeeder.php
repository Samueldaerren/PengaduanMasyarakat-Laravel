<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'newuser1@example.com',
            'password' => Hash::make('newpassword123'), // Password yang terenkripsi
        ]);

        User::create([
            'email' => 'newuser2@example.com',
            'password' => Hash::make('newpassword123'),
        ]);
    }
}
