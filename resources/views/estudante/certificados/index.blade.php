<!-- Certificados -->
<div class="container">
	<form method="POST">
		{{csrf_field()}}
		<table class="table table-sm">
			<thead>
			<tr>
			  <th scope="col"">Evento</th>
			  <th scope="col">Tipo</th>
			  <th scope="col">Carga horária</th>
			  <th scope="col">Organizador</th>
			  <th scope="col">Data</th>
			  <th scope="col" style="text-align: center">Certificado</th>
			</tr>
			</thead>
			<tbody>
				@foreach($events as $event)
				<tr>
					<td scope="row">{{$event->nome}}</td>
					<td>{{$event->tipo}}</td>
					<td>{{$event->carga_horaria}}</td>
					<td>{{$event->organizador}}</td>
					<td>{{$event->data}}</td>
					<td style="text-align: center;">
						<a class="certificate" href="/certificados/evento/{{$event->id}}" target="_blank" style="color: red;">
							<i class="fa fa-file-pdf-o fa-lg"></i>
						</a>
					</td>
				</tr>
				@endforeach

				<!-- <input type="hidden" value="" name="nome">
				<input type="hidden" value="" name="email">
				<input type="hidden" value="" name="cpf">
				<input type="hidden" value="" name="matricula"> -->

			</tbody>
		</table>

		@if(session()->has('no_template'))
		<div class="alert alert-warning" role="alert">
			{{session('no_template')}}
		</div>
		@endif

	</form>
</div>