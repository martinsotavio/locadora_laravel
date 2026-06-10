<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        // Explicit examples
        Cliente::updateOrCreate(
            ['cpf' => '22233344455'],
            [
                'nome' => 'Maria Silva',
                'telefone' => '(21) 98888-1111',
                'email' => 'maria.silva@example.com',
            ]
        );

        Cliente::updateOrCreate(
            ['cpf' => '33344455566'],
            [
                'nome' => 'João Pereira',
                'telefone' => '(21) 97777-2222',
                'email' => 'joao.pereira@example.com',
            ]
        );

        // More random
        Cliente::factory()->count(8)->create();
    }
}
