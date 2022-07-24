<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartaoCreditoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'dia_fechamento' => $this->faker->numberBetween(1,29),
            'dia_vencimento' => $this->faker->numberBetween(1,29)
        ];
    }
}
