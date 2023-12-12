@extends('layouts.layoutauth')

@section('conteudo')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Cadastrar') }}</div>
            
            <div class="card-body">
                <form id="register-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="matricula" class="col-md-4 col-form-label text-md-end ">{{ __('Matrícula') }}</label>
                        <div class="col-md-6">
                            <input id="matricula" type="text" value="{{ old('matricula') }}" class="form-control @error('matricula') is-invalid @enderror" name="matricula" required>
                            @error('matricula')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!--<div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>-->

                    <div class="row mb-3">
                        <div class="form-floating col-md-6 offset-md-4" id="anoFloat">
                            <select id="ano" name="ano" class="form-select  @error('ano') is-invalid @enderror" required>
                                <option value="">{{__('Selecione seu ano')}}</option>
                                <option value="1" {{ old('ano') == 1 ? 'selected' : ''}} >{{__('1º Ano')}}</option>
                                <option value="2" {{ old('ano') == 2 ? 'selected' : ''}}>{{__('2º Ano')}}</option>
                                <option value="3" {{ old('ano') == 3 ? 'selected' : ''}}>{{__('3º Ano')}}</option>
                            </select>
                            <label for="ano" class="ms-2" id="labelAno">{{ __('Ano')}}</label>
                            @error('ano')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-floating col-md-6 offset-md-4" id="cursoFloat">
                            <select id="curso" name="curso" class="form-select @error('curso') is-invalid @enderror" required>
                                <option value="">{{__('Selecione seu curso')}}</option>
                                @foreach($cursos as $c)
                                    <option value="{{$c->id}}" {{ old('curso') == $c->id ? 'selected' : ''}}> {{$c->descricao}} </option>
                                @endforeach
                            </select>
                            <label for="curso" class="ms-2" id="labelCurso" >{{ __('Curso')}}</label>
                            @error('curso')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="telefone" class="col-md-4 col-form-label text-md-end ">{{ __('Telefone') }}</label>
                        <div class="col-md-6">
                            <input id="telefone" type="text" value="{{ old('telefone') }}"class="form-control @error('telefone') is-invalid @enderror" name="telefone" required>
                            @error('telefone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success">
                                {{ __('Cadastrar') }}
                            </button>
                        </div>
                        <div class="col-md-6 offset-md-4 me-auto">
                        <a class="btn btn-link" href="{{ route('login') }}">Já possui conta? Vá para página de login</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script type="module">
    $('#register-form').validate({
        rules: {
            matricula: {
                required: true,
                rangelength: [11, 11],
                digits: true, 
            },
            name: {
                required: true,
                minlength: 8,
                maxlength: 100
            },
            email: {
                required: true,
                email: true,
                maxlength: 255
            },
            password: {
                required: true,
                minlength: 3
            },
            curso: {
                required: true
            },
            ano: {
                required: true
            },
            telefone: {
                required: true, 
                maxlength: 20,
                minlength: 5,
                digits: true
            }
        },
        messages: {
            matricula: {
                rangelength: 'Precisa ter exatamente 11 caracteres!',
            }
        },
        errorPlacement: function (error, element) {
            console.log(element.attr('name'))
            // Only apply custom placement for the 'curso' input
            if (element.attr("name") === "curso") {
                error.insertAfter($('#labelCurso'))
            } else if (element.attr("name") === "ano") {
                error.insertAfter($('#labelAno'))
            } else {
                // For other inputs, use default placement
                error.insertAfter(element);
            }
        },
  })
</script>
@endsection