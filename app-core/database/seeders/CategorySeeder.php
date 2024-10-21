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
            ['name' => 'Cutting Tools', 'slug' => Str::slug('Cutting Tools')],
            ['name' => 'Fastening Tools', 'slug' => Str::slug('Fastening Tools')],
            ['name' => 'Mechanics Tools', 'slug' => Str::slug('Mechanics Tools')],
            ['name' => 'Holding Tools', 'slug' => Str::slug('Holding Tools')],
            ['name' => 'Machine', 'slug' => Str::slug('Machine')],
            ['name' => 'Measuring Tools', 'slug' => Str::slug('Measuring Tools')],
            ['name' => 'Safety Equipment', 'slug' => Str::slug('Safety Equipment')],
            ['name' => 'Vde Tools', 'slug' => Str::slug('Vde Tools')],
        ];

        

        

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
