<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=UserSeeder

     */
    public function run(): void
    {
        // Option 1: Create one user manually
        User::create([
            'name' => 'Admin',
            'user_name' => 'Admin',
            'role_id' => '1',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin2023'),
        ]);
    }
}
