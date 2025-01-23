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

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
    {

        // Step 1: Create a fixed number of Users
        $users = UserInfo::factory()->count(5)->create(); // Generate 10 users

        // assigns random courses to random users
        $courses = Course::factory()
            ->count(5)
            ->create() // Create courses and save to the database
            ->each(function ($course) use ($users) {
                // Assign a random facultyID from the existing users
                $course->facultyID = $users->random()->userID; // Assign random facultyID
                $course->save(); // Save the course after updating facultyID
            });

        // Step 3: Create a fixed number of Assignments linked to Courses
        $assignments = Assignment::factory()
            ->count(20)
            ->make() // Create instances without saving
            ->each(function ($assignment) use ($courses) {
                $assignment->courseID = $courses->random()->courseID; // Assign random course
                $assignment->save(); // Save to DB
            });

        // Step 4: Create Submissions linked to Assignments and Users
        Submission::factory()
            ->count(30)
            ->make() // Create instances without saving
            ->each(function ($submission) use ($assignments, $users) {
                $submission->assignmentID = $assignments->random()->assignmentID; // Random assignment
                $submission->studentID = $users->random()->id; // Random user
                $submission->save(); // Save to DB
            });
            
        Enrollment::factory()
        ->count(30)
        ->make() // Create instances without saving
        ->each(function ($enrollment) use ($courses, $users) {
            $enrollment->courseID = $courses->random()->courseID; // Random assignment
            $enrollment->studentID = $users->random()->id; // Random user
            $enrollment->save(); // Save to DB
        });

        Module::factory()
            ->count(10) // Adjust the number as needed
            ->make() // Create instances without saving
            ->each(function ($module) use ($courses) {
                $module->courseID = $courses->random()->courseID; // Assign random course
                $module->save(); // Save to DB
    });
    }
}
