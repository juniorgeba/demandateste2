<?php

namespace App\Http\Controllers;

use App\Models\Demanda;
use App\Models\Pessoa;
use App\Models\Unidade;
use App\Models\Tipo;
use App\Models\Violencia;
use Illuminate\Http\Request;

class DemandaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', '');
        $classificacao = $request->input('classificacao', '');
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        $classificacoes = [
            'sem prioridade' => 'Sem Prioridade',
            'prioritario' => 'Prioritário',
            'urgente' => 'Urgente'
        ];

        $demandas = Demanda::with(['user', 'unidade', 'tipo', 'violencia'])
            ->when($search, function ($query) use ($search) {
                return $query->where('local_armazenamento', 'like', "%{$search}%");
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status_administrativo', $status);
            })
            ->when($classificacao, function ($query) use ($classificacao) {
                return $query->where('classificacao', $classificacao);
            })
            ->orderBy($sort, $order)
            ->paginate(10);

        return view('demandas.index', compact(
            'demandas',
            'search',
            'status',
            'classificacao',
            'classificacoes',
            'sort',
            'order'
        ));
    }


    public function create()
    {
        $tipos = Tipo::orderBy('nome')->pluck('nome', 'id');
        $violencias = Violencia::orderBy('nome')->pluck('nome', 'id');
        $classificacoes = [
            'sem prioridade' => 'Sem Prioridade',
            'prioritario' => 'Prioritário',
            'urgente' => 'Urgente'
        ];

        $pessoas = Pessoa::orderBy('nome')->get();

        return view('demandas.create', compact('tipos', 'violencias', 'classificacoes', 'pessoas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_id' => 'required|exists:tipos,id',
            'violencia_id' => 'required|exists:violencias,id',
            'local_armazenamento' => 'required|string|max:255',
            'classificacao' => 'required|in:sem prioridade,prioritario,urgente',
            'denunciantes' => 'array',
            'denunciantes.*.pessoa_id' => 'required|exists:pessoas,id', // Apenas o pessoa_id
        ]);

        $demanda = new Demanda($request->all());
        $demanda->user_id = auth()->id();
        $demanda->unidade_id = auth()->user()->unidade_id;
        $demanda->data_triagem = now();
        $demanda->status_administrativo = 'triagem';
        $demanda->save();

        // Salvar denunciantes
        foreach ($request->denunciantes as $denunciante) {
            $denunciante['user_id'] = auth()->id(); // Define o user_id do usuário logado
            $demanda->denunciantes()->create($denunciante);
        }

        return redirect()
            ->route('demandas.index')
            ->with('success', 'Demanda cadastrada com sucesso!');
    }



    public function show(Demanda $demanda)
    {
        return view('demandas.show', compact('demanda'));
    }

    public function edit(Demanda $demanda)
    {
        $tipos = Tipo::orderBy('nome')->pluck('nome', 'id');
        $violencias = Violencia::orderBy('nome')->pluck('nome', 'id');
        $classificacoes = [
            'sem prioridade' => 'Sem Prioridade',
            'prioritario' => 'Prioritário',
            'urgente' => 'Urgente'
        ];

        $status_administrativos = [
            'triagem' => 'Triagem',
            'demanda reprimida' => 'Demanda Reprimida',
            'atribuido' => 'Atribuído'
        ];

        $pessoas = Pessoa::orderBy('nome')->get();

        return view('demandas.edit', compact('demanda', 'tipos', 'violencias', 'classificacoes', 'status_administrativos', 'pessoas'));
    }

    public function update(Request $request, Demanda $demanda)
    {
        $request->validate([
            'tipo_id' => 'required|exists:tipos,id',
            'violencia_id' => 'required|exists:violencias,id',
            'local_armazenamento' => 'required|string|max:255',
            'classificacao' => 'required|in:sem prioridade,prioritario,urgente',
            'denunciantes' => 'array',
            'denunciantes.*.pessoa_id' => 'required|exists:pessoas,id', // Apenas o pessoa_id
        ]);

        $demanda->update($request->all());

        // Remover todos os denunciantes antigos
        $demanda->denunciantes()->delete();

        // Salvar novos denunciantes
        foreach ($request->denunciantes as $denunciante) {
            $denunciante['user_id'] = auth()->id(); // Define o user_id do usuário logado
            $demanda->denunciantes()->create($denunciante);
        }

        return redirect()
            ->route('demandas.index')
            ->with('success', 'Demanda atualizada com sucesso!');
    }



    public function destroy(Demanda $demanda)
    {
        $demanda->delete();

        return redirect()
            ->route('demandas.index')
            ->with('success', 'Demanda deletada com sucesso!');
    }
}
