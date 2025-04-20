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
                'name' => 'PC Gaming',
                'description' => 'Máy tính chơi game hiệu năng cao, đồ họa mạnh mẽ',
                'image' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?q=80&w=2042&auto=format&fit=crop',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'PC Văn Phòng',
                'description' => 'Máy tính văn phòng giá rẻ, hiệu năng ổn định',
                'image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?q=80&w=1932&auto=format&fit=crop',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'PC Core Ultra',
                'description' => 'Máy tính hiệu năng siêu cao, xử lý đa nhiệm mạnh mẽ',
                'image' => 'https://images.unsplash.com/photo-1591405351990-4726e331f141?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'PC Mini',
                'description' => 'Máy tính nhỏ gọn, tiết kiệm không gian',
                'image' => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?q=80&w=1974&auto=format&fit=crop',
                'is_featured' => true,
                'status' => true
            ],
            [
                'name' => 'CPU',
                'description' => 'Bộ vi xử lý từ các thương hiệu hàng đầu',
                'image' => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?q=80&w=1974&auto=format&fit=crop',
                'is_featured' => false,
                'status' => true
            ],
            [
                'name' => 'Mainboard',
                'description' => 'Bo mạch chủ đa dạng chipset và kích thước',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => false,
                'status' => true
            ],
            [
                'name' => 'RAM',
                'description' => 'Bộ nhớ trong tốc độ cao, dung lượng lớn',
                'image' => 'https://images.unsplash.com/photo-1562976540-1502c2145186?q=80&w=1931&auto=format&fit=crop',
                'is_featured' => false,
                'status' => true
            ],
            [
                'name' => 'VGA',
                'description' => 'Card đồ họa mạnh mẽ cho gaming và đồ họa',
                'image' => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => false,
                'status' => true
            ],
            [
                'name' => 'SSD/HDD',
                'description' => 'Ổ cứng tốc độ cao, dung lượng lớn',
                'image' => 'https://images.unsplash.com/photo-1601737487795-dab272f52cd0?q=80&w=1780&auto=format&fit=crop',
                'is_featured' => false,
                'status' => true
            ],
            [
                'name' => 'Tản Nhiệt',
                'description' => 'Hệ thống làm mát hiệu quả cho PC',
                'image' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => false,
                'status' => true
            ],
            [
                'name' => 'Nguồn (PSU)',
                'description' => 'Nguồn máy tính công suất cao, ổn định',
                'image' => 'https://images.unsplash.com/photo-1624913503273-5f9c4e980dba?q=80&w=1932&auto=format&fit=crop',
                'is_featured' => false,
                'status' => true
            ],
            [
                'name' => 'Vỏ Case',
                'description' => 'Vỏ máy tính đa dạng kiểu dáng và kích thước',
                'image' => 'https://images.unsplash.com/photo-1587202372616-b43abea06c2a?q=80&w=2070&auto=format&fit=crop',
                'is_featured' => false,
                'status' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}