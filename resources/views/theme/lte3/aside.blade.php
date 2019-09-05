<!-- Main Sidebar Container -->
{{-- {{dd($menusComposer)}} --}}
{{-- {{dd(Auth::user()->roles->pluck('id'))}}  --}}
<aside class="main-sidebar elevation-4 sidebar-dark-info" style="background-color: #1f2d3d;">
  <!-- Brand Logo -->
  <div class="brand-link navbar-info pl-1">
    <img src="{{asset("images/logo-transparente.png")}}" alt="LOLI Logo" class="brand-image ml-0">    
    <a href="{{ route('admin') }}" class="text-white">RASPADOS <b>LOLI</b></a>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    @auth 
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset("images")}}/{{ Auth::user()->image }}" class="img-circle elevation-2"
            alt="User Image">
        </div>
        <div class="info">
          <div class="text-white" class="d-block">{{ Auth::user()->name }}</div>
          
          <small class="float-right">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
              <i class="fas fa-power-off"></i> Cerrar Sesion
            </a>
          </small>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>     
        </div>
      </div>
    @endauth
    <!-- Sidebar Menu -->
    <navigationmenu></navigationmenu>
    {{-- <nav class="mt-2">
        
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        @foreach ($menusComposer as $key => $item)
        @if ($item["parent_menu"] != 0)
        @break
        @endif
        @include("theme.$theme.menu-item", ["item" => $item])
        @endforeach

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
    </nav> --}}
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>