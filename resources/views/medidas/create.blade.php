@extends('layouts.app')

@section('title', 'Cadastro de Medida')

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
                            <label for="pessoa_id" class="form-label">Nome do adolescente*</label>
                            <select id="pessoa_id" name="pessoa_id" class="form-control" required>
                                <option value="">Selecione um adolescente</option>
                                @foreach($pessoas as $pessoa)
                                    <option value="{{ $pessoa->id }}" {{ old('pessoa_id') == $pessoa->id ? 'selected' : '' }}>
                                        {{ $pessoa->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tecnico_user_id" class="form-label">Técnico Responsável*</label>
                            <select id="tecnico_user_id" name="tecnico_user_id" class="form-control" required>
                                <option value="">Selecione um técnico</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ old('tecnico_user_id') == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="status" class="form-check-input" id="status"
                                    {{ old('status') ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Aguardando Decisão Judicial - ADJ</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="natureza" class="form-label">Natureza</label>
                            <select id="natureza" name="natureza" class="form-control">
                                <option value="">Selecione um motivo</option>
                                <option value="LA" {{ old('natureza') == 'LA' ? 'selected' : '' }}>LA</option>
                                <option value="PSC" {{ old('natureza') == 'PSC' ? 'selected' : '' }}>PSC</option>
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
                            <select id="motivo_infracao" name="motivo_infracao" class="form-control" required>
                                <option value="">Selecione um motivo</option>
                                <option value="furto" {{ old('motivo_infracao') == 'furto' ? 'selected' : '' }}>Furto</option>
                                <option value="roubo" {{ old('motivo_infracao') == 'roubo' ? 'selected' : '' }}>Roubo</option>
                                <option value="tráfico de drogas" {{ old('motivo_infracao') == 'tráfico de drogas' ? 'selected' : '' }}>Tráfico de Drogas</option>
                                <option value="lesão corporal" {{ old('motivo_infracao') == 'lesão corporal' ? 'selected' : '' }}>Lesão Corporal</option>
                                <option value="homicídio" {{ old('motivo_infracao') == 'homicídio' ? 'selected' : '' }}>Homicídio</option>
                                <option value="porte ilegal de arma" {{ old('motivo_infracao') == 'porte ilegal de arma' ? 'selected' : '' }}>Porte Ilegal de Arma</option>
                                <option value="vandalismo" {{ old('motivo_infracao') == 'vandalismo' ? 'selected' : '' }}>Vandalismo</option>
                                <option value="ameaça" {{ old('motivo_infracao') == 'ameaça' ? 'selected' : '' }}>Ameaça</option>
                                <option value="digirir sem habilitação" {{ old('motivo_infracao') == 'digirir sem habilitação' ? 'selected' : '' }}>Digirir sem Habilitação</option>
                                <option value="Receptação" {{ old('motivo_infracao') == 'Receptação' ? 'selected' : '' }}>Receptação</option>
                                <option value="violência sexual" {{ old('motivo_infracao') == 'violência sexual' ? 'selected' : '' }}>Violência Sexual</option>
                                <option value="fuga" {{ old('motivo_infracao') == 'fuga' ? 'selected' : '' }}>Fuga</option>
                                <option value="outro" {{ old('motivo_infracao') == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="cod_motivo_infracao" class="form-label">Código da infração</label>
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
            // Inicializa o Select2 nos campos especificados
            $('#pessoa_id').select2({
                theme: 'bootstrap-5',
                placeholder: "Selecione uma pessoa",
                allowClear: true
            });

            $('#tecnico_user_id').select2({
                theme: 'bootstrap-5',
                placeholder: "Selecione um técnico",
                allowClear: true
            });

        });
    </script>
@endsection
