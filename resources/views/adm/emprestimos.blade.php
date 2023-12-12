@extends('layouts.layoutadm')

@section('conteudo')

{{-- Filtrar Empréstimos --}}
<div class="card mt-4" >
    <div class="card-header">
        Filtrar Empréstimos
    </div>

    <div class="card-body">
        <form action="{{ route('adm.emprestimos.index') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" id="filter_usuario" name="name"  value="{{ request('name') }}" class="form-control" placeholder="Filtrar por Usuário">
                        <label for="filter_usuario">Filtrar por nome de Usuário</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 mt-2 mt-md-0">
                    <div class="form-floating mb-3">
                        <input type="text" id="filter_livro" name="titulo" value="{{ request('titulo') }}" class="form-control" placeholder="Filtrar por Livro">
                        <label for="filter_livro">Filtrar por título do Livro</label>
                    </div>
                </div>

                <div class="col-12 mt-2">
                    <div class="form-floating mb-3">
                        <select class="form-select" aria-label="select-status" id="filter_status" name="status" placeholder="Filtrar por Status">
                            <option value="" >Filtrar por Status</option>
                            <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : ''}}>Pendente</option>
                            <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : ''}}>Confirmado</option>
                            <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : ''}}>Atrasado</option>
                        </select>
                
                        <label for="filter_status">Filtrar por Status</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-2">Filtrar Empréstimos</button>
        </form>
    </div>
</div>

{{-- Tabela de Empréstimos --}}
<div class="card mt-4" id="emprestimosTable">
    <div class="card-header">
       Empréstimos
    </div>

    <div class="card-body">
        @if (session('success-delete'))
            <div class="mt-3 alert alert-success">{{ session('success-delete')}} </div>
        @elseif (session('error-delete'))
            <div class="mt-3 alert alert-danger">{{ session('error-delete')}} </div>
        @elseif (session('error-update'))
            <div class="mt-3 alert alert-danger">{{ session('error-update')}} </div>
        @elseif (session('success-update'))
            <div class="mt-3 alert alert-success">{{ session('success-update')}} </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Livro</th>
                        <th>Data de Empréstimo</th>
                        <th>Data de Devolução</th>
                        <th>Status</th>
                        <th colspan="3">Ação</th>
                    </tr>
                </thead>
    
                <tbody>
                    @foreach ($emprestimos as $e)             
                        <tr id="emprestimo-{{$e->id}}">
                            <td>{{ $e->user->name }}</td>
                            <td>{{ $e->livro->titulo }}</td>
                            <td>{{ $e->data_emprestimo ? $e->data_emprestimo->format('d/m/Y') : 'não confirmada!' }}</td>
                            <td>{{ $e->devolucao ? $e->devolucao->format('d/m/Y').' às 00:00' : 'Não confirmada!'}}</td>
                            <td>{{ $e->status }}</td>
                            <td>
                                @if ($e->livro->estoque >= 0 && $e->status != 'confirmado')
                                <form action="{{ route('adm.emprestimos.update', ['id' => $e->id, 'status' => 'confirmado']) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Confirmar</button>
                                </form>
                                @elseif ($e->status == 'confirmado')
                                    <form action="{{ route('adm.emprestimos.update', ['id' => $e->id, 'status' => 'devolvido']) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">Confirmar devolução</button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($e->status != 'confirmado')
                                <form action="{{ route('adm.emprestimos.update', ['id' => $e->id, 'status' => 'recusado' ]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning btn-sm">Recusar</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('adm.emprestimos.destroy', ['emprestimo' => $e->id ]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>   
    </div>
</div>

{{-- Emprestimos devolvidos e recusados --}}
@if ($emprestimos_devolvidos)
<div class="card mt-4 old-card">
    <div class="card-header">
        Empréstimos devolvidos e recusados
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-secondary">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Livro</th>
                        <th>Data de Empréstimo</th>
                        <th>Data de Devolução</th>
                        <th>Status</th>
                        <th colspan="2">Ação</th>

                    </tr>
                </thead>
    
                <tbody>
                    @foreach ($emprestimos_devolvidos as $e)             
                        <tr id="emprestimo-{{$e->id}}">
                            <td>{{ $e->user->name }}</td>
                            <td>{{ $e->livro->titulo }}</td>
                            <td>{{ $e->data_emprestimo ? $e->data_emprestimo->format('d/m/Y') : 'não confirmada!' }}</td>
                            <td>{{ $e->devolucao ? $e->devolucao->format('d/m/Y').' às 00:00' : 'Não confirmada!'}}</td>
                            <td>{{ $e->status }}</td>
                            <td>
                                @if ($e->livro->estoque > 0)
                                <form action="{{ route('adm.emprestimos.update', ['id' => $e->id, 'status' => 'pendente']) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Desfazer devolução/recusa</button>
                                </form>
                                @else 
                                    Livros insuficiente no estoque!
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('adm.emprestimos.destroy', ['emprestimo' => $e->id ]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>   
    </div>
</div>
@endif
@endsection
