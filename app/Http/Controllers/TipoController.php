<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'nome');
        $order = $request->input('order', 'asc');

        $tipos = Tipo::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy($sort, $order)
            ->paginate(10);

        return view('tipos.index', compact('tipos', 'search', 'sort', 'order'));
    }

    public function create()
    {
        return view('tipos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:tipos',
        ], [
            'nome.required' => 'O nome do tipo é obrigatório',
            'nome.unique' => 'Já existe um tipo cadastrado com este nome',
            'nome.max' => 'O nome não pode ter mais que 255 caracteres'
        ]);

        $tipo = new Tipo();
        $tipo->nome = $request->nome;
        $tipo->user_id = auth()->id();
        $tipo->save();

        return redirect()
            ->route('tipos.index')
            ->with('success', 'Tipo cadastrado com sucesso!');
    }

    public function show(Tipo $tipo)
    {
        return view('tipos.show', compact('tipo'));
    }

    public function edit(Tipo $tipo)
    {
        return view('tipos.edit', compact('tipo'));
    }

    public function update(Request $request, Tipo $tipo)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:tipos,nome,' . $tipo->id,
        ], [
            'nome.required' => 'O nome do tipo é obrigatório',
            'nome.unique' => 'Já existe um tipo cadastrado com este nome',
            'nome.max' => 'O nome não pode ter mais que 255 caracteres'
        ]);

        $tipo->nome = $request->nome;
        $tipo->save();

        return redirect()
            ->route('tipos.index')
            ->with('success', 'Tipo atualizado com sucesso!');
    }

    public function destroy(Tipo $tipo)
    {
        $tipo->delete();

        return redirect()
            ->route('tipos.index')
            ->with('success', 'Tipo deletado com sucesso!');
    }
}
