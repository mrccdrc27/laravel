<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or find the admin user
        $admin = User::updateOrCreate(
            ['email' => 'student@example.com'], // Search criteria
            [
                'role' => 'student', // Set the role column to 'admin'
                'email_verified_at' => now(),
                'password' => bcrypt('password'), // Hash the password
                'remember_token' => Str::random(10),
            ]
        );

        // Create or update the associated userinfo entry
        DB::table('users_info')->updateOrInsert(
            ['userID' => $admin->id], // Foreign key to the users table
            [
                'firstName' => 'core', // Example fields
                'lastName' => 'The student',
                'birthPlace' => 'Test',
                'nationality' => 'Only',
                'birthDate' => '2000-01-01',
                'sex' => true,
                'createdAt' => now(),
                'updatedAt' => now(),
            ]
        );

        //$this->command->info('Admin account and userinfo created or updated.');
    }
}
