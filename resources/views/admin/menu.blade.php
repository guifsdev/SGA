<nav 
  class="navbar navbar-expand-lg navbar-light"
  style="background-color: #e3f2fd;">

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
          <a class="dropdown-item" href="/admin/ajuste">Ver</a>
          <a class="dropdown-item" href="/admin/ajuste/config">Configurar</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Eventos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/admin/eventos">Ver</a>
          <a class="dropdown-item" href="/admin/eventos/configurar">Configurar</a>
        </div>
      </li>

      <li class="nav-item">
        <a href="/admin/usuarios" tabindex="-1" aria-disabled="true"
            class="nav-link {{Auth::user()->role == 'admin' ? '' : 'disabled'}}">Usuários</a>
      </li>      
      <li class="nav-item">
        <a class="nav-link" href="/admin/logout" tabindex="-1" aria-disabled="false">Sair</a>
      </li>
    </ul>
  </div>
</nav>