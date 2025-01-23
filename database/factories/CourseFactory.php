<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User; // Assuming facultyID references the User model
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3), // Generate a 3-word title
            'description' => $this->faker->paragraph, // Generate a paragraph of text
            'facultyID' => User::inRandomOrder()->first()->id, // Create a related user and use its ID
            'isPublic' => $this->faker->boolean, // Random true/false value
            'createdAt' => now(), // Current timestamp
        ];
    }
}
