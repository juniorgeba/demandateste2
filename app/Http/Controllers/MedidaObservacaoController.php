<?php

namespace App\Http\Controllers;

use App\Models\MedidaObservacao;
use Illuminate\Http\Request;

class MedidaObservacaoController extends Controller
{
    public function destroy(MedidaObservacao $observacao)
    {
        try {
            // Verifica se o usuário tem permissão para excluir
            // Você pode adicionar suas próprias regras de autorização aqui

            $observacao->delete();

            return response()->json([
                'success' => true,
                'message' => 'Observação excluída com sucesso'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir observação: ' . $e->getMessage()
            ], 500);
        }
    }
}
