<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CarroFactory extends Factory
{
    public function definition()
    {
        // placa format: ABC-1234
        $placa = strtoupper($this->faker->bothify('???-####'));

        return [
            'placa' => $placa,
            'modelo' => $this->faker->word(),
            'marca' => $this->faker->company(),
            'ano' => $this->faker->numberBetween(2005, 2026),
            'cor' => $this->faker->safeColorName(),
            'valor_diaria' => $this->faker->randomFloat(2, 50, 400),
            'disponivel' => $this->faker->boolean(80),
        ];
    }
}
