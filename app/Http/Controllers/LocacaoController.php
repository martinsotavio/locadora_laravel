<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Locacao;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\Comissao;

class LocacaoController extends Controller
{
    public function criar()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();

        return view('cadastro_locacao', compact('clientes', 'funcionarios'));
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'valor_diaria' => 'required|numeric|min:0',
        ]);

        $dias = Carbon::parse($request->data_inicio)->diffInDays(Carbon::parse($request->data_fim)) + 1;
        $valorTotal = round($dias * $request->valor_diaria, 2);
        $percent = 18;
        $valorComissao = round($valorTotal * ($percent / 100), 2);

        $locacao = Locacao::create([
            'cliente_id' => $request->cliente_id,
            'funcionario_id' => $request->funcionario_id,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'dias' => $dias,
            'valor_diaria' => $request->valor_diaria,
            'valor_total' => $valorTotal,
            'comissao_percent' => $percent,
            'valor_comissao' => $valorComissao,
            'status' => 'ativa',
        ]);

        Comissao::create([
            'locacao_id' => $locacao->id,
            'funcionario_id' => $request->funcionario_id,
            'valor' => $valorComissao,
        ]);

        return redirect()->back()->with('sucesso', 'Locação cadastrada com sucesso!');
    }

    public function listar()
    {
        $locacoes = Locacao::with(['cliente', 'funcionario'])->orderBy('created_at', 'desc')->get();

        return view('lista_locacoes', compact('locacoes'));
    }

    public function editar($id)
    {
        $locacao = Locacao::findOrFail($id);
        $clientes = Cliente::orderBy('nome')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();

        return view('editar_locacao', compact('locacao', 'clientes', 'funcionarios'));
    }

    public function atualizar(Request $request, $id)
    {
        $locacao = Locacao::findOrFail($id);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'valor_diaria' => 'required|numeric|min:0',
        ]);

        $dias = Carbon::parse($request->data_inicio)->diffInDays(Carbon::parse($request->data_fim)) + 1;
        $valorTotal = round($dias * $request->valor_diaria, 2);
        $percent = 18;
        $valorComissao = round($valorTotal * ($percent / 100), 2);

        $locacao->update([
            'cliente_id' => $request->cliente_id,
            'funcionario_id' => $request->funcionario_id,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'dias' => $dias,
            'valor_diaria' => $request->valor_diaria,
            'valor_total' => $valorTotal,
            'comissao_percent' => $percent,
            'valor_comissao' => $valorComissao,
            'status' => $request->status ?? $locacao->status,
        ]);

        if ($locacao->comissao) {
            $locacao->comissao->update(['valor' => $valorComissao, 'funcionario_id' => $request->funcionario_id]);
        } else {
            Comissao::create([
                'locacao_id' => $locacao->id,
                'funcionario_id' => $request->funcionario_id,
                'valor' => $valorComissao,
            ]);
        }

        return redirect()->route('locacoes.listar')->with('sucesso', 'Locação atualizada com sucesso!');
    }

    public function deletar($id)
    {
        $locacao = Locacao::findOrFail($id);
        $locacao->delete();

        return redirect()->back()->with('sucesso', 'Locação excluída com sucesso!');
    }
}
