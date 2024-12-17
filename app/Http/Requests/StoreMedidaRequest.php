<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedidaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'tecnico_user_id' => 'required|exists:users,id',
            'pessoa_id' => 'required|exists:pessoas,id',
            'prazo_meses' => 'required|integer|min:1',
            'data_entrada_no_creas' => 'required|date',
            'motivo_infracao' => 'required|string|max:255',
            'cod_motivo_infracao' => 'nullable|string|max:50',
            'local_armazenamento' => 'nullable|string|max:255',
            'observacao' => 'nullable|string',
            'documentos.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png'
        ];
    }

    public function messages()
    {
        return [
            'tecnico_user_id.required' => 'O técnico responsável é obrigatório',
            'pessoa_id.required' => 'A pessoa é obrigatória',
            'prazo_meses.required' => 'O prazo é obrigatório',
            'prazo_meses.integer' => 'O prazo deve ser um número inteiro',
            'prazo_meses.min' => 'O prazo deve ser maior que zero',
            'data_entrada_no_creas.required' => 'A data de entrada no CREAS é obrigatória',
            'data_entrada_no_creas.date' => 'A data de entrada no CREAS deve ser uma data válida',
            'motivo_infracao.required' => 'O motivo da infração é obrigatório',
            'documentos.*.max' => 'O arquivo não pode ser maior que 10MB',
            'documentos.*.mimes' => 'O arquivo deve ser do tipo: pdf, doc, docx, jpg, jpeg ou png'
        ];
    }
}
