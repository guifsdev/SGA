@if($adjustments->count() > 0)
	@foreach($adjustments as $adjustment)
	<tr>
		<th scope="row">
			<input id="{{$adjustment['id']}}" class="adjust_check" type="checkbox"/><label for="{{$adjustment['id']}}"></label>
		</th>
		<td>{{$adjustment['id']}}</td>
		<td>{{$adjustment['student_name']}}</td>	
		<td>{{$adjustment['student_cpf']}}</td>	
		<td>{{$adjustment['student_matricula']}}</td>	
		<td>{{$adjustment['subject_code'] . ' ' . $adjustment['subject_name'] . ' ' . $adjustment['subject_class_name']}}</td>	
		<td id="reason_denied">{{$adjustment['reason_denied']}}</td>	
		<td>{{$adjustment['action']}}</td>	
		<td>{{$adjustment['created_at']}}</td>	
		<td id="result">{{$adjustment['result']}}</td>
	</tr>
	@endforeach
@else
<tr>
	<td colspan="10" style="text-align: center">Nenhum resultado</td>
</tr>
@endif