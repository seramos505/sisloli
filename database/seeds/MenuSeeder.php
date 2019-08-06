<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus=[
            ["menu_id" => 0,"nombre" => "Catalogo","url" => "javascript:;","orden" => 1,"icono" => "fas fa-clipboard-list"],
            ["menu_id" => 0,"nombre" => "Ventas","url" => "javascript:;","orden" => 2,"icono" => "fas fa-cart-plus"],
            ["menu_id" => 1,"nombre" => "Productos","url" => "producto","orden" => 1,"icono" => "fab fa-product-hunt"],
            ["menu_id" => 1,"nombre" => "Categorías","url" => "categoria","orden" => 2,"icono" => "fas fa-clipboard-check"],
            ["menu_id" => 1,"nombre" => "Sabores","url" => "sabor","orden" => 3,"icono" => "fas fa-ice-cream"],
            ["menu_id" => 1,"nombre" => "Tamaños","url" => "tamano","orden" => 4,"icono" => "fas fa-ruler"],
            ["menu_id" => 2,"nombre" => "Ordenes","url" => "orden","orden" => 1,"icono" => "fas fa-cart-arrow-down"],
            ["menu_id" => 2,"nombre" => "Clientes","url" => "cliente","orden" => 2,"icono" => "fas fa-user-tie"]

        ];
        foreach($menus as $menu){
            DB::table('menu')->insert([
                'menu_id' => $menu["menu_id"],
                'nombre' => $menu["nombre"],
                'url' => $menu["url"],
                'orden' => $menu["orden"],
                'icono' => $menu["icono"], 
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
