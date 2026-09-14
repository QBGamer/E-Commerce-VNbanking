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
            ['product_id' => 2, 'image' => 'https://placehold.co/600x600?text=Jacket-1', 'position' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'image' => 'https://placehold.co/600x600?text=Mug-1', 'position' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}