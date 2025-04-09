@extends('layouts.app')
@section('title', 'Demandas')

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Lista de Demandas</h3>
        </div>
        <div class="block-content">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Botão de adicionar demanda -->
                <a href="{{ route('demandas.create') }}" class="btn btn-primary">Adicionar Demanda</a>

                <!-- Formulário de busca -->
                <form method="GET" action="{{ route('demandas.index') }}" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por local de armazenamento"
                               value="{{ $search }}">
                        <select name="status" class="form-control ml-2">
                            <option value="">Todos os Status</option>
                            <option value="triagem" {{ $status == 'triagem' ? 'selected' : '' }}>Triagem</option>
                            <option value="demanda reprimida" {{ $status == 'demanda reprimida' ? 'selected' : '' }}>Demanda Reprimida</option>
                            <option value="atribuido" {{ $status == 'atribuido' ? 'selected' : '' }}>Atribuído</option>
                        </select>
                        <select name="classificacao" class="form-control ml-2">
                            <option value="">Todas as Classificações</option>
                            @foreach($classificacoes as $value => $label)
                                <option value="{{ $value }}" {{ $classificacao == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Buscar</button>
                            <a href="{{ route('demandas.index') }}" class="btn btn-outline-secondary">Limpar</a>
                        </div>
                    </div>
                </form>
            </div>

            @if($demandas->count())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <a href="{{ route('demandas.index', ['sort' => 'local_armazenamento', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Local de Armazenamento
                                @if($sort === 'local_armazenamento')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('demandas.index', ['sort' => 'classificacao', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Classificação
                                @if($sort === 'classificacao')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('demandas.index', ['sort' => 'status_administrativo', 'order' => $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                Status
                                @if($sort === 'status_administrativo')
                                    <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>Unidade</th>
                        <th>Tipo</th>
                        <th>Data Triagem</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($demandas as $demanda)
                        <tr>
                            <td>{{ $demanda->id }}</td>
                            <td>{{ $demanda->local_armazenamento }}</td>
                            <td>{{ ucfirst($demanda->classificacao) }}</td>
                            <td>{{ ucfirst($demanda->status_administrativo) }}</td>
                            <td>{{ $demanda->unidade->nome }}</td>
                            <td>{{ $demanda->tipo->nome }}</td>
                            <td>{{ $demanda->data_triagem ? \Carbon\Carbon::parse($demanda->data_triagem)->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('demandas.show', $demanda->id) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('demandas.edit', $demanda->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('demandas.destroy', $demanda->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja deletar esta demanda?');">
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

                {{ $demandas->appends(request()->query())->links() }}
            @else
                <div class="alert alert-warning">
                    Nenhuma demanda cadastrada.
                </div>
            @endif

        </div>
    </div>
@endsection
