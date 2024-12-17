@extends('layouts.app')

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Lista de Medidas</h3>
        </div>
        <div class="block-content">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Botão de adicionar medida -->
                <a href="{{ route('medidas.create') }}" class="btn btn-primary">Nova Medida</a>

                <!-- Formulário de busca e filtros -->
                <form method="GET" action="{{ route('medidas.index') }}" class="form-inline">
                    <div class="input-group">
                        <select name="status" class="form-control me-2">
                            <option value="">Todos os Status</option>
                            <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="adj" {{ request('status') == 'adj' ? 'selected' : '' }}>ADJ</option>
                            <option value="desligado" {{ request('status') == 'desligado' ? 'selected' : '' }}>Desligado</option>
                        </select>
                        <input type="text" name="search" class="form-control"
                               placeholder="Buscar por nome da pessoa"
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Buscar</button>
                            <a href="{{ route('medidas.index') }}" class="btn btn-outline-secondary">Limpar</a>
                        </div>
                    </div>
                </form>
            </div>

            @if($medidas->count())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <a href="{{ route('medidas.index', ['sort' => 'pessoa', 'order' => request('order', 'asc') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'order'])) }}">
                                Pessoa
                                @if(request('sort') === 'pessoa')
                                    <i class="fas fa-sort-{{ request('order', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('medidas.index', ['sort' => 'tecnico', 'order' => request('order', 'asc') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'order'])) }}">
                                Técnico Responsável
                                @if(request('sort') === 'tecnico')
                                    <i class="fas fa-sort-{{ request('order', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('medidas.index', ['sort' => 'data_entrada_no_creas', 'order' => request('order', 'asc') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'order'])) }}">
                                Data Entrada CREAS
                                @if(request('sort') === 'data_entrada_no_creas')
                                    <i class="fas fa-sort-{{ request('order', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th>Prazo (meses)</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($medidas as $medida)
                        <tr>
                            <td>{{ $medida->id }}</td>
                            <td>{{ $medida->pessoa->nome }}</td>
                            <td>{{ $medida->tecnico->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($medida->data_entrada_no_creas)->format('d/m/Y') }}</td>
                            <td>{{ $medida->prazo_meses }}</td>
                            <td>{!! $medida->status_formatado !!}</td>
                            <td>
                                <a href="{{ route('medidas.show', $medida->id) }}"
                                   class="btn btn-info btn-sm"
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($medida->status !== 'desligado')
                                    <a href="{{ route('medidas.edit', $medida->id) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            title="Desligar"
                                            onclick="confirmarDesligamento({{ $medida->id }})">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $medidas->appends(request()->query())->links() }}
            @else
                <div class="alert alert-warning">
                    Nenhuma medida encontrada.
                </div>
            @endif

        </div>
    </div>

    <!-- Modal de Desligamento -->
    <div class="modal fade" id="modalDesligamento" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Desligamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formDesligamento" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="motivo_desligamento" class="form-label">Motivo do Desligamento</label>
                            <textarea class="form-control"
                                      id="motivo_desligamento"
                                      name="motivo_desligamento"
                                      required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Confirmar Desligamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function confirmarDesligamento(medidaId) {
            // Encontra o modal
            const modalElement = document.getElementById('modalDesligamento');
            if (!modalElement) {
                console.error('Modal não encontrado');
                return;
            }

            // Inicializa o modal
            const modal = new bootstrap.Modal(modalElement);

            // Configura o formulário
            const form = document.getElementById('formDesligamento');
            if (!form) {
                console.error('Formulário não encontrado');
                return;
            }

            // Define a URL do formulário
            form.action = `/medidas/${medidaId}/desligar`;

            // Limpa o campo de motivo
            const motivoField = document.getElementById('motivo_desligamento');
            if (motivoField) {
                motivoField.value = '';
            }

            // Mostra o modal
            modal.show();
        }

        // Adiciona validação ao formulário
        document.getElementById('formDesligamento').addEventListener('submit', function(e) {
            const motivo = document.getElementById('motivo_desligamento').value.trim();
            if (!motivo) {
                e.preventDefault();
                alert('Por favor, informe o motivo do desligamento.');
                return false;
            }
        });
    </script>
@endpush

