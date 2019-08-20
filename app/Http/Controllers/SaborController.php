<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Sabor;

class SaborController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $sabores = Sabor::orderBy('id', 'desc')->paginate(1);
        }
        else{
            $sabores = Sabor::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(1);
        }
        

        return [
            'pagination' => [
                'total'        => $sabores->total(),
                'current_page' => $sabores->currentPage(),
                'per_page'     => $sabores->perPage(),
                'last_page'    => $sabores->lastPage(),
                'from'         => $sabores->firstItem(),
                'to'           => $sabores->lastItem(),
            ],
            'sabores' => $sabores
        ];
    }


    public function selectSabor(Request $request){
        if (!$request->ajax()) return redirect('/');
        $sabores = Sabor::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['sabores' => $sabores];
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
        $Sabor = new Sabor();
        $Sabor->nombre = $request->nombre;
        $Sabor->descripcion = $request->descripcion;
        $Sabor->condicion = '1';
        $Sabor->save();
    }


    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Sabor = Sabor::findOrFail($request->id);
        $Sabor->nombre = $request->nombre;
        $Sabor->descripcion = $request->descripcion;
        $Sabor->condicion = '1';
        $Sabor->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Sabor = Sabor::findOrFail($request->id);
        $Sabor->condicion = '0';
        $Sabor->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $Sabor = Sabor::findOrFail($request->id);
        $Sabor->condicion = '1';
        $Sabor->save();
    }


}
