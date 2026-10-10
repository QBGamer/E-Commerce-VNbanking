<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_images')->delete();

        DB::table('product_images')->insert([
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-1', 'position' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-2', 'position' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-3', 'position' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-4', 'position' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-5', 'position' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-6', 'position' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-7', 'position' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-8', 'position' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-9', 'position' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image' => 'https://placehold.co/600x600?text=Mouse-10', 'position' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'image' => 'https://placehold.co/600x600?text=Jacket-1', 'position' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'image' => 'https://placehold.co/600x600?text=Mug-1', 'position' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
