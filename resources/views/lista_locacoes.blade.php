<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Locações</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .container { max-width: 1000px; margin: 0 auto; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f3f4f6; color: #374151; }
        .sucesso { color: green; font-weight: bold; padding: 10px; background-color: #dcfce7; border-radius: 4px; margin-bottom: 15px; }
        .btn-voltar { display: inline-block; margin-bottom: 20px; color: #4b5563; text-decoration: none; font-size: 14px; font-weight: bold; }
        .btn-voltar:hover { color: #111827; }
        .btn-editar { background-color: #eab308; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px; margin-right: 5px; }
        .btn-deletar { background-color: #ef4444; color: white; padding: 6px 12px; border: none; border-radius: 4px; font-weight: bold; font-size: 13px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="container">
        <a href="/dashboard" class="btn-voltar">Voltar para o Dashboard</a>

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
                        <th>Período</th>
                        <th>Diárias</th>
                        <th>Valor total</th>
                        <th>Comissão (18%)</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locacoes as $locacao)
                        <tr>
                            <td>{{ $locacao->cliente->nome }}<br><small>{{ $locacao->cliente->cpf }}</small></td>
                            <td>{{ $locacao->funcionario->nome }}<br><small>{{ $locacao->funcionario->cpf }}</small></td>
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
                            <td colspan="8" style="text-align: center; color: #6b7280;">Nenhuma locação cadastrada ainda.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
