@extends('layouts.master')

@section('content')

<h1>Aqui está os status dos requerimentos</h1>

<div class="container-fluid">
	<table class="table table-sm table-hover">
	  <thead>
	    <tr>
	      <th scope="col">Período</th>
	      <th scope="col">Disciplina</th>
	      <th scope="col">Ação</th>
	      <th scope="col">Data solicitada</th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach($requerimentos as $requerimento)
			<tr>
				<td>{{$requerimento['periodo']}}</td>
				<td>{{$requerimento['disciplina']}}</td>
				<td>{{$requerimento['acao']}}</td>
				<td>{{$requerimento['created_at']}}</td>
			</tr>
		@endforeach
	  </tbody>
	</table>
	<button type="button" id='print' class="btn btn-primary">Imprimir consulta</button>
</div>

<p>token de consulta: {{$token}}</p>

<script type="text/javascript">
	$(document).ready(function() {
		$('#print').click(function() {
			window.print();
		});
	});
</script>


	



@endsection