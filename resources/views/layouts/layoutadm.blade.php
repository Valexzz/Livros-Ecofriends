<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- font -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- css -->


    <!-- fontawesome --> 
    <script src="https://kit.fontawesome.com/22e6a200c4.js" crossorigin="anonymous"></script>
</head>
<body id="adm">

    <!-- Header -->
    <header id="cabecalho" class="bg-warning p-3 text-center text-light d-none d-md-block">
        <h1>Livros Enem ADM</h1>
    </header>

    <!-- logout -->
    <form action="{{ route('logout') }}" method="POST" class="position-absolute top-0 end-0 m-3">
        @csrf
        <button type="submit" class="btn btn-danger">Sair</button>
    </form>
    
    <!-- Navigation -->
    <nav class="bg-warning navbar navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand text-light p-3 fs-2 d-md-none" href="{{ route('adm.index') }}">Livros Enem ADM</a>
            <button class="navbar-toggler btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars fs-1" style="color: #ffffff;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto me-auto mb-2 mb-lg-0 justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('adm.index') ? 'active' : '' }} text-white" href="{{ route('adm.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('adm.livros.index') ? 'active' : '' }} text-white" href="{{ route('adm.livros.index') }}">Livros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('adm.usuarios') ? 'active' : '' }} text-white" href="{{ route('adm.usuarios') }}">Usuário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('adm.emprestimos.index') ? 'active' : '' }} text-white" href="{{ route('adm.emprestimos.index') }}">Empréstimos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }} text-white" href="{{ route('index')}}">Voltar</a>
                    </li>
                    <li class="nav-item d-md-none">
                            <!-- logout -->
                        <form action="{{ route('logout') }}" method="POST" class="">
                            @csrf
                            <button type="submit" class="nav-link text-white">Sair</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container my-4">
        @yield('conteudo')
    </div>

    

    <!-- Footer -->
    <footer class="bg-warning text-white text-center p-3">
        <p>&copy; 2023 {{config('app.name')}}. Todos os direitos reservados</p>
        <p>Desenvolvido por Victor Alexandre Borges Milhomem :D</p>
    </footer>

</body>
</html>
@yield('script')