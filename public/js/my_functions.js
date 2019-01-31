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
		url: '/subjects',
		type: 'POST',
		data: {
			'periodo' : periodo
		},
		dataType: 'JSON',
		success: function(response) {
			if(route === '/admin/ajuste') colDisciplinas.append('<option>Todas</option>');

			for(var i = 0; i < response.length; ++i) {
				colDisciplinas.
				append('<option>' + response[i]['name'] + '</option>');
			}
		},
		error: function(data) {
			console.log("Error: " + JSON.stringify(data));
		}
	});
}

function sendFilterParams(form) {
	//Remover o nome dos inputs desmarcados
	var checkboxes = form.find('input[type=checkbox]').each(function() {
		if(! $(this).is(':checked')) {
			$(this).siblings('.input-filtros').removeAttr('name');
		}
		//TODO Remover nome de filtros com select em 'Todos'
	});
}