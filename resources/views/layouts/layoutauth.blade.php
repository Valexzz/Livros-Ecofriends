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
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">

    <!-- fontawesome --> 
    <script src="https://kit.fontawesome.com/22e6a200c4.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Header -->
    <header id="cabecalho" class="bg-success p-3 text-center text-light">
        <h1>Livros Enem</h1>
    </header>

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('conteudo')
    </div>

    <!-- Footer -->
    <footer class="bg-success text-white text-center p-3">
        <p>&copy; 2023 {{config('app.name')}}. Todos os direitos reservados</p>
    </footer>

</body>
</html>
@yield('script')