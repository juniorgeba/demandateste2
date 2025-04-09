@extends('layouts.app')

@section('title', 'Edição de Demanda')

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

                <div class="mb-3">
                    <h5>Denunciantes</h5>
                    <div id="denunciantes-container">
                        @foreach($demanda->denunciantes as $index => $denunciante)
                            <div class="denunciante">
                                <select name="denunciantes[{{ $index }}][pessoa_id]" class="form-control">
                                    <option value="">Selecione uma pessoa</option>
                                    @foreach($pessoas as $pessoa)
                                        <option value="{{ $pessoa->id }}" {{ $denunciante->pessoa_id == $pessoa->id ? 'selected' : '' }}>{{ $pessoa->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addDenunciante()" class="btn btn-secondary">Adicionar Denunciante</button>
                </div>
                <script>
                    let denuncianteCount = 1;

                    function addDenunciante() {
                        const container = document.getElementById('denunciantes-container');
                        const newDenunciante = document.createElement('div');
                        newDenunciante.classList.add('denunciante');
                        newDenunciante.innerHTML = `
            <select name="denunciantes[${denuncianteCount}][pessoa_id]" class="form-control">
                <option value="">Selecione uma pessoa</option>
                @foreach($pessoas as $pessoa)
                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome }}</option>
                @endforeach
                        </select>
`;
                        container.appendChild(newDenunciante);
                        denuncianteCount++;
                    }
                </script>



                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Atualizar Demanda</button>
                    <a href="{{ route('demandas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
