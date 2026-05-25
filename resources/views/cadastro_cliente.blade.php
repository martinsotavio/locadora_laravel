<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 40px; 
            background-color: #f4f4f9; 
        }
        .card { 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            max-width: 400px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
            margin: 0 auto; 
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #374151;
        }
        input { 
            width: 100%; 
            padding: 10px; 
            margin: 6px 0 14px 0; 
            box-sizing: border-box; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            font-size: 14px;
        }
        button { 
            background-color: #2563eb; 
            color: white; 
            padding: 12px; 
            border: none; 
            border-radius: 4px; 
            width: 100%; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
            margin-top: 10px;
        }
        button:hover { 
            background-color: #1d4ed8; 
        }
        .sucesso { 
            color: green; 
            font-weight: bold; 
            margin-bottom: 15px; 
            padding: 10px;
            background-color: #dcfce7;
            border-radius: 4px;
        }
        .btn-voltar { 
            display: inline-block; 
            margin-bottom: 20px; 
            color: #4b5563; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: bold; 
        }
        .btn-voltar:hover { 
            color: #111827; 
        }
    </style>
</head>
<body>

    <div style="max-width: 400px; margin: 0 auto;">
        <a href="javascript:history.back()" class="btn-voltar"> Voltar para o Dashboard</a>
    </div>

    <div class="card">
        <h2 style="margin-top: 0; color: #1f2937;">Cadastrar Novo Cliente</h2>

        @if(session('sucesso'))
            <p class="sucesso">✅ {{ session('sucesso') }}</p>
        @endif

        <form action="{{ route('clientes.salvar') }}" method="POST">
            @csrf
            
            <label>Nome:</label>
            <input type="text" name="nome" required placeholder="Digite o nome completo">

            <label>CPF:</label>
            <input type="text" name="cpf" placeholder="Apenas números" required>

            <label>Telefone:</label>
            <input type="text" name="telefone" placeholder="(00) 00000-0000">

            <button type="submit">Salvar Cliente</button>
        </form>
    </div>

</body>
</html>