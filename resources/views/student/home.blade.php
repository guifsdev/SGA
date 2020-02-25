@extends('layouts.master')

@section('content')

<div class="home">
	<span class="background"></span>
	<header class="home__navigation">
		<h1 class="home__logo-text home__logo-text--student">SGA</h1>
		<nav>
		  <ul>
			<router-link to="/home" tag="li">
			  	<a>
					<i class="fas fa-home"></i>
					Home
				</a>
			</router-link>
			<router-link to="/meus-dados" tag="li">
			  	<a>
					<i class="fas fa-info-circle"></i>
					Meus Dados
				</a>
			</router-link>		
			<router-link to="/ajuste" tag="li">
			  	<a>
					<i class="fas fa-edit"></i>
					Ajuste
				</a>
			</router-link>		
			<router-link to="/certificados" tag="li">
			  	<a>
					<i class="fas fa-certificate"></i>
					Certificados
				</a>
			</router-link>
			<router-link to="/eventos" tag="li">
			  	<a>
					<i class="fas fa-calendar-alt"></i>
					Eventos
				</a>
			</router-link>
		  </ul>
		</nav>
	</header>
	<main class="home__main">
	  <div class="title-box">
		<h2 class="title-box__title">@{{$route.name}}</h2>
		<a href="javascript:void(0);" class="icon-link">
			<i class="fas fa-user-graduate"></i>
			Olá {{$student->name}}!
		</a>
		<a href="/estudante/logout" class="icon-link">
			<i class="fas fa-sign-out-alt"></i>
		</a>
	  </div>

	  <article class="larg">
		<router-view :student="{{$student}}"></router-view> </article>
	</main>
</div>
@endsection
