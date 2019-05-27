<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'SGA UFF- Coordenação do Curso de Administração')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"> -->

    <!-- Custom styles -->

    @yield('custom_styles')
    
    
</head>
<body>
    <div id="app">
        @yield('content')
    </div>


    <script src="{{mix('/js/manifest.js')}}"></script>
    <script src="{{mix('/js/vendor.js')}}"></script>
    <script src="{{mix('/js/app.js')}}"></script>

    <!-- Custom scripts -->
    @yield('custom_scripts')
    
</body>
</html>