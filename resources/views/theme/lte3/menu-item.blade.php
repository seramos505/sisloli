@if ($item["submenu"] == [])
    <li class="{{getMenuActivo($item["url"])}}">
        <a href="{{url($item['url'])}}">
          <i class="fa {{$item["icono"]}}"></i> <span>{{$item["nombre"]}}</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{route('categoria')}}" class="nav-link  {{getMenuActivo('categoria')}}">
            <i class="fas fa-clipboard-check nav-icon"></i>
            <p>Categorías</p>
        </a>
    </li>
@else
    <li class="treeview">
        <a href="javascript:;">
          <i class="fa {{$item["icono"]}}"></i> <span>{{$item["nombre"]}}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
            @foreach ($item["submenu"] as $submenu)
                @include("theme.$theme.menu-item", ["item" => $submenu])
            @endforeach
        </ul>
    </li>
@endif