@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Certificados')
@section('nav_title', 'Criar certificados')


@section('content')
@include('partials.menu')

<div class="container" style="width: 900px">
	<form method="POST" action="/admin/certificados/criar">
	{{csrf_field()}}
		<div class="form-group">
			<label for="metodo-inserir">Evento:</label>
			<select class="form-control" id="evento" name="evento">
				@foreach($events as $event)
					<option value="{{$event->id}}">{{$event->nome}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="template">Template:</label>
			<select class="form-control" id="template" name="template">
				@foreach($templates as $template)
					<option value="{{$template}}">{{$template}}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group" style="margin-bottom: 0">
			<label for="template">Participantes:</label>
		</div>
		<div class="container form-group" 
		  	style="border: 1px solid #CBD2D9; padding-top: 20px; border-radius: 4px">
			<table class="table order-list">
			    <thead>
			        <tr>
			            <th scope="col" style="width: 25%">CPF</td>
			            <th scope="col" style="width: 25%">Matrícula</td>
			            <th scope="col" style="width: 40%">Email</td>
			            <th scope="col" style="width: 10%"></td>
			        </tr>
			    </thead>
			    <tbody>
			        <tr>
						<td>
			            	<input type="text" class="form-control" id="cpf"  name="cpf[0]">
						</td>
						<td>
							<input type="text" class="form-control" id="matricula" name="matricula[0]">
						</td>
						<td>
							<input type="email" class="form-control" id="email" name="email[0]">
						</td>

			            <td><a class="deleteRow"></a></td>
			        </tr>
			    </tbody>
			    <tfoot>
			        <tr>
			            <td colspan="5" style="text-align: left;">
			                <input type="button" class="btn btn-light btn-block " id="addrow" value="Adicionar"/>
			            </td>
			        </tr>
			        <tr>
			        </tr>
			    </tfoot>
			</table>
		</div> <!-- .container -->
</div>

@endsection

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manage_events.js') }}"></script>
@endsection