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
        
        
        $ingresos = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id')   
        ->leftjoin('sabor','orden_detalle.combinado','=','sabor.id')         
        ->select('orden.id as orden','orden_detalle.id','orden_detalle.cantidad','orden_detalle.precio','orden_detalle.descuento','orden_detalle.relleno',
                'producto.nombre as producto','orden_detalle.combinado','sabor.nombre as sabor')
        ->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->orderBy('orden.id', 'desc')->paginate(15);   
        
        $TotalVenta = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->select(DB::raw('sum(orden_detalle.cantidad*orden_detalle.precio-orden_detalle.descuento) as total'))
        ->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
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
            'TotalVenta'=>$TotalVenta->total,
        ];
    }
}
