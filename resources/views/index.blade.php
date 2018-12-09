@extends('layouts.master')

@section('content')


<form method="GET"  action="">
	
	<div class="form-group">
		<button type="submit" id="consulta" class="btn btn-primary">Consultar requerimento</button>
	</div>
	<div class="form-group">
		<button type="submit" id="ajuste" class="btn btn-primary">Ajustar plano de estudos</button>
	</div>
</form>

<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))
      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
    @endforeach
  </div> <!-- end .flash-message -->

<script type="text/javascript">
$(document).ready(function() {

	var form = $('form');

	$('button').click(function() {
		
		var id = $(this).attr('id');
		form.attr('action', '/' + id);

	});

});
</script>




@endsection