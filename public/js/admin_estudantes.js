function updateActiveStudents() {
	let fd = new FormData($('form')[0]);

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});

	$.ajax({
		url: '/admin/estudantes/merge',
		type: 'POST',
		data: fd,
		processData: false,
		success: function(response) {
			console.log(response);
		},
		error: function(response) {
		}
	});

}


function readFile(target) {
	let name = target.value.split('\\');

	$('.custom-file label').html(name[name.length -1]);
	let file = target.files[0];

	$('#update_students').attr('disabled', false);


	/*let output = [];
	parse(reader).on('readable', function(){
		let record
  		while (record = this.read()) {
	    	output.push(record);
	  	}
	})
  		//trim: true,
	  	//skip_empty_lines: true
	
	console.log(output);*/
}