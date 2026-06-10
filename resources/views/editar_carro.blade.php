@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>
    </div>

    <div class="card" style="max-width:700px;margin:18px auto">
        <h2 style="margin-top: 0; color: #1f2937;">Editar Carro</h2>

        @if($errors->any())
            <div style="color:#ef4444; margin-bottom:10px;">@foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach</div>
        @endif

        <form action="{{ route('carros.atualizar', $carro->placa) }}" method="POST">
            @csrf

            <div class="form-section">
                <h3>Informações do Veículo</h3>
                
                <div class="form-group">
                    <label>Placa:</label>
                    <input type="text" name="placa" required value="{{ old('placa', $carro->placa) }}"> 
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Marca:</label>
                        <input type="text" name="marca" value="{{ old('marca', $carro->marca) }}"> 
                    </div>

                    <div class="form-group">
                        <label>Modelo:</label>
                        <input type="text" name="modelo" value="{{ old('modelo', $carro->modelo) }}"> 
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Ano:</label>
                        <input type="text" name="ano" value="{{ old('ano', $carro->ano) }}"> 
                    </div>

                    <div class="form-group">
                        <label>Cor:</label>
                        <input type="text" name="cor" value="{{ old('cor', $carro->cor) }}"> 
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Valores e Disponibilidade</h3>
                
                <div class="form-group">
                    <label>Valor Diária (R$):</label>
                    <input type="number" step="0.01" name="valor_diaria" value="{{ old('valor_diaria', $carro->valor_diaria) }}"> 
                </div>

                <div class="form-checkbox-group">
                    <input type="checkbox" name="disponivel" {{ old('disponivel', $carro->disponivel) ? 'checked' : '' }}>
                    <label>Disponível para aluguel</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="secondary">Atualizar Carro</button>
            </div>
        </form>
        <div style="margin-top:12px;text-align:center;">
            <a href="{{ route('carros.listar') }}">Voltar para Lista de Carros</a>
        </div>
    </div>
@endsection