<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pietanza;
use App\Models\Ristoratore;

class PietanzaFactory extends Factory
{
    protected $model = Pietanza::class;
    public function definition()
    {
        return [
            'ristoratore' => Ristoratore::factory(),
            'nome' => $this->faker->word(),
        ];
    }
}
