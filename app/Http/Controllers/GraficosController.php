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
        ->where('orden_detalle.condicion','=','1')
        ->groupby('sabor.nombre')
        ->orderBy('total', 'desc')->get();          

        return $ingresos; 
        
    }

    public function ingreso_tamano(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
 
        
        $FechaInicial=Carbon::parse($request->FechaInicial)->format('Y-m-d H:i:s');
        $FechaFinal = Carbon::parse($request->FechaFinal)->format('Y-m-d H:i:s');
        
        
        $ingresos = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id')   
        ->rightjoin('tamano','producto.idtamano','=','tamano.id')  
        //cualquier select funciona
        //->selectRaw('sabor.nombre as sabor,sabor.color as color,sum(orden_detalle.cantidad) as total')    
        ->select('tamano.nombre as tamano',DB::raw('sum(orden_detalle.cantidad) as total'))
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->where('orden_detalle.condicion','=','1')
        ->groupby('tamano.id')
        ->orderBy('tamano', 'desc')->get();          

        return $ingresos; 
        
    }

    public function ingreso_sabor_mes(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        //select MONTH(TMeses.fecha_hora) as idMes,IFNULL(T1.total_mes, 0) as total_mes from `orden` as TMeses LEFT JOIN (select sum(orden_detalle.cantidad) as total_mes, MONTH(orden.fecha_hora) as Mes from `orden` inner join `orden_detalle` on `orden`.`id` = `orden_detalle`.`idorden` inner join `producto` on `orden_detalle`.`idproducto` = `producto`.`id` where `producto`.`idsabor` = 3 group by `mes`) T1 ON T1.Mes = MONTH(TMeses.fecha_hora) group by MONTH(TMeses.fecha_hora) order by `idMes` asc 
 
        
        $FechaInicial=Carbon::parse($request->FechaInicial)->format('Y-m-d H:i:s');
        $FechaFinal = Carbon::parse($request->FechaFinal)->format('Y-m-d H:i:s');

        $meses = Orden::selectRaw('MONTH(orden.fecha_hora) as mes')
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->groupby('mes')
        ->orderBy('mes','asc')->get(); 

        $dataset=[];
        $data=[];
        $i=0;
        foreach (Sabor::all() as $Sabor) {  
            $data=[$i,2,3,4,5];        
            
            $sabormeses = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
            ->join('producto','orden_detalle.idproducto','=','producto.id')   
            ->select(DB::raw('sum(orden_detalle.cantidad) as total'),
                    DB::raw('MONTH(orden.fecha_hora) as mes'))
            //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
            ->where('producto.idsabor','=',$Sabor->id)
            ->groupby('mes')
            ->orderBy('mes','asc')->pluck('total');

            $dataset[$i]=['sabor'=>$Sabor->nombre,'color'=>$Sabor->color,'data'=>$sabormeses];
            $i++;
        }

        // $sql_meses = Orden::selectRaw('MONTH(orden.fecha_hora) as mes')
        // ->groupby('mes')->toSql();

        // $count = DB::table(DB::raw("($sql_meses) AS a"))->get(); 

        $sql_sabores = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id')   
        ->select(DB::raw('sum(orden_detalle.cantidad) as total'),
                DB::raw('MONTH(orden.fecha_hora) as mes'),'producto.idsabor as sabor')
        ->where('producto.idsabor',5)
        ->groupby('mes','sabor')->toSql();
        

        // $meses = Orden::selectRaw('MONTH(orden.fecha_hora) as mes')
        // ->leftjoin(DB::raw("($sql_sabores) AS a"),'a.mes','=','MONTH(orden.fecha_hora)')
        // ->groupby('MONTH(orden.fecha_hora)')        
        // ->orderBy('mes','asc')->getBindings();  
        
        // $count = DB::table(DB::raw("($sql_sabores) AS a"))         
        //  ->get(); 

         
        
         $someVariable=1;
         $results = DB::select( DB::raw("select MONTH(TMeses.fecha_hora) as idMes,IFNULL(T1.total_mes, 0) as total_mes from `orden` as TMeses LEFT JOIN (select sum(orden_detalle.cantidad) as total_mes, MONTH(orden.fecha_hora) as Mes from `orden` inner join `orden_detalle` on `orden`.`id` = `orden_detalle`.`idorden` inner join `producto` on `orden_detalle`.`idproducto` = `producto`.`id` where `producto`.`idsabor` = 3 group by `mes`) T1 ON T1.Mes = MONTH(TMeses.fecha_hora) group by MONTH(TMeses.fecha_hora) order by `idMes` asc ") );
         dd($results);

        $sabormeses = Orden::join('orden_detalle','orden.id','=','orden_detalle.idorden')
        ->join('producto','orden_detalle.idproducto','=','producto.id')   
        ->select(DB::raw('sum(orden_detalle.cantidad) as total'),
                DB::raw('MONTH(orden.fecha_hora) as mes'))
        //->whereBetween('orden.fecha_hora', [$FechaInicial, $FechaFinal])
        ->where('producto.idsabor','=',5)
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
            //'sabormeses'=>$sabormeses,
            'labels'=> $results,
            //'dataset'=>$dataset,             
             //'ingresos' => $ingresos
        ]; 
        
    }
}
