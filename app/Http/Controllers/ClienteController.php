<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; // Importa o modelo de cliente

class ClienteController extends Controller
{
    // Função para mostrar a tela do formulário
    public function criar()
    {
        return view('cadastro_cliente');
    }

    // Função para receber os dados do formulário e salvar
    public function salvar(Request $request)
    {
        // Validação simples para evitar CPFs duplicados e campos vazios
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|unique:clientes,cpf',
        ]);

        // Cria o cliente no banco com os dados vindos do formulário
        $cliente = new Cliente();
        $cliente->nome = $request->nome;
        $cliente->cpf = $request->cpf;
        $cliente->telefone = $request->telefone;
        $cliente->save();

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->back()->with('sucesso', 'Cliente cadastrado com sucesso!');
    }

    
    public function listar()
    {
        $clientes = Cliente::all(); // Pega todos os registros da tabela clientes
        return view('lista_clientes', compact('clientes'));
    }

    
    public function editar($id)
    {
        $cliente = Cliente::findOrFail($id); // Procura o cliente pelo ID (se não achar, dá erro 404)
        return view('editar_cliente', compact('cliente'));
    }

    
    public function atualizar(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        // Valida os dados, permitindo que o cliente mantenha o próprio CPF sem dar erro de "duplicado"
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|unique:clientes,cpf,' . $id,
        ]);

        $cliente->nome = $request->nome;
        $cliente->cpf = $request->cpf;
        $cliente->telefone = $request->telefone;
        $cliente->save();

        // Redireciona para a lista com a mensagem de sucesso
        return redirect()->route('clientes.listar')->with('sucesso', 'Cliente atualizado com sucesso!');
    }

   
    public function deletar($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete(); // Apaga o registro do banco

        // Retorna para a mesma página atualizando a tabela
        return redirect()->back()->with('sucesso', 'Cliente excluído com sucesso!');
    }
}