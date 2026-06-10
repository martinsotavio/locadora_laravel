<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarroController extends Controller
{
    public function index()
    {
        $carros = Carro::orderBy('placa')->get();
        return view('carros.index', compact('carros'));
    }

    public function create()
    {
        return view('carros.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'placa' => ['required', 'string', 'max:20', 'unique:carros,placa'],
            'modelo' => ['nullable', 'string', 'max:100'],
            'marca' => ['nullable', 'string', 'max:100'],
            'ano' => ['nullable', 'digits:4'],
            'cor' => ['nullable', 'string', 'max:50'],
            'valor_diaria' => ['nullable', 'numeric'],
            'disponivel' => ['sometimes', 'boolean'],
        ]);

        $data['disponivel'] = $request->has('disponivel');

        Carro::create($data);

        return redirect()->route('carros.index')->with('success', 'Carro criado.');
    }

    public function edit($placa)
    {
        $carro = Carro::where('placa', $placa)->firstOrFail();
        return view('carros.edit', compact('carro'));
    }

    public function update(Request $request, $placa)
    {
        $carro = Carro::where('placa', $placa)->firstOrFail();

        $data = $request->validate([
            'placa' => [
                'required', 'string', 'max:20',
                Rule::unique('carros', 'placa')->ignore($carro->placa, 'placa'),
            ],
            'modelo' => ['nullable', 'string', 'max:100'],
            'marca' => ['nullable', 'string', 'max:100'],
            'ano' => ['nullable', 'digits:4'],
            'cor' => ['nullable', 'string', 'max:50'],
            'valor_diaria' => ['nullable', 'numeric'],
            'disponivel' => ['sometimes', 'boolean'],
        ]);

        $data['disponivel'] = $request->has('disponivel');

        // If placa changed (primary key), perform update accordingly
        if ($data['placa'] !== $carro->placa) {
            // create new record and delete old (to handle PK change)
            $carro->fill($data)->save();
        } else {
            $carro->update($data);
        }

        return redirect()->route('carros.index')->with('success', 'Carro atualizado.');
    }

    public function destroy($placa)
    {
        $carro = Carro::where('placa', $placa)->firstOrFail();
        $carro->delete();
        return redirect()->route('carros.index')->with('success', 'Carro removido.');
    }

    // Legacy-style methods to match other controllers (Portuguese names)
    public function criar()
    {
        return view('cadastro_carro');
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'placa' => ['required', 'string', 'max:20', 'unique:carros,placa'],
            'modelo' => ['nullable', 'string', 'max:100'],
            'marca' => ['nullable', 'string', 'max:100'],
            'ano' => ['nullable', 'digits:4'],
            'cor' => ['nullable', 'string', 'max:50'],
            'valor_diaria' => ['nullable', 'numeric'],
        ]);

        Carro::create([
            'placa' => $request->placa,
            'modelo' => $request->modelo,
            'marca' => $request->marca,
            'ano' => $request->ano,
            'cor' => $request->cor,
            'valor_diaria' => $request->valor_diaria,
            'disponivel' => $request->has('disponivel'),
        ]);

        return redirect()->back()->with('sucesso', 'Carro cadastrado com sucesso!');
    }

    public function listar()
    {
        $carros = Carro::orderBy('placa')->get();
        return view('lista_carros', compact('carros'));
    }

    public function editar($placa)
    {
        $carro = Carro::where('placa', $placa)->firstOrFail();
        return view('editar_carro', compact('carro'));
    }

    public function atualizar(Request $request, $placa)
    {
        $carro = Carro::where('placa', $placa)->firstOrFail();

        $request->validate([
            'placa' => ['required', 'string', 'max:20'],
            'modelo' => ['nullable', 'string', 'max:100'],
            'marca' => ['nullable', 'string', 'max:100'],
            'ano' => ['nullable', 'digits:4'],
            'cor' => ['nullable', 'string', 'max:50'],
            'valor_diaria' => ['nullable', 'numeric'],
        ]);

        $data = $request->only(['placa','modelo','marca','ano','cor','valor_diaria']);
        $data['disponivel'] = $request->has('disponivel');

        // If placa changed, handle PK update by creating new record then deleting old
        if ($data['placa'] !== $carro->placa) {
            Carro::create($data);
            $carro->delete();
        } else {
            $carro->update($data);
        }

        return redirect()->route('carros.listar')->with('sucesso', 'Carro atualizado com sucesso!');
    }

    public function deletar($placa)
    {
        $carro = Carro::where('placa', $placa)->firstOrFail();
        $carro->delete();
        return redirect()->back()->with('sucesso', 'Carro excluído com sucesso!');
    }
}
