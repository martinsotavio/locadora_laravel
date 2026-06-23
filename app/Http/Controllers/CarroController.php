<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CarroController extends Controller
{
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
            'status' => ['nullable', Rule::in(Carro::STATUSES)],
            'imagem' => ['nullable', 'image', 'max:4096'],
        ]);

        Carro::create([
            'placa' => $request->placa,
            'modelo' => $request->modelo,
            'marca' => $request->marca,
            'ano' => $request->ano,
            'cor' => $request->cor,
            'valor_diaria' => $request->valor_diaria,
            'status' => $request->input('status', Carro::STATUS_DISPONIVEL),
            'imagem' => $request->hasFile('imagem') ? $request->file('imagem')->store('carros', 'public') : null,
        ]);

        return redirect()->back()->with('sucesso', 'Carro cadastrado com sucesso!');
    }

    public function listar()
    {
        $carros = Carro::orderBy('placa')->paginate(10);
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
            'status' => ['nullable', Rule::in(Carro::STATUSES)],
            'imagem' => ['nullable', 'image', 'max:4096'],
        ]);

        $data = $request->only(['placa','modelo','marca','ano','cor','valor_diaria']);
        $data['status'] = $request->input('status', $carro->status);
        $data['imagem'] = $carro->imagem;

        if ($request->hasFile('imagem')) {
            if ($carro->imagem) {
                Storage::disk('public')->delete($carro->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('carros', 'public');
        }

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

        if ($carro->locacoes()->exists()) {
            return redirect()->back()->with('erro', 'Carro possui locações vinculadas e não pode ser excluído.');
        }

        if ($carro->imagem) {
            Storage::disk('public')->delete($carro->imagem);
        }

        $carro->delete();
        return redirect()->back()->with('sucesso', 'Carro excluído com sucesso!');
    }
}
