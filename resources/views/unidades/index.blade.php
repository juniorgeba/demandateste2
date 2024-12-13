@extends('layouts.app')

@section('content')
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Lista de Unidades</h3>
            </div>
            <div class="block-content">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Botão de adicionar unidade -->
                    <a href="{{ route('unidades.create') }}" class="btn btn-primary">Adicionar Unidade</a>

                    <!-- Formulário de busca -->
                    <form method="GET" action="{{ route('unidades.index') }}" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nome"
                                   value="{{ $search }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary">Buscar</button>
                                <a href="{{ route('unidades.index') }}" class="btn btn-outline-secondary">Limpar</a>
                            </div>
                        </div>
                    </form>
                </div>

                @if($unidades->count())
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <a href="{{ route('unidades.index', ['sort' => 'nome', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Nome
                                    @if($sort === 'nome')
                                        <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('unidades.index', ['sort' => 'numero_max_atribuicoes_por_tecnico', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                    Número Máximo de Atribuições por Técnico
                                    @if($sort === 'numero_max_atribuicoes_por_tecnico')
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
                        @foreach($unidades as $unidade)
                            <tr>
                                <td>{{ $unidade->id }}</td>
                                <td>{{ $unidade->nome }}</td>
                                <td>{{ $unidade->numero_max_atribuicoes_por_tecnico }}</td>
                                <td>
                                    <a href="{{ route('unidades.show', $unidade->id) }}" class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i> <!-- Ícone de olho para "Ver" -->
                                    </a>
                                    <a href="{{ route('unidades.edit', $unidade->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i> <!-- Ícone de lápis para "Editar" -->
                                    </a>
                                    <form action="{{ route('unidades.destroy', $unidade->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Tem certeza que deseja deletar esta unidade?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" title="Deletar">
                                            <i class="fas fa-trash"></i> <!-- Ícone de lixeira para "Deletar" -->
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $unidades->appends(request()->query())->links() }} <!-- Paginação com parâmetros de query -->
                @else
                    <div class="alert alert-warning">
                        Nenhuma unidade cadastrada.
                    </div>
                @endif

            </div>
        </div>

@endsection
