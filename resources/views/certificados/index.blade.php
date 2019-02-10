@extends('layouts.master')

@section('title', 'SGA - Emissão de certificados')

@section('content')

<div class="container" style="width: 960px">

	<h3>Emissão de certificados</h3>

	<!-- /certificados/evento/id -->
	<form method="POST">
		{{csrf_field()}}
		<table class="table table-sm" style="margin-top: 50px">
			<thead>
			<tr>
			  <th scope="col"">Certificado</th>
			  <th scope="col">Tipo</th>
			  <th scope="col">Carga horária</th>
			  <th scope="col">Organizador</th>
			  <th scope="col">Data</th>
			  <th scope="col" style="text-align: center">PDF</th>
			</tr>
			</thead>
			<tbody>
				@foreach($events as $event)
				<tr>
					<th scope="row">{{$event['nome']}}</th>
					<td>{{$event['tipo']}}</td>
					<td>{{$event['carga_horaria']}}</td>
					<td>{{$event['organizador']}}</td>
					<td>{{$event['data']}}</td>
					<td style="text-align: center;">
						<a class="certificate" href="/certificados/evento/{{$event['id']}}" style="color: red;">
							<i class="fa fa-file-pdf-o fa-lg"></i>
						</a>
					</td>
				</tr>
				@endforeach

				<input type="hidden" value="{{$participant['nome']}}" name="nome">
				<input type="hidden" value="{{$participant['email']}}" name="email">
				<input type="hidden" value="{{$participant['cpf']}}" name="cpf">
				<input type="hidden" value="{{$participant['matricula']}}" name="matricula">

			</tbody>
		</table>
	</form>
</div>

<script type="text/javascript">
	$('.certificate').on('click', function(evt) {
		evt.preventDefault();
		viewCertificate(this);
	});
</script>


@endsection

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
@endsection
