@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Detalhes da Origem</span>
            <div>
                <a href="{{ route('origens.edit', $origem->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('origens.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-3">Informações da Origem</h5>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th width="200">Nome:</th>
                            <td>{{ $origem->nome }}</td>
                        </tr>
                        <tr>
                            <th>Cadastrado Por:</th>
                            <td>{{ $origem->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Data de Criação:</th>
                            <td>{{ $origem->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td>{{ $origem->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
