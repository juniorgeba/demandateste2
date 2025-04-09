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
            Editar Pessoa
        </div>
        <div class="card-body">
            <form action="{{ route('pessoas.update', $pessoa->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Primeira Coluna - Dados Pessoais -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Dados Pessoais</h5>

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo*</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $pessoa->nome) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="genero" class="form-label">Gênero*</label>
                            <select class="form-control" id="genero" name="genero" required>
                                <option value="">Selecione o Gênero</option>
                                <option value="masculino" {{ old('genero', $pessoa->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="feminino" {{ old('genero', $pessoa->genero) == 'feminino' ? 'selected' : '' }}>Feminino</option>
                                <option value="lgbt" {{ old('genero', $pessoa->genero) == 'lgbt' ? 'selected' : '' }}>LGBT</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="deficiencia" class="form-label">Deficiência*</label>
                            <select class="form-control" id="deficiencia" name="deficiencia" required>
                                <option value="">Selecione</option>
                                <option value="nenhuma" {{ old('deficiencia', $pessoa->deficiencia) == 'nenhuma' ? 'selected' : '' }}>Nenhuma</option>
                                <option value="fisica" {{ old('deficiencia', $pessoa->deficiencia) == 'fisica' ? 'selected' : '' }}>Física</option>
                                <option value="visual" {{ old('deficiencia', $pessoa->deficiencia) == 'visual' ? 'selected' : '' }}>Visual</option>
                                <option value="auditiva" {{ old('deficiencia', $pessoa->deficiencia) == 'auditiva' ? 'selected' : '' }}>Auditiva</option>
                                <option value="mental" {{ old('deficiencia', $pessoa->deficiencia) == 'mental' ? 'selected' : '' }}>Mental</option>
                                <option value="multipla" {{ old('deficiencia', $pessoa->deficiencia) == 'multipla' ? 'selected' : '' }}>Múltipla</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento*</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $pessoa->data_nascimento) }}">
                        </div>

                        <div class="mb-3">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control" id="rg" name="rg" value="{{ old('rg', $pessoa->rg) }}">
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf" id="cpf" name="cpf" value="{{ old('cpf', $pessoa->cpf) }}">
                        </div>

                        <div class="mb-3">
                            <label for="naturalidade" class="form-label">Naturalidade</label>
                            <input type="text" class="form-control" id="naturalidade" name="naturalidade" value="{{ old('naturalidade', $pessoa->naturalidade) }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $pessoa->email) }}">
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control phone" id="telefone" name="telefone" value="{{ old('telefone', $pessoa->telefone) }}">
                        </div>
                    </div>

                    <!-- Segunda Coluna - Dados Familiares e Endereço -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Dados Familiares</h5>

                        <div class="mb-3">
                            <label for="nome_mae" class="form-label">Nome da Mãe</label>
                            <input type="text" class="form-control" id="nome_mae" name="nome_mae" value="{{ old('nome_mae', $pessoa->nome_mae) }}">
                        </div>

                        <div class="mb-3">
                            <label for="nome_pai" class="form-label">Nome do Pai</label>
                            <input type="text" class="form-control" id="nome_pai" name="nome_pai" value="{{ old('nome_pai', $pessoa->nome_pai) }}">
                        </div>

                        <div class="mb-3">
                            <label for="nome_responsavel" class="form-label">Nome do Responsável</label>
                            <input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" value="{{ old('nome_responsavel', $pessoa->nome_responsavel) }}">
                        </div>

                        <div class="mb-3">
                            <label for="grau_parentesco_responsavel" class="form-label">Grau de Parentesco do Responsável</label>
                            <select class="form-control" id="grau_parentesco_responsavel" name="grau_parentesco_responsavel">
                                <option value="">Selecione o Grau de Parentesco</option>
                                <option value="pai" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'pai' ? 'selected' : '' }}>Pai</option>
                                <option value="mae" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'mae' ? 'selected' : '' }}>Mãe</option>
                                <option value="avo" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'avo' ? 'selected' : '' }}>Avô/Avó</option>
                                <option value="tio" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'tio' ? 'selected' : '' }}>Tio/Tia</option>
                                <option value="irmao" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'irmao' ? 'selected' : '' }}>Irmão/Irmã</option>
                                <option value="primo" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'primo' ? 'selected' : '' }}>Primo/Prima</option>
                                <option value="padrasto" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'padrasto' ? 'selected' : '' }}>Padrasto</option>
                                <option value="madrasta" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'madrasta' ? 'selected' : '' }}>Madrasta</option>
                                <option value="tutor" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'tutor' ? 'selected' : '' }}>Tutor Legal</option>
                                <option value="outro" {{ old('grau_parentesco_responsavel', $pessoa->grau_parentesco_responsavel) == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="rg_responsavel" class="form-label">RG Responsável</label>
                            <input type="text" class="form-control" id="rg_responsavel" name="rg_responsavel" value="{{ old('rg_responsavel', $pessoa->rg_responsavel) }}">
                        </div>

                        <div class="mb-3">
                            <label for="cpf_responsavel" class="form-label">CPF Responsável</label>
                            <input type="text" class="form-control cpf" id="cpf_responsavel" name="cpf_responsavel" value="{{ old('cpf_responsavel', $pessoa->cpf_responsavel) }}">
                        </div>

                        <div class="mb-3">
                            <label for="telefone_responsavel" class="form-label">Telefone Responsável</label>
                            <input type="text" class="form-control phone" id="telefone_responsavel" name="telefone_responsavel" value="{{ old('telefone_responsavel', $pessoa->telefone_responsavel) }}">
                        </div>

                        <h5 class="mb-3 mt-4">Endereço</h5>

                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control cep" id="cep" name="cep" value="{{ old('cep', $pessoa->cep) }}">
                        </div>

                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('endereco', $pessoa->endereco) }}">
                        </div>

                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero', $pessoa->numero) }}">
                        </div>

                        <div class="mb-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" value="{{ old('complemento', $pessoa->complemento) }}">
                        </div>

                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro', $pessoa->bairro) }}">
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Atualizar Pessoa</button>
                    <a href="{{ route('pessoas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.cep').mask('00000-000');
            $('.cpf').mask('000.000.000-00', {reverse: true});
        });

        var maskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {onKeyPress: function(val, e, field, options) {
                    field.mask(maskBehavior.apply({}, arguments), options);
                }
            };

        $('.phone').mask(maskBehavior, options);

        $('#cep').blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != "") {
                var validacep = /^[0-9]{8}$/;
                if(validacep.test(cep)) {
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            $("#endereco").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                        }
                    });
                }
            }
        });
    </script>
@endsection
