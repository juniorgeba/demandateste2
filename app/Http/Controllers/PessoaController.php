<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'nome'); // Campo padrão para ordenação
        $order = $request->input('order', 'asc'); // Ordem padrão

        $query = Pessoa::query();

        // Aplicar busca se houver termo de pesquisa
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('cpf', 'like', "%{$search}%");
            });
        }

        // Aplicar ordenação
        $query->orderBy($sort, $order);

        // Paginar resultados
        $pessoas = $query->paginate(10);

        return view('pessoas.index', compact('pessoas', 'search', 'sort', 'order'));
    }


    public function create()
    {
        return view('pessoas.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
            'nome.required' => 'O campo nome é obrigatório.',
            'genero.required' => 'O campo gênero é obrigatório.',
            'deficiencia.required' => 'O campo deficiência é obrigatório.',
        ];

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'genero' => 'required|string',
            'deficiencia' => 'required|string',
            'data_nascimento' => 'nullable|date',
            'cpf' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique('pessoas')
            ],
            'nome_mae' => 'nullable|string|max:255',
            'nome_pai' => 'nullable|string|max:255',
            'nome_responsavel' => 'nullable|string|max:255',
            'grau_parentesco_responsavel' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:9',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:15',
        ] , $messages);

        $validated['user_id'] = auth()->id();

        Pessoa::create($validated);

        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa cadastrada com sucesso.');
    }

    public function show(Pessoa $pessoa)
    {
        return view('pessoas.show', compact('pessoa'));
    }

    public function edit(Pessoa $pessoa)
    {
        return view('pessoas.edit', compact('pessoa'));
    }

    public function update(Request $request, Pessoa $pessoa)
    {
        $messages = [
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
            'nome.required' => 'O campo nome é obrigatório.',
            'genero.required' => 'O campo gênero é obrigatório.',
            'deficiencia.required' => 'O campo deficiência é obrigatório.',
        ];

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'genero' => 'required|string',
            'deficiencia' => 'required|string',
            'data_nascimento' => 'nullable|date',
            'cpf' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique('pessoas')->ignore($pessoa->id)
            ],
            'nome_mae' => 'nullable|string|max:255',
            'nome_pai' => 'nullable|string|max:255',
            'nome_responsavel' => 'nullable|string|max:255',
            'grau_parentesco_responsavel' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:9',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:15',
        ] , $messages);

        $pessoa->update($validated);

        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa atualizada com sucesso.');
    }

    public function destroy(Pessoa $pessoa)
    {
        $pessoa->delete();

        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa excluída com sucesso.');
    }
}
