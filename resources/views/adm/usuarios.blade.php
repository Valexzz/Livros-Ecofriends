@extends('layouts.layoutadm')

@section('conteudo')

<!-- Filtrar -->
<div class="card">
    <div class="card-header">
        Filtrar
    </div>
    <div class="card-body">
        <div class="form-group filter-form">
            <form action="{{ route('adm.usuarios') }}" method="get">
                @csrf
                <div class="row">

                    <div class="col-12">
                        <div class="form-floating">
                            <input class="form-control" id="filtro_name" type="text" value="{{ request('name') }}"  name="name" placeholder="Nome">
                            <label for="filtro_name">Nome</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mt-4">
                        <div class="form-floating">
                            <input class="form-control" id="filtro_matricula" type="text" value="{{ request('matricula') }}" name="matricula" placeholder="Matricula">
                            <label for="filtro_matricula">Matricula</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mt-4">
                        <div class="form-floating">
                            <select class="form-select "id="filtro_curso" name="curso_id">
                                <option value="">Curso</option>
                                @foreach ($cursos as $c)
                                <option value="{{ $c->id }}" {{ request('curso_id') == $c->id ? 'selected' : ''}}>{{ $c->descricao }}</option>
                                @endforeach
                            </select> 
                            <label for="filtro_curso">Curso</label>
                        </div>
                    </div>
                    
                </div>

                <button class="mt-2 btn btn-success"type="submit">Filtrar</button>
            </form>
        </div>
    </div>
</div>


<div class="card mt-4" id="usersTable">
    <div class="card-header">
        Listagem de Usuários
    </div>

    <!-- User tabela -->
    <div class="card-body">
        @if (session('success-delete'))
            <div class="mt-3 alert alert-success">{{ session('success-delete')}} </div>
        @elseif (session('error-delete'))
            <div class="mt-3 alert alert-danger">{{ session('error-delete')}} </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Curso</th>
                        <th>Email</th>
                        <th>Ano</th>
                        <th>Telefone</th>
                        <th colspan="2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <!-- Sample user data rows -->
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->matricula }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->curso->descricao }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->ano }}</td>
                            <td>{{ $u->telefone }}</td>
                            @if ($u->id != $user->id)
                            <td>
                                <form id="id-{{ $u->id }}" action="{{ route('adm.usuarios.giveAdm', ['id' => $u->id , 'give' => $u->adm == '0' ? '1' : '0']) }}" method="POST">
                                    @method('PUT') 
                                    @csrf 
                                    <button @class(['btn', 
                                    'btn-success' => $u->adm == '0' ? true : false, 
                                    'btn-danger' => $u->adm == '1' ? true : false]) 
                                    type="submit">{{$u->adm == '1' ? 'Remover ADM' : 'Conceder ADM'}}</button>
                                </form>
                            </td>
                            <td>
                                @if ($u->emprestimos->count())
                                    Usuário tem empréstimos!
                                @else
                                    <form id="id-{{ $u->id }}" action="{{ route('adm.usuarios.destroy', ['id' => $u->id , 'give' => $u->adm == '0' ? '1' : '0']) }}" method="POST">
                                        @method('DELETE') 
                                        @csrf 
                                        <button class="btn btn-danger" type="submit">Remover</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection