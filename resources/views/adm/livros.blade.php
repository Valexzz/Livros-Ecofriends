@extends('layouts.layoutadm')

@section('conteudo')

{{--Inserir livros--}}
<div class="card">
    <div class="card-header">
        Cadastrar livros
    </div>
    <div class="card-body">
        @if (session('success-store'))
            <div class="mt-3 alert alert-success">{{ session('success-store')}} </div>
        @elseif (session('error-store'))
            <div class="mt-3 alert alert-danger">{{ session('error-store')}} </div>
        @endif
        <form id="register-livro" action="{{ route('adm.livros.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-floating">
                        <input class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}" type="text" id="titulo" name="titulo" placeholder="titulo" required>
                        <label for="titulo">Título</label>
                        @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="col-12 col-md-4 mt-4 mt-md-0">
                    <div class="form-floating"> 
                        <select id="area-conhecimento" class="form-select  @error('area_conhecimento') is-invalid @enderror" name="area_conhecimento" required>
                            <option value="">Área de conhecimento</option>
                            @foreach($areas_conhecimento as $ac)
                                <option value="{{$ac->id}}" {{ request('area_conhecimento_id') == $ac->id ? 'selected' : ''}}>{{$ac->descricao}}</option>
                            @endforeach
                        </select>
                        @error('area_conhecimento')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="area-conhecimento">Área de conhecimento</label>
                    </div>
                </div>

                <div class="col-12 col-md-4 mt-4 mt-md-0">
                    <div class="form-floating">
                        <input class="form-control @error('numero_cadastro') is-invalid @enderror" value="{{ old('numero_cadastro') }}" type="text" id="numero-cadastro" name="numero_cadastro" placeholder="Número de cadastro" required>
                        <label for="numero-cadastro">Número de Cadastro</label>
                    </div>
                    @error('numero_cadastro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>      
            </div> 

            <div class="row mt-2">
                <div class="col-6">
                    <button type="submit" class="btn btn-success">Cadastrar livro</button>
                </div>

                <div class="col-6">
                    <label for="estoque">Informe a quantidade de livros</label>
                    <input class="form-control @error('estoque') is-invalid @enderror" value="{{ old('estoque') > 0 ? old('estoque') : 1}}" type="number" id="estoque" name="estoque" required>

                    @error('estoque')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

            </div>
            
            
        </form>
    </div>
</div>

{{-- filtrar --}}
<div class="card mt-4"> 
    <div class="card-header">
        Filtrar
    </div>

    <div class="card-body">
        <form action="{{ route('adm.livros.store') }} " method="get">
            @csrf
            <div class="row">
                
                <div class="col-12 col-md-4">
                    <div class="form-floating">
                        <input class="form-control" type="text" value="{{ request('titulo') }}" id="filtro-titulo" name="titulo" placeholder="Título">
                        <label for="filtro-titulo">Título</label>
                    </div>
                </div>

                <div class="col-12 col-md-4 mt-4 mt-md-0">
                    <div class="form-floating ">
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
                        <input class="form-control" type="text" value="{{ request('numero_cadastro') }}" id="filtro-numero-cadastro" name="numero_cadastro" placeholder="Número de cadastro">
                        <label for="filtro-numero-cadastro">Número de cadastro</label>
                    </div>
                </div>      
            </div> 

            <button type="submit" class="btn btn-success mt-2">Filtrar Livros</button> 
            
        </form>
    </div>   
</div>

{{-- Editar livro --}}
<div class="card mt-4"> 
    <div class="card-header">
        Editar livro
    </div>

    <div class="card-body">
        @if (session('success-update'))
            <div class="mt-3 alert alert-success">{{ session('success-update')}} </div>
        @elseif (session('error-update'))
            <div class="mt-3 alert alert-danger">{{ session('error-update')}} </div>
        @endif
        <form action="" id="form-edit" method="post">  
            @csrf
            @method('PUT') 
            <div class="row"> 
                <div class="col">
                    <div class="form-floating ">
                        <select class="form-select" aria-label="select-conhecimento" id="id-edit" name="id">
                            <option value="">Selecione o ID do livro para editar</option>
                            @foreach($livros as $l){
                                <option value="{{$l->id}}">{{$l->id}} - {{$l->titulo}}</option>
                            }
                            @endforeach
                        </select>
                        <label for="id-edit">Área de conhecimento</label>
                    </div>
                </div> 
            </div> 
            <div class="d-none row mt-4" id="input-edit">
   


            </div>
        </form>
    </div>   
</div>

{{-- recuperar livros --}}   
<div class="card mt-4" id="booksTable">
    <div class="card-header">
        Livros 
    </div>
    <div class="card-body">
        @if (session('success-delete'))
            <div class="mt-3 alert alert-success">{{ session('success-delete')}} </div>
        @elseif (session('error-delete'))
            <div class="mt-3 alert alert-danger">{{ session('error-delete')}} </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>id</th>
                    <th>Título</th>
                    <th>Área de Conhecimento</th>
                    <th>Número de Cadastro</th>
                    <th>Em estoque</th>
                    <th>Emprestados</th>
                    <th colspan="2">Ação</th>
                </tr>
            
                @foreach($livros as $l)
                    <tr>
                        <td>{{$l->id}}</td>
                        <td>{{$l->titulo}}</td>
                        <td>{{$l->areaConhecimento->descricao}}</td>
                        <td>{{$l->numero_cadastro}}</td>
                        <td>{{$l->estoque}}</td>
                        <td>{{$l->emprestimos_count }}</td>
                        <td><button class="btn btn-warning btn-edit" id="edit-{{$l->id}}">editar</button></td>
                        <td>
                            @if($l->emprestimos_count > 0)
                                Livro está em um empréstimo!
                            @else
                            <form action="{{ route('adm.livros.destroy', ['livro' => $l->id ]) }}" method="post"> 
                                @csrf 
                                @method('DELETE') 
                                <button class="btn btn-danger">deletar</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>  
       
@endsection

@section('script')

<script type="module">

    function loadEdit(){
        $.ajax({
            url: `/adm/livros/${$('#id-edit').val()}/edit`,
            method: 'GET',
            success: d => {
                $('#form-edit').attr('action', `livros/${d.id}`)
                $('#input-edit').empty()
                $('#input-edit').removeClass('d-none')
                $('#input-edit').append(
                    `<div class="col-12 col-md-4">
                        <div class="form-floating">
                            <input class="form-control" type="text" id="titulo-edit" name="titulo" value="${d.titulo}" required>
                            <label for="titulo-edit">Título</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mt-4 mt-md-0">
                        <div class="form-floating ">
                            <select class="form-select" aria-label="select-conhecimento" id="area-conhecimento-edit" name="area_conhecimento">
                                <option value="">Área de conhecimento</option>
                                <option value="1" ${(d.area_conhecimento_id == 1) ? 'selected' : ''}>Matemática</option>
                                <option value="2" ${(d.area_conhecimento_id == 2) ? 'selected' : ''}>Português</option>
                                <option value="3" ${(d.area_conhecimento_id == 3) ? 'selected' : ''}>Física</option>
                            </select>
                            <label for="area-conhecimento-edit">Área de conhecimento</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mt-4 mt-md-0">
                        <div class="form-floating">
                            <input class="form-control" type="text" id="numero-cadastro-edit" value="${d.numero_cadastro}" name="numero_cadastro" placeholder="Número de cadastro">
                            <label for="numero-cadastro-edit">Número de cadastro</label>
                        </div>
                    </div> 
                    
                    <div class="col-6 mt-4">
                        <button type="submit" class="btn btn-warning">Atualizar livro</button>
                    </div>

                    <div class="col-6 mt-4 ">
                        <label for="estoque-edit">Informe a quantidade de livros em estoque</label>
                        <input class="form-control" value="${d.estoque}" type="number" id="estoque-edit" name="estoque" required>
                    </div> 

                    `
                )
            },
            error: () => {

            }
        })
    }
    $('#register-livro').validate({
        rules: {
            titulo: {
                required: true,
                minlength: 6,
                maxlength: 100
            },
            area_conhecimento: {
                required: true
            },
            numero_cadastro: {
                required: true,
                digits: true
            },
        }
  })

  $('#form-edit').validate({
        rules: {
            titulo: {
                required: true,
                minlength: 6,
                maxlength: 100
            },
            area_conhecimento: {
                required: true
            },
            numero_cadastro: {
                required: true,
                digits: true
            },
        }
  })

  $('#id-edit').on('change', (e) => {
    console.log($(e.currentTarget).val())
    if ($(e.currentTarget).val()){
        loadEdit()
    } else {
        $('#input-edit').empty()
    }
  })

  $('.btn-edit').on('click', e => {
        $('#id-edit').val($(e.currentTarget).attr('id').split('-')[1])
        loadEdit()
        $('#id-edit')[0].scrollIntoView()
  })
</script>
@endsection

