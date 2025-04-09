@extends('layouts.app')
@section('title', 'Cadastro de Demanda')

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
            Cadastro de Demanda
        </div>
        <div class="card-body">
            <form action="{{ route('demandas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Primeira Coluna -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Informações da Demanda</h5>

                        <div class="mb-3">
                            <label for="tipo_id" class="form-label">Tipo de Demanda*</label>
                            <select class="form-control" id="tipo_id" name="tipo_id" required>
                                <option value="">Selecione o Tipo</option>
                                @foreach($tipos as $id => $nome)
                                    <option value="{{ $id }}" {{ old('tipo_id') == $id ? 'selected' : '' }}>
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
                                    <option value="{{ $id }}" {{ old('violencia_id') == $id ? 'selected' : '' }}>
                                        {{ $nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Segunda Coluna -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Detalhes Adicionais</h5>

                        <div class="mb-3">
                            <label for="local_armazenamento" class="form-label">Local de Armazenamento*</label>
                            <input type="text" class="form-control" id="local_armazenamento"
                                   name="local_armazenamento" value="{{ old('local_armazenamento') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="classificacao" class="form-label">Classificação*</label>
                            <select class="form-control" id="classificacao" name="classificacao" required>
                                <option value="">Selecione a Classificação</option>
                                @foreach($classificacoes as $value => $label)
                                    <option value="{{ $value }}" {{ old('classificacao') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h5>Denunciantes</h5>
                    <div id="denunciantes-container">
                        <div class="denunciante">
                            <select name="denunciantes[0][pessoa_id]" class="form-control">
                                <option value="">Selecione uma pessoa</option>
                                @foreach($pessoas as $pessoa)
                                    <option value="{{ $pessoa->id }}">{{ $pessoa->nome }}</option>
                                @endforeach
                            </select>
                        </div>
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
                    <button type="submit" class="btn btn-success">Salvar Demanda</button>
                    <a href="{{ route('demandas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
