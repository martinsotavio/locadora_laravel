@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Carros</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('carros.create') }}" class="btn btn-primary mb-3">Novo Carro</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Ano</th>
                <th>Cor</th>
                <th>Valor Diária</th>
                <th>Disponível</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carros as $carro)
            <tr>
                <td>{{ $carro->placa }}</td>
                <td>{{ $carro->modelo }}</td>
                <td>{{ $carro->marca }}</td>
                <td>{{ $carro->ano }}</td>
                <td>{{ $carro->cor }}</td>
                <td>{{ number_format($carro->valor_diaria ?? 0, 2, ',', '.') }}</td>
                <td>{{ $carro->disponivel ? 'Sim' : 'Não' }}</td>
                <td>
                    <a href="{{ route('carros.edit', $carro->placa) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <form action="{{ route('carros.destroy', $carro->placa) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Remover este carro?')">Remover</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
