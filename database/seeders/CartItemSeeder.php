<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartItemSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()?->id;

        DB::table('cart_items')->delete();

        DB::table('cart_items')->insert([
            ['user_id' => $userId, 'product_id' => 1, 'quantity' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $userId, 'product_id' => 3, 'quantity' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}