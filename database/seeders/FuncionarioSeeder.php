<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use Illuminate\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        // Explicit examples
        Funcionario::updateOrCreate(
            ['cpf' => '44455566677'],
            [
                'nome' => 'Carlos Alberto',
                'telefone' => '(21) 99999-0001',
                'email' => 'carlos.alberto@example.com',
                'cargo' => 'gerente',
            ]
        );

        Funcionario::updateOrCreate(
            ['cpf' => '55566677788'],
            [
                'nome' => 'Ana Beatriz',
                'telefone' => '(21) 97777-0002',
                'email' => 'ana.beatriz@example.com',
                'cargo' => 'locador',
            ]
        );

        // Additional random (guard against duplicates by ensuring unique cpf)
        Funcionario::factory()->count(6)->create();
    }
}
