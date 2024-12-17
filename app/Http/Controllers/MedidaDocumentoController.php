<?php

namespace App\Http\Controllers;

use App\Models\MedidaDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedidaDocumentoController extends Controller
{
    public function download(MedidaDocumento $documento)
    {
        // Verificar se o usuário tem permissão para baixar o documento
        if (!auth()->user()) {
            abort(403);
        }

        // Verificar se o arquivo existe
        if (!Storage::exists($documento->documento)) {
            return back()->with('error', 'Arquivo não encontrado.');
        }

        // Retornar o arquivo para download
        return Storage::download(
            $documento->documento,
            $documento->nome_original,
            ['Content-Type' => $documento->mime_type]
        );
    }

    public function destroy(MedidaDocumento $documento)
    {
        try {
            // Verificar se o usuário tem permissão
            if (!auth()->user()) {
                abort(403);
            }

            // Deletar o arquivo físico
            if (Storage::exists($documento->documento)) {
                Storage::delete($documento->documento);
            }

            // Deletar o registro do banco
            $documento->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir documento: ' . $e->getMessage()
            ], 500);
        }
    }
}
