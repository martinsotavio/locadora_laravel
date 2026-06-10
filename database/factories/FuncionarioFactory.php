<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioFactory extends Factory
{
    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => preg_replace('/\D/', '', $this->faker->numerify('###########')),
            'telefone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'cargo' => $this->faker->randomElement(['gerente', 'locador']),
        ];
    }
}
