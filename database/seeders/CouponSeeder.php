<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('coupons')->delete();

        DB::table('coupons')->insert([
            [
                'code' => 'WELCOME10',
                'type' => 'fixed',
                'value' => 10.00,
                'min_order' => 50.00,
                'max_uses' => 100,
                'used_count' => 12,
                'starts_at' => now()->subDays(7),
                'expires_at' => now()->addDays(30),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUMMER25',
                'type' => 'percent',
                'value' => 25.00,
                'min_order' => 30.00,
                'max_uses' => 200,
                'used_count' => 45,
                'starts_at' => now()->subDays(3),
                'expires_at' => now()->addDays(20),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EXPIRED10',
                'type' => 'fixed',
                'value' => 10.00,
                'min_order' => null,
                'max_uses' => 50,
                'used_count' => 50,
                'starts_at' => now()->subDays(30),
                'expires_at' => now()->subDays(1),
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}