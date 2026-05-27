<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Funcionários - Locadora</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .container { max-width: 900px; margin: 0 auto; }
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
        <a href="javascript:history.back()" class="btn-voltar">Voltar para o Dashboard</a>

        <div class="card">
            <h2 style="margin-top: 0; color: #1f2937;">Funcionários Cadastrados</h2>

            @if(session('sucesso'))
                <p class="sucesso">{{ session('sucesso') }}</p>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Cargo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($funcionarios as $funcionario)
                        <tr>
                            <td>{{ $funcionario->nome }}</td>
                            <td>{{ $funcionario->cpf }}</td>
                            <td>{{ $funcionario->telefone ?? 'Não informado' }}</td>
                            <td>{{ $funcionario->email ?? 'Não informado' }}</td>
                            <td>{{ $funcionario->cargo ?? 'Não informado' }}</td>
                            <td>
                                @if($funcionario->cargo === 'gerente')
                                    <a href="{{ route('funcionarios.editar', $funcionario->id) }}" class="btn-editar">Editar</a>
                                    <form action="{{ route('funcionarios.deletar', $funcionario->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar este funcionário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-deletar">Deletar</button>
                                    </form>
                                @else
                                    <span style="color: #6b7280; font-size: 13px;">Somente listagem</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if($funcionarios->isEmpty())
                        <tr>
                            <td colspan="6" style="text-align: center; color: #6b7280;">Nenhum funcionário cadastrado ainda.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
