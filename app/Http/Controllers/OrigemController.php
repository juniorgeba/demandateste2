<?php

namespace App\Http\Controllers;

use App\Models\Origem;
use Illuminate\Http\Request;

class OrigemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'nome');
        $order = $request->input('order', 'asc');

        $origens = Origem::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy($sort, $order)
            ->paginate(10);

        return view('origens.index', compact('origens', 'search', 'sort', 'order'));
    }

    public function create()
    {
        return view('origens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:origens',
        ], [
            'nome.required' => 'O nome da origem é obrigatório',
            'nome.unique' => 'Já existe uma origem cadastrada com este nome',
            'nome.max' => 'O nome não pode ter mais que 255 caracteres'
        ]);

        $origem = new Origem();
        $origem->nome = $request->nome;
        $origem->user_id = auth()->id();
        $origem->save();

        return redirect()
            ->route('origens.index')
            ->with('success', 'Origem cadastrada com sucesso!');
    }

    public function show(Origem $origem)
    {
        return view('origens.show', compact('origem'));
    }

    public function edit(Origem $origem)
    {
        return view('origens.edit', compact('origem'));
    }

    public function update(Request $request, Origem $origem)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:origens,nome,' . $origem->id,
        ], [
            'nome.required' => 'O nome da origem é obrigatório',
            'nome.unique' => 'Já existe uma origem cadastrada com este nome',
            'nome.max' => 'O nome não pode ter mais que 255 caracteres'
        ]);

        $origem->nome = $request->nome;
        $origem->save();

        return redirect()
            ->route('origens.index')
            ->with('success', 'Origem atualizada com sucesso!');
    }

    public function destroy(Origem $origem)
    {
        $origem->delete();

        return redirect()
            ->route('origens.index')
            ->with('success', 'Origem deletada com sucesso!');
    }
}
