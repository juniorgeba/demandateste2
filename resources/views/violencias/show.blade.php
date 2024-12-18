@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Detalhes da Violência</span>
            <div>
                <a href="{{ route('violencias.edit', $violencia->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('violencias.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Dados da Violência -->
                <div class="col-md-12">
                    <h5 class="mb-3">Informações da Violência</h5>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th width="200">Nome:</th>
                            <td>{{ $violencia->nome }}</td>
                        </tr>
                        <tr>
                            <th>Cadastrado Por:</th>
                            <td>{{ $violencia->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Data de Criação:</th>
                            <td>{{ $violencia->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td>{{ $violencia->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
