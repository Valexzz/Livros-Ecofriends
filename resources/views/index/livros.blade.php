@extends('layouts.layout')

@section('conteudo')
<div class="card">
    <div class="card-header">
        Filtrar
    </div>
    <div class="card-body">
        <form action="{{ route('livros.index') }} " method="get">
            @csrf
            <div class="row">
                <div class="col-12 col-md-4 mt-md-0">
                    <div class="form-floating">
                        <input class="form-control" type="text" value="{{ request('titulo') }}" id="filtro-titulo" name="titulo" placeholder="Filtrar por título">
                        <label for="filtro-titulo">Título</label>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                    <div class="form-floating">
                        <select class="form-select" aria-label="select-conhecimento" id="filtro_area_conhecimento" name="area_conhecimento_id">
                            <option value="">Área de conhecimento</option>
                            @foreach($areas_conhecimento as $ac)
                                <option value="{{$ac->id}}" {{ request('area_conhecimento_id') == $ac->id ? 'selected' : ''}}>{{$ac->descricao}}</option>
                            @endforeach
                        </select>
                        <label for="filtro_area_conhecimento">Área de conhecimento</label>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-4 mt-md-0">
                    <div class="form-floating">
                        <input class="form-control" type="text" value="{{ request('numero_cadastro') }}" id="filtro-numero-cadastro" name="numero_cadastro" placeholder="Filtrar por número de cadastro">
                        <label for="filtro-numero-cadastro">Número de cadastro</label>
                    </div>
                </div>
            </div>

            <button class="mt-2 btn btn-success" type="submit">Filtrar Livros</button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        Livros
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($livros as $l)
                <div class="col-12 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="titulo">{{ $l->titulo }}</h2>
                        </div>
                        <div class="card-body">
                            <p><strong>Área de Conhecimento: </strong>{{ $l->areaConhecimento->descricao }}</p>
                            <p><strong>Número de Registro: </strong> {{ $l->numero_cadastro }}</p>
                            <p><strong>Em estoque:</strong> {{ $l->estoque }}</p>
                            <form method="POST" action="{{ route('emprestimos.store') }}">
                                @csrf
                                <input type="hidden" value=" {{ $l->id }} " name="livro" >
                                <button class="btn btn-success" type="submit" >Realizar empréstimo</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@if ($livros_fora->count())
    <div class="card mt-4">
        <div class="card-header">
            Livros Fora de estoque
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($livros_fora as $l)
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="titulo">{{ $l->titulo }}</h2>
                            </div>
                            <div class="card-body">
                                <p><strong>Área de Conhecimento: </strong>{{ $l->areaConhecimento->descricao }}</p>
                                <p><strong>Número de Registro: </strong> {{ $l->numero_cadastro }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection