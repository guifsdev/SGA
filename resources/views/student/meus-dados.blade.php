<div class="container" style="max-width: 100%; margin: 0; padding: 0"><!-- <h3>Ajuste de disciplinas do aluno</h3> -->
    <div class="card" style="width: 18rem;">
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>CR:</b> {{$student->cr}}</li>
        <li class="list-group-item"><b>CHA:</b> {{$student->cha}}</li>
        <li class="list-group-item"><b>CHC:</b> {{$student->chc}}</li>
        <li class="list-group-item"><b>CHT:</b> {{$student->cht}}</li>
        <li class="list-group-item"><b>Localidade:</b> {{$student->localidade}}</li>
        <li class="list-group-item"><b>Currículo:</b> {{$student->curriculo}}</li>
      </ul>
    </div>

    <form method="POST" action="#" style="margin-top: 15px">
    {{csrf_field()}}
    {{method_field('PATCH')}}
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control" id="cpf" placeholder="Sua matrícula" 
                name="cpf" disabled="disabled"
                value="{{$student->cpf}}">
        </div>
    
        <div class="form-group">
            <label for="matricula">Matrícula:</label>
            <input type="text" class="form-control" id="matricula" placeholder="Sua matrícula" 
                name="matricula" disabled="disabled"
                value="{{$student->matricula}}">
        </div>
        <div class="form-group">
            <label for="nome">Nome completo:</label>
            <input type="text" class="form-control" id="nome" placeholder="Seu nome" name="nome" required
                value="{{$nome_completo}}">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required 
                value="{{$student->email}}">
        </div>
    
        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="tel" class="form-control" id="telefone" name="tel" required
                value="{{$student->tel}}">
        </div>
        <div class="form-group align-center">
            <button type="submit" class="btn btn-primary" id="atualizar" aria-describedby="aviso">Salvar Alterações</button>
        </div>
        
        @include('partials.errors')
    </form>
</div>



<script>
$(document).ready(function() {
    $('#telefone').mask('(00) 00000-0000');

    $('form').on('submit', function(e) {
        e.preventDefault();
        let form = $('form');
        updateStudentData(form);
        removeMask($('#telefone'));
    });




});
</script>