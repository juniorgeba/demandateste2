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
            Editar Usuário
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Primeira Coluna -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="sobrenome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ old('sobrenome', $user->sobrenome) }}">
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf" id="cpf" name="cpf" value="{{ old('cpf', $user->cpf) }}">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="ativo" {{ old('status', $user->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="inativo" {{ old('status', $user->status) == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Segunda Coluna -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="funcao" class="form-label">Perfil de acesso</label>
                            <select class="form-control" id="funcao" name="funcao">
                                <option value="">Selecione a Perfil</option>
                                <option value="administrativo" {{ old('funcao', $user->funcao) == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="tecnico" {{ old('funcao', $user->funcao) == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="coordenacao" {{ old('funcao', $user->funcao) == 'coordenacao' ? 'selected' : '' }}>Coordenação</option>
                                <option value="gestao" {{ old('funcao', $user->funcao) == 'gestao' ? 'selected' : '' }}>Gestão</option>
                                <option value="vigilancia" {{ old('funcao', $user->funcao) == 'vigilancia' ? 'selected' : '' }}>Vigilância</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="unidade" class="form-label">Unidade</label>
                            <select class="form-control" id="unidade" name="unidade_id" required>
                                <option value="">Selecione a Unidade</option>
                                @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}" {{ old('unidade_id', $user->unidade_id) == $unidade->id ? 'selected' : '' }}>
                                        {{ $unidade->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        //Mascaras
        $(document).ready(function () {
            $('.cep').mask('00000-000');
            $('.phone_with_ddd').mask('(00) 0000-0000');
            $('.cpf').mask('000.000.000-00', {reverse: true});
            $('.money').mask('000.000.000.000.000,00', {reverse: true});
            $('.money2').mask("#.##0,00", {reverse: true});
        });
    </script>
@endsection
