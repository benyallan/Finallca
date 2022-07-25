<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LancamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descricao' => $this->faker->word(),
            'valorTotal' => $this->faker->randomFloat(2, 0, 9999),
            'data' => $this->faker->date(),
            'obs' => $this->faker->sentence(6)
        ];
    }
}
