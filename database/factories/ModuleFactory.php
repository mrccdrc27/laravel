<?php

namespace Database\Factories;

use App\Models\Module;
use App\Models\Course; // Assuming a Course model exists
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    protected $model = Module::class;

    public function definition()
    {
        return [
            'courseID' => Course::inRandomOrder()->first()->id, // Generates a related Course
            'title' => $this->faker->sentence(3), // Random 3-word title
            'content' => $this->faker->paragraph(), // Random paragraph
            'filePath' => $this->faker->filePath(), // Random file path
            'createdAt' => now(), // Current timestamp
            'updatedAt' => now(), // Current timestamp
        ];
    }
}
