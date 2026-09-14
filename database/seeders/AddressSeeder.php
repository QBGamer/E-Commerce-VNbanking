<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()?->id;

        DB::table('addresses')->delete();

        DB::table('addresses')->insert([
            [
                'user_id' => $userId,
                'full_name' => 'Admin Demo',
                'phone' => '+84 901 111 111',
                'address_line' => '123 Market Street, District 1',
                'city' => 'Ho Chi Minh City',
                'country' => 'Vietnam',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'full_name' => 'Admin Demo',
                'phone' => '+84 901 111 111',
                'address_line' => '45 Le Loi Street',
                'city' => 'Ho Chi Minh City',
                'country' => 'Vietnam',
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'full_name' => 'Jane Doe',
                'phone' => '+84 903 333 333',
                'address_line' => '77 Ba Trieu Street',
                'city' => 'Hanoi',
                'country' => 'Vietnam',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}