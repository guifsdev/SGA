@extends('layouts.master')

@section('content')

@section('nav_title', 'Editar configurações do ajuste')

@include('admin.menu')
<div class="container" style="width: 350px">
<form method="POST" action="/admin/ajuste/config/editar">
	{{csrf_field()}}
  <div class="form-group">
    <label class="" for="abertura">Data de abertura:</label>
    <input type="text" class="form-control" name="abertura" value="{{$datas['abertura']}}">
  </div>  
  <div class="form-group">
    <label class="" for="fechamento">Data de fechamento:</label>
    <input type="text" class="form-control" name="fechamento" value="{{$datas['fechamento']}}">
  </div>
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
</div>

@endsection