@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Lista de Unidades</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('unidades.create') }}" class="btn btn-primary">Adicionar Unidade</a>
        </div>

        @if($unidades->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Número Máximo de Atribuições por Técnico</th>
                    <th>Criada Por</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($unidades as $unidade)
                    <tr>
                        <td>{{ $unidade->nome }}</td>
                        <td>{{ $unidade->numero_max_atribuicoes_por_tecnico }}</td>
                        <td>{{ $unidade->criadoPor->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('unidades.show', $unidade->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('unidades.edit', $unidade->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('unidades.destroy', $unidade->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja deletar esta unidade?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $unidades->links() }} <!-- Paginação -->
        @else
            <div class="alert alert-warning">
                Nenhuma unidade cadastrada.
            </div>
        @endif
    </div>
@endsection