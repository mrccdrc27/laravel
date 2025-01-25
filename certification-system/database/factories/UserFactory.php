<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'role' => $this->faker->randomElement(['admin', 'employee', 'manager']),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password123'), // Default password for seeding
            'is_active' => $this->faker->boolean,
            'last_login_at' => $this->faker->dateTime(),
        ];
    }
}

