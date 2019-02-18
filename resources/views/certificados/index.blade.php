<!-- Certificados -->
<div class="container">
	<form method="POST">
		{{csrf_field()}}
		<table class="table table-sm">
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
				<tr>
					<th scope="row"></th>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: center;">
						<a class="certificate" href="/certificados/evento/" style="color: red;">
							<i class="fa fa-file-pdf-o fa-lg"></i>
						</a>
					</td>
				</tr>

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