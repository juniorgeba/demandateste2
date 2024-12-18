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
            Cadastro de Violência
        </div>
        <div class="card-body">
            <form action="{{ route('violencias.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome da Violência</label>
                    <input type="text"
                           class="form-control"
                           id="nome"
                           name="nome"
                           value="{{ old('nome') }}"
                           required>
                </div>

                <button type="submit" class="btn btn-success">Salvar Violência</button>
                <a href="{{ route('violencias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>

@endsection
