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
        $now = now();

        Category::insert([
            [
                'name' => 'Laptops', 
                'description' => 'High performance laptops',
                // Now points to the local file you downloaded
                'image' => 'categories/laptops.jpg', 
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Accessories', 
                'description' => 'Keyboards, mice, and more',
                'image' => 'categories/accessories.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mobiles', 
                'description' => 'Latest smartphones',
                'image' => 'categories/mobiles.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}