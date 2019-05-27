@extends('layouts.master')

@section('nav_title', 'Templates')

@section('content')
@include('partials.menu')

<div class="container" style="margin-top: 25px">
	<div class="container">
		<h3>Disponíveis</h3>
		<div class="card-columns">
			
			@foreach($templates as $template)
			<div class="card" style="max-width: 12rem;">
			  <img src="{{Storage::url('certificados/templates/' . $template['withFormat'])}}" style="max-width: 100%; max-height: 100%" alt="">
			  <div class="card-body">
			    <h5 class="card-title">{{$template['name']}}</h5>
			  </div>
			</div>
			@endforeach
		</div>
	</div>

	<div class="container" style="margin-top: 100px">
		<h3>Inserir novo</h3>
		
		<form method="POST" action="">
			{{csrf_field()}}
			<div class="form-group input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
			  </div>
			  <div class="custom-file">
			    <input type="file" name="thefile" class="custom-file-input" id="template-file" accept=".png">
			    <label class="custom-file-label" for="template-file">Selecione o arquivo .png</label>
			  </div>
			</div>
			<button type="submit" class="btn btn-primary">Salvar</button>
		</form>
	</div>
</div>

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
@endsection


<script type="text/javascript">
$(document).ready(function() {
	formData = new FormData();
	//console.log(formData);

	$('#template-file').on('change', function() {
		readFile(this);

		//console.log(test);
	});

	$('form').on('submit', function(e) {
		e.preventDefault();

	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	        }
	    });

		$.ajax({
	        type: 'POST',
	        url: '/admin/eventos/templates',
	        data: formData,
	        processData: false,
  			contentType: false,
	        //dataType = 'JSON',
			success: function (data) {
				console.log(data);
			},
		});



		/*for( var pair of formData.entries()) {
			console.log(pair[0] + ', ' + pair[1]);
			
		}*/


		
	})
});
</script>
@endsection

