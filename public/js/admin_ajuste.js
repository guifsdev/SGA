function updateAdjustments(action) {
	let adjustBag = {};
	/*
		{
			ids: [1,2,3,4,5],
			reason: 'foo',
			description: 'bar'
		}
	*/
	$(".adjust_check:checked").each(function() {
		if(!adjustBag.ids) adjustBag.ids = [$(this).attr('id')];
		else adjustBag.ids.push($(this).attr('id'));
		if(action == 'deny') {
			if($('#reason_deny').val() == 'outro') {
				let description = $('textarea[name="description"]').val();
				if(!description) {
					alert('Descreva o motivo do indeferimento.');
					return false;
				}
				//console.log($('input[name="description"]').text());
				adjustBag.reason = $('textarea[name="description"]').val();
			}
			else {
				adjustBag.reason = $('#reason_deny').val();
			}
		}
	});

	if(action == 'deny' && !('reason' in adjustBag)) return false;

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/admin/ajuste/update',
		type: 'POST',
		data: {
			'adjust_bag': adjustBag,
			'update': action
		},
		dataType: 'JSON',
		success: function(response) {
			response.ids.forEach(id => {
				let row = $('#adjustments #' + id).parents().eq(1);
				row.find('#reason_denied').empty();
				row.find('#result').html(response.result);

				if(action == 'deny') {
					row.find('#reason_denied').html(response.reason);
				}
			});
		},
		error: function(response) {
			response = response.responseJSON;
			console.log(response);
			$('#actions #errors').remove();
			$('#actions').append('<div class="alert alert-danger form-group" role="alert" id="errors"></div>');
			$('#errors').html(response.reason);
		}
	});
}

function sendFilterParams() {
	$('#check_many').prop('checked', false);
	toggleDeferChecked(false);
	toggleDenyChecked(false);
	toggleDescription(false);

	let filterParams = {};

	$("#main_filter [type='checkbox']").each(function() {
		if($(this).prop('checked') == true) {
			let key = $(this).siblings('.filter_input').attr('name');
			let value = $(this).siblings('.filter_input').val();
			if((key && value) != '') filterParams[key] = value;
		}
	});
	if(Object.keys(filterParams).length) {
		let filterType = $('[name="filter_type"]').val();
		filterParams['filter_type'] = filterType;
	}

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/admin/ajuste/filtrar',
		type: 'POST',
		data: {
			'filter_params': filterParams
		},
		dataType: 'JSON',
		success: function(response) {
			//$('#adjustments tbody').empty().html(response.html);
			//console.log(response.filter_params);
			
			let table = $('#adjustments tbody');
			table.empty().html(response.html);
			//console.log(response.request);

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

function clearFilter() {
	$('#main_filter .filter_input').each(function() {
		let target = $(this);
		target.siblings('[type=checkbox]').prop('checked', false);
		if(target.is('select')) target.prop('selectedIndex', 0);
		if(target.is('input')) target.val('');
	});
}

function checkMany() {
	$(this).prop('checked', function(i, value) {
		if(value) {
			$('.adjust_check').prop('checked', 'checked');
			toggleDeferChecked(true);
		}
		else {
			$('.adjust_check').prop('checked', false);
			toggleDeferChecked(false);
			toggleDenyChecked(false);
			toggleDescription(false);
		}
	});
}

function toggleDeferChecked(state) {
	$('button#defer').attr('disabled', !state);
}

function toggleDenyChecked(state) {
	if(!state) $('#reason_deny option[value=""]').prop('selected', 'selected');
	$('button#deny').attr('disabled', !state);
}
function toggleDescription(state) {
	if(state) {
		$('#reason_description').removeClass('collapse');
	}
	else {
		$('#reason_description').addClass('collapse');
	}
}


function filterTable(key) {
	$('#adjustments tr:not(#head)').filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(key) > -1)
	});
}

