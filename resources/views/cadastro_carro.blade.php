@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>
    </div>

    <div class="card" style="max-width:700px;margin:18px auto">
        <h2 style="margin-top: 0; color: #1f2937;">Cadastrar Novo Carro</h2>

        @if(session('sucesso'))
            <p class="sucesso">{{ session('sucesso') }}</p>
        @endif

        <form action="{{ route('carros.salvar') }}" method="POST">
            @csrf

            <div class="form-section">
                <h3>Informações do Veículo</h3>
                
                <div class="form-group">
                    <label>Placa:</label>
                    <input type="text" name="placa" required placeholder="ABC-1234"> 
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Marca:</label>
                        <input type="text" name="marca" placeholder="Marca do veículo"> 
                    </div>

                    <div class="form-group">
                        <label>Modelo:</label>
                        <input type="text" name="modelo" placeholder="Modelo do veículo"> 
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Ano:</label>
                        <input type="text" name="ano" placeholder="2020"> 
                    </div>

                    <div class="form-group">
                        <label>Cor:</label>
                        <input type="text" name="cor" placeholder="Cor"> 
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Valores e Disponibilidade</h3>
                
                <div class="form-group">
                    <label>Valor Diária (R$):</label>
                    <input type="number" step="0.01" name="valor_diaria" placeholder="0.00" required> 
                </div>

                <div class="form-checkbox-group">
                    <input type="checkbox" name="disponivel" {{ old('disponivel') ? 'checked' : '' }}>
                    <label>Disponível para aluguel</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Salvar Carro</button>
            </div>
        </form>
        <div style="margin-top:12px;text-align:center;">
            <a href="{{ route('carros.listar') }}">Voltar para Lista de Carros</a>
        </div>
    </div>
@endsection

