<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@dutaauto.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Staff
        User::create([
            'name' => 'Staff',
            'email' => 'staff@dutaauto.com',
            'password' => bcrypt('staff123'),
            'role' => 'staff',
        ]);

        // User Biasa
        User::create([
            'name' => 'User',
            'email' => 'user@dutaauto.com',
            'password' => bcrypt('user123'),
            'role' => 'user',
        ]);
    }
}
