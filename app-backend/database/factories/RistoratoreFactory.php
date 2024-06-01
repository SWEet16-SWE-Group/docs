<?php

namespace Database\Factories;

use App\Models\Ristoratore;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RistoratoreFactory extends Factory
{
    protected $model = Ristoratore::class;

    public function definition()
    {
        return [
            'user' => User::factory(),
            'nome' => $this->faker->unique()->company,
            'indirizzo' => $this->faker->unique()->address,
            'telefono' => $this->faker->unique()->numerify('##########'),
            'capienza' => $this->faker->numberBetween(10, 200),
            'orario' => '19:30 - 22:30'
        ];
    }
}
