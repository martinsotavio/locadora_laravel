<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Carro;

class CarroCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_listar_carros_vacio()
    {
        $response = $this->actingAs($this->createUser())->get(route('carros.listar'));
        $response->assertStatus(200);
        $response->assertSee('Carros Cadastrados');
    }

    public function test_criar_editar_deletar_carro()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();
        $this->actingAs($user);

        // Criar
        $response = $this->post(route('carros.salvar'), [
            'placa' => 'TST-0001',
            'modelo' => 'Modelo Teste',
            'marca' => 'Marca Teste',
            'ano' => '2020',
            'cor' => 'Preto',
            'valor_diaria' => '123.45',
            'disponivel' => 'on',
        ]);

        $response->assertSessionHas('sucesso');
        $this->assertDatabaseHas('carros', ['placa' => 'TST-0001']);

        // Editar
        $response = $this->post(route('carros.atualizar', 'TST-0001'), [
            'placa' => 'TST-0001',
            'modelo' => 'Modelo Editado',
        ]);
        $response->assertRedirect(route('carros.listar'));
        $this->assertDatabaseHas('carros', ['placa' => 'TST-0001', 'modelo' => 'Modelo Editado']);

        // Deletar
        $response = $this->delete(route('carros.deletar', 'TST-0001'));
        $response->assertRedirect();
        $this->assertDatabaseMissing('carros', ['placa' => 'TST-0001']);
    }

    // helper: create a user with team if app uses teams; fallback to default user creation
    protected function createUser()
    {
        if (class_exists(\App\Models\User::class)) {
            return \App\Models\User::factory()->create();
        }

        return \App\Models\User::factory()->create();
    }
}
