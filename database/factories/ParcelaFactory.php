<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ParcelaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if ($this->faker->numberBetween(0,1) === 1) {
            $tipo = 'receita';
        } else {
            $tipo = 'despesa';
        }
        return [
            'tipo' => $tipo,
            'valor' => $this->faker->randomFloat(2, 0, 99),
            'data_vencimento' => $this->faker->date(),
            'numero' => 1,
            'total' => 1,
            'obs' => $this->faker->sentence(6)
        ];
    }
}
