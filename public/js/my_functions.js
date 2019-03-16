function getView(view) {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/estudante',
		type: 'POST',
		data: {
			'view': view
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
function buscarDisciplinas(route = '/ajuste', selected = null)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    //em 'admin/ajuste' o select do período é: $('select[name=periodo]')
    //em '/ajuste' é $('.periodo')

    var periodo, colDisciplinas;

    if(route === '/ajuste')
    {
		var row = $(selected).parents(':eq(1)');
		periodo = row.find('.periodo :selected').text();
		colDisciplinas = row.find('.disciplina');
    }

    else if(route === '/admin/ajuste') {
    	//console.log(route);

    	periodo = $('select[name=periodo] :selected').text();
    	colDisciplinas = $('select[name=disciplina]');
    }
    
	//Limpar conteudo da coluna de disciplinas
	colDisciplinas.html('');

	//Coletar as disciplinas do periodo selecionado
	$.ajax({
		url: '/disciplinas',
		type: 'POST',
		data: {
			'periodo' : periodo
		},
		dataType: 'JSON',
		success: function(response) {
			if(route === '/admin/ajuste') colDisciplinas.append('<option value="Todos">Todas</option>');

			for(var i = 0; i < response.length; ++i) {
				colDisciplinas.append('<option>' + response[i]['name'] + ' ' + response[i]['class_name'] + '</option>');
			}
		},
		error: function(data) {
			//console.log("Error: " + JSON.stringify(data));
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

function sendFilterParams(form) 
{
	//Remover o nome dos inputs desmarcados
	var checkboxes = form.find('input[type=checkbox]').each(function() {
		var input = $(this);
		var inputSiblings = $(this).siblings('.input-filtros');

		//Não está marcada ou está marcada 
		if(! input.is(':checked') || (input.is(':checked') && (inputSiblings.val() === 'Todos'))) {
			//console.log(inputSiblings.val())
			inputSiblings.removeAttr('name');
		}
		//TODO Remover nome de filtros com select em 'Todos'
	});
}

function ajusteAction(form, action)
{
	removeDisabledAttributes();
	var formData = $(form).serialize();
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: action,
		type: 'POST',
		data: formData,
		dataType: 'JSON',
		success: function(response) {
			//console.log(response);
			$('#view').html(response.html);
		},
		error: function(e) {
			var response = JSON.parse(e.responseText);
			var errors = response['errors'];
			$('#errors').remove();
			form.append('<div class="alert alert-danger form-group" role="alert" id="errors"><ul></ul></div>');

			if(!errors) {
				$('#errors').prepend('Erro ao enviar requisição. Tente novamente em alguns instantes.');
			} else {
				$.each(errors, function(key, error) {
					$('#errors ul').append('<li>' + error + '</li>');
				});
			}

		}
	});
}
function removeDisabledAttributes() 
{
	var cpf = $('#cpf');
	var matricula = $('#matricula');

	cpf.prop('disabled', false);
	matricula.prop('disabled', false);
}
function bulkSelect()
{
	//console.log('bulkSelect');
	liberarDeferir();
	var checkLinhas = $('.checkable').filter(function(){
		var row = $(this).closest('tr');
		if(row.css('display') === 'none') return false;
		else return true;
	});

	if($(this).is(':checked')) {
		//excluir os não visiveis

		if(!checkLinhas.is(':checked')) {
			checkLinhas.prop('checked', true);
		}
	}
	else checkLinhas.prop('checked', false);
}
function liberarDeferir()
{
	var deferirBtn = $('#deferir');
	var elements = $('#requerimentos').find('input[type=checkbox]:checked');
	elements.length >= 1 ? deferirBtn.prop('disabled', false) : deferirBtn.prop('disabled', true);
}
function toggleActionButtons()
{
	var acoesBtns = $('#acoes-btns button');
	var elements = $('#requerimentos').find('input[type=checkbox]:checked');
	if(elements.length == 0) acoesBtns.prop('disabled', true);
}
function processarAjuste(acao)
{	
	var route = '/admin/ajuste/' + $(acao).attr('id');
	//Se o botão de ação clicado for deferir, 


	var form = $('form');
	form.find('tbody tr').each(function() {
		var check = $(this).find('input[type=checkbox]');

		if(!check.is(':checked')) {
			$(this).find('input[type=hidden]').removeAttr('name');
		}
	});

	//Implementar Ajax
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

	$.ajax({
			url: route,
			type: 'POST',
			data: form.serialize(),
			success: function(response) {
				//console.log('Success: ' + JSON.stringify(response));
				atualizarTabela();
			},
			error: function(data) {
				//console.log("Error: " + JSON.stringify(data));
			}
	});
}

//Table add row Dynamically
//https://bootsnipp.com/snippets/402bQ
function calculateRow(row) 
{
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}
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

function viewCertificate(el)
{
	$('form').attr('action', $(el).attr('href'));
	$('form').submit();
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

