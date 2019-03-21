@component('mail::message')
# Recebemos os seu requerimento de ajuste.

Comunicamos que recebemos com sucesso sua solicitação de ajuste de disciplinas. 
Seguem abaixo as disciplinas passíveis de alteração em seu plano de estudos conforme seu requerimento.

@component('mail::table')
|Periodo | Disciplina | Requerimento |
|:-------|:-----------|:-------------|
@foreach($attributes['periodo-ajuste'] as $key => $periodo)
| {{$periodo}} | {{$attributes['disciplina-ajuste'][$key]}} | {{$attributes['acao-ajuste'][$key]}} |
@endforeach
@endcomponent

Informamos que o resultado estará disponível no idUFF.

Obrigado,<br>
Coordenação do curso de Administração da Universidade Federal Fluminense.
@endcomponent
