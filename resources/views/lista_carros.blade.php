@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>

        <div class="card fade-in">
            <div class="page-header">
                <h2 class="page-title">Carros Cadastrados</h2>
                <div class="actions">
                    <a href="{{ route('carros.criar') }}" class="btn">Novo Carro</a>
                </div>
            </div>

            @if(session('sucesso'))
                <p class="sucesso">{{ session('sucesso') }}</p>
            @endif

            @if(session('erro'))
                <p class="erro">{{ session('erro') }}</p>
            @endif

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Placa</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Ano</th>
                            <th>Valor Diária</th>
                            <th>Status</th>
                            <th style="width:160px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($carros as $carro)
                        <tr>
                            <td>
                                @if($carro->imagemUrl())
                                    <img src="{{ $carro->imagemUrl() }}" alt="{{ $carro->placa }}" style="width:64px;height:48px;object-fit:cover;border-radius:6px;">
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td class="car-placa">{{ $carro->placa }}</td>
                            <td>{{ $carro->modelo ?? '—' }}</td>
                            <td>{{ $carro->marca ?? '—' }}</td>
                            <td>{{ $carro->ano ?? '—' }}</td>
                            <td>{{ isset($carro->valor_diaria) ? number_format($carro->valor_diaria, 2, ',', '.') : '—' }}</td>
                            <td>
                                <span class="badge {{ $carro->estaDisponivel() ? 'badge-disponivel' : 'badge-locado' }}">
                                    {{ $carro->estaDisponivel() ? 'Disponível' : 'Locado' }}
                                </span>
                            </td>
                            <td>
                                <div class="flex">
                                    <a href="{{ route('carros.editar', $carro->placa) }}" class="btn secondary">Editar</a>
                                    <form action="{{ route('carros.deletar', $carro->placa) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar este carro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Deletar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center;color:var(--muted)">Nenhum carro cadastrado ainda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                {{ $carros->links() }}
            </div>
        </div>
    </div>
@endsection
