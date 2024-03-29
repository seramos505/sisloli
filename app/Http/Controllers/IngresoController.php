<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin\Orden;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\OrdenDetalle;

class IngresoController extends Controller
{
    public function fecha(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
 
        
        $FechaInicial=Carbon::parse($request->FechaInicial)->format('Y-m-d H:i:s');
        $FechaFinal = Carbon::parse($request->FechaFinal)->format('Y-m-d H:i:s');
        $idtamano= $request->idtamano;
        $idsabor= $request->idsabor;
        
        
        $ingresos = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id')   
        ->leftjoin('sabor','orden_detalle.combinado','=','sabor.id')         
        ->select('orden.id as orden','orden_detalle.id','orden_detalle.cantidad','orden_detalle.precio','orden_detalle.descuento','orden_detalle.relleno',
                'producto.nombre as producto','orden_detalle.combinado','sabor.nombre as sabor')
        ->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        //->where('producto.idtamano','=',$idtamano)
        ->when($request->idtamano, function($query) use ($request){
            return $query->where('producto.idtamano', $request->idtamano);
        })
        //->where('producto.idsabor','=',$idsabor)
        ->when($request->idsabor, function($query) use ($request){
            return $query->where('producto.idsabor', $request->idsabor);
        })        
        ->where('orden.estado','=','Registrado')
        ->where('orden_detalle.condicion','=','1')
        ->orderBy('orden.id', 'desc')->paginate(15);   
        
        $totales = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id') 
        ->select(DB::raw('sum(orden_detalle.cantidad) as TotalProd'),DB::raw('sum(orden_detalle.cantidad*orden_detalle.precio-orden_detalle.descuento) as TotalVenta'))
        ->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        //->where('producto.idtamano','=',$idtamano)
        ->when($request->idtamano, function($query) use ($request){
            return $query->where('producto.idtamano', $request->idtamano);
        })
        //->where('producto.idsabor','=',$idsabor)
        ->when($request->idsabor, function($query) use ($request){
            return $query->where('producto.idsabor', $request->idsabor);
        }) 
        ->where('orden_detalle.condicion','=','1')
        ->where('orden.estado','=','Registrado')
        //->get();
        // ->pluck('total');
        ->first();
         
        return [
            'pagination' => [
                'total'        => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'per_page'     => $ingresos->perPage(),
                'last_page'    => $ingresos->lastPage(),
                'from'         => $ingresos->firstItem(),
                'to'           => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos,
            'totales'=>$totales,
        ];
    }
}
