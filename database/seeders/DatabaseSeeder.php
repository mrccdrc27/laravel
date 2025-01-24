<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\Submission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInfo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create dummy users
        // UserInfo::factory()->count(2)->create();

        // Course::factory()->count(2)->create();
        // User::factory()->count( 2)->create();
        // Enrollment::factory()->count( 2)->create();
        // Assignment::factory()->count( 2)->create();
        // Submission::factory()->count( 2)->create();
        


        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            
        ]);
        
        
    }
}
