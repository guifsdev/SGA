@extends('layouts.master')

@section('title', 'SGA - Gerenciamento de Certificados')
@section('nav_title', 'Criar certificados')


@section('content')
@include('partials.menu')
<certificates-emit 
	:events-prop="{{$events}}"
	:templates-prop="{{json_encode($templates)}}"></certificates-emit>
@endsection

@section('custom_scripts')
<script type="text/javascript" src="{{ asset('js/manage_events.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/my_functions.js') }}"></script>
<script type="text/javascript">

$(document).ready(function() {
	/*$.jMaskGlobals.watchDataMask = true;
	$('.cpf').mask('000.000.000-00');

	let eventId = $("#evento").val();
	getCertificates(eventId);

	$('#evento').on('change', function() {
		eventId = $(this).val();
		getCertificates(eventId);
	});
	
	$('#emit').on('click', function() {
		let studentId = $("input[name='studentId']").val(),
			template = $('#template').val();
			email = $("input[name='email']").val();
		emitCertificate(studentId, eventId, email, template);
	});

	$(document).on('click focus', '.cpf', function() {$(this).attr('data-mask', '000.000.000-00');});

	$(document).on('focusout', '.searchable', function(e) {
		let $this = $(this),
			countEmpty = 0;

		if($this.val() != '') {
			if($this.hasClass('cpf')) {
				$this.removeAttr('data-mask');
				$this.unmask();
			}
			findStudent($this.val(), eventId);
		}
		$.each($('.searchable'), function() {
			if($(this).val().length == 0) ++countEmpty;
		});
		if(countEmpty == 3) {
			$('#emit').attr('disabled', true);
			$('#result').empty();
			$("input[name='studentId']").val('');
		}
	});*/
});
</script>
@endsection