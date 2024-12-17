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
            Cadastro de Medida
        </div>
        <div class="card-body">
            <form action="{{ route('medidas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Primeira Coluna - Dados da Medida -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Dados da Medida</h5>

                        <div class="mb-3">
                            <label for="pessoa_id" class="form-label">Pessoa*</label>
                            <select name="pessoa_id" class="form-control" required>
                                <option value="">Selecione uma pessoa</option>
                                @foreach($pessoas as $pessoa)
                                    <option value="{{ $pessoa->id }}" {{ old('pessoa_id') == $pessoa->id ? 'selected' : '' }}>
                                        {{ $pessoa->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tecnico_user_id" class="form-label">Técnico Responsável*</label>
                            <select name="tecnico_user_id" class="form-control" required>
                                <option value="">Selecione um técnico</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ old('tecnico_user_id') == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="prazo_meses" class="form-label">Prazo (meses)*</label>
                            <input type="number" name="prazo_meses" class="form-control" value="{{ old('prazo_meses') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="data_entrada_no_creas" class="form-label">Data de Entrada no CREAS*</label>
                            <input type="date" name="data_entrada_no_creas" class="form-control" value="{{ old('data_entrada_no_creas') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="motivo_infracao" class="form-label">Motivo da Infração*</label>
                            <input type="text" name="motivo_infracao" class="form-control" value="{{ old('motivo_infracao') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="cod_motivo_infracao" class="form-label">Código do Motivo</label>
                            <input type="text" name="cod_motivo_infracao" class="form-control" value="{{ old('cod_motivo_infracao') }}">
                        </div>
                    </div>

                    <!-- Segunda Coluna - Informações Adicionais -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Informações Adicionais</h5>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="egresso" class="form-check-input" id="egresso"
                                    {{ old('egresso') ? 'checked' : '' }}>
                                <label class="form-check-label" for="egresso">Egresso</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="possui_irmao_em_atedimento" class="form-check-input" id="irmao"
                                    {{ old('possui_irmao_em_atedimento') ? 'checked' : '' }}>
                                <label class="form-check-label" for="irmao">Possui Irmão em Atendimento</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="local_armazenamento" class="form-label">Local de Armazenamento</label>
                            <input type="text" name="local_armazenamento" class="form-control" value="{{ old('local_armazenamento') }}">
                        </div>

                        <div class="mb-3">
                            <label for="observacao" class="form-label">Observação Inicial*</label>
                            <textarea name="observacao" class="form-control" rows="3" required>{{ old('observacao') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="documentos" class="form-label">Documentos</label>
                            <input type="file" name="documentos[]" class="form-control" multiple>
                            <small class="form-text text-muted">Você pode selecionar múltiplos arquivos.</small>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Salvar Medida</button>
                    <a href="{{ route('medidas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Aqui você pode adicionar qualquer JavaScript necessário
            // como máscaras de input ou validações específicas
        });
    </script>
@endsection
