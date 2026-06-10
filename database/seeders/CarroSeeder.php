<?php

namespace Database\Seeders;

use App\Models\Carro;
use Illuminate\Database\Seeder;

class CarroSeeder extends Seeder
{
    public function run(): void
    {
        // Some explicit examples
        Carro::updateOrCreate(
            ['placa' => 'ABC-0001'],
            [
                'modelo' => 'Punto',
                'marca' => 'Fiat',
                'ano' => 2018,
                'cor' => 'prata',
                'valor_diaria' => 120.00,
                'disponivel' => true,
            ]
        );

        Carro::updateOrCreate(
            ['placa' => 'XYZ-2020'],
            [
                'modelo' => 'Civic',
                'marca' => 'Honda',
                'ano' => 2020,
                'cor' => 'preto',
                'valor_diaria' => 250.00,
                'disponivel' => true,
            ]
        );

        // Generate additional random cars
        Carro::factory()->count(6)->create();
    }
}
