<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()?->id;

        DB::table('product_reviews')->delete();

        DB::table('product_reviews')->insert([
            ['product_id' => 1, 'user_id' => $userId, 'rating' => 5, 'comment' => 'Great mouse, very quiet clicks and comfortable.', 'status' => 'approved', 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'user_id' => $userId, 'rating' => 4, 'comment' => 'Works well on all surfaces.', 'status' => 'approved', 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'user_id' => $userId, 'rating' => 5, 'comment' => 'Nice fit and durable material.', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}