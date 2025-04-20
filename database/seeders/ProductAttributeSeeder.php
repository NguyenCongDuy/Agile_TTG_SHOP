<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;

class ProductAttributeSeeder extends Seeder
{
    public function run(): void
    {
        // CPU Attribute
        $cpuAttribute = ProductAttribute::create([
            'name' => 'cpu',
            'display_name' => 'CPU',
            'type' => 'select',
            'is_required' => true,
            'is_filterable' => true,
            'is_active' => true,
            'position' => 1
        ]);

        // CPU Values
        $cpuValues = [
            ['value' => 'intel_i3', 'display_value' => 'Intel Core i3'],
            ['value' => 'intel_i5', 'display_value' => 'Intel Core i5'],
            ['value' => 'intel_i7', 'display_value' => 'Intel Core i7'],
            ['value' => 'intel_i9', 'display_value' => 'Intel Core i9'],
            ['value' => 'amd_ryzen_3', 'display_value' => 'AMD Ryzen 3'],
            ['value' => 'amd_ryzen_5', 'display_value' => 'AMD Ryzen 5'],
            ['value' => 'amd_ryzen_7', 'display_value' => 'AMD Ryzen 7'],
            ['value' => 'amd_ryzen_9', 'display_value' => 'AMD Ryzen 9'],
        ];

        foreach ($cpuValues as $value) {
            ProductAttributeValue::create([
                'product_attribute_id' => $cpuAttribute->id,
                'value' => $value['value'],
                'display_value' => $value['display_value']
            ]);
        }

        // RAM Attribute
        $ramAttribute = ProductAttribute::create([
            'name' => 'ram',
            'display_name' => 'RAM',
            'type' => 'select',
            'is_required' => true,
            'is_filterable' => true,
            'is_active' => true,
            'position' => 2
        ]);

        // RAM Values
        $ramValues = [
            ['value' => '8gb', 'display_value' => '8GB'],
            ['value' => '16gb', 'display_value' => '16GB'],
            ['value' => '32gb', 'display_value' => '32GB'],
            ['value' => '64gb', 'display_value' => '64GB'],
        ];

        foreach ($ramValues as $value) {
            ProductAttributeValue::create([
                'product_attribute_id' => $ramAttribute->id,
                'value' => $value['value'],
                'display_value' => $value['display_value']
            ]);
        }

        // SSD Attribute
        $ssdAttribute = ProductAttribute::create([
            'name' => 'ssd',
            'display_name' => 'SSD',
            'type' => 'select',
            'is_required' => true,
            'is_filterable' => true,
            'is_active' => true,
            'position' => 3
        ]);

        // SSD Values
        $ssdValues = [
            ['value' => '256gb', 'display_value' => '256GB'],
            ['value' => '512gb', 'display_value' => '512GB'],
            ['value' => '1tb', 'display_value' => '1TB'],
            ['value' => '2tb', 'display_value' => '2TB'],
        ];

        foreach ($ssdValues as $value) {
            ProductAttributeValue::create([
                'product_attribute_id' => $ssdAttribute->id,
                'value' => $value['value'],
                'display_value' => $value['display_value']
            ]);
        }
    }
}
