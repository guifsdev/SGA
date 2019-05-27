@extends('layouts.master')

@section('content')
<span class="bckg"></span>

<header>
    <h1>SGA</h1>
    <nav>
      <ul>
        <router-link to="/home" tag="li">
          <a>Home</a>
        </router-link>
        <router-link to="/meus-dados" tag="li">
          <a>Meus Dados</a>
        </router-link>        
        <router-link to="/ajuste" tag="li">
          <a>Ajuste</a>
        </router-link>        
        <router-link to="/certificados" tag="li">
          <a>Certificados</a>
        </router-link>
        <router-link to="/eventos" tag="li">
          <a>Eventos</a>
        </router-link>
      </ul>
    </nav>
</header>
<main>
  <div class="title">
    <h2>@{{$route.name}}</h2>
    <a href="javascript:void(0);">Olá {{$primeiro_nome}}!</a>
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