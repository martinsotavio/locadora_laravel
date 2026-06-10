@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>
    </div>

    <div class="card">
        <h2 style="margin-top: 0; color: #1f2937;">Cadastrar Novo Cliente</h2>

        @if(session('sucesso'))
            <p class="sucesso">{{ session('sucesso') }}</p>
        @endif

        <form action="{{ route('clientes.salvar') }}" method="POST">
            @csrf
            
            <div class="form-section">
                <h3>Informações Pessoais</h3>
                
                <div class="form-group">
                    <label>Nome Completo:</label>
                    <input type="text" name="nome" required placeholder="Ex: João Silva Santos">
                </div>

                <div class="form-group">
                    <label>CPF:</label>
                    <input type="text" name="cpf" placeholder="Apenas números" required>
                </div>

                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" placeholder="(00) 00000-0000">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Salvar Cliente</button>
            </div>
        </form>
    </div>
@endsection