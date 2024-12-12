<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidades = Unidade::paginate(10);
        return view('unidades.index', compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('unidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:unidades,nome',
            'numero_max_atribuicoes_por_tecnico' => 'required|integer|min:1'
        ]);

        Unidade::create([
            'nome' => $request->nome,
            'numero_max_atribuicoes_por_tecnico' => $request->numero_max_atribuicoes_por_tecnico,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('unidades.index')->with('success', 'Unidade criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unidade $unidade)
    {
        return view ('unidades.show', compact('unidade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidade $unidade)
    {
        return view('unidades.edit', compact('unidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidade $unidade)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:unidades,nome,' . $unidade->id,
            'numero_max_atribuicoes_por_tecnico' => 'required|integer|min:1'
        ]);

        $unidade->update([
            'nome' => $request->nome,
            'numero_max_atribuicoes_por_tecnico' => $request->numero_max_atribuicoes_por_tecnico,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('unidades.index')->with('success', 'Unidade atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidade $unidade)
    {
        $unidade->delete();
        return redirect()->route('unidades.index')->with('success', 'Unidade deletada com sucesso!');
    }
}
