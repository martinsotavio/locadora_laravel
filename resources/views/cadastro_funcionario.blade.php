@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>
    </div>

    <div class="card" style="max-width:600px;margin:18px auto">
        <h2 style="margin-top: 0; color: #1f2937;">Cadastrar Novo Funcionário</h2>

        @if(session('sucesso'))
            <p class="sucesso">{{ session('sucesso') }}</p>
        @endif

        <form action="{{ route('funcionarios.salvar') }}" method="POST">
            @csrf
            
            <div class="form-section">
                <h3>Informações Pessoais</h3>
                
                <div class="form-group">
                    <label>Nome Completo:</label>
                    <input type="text" name="nome" required placeholder="Digite o nome completo">
                </div>

                <div class="form-group">
                    <label>CPF:</label>
                    <input type="text" name="cpf" placeholder="Apenas números" required>
                </div>

                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" placeholder="(00) 00000-0000">
                </div>

                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="email" name="email" placeholder="email@exemplo.com">
                </div>
            </div>

            <div class="form-section">
                <h3>Informações Profissionais</h3>
                
                <div class="form-group">
                    <label>Cargo:</label>
                    <select name="cargo" required>
                        <option value="">Selecione um cargo</option>
                        <option value="gerente">Gerente</option>
                        <option value="locador">Locador</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Salvar Funcionário</button>
            </div>
        </form>
    </div>
@endsection
