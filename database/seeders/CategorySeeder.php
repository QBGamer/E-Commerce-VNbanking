<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Gadgets, accessories and smart devices.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Clothing, footwear and accessories.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Home & Living', 'slug' => 'home-living', 'description' => 'Furniture, decor and kitchenware.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}