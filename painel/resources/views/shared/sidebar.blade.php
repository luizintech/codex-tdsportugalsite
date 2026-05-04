<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item navbar-brand-mini-wrapper">
        <a class="nav-link navbar-brand brand-logo-mini" 
          href="{{url('')}}"><img src="{{url('')}}/dist/assets/images/logo-mini.svg" alt="logo" /></a>
      </li>
      <li class="nav-item nav-profile">
        {{-- <a href="#" class="nav-link">
          <div class="profile-image">
            <img class="img-xs rounded-circle" src="{{url('')}}/dist/assets/images/faces/face8.jpg" alt="profile image">
            <div class="dot-indicator bg-success"></div>
          </div>
          <div class="text-wrapper">
            <p class="profile-name">Henry Klein</p>
            <p class="designation">Administrator</p>
          </div>
          <div class="icon-container">
            <i class="icon-bubbles"></i>
            <div class="dot-indicator bg-danger"></div>
          </div>
        </a> --}}
      </li>
      <li class="nav-item nav-category">
        <span class="nav-link">Dashboard</span>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{url('')}}">
          <span class="menu-title">Dashboard</span>
          <i class="icon-screen-desktop menu-icon"></i>
        </a>
      </li>
      <li class="nav-item nav-category"><span class="nav-link">Registros</span></li>
      
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#users" aria-expanded="false" aria-controls="icons">
          <span class="menu-title">Administrar site</span>
          <i class="icon-globe menu-icon"></i>
        </a>
        <div class="collapse" id="users">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{url('')}}/Users">Usuários</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('')}}/configurations">Configurações</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#registers" aria-expanded="false" aria-controls="icons">
          <span class="menu-title">Registros</span>
          <i class="icon-badge menu-icon"></i>
        </a>
        <div class="collapse" id="registers">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{url('')}}/Labels">Rotulos</a></li>
			      <li class="nav-item"> <a class="nav-link" href="{{url('')}}/Categories">Categorias</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('')}}/Medias">Midias</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('')}}/Posts">Artigos</a></li>
          </ul>
        </div>
      </li>

    </ul>
  </nav>