<?php

namespace App\Http\Controllers;

use App\Models\Violencia;
use Illuminate\Http\Request;


class ViolenciaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'nome');
        $order = $request->input('order', 'asc');

        $violencias = Violencia::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy($sort, $order)
            ->paginate(10);

        return view('violencias.index', compact('violencias', 'search', 'sort', 'order'));
    }

    public function create()
    {
        return view('violencias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:violencias',
        ], [
            'nome.required' => 'O nome da violência é obrigatório',
            'nome.unique' => 'Já existe uma violência cadastrada com este nome',
            'nome.max' => 'O nome não pode ter mais que 255 caracteres'
        ]);

        $violencia = new Violencia();
        $violencia->nome = $request->nome;
        $violencia->user_id = auth()->id();
        $violencia->save();

        return redirect()
            ->route('violencias.index')
            ->with('success', 'Violência cadastrada com sucesso!');
    }

    public function edit(Violencia $violencia)
    {
        return view('violencias.edit', compact('violencia'));
    }

    public function show(Violencia $violencia)
    {
        return view('violencias.show', compact('violencia'));
    }


    public function update(Request $request, Violencia $violencia)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:violencias,nome,' . $violencia->id,
        ], [
            'nome.required' => 'O nome da violência é obrigatório',
            'nome.unique' => 'Já existe uma violência cadastrada com este nome',
            'nome.max' => 'O nome não pode ter mais que 255 caracteres'
        ]);

        $violencia->nome = $request->nome;
        $violencia->save();

        return redirect()
            ->route('violencias.index')
            ->with('success', 'Violência atualizada com sucesso!');
    }


    public function destroy(Violencia $violencia)
    {
        $violencia->delete();

        return redirect()->route('violencias.index')
            ->with('success', 'Violência excluída com sucesso.');
    }
}
