<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarteiraFactory extends Factory
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
            'saldo_inicial' => $this->faker->randomFloat(2, 0, 9999)
        ];
    }
}
