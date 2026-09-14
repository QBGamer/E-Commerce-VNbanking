<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->delete();

        $products = [
            [
                'category_id' => 1,
                'name' => 'Wireless Bluetooth Mouse',
                'slug' => 'wireless-bluetooth-mouse',
                'sku' => 'SKU-001',
                'description' => 'A slim, ergonomic wireless mouse with silent clicks and up to 6 months of battery life.',
                'price' => 29.99,
                'old_price' => 39.99,
                'stock' => 120,
                'status' => 'active',
                'image' => 'https://placehold.co/600x600?text=Mouse',
                'badge' => 'Sale',
            ],
            [
                'category_id' => 2,
                'name' => 'Classic Denim Jacket',
                'slug' => 'classic-denim-jacket',
                'sku' => 'SKU-002',
                'description' => 'Timeless denim jacket crafted from durable cotton with a relaxed fit.',
                'price' => 59.99,
                'old_price' => null,
                'stock' => 35,
                'status' => 'active',
                'image' => 'https://placehold.co/600x600?text=Jacket',
                'badge' => 'Trending',
            ],
            [
                'category_id' => 3,
                'name' => 'Ceramic Coffee Mug Set',
                'slug' => 'ceramic-coffee-mug-set',
                'sku' => 'SKU-003',
                'description' => 'Set of 4 handmade ceramic coffee mugs, dishwasher and microwave safe.',
                'price' => 24.99,
                'old_price' => 34.99,
                'stock' => 8,
                'status' => 'active',
                'image' => 'https://placehold.co/600x600?text=Mug',
                'badge' => 'Low Stock',
            ],
            [
                'category_id' => 1,
                'name' => 'Mechanical Keyboard 87',
                'slug' => 'mechanical-keyboard-87',
                'sku' => 'SKU-004',
                'description' => 'Compact 87-key mechanical keyboard with hot-swappable switches and RGB backlight.',
                'price' => 89.99,
                'old_price' => null,
                'stock' => 0,
                'status' => 'active',
                'image' => 'https://placehold.co/600x600?text=Keyboard',
                'badge' => null,
            ],
        ];

        foreach ($products as $product) {
            $product['created_at'] = now();
            $product['updated_at'] = now();
            DB::table('products')->insert($product);
        }
    }
}