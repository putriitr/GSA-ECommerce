<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat user dengan role 'admin'
        User::create([
            'name' => 'admin@gmail.com',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Hashing the password
            'type' => 1, // 1 for 'admin'
            'slug' => Str::slug('admin@gmail.com', '-'), // Membuat slug berdasarkan name
        ]);
    }
}
