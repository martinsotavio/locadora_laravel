<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Locação</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .card { background: white; padding: 20px; border-radius: 8px; max-width: 520px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin: 0 auto; }
        label { font-weight: bold; display: block; margin-top: 10px; color: #374151; }
        input, select { width: 100%; padding: 10px; margin: 6px 0 14px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        button { background-color: #2563eb; color: white; padding: 12px; border: none; border-radius: 4px; width: 100%; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; }
        button:hover { background-color: #1d4ed8; }
        .sucesso { color: green; font-weight: bold; margin-bottom: 15px; padding: 10px; background-color: #dcfce7; border-radius: 4px; }
        .erros { color: #b91c1c; margin-bottom: 15px; padding: 10px; background-color: #fee2e2; border-radius: 4px; }
        .btn-voltar { display: inline-block; margin-bottom: 20px; color: #4b5563; text-decoration: none; font-size: 14px; font-weight: bold; }
        .btn-voltar:hover { color: #111827; }
    </style>
</head>
<body>

    <div style="max-width: 520px; margin: 0 auto;">
        <a href="/dashboard" class="btn-voltar">Voltar para o Dashboard</a>
    </div>

    <div class="card">
        <h2 style="margin-top: 0; color: #1f2937;">Cadastrar Nova Locação</h2>

        @if(session('sucesso'))
            <p class="sucesso">{{ session('sucesso') }}</p>
        @endif

        @if($errors->any())
            <div class="erros">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('locacoes.salvar') }}" method="POST">
            @csrf

            <label>Cliente:</label>
            <select name="cliente_id" required>
                <option value="">Selecione o cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nome }} ({{ $cliente->cpf }})</option>
                @endforeach
            </select>

            <label>Funcionário:</label>
            <select name="funcionario_id" required>
                <option value="">Selecione o funcionário</option>
                @foreach($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}">{{ $funcionario->nome }} ({{ $funcionario->cpf }})</option>
                @endforeach
            </select>

            <label>Data de início:</label>
            <input type="date" name="data_inicio" id="data_inicio" required value="{{ old('data_inicio') }}" min="{{ date('Y-m-d') }}">

            <label>Data de fim:</label>
            <input type="date" name="data_fim" id="data_fim" required value="{{ old('data_fim') }}" min="{{ date('Y-m-d') }}">

            <label>Valor da diária (R$):</label>
            <input type="number" name="valor_diaria" step="0.01" min="0" required>

            <button type="submit">Salvar Locação</button>
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
