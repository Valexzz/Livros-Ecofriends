@extends('layouts.layout')

@section('conteudo')

<div class="card info">
    <div class="card-header">
        Seus dados
    </div>
    <div class="card-body">
        <div class="profile-info">
            <label>Matrícula</label>
            <p>{{ $user->matricula }}</p>
    
            <label>Nome</label>
            <p>{{ $user->name }}</p>
    
            <label>Curso</label>
            <p>{{ $user->curso->descricao }}</p>
    
            <label>Email</label>
            <p>{{ $user->email }}</p>
    
            <label>Ano</label>
            <p>{{ $user->ano }}</p>
    
            <label>Telefone</label>
            <p>{{ $user->telefone }}</p>
        </div>
    </div>
</div>
@endsection