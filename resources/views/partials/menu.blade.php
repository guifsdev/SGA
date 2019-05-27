<nav 
  class="navbar navbar-expand-lg navbar-light"
  style="background-color: #e3f2fd; margin-bottom: 20px">

  <a class="navbar-brand" href="#">@yield('nav_title')</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
      	<a class="nav-link" href="/admin"><i class="fa fa-home"></i>  Painel</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ajuste
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/admin/ajuste">Listar</a>
          <a class="dropdown-item" href="/admin/ajuste/config">Configurações</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Eventos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/admin/eventos">Listar</a>
          <a class="dropdown-item" href="/admin/eventos/criar">Criar</a>
          <a class="dropdown-item" href="/admin/eventos/templates">Templates</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a href="#"
            tabindex="-1" aria-disabled="true" id="certificadosDropdown"
            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="nav-link dropdown-toggle">
              Certificados
        </a>
        <div class="dropdown-menu" aria-labelledby="certificadosDropdown">
          <a class="dropdown-item" href="/admin/certificados/emitir">Emitir</a>
        </div>
      </li> 



      <li class="nav-item dropdown">
        <a href="#"
            tabindex="-1" aria-disabled="true" id="disciplinasDropdown"
            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="nav-link dropdown-toggle {{Auth::user()->is_admin ? '' : 'disabled'}}">
              Disciplinas
        </a>
        <div class="dropdown-menu" aria-labelledby="disciplinasDropdown">
          <a class="dropdown-item" href="/admin/disciplinas">Listar</a>
          <a class="dropdown-item" href="/admin/disciplinas/criar">Criar</a>
        </div>
      </li> 

      <li class="nav-item">
        <a href="/admin/usuarios" tabindex="-1" aria-disabled="true"
            class="nav-link {{Auth::user()->is_admin ? '' : 'disabled'}}">Usuários</a>
      </li>
      <li class="nav-item dropdown">
        <a href="#"
            tabindex="-1" aria-disabled="true" id="estudantesDropdown"
            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="nav-link dropdown-toggle">
              Estudantes
        </a>
        <div class="dropdown-menu" aria-labelledby="estudantesDropdown">
          <a class="dropdown-item" href="/admin/estudantes">Listar</a>
          <a class="dropdown-item" href="/admin/estudantes/atualizar">Atualizar ativos</a>
        </div>
      </li>     
      <li class="nav-item">
        <a class="nav-link" href="/admin/logout" tabindex="-1" aria-disabled="false">Sair</a>
      </li>
    </ul>
  </div>
</nav>