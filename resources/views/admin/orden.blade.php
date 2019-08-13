@extends("theme.$theme.layout")
@section('titulo')
    Ordenes
@endsection


@section('contenido')
    <div class="row">
        <div class="col-lg-12 px-0">
            <orden></orden>
           

            <div class="form-group">
                <label>Minimal</label>
                <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                </select>
            </div>
        </div>        
    </div>
@endsection
