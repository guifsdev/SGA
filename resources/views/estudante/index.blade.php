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
	    <li>
	      <a href="javascript:void(0);" data-title="Ajuste">Ajuste</a>
	    </li>
	    <li>
	      <a href="javascript:void(0);" data-title="Certificados" disabled>Certificados</a>
	    </li>
	  </ul>
	</nav>
</header>
<main>
	<div class="title">
	  <h2>Ajuste</h2>
	  <a href="javascript:void(0);">Hello {{$primeiro_nome}}!</a>
	</div>

	<article class="larg" id="ajuste">
		@include('ajuste.index')
	</article>

	<article class="larg collapse" id="certificados">
		@include('certificados.index')
	</article>
</main>
@endsection

@section('custom_scripts')
<script>
$(document).ready( function() {

    $(document).delegate('button:submit', 'click', function(e) {
        if($(this).attr('id') == 'salvar') {
            $(this).attr('disabled', true);

        }
        e.preventDefault();
        reenableInputs();

        var form = $('form');
        var action = '/ajuste/' + $(this).attr('id');

        ajusteAction(form, action);
    });

    $(document).delegate('.periodo', 'change', function() {
        buscarDisciplinas('/ajuste', this);

    });



    /*$('.periodo').on('change', function() {
        buscarDisciplinas('/ajuste', this);
    });*/


    /*$('form').submit(removeDisabledAttributes);

    $('.certificate').on('click', function(evt) {
        evt.preventDefault();
        viewCertificate(this);
    });


    var submitBtn = $('button:submit');

    submitBtn.click(function(e){
        //e.preventDefault();
        reenableInputs();
        changeFormAction($(this));
    });*/


//////

    $('body').on("click", "nav ul li a", function(){
        var title = $(this).data('title');
        $('.title').children('h2').html(title);

        var ajuste = $('#ajuste');
        var certificados = $('#certificados');

        if(title == 'Ajuste' && ajuste.hasClass('collapse')) {
            ajuste.removeClass('collapse');
            certificados.addClass('collapse');
        }
        else if(title == 'Certificados' && certificados.hasClass('collapse')) {
            certificados.removeClass('collapse');
            ajuste.addClass('collapse');
        }
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
