<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInfo;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Check if the admin user already exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Replace with your desired admin email
            [
                'password' => bcrypt('password123'), // Use a secure password
                'email_verified_at' => now(), // Mark email as verified
            ]
        );
         // Assign the admin role to the user
         $admin->assignRole($adminRole);

         // Create or update the associated userinfo entry
         DB::table('users_info')->updateOrInsert(
             ['UserID' => $admin->id], // Foreign key to the users table
             [
                 'FirstName' => 'John', // Example fields
                 'LastName' => 'The Admin',
                 'BirthPlace' => 'Test',
                 'Nationality' => 'Only',
                 'BirthDate' => '1990-01-01', 
                 'Sex' => true,
                 'CreatedAt' => now(),
                 'UpdatedAt' => now(),
             ]
         );
 
         $this->command->info('Admin account and userinfo created or updated.');
    }
}
