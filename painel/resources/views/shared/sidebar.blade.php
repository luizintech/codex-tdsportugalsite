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
            <li class="nav-item"> <a class="nav-link" href="{{url('')}}/users">Usuários</a></li>
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

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="icons">
          <span class="menu-title">Relatórios</span>
          <i class="icon-badge menu-icon"></i>
        </a>
        <div class="collapse" id="reports">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{url('')}}/YoutubeVideoReports">Manutenção dos Videos</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{url('')}}/YoutubeShortReports">Manutenção dos Shorts</a></li>
          </ul>
        </div>
      </li>

      {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
          <span class="menu-title">Forms</span>
          <i class="icon-book-open menu-icon"></i>
        </a>
        <div class="collapse" id="forms">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/forms/basic_elements.html">Form Elements</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
          <span class="menu-title">Charts</span>
          <i class="icon-chart menu-icon"></i>
        </a>
        <div class="collapse" id="charts">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
          <span class="menu-title">Tables</span>
          <i class="icon-grid menu-icon"></i>
        </a>
        <div class="collapse" id="tables">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic Table</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category"><span class="nav-link">Extra Pages</span></li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <span class="menu-title">User Pages</span>
          <i class="icon-disc menu-icon"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category"><span class="nav-link">Help</span></li>
      <li class="nav-item">
        <a class="nav-link" href="docs/documentation.html" target="_blank">
          <span class="menu-title">Documentation</span>
          <i class="icon-folder-alt menu-icon"></i>
        </a>
      </li> --}}
    </ul>
  </nav>