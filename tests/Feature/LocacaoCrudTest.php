<?php

namespace Tests\Feature;

use App\Models\Carro;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\Locacao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocacaoCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_nao_permite_locar_carro_ja_locado()
    {
        $this->actingAs($this->createUser());

        $cliente = Cliente::factory()->create();
        $funcionario = Funcionario::factory()->create(['cargo' => 'locador']);
        $carro = Carro::factory()->create(['status' => Carro::STATUS_LOCADO]);

        $response = $this->post(route('locacoes.salvar'), [
            'cliente_id' => $cliente->id,
            'funcionario_id' => $funcionario->id,
            'carro_id' => $carro->placa,
            'data_inicio' => now()->addDay()->toDateString(),
            'data_fim' => now()->addDays(3)->toDateString(),
            'valor_diaria' => 100,
        ]);

        $response->assertSessionHasErrors('carro_id');
        $this->assertDatabaseCount('locacoes', 0);
    }

    public function test_criar_locacao_marca_carro_como_locado_e_gera_comissao()
    {
        $this->actingAs($this->createUser());

        $cliente = Cliente::factory()->create();
        $funcionario = Funcionario::factory()->create(['cargo' => 'locador']);
        $carro = Carro::factory()->create(['status' => Carro::STATUS_DISPONIVEL]);

        $response = $this->post(route('locacoes.salvar'), [
            'cliente_id' => $cliente->id,
            'funcionario_id' => $funcionario->id,
            'carro_id' => $carro->placa,
            'data_inicio' => now()->addDay()->toDateString(),
            'data_fim' => now()->addDays(3)->toDateString(),
            'valor_diaria' => 100,
        ]);

        $response->assertSessionHas('sucesso');
        $this->assertDatabaseHas('locacoes', [
            'carro_id' => $carro->placa,
            'status' => Locacao::STATUS_ATIVA,
        ]);
        $this->assertEquals(Carro::STATUS_LOCADO, $carro->refresh()->status);

        $locacao = Locacao::first();
        $this->assertDatabaseHas('comissoes', [
            'locacao_id' => $locacao->id,
            'funcionario_id' => $funcionario->id,
        ]);
    }

    public function test_deletar_locacao_libera_o_carro()
    {
        $this->actingAs($this->createUser());

        $cliente = Cliente::factory()->create();
        $funcionario = Funcionario::factory()->create(['cargo' => 'locador']);
        $carro = Carro::factory()->create(['status' => Carro::STATUS_DISPONIVEL]);

        $this->post(route('locacoes.salvar'), [
            'cliente_id' => $cliente->id,
            'funcionario_id' => $funcionario->id,
            'carro_id' => $carro->placa,
            'data_inicio' => now()->addDay()->toDateString(),
            'data_fim' => now()->addDays(2)->toDateString(),
            'valor_diaria' => 100,
        ]);

        $this->assertEquals(Carro::STATUS_LOCADO, $carro->refresh()->status);

        $locacao = Locacao::first();
        $response = $this->delete(route('locacoes.deletar', $locacao->id));

        $response->assertSessionHas('sucesso');
        $this->assertEquals(Carro::STATUS_DISPONIVEL, $carro->refresh()->status);
    }

    public function test_ranking_de_comissoes_ordena_por_total_desc_e_bonifica_o_lider()
    {
        $this->actingAs($this->createUser());

        $cliente = Cliente::factory()->create();
        $funcionarioLider = Funcionario::factory()->create(['cargo' => 'locador']);
        $funcionarioMenor = Funcionario::factory()->create(['cargo' => 'locador']);
        $carros = Carro::factory()->count(3)->create(['status' => Carro::STATUS_DISPONIVEL]);

        // Funcionário líder: duas locações somando R$ 144,00 de comissão (18%).
        $this->post(route('locacoes.salvar'), [
            'cliente_id' => $cliente->id,
            'funcionario_id' => $funcionarioLider->id,
            'carro_id' => $carros[0]->placa,
            'data_inicio' => now()->toDateString(),
            'data_fim' => now()->addDays(2)->toDateString(), // 3 diárias
            'valor_diaria' => 200,
        ]);
        $this->post(route('locacoes.salvar'), [
            'cliente_id' => $cliente->id,
            'funcionario_id' => $funcionarioLider->id,
            'carro_id' => $carros[1]->placa,
            'data_inicio' => now()->toDateString(),
            'data_fim' => now()->addDays(1)->toDateString(), // 2 diárias
            'valor_diaria' => 100,
        ]);

        // Funcionário com comissão menor: uma locação de R$ 9,00.
        $this->post(route('locacoes.salvar'), [
            'cliente_id' => $cliente->id,
            'funcionario_id' => $funcionarioMenor->id,
            'carro_id' => $carros[2]->placa,
            'data_inicio' => now()->toDateString(),
            'data_fim' => now()->toDateString(), // 1 diária
            'valor_diaria' => 50,
        ]);

        $response = $this->get(route('funcionarios.listar'));
        $response->assertStatus(200);

        $funcionarios = $response->viewData('funcionarios');

        $this->assertEquals($funcionarioLider->id, $funcionarios->first()->id);
        $this->assertEquals(144.0, $funcionarios->first()->total_comissao);
        $this->assertEquals(7.2, $funcionarios->first()->bonus);

        $ultimo = $funcionarios->firstWhere('id', $funcionarioMenor->id);
        $this->assertEquals(9.0, $ultimo->total_comissao);
        $this->assertEquals(0, $ultimo->bonus);
    }

    protected function createUser()
    {
        return \App\Models\User::factory()->create();
    }
}
