@extends('layouts.layoutverification')

@section('conteudo')
    <div class="card">
        <div class="card-header">{{ __('Verifique seu endereço de email') }}</div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Um novo link de verificação foi enviado ao seu email!') }}
                    </div>
                @endif

                {{ __('Antes de poder utilizar o site, verifique uma nova mensagem no seu endereço de email para verificação.') }}<br>
                {{ __('Se você não recebeu o link no seu email:') }}
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Clique aqui para reenviar') }}</button>.
                </form>
            </div>
        </div>
    </div>
@endsection
