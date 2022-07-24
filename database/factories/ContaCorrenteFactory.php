<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContaCorrenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'banco' => $this->faker->company(),
            'agencia' => $this->faker->numerify('####-#'),
            'numero' => $this->faker->numerify('######-#'),
            'nome' => $this->faker->name(),
            'obs' => $this->faker->sentence(4),
            'saldo_inicial' => $this->faker->randomFloat(2, 0, 9999)
        ];
    }
}
