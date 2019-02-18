@component('mail::message')
# Recebemos os seu requerimento de ajuste.

Comunicamos que recebemos com sucesso sua solicitação. 
Segue abaixo as disciplinas passiveis de alteração no seu plano de estudos conforme requerimento.

@component('mail::table')
|Periodo | Disciplina | Requerimento |
|:-------|:-----------|:-------------|
@foreach($attributes['periodo-ajuste'] as $key => $periodo)
| {{$periodo}} | {{$attributes['disciplina-ajuste'][$key]}} | {{$attributes['acao-ajuste'][$key]}} |
@endforeach
@endcomponent

Informamos que o resultado estará disponível no idUFF.


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
