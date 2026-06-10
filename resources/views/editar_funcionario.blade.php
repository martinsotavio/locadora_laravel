@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>
    </div>

    <div class="card">
        <h2 style="margin-top: 0; color: #1f2937;">Editar Dados do Funcionário</h2>

        <form action="{{ route('funcionarios.atualizar', $funcionario->id) }}" method="POST">
            @csrf

            <div class="form-section">
                <h3>Informações Pessoais</h3>
                
                <div class="form-group">
                    <label>Nome Completo:</label>
                    <input type="text" name="nome" value="{{ $funcionario->nome }}" required>
                </div>

                <div class="form-group">
                    <label>CPF:</label>
                    <input type="text" name="cpf" value="{{ $funcionario->cpf }}" required>
                </div>

                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" value="{{ $funcionario->telefone }}">
                </div>

                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="email" name="email" value="{{ $funcionario->email }}">
                </div>
            </div>

            <div class="form-section">
                <h3>Informações Profissionais</h3>
                
                <div class="form-group">
                    <label>Cargo:</label>
                    <select name="cargo" required>
                        <option value="gerente" {{ $funcionario->cargo === 'gerente' ? 'selected' : '' }}>Gerente</option>
                        <option value="locador" {{ $funcionario->cargo === 'locador' ? 'selected' : '' }}>Locador</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="secondary">Salvar Alterações</button>
            </div>
        </form>
    </div>
@endsection
