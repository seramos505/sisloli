@extends("theme.$theme.layout")
@section('titulo')
    Productos
@endsection
@section('contenido')
    <div class="row">
        <div class="col-lg-12 px-0">  
            @can('listar-producto')
                <producto></producto>
            @else
                No Tiene Permiso para ver los Productos                    
            @endcan
        </div>        
    </div>
@endsection