<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedidaRequest;
use App\Http\Requests\UpdateMedidaRequest;
use App\Models\Medida;
use App\Models\MedidaDocumento;
use App\Models\User;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MedidaRequest;
use Illuminate\Support\Facades\Storage;

class MedidaController extends Controller
{
    public function index(Request $request)
    {
        $query = Medida::with(['pessoa', 'tecnico', 'unidade']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('pessoa', function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%");
            });
        }

        $medidas = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('medidas.index', compact('medidas'));
    }

    public function create()
    {
        $tecnicos = User::where('funcao', 'tecnico')->get();
        $pessoas = Pessoa::orderBy('nome')->get();

        return view('medidas.create', compact('tecnicos', 'pessoas'));
    }

    public function store(StoreMedidaRequest $request)
    {
        // 1. Debug inicial - verificar dados recebidos
        logger('Dados recebidos:', $request->all());

        DB::beginTransaction();

        try {
            // 2. Debug dos dados antes de criar a medida
            logger('Tentando criar medida com dados:', [
                'user_id' => auth()->id(),
                'unidade_id' => auth()->user()->unidade_id,
                'tecnico_user_id' => $request->tecnico_user_id,
                'pessoa_id' => $request->pessoa_id,
                // ... outros campos
            ]);

            $medida = Medida::create([
                'user_id' => auth()->id(),
                'unidade_id' => auth()->user()->unidade_id,
                'tecnico_user_id' => $request->tecnico_user_id,
                'pessoa_id' => $request->pessoa_id,
                'prazo_meses' => $request->prazo_meses,
                'egresso' => $request->has('egresso'),
                'data_entrada_no_creas' => $request->data_entrada_no_creas,
                'motivo_infracao' => $request->motivo_infracao,
                'cod_motivo_infracao' => $request->cod_motivo_infracao,
                'possui_irmao_em_atedimento' => $request->has('possui_irmao_em_atedimento'),
                'local_armazenamento' => $request->local_armazenamento,
                'data_ativacao' => now(),
                'status' => 'ativo'
            ]);

            // 3. Debug após criar a medida
            logger('Medida criada:', $medida->toArray());

            // 4. Verificação e criação da observação
            if ($request->filled('observacao')) {
                logger('Tentando criar observação');

                $observacao = $medida->observacoes()->create([
                    'user_id' => auth()->id(),
                    'observacao' => $request->observacao
                ]);

                logger('Observação criada:', $observacao->toArray());
            }

            // 5. Upload de documentos
            if ($request->hasFile('documentos')) {
                logger('Iniciando upload de documentos');

                foreach ($request->file('documentos') as $documento) {
                    // Verifica se o diretório existe e tem permissões
                    $uploadPath = 'medidas/documentos';
                    if (!Storage::exists($uploadPath)) {
                        Storage::makeDirectory($uploadPath);
                    }

                    try {
                        $path = $documento->store($uploadPath);
                        logger('Arquivo salvo em: ' . $path);

                        $doc = $medida->documentos()->create([
                            'user_id' => auth()->id(),
                            'documento' => $path,
                            'nome_original' => $documento->getClientOriginalName(),
                            'mime_type' => $documento->getMimeType(),
                            'tamanho' => $documento->getSize()
                        ]);

                        logger('Documento registrado no banco:', $doc->toArray());
                    } catch (\Exception $e) {
                        logger('Erro ao salvar documento:', [
                            'erro' => $e->getMessage(),
                            'arquivo' => $documento->getClientOriginalName()
                        ]);
                        throw $e;
                    }
                }
            }

            DB::commit();
            logger('Transação commitada com sucesso');

            return redirect()->route('medidas.show', $medida)
                ->with('success', 'Medida cadastrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            logger('Erro durante o processo:', [
                'mensagem' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar medida: ' . $e->getMessage());
        }
    }


    public function show(Medida $medida)
    {
        $medida->load(['pessoa', 'tecnico', 'unidade', 'observacoes.user', 'documentos']);
        return view('medidas.show', compact('medida'));
    }

    public function edit(Medida $medida)
    {
        $tecnicos = User::where('funcao', 'tecnico')->get();
        $pessoas = Pessoa::orderBy('nome')->get();

        return view('medidas.edit', compact('medida', 'tecnicos', 'pessoas'));
    }

    public function update(UpdateMedidaRequest $request, Medida $medida)
    {
        DB::beginTransaction();

        try {
            // Atualizar dados básicos da medida
            $medida->update([
                'tecnico_user_id' => $request->tecnico_user_id,
                'pessoa_id' => $request->pessoa_id,
                'prazo_meses' => $request->prazo_meses,
                'egresso' => $request->has('egresso'),
                'data_entrada_no_creas' => $request->data_entrada_no_creas,
                'motivo_infracao' => $request->motivo_infracao,
                'cod_motivo_infracao' => $request->cod_motivo_infracao,
                'possui_irmao_em_atedimento' => $request->has('possui_irmao_em_atedimento'),
                'local_armazenamento' => $request->local_armazenamento,
            ]);

            // Adicionar nova observação se houver
            if ($request->filled('observacao')) {
                $medida->observacoes()->create([
                    'user_id' => auth()->id(),
                    'observacao' => $request->observacao
                ]);
            }

            // Upload de novos documentos
            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $documento) {
                    $uploadPath = 'medidas/documentos';
                    if (!Storage::exists($uploadPath)) {
                        Storage::makeDirectory($uploadPath);
                    }

                    $path = $documento->store($uploadPath);

                    $medida->documentos()->create([
                        'user_id' => auth()->id(),
                        'documento' => $path,
                        'nome_original' => $documento->getClientOriginalName(),
                        'mime_type' => $documento->getMimeType(),
                        'tamanho' => $documento->getSize()
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('medidas.show', $medida)
                ->with('success', 'Medida atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            logger('Erro ao atualizar medida:', [
                'mensagem' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Erro ao atualizar medida: ' . $e->getMessage());
        }
    }


    public function destroy(Medida $medida)
    {
        try {
            $medida->delete();
            return redirect()->route('medidas.index')
                ->with('success', 'Medida excluída com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir medida: ' . $e->getMessage());
        }
    }

    public function desligar(Request $request, Medida $medida)
    {
        $request->validate([
            'motivo_desligamento' => 'required'
        ]);

        DB::transaction(function () use ($request, $medida) {
            $medida->update([
                'status' => 'desligado',
                'data_desligamento' => now()
            ]);

            $medida->observacoes()->create([
                'user_id' => auth()->id(),
                'observacao' => "Desligamento - Motivo: " . $request->motivo_desligamento
            ]);
        });

        return back()->with('success', 'Medida desligada com sucesso!');
    }

    public function storeObservacao(Request $request, Medida $medida)
    {
        $request->validate([
            'observacao' => 'required|string'
        ]);

        $medida->observacoes()->create([
            'user_id' => auth()->id(),
            'observacao' => $request->observacao
        ]);

        return back()->with('success', 'Observação adicionada com sucesso!');
    }

    public function storeDocumento(Request $request, Medida $medida)
    {
        $request->validate([
            'documento' => 'required|file|max:10240'
        ]);

        $path = $request->file('documento')->store('medidas/documentos');

        $medida->documentos()->create([
            'user_id' => auth()->id(),
            'documento' => $path,
            'nome_original' => $request->file('documento')->getClientOriginalName(),
            'mime_type' => $request->file('documento')->getMimeType(),
            'tamanho' => $request->file('documento')->getSize()
        ]);

        return back()->with('success', 'Documento adicionado com sucesso!');
    }

    public function downloadDocumento(MedidaDocumento $documento)
    {
        return Storage::download($documento->documento, $documento->nome_original);
    }

}
