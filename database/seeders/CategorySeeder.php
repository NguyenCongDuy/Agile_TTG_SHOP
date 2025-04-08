<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Latest electronic devices and gadgets',
                'image' => 'images/categories/electronics.jpg',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashionable clothing for all seasons',
                'image' => 'images/categories/clothing.jpg',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Everything for your home and kitchen',
                'image' => 'images/categories/home-kitchen.jpg',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Books',
                'description' => 'Wide range of books for all ages',
                'image' => 'images/categories/books.jpg',
                'is_featured' => false,
                'status' => true
            ],
            [
                'name' => 'Sports',
                'description' => 'Sports equipment and accessories',
                'image' => 'images/categories/sports.jpg',
                'is_featured' => false,
                'status' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 