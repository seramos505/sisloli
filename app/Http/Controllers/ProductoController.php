<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Producto;

class ProductoController extends Controller
{
    public function listar(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('categoria','producto.idcategoria','=','categoria.id')
            ->join('tamano','producto.idtamano','=','tamano.id')
            ->join('sabor','producto.idsabor','=','sabor.id')
            ->select('producto.id','producto.idcategoria','producto.idtamano','producto.idsabor','producto.nombre',
            'categoria.nombre as nombre_categoria','tamano.nombre as nombre_tamano','sabor.nombre as nombre_sabor',
            'producto.precio_venta','producto.descripcion','producto.condicion')
            ->orderBy('producto.id', 'desc')->paginate(3);
        }
        else{
            $productos = Producto::join('categoria','producto.idcategoria','=','categoria.id')
            ->join('tamano','producto.idtamano','=','tamano.id')
            ->join('sabor','producto.idsabor','=','sabor.id')
            ->select('producto.id','producto.idcategoria','producto.idtamano','producto.idsabor','producto.nombre',
            'categoria.nombre as nombre_categoria','tamano.nombre as nombre_tamano','sabor.nombre as nombre_sabor',
            'producto.precio_venta','producto.descripcion','producto.condicion')
            ->where('producto.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('producto.id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = new Producto();
        $producto->idcategoria = $request->idcategoria;
        $producto->idtamano = $request->idtamano;
        $producto->idsabor = $request->idsabor;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->descripcion = $request->descripcion;
        $producto->condicion = '1';
        $producto->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->idcategoria = $request->idcategoria;
        $producto->idtamano = $request->idtamano;
        $producto->idsabor = $request->idsabor;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->descripcion = $request->descripcion;
        $producto->condicion = '1';
        $producto->save();
    }


    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = '0';
        $producto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = '1';
        $producto->save();
    }
}
