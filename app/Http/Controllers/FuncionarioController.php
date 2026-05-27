<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
    public function criar()
    {
        return view('cadastro_funcionario');
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|digits:11|unique:funcionarios,cpf',
            'cargo' => 'required|in:gerente,locador',
        ]);

        Funcionario::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'cargo' => $request->cargo,
        ]);

        return redirect()->back()->with('sucesso', 'Funcionário cadastrado com sucesso!');
    }

    public function listar()
    {
        $funcionarios = Funcionario::all();
        return view('lista_funcionarios', compact('funcionarios'));
    }

    public function editar($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('editar_funcionario', compact('funcionario'));
    }

    public function atualizar(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|digits:11|unique:funcionarios,cpf,' . $id,
            'cargo' => 'required|in:gerente,locador',
        ]);

        $funcionario->update([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'cargo' => $request->cargo,
        ]);

        return redirect()->route('funcionarios.listar')->with('sucesso', 'Funcionário atualizado com sucesso!');
    }

    public function deletar($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->delete();

        return redirect()->back()->with('sucesso', 'Funcionário excluído com sucesso!');
    }
}
