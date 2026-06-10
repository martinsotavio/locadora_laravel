@extends('layouts.app')

@section('content')
    <div class="container fade-in">
        <a href="javascript:history.back()" class="btn ghost">Voltar</a>

        <div class="card">
            <h2 style="margin-top: 0; color: #1f2937;">Funcionários Cadastrados</h2>

            @if(session('sucesso'))
                <p class="sucesso">{{ session('sucesso') }}</p>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Cargo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($funcionarios as $funcionario)
                        <tr>
                            <td>{{ $funcionario->nome }}</td>
                            <td>{{ $funcionario->cpf }}</td>
                            <td>{{ $funcionario->telefone ?? 'Não informado' }}</td>
                            <td>{{ $funcionario->email ?? 'Não informado' }}</td>
                            <td>{{ $funcionario->cargo ?? 'Não informado' }}</td>
                            <td>
                                @if($funcionario->cargo === 'gerente')
                                    <a href="{{ route('funcionarios.editar', $funcionario->id) }}" class="btn-editar">Editar</a>
                                    <form action="{{ route('funcionarios.deletar', $funcionario->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar este funcionário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-deletar">Deletar</button>
                                    </form>
                                @else
                                    <span style="color: #6b7280; font-size: 13px;">Somente listagem</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if($funcionarios->isEmpty())
                        <tr>
                            <td colspan="6" style="text-align: center; color: #6b7280;">Nenhum funcionário cadastrado ainda.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
