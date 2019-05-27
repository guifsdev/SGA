@extends('layouts.master')

@section('nav_title', 'SGA - Admin Home')


@section('content')

@include('partials.menu')
<div class="container card-columns">
	<div class="card border-dark mb-3" style="max-width: 18rem;">
	  <h4 class="card-header"><a href="/admin/ajuste">Ajuste</a></h4>
	  <div class="card-body text-dark">
	    <a href="/admin/ajuste/config">Configurações</a>

	    <p class="card-text">
	    	<span class="font-weight-bold">Situação: </span>{{$adjustment['status']}} <br>
	    	<span class="font-weight-bold">Abertura: </span>{{$adjustment['settings']['data_abertura']}} <br>
	    	<span class="font-weight-bold">Fechamento: </span>{{$adjustment['settings']['data_fechamento']}} <br>
	    	<span class="font-weight-bold">Novos: </span>{{$adjustment['new']}} <br>
	    	<span class="font-weight-bold">Deferidos: </span>{{$adjustment['deferred']}} <br>
			<span class="font-weight-bold">Indeferidos: </span>{{$adjustment['denied']}} <br>
			<span class="font-weight-bold">Pendentes: </span> {{$adjustment['pending']}}
	    </p>
	  </div>
	</div>

	<div class="card border-dark mb-3" style="max-width: 18rem;">
	  <h4 class="card-header"><a href="/admin/estudantes">Estudantes</a></h4>
	  <div class="card-body text-dark">
	    <a href="/admin/estudantes" disabled>Atualizar</a>
	    <p class="card-text">
	    	<span class="font-weight-bold">Contagem: </span>{{$students['count']}} <br>
	    	<span class="font-weight-bold">Último merge: </span>{{$students['last_merge']}}
	    </p>
	  </div>
	</div>

	<div class="card border-dark mb-3" style="max-width: 18rem;">
	  <h4 class="card-header"><a href="/admin/disciplinas">Disciplinas</a></h4>
	  <div class="card-body text-dark">
	    <a href="/admin/disciplinas/criar">Criar</a>
	    <p class="card-text">
	    	<span class="font-weight-bold">Contagem: </span>{{$subjects['count']}} <br>
	    	<span class="font-weight-bold">Ofertadas: </span>{{$subjects['offered']}}
	    </p>
	  </div>
	</div>

	<div class="card border-dark mb-3" style="max-width: 18rem;">
	  <h4 class="card-header"><a href="/admin/certificados">Certificados</a></h4>
	  <div class="card-body text-dark">
	    <a href="/admin/certificados/emitir">Emitir</a>
	    <p class="card-text">
	    	<span class="font-weight-bold">Contagem: </span>{{$certificates['count']}} <br>
	    </p>
	  </div>
	</div>

	<div class="card border-dark mb-3" style="max-width: 18rem;">
	  <h4 class="card-header"><a href="/admin/eventos">Eventos</a></h4>
	  <div class="card-body text-dark">
	    <a href="/admin/eventos/criar">Novo</a>
	    <p class="card-text">
	    	<span class="font-weight-bold">Contagem: </span>{{$certificates['count']}} <br>
	    </p>
	  </div>
	</div>

	<div class="card border-dark mb-3" style="max-width: 18rem;">
	  <h4 class="card-header"><a href="/admin/templates">Templates</a></h4>
	  <div class="card-body text-dark">
	    <a href="/admin/templates/criar">Novo</a>
	    <p class="card-text">
	    	<span class="font-weight-bold">Contagem: </span>{{$templates['count']}} <br>
	    </p>
	  </div>
	</div>
</div>

@endsection