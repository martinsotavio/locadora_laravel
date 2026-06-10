@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>
    </div>

        <section class="card" style="margin-top: 12px; padding: 20px;">
            <h2>Editar Locação</h2>

            <form action="{{ route('locacoes.atualizar', $locacao->id) }}" method="POST">
                @csrf

                <div class="form-section">
                    <h3>Informações da Locação</h3>
                    
                    <div class="form-group">
                        <label>Cliente:</label>
                        <select name="cliente_id" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $locacao->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }} ({{ $cliente->cpf }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Funcionário Responsável:</label>
                        <select name="funcionario_id" required>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario->id }}" {{ $locacao->funcionario_id == $funcionario->id ? 'selected' : '' }}>{{ $funcionario->nome }} ({{ $funcionario->cpf }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Período e Valor</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Data de Início:</label>
                            <input type="date" name="data_inicio" id="data_inicio" value="{{ $locacao->data_inicio }}" required min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label>Data de Fim:</label>
                            <input type="date" name="data_fim" id="data_fim" value="{{ $locacao->data_fim }}" required min="{{ $locacao->data_inicio }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Valor da Diária (R$):</label>
                        <input type="number" name="valor_diaria" step="0.01" min="0" value="{{ $locacao->valor_diaria }}" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="secondary">Salvar Alterações</button>
                </div>
            </form>
        </section>
@endsection
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
@endsection
