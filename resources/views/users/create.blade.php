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
            Cadastro de Usuário
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Primeira Coluna -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="sobrenome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}">
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf" id="cpf" name="cpf" value="{{ old('cpf') }}">
                        </div>
                    </div>

                    <!-- Segunda Coluna -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="funcao" class="form-label">Perfil de acesso</label>
                            <select class="form-control" id="funcao" name="funcao">
                                <option value="">Selecione a Perfil</option>
                                <option value="administrativo" {{ old('funcao') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="tecnico" {{ old('funcao') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="coordenacao" {{ old('funcao') == 'coordenacao' ? 'selected' : '' }}>Coordenação</option>
                                <option value="gestao" {{ old('funcao') == 'gestao' ? 'selected' : '' }}>Gestão</option>
                                <option value="vigilancia" {{ old('funcao') == 'vigilancia' ? 'selected' : '' }}>Vigilância</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="unidade" class="form-label">Unidade</label>
                            <select class="form-control" id="unidade" name="unidade_id" required>
                                <option value="">Selecione a Unidade</option>
                                @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}" {{ old('unidade_id') == $unidade->id ? 'selected' : '' }}>
                                        {{ $unidade->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Salvar Usuário</button>
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
