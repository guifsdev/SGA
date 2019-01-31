@extends('layouts.master')

@section('title', 'Ajuste SGA - Sucesso!')

@section('content')
<div class="container-fluid">
	<main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content" role="main" 
	style="
		margin: 0 auto; 
		padding-left: 1rem !important;">

		<h3>Ajuste de disciplinas do aluno</h3>
		<div class="form-group">
			<label for="nome">Nome completo:</label>
			<input type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" 
				disabled="disabled"
				value="{{$userInput['nome']}}" >
		</div>

		<div class="form-group">
			<label for="cpf">CPF:</label>
			<input type="text" class="form-control" id="CPF" placeholder="CPF" name="cpf" 
				disabled="disabled"
				value="{{$userInput['cpf']}}">
		</div>

		<div class="form-group">
			<label for="matricula">Matrícula:</label>
			<input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" 
				name="matricula" disabled="disabled"
				value="{{$userInput['matricula']}}">
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" 
				disabled="disabled"
				value="{{$userInput['email']}}" >
		</div>

		<div class="form-group">
			<label for="telefone">Telefone:</label>
			<input type="tel" class="form-control" id="telefone" name="tel" 
				disabled="disabled"
				value="{{$userInput['tel']}}" >
		</div>
		<table class="table table-sm">
		  <thead>
		    <tr>
		      <th scope="col" style="width: 20%">Período</th>
		      <th scope="col">Disciplina</th>
		      <th scope="col">Requerimento</th>
		    </tr>
		  </thead>
		  <tbody>
			@for($i = 1; $i <= count($userInput['periodo']); ++$i)
				<tr class="ajuste" id="{{$i}}">
				  <td scope="row">
				  	{{$userInput['periodo'][$i]}}
				  </td>
				  <td>
				  	{{$userInput['disciplina'][$i]}}
				  </td>
				  <td style="width: 5%" class="align-radio-center">
				  	{{$userInput['requerimento'][$i]}}
				  </td>
				</tr>
			@endfor
		  </tbody>
		</table>
		<!-- Mensagem de sucesso -->
		<div class="alert alert-success" role="alert">
		  {{session('success')}}
		</div>
		<p>Autenticação: {{$userInput['autenticacao']}}</p>
		<p>Data do requerimento: {{$userInput['datahora']}}</p>
		
		<!-- Encerrar -->
		<div class="form-group align-center">
			<button type="submit" class="btn btn-primary" aria-describedby="aviso"
				onclick="window.location='{{url("/login")}}'">
				Encerrar
			</button>
		</div>
	</main>
</div>

@endsection