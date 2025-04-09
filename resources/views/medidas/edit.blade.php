@extends('layouts.app')
@section('title', 'Edição de Medida')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ocorreu um erro:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Editar Medida</span>
            <a href="{{ route('medidas.show', $medida) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('medidas.update', $medida->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Primeira Coluna - Dados da Medida -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Dados da Medida</h5>

                        <div class="mb-3">
                            <label class="form-label">Pessoa*</label>
                            <select name="pessoa_id" class="form-control" required>
                                <option value="">Selecione uma pessoa</option>
                                @foreach($pessoas as $pessoa)
                                    <option value="{{ $pessoa->id }}" {{ old('pessoa_id', $medida->pessoa_id) == $pessoa->id ? 'selected' : '' }}>
                                        {{ $pessoa->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Técnico Responsável*</label>
                            <select name="tecnico_user_id" class="form-control" required>
                                <option value="">Selecione um técnico</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ old('tecnico_user_id', $medida->tecnico_user_id) == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="natureza" class="form-label">Natureza</label>
                            <select id="natureza" name="natureza" class="form-control">
                                <option value="{{ old('natureza', $medida->narureza) }}">{{ old('natureza', $medida->narureza) }}</option>
                                <option value="LA" {{ old('natureza'), $medida->narureza == 'LA' ? 'selected' : '' }}>LA</option>
                                <option value="PSC" {{ old('natureza'), $medida->narureza == 'PSC' ? 'selected' : '' }}>PSC</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prazo (meses)*</label>
                            <input type="number" name="prazo_meses" class="form-control"
                                   value="{{ old('prazo_meses', $medida->prazo_meses) }}" required min="1">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data de Entrada no CREAS*</label>
                            <input type="date" name="data_entrada_no_creas" class="form-control"
                                   value="{{ old('data_entrada_no_creas', $medida->data_entrada_no_creas) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="motivo_infracao" class="form-label">Motivo da Infração*</label>
                            <select id="motivo_infracao" name="motivo_infracao" class="form-control" required>
                                <option value="{{ $medida->motivo_infracao }}">{{ $medida->motivo_infracao }}</option>
                                <option value="furto" {{ old('motivo_infracao', $medida->motivo_infracao) == 'furto' ? 'selected' : '' }}>Furto</option>
                                <option value="roubo" {{ old('motivo_infracao', $medida->motivo_infracao) == 'roubo' ? 'selected' : '' }}>Roubo</option>
                                <option value="tráfico de drogas" {{ old('motivo_infracao', $medida->motivo_infracao) == 'tráfico de drogas' ? 'selected' : '' }}>Tráfico de Drogas</option>
                                <option value="lesão corporal" {{ old('motivo_infracao', $medida->motivo_infracao) == 'lesão corporal' ? 'selected' : '' }}>Lesão Corporal</option>
                                <option value="homicídio" {{ old('motivo_infracao', $medida->motivo_infracao) == 'homicídio' ? 'selected' : '' }}>Homicídio</option>
                                <option value="porte ilegal de arma" {{ old('motivo_infracao', $medida->motivo_infracao) == 'porte ilegal de arma' ? 'selected' : '' }}>Porte Ilegal de Arma</option>
                                <option value="vandalismo" {{ old('motivo_infracao', $medida->motivo_infracao) == 'vandalismo' ? 'selected' : '' }}>Vandalismo</option>
                                <option value="ameaça" {{ old('motivo_infracao', $medida->motivo_infracao) == 'ameaça' ? 'selected' : '' }}>Ameaça</option>
                                <option value="outro" {{ old('motivo_infracao', $medida->motivo_infracao) == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="cod_motivo_infracao" class="form-label">Código da infração</label>
                            <input type="text" name="cod_motivo_infracao" class="form-control" value="{{ old('cod_motivo_infracao', $medida->cod_motivo_infracao) }}">
                        </div>

                    </div>

                    <!-- Segunda Coluna - Informações Adicionais -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Informações Adicionais</h5>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="egresso" class="form-check-input" id="egresso"
                                    {{ old('egresso', $medida->egresso) ? 'checked' : '' }}>
                                <label class="form-check-label" for="egresso">Egresso</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="possui_irmao_em_atedimento" class="form-check-input" id="irmao"
                                    {{ old('possui_irmao_em_atedimento', $medida->possui_irmao_em_atedimento) ? 'checked' : '' }}>
                                <label class="form-check-label" for="irmao">Possui Irmão em Atendimento</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Local de Armazenamento</label>
                            <input type="text" name="local_armazenamento" class="form-control"
                                   value="{{ old('local_armazenamento', $medida->local_armazenamento) }}">
                        </div>
                    </div>
                </div>

                <!-- Seção de Observações -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Observações</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalObservacao">
                            <i class="fas fa-plus"></i> Nova Observação
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Observação</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($medida->observacoes as $observacao)
                                <tr>
                                    <td>{{ $observacao->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $observacao->user->name }}</td>
                                    <td>{{ $observacao->observacao }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete-observacao"
                                                data-observacao-id="{{ $observacao->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nenhuma observação registrada</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Seção de Documentos -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Documentos</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDocumento">
                            <i class="fas fa-plus"></i> Novo Documento
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>Nome do Arquivo</th>
                                <th>Tamanho</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($medida->documentos as $documento)
                                <tr>
                                    <td>{{ $documento->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $documento->user->name }}</td>
                                    <td>{{ $documento->nome_original }}</td>
                                    <td>{{ number_format($documento->tamanho / 1024, 2) }} KB</td>
                                    <td>
                                        <a href="{{ route('documentos.download', $documento) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-documento"
                                                data-documento-id="{{ $documento->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Nenhum documento anexado</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Nova Observação -->
    <div class="modal fade" id="modalObservacao" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('medidas.observacao.store', $medida->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Observação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="observacao" class="form-label">Observação</label>
                            <textarea class="form-control" id="observacao" name="observacao" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Novo Documento -->
    <div class="modal fade" id="modalDocumento" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('medidas.documento.store', $medida->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Documento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento</label>
                            <input type="file" class="form-control" id="documento" name="documento" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // Excluir documento
            $('.delete-documento').click(function() {
                if (confirm('Tem certeza que deseja excluir este documento?')) {
                    const documentoId = $(this).data('documento-id');
                    const row = $(this).closest('tr');

                    $.ajax({
                        url: `/documentos/${documentoId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                            } else {
                                alert('Erro ao excluir documento');
                            }
                        },
                        error: function() {
                            alert('Erro ao excluir documento');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Excluir observação
            $('.delete-observacao').click(function() {
                const button = $(this);
                const observacaoId = button.data('observacao-id');
                const row = button.closest('tr');

                if (confirm('Tem certeza que deseja excluir esta observação?')) {
                    $.ajax({
                        url: `/medidas/observacao/${observacaoId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(300, function() {
                                    $(this).remove();

                                    // Verifica se não há mais observações
                                    if ($('.table tbody tr').length === 0) {
                                        $('.table tbody').append(
                                            '<tr><td colspan="4" class="text-center">Nenhuma observação registrada</td></tr>'
                                        );
                                    }
                                });
                            } else {
                                alert(response.message || 'Erro ao excluir observação');
                            }
                        },
                        error: function(xhr) {
                            console.error('Erro:', xhr);
                            alert('Erro ao excluir observação. Verifique o console para mais detalhes.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
