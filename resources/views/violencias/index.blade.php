@extends('layouts.app')

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Lista de Violências</h3>
        </div>
        <div class="block-content">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Botão de adicionar violência -->
                <a href="{{ route('violencias.create') }}" class="btn btn-primary">Adicionar Violência</a>

                <!-- Formulário de busca -->
                <form method="GET" action="{{ route('violencias.index') }}" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nome"
                               value="{{ $search }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Buscar</button>
                            <a href="{{ route('violencias.index') }}" class="btn btn-outline-secondary">Limpar</a>
                        </div>
                    </div>
                </form>
            </div>

            @if($violencias->count())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <a href="{{ route('violencias.index', ['sort' => 'nome', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Nome
                                @if($sort === 'nome')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('violencias.index', ['sort' => 'user_id', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Cadastrado por
                                @if($sort === 'user_id')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($violencias as $violencia)
                        <tr>
                            <td>{{ $violencia->id }}</td>
                            <td>{{ $violencia->nome }}</td>
                            <td>{{ $violencia->user->name }}</td>
                            <td>
                                <a href="{{ route('violencias.show', $violencia->id) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('violencias.edit', $violencia->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('violencias.destroy', $violencia->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja deletar esta violência?');">
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

                {{ $violencias->appends(request()->query())->links() }}
            @else
                <div class="alert alert-warning">
                    Nenhuma violência cadastrada.
                </div>
            @endif

        </div>
    </div>
@endsection
