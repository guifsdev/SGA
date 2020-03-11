@extends('layouts.master')

@section('content')

<div class="home">
	<span class="background"></span>
	<header class="home__navigation">
		<h1 class="home__logo-text home__logo-text--servant">SGA</h1>
		<span class="user-cue">(Servidor)</span>
		<nav>
		  <ul>
			<router-link to="/home" tag="li">
				<a>
					<i class="fas fa-home"></i>
					Home
				</a>
			</router-link>
			<router-link to="/resolver-ajustes" tag="li">
				<a>
					<i class="fas fa-edit"></i>
					Ajuste
				</a>
			</router-link>
			<router-link to="resolver-chamados" tag="li">
				<a>
					<i class="fas fa-bullhorn"></i>
					Chamados
				</a>
			</router-link>
			<router-link to="/certificados" tag="li">
				<a>
					<i class="fas fa-certificate"></i>
					Certificados
				</a>
			</router-link>
			<router-link to="/configs" tag="li">
				<a>
					<i class="fas fa-cog"></i>
					Configurações
				</a>
			</router-link>
		  </ul>
		</nav>
	</header>
	<main class="home__main">
	  <div class="title-box">
		<h2 class="title-box__title">@{{$route.name}}</h2>
		<a href="javascript:void(0);" class="icon-link">
			<i class="fas fa-user"></i>
			Olá {{$servant->name}}!
		</a>
		<a href="/servidor/logout" class="icon-link">
			<i class="fas fa-sign-out-alt"></i>
		</a>
	  </div>

	  <article class="larg">
		<router-view :servant="{{$servant}}"></router-view> </article>
	</main>
</div>
@endsection
