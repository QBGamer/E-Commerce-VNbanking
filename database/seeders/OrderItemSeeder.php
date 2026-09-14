<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->delete();

        $items = [
            ['order_id' => 1, 'product_id' => 4, 'product_name' => 'Mechanical Keyboard 87', 'product_image' => 'https://placehold.co/600x600?text=Keyboard', 'price' => 89.99, 'quantity' => 1, 'subtotal' => 89.99],
            ['order_id' => 2, 'product_id' => 2, 'product_name' => 'Classic Denim Jacket', 'product_image' => 'https://placehold.co/600x600?text=Jacket', 'price' => 59.99, 'quantity' => 1, 'subtotal' => 59.99],
            ['order_id' => 3, 'product_id' => 3, 'product_name' => 'Ceramic Coffee Mug Set', 'product_image' => 'https://placehold.co/600x600?text=Mug', 'price' => 24.99, 'quantity' => 1, 'subtotal' => 24.99],
        ];

        foreach ($items as $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            DB::table('order_items')->insert($item);
        }
    }
}