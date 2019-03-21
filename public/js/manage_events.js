$(document).ready(function() {
	csvFileContents = '';
    counter = 1;

	/*$('#csv-file').on('change', function() {
		readFile(this);
	});

	$('#metodo-inserir').on('change', changeInsertionMethod);*/

    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

		cols += '<td><input type="text" class="form-control" id="cpf-participante"  name="cpf-participante[' + counter + ']"></td>';
		cols += '<td><input type="text" class="form-control" id="matricula-participante" name="matricula-participante[' + counter + ']"></td>';
		cols += '<td><input type="email" class="form-control" id="email-participante" name="email-participante[' + counter + ']"></td>';
		cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Remover"></td>';

        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });

    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1;
    });



	$('form').on('submit', function(e) {
		//e.preventDefault();
		var insertionMethod = getInsertionMethod();

		//remove names
		if(insertionMethod == 'manual') {
			$('#csv').find('input[type=hidden]').removeAttr('name');
		}
		else if(insertionMethod == 'csv') {
			//console.log($('#manual').find('tbody input'));
			$('#manual').find('tbody input').removeAttr('name');
			$('#file-contents').val(csvFileContents);
		}
	});
});