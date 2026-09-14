<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->delete();

        DB::table('settings')->insert([
            ['key' => 'store_name', 'value' => 'Shoply', 'group' => 'store', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'store_tagline', 'value' => 'Everything you need, delivered.', 'group' => 'store', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'support_email', 'value' => 'support@shoply.demo', 'group' => 'store', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'support_phone', 'value' => '+84 900 000 000', 'group' => 'store', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'store_address', 'value' => '123 Market Street, District 1, Ho Chi Minh City', 'group' => 'store', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'payment_methods', 'value' => json_encode(['cod', 'card', 'paypal', 'momo']), 'group' => 'payment', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}