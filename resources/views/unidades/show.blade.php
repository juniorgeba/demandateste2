@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Detalhes da Unidade</h1>

        <div class="card">
            <div class="card-header">
                Unidade: {{ $unidade->nome }}
            </div>
            <div class="card-body">
                <p><strong>Nome:</strong> {{ $unidade->nome }}</p>
                <p><strong>Número Máximo de Atribuições por Técnico:</strong> {{ $unidade->numero_max_atribuicoes_por_tecnico }}</p>
                <p><strong>Criada Por:</strong> {{ $unidade->criadoPor->name ?? 'N/A' }}</p>
                <p><strong>Data de Criação:</strong> {{ $unidade->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Última Atualização:</strong> {{ $unidade->updated_at->format('d/m/Y H:i') }}</p>

                <a href="{{ route('unidades.edit', $unidade->id) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('unidades.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@endsection
