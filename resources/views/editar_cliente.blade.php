@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>
    </div>

    <div class="card">
        <h2 style="margin-top: 0; color: #1f2937;"> Editar Dados do Cliente</h2>

        <form action="{{ route('clientes.atualizar', $cliente->id) }}" method="POST">
            @csrf
            
            <div class="form-section">
                <h3>Informações Pessoais</h3>
                
                <div class="form-group">
                    <label>Nome Completo:</label>
                    <input type="text" name="nome" value="{{ $cliente->nome }}" required>
                </div>

                <div class="form-group">
                    <label>CPF:</label>
                    <input type="text" name="cpf" value="{{ $cliente->cpf }}" required>
                </div>

                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" value="{{ $cliente->telefone }}">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="secondary">Salvar Alterações</button>
            </div>
        </form>
    </div>
@endsection