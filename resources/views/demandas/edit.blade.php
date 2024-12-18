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
            Edição de Demanda
        </div>
        <div class="card-body">
            <form action="{{ route('demandas.update', $demanda->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Primeira Coluna -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Informações da Demanda</h5>

                        <div class="mb-3">
                            <label for="tipo_id" class="form-label">Tipo de Demanda*</label>
                            <select class="form-control" id="tipo_id" name="tipo_id" required>
                                <option value="">Selecione o Tipo</option>
                                @foreach($tipos as $id => $nome)
                                    <option value="{{ $id }}"
                                        {{ old('tipo_id', $demanda->tipo_id) == $id ? 'selected' : '' }}>
                                        {{ $nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="violencia_id" class="form-label">Tipo de Violência*</label>
                            <select class="form-control" id="violencia_id" name="violencia_id" required>
                                <option value="">Selecione o Tipo de Violência</option>
                                @foreach($violencias as $id => $nome)
                                    <option value="{{ $id }}"
                                        {{ old('violencia_id', $demanda->violencia_id) == $id ? 'selected' : '' }}>
                                        {{ $nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="local_armazenamento" class="form-label">Local de Armazenamento*</label>
                            <input type="text" class="form-control" id="local_armazenamento"
                                   name="local_armazenamento"
                                   value="{{ old('local_armazenamento', $demanda->local_armazenamento) }}" required>
                        </div>
                    </div>

                    <!-- Segunda Coluna -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Status e Classificação</h5>

                        <div class="mb-3">
                            <label for="classificacao" class="form-label">Classificação*</label>
                            <select class="form-control" id="classificacao" name="classificacao" required>
                                <option value="">Selecione a Classificação</option>
                                @foreach($classificacoes as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('classificacao', $demanda->classificacao) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status_administrativo" class="form-label">Status Administrativo*</label>
                            <select class="form-control" id="status_administrativo" name="status_administrativo" required>
                                @foreach($status_administrativos as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('status_administrativo', $demanda->status_administrativo) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <p><strong>Data da Triagem:</strong> {{ $demanda->data_triagem->format('d/m/Y') }}</p>
                            @if($demanda->data_demanda_reprimida)
                                <p><strong>Data da Demanda Reprimida:</strong> {{ $demanda->data_demanda_reprimida->format('d/m/Y') }}</p>
                            @endif
                            @if($demanda->data_atribuicao)
                                <p><strong>Data da Atribuição:</strong> {{ $demanda->data_atribuicao->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Atualizar Demanda</button>
                    <a href="{{ route('demandas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
