<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = [           
            ["nombre" => "LoliTropical 10 Onzas","idsabor" => 1,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Dulce de Leche 10 Onzas","idsabor" => 2,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Chocolate 10 Onzas","idsabor" => 3,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Nancite 10 Onzas","idsabor" => 4,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Tamarindo 10 Onzas","idsabor" => 5,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Frambuesa 10 Onzas","idsabor" => 6,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Piña 10 Onzas","idsabor" => 7,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Coco 10 Onzas","idsabor" => 8,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Fresa 10 Onzas","idsabor" => 9,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Mamon 10 Onzas","idsabor" => 10,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],
            ["nombre" => "Limon 10 Onzas","idsabor" => 11,"idcategoria" => 1,"idtamano" => 1,"precio_venta" => 45,"descripcion" => "Presentación Vaso Pequeño"],

        ];
        foreach($productos as $producto){
            DB::table('producto')->insert([
                'nombre' => $producto["nombre"],
                'idcategoria' => $producto["idcategoria"],
                'idsabor' => $producto["idsabor"],
                'idtamano' => $producto["idtamano"],
                'precio_venta' => $producto["precio_venta"],
                'descripcion' => $producto["descripcion"],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

    }
}
