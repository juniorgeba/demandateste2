@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Criar Nova Unidade</h1>

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
            <div class="card-header">
                Formulário de Unidade
            </div>
            <div class="card-body">
                <form action="{{ route('unidades.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Unidade</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="numero_max_atribuicoes_por_tecnico" class="form-label">Número Máximo de Atribuições por Técnico</label>
                        <input type="number" class="form-control" id="numero_max_atribuicoes_por_tecnico" name="numero_max_atribuicoes_por_tecnico" value="{{ old('numero_max_atribuicoes_por_tecnico') }}" required min="1">
                    </div>

                    <button type="submit" class="btn btn-success">Salvar Unidade</button>
                    <a href="{{ route('unidades.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection