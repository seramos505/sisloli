<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin\Orden;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\OrdenDetalle;

class GraficosController extends Controller
{
    public function ingreso_sabor(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
 
        
        $FechaInicial=Carbon::parse($request->FechaInicial)->format('Y-m-d H:i:s');
        $FechaFinal = Carbon::parse($request->FechaFinal)->format('Y-m-d H:i:s');
        
        
        $ingresos = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id')   
        ->rightjoin('sabor','producto.idsabor','=','sabor.id')      
        ->select('sabor.nombre as sabor','sabor.color as color',DB::raw('sum(orden_detalle.cantidad) as total'))
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->groupby('sabor.id')
        ->orderBy('sabor.nombre', 'asc')->get();          

        return $ingresos; 
        
    }
}
