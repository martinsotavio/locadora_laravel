@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>

        <div class="card">
            <h2 style="margin-top: 0; color: #1f2937;">Locações</h2>

            @if(session('sucesso'))
                <p class="sucesso">{{ session('sucesso') }}</p>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Funcionário</th>
                        <th>Carro</th>
                        <th>Período</th>
                        <th>Diárias</th>
                        <th>Valor total</th>
                        <th>Comissão (18%)</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Carregada com eager loading (cliente, funcionario, carro) no controller para evitar consultas N+1. --}}
                    @foreach($locacoes as $locacao)
                        <tr>
                            <td>{{ $locacao->cliente->nome }}<br><small>{{ $locacao->cliente->cpf }}</small></td>
                            <td>{{ $locacao->funcionario->nome }}<br><small>{{ $locacao->funcionario->cpf }}</small></td>
                            <td>{{ $locacao->carro->placa ?? '—' }}<br><small>{{ $locacao->carro->marca ?? '' }} {{ $locacao->carro->modelo ?? '' }}</small></td>
                            <td>{{ $locacao->data_inicio }} até {{ $locacao->data_fim }}</td>
                            <td>{{ $locacao->dias }}</td>
                            <td>R$ {{ number_format($locacao->valor_total, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($locacao->valor_comissao, 2, ',', '.') }}</td>
                            <td>{{ ucfirst($locacao->status) }}</td>
                            <td>
                                <a href="{{ route('locacoes.editar', $locacao->id) }}" class="btn-editar">Editar</a>
                                <form action="{{ route('locacoes.deletar', $locacao->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar esta locação?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-deletar">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($locacoes->isEmpty())
                        <tr>
                            <td colspan="9" style="text-align: center; color: #6b7280;">Nenhuma locação cadastrada ainda.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div style="margin-top:16px;">
                {{ $locacoes->links() }}
            </div>
        </div>
    </div>
@endsection
