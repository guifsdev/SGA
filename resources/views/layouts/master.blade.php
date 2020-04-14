<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Aplicações SGA - Coordenação do curso de Administração')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900|Nunito:300,300i,400,800" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
	<link rel="stylesheet" href="{{mix('css/app.css')}}">

    <!-- Custom styles -->

    @yield('custom_styles')
    
    
</head>
<body>
    <div id="app">
        @yield('content')
    </div>


    <script src="{{mix('js/manifest.js')}}"></script>
    <script src="{{mix('js/vendor.js')}}"></script>
    <script src="{{mix('js/app.js')}}"></script>

    <!-- Custom scripts -->
    @yield('custom_scripts')
    
</body>
</html>
