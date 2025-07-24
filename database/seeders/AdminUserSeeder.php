<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        User::updateOrCreate(
            [
                'email' => 'admin@terraserve.com',
            ],
            [
                'name' => 'Admin Terraserve',
                'username' => 'adminterraserve',
                'phone' => '081234567890',
                'password' => Hash::make('123'),
                'roles' => 'ADMIN',
            ]
        );
    }
}