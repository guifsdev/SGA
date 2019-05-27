function adjustModify() {
	let studentData = {};
	$('#student_data input').each(function() {
		studentData[this.name] = this.value;
	});


	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/ajuste/modificar',
		type: 'POST',
		data: {
			'student_data': studentData
		},
		dataType: 'JSON',
		success: function(response) {
			$('#view').empty();
			$('#view').html(response.html);
		},
		error: function(e) {
			var response = JSON.parse(e.responseText);
			var errors = response['errors'];
			$('#view').empty();
			
			$('#view').append('<div class="alert alert-danger form-group" role="alert" id="errors"><ul></ul></div>');
			$.each(errors, function(key, error) {
				$('#errors ul').append('<li>' + error + '</li>');
			});
		}
	});
}
function adjustConfirm() {
	let subjectId = [], 
		action  = [];
	let adjustments = [];

	['subject_id', 'action'].forEach(column => {
		$('.' + column + ' option:selected[value != ""]').each(function(data) {
			if(column == 'subject_id') subjectId.push(this.value);
			if(column == 'action') action.push(this.value);
		});
	});
	console.log('subject: ', subjectId, 'action: ', action);

	//malfilled form
	if(subjectId.length != action.length) {
		$('#errors').remove();
		$('form#adjustment').append('<div class="alert alert-danger form-group" role="alert" id="errors"><ul></ul></div>');
		$('#errors ul').append('<li>Preenchimento incorreto.</li>');
		return;
	} 
	//tranform the arrays in a json obj
	else {
		for(let i = 0; i < subjectId.length; ++i) {
			let adjust = {};
			adjust.subjectId = subjectId[i];
			adjust.action = action[i];
			adjustments.push(adjust);
		}
		console.log('confirming adjustments: ', adjustments);
	}

	$('#telefone').unmask();

	let studentData = {};

	$('#student_data input').each(function() {
		studentData[this.name] = this.value;
	});

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});
	$.ajax({
		url: '/ajuste/confirmar',
		type: 'POST',
		data: {
			'student_data': studentData,
			'adjustments': adjustments,
		},
		dataType: 'JSON',
		success: function(response) {
			//console.log(response);
			$('#view').html(response.html);
		},
		error: function(data) {
			$('#telefone').mask('(00) 00000-0000');
			$('#errors').remove();
			$('form#adjustment').append('<div class="alert alert-danger form-group" role="alert" id="errors"><ul></ul></div>');
			let error = data.responseJSON;

			if(error.reason) {
				$('#errors ul').append('<li>' + error.reason + '</li>');
			}
		}
	});
}
function adjustSave() {
	let studentData = {};
	let subjectId = [], 
		action  = [];
	let adjustments = [];


	['action', 'subject_id'].forEach(column => {
		$('input.' + column).each(function(data) {
			if(column == 'action') action.push(this.value);
			if(column == 'subject_id') subjectId.push(this.value);
		});
	});
	for(let i = 0; i < subjectId.length; ++i) {
		let adjust = {};
		adjust.action = action[i];
		adjust.subjectId = subjectId[i];

		adjustments.push(adjust);
	}
	console.log('saving adjustments: ' + JSON.stringify(adjustments));
	
	$('#save').attr('disabled', true)
		.html('Salvando... ')
		.append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
	//console.log(`save: ${save}, route: ${route}, adjustments: ${adjustments}`);

	$('#student_data input').each(function() {
		studentData[this.name] = this.value;
	});

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});
	$.ajax({
		url: '/ajuste/salvar',
		type: 'POST',
		data: {
			'student_data': studentData,
			'adjustments': adjustments,
		},
		dataType: 'JSON',
		success: function(response) {
			//console.log(response);
			$('#view').html(response.html);
		},
		error: function(data) {
			$('#errors').remove();
			$('form#adjustment').append('<div class="alert alert-danger form-group" role="alert" id="errors"><ul></ul></div>');
			let error = data.responseJSON;

			if(error.reason) {
				$('#errors ul').append('<li>' + error.reason + '</li>');
			}
		}
	});
}
function loadDashboardView(route) {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});
	$.ajax({
		url: route,
		type: 'POST',
		data: {
			'route': route
		},
		dataType: 'JSON',
		success: function(response) {
			$('#view').empty();
			$('#view').html(response.html);
		},
		error: function(e) {
			var response = JSON.parse(e.responseText);
			var errors = response['errors'];
			$('#view').empty();
			
			$('#view').append('<div class="alert alert-danger form-group" role="alert" id="errors"><ul></ul></div>');
			$.each(errors, function(key, error) {
				$('#errors ul').append('<li>' + error + '</li>');
			});
		}
	});
}
//substitui buscarDisciplinas
function getAdjustSubjects(period, row) {
	let subjects = row.find('#subject'),
		action = row.find('#action');
	if(!period) {
		subjects.empty().append('<option value="">Selecione</option>');
		action.empty().append('<option value="">Selecione</option>');
		return;
	}

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/disciplinas',
		type: 'POST',
		data: {
			'period' : period
		},
		dataType: 'JSON',
		success: function(response) {
			//console.log(response);
			subjects.empty();
			action.empty();
			for(let i = 0; i < response.length; ++i) {
				let attributes = response[i],
					subjectName = attributes['name'],
					className = attributes['class_name'],
					subjectId = attributes['id'];
				subjects.append('<option value="'+ subjectId +'">' + subjectName + ' ' + className + '</option>');
			}
			subjects.find('option').eq(0).remove();

			action.append('<option value="">Selecione</option>' +
						  '<option value="1">Incluir</option>' +
						  '<option value="0">Excluir</option>');

		},
		error: function(data) {
			console.log("Error: " + JSON.stringify(data));
		}
	});
}
function updateStudentData(form) {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/estudante',
		type: 'PATCH',
		data: form.serialize(),
		dataType: 'JSON',
		success: function(response) {
			//console.log(response);
			$('.alert-success').remove();
			form.append('<div class="alert alert-success" role="alert">' + 'Dados atualizados com sucesso' + '</div>');
		},
		error: function(e) {
			var response = JSON.parse(e.responseText);
			var errors = response['errors'];

			$('#errors').remove();
			
			form.append('<div class="alert alert-danger form-group" role="alert" id="errors"><ul></ul></div>');
			$.each(errors, function(key, error) {
				$('#errors ul').append('<li>' + error + '</li>');
			});
		}
	});
}

//Table add row Dynamically
//https://bootsnipp.com/snippets/402bQ
/*function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();
}*/

/*function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}*/
function changeInsertionMethod()
{
	var method = $(this).find(':selected').val();

	var manual = $('#manual');
	var csv = $('#csv');

	if(method == 'csv') {
		manual.addClass('collapse');
		csv.removeClass('collapse');
	}
	else if(method == 'manual') {
		manual.removeClass('collapse');
		csv.addClass('collapse');
	}
	return method;
}

function getInsertionMethod()
{
	var method = $('#metodo-inserir').find(':selected').val();
	return method;
}

function readFile(input)
{
    var fileName = $(input).val();

    


    fileName = fileName.split('\\');
    $(input).next('.custom-file-label').html(fileName[fileName.length -1]);

    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = (function(file) {
    	return function(e) {
    		var contents = e.target.result;
    		csvFileContents = contents;

    		test = 1;
			//formData = new FormData();
    		//console.log(contents);
    		formData.append('file', contents);

    		//console.log(formData['file']);

    	};

    })(file);
    reader.readAsText(file);
}

function changeFormAction(btn)
{
    if(btn.attr('id') === 'modificar')
    {
        $('form').attr('action', '/ajuste/modificar');
    }

}
function reenableInputs() {
    var disabledInputs = $('input:disabled');
    disabledInputs.prop('disabled', false);
}


function atualizarTabela()
{ 
    $("#requerimentos table").load(window.location.href + '#requerimentos table');
}

