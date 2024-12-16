@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Detalhes da Unidade</span>
            <div>
                <a href="{{ route('unidades.edit', $unidade->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('unidades.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Dados da Unidade -->
                <div class="col-md-12">
                    <h5 class="mb-3">Informações da Unidade</h5>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th width="200">Nome:</th>
                            <td>{{ $unidade->nome }}</td>
                        </tr>
                        <tr>
                            <th>Número Máximo de Atribuições por Técnico:</th>
                            <td>{{ $unidade->numero_max_atribuicoes_por_tecnico }}</td>
                        </tr>
                        <tr>
                            <th>Criada Por:</th>
                            <td>{{ $unidade->criadoPor->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Data de Criação:</th>
                            <td>{{ $unidade->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td>{{ $unidade->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
