<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class; // Replace with the correct namespace of your User model

    public function definition()
    {

        return [
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'password' => bcrypt('password'), // Default password for testing
            'role' => $this->faker->randomElement(['admin', 'student', 'faculty', 'root']),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
