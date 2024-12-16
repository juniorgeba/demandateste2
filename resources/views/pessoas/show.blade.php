@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Detalhes da Pessoa</span>
            <div>
                <a href="{{ route('pessoas.edit', $pessoa->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('pessoas.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Primeira Coluna - Dados Pessoais -->
                <div class="col-md-6">
                    <h5 class="mb-3">Dados Pessoais</h5>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th width="200">Nome Completo:</th>
                            <td>{{ $pessoa->nome }}</td>
                        </tr>
                        <tr>
                            <th>Gênero:</th>
                            <td>{{ ucfirst($pessoa->genero) }}</td>
                        </tr>
                        <tr>
                            <th>Deficiência:</th>
                            <td>{{ ucfirst($pessoa->deficiencia) }}</td>
                        </tr>
                        <tr>
                            <th>Data de Nascimento:</th>
                            <td>{{ $pessoa->data_nascimento ? \Carbon\Carbon::parse($pessoa->data_nascimento)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>CPF:</th>
                            <td>{{ $pessoa->cpf ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>E-mail:</th>
                            <td>{{ $pessoa->email ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Telefone:</th>
                            <td>{{ $pessoa->telefone ?: '-' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Segunda Coluna - Dados Familiares e Endereço -->
                <div class="col-md-6">
                    <h5 class="mb-3">Dados Familiares</h5>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th width="200">Nome da Mãe:</th>
                            <td>{{ $pessoa->nome_mae ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nome do Pai:</th>
                            <td>{{ $pessoa->nome_pai ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nome do Responsável:</th>
                            <td>{{ $pessoa->nome_responsavel ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Grau de Parentesco:</th>
                            <td>
                                @switch($pessoa->grau_parentesco_responsavel)
                                    @case('pai') Pai @break
                                    @case('mae') Mãe @break
                                    @case('avo') Avô/Avó @break
                                    @case('tio') Tio/Tia @break
                                    @case('irmao') Irmão/Irmã @break
                                    @case('primo') Primo/Prima @break
                                    @case('padrasto') Padrasto @break
                                    @case('madrasta') Madrasta @break
                                    @case('tutor') Tutor Legal @break
                                    @case('outro') Outro @break
                                    @default -
                                @endswitch
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <h5 class="mb-3 mt-4">Endereço</h5>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th width="200">CEP:</th>
                            <td>{{ $pessoa->cep ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Endereço:</th>
                            <td>{{ $pessoa->endereco ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Número:</th>
                            <td>{{ $pessoa->numero ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bairro:</th>
                            <td>{{ $pessoa->bairro ?: '-' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <h5 class="mb-3">Informações do Sistema</h5>
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th width="200">Cadastrado por:</th>
                        <td>{{ $pessoa->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Data de Cadastro:</th>
                        <td>{{ $pessoa->created_at ? $pessoa->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Última Atualização:</th>
                        <td>{{ $pessoa->updated_at ? $pessoa->updated_at->format('d/m/Y H:i:s') : '-' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <form action="{{ route('pessoas.destroy', $pessoa->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Excluir Pessoa
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
