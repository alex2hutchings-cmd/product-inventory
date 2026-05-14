<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use App\Models\Promotion;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::create([
            'name' => 'Electronics',
        ]);

        $accessories = Category::create([
            'name' => 'Accessories',
        ]);

        $products = [
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical keyboard.',
                'base_price' => 89.99,
                'image' => '/storage/products/keyboard.jpg',
                'category_id' => $electronics->id,
            ],
            [
                'name' => 'Gaming Mouse',
                'description' => 'Wireless gaming mouse.',
                'base_price' => 49.99,
                'image' => '/storage/products/mouse.jpg',
                'category_id' => $electronics->id,
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Adjustable aluminium stand.',
                'base_price' => 39.99,
                'image' => '/storage/products/stand.jpg',
                'category_id' => $accessories->id,
            ],
            [
                'name' => 'USB-C Dock',
                'description' => 'Docking station.',
                'base_price' => 79.99,
                'image' => '/storage/products/dock.jpg',
                'category_id' => $accessories->id,
            ],

            [
                'name' => 'HD Monitor',
                'description' => '27 inch monitor.',
                'base_price' => 199.99,
                'image' => '/storage/products/monitor.jpg',
                'category_id' => $electronics->id,
            ],
        ];

        foreach ($products as $productData) {

            $image = Image::create([
                'path' => $productData['image'],
            ]);

            Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'base_price' => $productData['base_price'],
                'image_id' => $image->id,
                'category_id' => $productData['category_id'],
            ]);
        }

        Promotion::create([
            'name' => 'Electronics Sale',
            'value' => 10,
            'discount_type' => 'flat',
            'promotable_id' => $electronics->id,
            'promotable_type' => Category::class,
        ]);

        $monitor = Product::where('name', 'HD Monitor')->first();

        Promotion::create([
            'name' => 'Monitor Discount',
            'value' => 15,
            'discount_type' => 'percentage',
            'promotable_id' => $monitor->id,
            'promotable_type' => Product::class,
        ]);
    }
}