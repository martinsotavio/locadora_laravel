@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>
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

            <div class="form-section">
                <h3>Informações da Locação</h3>
                
                <div class="form-group">
                    <label>Cliente:</label>
                    <select name="cliente_id" required>
                        <option value="">Selecione o cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }} ({{ $cliente->cpf }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Funcionário Responsável:</label>
                    <select name="funcionario_id" required>
                        <option value="">Selecione o funcionário</option>
                        @foreach($funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->nome }} ({{ $funcionario->cpf }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Só lista carros com status "disponivel" (ver LocacaoController::criar). --}}
                <div class="form-group">
                    <label>Carro:</label>
                    <select name="carro_id" required>
                        <option value="">Selecione o carro disponível</option>
                        @foreach($carros as $carro)
                            <option value="{{ $carro->placa }}">{{ $carro->placa }} — {{ $carro->marca }} {{ $carro->modelo }}</option>
                        @endforeach
                    </select>
                    @if($carros->isEmpty())
                        <small style="color:#ef4444;">Nenhum carro disponível no momento.</small>
                    @endif
                </div>
            </div>

            {{-- dias, valor_total e valor_comissao são calculados no controller a partir destes campos. --}}
            <div class="form-section">
                <h3>Período e Valor</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label>Data de Início:</label>
                        <input type="date" name="data_inicio" id="data_inicio" required value="{{ old('data_inicio') }}" min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label>Data de Fim:</label>
                        <input type="date" name="data_fim" id="data_fim" required value="{{ old('data_fim') }}" min="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Valor da Diária (R$):</label>
                    <input type="number" name="valor_diaria" step="0.01" min="0" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Salvar Locação</button>
            </div>
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
@endsection
