@component('mail::message')
# Olá {{$studentName}},

O seu requerimento de ajuste de disciplinas teve o seguinte resultado:

@component('mail::table')
|Periodo | Disciplina | Requerimento | Resultado| Motivo |
|:-------|:-----------|:-------------|:---------|:-------|
@foreach($adjustments as $adjustment)
| {{$adjustment['period']}} | {{$adjustment['subject_name']}} | {{$adjustment['action']}} | {{$result}} | {{$reason}} |
@endforeach
@endcomponent
<style>
table.wrapper {
	white-space: nowrap;
}
</style>



Vale lembrar que o resultado definitivo estará no seu plano de estudos do idUFF.

<br>
SGA

Coordenação do curso de Administração da Universidade Federal Fluminense.
@endcomponent
