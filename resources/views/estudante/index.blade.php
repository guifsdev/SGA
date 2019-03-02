@extends('layouts.master')

@section('title', 'SGA - Bem vindo(a) a Plataforma do SGA!')

@section('custom_styles')
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endsection
@section('content')
<span class="bckg"></span>
<header>
	<h1>SGA</h1>
	<nav>
	  <ul>
        <li><a href="javascript:void(0);" data-title="Home" data-view="home">Home</a></li>
        <li><a href="javascript:void(0);" data-title="Meus Dados" data-view="meus-dados">Meus Dados</a></li>
        <li><a href="javascript:void(0);" data-title="Ajuste" data-view="ajuste">Ajuste</a></li>
        <li><a href="javascript:void(0);" data-title="Certificados" data-view="certificados">Certificados</a></li>
        <li><a href="javascript:void(0);" data-title="Eventos" data-view="eventos">Eventos</a></li>
	  </ul>
	</nav>
</header>
<main>
	<div class="title">
	  <h2>Home</h2>
      <a href="#">Olá {{$primeiro_nome}}!</a>
	  <a href="/estudante/logout"></a>
	</div>

    <article class="larg" id="view"></article>

</main>
@endsection

@section('custom_scripts')
<script>
$(document).ready( function() {
    getView('home');

    $('body').on("click", "nav ul li a", function(){
        var view = $(this).data('view');
        var title = $(this).data('title');
        $('.title').children('h2').html(title);
        getView(view);
    });

    $('body').on("click", ".larg div h3", function() {
        if($(this).children('span').hasClass('close')) {
            $(this).children('span').removeClass('close');
        }
        else {
            $(this).children('span').addClass('close');
        }
        $(this).parent().children('p').slideToggle(250);
    });
  

}); //end ready
</script>

<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
@endsection
