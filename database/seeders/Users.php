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
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{

        // Configurable values for scaling the seed data
        $numUsers = 25;  // Number of users
        $numCourses = 50; // Number of courses
        $maxEnrollmentsPerUser = 10; // Max courses a user can enroll in
        $modulesPerCourse = 1; // Modules per course
        $assignmentsPerCourse = 5; // Assignments per course
        $submissionsPerStudent = 50; // Submissions per student

        $faker = Faker::create();

        // Generate Users
        $users = UserInfo::factory()->count($numUsers)->create();

        // Generate Courses
        $courses = Course::factory()->count($numCourses)->make()->each(function ($course) use ($users) {
            $course->facultyID = $users->random()->userID;
            $course->save();
        });

        // Generate Enrollments
        $enrolledUsers = collect();
        $enrollments = [];
        foreach ($users as $user) {
            $availableCourses = $courses->shuffle()->take(rand(3, $maxEnrollmentsPerUser));
            foreach ($availableCourses as $course) {
                if (!$enrolledUsers->contains([$user->userID, $course->courseID])) {
                    $enrolledUsers->push([$user->userID, $course->courseID]);
                    $enrollments[] = [
                        'courseID' => $course->courseID,
                        'studentID' => $user->userID,
                        'enrolledAt' => now(),
                    ];
                }
            }
        }
        DB::table('enrollment')->insert($enrollments);

        // Generate Modules
        $modules = [];
        foreach ($courses as $course) {
            for ($i = 0; $i < $modulesPerCourse; $i++) {
                $modules[] = [
                    'courseID' => $course->courseID,
                    'createdAt' => now(),
                    'updatedAt' => now(),
                    'title' => $faker->words(3, true),
                ];
            }
        }
        DB::table('modules')->insert($modules);

        // Generate Assignments
        $assignments = [];
        $assignmentPairs = collect();
        foreach ($courses as $course) {
            for ($i = 0; $i < $assignmentsPerCourse; $i++) {
                $assignments[] = [
                    'courseID' => $course->courseID,
                    'createdAt' => now(),
                    'updatedAt' => now(),
                    'title' => $faker->words(3, true),
                    'filePath' => $faker->words(3, true),
                    'instructions' => $faker->sentence(),
                    'dueDate' => now()->addDays(rand(1, 30)),
                ];
            }
        }
        DB::table('assignments')->insert($assignments);

        // Generate Submissions
        $assignmentIds = DB::table('assignments')->pluck('assignmentID');
        $submittedPairs = collect();
        $submissions = [];
        foreach ($users as $user) {
            foreach ($assignmentIds->shuffle()->take(rand(1, $submissionsPerStudent)) as $assignmentID) {
                if (!$submittedPairs->contains([$user->userID, $assignmentID])) {
                    $submissions[] = [
                        'assignmentID' => $assignmentID,
                        'studentID' => $user->userID,
                        'submittedAt' => now(),
                    ];
                    $submittedPairs->push([$user->userID, $assignmentID]);
                }
            }
        }
        DB::table('submissions')->insert($submissions);
    }

}
