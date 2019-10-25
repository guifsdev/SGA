@extends('layouts.master')

@section('content')
<span class="bckg"></span>

<header>
    <h1>SGA</h1>
    <nav>
      <ul>
        <router-link to="/home" tag="li">
          <a><i class="fa fa-home"></i> Home</a>
        </router-link>
        <router-link to="/meus-dados" tag="li">
          <a><i class="fa fa-graduation-cap"></i> Meus Dados</a>
        </router-link>        
        <router-link to="/ajuste" tag="li">
          <a><i class="fa fa-edit"></i> Ajuste</a>
        </router-link>        
        <router-link to="/certificados" tag="li">
          <a><i class="fa fa-certificate"></i> Certificados</a>
        </router-link>
        <router-link to="/eventos" tag="li">
          <a><i class="fa fa-calendar-check"></i> Eventos</a>
        </router-link>
      </ul>
    </nav>
</header>
<main>
  <div class="title">
    <h2>@{{$route.name}}</h2>
    <a href="javascript:void(0);"><i class="fa fa-user-graduate"></i> Olá {{$primeiro_nome}}!</a>
    <a href="/estudante/logout"><i class="fa fa-sign-out-alt"></i></a>
  </div>

  <article class="larg">
    <router-view :student-props="{{$student}}"></router-view>
  </article>
</main>
@endsection



@section('custom_styles')
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@endsection