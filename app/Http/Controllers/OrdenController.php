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
            ->join('cliente','orden.idcliente','=','cliente.id')
            ->join('orden_detalle','orden.id','=','orden_detalle.idorden')
            ->select('orden.id','orden.fecha_hora','orden.impuesto','orden.estado','users.name as user','cliente.nombre as cliente',
            DB::raw('sum(orden_detalle.cantidad*orden_detalle.precio-orden_detalle.descuento) as total'))
            ->groupBy('orden.id','orden.fecha_hora','orden.impuesto','orden.estado','users.name')
            ->orderBy('orden.id', 'desc')->paginate(5);
        }
        else{
            $ordenes = Orden::join('users','orden.idusuario','=','users.id')
            ->join('cliente','orden.idcliente','=','cliente.id')
            ->join('orden_detalle','orden.id','=','orden_detalle.idorden')
            ->select('orden.id','orden.fecha_hora','orden.impuesto','orden.estado','users.name as user','cliente.nombre as cliente',
            DB::raw('sum(orden_detalle.cantidad*orden_detalle.precio-orden_detalle.descuento) as total'))
            ->groupBy('orden.id','orden.fecha_hora','orden.impuesto','orden.estado','users.name')
            ->where($criterio, 'like', '%'. $buscar . '%')
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

    public function obtenerCabecera(Request $request){
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $orden = Orden::join('cliente','orden.idcliente','=','cliente.id')
        ->join('users','orden.idusuario','=','users.id')
        ->join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->select('orden.id','orden.fecha_hora','orden.impuesto','orden.estado','users.name','cliente.nombre as cliente',
        DB::raw('sum(orden_detalle.cantidad*orden_detalle.precio-orden_detalle.descuento) as total'))
        ->where('orden.id','=',$id)
        ->groupBy('orden.id','orden.fecha_hora','orden.impuesto','orden.estado','users.name')
        ->get();

         //$orden = DB::select('select orden.id, orden.fecha_hora, orden.impuesto,
         // SUM(orden_detalle.cantidad*orden_detalle.precio-orden_detalle.descuento) as total, orden.estado, users.name from orden inner join users on orden.idusuario = users.id inner join orden_detalle on orden.id = orden_detalle.idorden where orden.id = ? order by orden.id desc limit 1', [12]);
         
        return ['orden' => $orden];
    }
    public function obtenerDetalles(Request $request){
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $detalles = OrdenDetalle::join('producto','orden_detalle.idproducto','=','producto.id')
        ->select('orden_detalle.cantidad','orden_detalle.precio','orden_detalle.descuento','orden_detalle.relleno',
        'producto.nombre as producto')
        ->where('orden_detalle.idorden','=',$id)
        ->orderBy('orden_detalle.id', 'desc')->get();
         
        return ['detalles' => $detalles];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $orden = new Orden();   
            $orden->idcliente = $request->idcliente;
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
                $detalle->relleno = $det['relleno'];         
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
