<?php

namespace Database\Factories;

use App\Models\Submission;
use App\Models\Assignment; // Assuming an Assignment model exists
use App\Models\User;  // Assuming a User model exists
use Illuminate\Database\Eloquent\Factories\Factory;

class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition()
    {
        return [
            // 'assignmentID' => Assignment::factory(), // Generates a related Assignment or null
            // 'studentID' => User::factory(), // Generates a related User
            'content' => $this->faker->text(200), // Random content up to 200 characters
            'filePath' => $this->faker->filePath(), // Random file path
            'submittedAt' => now(), // Current timestamp
            'grade' => $this->faker->optional()->randomFloat(2, 0, 100), // Random grade between 0-100 or null
        ];
    }

}
