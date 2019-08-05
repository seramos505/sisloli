@extends("theme.$theme.layout")
@section('titulo')
    Productos
@endsection
@section('contenido')
    <div class="row">
        <div class="col-lg-12 px-0">
                

                @can('Agregar Producto')
                    con permiso
                @else
                    sin permiso                    
                @endcan
            <producto></producto>
        </div>        
    </div>
@endsection