<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()?->id;

        DB::table('orders')->delete();

        $address = [
            'full_name' => 'Jane Doe',
            'phone' => '+84 903 333 333',
            'address_line' => '77 Ba Trieu Street',
            'city' => 'Hanoi',
            'country' => 'Vietnam',
        ];

        DB::table('orders')->insert([
            [
                'order_number' => 'ORD-1001',
                'user_id' => $userId,
                'coupon_id' => null,
                'subtotal' => 89.99,
                'discount' => 0,
                'total' => 89.99,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'processing',
                'shipping_address' => json_encode($address),
                'notes' => null,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(2),
            ],
            [
                'order_number' => 'ORD-1002',
                'user_id' => $userId,
                'coupon_id' => 1,
                'subtotal' => 59.99,
                'discount' => 10.00,
                'total' => 49.99,
                'payment_method' => 'card',
                'payment_status' => 'paid',
                'status' => 'shipped',
                'shipping_address' => json_encode($address),
                'notes' => 'Leave at the front desk.',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(1),
            ],
            [
                'order_number' => 'ORD-1003',
                'user_id' => $userId,
                'coupon_id' => null,
                'subtotal' => 24.99,
                'discount' => 0,
                'total' => 24.99,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'pending',
                'shipping_address' => json_encode($address),
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}