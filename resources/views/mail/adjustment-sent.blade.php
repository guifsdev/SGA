@component('mail::message')
# Olá {{$studentName}},

Comunicamos que recebemos com sucesso sua solicitação de ajuste de disciplinas. 
Abaixo, as disciplinas passíveis de alteração em seu plano de estudos conforme seu requerimento.

@component('mail::table')
|Periodo | Disciplina | Requerimento |
|:-------|:-----------|:-------------|
@foreach($adjustments as $adjustment)
| {{$adjustment['period']}} | {{$adjustment['subject']['name_class']}} | {{$adjustment['action']}} |
@endforeach
@endcomponent

Assinatura: **`{{$signature}}`**

Informamos que o resultado estará disponível no idUFF.

Obrigado,<br>
SGA

Coordenação do curso de Administração da Universidade Federal Fluminense.
@endcomponent
