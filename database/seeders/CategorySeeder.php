<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory(6)->create();
        $categories = ['Books', 'Electronics', 'Clothing', 'Food', 'Toys', 'Furniture', 'Sports', 'Health', 'Beauty', 'Automotive', 'Gardening', 'Tools', 'Pet Supplies', 'Office Supplies'];

        foreach ($categories as $category) {
            \App\Models\Category::factory()->create(['name' => $category, 'slug' => \Illuminate\Support\Str::slug($category)]);
        }
    }
}
