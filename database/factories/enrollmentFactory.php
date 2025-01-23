<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\Course; // Assuming a Course model exists
use App\Models\User;  // Assuming a User model exists
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition()
    {
        return [
            'courseID' => Course::inRandomOrder()->first()->id,
            // 'studentID' => User::factory(), // Generates a related User
            'enrolledAt' => now(), // Current timestamp
            'isActive' => $this->faker->boolean(90), // 90% chance of being true
        ];
    }
}
