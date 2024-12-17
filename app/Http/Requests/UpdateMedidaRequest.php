<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedidaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'tecnico_user_id' => 'required|exists:users,id',
            'pessoa_id' => 'required|exists:pessoas,id',
            'prazo_meses' => 'required|integer|min:1',
            'data_entrada_no_creas' => 'required|date',
            'motivo_infracao' => 'required|string',
            'cod_motivo_infracao' => 'nullable|string',
            'local_armazenamento' => 'nullable|string',
            'observacao' => 'nullable|string',
            'documentos.*' => 'nullable|file|max:10240'
        ];
    }

    public function messages()
    {
        return [
            'tecnico_user_id.required' => 'O técnico responsável é obrigatório.',
            'tecnico_user_id.exists' => 'O técnico selecionado não é válido.',

            'pessoa_id.required' => 'A pessoa é obrigatória.',
            'pessoa_id.exists' => 'A pessoa selecionada não é válida.',

            'prazo_meses.required' => 'O prazo em meses é obrigatório.',
            'prazo_meses.integer' => 'O prazo deve ser um número inteiro.',
            'prazo_meses.min' => 'O prazo deve ser de pelo menos 1 mês.',

            'data_entrada_no_creas.required' => 'A data de entrada no CREAS é obrigatória.',
            'data_entrada_no_creas.date' => 'A data de entrada no CREAS deve ser uma data válida.',

            'motivo_infracao.required' => 'O motivo da infração é obrigatório.',
            'motivo_infracao.string' => 'O motivo da infração deve ser um texto.',

            'cod_motivo_infracao.string' => 'O código do motivo da infração deve ser um texto.',

            'local_armazenamento.string' => 'O local de armazenamento deve ser um texto.',

            'observacao.string' => 'A observação deve ser um texto.',

            'documentos.*.file' => 'O arquivo enviado não é válido.',
            'documentos.*.max' => 'O arquivo não pode ser maior que 10MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'tecnico_user_id' => 'técnico responsável',
            'pessoa_id' => 'pessoa',
            'prazo_meses' => 'prazo em meses',
            'data_entrada_no_creas' => 'data de entrada no CREAS',
            'motivo_infracao' => 'motivo da infração',
            'cod_motivo_infracao' => 'código do motivo da infração',
            'local_armazenamento' => 'local de armazenamento',
            'observacao' => 'observação',
            'documentos.*' => 'documento'
        ];
    }
}
