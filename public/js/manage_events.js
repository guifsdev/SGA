//contador de linhas
counter = 1;

function addRow() {
    var newRow = $("<tr>");
    var cols = "";

	cols += '<td><input type="text" class="form-control cpf searchable" data-mask="000.000.000-00" name="cpf[' + counter + ']"></td>';
	cols += '<td><input type="text" class="form-control matricula searchable" name="matricula[' + counter + ']"></td>';
	cols += '<td><input type="email" class="form-control email searchable" name="email[' + counter + ']"></td>';
	cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Remover"></td>';

    newRow.append(cols);
    $("table.order-list").append(newRow);
    counter++;	
}

function removeRow(btnDel) {
	$(btnDel).closest("tr").remove();
	counter -= 1;
}

function getCertificates(eventId) {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/admin/certificados',
		type: 'POST',
		data: {
			'event_id': eventId,
		},
		dataType: 'JSON',
		success: function(response) {
			//console.log(response.certificates);
			let msgNoCertificates = $('.emited-group').find('p');
			response.certificates.length ? msgNoCertificates.css('display', 'none') : 
				msgNoCertificates.css('display', 'block');

			if(response.certificates.length > 0) {
				msgNoCertificates.css('display', 'none');
				$('table#emited').css('display', 'block');
			}
			else {
				msgNoCertificates.css('display', 'block');
				$('table#emited').css('display', 'none');
			}



			let emitedCertificates = $('table#emited tbody');
			emitedCertificates.empty();

			response.certificates.forEach(student => {
				if(!student['email']) student['email'] = '';
				emitedCertificates.append('<tr>' +
											'<td>' + student['nome'] + '</td>' +
											'<td>' + student['email'] + '</td>' +
											'<td>' + student['matricula'] + '</td>' +
											'<td>' + student['cpf'] + '</td>' +
										  '</tr>');
			});
		},
		error: function(e) {
			var response = JSON.parse(e.responseText);
			var errors = response['errors'];
		}
	});
}

function emitCertificate(studentId, eventId, email, template) {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/admin/certificados/emitir',
		type: 'POST',
		data: {
			'student_id': studentId,
			'event_id': eventId,
			'template': template,
		},
		dataType: 'JSON',
		success: function(response) {
			//console.log(response);
			$('.emited-group').find('p').css('display', 'none');

			let isValidEmail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			isValidEmail = isValidEmail.test(email);
			if(isValidEmail) updateStudentEmail(studentId, email);
			
			getCertificates(eventId);
			fadeMessage(response.queryType);
		},
		error: function(e) {
			var response = JSON.parse(e.responseText);
			var errors = response['errors'];
		}
	});
}

function updateStudentEmail(studentId, email) {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/admin/estudante/' + studentId + '/' + email,
		type: 'GET',
		/*data: {
			'student_id': studentId,
			'event_id': eventId,
			'template': template,
		},*/
		dataType: 'JSON',
		success: function(response) {
			console.log(response);


		},
		error: function(e) {
			var response = JSON.parse(e.responseText);
			var errors = response['errors'];
		}
	});
}



function fadeMessage(queryType) {
	let message,
  		row = '<div class="alert" role="alert"></div>';

	$('#emit-group').append(row);

	if(queryType == 'create') {
    	message = 'Certificado emitido para o aluno';
    	$('.alert').addClass('alert-success');

	}
	else if(queryType == 'update') {
		message = 'Certificado atualizado para o aluno';
		$('.alert').addClass('alert-info');
	}

	$('.alert').empty().html(message);

	$('.alert').delay(3000).fadeOut(function() {
		$(this).remove();
	});
}

function findStudent(input, eventId) {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/admin/estudante/' + input,
		type: 'GET',
		/*data: {'input': input},*/
		dataType: 'JSON',
		success: function(response) {
			//console.log(response);
			if(response.student.length) {
				let studentData = response.student[0];
				$("input[name='cpf']").val(studentData['cpf']);
				$("input[name='matricula']").val(studentData['matricula']);
				$("input[name='email']").val(studentData['email']);
				$("input[name='studentId']").val(studentData['id']);

				$('#emit').attr('disabled', false);
				$('#result').empty().html('1 estudante localizado.').css('color', 'blue');
			}
			else {
				$('#emit').attr('disabled', true);
				$('#result').empty().html('Nenhum estudante localizado.').css('color', 'red');
				$("input[name='studentId']").val('');
			}

		},
		error: function(e) {
			var response = JSON.parse(e.responseText);
			var errors = response['errors'];
			/*$('#view').empty();
			
			$('#view').append('<div class="alert alert-danger form-group" role="alert" id="errors"><ul></ul></div>');
			$.each(errors, function(key, error) {
				$('#errors ul').append('<li>' + error + '</li>');
			});*/
		}
	});
}