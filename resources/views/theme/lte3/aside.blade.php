<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-info" style="background-color: #1f2d3d;">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link navbar-info pl-1">
    <img src="{{asset("assets/$theme/dist/img/logo-transparente.png")}}" alt="LOLI Logo" class="brand-image ml-0">
    <span class="">RASPADOS LOLI</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset("assets/$theme/dist/img/user2-160x160.jpg")}}" class="img-circle elevation-2"
          alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">        
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        @foreach ($menusComposer as $key => $item)
          @if ($item["menu_id"] != 0)
            @break
          @endif
          @include("theme.$theme.menu-item", ["item" => $item])
        @endforeach    

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Catalogo
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-4">
            <li class="nav-item">
              <a href="{{route('producto')}}" class="nav-link {{getMenuActivo('producto')}}">
                <i class="fab fa-product-hunt nav-icon"></i>
                <p>Productos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('categoria')}}" class="nav-link  {{getMenuActivo('categoria')}}">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>Categorías</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('sabor')}}" class="nav-link  {{getMenuActivo('sabor')}}">
                <i class="fas fa-ice-cream nav-icon"></i>
                <p>Sabores</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('tamano')}}" class="nav-link  {{getMenuActivo('tamano')}}">
                <i class="fas fa-ruler nav-icon"></i>
                <p>Tamaños</p>
              </a>
            </li>  
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cart-plus"></i>
            <p>
              Ventas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-4">
            <li class="nav-item">
              <a href="{{route('orden')}}" class="nav-link {{getMenuActivo('orden')}}">
                <i class="fas fa-cart-arrow-down nav-icon"></i>
                <p>Ordenes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/charts/flot.html" class="nav-link">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Clientes</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Reportes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-4">
            <li class="nav-item">
              <a href="pages/charts/chartjs.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ventas Diario</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/charts/flot.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ventas por Mes</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Acceso
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-4">
            <li class="nav-item">
              <a href="pages/charts/chartjs.html" class="nav-link">
                <i class="fas fa-user nav-icon"></i>
                <p>Usuarios</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/charts/flot.html" class="nav-link">
                <i class="fas fa-scroll nav-icon"></i>
                <p>Roles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/charts/flot.html" class="nav-link">
                <i class="fas fa-user-tag nav-icon"></i>
                <p>Permisos</p>
              </a>
            </li>
            <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="fas fa-bars nav-icon"></i>
                  <p>Menus</p>
                </a>
              </li>
          </ul>
        </li> 
        
        <li class="nav-item">
          <a href="pages/widgets.html" class="nav-link">
            <i class="nav-icon fas fa-exclamation-circle"></i>
            <p>
              Ayuda
              <span class="right badge badge-danger">PDF</span>
            </p>
          </a>
        </li>


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>