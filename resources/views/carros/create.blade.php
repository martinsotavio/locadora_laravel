@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Novo Carro</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('carros.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Placa</label>
            <input type="text" name="placa" class="form-control" value="{{ old('placa') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control" value="{{ old('modelo') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Marca</label>
            <input type="text" name="marca" class="form-control" value="{{ old('marca') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Ano</label>
            <input type="text" name="ano" class="form-control" value="{{ old('ano') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Cor</label>
            <input type="text" name="cor" class="form-control" value="{{ old('cor') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Valor Diária</label>
            <input type="number" step="0.01" name="valor_diaria" class="form-control" value="{{ old('valor_diaria') }}">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponivel" class="form-check-input" id="disponivel" {{ old('disponivel') ? 'checked' : '' }}>
            <label class="form-check-label" for="disponivel">Disponível</label>
        </div>
        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('carros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
