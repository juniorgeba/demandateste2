@extends('layouts.app')

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Lista de Pessoas</h3>
        </div>
        <div class="block-content">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Botão de adicionar pessoa -->
                <a href="{{ route('pessoas.create') }}" class="btn btn-primary">Adicionar Pessoa</a>

                <!-- Formulário de busca -->
                <form method="GET" action="{{ route('pessoas.index') }}" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nome ou CPF"
                               value="{{ $search }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Buscar</button>
                            <a href="{{ route('pessoas.index') }}" class="btn btn-outline-secondary">Limpar</a>
                        </div>
                    </div>
                </form>
            </div>

            @if($pessoas->count())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <a href="{{ route('pessoas.index', ['sort' => 'nome', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Nome
                                @if($sort === 'nome')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('pessoas.index', ['sort' => 'cpf', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                CPF
                                @if($sort === 'cpf')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('pessoas.index', ['sort' => 'data_nascimento', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Data de Nascimento
                                @if($sort === 'data_nascimento')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pessoas as $pessoa)
                        <tr>
                            <td>{{ $pessoa->id }}</td>
                            <td>{{ $pessoa->nome }}</td>
                            <td>{{ $pessoa->cpf ?? 'N/A' }}</td>
                            <td>{{ $pessoa->data_nascimento ? \Carbon\Carbon::parse($pessoa->data_nascimento)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $pessoa->telefone ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('pessoas.show', $pessoa->id) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pessoas.edit', $pessoa->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pessoas.destroy', $pessoa->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja deletar esta pessoa?');">
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

                {{ $pessoas->appends(request()->query())->links() }}
            @else
                <div class="alert alert-warning">
                    Nenhuma pessoa cadastrada.
                </div>
            @endif

        </div>
    </div>
@endsection
