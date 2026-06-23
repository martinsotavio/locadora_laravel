@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>

        <div class="card">
            <h2 style="margin-top: 0; color: #1f2937;">Clientes Cadastrados</h2>

            @if(session('sucesso'))
                <p class="sucesso"> {{ session('sucesso') }}</p>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->cpf }}</td>
                            <td>{{ $cliente->telefone ?? 'Não informado' }}</td>
                            <td>
                                <a href="{{ route('clientes.editar', $cliente->id) }}" class="btn-editar">Editar</a>
                                
                                <form action="{{ route('clientes.deletar', $cliente->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-deletar">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($clientes->isEmpty())
                        <tr>
                            <td colspan="4" style="text-align: center; color: #6b7280;">Nenhum cliente cadastrado ainda.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div style="margin-top:16px;">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
@endsection