<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create 10 example users
        User::create([
            'role' => 'admin',
            'username' => 'adminUser',
            'email' => 'admin@example.com',  // Add email here
            'password' => Hash::make('adminPassword123'),

            'last_login_at' => now(),
        ]);

        User::create([
            'role' => 'employee',
            'username' => 'employeeUser',
            'email' => 'employee@example.com',  // Add email here
            'password' => Hash::make('employeePassword123'),

            'last_login_at' => now(),
        ]);

        User::create([
            'role' => 'manager',
            'username' => 'managerUser',
            'email' => 'manager@example.com',  // Add email here
            'password' => Hash::make('managerPassword123'),

            'last_login_at' => now(),
        ]);

        User::create([
            'role' => 'admin',
            'username' => 'Adi',
            'email' => 'adibentulan@gmail.com',  // Add email here
            'password' => Hash::make('123'),

            'last_login_at' => now(),
        ]);

    }
}

