<!-- Certificados -->
<div class="container">
	<form method="POST">
		{{csrf_field()}}
		<table class="table table-sm">
			<thead>
			<tr>
			  <th scope="col">Evento</th>
			  <th scope="col">Tipo</th>
			  <th scope="col">Carga horária</th>
			  <th scope="col">Organizador</th>
			  <th scope="col">Data</th>
			  <th scope="col" style="text-align: center">Certificado</th>
			</tr>
			</thead>
			<tbody>
				@foreach($certificates as $certificate)
				<tr>
					<td scope="row">{{$certificate->event->nome}}</td>
					<td>{{$certificate->event->tipo}}</td>
					<td>{{$certificate->event->carga_horaria}}</td>
					<td>{{$certificate->event->organizador}}</td>
					<td>{{$certificate->event->data}}</td>
					<td style="text-align: center;">
						<a class="certificate" href="/certificados/{{$certificate->id}}/evento/{{$certificate->event->id}}"
						   target="_blank" style="color: red;">
							<i class="fa fa-file-pdf-o fa-lg"></i>
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		@if(session()->has('no_template'))
		<div class="alert alert-warning" role="alert">
			{{session('no_template')}}
		</div>
		@endif

	</form>
</div>