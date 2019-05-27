@component('mail::message')
# Olá {{$primeiro_nome}},

Comunicamos que recebemos com sucesso sua solicitação de ajuste de disciplinas. 
Seguem abaixo as disciplinas passíveis de alteração em seu plano de estudos conforme seu requerimento.

@component('mail::table')
|Periodo | Disciplina | Requerimento |
|:-------|:-----------|:-------------|
@foreach($adjustments as $adjustment)
| {{$adjustment['period']}} | {{$adjustment['subject_name']}} | {{$adjustment['action'] == '1' ? 'Incluir' : 'Excluir'}} |
@endforeach
@endcomponent

Informamos que o resultado estará disponível no idUFF.

Obrigado,<br>
Coordenação do curso de Administração da Universidade Federal Fluminense.
@endcomponent
