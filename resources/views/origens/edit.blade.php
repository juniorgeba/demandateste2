@extends('layouts.app')

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
        <div class="card-header">
            Edição de Origem
        </div>
        <div class="card-body">
            <form action="{{ route('origens.update', $origem->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome da Origem</label>
                    <input type="text"
                           class="form-control"
                           id="nome"
                           name="nome"
                           value="{{ old('nome', $origem->nome) }}"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Origem</button>
                <a href="{{ route('origens.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

@endsection
