<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Locação</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .card { background: white; padding: 20px; border-radius: 8px; max-width: 520px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin: 0 auto; }
        label { font-weight: bold; display: block; margin-top: 10px; color: #374151; }
        input, select { width: 100%; padding: 10px; margin: 6px 0 14px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        button { background-color: #eab308; color: white; padding: 12px; border: none; border-radius: 4px; width: 100%; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; }
        button:hover { background-color: #ca8a04; }
        .btn-voltar { display: inline-block; margin-bottom: 20px; color: #4b5563; text-decoration: none; font-size: 14px; font-weight: bold; }
        .btn-voltar:hover { color: #111827; }
    </style>
</head>
<body>

    <div style="max-width: 520px; margin: 0 auto;">
        <a href="{{ route('locacoes.listar') }}" class="btn-voltar">Voltar para a Lista</a>
    </div>

    <div class="card">
        <h2 style="margin-top: 0; color: #1f2937;">Editar Locação</h2>

        <form action="{{ route('locacoes.atualizar', $locacao->id) }}" method="POST">
            @csrf

            <label>Cliente:</label>
            <select name="cliente_id" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $locacao->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }} ({{ $cliente->cpf }})</option>
                @endforeach
            </select>

            <label>Funcionário:</label>
            <select name="funcionario_id" required>
                @foreach($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}" {{ $locacao->funcionario_id == $funcionario->id ? 'selected' : '' }}>{{ $funcionario->nome }} ({{ $funcionario->cpf }})</option>
                @endforeach
            </select>

            <label>Data de início:</label>
            <input type="date" name="data_inicio" id="data_inicio" value="{{ $locacao->data_inicio }}" required min="{{ date('Y-m-d') }}">

            <label>Data de fim:</label>
            <input type="date" name="data_fim" id="data_fim" value="{{ $locacao->data_fim }}" required min="{{ $locacao->data_inicio }}">

            <label>Valor da diária (R$):</label>
            <input type="number" name="valor_diaria" step="0.01" min="0" value="{{ $locacao->valor_diaria }}" required>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>

    <script>
        const inicio = document.getElementById('data_inicio');
        const fim = document.getElementById('data_fim');

        if (inicio && fim) {
            inicio.addEventListener('change', () => {
                fim.min = inicio.value;
                if (fim.value && fim.value < inicio.value) {
                    fim.value = inicio.value;
                }
            });
        }
    </script>
</body>
</html>
