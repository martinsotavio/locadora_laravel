<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Locacao;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\Carro;
use App\Models\Comissao;

/**
 * CRUD de Locações.
 *
 * Regra de negócio principal: um carro só pode estar vinculado a UMA
 * locação ativa por vez. Enquanto a locação estiver "ativa", o carro
 * fica com status "locado" e não aparece como opção para uma nova
 * locação. Ao finalizar ou excluir a locação, o carro volta a ficar
 * "disponivel".
 */
class LocacaoController extends Controller
{
    /** Percentual de comissão aplicado sobre o valor total da locação. */
    private const COMISSAO_PERCENT_PADRAO = 18;

    public function criar()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();

        // Só oferece para seleção os carros livres no momento do cadastro.
        $carros = Carro::where('status', Carro::STATUS_DISPONIVEL)->orderBy('placa')->get();

        return view('cadastro_locacao', compact('clientes', 'funcionarios', 'carros'));
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'carro_id' => 'required|exists:carros,placa',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'valor_diaria' => 'required|numeric|min:0',
        ]);

        $carro = Carro::where('placa', $request->carro_id)->firstOrFail();

        // Regra: carro já locado não pode ser locado novamente.
        if (! $carro->estaDisponivel()) {
            return back()->withInput()->withErrors([
                'carro_id' => 'Este carro já está locado e não pode ser reservado novamente.',
            ]);
        }

        $dias = Carbon::parse($request->data_inicio)->diffInDays(Carbon::parse($request->data_fim)) + 1;
        $valorTotal = round($dias * $request->valor_diaria, 2);
        $percent = self::COMISSAO_PERCENT_PADRAO;
        $valorComissao = round($valorTotal * ($percent / 100), 2);

        $locacao = Locacao::create([
            'cliente_id' => $request->cliente_id,
            'funcionario_id' => $request->funcionario_id,
            'carro_id' => $carro->placa,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'dias' => $dias,
            'valor_diaria' => $request->valor_diaria,
            'valor_total' => $valorTotal,
            'comissao_percent' => $percent,
            'valor_comissao' => $valorComissao,
            'status' => Locacao::STATUS_ATIVA,
        ]);

        Comissao::create([
            'locacao_id' => $locacao->id,
            'funcionario_id' => $request->funcionario_id,
            'valor' => $valorComissao,
        ]);

        // Enquanto a locação estiver ativa, o carro fica indisponível.
        $carro->marcarComoLocado();

        return redirect()->back()->with('sucesso', 'Locação cadastrada com sucesso!');
    }

    public function listar()
    {
        $locacoes = Locacao::with(['cliente', 'funcionario', 'carro'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('lista_locacoes', compact('locacoes'));
    }

    public function editar($id)
    {
        $locacao = Locacao::findOrFail($id);
        $clientes = Cliente::orderBy('nome')->get();
        $funcionarios = Funcionario::orderBy('nome')->get();

        // O carro já reservado por esta locação continua aparecendo na
        // lista de opções, mesmo estando "locado" (é o carro dela mesma).
        $carros = Carro::where('status', Carro::STATUS_DISPONIVEL)
            ->orWhere('placa', $locacao->carro_id)
            ->orderBy('placa')
            ->get();

        return view('editar_locacao', compact('locacao', 'clientes', 'funcionarios', 'carros'));
    }

    public function atualizar(Request $request, $id)
    {
        $locacao = Locacao::findOrFail($id);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'carro_id' => 'required|exists:carros,placa',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'valor_diaria' => 'required|numeric|min:0',
            'status' => 'nullable|in:ativa,finalizada',
        ]);

        $statusAnterior = $locacao->status;
        $carroAnterior = $locacao->carro;

        $novoCarro = Carro::where('placa', $request->carro_id)->firstOrFail();
        $novoStatus = $request->status ?? $statusAnterior;
        $trocouCarro = $locacao->carro_id !== $novoCarro->placa;

        // Só precisa validar disponibilidade quando o carro está "entrando"
        // em uso por esta locação agora (trocou de carro, ou está sendo
        // reativada). Se já era a mesma locação ativa com o mesmo carro,
        // não há nada novo para bloquear.
        $precisaChecarDisponibilidade = $novoStatus === Locacao::STATUS_ATIVA
            && ($trocouCarro || $statusAnterior !== Locacao::STATUS_ATIVA);

        if ($precisaChecarDisponibilidade && ! $novoCarro->estaDisponivel()) {
            return back()->withInput()->withErrors([
                'carro_id' => 'Este carro já está locado e não pode ser reservado novamente.',
            ]);
        }

        $dias = Carbon::parse($request->data_inicio)->diffInDays(Carbon::parse($request->data_fim)) + 1;
        $valorTotal = round($dias * $request->valor_diaria, 2);
        $percent = self::COMISSAO_PERCENT_PADRAO;
        $valorComissao = round($valorTotal * ($percent / 100), 2);

        $locacao->update([
            'cliente_id' => $request->cliente_id,
            'funcionario_id' => $request->funcionario_id,
            'carro_id' => $novoCarro->placa,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'dias' => $dias,
            'valor_diaria' => $request->valor_diaria,
            'valor_total' => $valorTotal,
            'comissao_percent' => $percent,
            'valor_comissao' => $valorComissao,
            'status' => $novoStatus,
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

        // Libera o carro anterior se ele foi substituído enquanto a locação
        // estava ativa (caso contrário ele já estava disponível).
        if ($trocouCarro && $carroAnterior && $statusAnterior === Locacao::STATUS_ATIVA) {
            $carroAnterior->marcarComoDisponivel();
        }

        // Sincroniza o estado do carro atual com o novo status da locação.
        if ($novoStatus === Locacao::STATUS_ATIVA) {
            $novoCarro->marcarComoLocado();
        } else {
            $novoCarro->marcarComoDisponivel();
        }

        return redirect()->route('locacoes.listar')->with('sucesso', 'Locação atualizada com sucesso!');
    }

    public function deletar($id)
    {
        $locacao = Locacao::findOrFail($id);
        $carro = $locacao->carro;
        $estavaAtiva = $locacao->status === Locacao::STATUS_ATIVA;

        $locacao->delete();

        // Excluir uma locação ativa libera o carro que estava ocupado por ela.
        if ($estavaAtiva && $carro) {
            $carro->marcarComoDisponivel();
        }

        return redirect()->back()->with('sucesso', 'Locação excluída com sucesso!');
    }
}
