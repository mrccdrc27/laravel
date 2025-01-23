<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Course; // Assuming a Course model exists
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition()
    {
        return [
            'courseID' => Course::inRandomOrder()->first()->id, // Generates a related Course
            'title' => $this->faker->sentence(4), // Random 4-word title
            'filePath' => $this->faker->filePath(), // Random file path or null
            'instructions' => $this->faker->sentence(4), // Random 4-word title
            'dueDate' => $this->faker->dateTimeBetween('+1 week', '+1 month'), // Random future date
            'createdAt' => now(), // Current timestamp
        ];
    }

}
