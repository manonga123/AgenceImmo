<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            
            [
                'first_name' => 'Admin',
                'last_name' => 'System',
                'email' => 'admin@admin.com',
                'phone' => '0340000000',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'first_name' => 'user',
                'last_name' => 'user',
                'email' => 'user@user.com',
                'phone' => '0341111111',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'first_name' => 'owener',
                'last_name' => 'Rabe',
                'email' => 'owner@owner.com',
                'phone' => '0342222222',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}