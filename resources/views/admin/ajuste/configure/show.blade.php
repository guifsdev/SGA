@extends('layouts.master')

@section('content')

@section('nav_title', 'Configurações do ajuste')

@include('partials.menu')
<div class="container" style="width: 500px; display: inline-block;">
<form method="GET" action="/admin/ajuste/config/editar">
  {{csrf_field()}}
  <table class="table">
    <tbody>
      <tr>
        <th scope="row">Data de abertura</th>
        <td>{{$settings['data_abertura']}}</td>
      </tr>
      <tr>
        <th scope="row">Data de fechamento</th>
        <td>{{$settings['data_fechamento']}}</td>
      </tr>
      <tr>
        <th scope="row">Quantidade de disciplinas por ajustes</th>
        <td>{{$settings['max_ajustes']}}</td>
      </tr>
    </tbody>
  </table>
  
  <button type="submit" class="btn btn-primary">Editar</button>
</form>
</div>
@endsection