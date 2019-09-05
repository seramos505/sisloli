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
        ->select('sabor.nombre as sabor',DB::raw('sum(orden_detalle.cantidad) as total'))
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->groupby('sabor.id')
        ->orderBy('sabor.nombre', 'asc')->get();          

        return $ingresos; 
        // return [
        //     // 'pagination' => [
        //     //     'total'        => $ingresos->total(),
        //     //     'current_page' => $ingresos->currentPage(),
        //     //     'per_page'     => $ingresos->perPage(),
        //     //     'last_page'    => $ingresos->lastPage(),
        //     //     'from'         => $ingresos->firstItem(),
        //     //     'to'           => $ingresos->lastItem(),
        //     // ],
        //     'ingresos' => $ingresos,    
        //     // 'donutData'        => [
        //     //     'labels'=> [
        //     //         'Chrome', 
        //     //         'IE',
        //     //         'FireFox', 
        //     //         'Safari', 
        //     //         'Opera', 
        //     //         'Navigator', 
        //     //     ],
        //     //     'datasets'=> [
        //     //       [
        //     //         'data'=> [700,500,400,600,300,100],
        //     //         'backgroundColor' => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        //     //       ]                ]
        //     // ]        
        // ];
    }
}
