<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ingrediente;
use App\Models\Ristoratore;

class IngredienteFactory extends Factory
{
    protected $model = Ingrediente::class;
    public function definition()
    {
        return [
            'ristoratore' => Ristoratore::factory(),
            'nome' => $this->faker->word(),
        ];
    }
}
