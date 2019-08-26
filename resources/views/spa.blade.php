@extends("theme.$theme.layout")
@section('titulo')
    Categorias
@endsection
@section('header')
    Catalogo    
@endsection
@section('contenido')
    <div class="row">
        <div class="col-lg-12 px-0">
            <app></app>
        </div>        
    </div>
@endsection
@section('menu')
    <navigationmenu></navigationmenu>    
@endsection