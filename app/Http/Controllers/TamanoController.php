<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Tamano;

class TamanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tamanos = Tamano::orderBy('id', 'desc')->paginate(15);
        }
        else{
            $tamanos = Tamano::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $tamanos->total(),
                'current_page' => $tamanos->currentPage(),
                'per_page'     => $tamanos->perPage(),
                'last_page'    => $tamanos->lastPage(),
                'from'         => $tamanos->firstItem(),
                'to'           => $tamanos->lastItem(),
            ],
            'tamanos' => $tamanos
        ];
    }


    public function selectTamano(Request $request){
        if (!$request->ajax()) return redirect('/');
        $tamanos = Tamano::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['tamanos' => $tamanos];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Tamano = new Tamano();
        $Tamano->nombre = $request->nombre;
        $Tamano->descripcion = $request->descripcion;
        $Tamano->condicion = '1';
        $Tamano->save();
    }


    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Tamano = Tamano::findOrFail($request->id);
        $Tamano->nombre = $request->nombre;
        $Tamano->descripcion = $request->descripcion;
        $Tamano->condicion = '1';
        $Tamano->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Tamano = Tamano::findOrFail($request->id);
        $Tamano->condicion = '0';
        $Tamano->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Tamano = Tamano::findOrFail($request->id);
        $Tamano->condicion = '1';
        $Tamano->save();
    }
}
