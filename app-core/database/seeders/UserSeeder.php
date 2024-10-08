<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat user dengan role 'user'
        User::create([
            'name' => 'user@gmail.com',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'), // Hashing the password
            'type' => 0, // 0 for 'user'
        ]);

        // Buat user dengan role 'admin'
        User::create([
            'name' => 'admin@gmail.com',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Hashing the password
            'type' => 1, // 1 for 'admin'
        ]);

        // Buat user dengan role 'manager'
        User::create([
            'name' => 'manager@gmail.com',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'), // Hashing the password
            'type' => 2, // 2 for 'manager'
        ]);
    }
}
