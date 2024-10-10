<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Alat Tulis', 'slug' => Str::slug('Alat Tulis')],
            ['name' => 'Peralatan Rumah Tangga', 'slug' => Str::slug('Peralatan Rumah Tangga')],
            ['name' => 'Elektronik', 'slug' => Str::slug('Elektronik')],
            ['name' => 'Pakaian', 'slug' => Str::slug('Pakaian')],
            ['name' => 'Buku', 'slug' => Str::slug('Buku')],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
