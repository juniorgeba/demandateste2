@extends('layouts.app')

@section('title', 'Detalhes da Demanda')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Detalhes da Demanda</span>
            <div>
                <a href="{{ route('demandas.edit', $demanda->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('demandas.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Primeira Coluna - Dados da Demanda -->
                <div class="col-md-6">
                    <h5 class="mb-3">Dados da Demanda</h5>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th width="200">Tipo:</th>
                            <td>{{ $demanda->tipo->nome }}</td>
                        </tr>
                        <tr>
                            <th>Violência:</th>
                            <td>{{ $demanda->violencia->nome }}</td>
                        </tr>
                        <tr>
                            <th>Local de Armazenamento:</th>
                            <td>{{ $demanda->local_armazenamento ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Classificação:</th>
                            <td>{{ ucfirst($demanda->classificacao) }}</td>
                        </tr>
                        <tr>
                            <th>Status Administrativo:</th>
                            <td>{{ ucfirst($demanda->status_administrativo) }}</td>
                        </tr>
                        <tr>
                            <th>Data de Triagem:</th>
                            <td>{{ $demanda->data_triagem_formatada }}</td>
                        </tr>
                        <tr>
                            <th>Data da Demanda Reprimida:</th>
                            <td>{{ $demanda->data_demanda_reprimida_formatada }}</td>
                        </tr>
                        <tr>
                            <th>Data da Atribuição:</th>
                            <td>{{ $demanda->data_atribuicao_formatada }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Segunda Coluna - Informações do Sistema -->
                <div class="col-md-6">
                    <h5 class="mb-3">Informações do Sistema</h5>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th width="200">Cadastrado por:</th>
                            <td>{{ $demanda->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Unidade:</th>
                            <td>{{ $demanda->unidade->nome }}</td>
                        </tr>
                        <tr>
                            <th>Data de Cadastro:</th>
                            <td>{{ $demanda->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td>{{ $demanda->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <h5>Denunciantes</h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Pessoa</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($demanda->denunciantes as $denunciante)
                        <tr>
                            <td>{{ $denunciante->user->name }}</td>
                            <td>{{ $denunciante->pessoa->nome }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Nenhum denunciante registrado</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>


            <!-- Seção de Observações -->
            {{--<div class="mt-4">
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
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($demanda->observacoes as $observacao)
                            <tr>
                                <td>{{ $observacao->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $observacao->user->name }}</td>
                                <td>{{ $observacao->observacao }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Nenhuma observação registrada</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>--}}

            <!-- Seção de Documentos -->
            {{--<div class="mt-4">
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
                        @forelse($demanda->documentos as $documento)
                            <tr>
                                <td>{{ $documento->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $documento->user->name }}</td>
                                <td>{{ $documento->nome_original }}</td>
                                <td>{{ number_format($documento->tamanho / 1024, 2) }} KB</td>
                                <td>
                                    <a href="{{ route('demandas.documento.download', $documento->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i>
                                    </a>
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
            </div>--}}

            <!-- Botões de Ação -->
            <div class="mt-4">
                <form action="{{ route('demandas.destroy', $demanda->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta demanda?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Excluir Demanda
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Nova Observação -->
    {{--<div class="modal fade" id="modalObservacao" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('demandas.observacao.store', $demanda->id) }}" method="POST">
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
    </div>--}}

    <!-- Modal de Novo Documento -->
    {{--<div class="modal fade" id="modalDocumento" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('demandas.documento.store', $demanda->id) }}" method="POST" enctype="multipart/form-data">
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
    </div>--}}
@endsection
