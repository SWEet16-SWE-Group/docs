<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail,
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
