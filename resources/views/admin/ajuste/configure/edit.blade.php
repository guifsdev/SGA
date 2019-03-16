@extends('layouts.master')

@section('content')

@section('nav_title', 'Editar configurações do ajuste')

@include('partials.menu')
<div class="container" style="width: 500px; display: inline-block;">
<form method="POST" action="/admin/ajuste/config/editar">
	{{csrf_field()}}
  <div class="form-group">
    <label for="abertura">Data de abertura:</label>
    <input type="datetime-local" class="form-control" name="abertura" value="{{$settings['data_abertura']}}">
  </div>  
  <div class="form-group">
    <label for="fechamento">Data de fechamento:</label>
    <input type="datetime-local" class="form-control" name="fechamento" value="{{$settings['data_fechamento']}}">
  </div>
  <div class="form-group">
    <label for="max_ajustes">Quantidade de disciplinas por ajuste:</label>
    <input type="number" min="1" class="form-control" name="max_ajustes" value="{{$settings['max_ajustes']}}">
  </div>
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
</div>

@endsection