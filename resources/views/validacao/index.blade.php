@extends('layouts.master')
@include('validacao.nav')

@section('content')
<h1>Validação</h1>


<div class="container-fluid">
<!-- 	<table class="table table-sm">
		<thead>
			<tr>
				<th>
					<input type="checkbox" name="selecionar-tudo">
					<label for="selecionar-tudo">Selecionar tudo</label>
				</th>
				<th>
					<label for="filtrar">Filtrar</label>
					<input type="text" name="marcar-tudo">
				</th>
			</tr>
		</thead>
	</table>
 -->

	<div class="container-fluid" style='margin:0'>
		<input type="checkbox" name="selecionar-tudo">
		<label for="selecionar-tudo">Selecionar tudo</label>
		<label for="filtrar">Filtrar</label>
		<input type="text" name="marcar-tudo">
		
	</div>

	<table class="table table-sm table-hover">
	  <thead>
	    <tr>
	      <th></th>
	      <th scope="col">Matricula</th>
	      <th scope="col">Nome</th>
	      <th scope="col">Período</th>
	      <th scope="col">Disciplina</th>
	      <th scope="col">Ação</th>
	      <th scope="col">Status</th>
	      <th scope="col">Data solicitada</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($requerimentos as $requerimento)
			<tr>
				<td><input type="checkbox" name=""></td>
				<td>{{$requerimento['matricula']}}</td>
				<td>{{$requerimento['nome']}}</td>
				<td>{{$requerimento['periodo']}}</td>
				<td>{{$requerimento['disciplina']}}</td>
				<td>{{$requerimento['acao']}}</td>
				<td>{{$requerimento['status']}}</td>
				<td>{{$requerimento['created_at']}}</td>
			</tr>
		@endforeach
	  </tbody>
	</table>
</div>



@endsection
