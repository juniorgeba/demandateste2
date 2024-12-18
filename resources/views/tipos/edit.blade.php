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
            Edição de Tipo de Demanda
        </div>
        <div class="card-body">
            <form action="{{ route('tipos.update', $tipo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Tipo</label>
                    <input type="text"
                           class="form-control"
                           id="nome"
                           name="nome"
                           value="{{ old('nome', $tipo->nome) }}"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Tipo</button>
                <a href="{{ route('tipos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
