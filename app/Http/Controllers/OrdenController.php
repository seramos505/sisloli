<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Admin\Orden;
use App\Models\Admin\OrdenDetalle;
use App\User;

class OrdenController extends Controller
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
            $ordenes = Orden::join('users','orden.idusuario','=','users.id')
            ->select('orden.id','orden.fecha_hora','orden.impuesto','orden.total',
            'orden.estado','users.name')
            ->orderBy('orden.id', 'desc')->paginate(5);
        }
        else{
            $ordenes = Orden::join('users','orden.idusuario','=','users.id')
            ->select('orden.id','orden.fecha_hora','orden.impuesto','orden.total',
            'orden.estado','users.name')
            ->where('orden.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('orden.id', 'desc')->paginate(5);
        }
         
        return [
            'pagination' => [
                'total'        => $ordenes->total(),
                'current_page' => $ordenes->currentPage(),
                'per_page'     => $ordenes->perPage(),
                'last_page'    => $ordenes->lastPage(),
                'from'         => $ordenes->firstItem(),
                'to'           => $ordenes->lastItem(),
            ],
            'ordenes' => $ordenes
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $orden = new Orden();
            $orden->idusuario = \Auth::user()->id;
            $orden->fecha_hora = Carbon::now()->format('Y-m-d H:i:s');
            $orden->impuesto = $request->impuesto;
            $orden->total = $request->total;
            $orden->estado = 'Registrado';
            $orden->save();
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($detalles as $ep=>$det)
            {
                $detalle = new OrdenDetalle();
                $detalle->idorden = $orden->id;
                $detalle->idproducto = $det['idproducto'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];         
                $detalle->save();
            }          
           
      
            DB::commit();
            return [
                'id'=> $orden->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $orden = Orden::findOrFail($request->id);
        $orden->estado = 'Anulado';
        $orden->save();
    }
}
