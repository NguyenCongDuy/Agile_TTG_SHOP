<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(UserSeeder::class);
        $this->call(ProductsSeeder::class);

        // Create Categories
        $categories = [
            [
                'name' => 'Điện tử',
                'description' => 'Các thiết bị điện tử và phụ kiện',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Thời trang',
                'description' => 'Quần áo và phụ kiện thời trang',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Sách',
                'description' => 'Sách và tài liệu học tập',
                'is_featured' => true,
                'status' => true
            ]
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
        
        // Tạo sản phẩm
        $products = [
            [
                'name' => 'Smartphone',
                'description' => 'Điện thoại thông minh mới nhất với các tính năng vượt trội',
                'price' => 9999000,  // Giá quy đổi sang đồng Việt Nam (VNĐ)
                'category_id' => 1,  // Danh mục "Điện tử"
                'stock' => 50,       // Số lượng trong kho
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Laptop',
                'description' => 'Laptop mạnh mẽ cho công việc và chơi game',
                'price' => 14999000, // Giá quy đổi sang đồng Việt Nam (VNĐ)
                'category_id' => 1,
                'stock' => 30,
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Áo thun',
                'description' => 'Áo thun cotton thoải mái, phù hợp với mọi mùa',
                'price' => 299000, // Giá quy đổi sang đồng Việt Nam (VNĐ)
                'category_id' => 2, // Danh mục "Thời trang"
                'stock' => 100,
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Quần jeans',
                'description' => 'Quần jeans màu xanh cổ điển, phù hợp với mọi trang phục',
                'price' => 599000, // Giá quy đổi sang đồng Việt Nam (VNĐ)
                'category_id' => 2,
                'stock' => 75,
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'Sách lập trình',
                'description' => 'Học lập trình từ cơ bản đến nâng cao',
                'price' => 499000, // Giá quy đổi sang đồng Việt Nam (VNĐ)
                'category_id' => 3, // Danh mục "Sách"
                'stock' => 40,
                'is_featured' => true,
                'status' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->call(ContactSeeder::class);

        $this->call([
            CategorySeeder::class,
        ]);
    }
}
