<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserInfoFactory extends Factory
{
    protected $model = \App\Models\UserInfo::class; // Replace with the correct namespace of your UserInfo model

    public function definition()
    {
        return [
            'firstName' => $this->faker->firstName,
            'middleName' => $this->faker->optional()->firstName,
            'lastName' => $this->faker->lastName,
            'birthDate' => $this->faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'sex' => $this->faker->boolean, // Randomly 0 or 1
            'nationality' => $this->faker->country,
            'birthPlace' => $this->faker->city,
            'createdAt' => now(),
            'updatedAt' => now(),
            'userID' => \App\Models\User::factory(), // Creates a user and assigns its ID
        ];
    }
}
