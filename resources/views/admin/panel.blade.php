@extends('layouts.master')

@section('title', 'SGA - Painel de Gerenciamento de ajustes e certificados')
<div class="container">
	<h3 class="panel-title">Painel de Gerenciamento de ajustes e certificados</h3>
	<div id="tables-group">
		<div class="table-container">
			<table class="panel-table">
			  <thead>
			    <tr class="border_bottom">
			      <th scope="col" class="blue">Requerimentos de ajuste</th>
			      <th scope="col">
		      		<button class="btn btn-info" 
		      			onclick="window.location='{{ url("/admin/ajuste") }}'"><i class="fa fa-list"> Ver </i>
		      		</button>
		      		<button class="btn btn-info"
		      			onclick="window.location='{{ url("/admin/ajuste/configurar") }}'"><i class="fa fa-cog"> Configurar </i>
		      		</button>
			      </th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <th scope="row">Situação</th>
			      <td>Aberto/Fechado</td>
			    </tr>
			    <tr>
			      <th scope="row">Data de abertura</th>
			      <td>dd/mm/yyyy</td>
			    </tr>
			    <tr>
			      <th scope="row">Novos</th>
			      <td>vv</td>
			    </tr>
			    <tr>
			      <th scope="row">Deferidos</th>
			      <td>ww</td>
			    </tr>
			    <tr>
			      <th scope="row">Indeferidos</th>
			      <td>xx</td>
			    </tr>
			    <tr>
			      <th scope="row">Pendentes</th>
			      <td>yy</td>
			    </tr>
			  </tbody>
			</table>
		</div>
		<div class="table-container">
			<table class="panel-table">
			  <thead>
			    <tr class="border_bottom">
			      <th scope="col" class="blue">Certificados</th>
			      <th scope="col">
		      		<button class="btn btn-info"
		      			onclick="window.location='{{ url("/admin/certificados") }}'"><i class="fa fa-list"> Ver </i>
		      		</button>
		      		<button class="btn btn-info"
		      			onclick="window.location='{{ url("/admin/certificados/configurar") }}'"><i class="fa fa-cog"> Configurar </i>
		      		</button>
			      </th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <th scope="row">Emitidos</th>
			      <td>xxx</td>
			    </tr>
			    <tr>
			      <th scope="row">Vizualisados</th>
			      <td>yyy</td>
			    </tr>
			    <tr>
			      <th scope="row">Impressos</th>
			      <td>zz</td>
			    </tr>
			  </tbody>
			</table>
		</div>
	</div>
</div>
@section('content')
@endsection