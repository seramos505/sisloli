<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin\Orden;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\OrdenDetalle;
use App\Models\Admin\Sabor;


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
        //cualquier select funciona
        //->selectRaw('sabor.nombre as sabor,sabor.color as color,sum(orden_detalle.cantidad) as total')    
        ->select('sabor.nombre as sabor','sabor.color as color',DB::raw('sum(orden_detalle.cantidad) as total'))
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->groupby('sabor.id')
        ->orderBy('total', 'desc')->get();          

        return $ingresos; 
        
    }

    public function ingreso_sabor_mes(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
 
        
        $FechaInicial=Carbon::parse($request->FechaInicial)->format('Y-m-d H:i:s');
        $FechaFinal = Carbon::parse($request->FechaFinal)->format('Y-m-d H:i:s');

        $meses = Orden::selectRaw('MONTH(orden.fecha_hora) as mes')
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->groupby('mes')
        ->orderBy('mes','asc')->get(); 

        $dataset=[];
        $i=0;
        foreach (Sabor::all() as $Sabor) {            
            $dataset[$i]=['sabor'=>$Sabor->nombre,'color'=>$Sabor->color,'data'=>[1,2,3,4]];
            $i++;
        }

        $sabormeses = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id')   
        ->select(DB::raw('sum(orden_detalle.cantidad) as total'),
                DB::raw('MONTH(orden.fecha_hora) as mes'))
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->where('producto.idsabor','=',3)
        ->groupby('mes')
        ->orderBy('mes','asc')->get();     
                
        
        $ingresos = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id')   
        ->rightjoin('sabor','producto.idsabor','=','sabor.id')      
        ->select('sabor.nombre as sabor','sabor.color as color',DB::raw('sum(orden_detalle.cantidad) as total'),
                DB::raw('MONTH(orden.fecha_hora) as mes'))
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->groupby('mes','sabor.id')
        ->orderBy('mes','asc','sabor.nombre', 'asc')->get();          

        return [
            'sabormeses'=>$sabormeses
            // 'data'=>$dataset,
            // 'meses'=> $meses,
            // 'ingresos' => $ingresos
        ]; 
        
    }
}
