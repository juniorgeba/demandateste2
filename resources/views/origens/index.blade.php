@extends('layouts.app')

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Lista de Origens</h3>
        </div>
        <div class="block-content">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('origens.create') }}" class="btn btn-primary">Adicionar Origem</a>

                <form method="GET" action="{{ route('origens.index') }}" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nome"
                               value="{{ $search }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Buscar</button>
                            <a href="{{ route('origens.index') }}" class="btn btn-outline-secondary">Limpar</a>
                        </div>
                    </div>
                </form>
            </div>

            @if($origens->count())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <a href="{{ route('origens.index', ['sort' => 'nome', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Nome
                                @if($sort === 'nome')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>Cadastrado por</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($origens as $origem)
                        <tr>
                            <td>{{ $origem->id }}</td>
                            <td>{{ $origem->nome }}</td>
                            <td>{{ $origem->user->name }}</td>
                            <td>
                                <a href="{{ route('origens.show', $origem->id) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('origens.edit', $origem->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('origens.destroy', $origem->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja deletar esta origem?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" title="Deletar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $origens->appends(request()->query())->links() }}
            @else
                <div class="alert alert-warning">
                    Nenhuma origem cadastrada.
                </div>
            @endif

        </div>
    </div>
@endsection
