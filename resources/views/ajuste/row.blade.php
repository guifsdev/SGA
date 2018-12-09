<tr class="ajuste" id="{{$i}}">
  <td scope="row">
	<select class="custom-select custom-select-sm periodo" id="{{$i}}" name="periodo-ajuste[{{$i}}]">
	  	<option selected disabled hidden value="dummy">Selecione</option>

	  @for($j = 1; $j <= 8; ++$j)
		<option value="{{$j}}">{{$j}}</option>
	  @endfor
	</select>
  </td>

  <td>
	<select class="custom-select custom-select-sm disciplina" id="{{$i}}" name="disciplina-ajuste[{{$i}}]">
	  <option selected disabled value="dummy">Selecione</option>
	</select>
  </td>

  <td style="width: 5%" class="align-radio-center">
	<div class="form-check">
	  <input class="form-check-input acao" type="radio" name="acao-ajuste[{{$i}}]" id="incluir-disciplina{{$i}}" value="incluir">
	</div>
  </td>
  <td style="width: 5%" class="align-radio-center">
	<div class="form-check">
	  <input class="form-check-input acao" type="radio" name="acao-ajuste[{{$i}}]" id="excluir-disciplina-{{$i}}" value="excluir">
	</div>
  </td>
</tr>

<script type="text/javascript">
$(document).ready(function() {
	$('.custom-select').val('dummy');
});
</script>
