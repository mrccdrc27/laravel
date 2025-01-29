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
         $numUsers = 34; // Number of users
         $numCourses = 7; // Number of courses
         $maxEnrollmentsPerUser = 7; // Max courses a user can enroll in
         $modulesPerCourse = 7; // Modules per course
         $assignmentsPerCourse = 7; // Assignments per course
         $submissionsPerStudent = 7; // Submissions per student
     
         $faker = Faker::create();

         User::factory()->count(1)->create([
            'role' => 'admin', // Setting the role to 'faculty'
            ]);
         $faculty = User::factory()->count(1)->create([
            'role' => 'faculty', // Setting the role to 'faculty'
        ]);



         // Generate Users
         $users = UserInfo::factory()->count($numUsers)->create();
     
         // Generate Courses
         $courses = Course::factory()->count($numCourses)->make()->each(function ($course) use ($faculty, $faker) {
             $course->facultyID = $faculty->random()->id;
             $course->title = $faker->words(3, true);
             $course->description = $faker->sentence();
             $course->save();
         });
     
         // Generate Enrollments
         $enrolledUsers = collect();
         $enrollments = [];
         foreach ($users as $user) {
             $availableCourses = $courses->shuffle()->take(rand(1, $maxEnrollmentsPerUser));
             foreach ($availableCourses as $course) {
                 $enrollmentKey = $user->userID . '-' . $course->courseID;
                 if (!$enrolledUsers->contains($enrollmentKey)) {
                     $enrolledUsers->push($enrollmentKey);
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
                     'content' => $faker->paragraph(),  // Adding meaningful content
                 ];
             }
         }
         DB::table('modules')->insert($modules);
     
         // Generate Assignments
         $assignments = [];
         foreach ($courses as $course) {
             for ($i = 0; $i < $assignmentsPerCourse; $i++) {
                 $assignments[] = [
                     'courseID' => $course->courseID,
                     'createdAt' => now(),
                     'updatedAt' => now(),
                     'title' => $faker->words(3, true),
                     'filePath' => 'files/' . $faker->word() . '.pdf',  // More realistic file path
                     'instructions' => $faker->realText($maxNbChars = 255, $indexSize = 2),
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
                 $submissionKey = $user->userID . '-' . $assignmentID;
                 if (!$submittedPairs->contains($submissionKey)) {
                     $submissions[] = [
                         'assignmentID' => $assignmentID,
                         'studentID' => $user->userID,
                         'submittedAt' => now(),
                         'content' => $faker->realText($maxNbChars = 255, $indexSize = 2),
                     ];
                     $submittedPairs->push($submissionKey);
                 }
             }
         }
         DB::table('submissions')->insert($submissions);
     }
     

}