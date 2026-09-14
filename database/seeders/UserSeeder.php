<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();

        $users = [
            ['name' => 'Admin Demo', 'email' => 'admin@shophub.demo', 'phone' => '+84 901 111 111', 'role' => 'admin', 'status' => 'active'],
            ['name' => 'Minh Nguyen', 'email' => 'minh@shophub.demo', 'phone' => '+84 902 222 222', 'role' => 'manager', 'status' => 'active'],
            ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'phone' => '+84 903 333 333', 'role' => 'customer', 'status' => 'active'],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }
    }
}